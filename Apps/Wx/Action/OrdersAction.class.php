<?php
namespace Wx\Action;
/**
 * ============================================================================
 * qpSHOP商城
 * 官网地址:http://www.qianpok.com
 * 联系QQ:874570326
 * ============================================================================
 * 订单控制器
 */
class OrdersAction extends BaseAction {


	/**
	 * 获取待付款的订单列表
	 */
	public function queryByPage(){
		$this->isUserLogin();
		$USER = session('WST_USER');
		session('WST_USER.loginTarget','User');
		//判断会员等级
		$rm = D('Wx/UserRanks');
		$USER["userRank"] = $rm->getUserRank();
		session('WST_USER',$USER);
		//获取订单列表
		$morders = D('Wx/Orders');
		$obj["userId"] = (int)$USER['userId'];
		$orderList = $morders->queryByPage($obj);
		$statusList = $morders->getUserOrderStatusCount($obj);
		$um = D('Wx/Users');
		$user = $um->getUserById(array("userId"=>session('WST_USER.userId')));
		$this->assign("userScore",$user['userScore']);
		$this->assign("umark","queryByPage");

		foreach($orderList['root'] as $key=>$val){
			$newArray[$val['orderunique']][] = $val;
		}
		$orderList['root'] = $newArray;


		$this->assign("orderList",$orderList);
		$this->assign("statusList",$statusList);
		$this->display("users/orders/list");
	}
	/**
	 * 获取用户待付款的订单列表
	 */
	public function queryPayByPage(){
		$this->isUserLogin();
		$USER = session('WST_USER');
		$morders = D('Wx/Orders');
		self::WSTAssigns();
		$obj["userId"] = (int)$USER['userId'];
		$payOrders = $morders->queryPayByPage($obj);
		$this->assign("umark","queryPayByPage");
		foreach($payOrders['root'] as $key=>$val){
			$newArray[$val['orderunique']][] = $val;
		}
		$payOrders['root'] = $newArray;

		$this->assign("payOrders",$payOrders);
		$this->display("users/orders/list_pay");
	}
    /**
	 * 获取待发货的订单列表
	 */
	public function queryDeliveryByPage(){
		$this->isUserLogin();
		$USER = session('WST_USER');
		$morders = D('Wx/Orders');
		self::WSTAssigns();
		$obj["userId"] = (int)$USER['userId'];
		$deliveryOrders = $morders->queryDeliveryByPage($obj);
		$this->assign("umark","queryDeliveryByPage");

		$this->assign("receiveOrders",$deliveryOrders);
		$this->display("users/orders/list_delivery");
	}
    /**
	 * 获取退款订单列表
	 */
	public function queryRefundByPage(){
		$this->isUserLogin();
		$USER = session('WST_USER');
		$morders = D('Wx/Orders');
		self::WSTAssigns();
		$obj["userId"] = (int)$USER['userId'];
		$refundOrders = $morders->queryRefundByPage($obj);
		$this->assign("umark","queryRefundByPage");
		$this->assign("receiveOrders",$refundOrders);
		$this->display("users/orders/list_refund");
	}
    /**
	 * 获取收货的订单列表
	 */
	public function queryReceiveByPage(){
		$this->isUserLogin();
		$USER = session('WST_USER');
		$morders = D('Wx/Orders');
		self::WSTAssigns();
		$obj["userId"] = (int)$USER['userId'];
		$receiveOrders = $morders->queryReceiveByPage($obj);
		$this->assign("umark","queryReceiveByPage");
		$this->assign("receiveOrders",$receiveOrders);
		$this->display("users/orders/list_receive");
	}
	
	/**
	 * 获取已取消订单
	 */
	public function queryCancelOrders(){
		$this->isUserLogin();
		$USER = session('WST_USER');
		$morders = D('Wx/Orders');
		self::WSTAssigns();
		$obj["userId"] = (int)$USER['userId'];
		$receiveOrders = $morders->queryCancelOrders($obj);
		$this->assign("umark","queryCancelOrders");
		$this->assign("receiveOrders",$receiveOrders);
		$this->display("users/orders/list_cancel");
	}
    
	/**
	 * 获取待评价订单
	 */
    public function queryAppraiseByPage(){
    	$this->isUserLogin();
    	$USER = session('WST_USER');
    	$morders = D('Wx/Orders');
    	self::WSTAssigns();
    	$obj["userId"] = (int)$USER['userId'];
		$appraiseOrders = $morders->queryAppraiseByPage($obj);
		$this->assign("umark","queryAppraiseByPage");
		$this->assign("appraiseOrders",$appraiseOrders);
		$this->display("users/orders/list_appraise");
	} 
	
	
	/**
	 * 订单詳情-买家专用
	 */
	public function getOrderInfo(){
		$this->isUserLogin();
		$USER = session('WST_USER');
		$morders = D('Wx/Orders');
		$obj["userId"] = (int)$USER['userId'];
		$obj["orderId"] = (int)I("orderId");
		$rs = $morders->getOrderDetails($obj);
		$data["orderInfo"] = $rs;
		$this->assign("orderInfo",$rs);
		$this->display("default/order_details");
	}
	
	/**
	 * 取消订单
	 */
    public function orderCancel(){
    	$this->isUserLogin();
    	$USER = session('WST_USER');
    	$morders = D('Wx/Orders');
    	$obj["userId"] = (int)$USER['userId'];
    	$obj["orderId"] = (int)I("orderId");
		$rs = $morders->orderCancel($obj);
		$this->ajaxReturn($rs);
	}
	/**
	 * 取消待付款订单
	 */
	public function orderCancelunique(){
		$this->isUserLogin();
		$USER = session('WST_USER');
		$morders = D('Wx/Orders');
		$obj["userId"] = (int)$USER['userId'];
		$obj["orderunique"] = (int)I("orderId");
		$rs = $morders->orderCancelunique($obj);
		$this->ajaxReturn($rs);
	}

	/**
	 * 用户确认收货订单
	 */
    public function orderConfirm(){
    	$this->isUserLogin();
    	$USER = session('WST_USER');
    	$morders = D('Wx/Orders');
    	$obj["userId"] = (int)$USER['userId'];
    	$obj["orderId"] = (int)I("orderId");
    	$obj["type"] = (int)I("type");
		$rs = $morders->orderConfirm($obj);
		$this->ajaxReturn($rs);
	}

	/**
	 * 核对订单信息
	 */
	public function checkOrderInfo(){
		$this->isUserLogin();
		$mgoods = D('Wx/Goods');
		$maddress = D('Wx/UserAddress');
		$gtotalMoney = 0;//商品总价（去除配送费）
		$totalMoney = 0;//商品总价（含配送费）
		$totalCnt = 0;
		$shopcat = getcart();//session("WST_CART")?session("WST_CART"):array();
		//print_r($shopcat);
		$catgoods = array();
	
		$shopColleges = array();
		$startTime = 0;
		$endTime = 24;
	    if(empty($shopcat)){
			$this->assign("fail_msg",'不能提交空商品的订单!');
			$this->display('/error');
			exit();
		}
		$paygoods = array();
		foreach($shopcat as $key=>$cgoods){
			$obj = array();
			$temp = explode('_',$key);		
			$obj["goodsId"] = (int)$temp[0];
			$obj["goodsAttrId"] = (int)$temp[1];	
			if($cgoods["ischk"]==1){
				$paygoods[] = $obj["goodsId"];
				$goods = $mgoods->getGoodsForCheck($obj);
				if($goods["isBook"]==1){
					$goods["goodsStock"] = $goods["goodsStock"]+$goods["bookQuantity"];
				}
				$goods['goodsatts'] = $key;
				$goods["ischk"] = $cgoods["ischk"];
				$goods["cnt"] = $cgoods["cnt"];
				$totalCnt += $cgoods["cnt"];
				$totalMoney += $goods["cnt"]*$goods["shopPrice"];
				$gtotalMoney += $goods["cnt"]*$goods["shopPrice"];
				$ommunitysId = $maddress->getShopCommunitysId($goods["shopId"]);
				$shopColleges[$goods["shopId"]] = $ommunitysId;			
				if($startTime<$goods["startTime"]){
					$startTime = $goods["startTime"];
				}
				if($endTime>$goods["endTime"]){
					$endTime = $goods["endTime"];
				}
				$catgoods[$goods["shopId"]]["shopgoods"][] = $goods;
				$catgoods[$goods["shopId"]]["deliveryFreeMoney"] = $goods["deliveryFreeMoney"];//店铺免运费最低金额
				$catgoods[$goods["shopId"]]["deliveryMoney"] = $goods["deliveryMoney"];//店铺配送费
				$catgoods[$goods["shopId"]]["deliveryStartMoney"] = $goods["deliveryStartMoney"];//店铺配送费
				$catgoods[$goods["shopId"]]["totalCnt"] = $catgoods[$goods["shopId"]]["totalCnt"]+$cgoods["cnt"];
				$catgoods[$goods["shopId"]]["totalMoney"] = $catgoods[$goods["shopId"]]["totalMoney"]+($goods["cnt"]*$goods["shopPrice"]);
			}
		}

		
		foreach($catgoods as $key=> $cshop){
			if($cshop["totalMoney"]<$cshop["deliveryFreeMoney"]){
				$totalMoney = $totalMoney + $cshop["deliveryMoney"];
			}
		}
		//print_r($paygoods);
		session('WST_PAY_GOODS',$paygoods);
		$USER = session('WST_USER');
		//获取地址列表
        $areaId2 = $this->getDefaultCity();
		$addressList = $maddress->queryByUserAndCity($USER['userId'],$areaId2);
		$this->assign("addressList",$addressList);
		//支付方式
		$pm = D('Wx/Payments');
		$payments = $pm->getList();
		$this->assign("payments",$payments);

//		if($endTime==0){
//			$endTime = 24;
//			$cstartTime = (floor($startTime))*4;
//			$cendTime = (floor($endTime))*4;
//		}else{
//			$cstartTime = (floor($startTime)+1)*4;
//			$cendTime = (floor($endTime)+1)*4;
//		}
//		if(floor($startTime)<$startTime){
//			$cstartTime = $cstartTime + 2;
//		}
//		if(floor($endTime)<$endTime){
//			$cendTime = $cendTime + 2;
//		}
		//$baseScore = WSTOrderScore();
		//$baseMoney = WSTScoreMoney();
		//$this->assign("startTime",$cstartTime);
		//$this->assign("endTime",$cendTime);
		$this->assign("shopColleges",$shopColleges);
		$this->assign("catgoods",$catgoods);
		$this->assign("gtotalMoney",$gtotalMoney);
		$this->assign("totalMoney",$totalMoney);
		/*积分暂时不启用*/
//		$um = D('Wx/Users');
//		$user = $um->getUserById(array("userId"=>session('WST_USER.userId')));
//		$this->assign("userScore",$user['userScore']);
//		$useScore = $baseScore*floor($user["userScore"]/$baseScore);
//		$scoreMoney = $baseMoney*floor($user["userScore"]/$baseScore);
//		if($totalMoney<$scoreMoney){//订单金额小于积分金额
//			$useScore = $baseScore*floor($totalMoney/$baseMoney);
//			$scoreMoney = $baseMoney*floor($totalMoney/$baseMoney);
//		}
//		$this->assign("canUserScore",$useScore);
//		$this->assign("scoreMoney",$scoreMoney);
		$this->display('shop/check_order');
	}
	
	/**
	 * 提交订单信息
	 * 
	 */
	public function submitOrder(){

		$this->isUserLogin();
		session("WST_ORDER_UNIQUE",null);
		$morders = D('Wx/Orders');
		$rs = $morders->submitOrder();
		$this->ajaxReturn($rs);
	}
	/**
	 * 去支付
	 */
	public function toWxPay(){
		$orderunique = session("WST_ORDER_UNIQUE");
		$isScorePay = 0;//是否积分抵用
        $orderModel = D("Wx/Orders");
		$sql = "SELECT o.orderId,o.userId,o.useScore,o.payType, o.orderNo,o.shopId,o.needPay ,og.goodsNums ,og.goodsId,og.goodsAttrId
				FROM __PREFIX__order_goods og, __PREFIX__orders o
				WHERE o.orderId = og.orderId AND o.orderunique ='$orderunique'";
		$ordergoods =  $orderModel->query($sql);
		$payway = $ordergoods[0]['payType'];
		$userId =  $ordergoods[0]['userId'];
		$totalpayamount = 0;
		foreach($ordergoods as $key=>$val){
			$totalpayamount += $val['needPay'];
			//添加积分明细
			if($GLOBALS['CONFIG']['isOpenScorePay']==1 && $isScorePay==1 && $val['useScore']>0){//积分支付
				$sql = "UPDATE __PREFIX__users set userScore=userScore-".$val['useScore']." WHERE userId=".$userId;
				$rs = $orderModel->execute($sql);
				$datas = array();
				$m = M('user_score');
				$datas["userId"] = $userId;
				$datas["score"] = $val['useScore'];
				$datas["dataSrc"] = 1;
				$datas["dataId"] = $val['orderId'];
				$datas["dataRemarks"] = "订单支付-扣积分";
				$datas["scoreType"] = 2;
				$datas["createTime"] = date('Y-m-d H:i:s');
				$m->add($datas);
			}
			//事务结束后操作
			if($payway==0){ //$payway;//0:货到付款 1:微信支付 2支付宝支付 3：余额支付
				//建立订单记录
				$data = array();
				$data["orderId"] = $val['orderId'];
				$data["logContent"] = "下单成功";
				$data["logUserId"] = $userId;
				$data["logType"] = 0;
				$data["logTime"] = date('Y-m-d H:i:s');
				$mlogo = M('log_orders');
				$mlogo->add($data);

				//建立订单提醒
				$sql ="SELECT userId,shopId,shopName FROM __PREFIX__shops WHERE shopId=".$val['shopId']." AND shopFlag=1  ";
				$users = $orderModel->query($sql);
				$morm = M('order_reminds');
				for($i=0;$i<count($users);$i++){
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
				$sql="update __PREFIX__goods set goodsStock=goodsStock-".$val['goodsNums']." where goodsId=".$val["goodsId"];
				$orderModel->execute($sql);
				if((int)$val["goodsAttrId"]>0){
					$sql="update __PREFIX__goods_attributes set attrStock=attrStock-".$val['goodsNums']." where id=".$val["goodsAttrId"];
					$orderModel->execute($sql);
				}
				echo '<script type="application/javascript">window.location.href="/Wx/Orders/querydeliverybypage"</script>';
				exit;
			}else{
				$data = array();
				$data["orderId"] = $val['orderId'];
				$data["logContent"] = "订单已提交，等待支付";
				$data["logUserId"] = $userId;
				$data["logType"] = 0;
				$data["logTime"] = date('Y-m-d H:i:s');
				$mlogo = M('log_orders');
				$mlogo->add($data);
			}
		}

		//判断支付方式
		if($payway  != 0) { //不属于货到付款
			$account_info = M("users")->where("userId=$userId")->find();
			//支付方式
			if ($totalpayamount > 0) {
				if ($payway == 3) { //余额支付
					if ($account_info['userBalance'] < $totalpayamount) {
						$ordersign = md5($orderunique . "xihuansha.2016.#");
						$payamountweixin = ($totalpayamount - $account_info['userBalance']) * 100;
						//余额不足跳转至微信支付
						echo '<script type="application/javascript">window.location.href="/?g=Wx&c=Wxpay&a=index&trannum=' . $orderunique . '&ordersign=' . $ordersign . '&payamount=' . $payamountweixin . '&backurl=' . urlencode("/?g=Wx&c=index&a=index") . '&showwxpaytitle=1"</script>';
						exit;
					}
				} else { //跳转至微信支付
					$ordersign = md5($orderunique . "xihuansha.2016.#");
					echo '<script type="application/javascript">window.location.href="/?g=Wx&c=Wxpay&a=index&trannum=' . $orderunique . '&ordersign=' . $ordersign . '&payamount=' . ($totalpayamount * 100) . '&backurl=' . urlencode("/?g=Wx&c=index&a=index") . '&showwxpaytitle=1"</script>';
					exit;
				}
			}

			//扣款、明细
			if ($totalpayamount > 0) {
				$accoun = M('users')->where(array('userId' => $userId))->setDec('userBalance', $totalpayamount);
				if (false != $accoun) {
					M('orders')->where(array('orderunique' => $orderunique))->save(array('orderStatus' => 0, 'payTime' => date("Y-m-d H:i:s")));
					$orderModel->addAccountAmount($userId, '消费', 0 - $totalpayamount, $account_info['userBalance'] - $totalpayamount, $transaction_id = 0, $orderunique, '', date("Y-m-d H:i:s"));
				}
			} else {
				M('orders')->where(array('orderunique' => $orderunique))->save(array('orderStatus' => 0, 'payTime' => date("Y-m-d H:i:s")));
			}

			M("order_level")->where(array('orderunique' => $orderunique))->save(array('orderStatus' => 0)); //更新分成订单状态
			$orderModel->addTranPayments($userId, $orderunique, '余额支付', $totalpayamount, date("Y-m-d H:i:s")); //订单支付明细
			foreach ($ordergoods as $key=> $val) {
				//建立订单记录
				$data = array();
				$data["orderId"] = $val['orderId'];
				$data["logContent"] ="下单成功";
				$data["logUserId"] = $userId;
				$data["logType"] = 0;
				$data["logTime"] = date('Y-m-d H:i:s');
				$mlogo = M('log_orders');
				$mlogo->add($data);

				//建立订单提醒
				$sql = "SELECT userId,shopId,shopName FROM __PREFIX__shops WHERE shopId=".$val['shopId'] ." AND shopFlag=1  ";
				$users = $orderModel->query($sql);
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
				$orderModel->execute($sql);
				if ((int)$val["goodsAttrId"] > 0) {
					$sql = "update __PREFIX__goods_attributes set attrStock=attrStock-" . $val['goodsNums'] . " where id=" . $val["goodsAttrId"];
					$orderModel->execute($sql);
				}
			}
		}
		echo '<script type="application/javascript">window.location.href="/Wx/Orders/querydeliverybypage"</script>';
		exit;

	}

	/**
	 * 显示下单结果
	 */
	public function orderSuccess(){
		$this->isUserLogin();
		$morders = D('Wx/Orders');
		$this->assign("orderInfos",$morders->getOrderListByIds());
		$this->display('shop/order_success');
	}
	
	/**
	 * 检查是否已支付
	 */
	public function checkOrderPay(){
		$morders = D('Wx/Orders');
		$USER = session('WST_USER');
		$obj["userId"] = (int)$USER['userId'];
		$rs = $morders->checkOrderPay($obj);
		$this->ajaxReturn($rs);
	}
	
	
	/**
	 * 订单詳情
	 */
	public function getOrderDetails(){
		$this->isUserLogin();
		$USER = session('WST_USER');
		$morders = D('Wx/Orders');
		$obj["userId"] = (int)$USER['userId'];
		$obj["shopId"] = (int)$USER['shopId'];
		$obj["orderId"] = (int)I("orderId");
		$rs = $morders->getOrderDetails($obj);
		$data["orderInfo"] = $rs;
		$this->assign("orderInfo",$rs);
	
		$this->display("users/orders/details");
	}
	
	/*************************************************************************/
	/********************************商家訂單管理*****************************/
	/*************************************************************************/
	/**
	 * 跳转到商家订单列表
	*/
	public function toShopOrdersList(){
		$this->isShopLogin();
		$morders = D('Wx/Orders');
		$this->assign("umark","toShopOrdersList");		
		$this->display("default/shops/orders/list");
	}
	/**
	 * 获取商家订单列表
	*/
	public function queryShopOrders(){
		$this->isShopLogin();
		$USER = session('WST_USER');
		$morders = D('Wx/Orders');
		$obj["shopId"] = (int)$USER["shopId"];
		$obj["userId"] = (int)$USER['userId'];
		$orders = $morders->queryShopOrders($obj);
		
		$this->ajaxReturn($orders);
	}
	/**
	 * 商家受理订单
	 */
    public function shopOrderAccept(){
    	$this->isShopLogin();
    	$USER = session('WST_USER');
    	$morders = D('Wx/Orders');
    	$obj["userId"] = (int)$USER['userId'];
    	$obj["shopId"] = (int)$USER['shopId'];
    	$obj["orderId"] = (int)I("orderId");
		$rs = $morders->shopOrderAccept($obj);
		$this->ajaxReturn($rs);
	} 
    /**
	 * 商家批量受理订单
	 */
    public function batchShopOrderAccept(){
    	$this->isShopLogin();
    	$morders = D('Wx/Orders');
		$rs = $morders->batchShopOrderAccept($obj);
		$this->ajaxReturn($rs);
	}
	/**
	 * 商家生产订单
	 */
    public function shopOrderProduce(){
    	$this->isShopLogin();
    	$USER = session('WST_USER');
    	$morders = D('Wx/Orders');
    	$obj["userId"] = (int)$USER['userId'];
    	$obj["shopId"] = (int)$USER['shopId'];
    	$obj["orderId"] = (int)I("orderId");
		$rs = $morders->shopOrderProduce($obj);
		$this->ajaxReturn($rs);
	} 
	public function batchShopOrderProduce(){
    	$this->isShopLogin();
    	$morders = D('Wx/Orders');
		$rs = $morders->batchShopOrderProduce($obj);
		$this->ajaxReturn($rs);
	} 
	/**
	 * 商家发货配送订单
	 */
    public function shopOrderDelivery(){
    	$this->isShopLogin();
    	$USER = session('WST_USER');
    	$morders = D('Wx/Orders');
    	$obj["userId"] = (int)$USER['userId'];
    	$obj["shopId"] = (int)$USER['shopId'];
    	$obj["orderId"] = (int)I("orderId");
		$rs = $morders->shopOrderDelivery($obj);
		$this->ajaxReturn($rs);
	} 
	
    /**
	 * 商家发货配送订单
	 */
    public function batchShopOrderDelivery(){
    	$this->isShopLogin();
    	$morders = D('Wx/Orders');
		$rs = $morders->batchShopOrderDelivery($obj);
		$this->ajaxReturn($rs);
	}
	
	/**
	 * 商家确认收货订单
	 */
    public function shopOrderReceipt(){
    	$this->isShopLogin();
    	$USER = session('WST_USER');
    	$morders = D('Wx/Orders');
    	$obj["userId"] = (int)$USER['userId'];
    	$obj["shopId"] = (int)$USER['shopId'];
    	$obj["orderId"] = (int)I("orderId");
		$rs = $morders->shopOrderReceipt($obj);
		$this->ajaxReturn($rs);
	} 
	
	/**
	 * 商家同意拒收/不同意拒收
	 */
	public function shopOrderRefund(){
		$this->isShopLogin();
		$USER = session('WST_USER');
    	$morders = D('Wx/Orders');
    	$obj["userId"] = (int)$USER['userId'];
    	$obj["shopId"] = (int)$USER['shopId'];
    	$obj["orderId"] = (int)I("orderId");
		$rs = $morders->shopOrderRefund($obj);
		$this->ajaxReturn($rs);
	}
	
	/**
	 * 获取用户订单消息提示
	 */
	public function getUserMsgTips(){
		$this->isUserLogin();
		$morders = D('Wx/Orders');
		$USER = session('WST_USER');
		$obj["userId"] = (int)$USER['userId'];
		$statusList = $morders->getUserOrderStatusCount($obj);
		$this->ajaxReturn($statusList);
	}
	
	/**
	 * 获取店铺订单消息提示
	 */
	public function getShopMsgTips(){
		$this->isShopLogin();
		$morders = D('Wx/Orders');
		$USER = session('WST_USER');
		$obj["shopId"] = (int)$USER['shopId'];
		$obj["userId"] = (int)$USER['userId'];
		$statusList = $morders->getShopOrderStatusCount($obj);
		$this->ajaxReturn($statusList);
	}
	
}