<?php

namespace Wx\Action;


use Common\Common\Wxapi;
use Common\Common\Wxnotice;

class WxpayAction extends BaseAction {


    /* 支付接口
     * http://域名/Wx/Wxpay
     * $_GET['payamount']; //支付金额
     * $_GET['ordernum']; //订单号
     * $_GET['backurl']; //成功返回地址
     * $_GET['ordersign']; //支付验证
     */
    public function index() {
        //	由于微信5.0版本后才加入微信支付模块，低版本用户调用微信支付功能将无效。因此，建议商户通过user agent来确定用户当前的版本号后再调用支付接口。
        //	Mozilla/5.0(iphone;CPU iphone OS 5_1_1 like Mac OS X) AppleWebKit/534.46(KHTML,like Geocko) Mobile/9B206 MicroMessenger/5.0"
        //	其中5.0为用户安装的微信版本号，商户可以解析以上HTTP头，获取到微信版本号是否高于或者等于5.0。
        
        $payamount = $_GET['payamount']; //支付金额
        $trannum = $_GET['trannum']; //交易号
        $backurl = $_GET['backurl']; //返回地址
        $ordersign = $_GET['ordersign']; //支付验证
        $successurl = $_GET['successurl']; //支付成功前往地址
        $closemsg = $_GET['closemsg']; //是关闭提示，再跳转到successurl
        
        if(!$this->wxopenid){
            showmsg("请在微信中打开！", $backurl);
            exit;
        }
        if(empty($successurl)){
            if(substr($trannum, 0, 5) == 'chong'){
                $successurl = '/Wx/Users/purse';
            }else{
                $successurl = '/Wx/Index/index';//U('/Order/odetail?trade_no='.$trannum);
            }
        }
        $trannumInfo = M('orders')->where("orderunique='$trannum'")->find();
        if($trannumInfo['orderStatus']==0&&substr($trannum, 0, 5) != 'chong'){
            showmsg("该订单已经支付成功，请勿重复支付！", $successurl);
        }
        $USER = session('WST_USER');
        if (md5($trannum . "xihuansha.2016.#") != $ordersign) {
            logger("[" . date('H:i:s') . "] 非法调用 $trannum\n" . json_encode($_GET), 'Wxpay');
           showmsg("参数传递有误！", $backurl);exit;
        }
        $prepay_id = "";
        $wxapi = new Wxapi();
        //Wx jsapi config
        $signPackage = $wxapi->getSignPackage();
        //Wx jsapi pay
        $unifiedorder = $wxapi->unifiedorder($this->wxopenid, $trannum.'-'.rand(10, 99), $payamount, $USER['userId']); //预订单
        if ($unifiedorder->return_code == 'SUCCESS' && $unifiedorder->result_code == 'SUCCESS') {
            logger("[" . date('H:i:s') . "] 生成预订单 $trannum\n" . json_encode($unifiedorder), 'Wxpay');
            $prepay_id = $unifiedorder->prepay_id;
        } else {
            logger("[" . date('H:i:s') . "] 预订单失败 $trannum\n" . json_encode($unifiedorder), 'Wxpay');
          //   var_dump($unifiedorder);
            showmsg($unifiedorder->err_code_des, $backurl);
            exit;
        }
        $jsApiParameters = $wxapi->getParameters($prepay_id);

        logger("[" . date('H:i:s') . "] POST $trannum\n" . json_encode($jsApiParameters), 'Wxpay');
        
        $this->assign('closemsg', $closemsg);
        $this->assign('signPackage', $signPackage);
        $this->assign('jsApiParameters', $jsApiParameters);
        $this->assign("backurl", $backurl);
        $this->assign("successurl", $successurl);
        //print_r($successurl);
        $this->display('/wxpay/index');
    }
    
    /* 测试支付0.01元
     */
    public function test() {
        $prepay_id = "";
        $wxapi = new Wxapi();
        //Wx jsapi config
        $signPackage = $wxapi->getSignPackage();
        //Wx jsapi pay
        $USER = session('WST_USER');
        $unifiedorder = $wxapi->unifiedorder($this->wxopenid, time(), 1, $USER['userId']); //预订单
        if ($unifiedorder->return_code == 'SUCCESS' && $unifiedorder->result_code == 'SUCCESS') {
            $prepay_id = $unifiedorder->prepay_id;
        } else {
            var_dump($unifiedorder);
            exit("...");
        }
        $jsApiParameters = $wxapi->getParameters($prepay_id);
        logger("[" . date('H:i:s') . "] POST\n" . json_encode($jsApiParameters) . "\n", 'Wxpaybbbbbs');
        $this->assign('signPackage', $signPackage);
        $this->assign('jsApiParameters', $jsApiParameters);

        $this->display('/wxpay/test');
    }
    
    //通用通知回调
    public function notify() {
        /* {"appid":"wxe90771453bd536cf","attach":"1423707306","bank_type":"CFT",
          "cash_fee":"1","fee_type":"CNY","is_subscribe":"Y","mch_id":"1228098902",
          "nonce_str":"4xo57bkf7sr8zodnpx8xrxy8ka5oj7i6","openid":"o1RK1txLugjA2fThGZUfT9Hq0Z_U",
          "out_trade_no":"1423707306","result_code":"SUCCESS","return_code":"SUCCESS",
          "sign":"2EAAA785B33DC5485C8F9C4AECCA6794","time_end":"20150212101515",
          "total_fee":"1","trade_type":"JSAPI","transaction_id":"1007680733201502120016410844"} */
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $wxapi = new Wxapi();
        $message = json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA));
        logger("\n[" . date('H:i:s') . "] Notify\n" . $message, 'Wxpay');
        $data = json_decode($message, 1);

        $dateline = time();
        //验证签名，并回应微信。
        $wxapi = new Wxapi();
        if ($wxapi->checkSign($data) == FALSE) {
            $result["return_code"] = "FAIL"; //返回状态码
            $result["return_msg"] = "签名失败"; //返回信息
            logger("[" . date('H:i:s') . "] Response 签名失败", 'Wxpay');
            echo $wxapi->arrayToXml($result);
            exit;
        }else{
            $result["return_code"] = "SUCCESS"; //设置返回码
            echo $wxapi->arrayToXml($result);
        }
        
        $accid = $data['attach']; //帐户id
        $aryorder = split('-', $data['out_trade_no']); //订单唯一流水号
        $trannum = $aryorder[0]; //订单号
        $transaction_id = $data['transaction_id']; //微信支付单号
        $total_fee = $data['total_fee'] / 100; //支付总金额

        if ($data["return_code"] == "FAIL") { //通信出错
            logger("[" . date('H:i:s') . "] trannum:{$trannum} 通信出错", 'Wxpay');
            exit;
        }
        if ($data["result_code"] == "FAIL") {//业务出错
            logger("[" . date('H:i:s') . "] trannum:{$trannum} 业务出错", 'Wxpay');
            exit;
        }

        /*支付成功
         * return_code == SUCCESS && result_code == SUCCESS
         */
        //第1步，检查用户是否存在
        $account = M('users')->where(array('userId' => $accid))->find();
        if(!is_array($account)){
            logger("[" . date('H:i:s') . "] userId:{$accid} 不存在", 'Wxpay');
            exit;
        }
        //第2步，检查是否重复通知
        $history = M('users_amount')->where(array('transaction_id' => $transaction_id))->find();
        if(is_array($history)){
            logger("[" . date('H:i:s') . "] 微信订单号:{$transaction_id} 多次通知", 'Wxpay');
            exit;
        }
        //第3步，添加金额明细
        $balance = $account['userBalance'] + $total_fee; //操作后余额
        $data = array('userId' => $accid,
            'type' => '微信充值',
            'amount' => $total_fee,
            'balance' => $balance,
            'transaction_id' => $transaction_id,
            'orderunique' => $trannum,
            'createTime' => date('Y-m-d H:i:s'));
        M('users_amount')->add($data);
        //第4步，更新帐户余额
        M('users')->where(array('userId' => $accid))->setInc('userBalance', $total_fee);
        //第5步，非充值执行订单支付
        $senty = D("Wx/Orders");
        if(substr($trannum, 0, 5) == 'chong'){ //充值
            /**微信充值活动**/
            if(substr($trannum, 0, 6) == 'chongs'){
                $tea_amount = 0;
                if($total_fee == 800){
                    $tea_amount = 200;
                    M('account')->where(array('id' => $accid))->setInc('recharge_amount', $tea_amount);
                }else if($total_fee == 1500){
                    $tea_amount = 500;
                    M('account')->where(array('id' => $accid))->setInc('recharge_amount', $tea_amount);
                }
                if($tea_amount>0){
                    $recharge_amounts = $account['recharge_amounts'] + $tea_amount;
                    $recharge = array('aid' => $accid,
                        'type' => '微信充值赠送',
                        'amount' => $tea_amount,
                        'recharge_amounts' => $recharge_amounts,
                        'transaction_id' => $transaction_id,
                        'trannum' => $trannum,
                        'orderradom' => $trannum,
                        'dateline' => $dateline);
                    M('account_tea_amounts')->add($recharge);
                }
                $map['aid'] = $accid;
                $map['recharge_amount'] = $total_fee;
                $map['dateline'] = time();
                $map['trannum'] = $trannum;
                $map['tea_amount'] = $tea_amount;
                M("act_recharge")->add($map);
                M('Account')->where("id='$accid' and origin <> '喜欢啥' and origin <> '盒卡会员'")->save(array('origin' => '充值客户'));
            }
            //$Wxnotice = new Wxnotice();
            //$Wxnotice->rechargeSuccess($accid, $total_fee, $balance);

        }else{
            //充值进去重新查询出来计算
            $account = M('users')->where(array('userId' => $accid))->find();
            //支付第1步，检查余额是否足够
            $sql = "SELECT o.orderId,o.userId,o.useScore,o.payType, o.orderNo,o.shopId,o.needPay ,og.goodsNums ,og.goodsId,og.goodsAttrId
				FROM __PREFIX__order_goods og, __PREFIX__orders o
				WHERE o.orderId = og.orderId AND o.orderunique ='$trannum'";
            $tranInfo =  $senty->query($sql);
            $payamout = 0;
            foreach($tranInfo as $key=>$val){
                $payamout += $val['needPay'];
            }

            if($account['userBalance'] < $payamout){
                showmsg('余额不足以支付定单');
                exit; //余额不足以支付定单
            }
            if($payamout > 0){
                //支付第2步，扣除总余额
                M('users')->where(array('userId' => $accid))->setDec('userBalance', $payamout);
                //支付第3步，添加金额明细
                $balance = $account['userBalance'] - $payamout; //操作后余额
                $data = array('userId' => $accid,
                    'type' => '消费',
                    'amount' => 0 - $payamout,
                    'balance' => $balance,
                    'orderunique' => $trannum,
                    'createTime' => date('Y-m-d H:i:s'));
                M('users_amount')->add($data);
                //支付第4步，添加订单支付明细
                $senty->addTranPayments($accid, $trannum, '微信付款', $payamout, date("Y-m-d H:i:s")); //订单支付明细

            }
            //支付第5步，更新订单及分成状态
            M('orders')->where(array('orderunique' => $trannum))->save(array('orderStatus' => 0, 'payTime' => date("Y-m-d H:i:s")));
            M("order_level")->where(array('orderunique' => $trannum))->save(array('orderStatus' => 0)); //更新分成订单状态

            
            //支付第7步，已售数量更新
            foreach ($tranInfo as $key=> $val) {
                //建立订单记录
                $data = array();
                $data["orderId"] = $val['orderId'];
                $data["logContent"] ="下单成功";
                $data["logUserId"] = $accid;
                $data["logType"] = 0;
                $data["logTime"] = date('Y-m-d H:i:s');
                $mlogo = M('log_orders');
                $mlogo->add($data);

                //建立订单提醒
                $sql = "SELECT userId,shopId,shopName FROM __PREFIX__shops WHERE shopId=".$val['shopId'] ." AND shopFlag=1  ";
                $users = $senty->query($sql);
                $morm = M('order_reminds');
                for ($i = 0; $i < count($users); $i++) {
                    $data = array();
                    $data["orderId"] = $val['orderId'];
                    $data["shopId"] = $val['shopId'];
                    $data["userId"] = $users[$i]["userId"];
                    $data["userType"] = 0;
                    $data["remindType"] = 0;
                    $data["createTime"] = date("Y-m-d H:i:s");
                    $morm->add($data);
                }

                //修改库存
                $sql = "update __PREFIX__goods set goodsStock=goodsStock-" . $val['goodsNums'] . " where goodsId=" . $val["goodsId"];
                $senty->execute($sql);
                if ((int)$val["goodsAttrId"] > 0) {
                    $sql = "update __PREFIX__goods_attributes set attrStock=attrStock-" . $val['goodsNums'] . " where id=" . $val["goodsAttrId"];
                    $senty->execute($sql);
                }
            }
            //微信通知
            $wxnotice = new Wxnotice();
            $result = $wxnotice->orderSuccess($trannum);

            if($result->errmsg){
                logger("[" . date('H:i:s') . "] 微信通知出错: "+$result->errmsg+"\n", 'Wxpay');
            }
        }
        //M("AccountLoginkey")->where("aid='%d' AND qrkey='%s'",array($accid, $trannum))->save(array("status"=>1));
        logger("[" . date('H:i:s') . "] trannum:{$trannum} 支付成功\n", 'Wxpay');
    }

    //Native原生支付，支付回调URL
    public function nativecallback() {
        logger("\n[" . date('H:i:s') . "] nativecallback\n" . $GLOBALS['HTTP_RAW_POST_DATA'], 'Wxpay');
    }

    //告警通知URL，微信监测到商户服务出现问题时，会及时推送相关告警信息到商户后台。
    public function warning() {
        logger("\n[" . date('H:i:s') . "] warning\n" . $GLOBALS['HTTP_RAW_POST_DATA'], 'Wxpay');
    }

}
