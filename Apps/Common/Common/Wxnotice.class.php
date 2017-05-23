<?php
namespace Common\Common;
use Think\Controller;
class Wxnotice extends Controller{

    private $timestamp;

    public function __construct() {

        $this->timestamp = time();
    }


    
    /* 发送模板消息（私有）
     * @param array $data   发送内容
     * @return json {"errcode":0, "errmsg":"ok", "msgid":200228332 }
     * 0 - 成功；errmsg - 错误信息
     */
    private function sendTplMsg($data) {
        $Wxapi = new Wxapi();

        $access_token = $Wxapi->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $access_token;
        logger("\n[" . date('H:i:s') . "] Notice\n" . $data, 'Wxtpl');
        $rejson = http_post($url, $data);
        logger("\n[" . date('H:i:s') . "] Return\n" . $rejson, 'Wxtpl');
        return json_decode($rejson, true);
    }
    
    /* 充值成功提醒
     * @param int $aid   用户id
     * @param float $amount  充值金额
     * @param float $balance 帐户余额
     * @return json {"errcode":0, "errmsg":"ok"}
     * 0 - 成功；errmsg - 错误信息
     */
    public function rechargeSuccess($aid, $amount, $balance){
        $account = M('account')->field("openid")->where(array("id" => $aid))->find();
        if(is_array($account)){
            $openid = $account['openid']; //openid
            if($openid == '') return json_decode(array("errcode" => 1, "errmsg" => "用户未绑定微信！"));
        }
        $date = '{
           "touser":"' . $openid . '",
           "template_id":"KHoDmv7msSvW14UBLNqR7gUPLd40z9McV92nxhCc9mg",
           "url":"http://b-box.cc/?g=Wx&c=user&a=index",
           "topcolor":"#ea572b",
           "data":{
                "first": { "value":"您已成功充值", "color":"#000000" },
                "money":{ "value":"' . $amount . '元", "color":"#000000" },
                "product": { "value":"微信充值", "color":"#000000" },
                "remark":{ "value":"帐户余额:' . $balance . '元", "color":"#000000" }
            }
	}';
        return $this->sendTplMsg($date);
    }
    
    /* 绑定成功通知
     * @param int $aid   用户id
     * @param string $username  绑定用户名（手机号）
     * @param int $type 类型：0-帐户绑定；1-验证手机；
     * @return json {"errcode":0, "errmsg":"ok"}
     * 0 - 成功；errmsg - 错误信息
     */
    public function bindUser($aid, $username, $type = 0){
        if($type == 1){
            $title = '小主，您的手机号码已验证。';
        }else{
            $title = '小主，您的帐户绑定成功。';
        }
        $account = M('account')->field("openid")->where(array("id" => $aid))->find();
        if(is_array($account)){
            $openid = $account['openid']; //openid
            if($openid == '') return json_decode(array("errcode" => 1, "errmsg" => "用户未绑定微信！"));
        }
        $date = '{
           "touser":"' . $openid . '",
           "template_id":"O6GlEYCfCFu2xVIITBX23k3RZVYRXWtXOuSIqNnkGgY",
           "url":"http://b-box.cc/index.php?m=&c=user&a=useredit",
           "topcolor":"#ea572b",
           "data":{
                "first": { "value":"' . $title . '", "color":"#999999" },
                "keyword1":{ "value":"' . $username . '", "color":"#ea572b" },
                "keyword2": { "value":"个人用户", "color":"#ea572b" },
                "keyword3": { "value":"' . date('Y-m-d H:i:s') . '", "color":"#ea572b" },
                "remark":{ "value":"如有问题请致电400-8868-163或直接在微信留言，我们将第一时间为您服务！", "color":"#000000" }
            }
	}';
        return $this->sendTplMsg($date);
    }
    
    /* 订单提交成功通知
     * @param string $ordernum  订单号
     * @return json {"errcode":0, "errmsg":"ok"}
     * 0 - 成功；errmsg - 错误信息
     */
    public function orderSuccess($ordernum){
        $order = M('order')->field("aid, amount, dateline")->where(array("ordernum" => $ordernum))->find();
        if(!is_array($order)){
            return json_decode(array("errcode" => 1, "errmsg" => "订单不存在！"));
        }
        $meals = M('order_meals')->field("mealname, price, quantity")->where(array("ordernum" => $ordernum))->select();
        $packets = M('order_packets')->field("road, building, address")->where(array("ordernum" => $ordernum))->find();
        $account = M('account')->field("openid")->where(array("id" => $order['aid']))->find();
        if(is_array($account)){
            $openid = $account['openid']; //openid
            if($openid == '')
                return json_decode(array("errcode" => 2, "errmsg" => "用户未绑定微信！"));
        }else{
            return json_decode(array("errcode" => 3, "errmsg" => "用户不存在！"));
        }
        $linkurl = 'http://b-box.cc/index.php?m=home&c=order&a=success&oid='.$ordernum; //点击链接
        $ordertime = date('Y-m-d H:i:s', $order['dateline']); //下单时间
        $amount = $order['amount']; //订单总金额
        foreach ($meals as $row){
            $detial.= "$row[mealname] ￥$row[price] * $row[quantity]；";
        }
        $address = $packets['road'].$packets['building'].'号'.$packets['address']; //详细地址
        
        $date = '{
           "touser":"' . $openid . '",
           "template_id":"P8NLP6BZdHgRkctdx1UJ6Zqce7Iw4xacn8Pz9hnEZw4",
           "url":"' . $linkurl . '",
           "topcolor":"#ea572b",
           "data":{
                "first": { "value":"订单提交成功", "color":"#999999" },
                "keyword1":{ "value":"' . $ordertime . '", "color":"#ea572b" },
                "keyword2": { "value":"' . $amount . '元", "color":"#ea572b" },
                "keyword3": { "value":"' . $detial . '", "color":"#ea572b" },
                "keyword4": { "value":"' . $address . '", "color":"#999999" },
                "remark":{ "value":"如有问题请致电400-8868-163或直接在微信留言，我们将第一时间为您服务！", "color":"#000000" }
            }
	}';
        return $this->sendTplMsg($date);
    }
    
     /* 漂流瓶回复成功通知
     * @param string $ordernum  订单号
     * @return json {"errcode":0, "errmsg":"ok"}
     * 0 - 成功；errmsg - 错误信息
     */
    public function bottleSuccess($log_id){
        $bottle_log = M('act_qixi_log')->where(array("id" => $log_id))->find();
        
        if(!is_array($bottle_log)){
            return json_decode(array("errcode" => 1, "errmsg" => "回复信息已删除。"));
        }
        $account = M('account')->field("openid")->where(array("id" => $bottle_log['aid']))->find();
       
        if(is_array($account)){
            $openid = $account['openid']; //openid
            if($openid == '')
                return json_decode(array("errcode" => 2, "errmsg" => "用户未绑定微信！"));
        }else{
            return json_decode(array("errcode" => 3, "errmsg" => "用户不存在！"));
        }
        $linkurl = 'http://b-box.cc/index.php?m=home&c=actqixi&a=chat&&id='.$bottle_log['fromid']; //点击链接
        $from = M('account')->field("nickname")->where(array("id" => $bottle_log['fromid']))->find();
        $date = '{
           "touser":"' . $openid . '",
           "template_id":"5OEBaM-olWxiy0qkzqGvLBLwa1pHvN2dwdaIH_qji5A",
           "url":"' . $linkurl . '",
           "topcolor":"#ea572b",
           "data":{
                "first": { "value":"您好，有新的漂流瓶消息。", "color":"#f39700" },
                "keynote1":{ "value":"' . $from['nickname'] . '", "color":"#ea572b" },
                "keynote2": { "value":"' . date('Y-m-d H:i:s') . '", "color":"#ea572b" },
                "remark":{ "value":"'.$bottle_log[message].'", "color":"#f39700" }
            }
	}';
        return $this->sendTplMsg($date);
    }
    
    /*
     * 为TA订制
     * @param string $ordernum  订单号
     * @param string $linkurl   链接地址
     */
    public function orderForone($ordernum, $linkurl){
        $order = M('order')->field('bx_account.nickname AS nickname, amount')->join("LEFT JOIN bx_account ON bx_order.aid = bx_account.id")->where(array('ordernum' => $ordernum))->find();
        $forone = M('order_forone')->field("bx_account.openid AS openid, bx_account.nickname AS nickname")->join("LEFT JOIN bx_account ON bx_order_forone.fid = bx_account.id")->where(array('ordernum' => $ordernum))->find();
        if(!$forone['openid'] || !$forone['subscribe'])
            return json_decode(array("errcode" => 1, "errmsg" => "用户未注册或是未关注！"));
        $date = '{
           "touser":"' . $forone['openid'] . '",
           "template_id":"EfQYRWIJa6f5pEmyywjrXxRzyCmcs3Ro_EkFg5XbVVw",
           "url":"' . $linkurl . '",
           "topcolor":"#ea572b",
           "data":{
                "first": { "value":"您好，您的好友'.$order['nickname'].'已为你定制一份便当。便当正在派送中，请耐心等待！", "color":"#999999" },
                "keyword1":{ "value":"' . $ordernum . '", "color":"#ea572b" },
                "keyword2": { "value":"' . $forone['nickname'] . '", "color":"#ea572b" },
                "keyword3": { "value":"' . $order['amount']. '", "color":"#ea572b" },
                "keyword4": { "value":"B-BOX包养订单", "color":"#999999" },
                "keyword5": { "value":"（当天）", "color":"#999999" },
                "remark":{ "value":"查看详情", "color":"#000000" }
            }
	}';
        return $this->sendTplMsg($date);
    }
    
    /*
     * 邀请饭团成员点餐
     * @param int $gid  饭团id
     * @param string $openid    接收人openid
     * @param string $linkurl   链接地址
     */
    public function grouponInvitation($gid, $openid, $linkurl){
        $groupon = M('act_groupon')->field("daily, aid")->where("id ='$gid'")->find();
        $nickname = M("account")->where("id = '$groupon[aid]'")->getField("nickname");
//       / print_r($linkurl);exit;
        $date = '{
           "touser":"' . $openid . '",
           "template_id":"wlw9s7Ew6T_XqH-7FAfPeeMjJer0E6Yl30LgksYV-rs",
           "url":"' . $linkurl . '",
           "topcolor":"#ea572b",
           "data":{
                "first": { "value":"' . $nickname . '约你一起组饭团啦~", "color":"#999999" },
                "keyword1":{ "value":"' . $nickname . '", "color":"#ea572b" },
                "keyword2": { "value":"饭团", "color":"#ea572b" },
                "keyword3": { "value":"' . $groupon[daily] . '", "color":"#ea572b" },
                "keyword4": { "value":"B私房便当", "color":"#999999" },
                "keyword5": { "value":"软件园二期", "color":"#999999" },
                "remark":{ "value":"查看详情", "color":"#000000" }
            }
	}';
        return $this->sendTplMsg($date);
    }
    
    /* 
     * 模板发送
     * @param string $touser  openid
     * @param string $template_id  模板id
     * @param string $url  链接地址
     * @param array $data  内容
     * @return json {"errcode":0, "errmsg":"ok"}
     * 0 - 成功；errmsg - 错误信息
     */
    public function tplsend($touser, $template_id, $url, $data){
        $param['touser'] = $touser;
        $param['template_id'] = $template_id;
        $param['url'] = $url;
        $param['data'] = $data;
        //$poststr = "'". json_encode($param) . "'";
        //echo $poststr;
        //exit;
        return $this->sendTplMsg(json_encode($param));
    }
}
