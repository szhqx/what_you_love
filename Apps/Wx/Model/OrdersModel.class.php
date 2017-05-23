<?php
namespace Wx\Model;
/**
 * ============================================================================
 * QianPokMall商城
 * 官网地址:http://www.qianpok.com
 * 联系QQ:376983512
 * ============================================================================
 * 订单服务类
 */
class OrdersModel extends BaseModel {
	/**
	 * 获以订单列表
	 */
	public function getOrdersList($obj){
		$userId = $obj["userId"];
		$m = M('orders');
		$sql = "SELECT * FROM __PREFIX__orders WHERE userId = $userId AND orderStatus <>-1 order by createTime desc";		
		return $m->pageQuery($sql);
	}
	
	/**
	 * 取消订单记录 
	 */
	public function getcancelOrderList($obj){		
		$userId = $obj["userId"];
		$m = M('orders');
		$sql = "SELECT * FROM __PREFIX__orders WHERE userId = $userId AND orderStatus =-1 order by createTime desc";		
		return $m->pageQuery($sql);
		
	}

	/**
	 * 获取订单详情
	 */
	public function getOrdersDetails($obj){		
		$orderId = $obj["orderId"];
		$sql = "SELECT od.*,sp.shopName 
				FROM __PREFIX__orders od, __PREFIX__shops sp 
				WHERE od.shopId = sp.shopId And orderId = $orderId ";		
		$rs = $this->query($sql);;	
		return $rs;
		
	}
	
	/**
	 * 获取订单商品信息
	 */
	public function getOrdersGoods($obj){	
			
		$orderId = $obj["orderId"];
		$sql = "SELECT g.*,og.goodsNums as ogoodsNums,og.goodsPrice as ogoodsPrice 
				FROM __PREFIX__order_goods og, __PREFIX__goods g 
				WHERE og.orderId = $orderId AND og.goodsId = g.goodsId ";		
		$rs = $this->query($sql);	
		return $rs;
		
	}
	
	/**
	 * 
	 * 获取订单商品详情
	 */
	public function getOrdersGoodsDetails($obj){	
			
		$orderId = $obj["orderId"];
		$sql = "SELECT g.*,og.goodsNums as ogoodsNums,og.goodsPrice as ogoodsPrice ,ga.id as gaId
				FROM __PREFIX__order_goods og, __PREFIX__goods g 
				LEFT JOIN __PREFIX__goods_appraises ga ON g.goodsId = ga.goodsId AND ga.orderId = $orderId
				WHERE og.orderId = $orderId AND og.goodsId = g.goodsId";		
		$rs = $this->query($sql);	
		return $rs;
		
	}
	
	/**
	 *
	 * 获取订单商品详情
	 */
	public function getPayOrders($obj){
		$orderType = (int)$obj["orderType"];
		$orderId = 0;
		$orderunique = 0;
		if($orderType>0){//来在线支付接口
			$uniqueId = $obj["uniqueId"];
			if($orderType==1){
				$orderId = (int)$uniqueId;
			}else{
				$orderunique = WSTAddslashes($uniqueId);
			}
		}else{
			$orderId = (int)$obj["orderId"];
			$orderunique = session("WST_ORDER_UNIQUE");
		}
		
		if($orderId>0){
			$sql = "SELECT o.orderId, o.orderNo, g.goodsId, g.goodsName ,og.goodsAttrName , og.goodsNums ,og.goodsPrice
				FROM __PREFIX__order_goods og, __PREFIX__goods g, __PREFIX__orders o
				WHERE o.orderId = og.orderId AND og.goodsId = g.goodsId AND o.payType=1 AND orderFlag =1 AND o.isPay=0 AND o.needPay>0 AND o.orderStatus = -2 AND o.orderId =$orderId";
		}else{
			$sql = "SELECT o.orderId, o.orderNo, g.goodsId, g.goodsName ,og.goodsAttrName , og.goodsNums ,og.goodsPrice
				FROM __PREFIX__order_goods og, __PREFIX__goods g, __PREFIX__orders o
				WHERE o.orderId = og.orderId AND og.goodsId = g.goodsId AND o.payType=1 AND orderFlag =1 AND o.isPay=0 AND o.needPay>0 AND o.orderStatus = -2 AND o.orderunique ='$orderunique'";
		}
		
		$rslist = $this->query($sql);
		
		$orders = array();
		foreach ($rslist as $key => $order) {
			$orders[$order["orderNo"]][] = $order;
		}
		if($orderId>0){
			$sql = "SELECT SUM(needPay) needPay FROM __PREFIX__orders WHERE orderId = $orderId AND isPay=0 AND payType=1 AND needPay>0 AND orderStatus = -2 AND orderFlag =1";
		}else{
			$sql = "SELECT SUM(needPay) needPay FROM __PREFIX__orders WHERE orderunique = '$orderunique' AND isPay=0 AND payType=1 AND needPay>0 AND orderStatus = -2 AND orderFlag =1";
		}
		$payInfo = self::queryRow($sql);
		$data["orders"] = $orders;
		$data["needPay"] = $payInfo["needPay"];
		return $data;
	
	}
	
	/**
	 * 下单
	 */
	public function submitOrder(){
		$rd = array('status'=>-1);
		$USER = session('WST_USER');
		$goodsmodel = D('Wx/Goods');
		$morders = D('Wx/Orders');
		$totalMoney = 0;
		$totalCnt = 0;
		$userId = (int)$USER['userId'];
		
		$consigneeId = (int)I("consigneeId");
		$payway = (int)I("payway"); //支付类型 0:货到付款 1:微信支付 2:支付宝支付 3：余额支付3;//
		$isself = (int)I("isself"); //配送类型 0：物流配送 1：上门自提
		$needreceipt = (int)I("needreceipt");
		$isScorePay = (int)I("isScorePay",0); //是否积分抵用支付
		$orderunique = WSTGetMillisecond().$userId;
		$shopcat = getcart();

		$catgoods = array();
		$order = array();
		if(empty($shopcat)){
			$rd['msg'] = '购物车为空!';
			return $rd;
		}else{
			//整理及核对购物车数据
			$paygoods = session('WST_PAY_GOODS');
			foreach($shopcat as $key=>$cgoods){
				if($cgoods['ischk']==0)continue;//跳过未选中的商品
				$temp = explode('_',$key);
				$goodsId = (int)$temp[0];
				$goodsAttrId = (int)$temp[1];
				if(in_array($goodsId, $paygoods)){
					$goods = $goodsmodel->getGoodsSimpInfo($goodsId,$goodsAttrId);
					//核对商品是否符合购买要求
					if(empty($goods)){
						$rd['msg'] = '找不到指定的商品!';
						return $rd;
					}
					if($goods['goodsStock']<=0){
						$rd['msg'] = '对不起，商品'.$goods['goodsName'].'库存不足!';
						return $rd;
					}
					if($goods['isSale']!=1){
						$rd['msg'] = '对不起，商品库'.$goods['goodsName'].'已下架!';
						return $rd;
					}
					$goods["cnt"] = $cgoods["cnt"];
					$goods["goodsAttrs"] = $key; //商品规格组
					$goods['goodsAttrsName'] = returnAttr($key);
					$totalCnt += $cgoods["cnt"];
					$totalMoney += $goods["cnt"]*$goods["shopPrice"]; //订单总金额
					$catgoods[$goods["shopId"]]["shopgoods"][] = $goods;
					$catgoods[$goods["shopId"]]["deliveryFreeMoney"] = $goods["deliveryFreeMoney"];//店铺免运费最低金额
					$catgoods[$goods["shopId"]]["deliveryMoney"] = $goods["deliveryMoney"];//店铺免运费最低金额
					$catgoods[$goods["shopId"]]["totalCnt"] = $catgoods[$goods["shopId"]]["totalCnt"]+$cgoods["cnt"];

					//计算商铺给平台的低价总成本
					if($goods["attrlowPrice"]>0){
						$catgoods[$goods['shopId']]['totalCost'] = $catgoods[$goods['shopId']]['totalCost'] +($goods["cnt"]*$goods["attrlowPrice"]);
					}else{
						$catgoods[$goods['shopId']]['totalCost'] = $catgoods[$goods['shopId']]['totalCost'] +($goods["cnt"]*$goods["lowPrice"]);
					}
					//计算平台的计算的总利润
					if($goods["attrprofitPrice"]>0){
						$catgoods[$goods['shopId']]['totalProfit'] = $catgoods[$goods['shopId']]['totalProfit'] +($goods["cnt"]*$goods["attrprofitPrice"]);
					}else{
						$catgoods[$goods['shopId']]['totalProfit'] = $catgoods[$goods['shopId']]['totalProfit'] +($goods["cnt"]*$goods["profitPrice"]);
					}


					$catgoods[$goods["shopId"]]["totalMoney"] = $catgoods[$goods["shopId"]]["totalMoney"]+($goods["cnt"]*$goods["shopPrice"]);
				}
			}
			foreach($catgoods as $key=> $cshop){
				if($cshop["totalMoney"]<$cshop["deliveryFreeMoney"]){
					if($isself==0){
						$totalMoney = $totalMoney + $cshop["deliveryMoney"];
					}
				}
			}

			$morders->startTrans();	
			try{
				$ordersInfo = $morders->addOrders($userId,$consigneeId,$payway,$needreceipt,$catgoods,$orderunique,$isself,$isScorePay);
				$newcart = array();
				foreach($shopcat as $key=>$cgoods){
					if(!in_array($key, $paygoods)){
						$newcart[$key] = $cgoods;
					}
				}
				$morders->commit();
				M("cart")->where("userId=".$userId)->delete(); //提交后删除购物车表


				$rd['orderIds'] = implode(",",$ordersInfo["orderIds"]);
				$rd['status'] = 1;
				session("WST_ORDER_UNIQUE",$orderunique);
			}catch(Exception $e){
				$morders->rollback();
				$rd['msg'] = '下单出错，请联系管理员!';
			}
			return $rd;
		}		
	}
	
	/**
	 * 生成订单
	 * $userId; //用户ID
	 * $consigneeId; //地址ID
	 * $payway; ////0:货到付款 1:微信支付 2支付宝支付 3：余额支付
	 * $needreceipt; //是否需要发票
	 * $catgoods //购物车商品
	 * $orderunique 订单唯一流水号
	 * $isself 配送方式 0配送 1上门自取
	 */
	public function addOrders($userId,$consigneeId,$payway=3,$needreceipt,$catgoods,$orderunique,$isself,$isScorePay){
		$orderInfos = array();
		$orderIds = array();
		$orderNos = array();
		$remarks = I("remarks");

		$totalpayamount = 0 ; //订单需支付总金额
		$addressInfo = UserAddressModel::getAddressDetails($consigneeId);
        $m = M('orderids');
		foreach ($catgoods as $key=> $shopgoods){
			//生成订单ID
			$orderSrcNo = $m->add(array('rnd'=>microtime(true)));
			$orderNo = $orderSrcNo."".(fmod($orderSrcNo,7));
			//第一步 创建订单信息
			$data = array();
			$pshopgoods = $shopgoods["shopgoods"];
			$shopId = $pshopgoods[0]["shopId"];
			$data["orderNo"] = $orderNo;
			$data["shopId"] = $shopId;	
			$deliverType = intval($pshopgoods[0]["deliveryType"]);
			$data["userId"] = $userId;
			$data["orderFlag"] = 1;
			$data["totalMoney"] = $shopgoods["totalMoney"]; //订单总金额
			$data["totalCost"] = $shopgoods["totalCost"]; //总成本
			$data["totalProfit"] = $shopgoods["totalProfit"]; //总利润
			if($isself==1){ //配送方式 1上门自提，0物流配送 判断是否要运费
				$deliverMoney = 0;
			}else{
				$deliverMoney = ($shopgoods["totalMoney"]<$shopgoods["deliveryFreeMoney"])?$shopgoods["deliveryMoney"]:0;
			}

			$data["deliverMoney"] = $deliverMoney; //配送费用
			$data["payType"] = $payway; //0:货到付款 1:微信支付 2支付宝支付 3：余额支付
			$data["deliverType"] = $deliverType; //配送方式 0-商城配送 1-店铺配送
			$data["userName"] = $addressInfo["userName"];
			$data["areaId1"] = $addressInfo["areaId1"];
			$data["areaId2"] = $addressInfo["areaId2"];
			$data["areaId3"] = $addressInfo["areaId3"];
			$data["communityId"] = $addressInfo["communityId"];
			$data["userAddress"] = $addressInfo["paddress"]." ".$addressInfo["address"];
			$data["userTel"] = $addressInfo["userTel"];
			$data["userPhone"] = $addressInfo["userPhone"];
			
			$data['orderScore'] = floor($data["totalMoney"]+$data["deliverMoney"]);
			$data["isInvoice"] = $needreceipt;		
			$data["orderRemarks"] = $remarks;
			$data["requireTime"] = I("requireTime");
			$data["invoiceClient"] = I("invoiceClient");
			$data["isAppraises"] = 0;
			$data["isSelf"] = $isself;
			$isScorePay = $isScorePay; //是否积分抵用支付
			$scoreMoney = 0;
			$useScore = 0;
			$data["couponMoney"] = 0;//优惠券低多少钱
			//佣金计算
			if($GLOBALS['CONFIG']['poundageRate']>0){
				$data["poundageRate"] = $GLOBALS['CONFIG']['poundageRate']; //分成比率
				//公式：（（总金额-总成本-优惠券）* 分成比率）
				//$data["poundageMoney"] = WSTBCMoney($data["totalMoney"] * $data["poundageRate"] / 100,0,2);//
				$data["poundageMoney"] = WSTBCMoney(($data["totalMoney"] - $data["totalCost"]-$data["couponMoney"]) * $data["poundageRate"] / 100,0,2);//分成总金额
			}else{
				$data["poundageRate"] = 0;
				$data["poundageMoney"] = 0;
			}
			//计算积分抵用
			if($GLOBALS['CONFIG']['isOpenScorePay']==1 && $isScorePay==1){
				$baseScore = WSTOrderScore();
				$baseMoney = WSTScoreMoney();
				$sql = "select userId,userScore from __PREFIX__users where userId=$userId";
				$user = $this->queryRow($sql);
				$useScore = $baseScore*floor($user["userScore"]/$baseScore);
				$scoreMoney = $baseMoney*floor($user["userScore"]/$baseScore);
				$orderTotalMoney = $shopgoods["totalMoney"]+$deliverMoney;
				if($orderTotalMoney<$scoreMoney){//订单金额小于积分金额
					$useScore = $baseScore*floor($orderTotalMoney/$baseMoney);
					$scoreMoney = $baseMoney*floor($orderTotalMoney/$baseMoney);
				}
				$data["useScore"] = $useScore;
				$data["scoreMoney"] = $scoreMoney;
			}

			$data["realTotalMoney"] = $shopgoods["totalMoney"]+$deliverMoney - $scoreMoney;
			$data["needPay"] = $shopgoods["totalMoney"]+$deliverMoney - $scoreMoney;
			
			$data["createTime"] = date("Y-m-d H:i:s");
			//支付状态-2未付款 0，未受理
			if($payway!=0){ //$payway; //0:货到付款 1:微信支付 2支付宝支付 3：余额支付
				$data["orderStatus"] = -2;
			}else{
				$data["orderStatus"] = 0;
			}
			
			$data["orderunique"] = $orderunique;
			$data["isPay"] = 0; //是否支付 0：未支付 1：已支付
			if($data["needPay"]==0){
				$data["isPay"] = 1;
			}
			$morders = M('orders');
			$orderId = $morders->add($data);

			//订单创建成功则建立相关记录
			if($orderId>0){
				$orderIds[] = $orderId;
				//建立订单分成记录表
				$user_info = M('user_exp')->where('uid='.$userId)->find();
				$mol = M("order_level");
				//奖金池
				$data_level[0]['orderId'] = $orderId;
				$data_level[0]["orderNo"] = $orderNo;
				$data_level[0]['orderunique'] = $orderunique;
				$data_level[0]['active_time'] = date('Y-m-d H:i:s');
				$data_level[0]['orderStatus'] = $data["orderStatus"];
				$data_level[0]['level_id'] = 1;
				if(!empty($user_info['p_a'])){ //一级
					$data_level[$user_info['p_a']]['orderId'] = $orderId;
					$data_level[$user_info['p_a']]["orderNo"] = $orderNo;
					$data_level[$user_info['p_a']]['orderunique'] = $orderunique;
					$data_level[$user_info['p_a']]['active_time'] = date('Y-m-d H:i:s');
					$data_level[$user_info['p_a']]['orderStatus'] = $data["orderStatus"];
					$data_level[$user_info['p_a']]['level_id'] = $user_info['p_a'];
					$data_level[$user_info['p_a']]['level_type'] = 1;
					if($data["poundageMoney"]  > 0){
						$data_level[$user_info['p_a']]['price'] = WSTBCMoney($data["poundageMoney"]/ 9,0,2);
					}else{
						$data_level[$user_info['p_a']]['price'] = 0;
					}
				}else{
					if($data["poundageMoney"]  > 0){
						$data_level[0]['price'] += WSTBCMoney($data["poundageMoney"]/ 9,0,2);
					}else{
						$data_level[0]['price'] += 0;
					}
				}
				if(!empty($user_info['p_b'])){ //二级
					$cjuser = array();
					$cjuser = M("users")->where("userId=".$user_info['p_b'])->find();
					if(($cjuser["userMeet"]==0) || ($cjuser["userMeet"]==1 && $cjuser["userOff"] != $user_info['p_a'])){
						$data_level[$user_info['p_b']]['orderId'] = $orderId;
						$data_level[$user_info['p_b']]["orderNo"] = $orderNo;
						$data_level[$user_info['p_b']]['orderunique'] = $orderunique;
						$data_level[$user_info['p_b']]['active_time'] = date('Y-m-d H:i:s');
						$data_level[$user_info['p_b']]['orderStatus'] = $data["orderStatus"];
						$data_level[$user_info['p_b']]['level_id'] = $user_info['p_b'];
						$data_level[$user_info['p_b']]['level_type'] = 2;
						if($data["poundageMoney"]  > 0){
							$data_level[$user_info['p_b']]['price'] = WSTBCMoney($data["poundageMoney"]/ 9,0,2);
						}else{
							$data_level[$user_info['p_b']]['price'] = 0;
						}
					}else{
						if($data["poundageMoney"]  > 0){
							$data_level[0]['price'] += WSTBCMoney($data["poundageMoney"]/ 9,0,2);
						}else{
							$data_level[0]['price'] += 0;
						}
					}

				}else{
					if($data["poundageMoney"]  > 0){
						$data_level[0]['price'] += WSTBCMoney($data["poundageMoney"]/ 9,0,2);
					}else{
						$data_level[0]['price'] += 0;
					}
				}
				if(!empty($user_info['p_c'])){ //三级
					$cjuser = array();
					$cjuser = M("users")->where("userId=".$user_info['p_c'])->find();
					if(($cjuser["userMeet"]==0) || ($cjuser["userMeet"]==1 && $cjuser["userOff"] != $user_info['p_b'])){
						$data_level[$user_info['p_c']]['orderId'] = $orderId;
						$data_level[$user_info['p_c']]['orderunique'] = $orderunique;
						$data_level[$user_info['p_c']]["orderNo"] = $orderNo;
						$data_level[$user_info['p_c']]['active_time'] = date('Y-m-d H:i:s');
						$data_level[$user_info['p_c']]['orderStatus'] = $data["orderStatus"];
						$data_level[$user_info['p_c']]['level_id'] = $user_info['p_c'];
						$data_level[$user_info['p_c']]['level_type'] = 3;
						if($data["poundageMoney"]  > 0){
							$data_level[$user_info['p_c']]['price'] = WSTBCMoney($data["poundageMoney"]/ 9,0,2);
						}else{
							$data_level[$user_info['p_c']]['price'] = 0;
						}
					}else{
						if($data["poundageMoney"]  > 0){
							$data_level[0]['price'] += WSTBCMoney($data["poundageMoney"]/ 9,0,2);
						}else{
							$data_level[0]['price'] += 0;
						}
					}
				}else{
					if($data["poundageMoney"]  > 0){
						$data_level[0]['price'] += WSTBCMoney($data["poundageMoney"]/ 9,0,2);
					}else{
						$data_level[0]['price'] += 0;
					}
				}
				if(!empty($user_info['p_d'])){ //四级
					$cjuser = array();
					$cjuser = M("users")->where("userId=".$user_info['p_d'])->find();
					if(($cjuser["userMeet"]==0) || ($cjuser["userMeet"]==1 && $cjuser["userOff"] != $user_info['p_c'])){
						$data_level[$user_info['p_d']]['orderId'] = $orderId;
						$data_level[$user_info['p_d']]["orderNo"] = $orderNo;
						$data_level[$user_info['p_d']]['orderunique'] = $orderunique;
						$data_level[$user_info['p_d']]['active_time'] = date('Y-m-d H:i:s');
						$data_level[$user_info['p_d']]['orderStatus'] = $data["orderStatus"];
						$data_level[$user_info['p_d']]['level_id'] = $user_info['p_d'];
						$data_level[$user_info['p_d']]['level_type'] = 4;
						if($data["poundageMoney"]  > 0){
							$data_level[$user_info['p_d']]['price'] = WSTBCMoney($data["poundageMoney"]/ 9,0,2);
						}else{
							$data_level[$user_info['p_d']]['price'] = 0;
						}
					}else{ //不符合大小边钱只能到奖金池
						if($data["poundageMoney"]  > 0){
							$data_level[0]['price'] += WSTBCMoney($data["poundageMoney"]/ 9,0,2);
						}else{
							$data_level[0]['price'] += 0;
						}
					}
				}else{
					if($data["poundageMoney"]  > 0){
						$data_level[0]['price'] += WSTBCMoney($data["poundageMoney"]/ 9,0,2);
					}else{
						$data_level[0]['price'] += 0;
					}
				}
				if(!empty($user_info['p_e'])){ //五级
					$cjuser = array();
					$cjuser = M("users")->where("userId=".$user_info['p_e'])->find();
					if(($cjuser["userMeet"]==0) || ($cjuser["userMeet"]==1 && $cjuser["userOff"] != $user_info['p_d'])){
						$data_level[$user_info['p_e']]['orderId'] = $orderId;
						$data_level[$user_info['p_e']]["orderNo"] = $orderNo;
						$data_level[$user_info['p_e']]['orderunique'] = $orderunique;
						$data_level[$user_info['p_e']]['active_time'] = date('Y-m-d H:i:s');
						$data_level[$user_info['p_e']]['orderStatus'] = $data["orderStatus"];
						$data_level[$user_info['p_e']]['level_id'] = $user_info['p_e'];
						$data_level[$user_info['p_e']]['level_type'] = 5;
						if($data["poundageMoney"]  > 0){
							$data_level[$user_info['p_e']]['price'] = WSTBCMoney($data["poundageMoney"]/ 9,0,2);
						}else{
							$data_level[$user_info['p_e']]['price'] = 0;
						}
					}else{
						if($data["poundageMoney"]  > 0){
							$data_level[0]['price'] += WSTBCMoney($data["poundageMoney"]/ 9,0,2);
						}else{
							$data_level[0]['price'] += 0;
						}
					}
				}else{
					if($data["poundageMoney"]  > 0){
						$data_level[0]['price'] += WSTBCMoney($data["poundageMoney"]/ 9,0,2);
					}else{
						$data_level[0]['price'] += 0;
					}
				}
				if(!empty($user_info['p_f'])){ //六级
					$cjuser = array();
					$cjuser = M("users")->where("userId=".$user_info['p_f'])->find();
					if(($cjuser["userMeet"]==0) || ($cjuser["userMeet"]==1 && $cjuser["userOff"] != $user_info['p_e'])){
						$data_level[$user_info['p_f']]['orderId'] = $orderId;
						$data_level[$user_info['p_f']]["orderNo"] = $orderNo;
						$data_level[$user_info['p_f']]['orderunique'] = $orderunique;
						$data_level[$user_info['p_f']]['active_time'] = date('Y-m-d H:i:s');
						$data_level[$user_info['p_f']]['orderStatus'] = $data["orderStatus"];
						$data_level[$user_info['p_f']]['level_id'] = $user_info['p_f'];
						$data_level[$user_info['p_f']]['level_type'] = 6;
						if($data["poundageMoney"]  > 0){
							$data_level[$user_info['p_f']]['price'] = WSTBCMoney($data["poundageMoney"]/ 9,0,2);
						}else{
							$data_level[$user_info['p_f']]['price'] = 0;
						}
					}else{
						if($data["poundageMoney"]  > 0){
							$data_level[0]['price'] += WSTBCMoney($data["poundageMoney"]/ 9,0,2);
						}else{
							$data_level[0]['price'] += 0;
						}
					}

				}else{
					if($data["poundageMoney"]  > 0){
						$data_level[0]['price'] += WSTBCMoney($data["poundageMoney"]/ 9,0,2);
					}else{
						$data_level[0]['price'] += 0;
					}
				}
				if(!empty($user_info['p_g'])){ //七级
					$cjuser = array();
					$cjuser = M("users")->where("userId=".$user_info['p_g'])->find();
					if(($cjuser["userMeet"]==0) || ($cjuser["userMeet"]==1 && $cjuser["userOff"] != $user_info['p_f'])){
						$data_level[$user_info['p_g']]['orderId'] = $orderId;
						$data_level[$user_info['p_g']]["orderNo"] = $orderNo;
						$data_level[$user_info['p_g']]['orderunique'] = $orderunique;
						$data_level[$user_info['p_g']]['active_time'] = date('Y-m-d H:i:s');
						$data_level[$user_info['p_g']]['orderStatus'] = $data["orderStatus"];
						$data_level[$user_info['p_g']]['level_id'] = $user_info['p_g'];
						$data_level[$user_info['p_g']]['level_type'] = 7;
						if($data["poundageMoney"]  > 0){
							$data_level[$user_info['p_g']]['price'] = WSTBCMoney($data["poundageMoney"]/ 9,0,2);
						}else{
							$data_level[$user_info['p_g']]['price'] = 0;
						}
					}else{
						if($data["poundageMoney"]  > 0){
							$data_level[0]['price'] += WSTBCMoney($data["poundageMoney"]/ 9,0,2);
						}else{
							$data_level[0]['price'] += 0;
						}
					}
				}else{
					if($data["poundageMoney"]  > 0){
						$data_level[0]['price'] += WSTBCMoney($data["poundageMoney"]/ 9,0,2);
					}else{
						$data_level[0]['price'] += 0;
					}
				}
				if(!empty($user_info['p_h'])){ //八级
					$cjuser = array();
					$cjuser = M("users")->where("userId=".$user_info['p_h'])->find();
					if(($cjuser["userMeet"]==0) || ($cjuser["userMeet"]==1 && $cjuser["userOff"] != $user_info['p_g'])){
						$data_level[$user_info['p_h']]['orderId'] = $orderId;
						$data_level[$user_info['p_h']]["orderNo"] = $orderNo;
						$data_level[$user_info['p_h']]['orderunique'] = $orderunique;
						$data_level[$user_info['p_h']]['active_time'] = date('Y-m-d H:i:s');
						$data_level[$user_info['p_h']]['orderStatus'] = $data["orderStatus"];
						$data_level[$user_info['p_h']]['level_id'] = $user_info['p_h'];
						$data_level[$user_info['p_h']]['level_type'] = 8;
						if($data["poundageMoney"]  > 0){
							$data_level[$user_info['p_h']]['price'] = WSTBCMoney($data["poundageMoney"]/ 9,0,2);
						}else{
							$data_level[$user_info['p_h']]['price'] = 0;
						}
					}else{
						if($data["poundageMoney"]  > 0){
							$data_level[0]['price'] += WSTBCMoney($data["poundageMoney"]/ 9,0,2);
						}else{
							$data_level[0]['price'] += 0;
						}
					}
				}else{
					if($data["poundageMoney"]  > 0){
						$data_level[0]['price'] += WSTBCMoney($data["poundageMoney"]/ 9,0,2);
					}else{
						$data_level[0]['price'] += 0;
					}
				}
				if(!empty($user_info['p_j'])){ //九级
					$cjuser = array();
					$cjuser = M("users")->where("userId=".$user_info['p_j'])->find();
					if(($cjuser["userMeet"]==0) || ($cjuser["userMeet"]==1 && $cjuser["userOff"] != $user_info['p_h'])){
						$data_level[$user_info['p_j']]['orderId'] = $orderId;
						$data_level[$user_info['p_j']]["orderNo"] = $orderNo;
						$data_level[$user_info['p_j']]['orderunique'] = $orderunique;
						$data_level[$user_info['p_j']]['active_time'] = date('Y-m-d H:i:s');
						$data_level[$user_info['p_j']]['orderStatus'] = $data["orderStatus"];
						$data_level[$user_info['p_j']]['level_id'] = $user_info['p_j'];
						$data_level[$user_info['p_j']]['level_type'] = 9;
						if($data["poundageMoney"]  > 0){
							$data_level[$user_info['p_j']]['price'] = WSTBCMoney($data["poundageMoney"]/ 9,0,2);
						}else{
							$data_level[$user_info['p_j']]['price'] = 0;
						}
					}else{
						if($data["poundageMoney"]  > 0){
							$data_level[0]['price'] += WSTBCMoney($data["poundageMoney"]/ 9,0,2);
						}else{
							$data_level[0]['price'] += 0;
						}
					}
				}else{
					if($data["poundageMoney"]  > 0){
						$data_level[0]['price'] += WSTBCMoney($data["poundageMoney"]/ 9,0,2);
					}else{
						$data_level[0]['price'] += 0;
					}
				}
				$data_level[0]['price'] = WSTBCMoney($data_level[0]['price'],0,2);
				$i = 0;
				foreach($data_level as $key=>$val){
					$new_level[$i] = $val;
					$i++;
				}

				$mol->addAll($new_level);
				//建立订单商品记录表
				$mog = M('order_goods');
				foreach ($pshopgoods as $key=> $sgoods){ //订单商品
					$data = array();
					$data["orderId"] = $orderId;
					$data["goodsId"] = $sgoods["goodsId"];
					$data["goodsAttrId"] = (int)$sgoods["goodsAttrId"];
					if($sgoods["attrVal"]!='')$data["goodsAttrName"] = $sgoods["attrName"].":".$sgoods["attrVal"];
					$data["goodsAttrs"] = $sgoods["goodsAttrs"];
					if($sgoods["attrVal"]!=''){
						$data["goodsAttrsName"] = $sgoods["attrName"].":".$sgoods["attrVal"]." ".$sgoods["goodsAttrsName"];
					}else{
						$data["goodsAttrsName"] = $sgoods["goodsAttrsName"];
					}
					$data["goodsNums"] = $sgoods["cnt"];
					$data["goodsPrice"] = $sgoods["shopPrice"];
					
					$data["goodsName"] = $sgoods["goodsName"];
					$data["goodsThums"] = $sgoods["goodsThums"];
					$mog->add($data);
				}
			}
		}
		return array("orderIds"=>$orderIds);
	}
	/* 扣款明细
    * $type-金额类型：微信充值，支付宝充值，积分兑换，消费
    */

	public function addAccountAmount($userId, $type, $amounts, $balance, $transaction_id = 0, $orderunique, $remark, $createTime) {
		$amount['userId'] = $userId;
		$amount['type'] = $type;
		$amount['amount'] = $amounts;
		$amount['balance'] = $balance;
		$amount['transaction_id'] = $transaction_id;
		$amount['orderunique'] = $orderunique;
		$amount['remark'] = $remark;
		$amount['createTime'] = $createTime;
		$amid = M('users_amount')->add($amount);
		//return $amid;
	}

	/* 交易付款明细
     * @交易号不能为空$trannum,$payment-类型：余额支付，微信付款，红包，优惠券抵用,支付宝支付
     */

	public function addTranPayments($userId, $orderunique, $payment, $amount, $createTime) {
		$pay['userId'] = $userId;
		$pay['orderunique'] = $orderunique;
		$pay['payment'] = $payment;
		$pay['amount'] = $amount;
		$pay['createTime'] = $createTime;
		$pmid = M('Order_payments')->add($pay);
		//return $pmid;
	}
	
	/**
	 * 获取订单参数
	 */
	public function getOrderListByIds(){
		 $orderunique = session("WST_ORDER_UNIQUE");
		 $orderInfos = array('totalMoney'=>0,'isMoreOrder'=>0,'list'=>array());
		 $sql = "select orderId,orderNo,totalMoney,deliverMoney,realTotalMoney
		         from __PREFIX__orders where userId=".(int)session('WST_USER.userId')." 
		         and orderunique='".$orderunique."' and orderFlag=1 ";
	     $rs = $this->query($sql);
	     if(!empty($rs)){
	     	$totalMoney = 0;
	     	$realTotalMoney = 0;
	     	foreach ($rs as $key =>$v){
	     		$orderInfos['list'][] = array('orderId'=>$v['orderId'],'orderNo'=>$v['orderNo']);
	     		$totalMoney += $v['totalMoney'] + $v['deliverMoney'];
	     		$realTotalMoney += $v['realTotalMoney'];
	     	}
	     	$orderInfos['totalMoney'] = $totalMoney;
	     	$orderInfos['realTotalMoney'] = $realTotalMoney;
	     	$orderInfos['isMoreOrder'] = (count($rs)>0)?1:0;
	     }
	     return $orderInfos;
	}
	
	/**
	 * 获取待付款订单
	 */
	public function queryByPage($obj){
		$userId = $obj["userId"];
		$pcurr = (int)I("pcurr",0);
		$sql = "SELECT o.* FROM __PREFIX__orders o
				WHERE userId = $userId AND orderFlag=1 order by orderId desc";
		$pages = $this->pageQuery($sql,$pcurr,1000000);
		$orderList = $pages["root"];
		if(count($orderList)>0){
			$orderIds = array();
			for($i=0;$i<count($orderList);$i++){
				$order = $orderList[$i];
				$orderIds[] = $order["orderId"];
			}
			//获取涉及的商品
			$sql = "SELECT og.goodsId,og.goodsName,og.goodsThums,og.goodsNums,og.goodsPrice,og.goodsAttrs,og.goodsAttrsName,og.orderId FROM __PREFIX__order_goods og
					WHERE og.orderId in (".implode(',',$orderIds).")";
			$glist = $this->query($sql);
			$goodslist = array();
			for($i=0;$i<count($glist);$i++){
				$goods = $glist[$i];
				$goodslist[$goods["orderId"]][] = $goods;
			}
			//放回分页数据里
			for($i=0;$i<count($orderList);$i++){
				$order = $orderList[$i];
				$order["goodslist"] = $goodslist[$order['orderId']];
				$pages["root"][$i] = $order;
			}
		}
		return $pages;
	}

	/**
	 * 获取待付款订单
	 */
	public function queryPayByPage($obj){
		$userId = (int)$obj["userId"];
		$orderNo = WSTAddslashes(I("orderNo"));
		$orderStatus = (int)I("orderStatus",0);
		$goodsName = WSTAddslashes(I("goodsName"));
		$shopName = WSTAddslashes(I("shopName"));
		$userName = WSTAddslashes(I("userName"));
		$pcurr = (int)I("pcurr",0);
		
		$sql = "SELECT o.orderId,o.orderNo,o.shopId,o.orderunique,o.orderStatus,o.userName,o.totalMoney,o.realTotalMoney,o.needPay,o.deliverMoney,
		        o.createTime,o.payType,o.isRefund,o.isAppraises,sp.shopName 
		        FROM __PREFIX__orders o,__PREFIX__shops sp 
		        WHERE o.userId = $userId AND o.orderStatus =-2 AND o.isPay = 0 AND needPay >0 AND (o.payType = 1 OR o.payType = 3) AND o.shopId=sp.shopId ";
		if($orderNo!=""){
			$sql .= " AND o.orderNo like '%$orderNo%'";
		}
		if($userName!=""){
			$sql .= " AND o.userName like '%$userName%'";
		}
		if($shopName!=""){
			$sql .= " AND sp.shopName like '%$shopName%'";
		}
		$sql .= " order by o.orderId desc";
		$pages = $this->pageQuery($sql,$pcurr);	
		$orderList = $pages["root"];
		if(count($orderList)>0){
			$orderIds = array();
			for($i=0;$i<count($orderList);$i++){
				$order = $orderList[$i];
				$orderIds[] = $order["orderId"];
			}
			//获取涉及的商品
			$sql = "SELECT og.goodsId,og.goodsName,og.goodsThums,og.goodsNums,og.goodsPrice,og.goodsAttrs,og.goodsAttrsName,og.orderId FROM __PREFIX__order_goods og
					WHERE og.orderId in (".implode(',',$orderIds).")";
			$glist = $this->query($sql);
			$goodslist = array();
			for($i=0;$i<count($glist);$i++){
				$goods = $glist[$i];
				$goodslist[$goods["orderId"]][] = $goods;
			}
			//放回分页数据里
			for($i=0;$i<count($orderList);$i++){
				$order = $orderList[$i];
				$order["goodslist"] = $goodslist[$order['orderId']];
				$pages["root"][$i] = $order;
			}
		}
		return $pages;
	}
	
	
	
	/**
	 * 获取待确认收货
	 */
	public function queryReceiveByPage($obj){
		$userId = (int)$obj["userId"];
		$orderNo = WSTAddslashes(I("orderNo"));
		$orderStatus = (int)I("orderStatus",0);
		$goodsName = WSTAddslashes(I("goodsName"));
		$shopName = WSTAddslashes(I("shopName"));
		$userName = WSTAddslashes(I("userName"));
		$pcurr = (int)I("pcurr",0);

		$sql = "SELECT o.orderId,o.orderNo,o.shopId,o.orderStatus,o.userName,o.totalMoney,o.realTotalMoney,
		        o.createTime,o.payType,o.isRefund,o.isAppraises,sp.shopName 
		        FROM __PREFIX__orders o,__PREFIX__shops sp WHERE o.userId = $userId AND o.orderStatus =3 AND o.shopId=sp.shopId ";
		if($orderNo!=""){
			$sql .= " AND o.orderNo like '%$orderNo%'";
		}
		if($userName!=""){
			$sql .= " AND o.userName like '%$userName%'";
		}
		if($shopName!=""){
			$sql .= " AND sp.shopName like '%$shopName%'";
		}
		$sql .= " order by o.orderId desc";
		$pages = $this->pageQuery($sql,$pcurr);	
		$orderList = $pages["root"];
		if(count($orderList)>0){
			$orderIds = array();
			for($i=0;$i<count($orderList);$i++){
				$order = $orderList[$i];
				$orderIds[] = $order["orderId"];
			}
			//获取涉及的商品
			$sql = "SELECT og.goodsId,og.goodsName,og.goodsThums,og.goodsNums,og.goodsPrice,og.goodsAttrs,og.goodsAttrsName,og.orderId FROM __PREFIX__order_goods og
					WHERE og.orderId in (".implode(',',$orderIds).")";
			$glist = $this->query($sql);
			$goodslist = array();
			for($i=0;$i<count($glist);$i++){
				$goods = $glist[$i];
				$goodslist[$goods["orderId"]][] = $goods;
			}
			//放回分页数据里
			for($i=0;$i<count($orderList);$i++){
				$order = $orderList[$i];
				$order["goodslist"] = $goodslist[$order['orderId']];
				$pages["root"][$i] = $order;
			}
		}
		return $pages;
	}
    /**
	 * 获取待发货订单
	 */
	public function queryDeliveryByPage($obj){
		$userId = (int)$obj["userId"];
		$orderNo = WSTAddslashes(I("orderNo"));
		$orderStatus = (int)I("orderStatus",0);
		$goodsName = WSTAddslashes(I("goodsName"));
		$shopName = WSTAddslashes(I("shopName"));
		$userName = WSTAddslashes(I("userName"));
		$pcurr = (int)I("pcurr",0);
		$sql = "SELECT o.orderId,o.orderNo,o.shopId,o.orderStatus,o.userName,o.totalMoney,o.realTotalMoney,
		        o.createTime,o.payType,o.isRefund,o.isAppraises,sp.shopName 
		        FROM __PREFIX__orders o,__PREFIX__shops sp 
		        WHERE o.userId = $userId AND o.orderStatus in ( 0,1,2 ) AND o.shopId=sp.shopId ";
		if($orderNo!=""){
			$sql .= " AND o.orderNo like '%$orderNo%'";
		}
		if($userName!=""){
			$sql .= " AND o.userName like '%$userName%'";
		}
		if($shopName!=""){
			$sql .= " AND sp.shopName like '%$shopName%'";
		}
		$sql .= " order by o.orderId desc";
		$pages = $this->pageQuery($sql,$pcurr);
       	
		$orderList = $pages["root"];
		if(count($orderList)>0){
			$orderIds = array();
			for($i=0;$i<count($orderList);$i++){
				$order = $orderList[$i];
				$orderIds[] = $order["orderId"];
			}
			//获取涉及的商品
	        $sql = "SELECT og.goodsId,og.goodsName,og.goodsThums,og.goodsNums,og.goodsPrice,og.goodsAttrs,og.goodsAttrsName,og.orderId FROM __PREFIX__order_goods og
					WHERE og.orderId in (".implode(',',$orderIds).")";	
			$glist = $this->query($sql);
			$goodslist = array();
			for($i=0;$i<count($glist);$i++){
				$goods = $glist[$i];
				$goodslist[$goods["orderId"]][] = $goods;
			}
			//放回分页数据里
			for($i=0;$i<count($orderList);$i++){
				$order = $orderList[$i];
				$order["goodslist"] = $goodslist[$order['orderId']];
				$pages["root"][$i] = $order;
			}
		}
		return $pages;
	}
    /**
	 * 获取退款
	 */
	public function queryRefundByPage($obj){
		$userId = (int)$obj["userId"];
		$orderNo = WSTAddslashes(I("orderNo"));
		$orderStatus = (int)I("orderStatus",0);
		$goodsName = WSTAddslashes(I("goodsName"));
		$shopName = WSTAddslashes(I("shopName"));
		$userName = WSTAddslashes(I("userName"));
		$sdate = WSTAddslashes(I("sdate"));
		$edate = WSTAddslashes(I("edate"));
		$pcurr = (int)I("pcurr",0);
		//必须是在线支付的才允许退款

		$sql = "SELECT o.orderId,o.orderNo,o.shopId,o.orderStatus,o.userName,o.totalMoney,o.realTotalMoney,
		        o.createTime,o.payType,o.isRefund,o.isAppraises,sp.shopName ,oc.complainId
		        FROM __PREFIX__orders o left join __PREFIX__order_complains oc on oc.orderId=o.orderId,__PREFIX__shops sp 
		        WHERE o.userId = $userId AND (o.orderStatus in (-3,-4,-5) or (o.orderStatus in (-1,-4,-6,-7) and payType =1 AND o.isPay =1)) AND o.shopId=sp.shopId ";
		if($orderNo!=""){
			$sql .= " AND o.orderNo like '%$orderNo%'";
		}
		if($userName!=""){
			$sql .= " AND o.userName like '%$userName%'";
		}
		if($shopName!=""){
			$sql .= " AND sp.shopName like '%$shopName%'";
		}
		$sql .= " order by o.orderId desc";
		$pages = $this->pageQuery($sql,$pcurr);	
		$orderList = $pages["root"];
		if(count($orderList)>0){
			$orderIds = array();
			for($i=0;$i<count($orderList);$i++){
				$order = $orderList[$i];
				$orderIds[] = $order["orderId"];
			}
			//获取涉及的商品
			$sql = "SELECT og.goodsId,og.goodsName,og.goodsThums,og.goodsNums,og.goodsPrice,og.goodsAttrs,og.goodsAttrsName,og.orderId FROM __PREFIX__order_goods og
					WHERE og.orderId in (".implode(',',$orderIds).")";
			$glist = $this->query($sql);
			$goodslist = array();
			for($i=0;$i<count($glist);$i++){
				$goods = $glist[$i];
				$goodslist[$goods["orderId"]][] = $goods;
			}
			//放回分页数据里
			for($i=0;$i<count($orderList);$i++){
				$order = $orderList[$i];
				$order["goodslist"] = $goodslist[$order['orderId']];
				$pages["root"][$i] = $order;
			}
		}
		return $pages;
	}
	
	/**
	 * 获取取消的订单
	 */
	public function queryCancelOrders($obj){
		$userId = (int)$obj["userId"];
		$orderNo = WSTAddslashes(I("orderNo"));
		$orderStatus = (int)I("orderStatus",0);
		$goodsName = WSTAddslashes(I("goodsName"));
		$shopName = WSTAddslashes(I("shopName"));
		$userName = WSTAddslashes(I("userName"));
		$pcurr = (int)I("pcurr",0);

		$sql = "SELECT o.orderId,o.orderNo,o.shopId,o.orderStatus,o.userName,o.totalMoney,o.realTotalMoney,
		        o.createTime,o.payType,o.isRefund,o.isAppraises,sp.shopName 
		        FROM __PREFIX__orders o,__PREFIX__shops sp 
		        WHERE o.userId = $userId AND o.orderStatus in (-1,-6,-7,-3,-5,-4) AND o.shopId=sp.shopId ";
		if($orderNo!=""){
			$sql .= " AND o.orderNo like '%$orderNo%'";
		}
		if($userName!=""){
			$sql .= " AND o.userName like '%$userName%'";
		}
		if($shopName!=""){
			$sql .= " AND sp.shopName like '%$shopName%'";
		}
		$sql .= " order by o.orderId desc";
		$pages = $this->pageQuery($sql,$pcurr);	
		$orderList = $pages["root"];
		if(count($orderList)>0){
			$orderIds = array();
			for($i=0;$i<count($orderList);$i++){
				$order = $orderList[$i];
				$orderIds[] = $order["orderId"];
			}
			//获取涉及的商品
			$sql = "SELECT og.goodsId,og.goodsName,og.goodsThums,og.goodsNums,og.goodsPrice,og.goodsAttrs,og.goodsAttrsName,og.orderId FROM __PREFIX__order_goods og
					WHERE og.orderId in (".implode(',',$orderIds).")";
			$glist = $this->query($sql);
			$goodslist = array();
			for($i=0;$i<count($glist);$i++){
				$goods = $glist[$i];
				$goodslist[$goods["orderId"]][] = $goods;
			}
			//放回分页数据里
			for($i=0;$i<count($orderList);$i++){
				$order = $orderList[$i];
				$order["goodslist"] = $goodslist[$order['orderId']];
				$pages["root"][$i] = $order;
			}
		}
		return $pages;
	}
	
	/**
	 * 获取待评价交易
	 */
	public function queryAppraiseByPage($obj){
		$userId = (int)$obj["userId"];
		$orderNo = WSTAddslashes(I("orderNo"));
		$goodsName = WSTAddslashes(I("goodsName"));
		$shopName = WSTAddslashes(I("shopName"));
		$userName = WSTAddslashes(I("userName"));
		$pcurr = (int)I("pcurr",0);
		$sql = "SELECT o.orderId,o.orderNo,o.shopId,o.orderStatus,o.userName,o.totalMoney,o.realTotalMoney,
		        o.createTime,o.payType,o.isRefund,o.isAppraises,sp.shopName ,oc.complainId
		        FROM __PREFIX__orders o left join __PREFIX__order_complains oc on oc.orderId=o.orderId,__PREFIX__shops sp WHERE o.userId = $userId AND o.shopId=sp.shopId ";	
		if($orderNo!=""){
			$sql .= " AND o.orderNo like '%$orderNo%'";
		}
		if($userName!=""){
			$sql .= " AND o.userName like '%$userName%'";
		}
		if($shopName!=""){
			$sql .= " AND sp.shopName like '%$shopName%'";
		}
		$sql .= " AND o.orderStatus = 4";
		$sql .= " order by o.orderId desc";
		$pages = $this->pageQuery($sql,$pcurr);	
		$orderList = $pages["root"];
		if(count($orderList)>0){
			$orderIds = array();
			for($i=0;$i<count($orderList);$i++){
				$order = $orderList[$i];
				$orderIds[] = $order["orderId"];
			}
			//获取涉及的商品
			$sql = "SELECT og.goodsId,og.goodsName,og.goodsThums,og.goodsNums,og.goodsPrice,og.goodsAttrs,og.goodsAttrsName,og.orderId FROM __PREFIX__order_goods og
					WHERE og.orderId in (".implode(',',$orderIds).")";
			$glist = $this->query($sql);
			$goodslist = array();
			for($i=0;$i<count($glist);$i++){
				$goods = $glist[$i];
				$goodslist[$goods["orderId"]][] = $goods;
			}
			//放回分页数据里
			for($i=0;$i<count($orderList);$i++){
				$order = $orderList[$i];
				$order["goodslist"] = $goodslist[$order['orderId']];
				$pages["root"][$i] = $order;
			}
		}
		return $pages;
	}
	/**
	 * 取消订单
	 */
	public function orderCancel($obj){		
		$userId = (int)$obj["userId"];
		$orderId = (int)$obj["orderId"];
		$rsdata = array('status'=>-1);
		//判断订单状态，只有符合状态的订单才允许改变
		$sql = "SELECT orderId,orderNo,orderStatus,useScore FROM __PREFIX__orders WHERE orderId = $orderId and orderFlag = 1 and userId=".$userId;		
		$rsv = $this->queryRow($sql);
		$cancelStatus = array(0,1,2,-2);//未受理,已受理,打包中,待付款订单
		if(!in_array($rsv["orderStatus"], $cancelStatus))return $rsdata;
		//如果是未受理和待付款的订单直接改为"用户取消【受理前】"，已受理和打包中的则要改成"用户取消【受理后-商家未知】"，后者要给商家知道有这么一回事，然后再改成"用户取消【受理后-商家已知】"的状态
		$orderStatus = -6;//取对商家影响最小的状态
		if($rsv["orderStatus"]==0 || $rsv["orderStatus"]==-2)$orderStatus = -1;
		if($orderStatus==-6 && I('rejectionRemarks')=='')return $rsdata;//如果是受理后取消需要有原因
		$sql = "UPDATE __PREFIX__orders set orderStatus = ".$orderStatus." WHERE orderId = $orderId and userId=".$userId;	
		$rs = $this->execute($sql);
		M("order_level")->where(array('orderId' => $orderId))->save(array('orderStatus' => $orderStatus)); //更新分成订单状态
		$sql = "select ord.deliverType, ord.orderId, og.goodsId ,og.goodsId, og.goodsNums 
				from __PREFIX__orders ord , __PREFIX__order_goods og 
				WHERE ord.orderId = og.orderId AND ord.orderId = $orderId";
		$ogoodsList = $this->query($sql);
		//获取商品库存
		for($i=0;$i<count($ogoodsList);$i++){
			$sgoods = $ogoodsList[$i];
			$sql="update __PREFIX__goods set goodsStock=goodsStock+".$sgoods['goodsNums']." where goodsId=".$sgoods["goodsId"];
			$this->execute($sql);
		}
		$sql="Delete From __PREFIX__order_reminds where orderId=".$orderId." AND remindType=0";
		$this->execute($sql);
		
		if($rsv["useScore"]>0){
			$sql = "UPDATE __PREFIX__users set userScore=userScore+".$rsv["useScore"]." WHERE userId=".$userId;
			$this->execute($sql);
			
			$data = array();
			$m = M('user_score');
			$data["userId"] = $userId;
			$data["score"] = $rsv["useScore"];
			$data["dataSrc"] = 3;
			$data["dataId"] = $orderId;
			$data["dataRemarks"] = "取消订单返还";
			$data["scoreType"] = 1;
			$data["createTime"] = date('Y-m-d H:i:s');
			$m->add($data);
		}
		$data = array();
		$m = M('log_orders');
		$data["orderId"] = $orderId;
		$data["logContent"] = "用户已取消订单".(($orderStatus==-6)?"：".I('rejectionRemarks'):"");
		$data["logUserId"] = $userId;
		$data["logType"] = 0;
		$data["logTime"] = date('Y-m-d H:i:s');
		$ra = $m->add($data);
		$rsdata["status"] = $ra;
		return $rsdata;
	}


	/**
	 * 取消待付款订单
	 */
	public function orderCancelunique($obj){
		$userId = (int)$obj["userId"];
		$orderunique = (int)$obj["orderunique"];
		$rsdata = array('status'=>-1);
		//判断订单状态，只有符合状态的订单才允许改变
		$sql = "SELECT orderId,orderNo,orderStatus,useScore FROM __PREFIX__orders WHERE orderunique = $orderunique and orderFlag = 1 and userId=".$userId;
		$rsv = $this->query($sql);
		foreach($rsv as $key=>$val){
			$orderId = $val['orderId'];
			$cancelStatus = array(0,1,2,-2);//未受理,已受理,打包中,待付款订单
			if(!in_array($val["orderStatus"], $cancelStatus))return $rsdata;
			//如果是未受理和待付款的订单直接改为"用户取消【受理前】"，已受理和打包中的则要改成"用户取消【受理后-商家未知】"，后者要给商家知道有这么一回事，然后再改成"用户取消【受理后-商家已知】"的状态
			$orderStatus = -6;//取对商家影响最小的状态
			if($val["orderStatus"]==0 || $val["orderStatus"]==-2)$orderStatus = -1;
			if($orderStatus==-6 && I('rejectionRemarks')=='')return $rsdata;//如果是受理后取消需要有原因
			$sql = "UPDATE __PREFIX__orders set orderStatus = ".$orderStatus." WHERE orderId = $orderId and userId=".$userId;
			$rs = $this->execute($sql);
			M("order_level")->where(array('orderId' => $orderId))->save(array('orderStatus' => $orderStatus)); //更新分成订单状态

			$sql = "select ord.deliverType, ord.orderId, og.goodsId ,og.goodsId, og.goodsNums
					from __PREFIX__orders ord , __PREFIX__order_goods og
					WHERE ord.orderId = og.orderId AND ord.orderId = $orderId";
			$ogoodsList = $this->query($sql);
			//获取商品库存
			for($i=0;$i<count($ogoodsList);$i++){
				$sgoods = $ogoodsList[$i];
				$sql="update __PREFIX__goods set goodsStock=goodsStock+".$sgoods['goodsNums']." where goodsId=".$sgoods["goodsId"];
				$this->execute($sql);
			}
			$sql="Delete From __PREFIX__order_reminds where orderId=".$orderId." AND remindType=0";
			$this->execute($sql);

			if($val["useScore"]>0){
				$sql = "UPDATE __PREFIX__users set userScore=userScore+".$val["useScore"]." WHERE userId=".$userId;
				$this->execute($sql);

				$data = array();
				$m = M('user_score');
				$data["userId"] = $userId;
				$data["score"] = $val["useScore"];
				$data["dataSrc"] = 3;
				$data["dataId"] = $orderId;
				$data["dataRemarks"] = "取消订单返还";
				$data["scoreType"] = 1;
				$data["createTime"] = date('Y-m-d H:i:s');
				$m->add($data);
			}
			$data = array();
			$m = M('log_orders');
			$data["orderId"] = $orderId;
			$data["logContent"] = "用户已取消订单".(($orderStatus==-6)?"：".I('rejectionRemarks'):"");
			$data["logUserId"] = $userId;
			$data["logType"] = 0;
			$data["logTime"] = date('Y-m-d H:i:s');
			$ra = $m->add($data);
			$rsdata["status"] = $ra;
		}
		return $rsdata;
	}
	/**
	 * 用户确认收货
	 */
	public function orderConfirm ($obj){
		$userId = (int)$obj["userId"];
		$orderId = (int)$obj["orderId"];
		$type = (int)$obj["type"];
		$rsdata = array();
		$sql = "SELECT orderId,orderNo,orderScore,orderStatus,poundageRate,poundageMoney,shopId,useScore,scoreMoney FROM __PREFIX__orders WHERE orderId = $orderId and userId=".$userId;
		$rsv = $this->queryRow($sql);
		if($rsv["orderStatus"]!=3){
			$rsdata["status"] = -1;
			return $rsdata;
		}
        //收货则给用户增加积分
        if($type==1){
        	$sql = "UPDATE __PREFIX__orders set orderStatus = 4,receiveTime='".date("Y-m-d H:i:s")."'  WHERE orderId = $orderId and userId=".$userId;
        	$rs = $this->execute($sql);
			M("order_level")->where(array('orderId' => $orderId))->save(array('orderStatus' => 4)); //更新分成订单状态
        	//修改商品销量
        	$sql = "UPDATE __PREFIX__goods g, __PREFIX__order_goods og, __PREFIX__orders o SET g.saleCount=g.saleCount+og.goodsNums WHERE g.goodsId= og.goodsId AND og.orderId = o.orderId AND o.orderId=$orderId AND o.userId=".$userId;
        	$rs = $this->execute($sql);

        	//修改积分
        	if($GLOBALS['CONFIG']['isOrderScore']==1){
	        	$sql = "UPDATE __PREFIX__users set userScore=userScore+".$rsv["orderScore"].",userTotalScore=userTotalScore+".$rsv["orderScore"]." WHERE userId=".$userId;
	        	$rs = $this->execute($sql);

	        	$data = array();
	        	$m = M('user_score');
	        	$data["userId"] = $userId;
	        	$data["score"] = $rsv["orderScore"];
	        	$data["dataSrc"] = 1;
	        	$data["dataId"] = $orderId;
	        	$data["dataRemarks"] = "交易获得";
	        	$data["scoreType"] = 1;
	        	$data["createTime"] = date('Y-m-d H:i:s');
	        	$m->add($data);
        	}
        	//积分支付支出
        	if($rsv["scoreMoney"]>0){
        		$data = array();
        		$m = M('log_sys_moneys');
        		$data["targetType"] = 0;
        		$data["targetId"] = $userId;
        		$data["dataSrc"] = 2;
        		$data["dataId"] = $orderId;
        		$data["moneyRemark"] = "订单【".$rsv["orderNo"]."】支付 ".$rsv["useScore"]." 个积分，支出 ￥".$rsv["scoreMoney"];
        		$data["moneyType"] = 2;
        		$data["money"] = $rsv["scoreMoney"];
        		$data["createTime"] = date('Y-m-d H:i:s');
        		$data["dataFlag"] = 1;
        		$m->add($data);
        	}
        	//收取订单佣金
        	if($rsv["poundageMoney"]>0){
        		$data = array();
        		$m = M('log_sys_moneys');
        		$data["targetType"] = 1;
        		$data["targetId"] = $rsv["shopId"];
        		$data["dataSrc"] = 1;
        		$data["dataId"] = $orderId;
        		$data["moneyRemark"] = "收取订单【".$rsv["orderNo"]."】".$rsv["poundageRate"]."%的佣金 ￥".$rsv["poundageMoney"];
        		$data["moneyType"] = 1;
        		$data["money"] = $rsv["poundageMoney"];
        		$data["createTime"] = date('Y-m-d H:i:s');
        		$data["dataFlag"] = 1;
        		$m->add($data);
        	}

        }else{
        	if(I('rejectionRemarks')=='')return $rsdata;//如果是拒收的话需要填写原因
        	$sql = "UPDATE __PREFIX__orders set orderStatus = -3 WHERE orderId = $orderId and userId=".$userId;
			M("order_level")->where(array('orderId' => $orderId))->save(array('orderStatus' => -3)); //更新分成订单状态
        	$rs = $this->execute($sql);
        }
        //增加记录
		$data = array();
		$m = M('log_orders');
		$data["orderId"] = $orderId;
		$data["logContent"] = ($type==1)?"用户已收货":"用户拒收：".I('rejectionRemarks');
		$data["logUserId"] = $userId;
		$data["logType"] = 0;
		$data["logTime"] = date('Y-m-d H:i:s');
		$ra = $m->add($data);
		$rsdata["status"] = $ra;;
		return $rsdata;
	}
	
    /**
     * 获取订单详情
     */
	public function getOrderDetails($obj){
		$userId = (int)$obj["userId"];
		$shopId = (int)$obj["shopId"];
		$orderId = (int)$obj["orderId"];
		$data = array();
		$sql = "SELECT * FROM __PREFIX__orders WHERE orderId = $orderId and (userId=".$userId." or shopId=".$shopId.")";	
		$order = $this->queryRow($sql);
		if(empty($order))return $data;
		$data["order"] = $order;
		$sql = "select og.orderId, og.goodsId ,g.goodsSn, og.goodsNums, og.goodsName , og.goodsPrice shopPrice,og.goodsThums,og.goodsAttrName,og.goodsAttrsName
				from __PREFIX__goods g , __PREFIX__order_goods og 
				WHERE g.goodsId = og.goodsId AND og.orderId = $orderId";
		$goods = $this->query($sql);
		$data["goodsList"] = $goods;
		
		for($i=0;$i<count($ogoodsList);$i++){
			$sgoods = $ogoodsList[$i];
			$sql="update __PREFIX__goods set goodsStock=goodsStock+".$sgoods['goodsNums']." where goodsId=".$sgoods["goodsId"];
			$this->execute($sql);
		}
		
		$sql = "SELECT * FROM __PREFIX__log_orders WHERE orderId = $orderId ";	
		$logs = $this->query($sql);
		$data["logs"] = $logs;
		
		return $data;
		
	}
	/**
	 * 获取用户指定状态的订单数目
	 * 2代发货
	 * 3配送中
	 */
	public function getUserOrderStatusCount($obj){
		$userId = (int)$obj["userId"];
		$data = array();
		$sql = "select orderStatus,COUNT(*) cnt from __PREFIX__orders WHERE orderStatus in (0,1,2,3) and orderFlag=1 and userId = $userId GROUP BY orderStatus";
		$olist = $this->query($sql);
		$data = array('-3'=>0,'-2'=>0,'2'=>0,'3'=>0,'4'=>0);
		for($i=0;$i<count($olist);$i++){
			$row = $olist[$i];
			if($row["orderStatus"]==0 || $row["orderStatus"]==1 || $row["orderStatus"]==2){
				$row["orderStatus"] = 2; //
			}
			$data[$row["orderStatus"]] = $data[$row["orderStatus"]]+$row["cnt"];
		}
		//获取未支付订单
		$sql = "select COUNT(*) cnt from __PREFIX__orders WHERE orderStatus = -2 and isRefund=0 and (payType=1 OR payType=3) and orderFlag=1 and isPay = 0 and needPay >0 and userId = $userId";
		$olist = $this->query($sql);
		$data[-2] = $olist[0]['cnt'];
		
		//获取退款订单
		$sql = "select COUNT(*) cnt from __PREFIX__orders WHERE orderStatus in (-3,-4,-6,-7) and isRefund=0 and payType=1 and orderFlag=1 and userId = $userId";
		$olist = $this->query($sql);
		$data[-3] = $olist[0]['cnt'];
		//获取待评价订单
		$sql = "select COUNT(*) cnt from __PREFIX__orders WHERE orderStatus =4 and isAppraises=0 and orderFlag=1 and userId = $userId";
		$olist = $this->query($sql);
		$data[4] = $olist[0]['cnt'];
		
		//获取商城信息
		$sql = "select count(*) cnt from __PREFIX__messages WHERE  receiveUserId=".$userId." and msgStatus=0 and msgFlag=1 ";
		$olist = $this->query($sql);
		$data[100000] = empty($olist)?0:$olist[0]['cnt'];
		
		return $data;
		
	}
	
	/**
	 * 获取用户指定状态的订单数目
	 */
	public function getShopOrderStatusCount($obj){
		$shopId = (int)$obj["shopId"];
		$rsdata = array();
		//待受理订单
		$sql = "SELECT COUNT(*) cnt FROM __PREFIX__orders WHERE shopId = $shopId AND orderStatus = 0 ";
		$olist = $this->queryRow($sql);
		$rsdata[0] = $olist['cnt'];
		
		//取消-商家未知的 / 拒收订单
		$sql = "SELECT COUNT(*) cnt FROM __PREFIX__orders WHERE shopId = $shopId AND orderStatus in (-3,-6)";
		$olist = $this->queryRow($sql);
		$rsdata[5] = $olist['cnt'];
		$rsdata[100] = $rsdata[0]+$rsdata[5];
		
		//获取商城信息
		$sql = "select count(*) cnt from __PREFIX__messages WHERE  receiveUserId=".(int)$obj["userId"]." and msgStatus=0 and msgFlag=1 ";
		$olist = $this->query($sql);
		$rsdata[100000] = empty($olist)?0:$olist[0]['cnt'];
		
		return $rsdata;
	
	}
	
	
	/**
	 * 获取商家订单列表
	 */
	public function queryShopOrders($obj){		
		$userId = (int)$obj["userId"];
		$shopId = (int)$obj["shopId"];
		$pcurr = (int)I("pcurr",0);
		$orderStatus = (int)I("statusMark");
		
		$orderNo = WSTAddslashes(I("orderNo"));
		$userName = WSTAddslashes(I("userName"));
		$userAddress = WSTAddslashes(I("userAddress"));
		$rsdata = array();
		$sql = "SELECT orderNo,orderId,userId,userName,userAddress,totalMoney,realTotalMoney,orderStatus,createTime FROM __PREFIX__orders WHERE shopId = $shopId ";
		if($orderStatus==5){
			$sql.=" AND orderStatus in (-3,-4,-5,-6,-7)";
		}else{
			$sql.=" AND orderStatus = $orderStatus ";	
		}
		if($orderNo!=""){
			$sql .= " AND orderNo like '%$orderNo%'";
		}
		if($userName!=""){
			$sql .= " AND userName like '%$userName%'";
		}
		if($userAddress!=""){
			$sql .= " AND userAddress like '%$userAddress%'";
		}
		$sql.=" order by orderId desc ";
		$data = $this->pageQuery($sql,$pcurr);
		//获取取消/拒收原因
		$orderIds = array();
		$noReadrderIds = array();
		foreach ($data['root'] as $key => $v){	
			if($v['orderStatus']==-6)$noReadrderIds[] = $v['orderId'];
			$sql = "select logContent from __PREFIX__log_orders where orderId =".$v['orderId']." and logType=0 and logUserId=".$v['userId']." order by logId desc limit 1";
			$ors = $this->query($sql);
			$data['root'][$key]['rejectionRemarks'] = $ors[0]['logContent'];
		}
		
		//要对用户取消【-6】的状态进行处理,表示这一条取消信息商家已经知道了
		if($orderStatus==5 && count($noReadrderIds)>0){
			$sql = "UPDATE __PREFIX__orders set orderStatus=-7 WHERE shopId = $shopId AND orderId in (".implode(',',$noReadrderIds).")AND orderStatus = -6 ";
			$this->execute($sql);
		}
		return $data;
	}
	
	/**
	 * 商家受理订单-只能受理【未受理】的订单
	 */
	public function shopOrderAccept ($obj){		
		$userId = (int)$obj["userId"];
		$orderId = (int)$obj["orderId"];
		$shopId = (int)$obj["shopId"];
		$rsdata = array();
		$sql = "SELECT orderId,orderNo,orderStatus FROM __PREFIX__orders WHERE orderId = $orderId AND orderFlag=1 and shopId=".$shopId;		
		$rsv = $this->queryRow($sql);
		if($rsv["orderStatus"]!=0){
			$rsdata["status"] = -1;
			return $rsdata;
		}

		$sql = "UPDATE __PREFIX__orders set orderStatus = 1 WHERE orderId = $orderId and shopId=".$shopId;		
		$rs = $this->execute($sql);		

		$data = array();
		$m = M('log_orders');
		$data["orderId"] = $orderId;
		$data["logContent"] = "商家已受理订单";
		$data["logUserId"] = $userId;
		$data["logType"] = 0;
		$data["logTime"] = date('Y-m-d H:i:s');
		$ra = $m->add($data);
		$rsdata["status"] = $ra;
		return $rsdata;
	}
	
    /**
	 * 商家批量受理订单-只能受理【未受理】的订单
	 */
	public function batchShopOrderAccept(){		
		$USER = session('WST_USER');
		$userId = (int)$USER["userId"];
		$orderIds = self::formatIn(",", I("orderIds"));
		$shopId = (int)$USER["shopId"];
		if($orderIds=='')return array('status'=>-2);
		$orderIds = explode(',',$orderIds);
		$orderNum = count($orderIds);
		$editOrderNum = 0;
		foreach ($orderIds as $orderId){
			if($orderId=='')continue;//订单号为空则跳过
			$sql = "SELECT orderId,orderNo,orderStatus FROM __PREFIX__orders WHERE orderId = $orderId AND orderFlag=1 and shopId=".$shopId;		
			$rsv = $this->queryRow($sql);
			if($rsv["orderStatus"]!=0)continue;//订单状态不符合则跳过
			$sql = "UPDATE __PREFIX__orders set orderStatus = 1 WHERE orderId = $orderId and shopId=".$shopId;		
			$rs = $this->execute($sql);		
	
			$data = array();
			$m = M('log_orders');
			$data["orderId"] = $orderId;
			$data["logContent"] = "商家已受理订单";
			$data["logUserId"] = $userId;
			$data["logType"] = 0;
			$data["logTime"] = date('Y-m-d H:i:s');
			$ra = $m->add($data);
			$editOrderNum++;
		}
		if($editOrderNum==0)return array('status'=>-1);//没有符合条件的执行操作
		if($editOrderNum<$orderNum)return array('status'=>-2);//只有部分订单符合操作
		return array('status'=>1);
	}
	
	/**
	 * 商家打包订单-只能处理[受理]的订单
	 */
	public function shopOrderProduce ($obj){		
		$userId = (int)$obj["userId"];
		$shopId = (int)$obj["shopId"];
		$orderId = (int)$obj["orderId"];
		$rsdata = array();
		$sql = "SELECT orderId,orderNo,orderStatus FROM __PREFIX__orders WHERE orderId = $orderId AND orderFlag =1 and shopId=".$shopId;		
		$rsv = $this->queryRow($sql);
		if($rsv["orderStatus"]!=1){
			$rsdata["status"] = -1;
			return $rsdata;
		}

		$sql = "UPDATE __PREFIX__orders set orderStatus = 2 WHERE orderId = $orderId and shopId=".$shopId;		
		$rs = $this->execute($sql);		
		$data = array();
		$m = M('log_orders');
		$data["orderId"] = $orderId;
		$data["logContent"] = "订单打包中";
		$data["logUserId"] = $userId;
		$data["logType"] = 0;
		$data["logTime"] = date('Y-m-d H:i:s');
		$ra = $m->add($data);
		$rsdata["status"] = $ra;;
		return $rsdata;
	}
	
    /**
	 * 商家批量打包订单-只能处理[受理]的订单
	 */
	public function batchShopOrderProduce (){		
		$USER = session('WST_USER');
		$userId = (int)$USER["userId"];
		$orderIds = self::formatIn(",", I("orderIds"));
		$shopId = (int)$USER["shopId"];
		if($orderIds=='')return array('status'=>-2);
		$orderIds = explode(',',$orderIds);
		$orderNum = count($orderIds);
		$editOrderNum = 0;
		foreach ($orderIds as $orderId){
			if($orderId=='')continue;//订单号为空则跳过
			$sql = "SELECT orderId,orderNo,orderStatus FROM __PREFIX__orders WHERE orderId = $orderId AND orderFlag =1 and shopId=".$shopId;		
			$rsv = $this->queryRow($sql);
			if($rsv["orderStatus"]!=1)continue;//订单状态不符合则跳过
	
			$sql = "UPDATE __PREFIX__orders set orderStatus = 2 WHERE orderId = $orderId and shopId=".$shopId;		
			$rs = $this->execute($sql);		
			$data = array();
			$m = M('log_orders');
			$data["orderId"] = $orderId;
			$data["logContent"] = "订单打包中";
			$data["logUserId"] = $userId;
			$data["logType"] = 0;
			$data["logTime"] = date('Y-m-d H:i:s');
			$ra = $m->add($data);
			$editOrderNum++;
		}
		if($editOrderNum==0)return array('status'=>-1);//没有符合条件的执行操作
		if($editOrderNum<$orderNum)return array('status'=>-2);//只有部分订单符合操作
		return array('status'=>1);
	}
	
	/**
	 * 商家发货配送订单
	 */
	public function shopOrderDelivery ($obj){		
		$userId = (int)$obj["userId"];
		$orderId = (int)$obj["orderId"];
		$shopId = (int)$obj["shopId"];
		$rsdata = array();
		$sql = "SELECT orderId,orderNo,orderStatus FROM __PREFIX__orders WHERE orderId = $orderId AND orderFlag =1 and shopId=".$shopId;		
		$rsv = $this->queryRow($sql);
		if($rsv["orderStatus"]!=2){
			$rsdata["status"] = -1;
			return $rsdata;
		}

		$sql = "UPDATE __PREFIX__orders set orderStatus = 3,deliveryTime='".date('Y-m-d H:i:s')."' WHERE orderId = $orderId and shopId=".$shopId;		
		$rs = $this->execute($sql);		

		$data = array();
		$m = M('log_orders');
		$data["orderId"] = $orderId;
		$data["logContent"] = "商家已发货";
		$data["logUserId"] = $userId;
		$data["logType"] = 0;
		$data["logTime"] = date('Y-m-d H:i:s');
		$ra = $m->add($data);
		$rsdata["status"] = $ra;;
		return $rsdata;
	}
	
    /**
	 * 商家发货配送订单
	 */
	public function batchShopOrderDelivery ($obj){		
		$USER = session('WST_USER');
		$userId = (int)$USER["userId"];
		$orderIds = self::formatIn(",",I("orderIds"));
		$shopId = (int)$USER["shopId"];
		if($orderIds=='')return array('status'=>-2);
		$orderIds = explode(',',$orderIds);
		$orderNum = count($orderIds);
		$editOrderNum = 0;
		foreach ($orderIds as $orderId){
			if($orderId=='')continue;//订单号为空则跳过
			$sql = "SELECT orderId,orderNo,orderStatus FROM __PREFIX__orders WHERE orderId = $orderId AND orderFlag =1 and shopId=".$shopId;		
			$rsv = $this->queryRow($sql);
			if($rsv["orderStatus"]!=2)continue;//状态不符合则跳过
	
			$sql = "UPDATE __PREFIX__orders set orderStatus = 3,deliveryTime='".date('Y-m-d H:i:s')."' WHERE orderId = $orderId and shopId=".$shopId;		
			$rs = $this->execute($sql);		
	
			$data = array();
			$m = M('log_orders');
			$data["orderId"] = $orderId;
			$data["logContent"] = "商家已发货";
			$data["logUserId"] = $userId;
			$data["logType"] = 0;
			$data["logTime"] = date('Y-m-d H:i:s');
			$ra = $m->add($data);
		    $editOrderNum++;
		}
		if($editOrderNum==0)return array('status'=>-1);//没有符合条件的执行操作
		if($editOrderNum<$orderNum)return array('status'=>-2);//只有部分订单符合操作
		return array('status'=>1);
	}
	
	/**
	 * 商家确认收货
	 */
	public function shopOrderReceipt ($obj){		
		$userId = (int)$obj["userId"];
		$shopId = (int)$obj["shopId"];
		$orderId = (int)$obj["orderId"];
		$rsdata = array();
		$sql = "SELECT orderId,orderNo,orderStatus FROM __PREFIX__orders WHERE orderId = $orderId AND orderFlag =1 and shopId=".$shopId;		
		$rsv = $this->queryRow($sql);
		if($rsv["orderStatus"]!=4){
			$rsdata["status"] = -1;
			return $rsdata;
		}

		$sql = "UPDATE __PREFIX__orders set orderStatus = 5 WHERE orderId = $orderId and shopId=".$shopId;		
		$rs = $this->execute($sql);		

		$data = array();
		$m = M('log_orders');
		$data["orderId"] = $orderId;
		$data["logContent"] = "商家确认已收货，订单完成";
		$data["logUserId"] = $userId;
		$data["logType"] = 0;
		$data["logTime"] = date('Y-m-d H:i:s');
		$ra = $m->add($data);
		$rsdata["status"] = $ra;;
		return $rsdata;
	}
	/**
	 * 商家确认拒收/不同意拒收
	 */
	public function shopOrderRefund ($obj){		
		$userId = (int)$obj["userId"];
		$orderId = (int)$obj["orderId"];
		$shopId = (int)$obj["shopId"];
		$type = (int)I('type');
		$rsdata = array();
		$sql = "SELECT orderId,orderNo,orderStatus,useScore FROM __PREFIX__orders WHERE orderId = $orderId AND orderFlag = 1 and shopId=".$shopId;		
		$rsv = $this->queryRow($sql);
		if($rsv["orderStatus"]!= -3){
			$rsdata["status"] = -1;
			return $rsdata;
		}
		//同意拒收
        if($type==1){
			$sql = "UPDATE __PREFIX__orders set orderStatus = -4 WHERE orderId = $orderId and shopId=".$shopId;		
			$rs = $this->execute($sql);
			//加回库存
			if($rs>0){
				$sql = "SELECT goodsId,goodsNums,goodsAttrId from __PREFIX__order_goods WHERE orderId = $orderId";
				$oglist = $this->query($sql);
				foreach ($oglist as $key => $ogoods) {
					$goodsId = $ogoods["goodsId"];
					$goodsNums = $ogoods["goodsNums"];
					$goodsAttrId = $ogoods["goodsAttrId"];
					$sql = "UPDATE __PREFIX__goods set goodsStock = goodsStock+$goodsNums WHERE goodsId = $goodsId";
					$this->execute($sql);
					if($goodsAttrId>0){
						$sql = "UPDATE __PREFIX__goods_attributes set attrStock = attrStock+$goodsNums WHERE id = $goodsAttrId";
						$this->execute($sql);
					}
				}
				
				if($rsv["useScore"]>0){
					$sql = "UPDATE __PREFIX__users set userScore=userScore+".$rsv["useScore"]." WHERE userId=".$userId;
					$this->execute($sql);
						
					$data = array();
					$m = M('user_score');
					$data["userId"] = $userId;
					$data["score"] = $rsv["useScore"];
					$data["dataSrc"] = 4;
					$data["dataId"] = $orderId;
					$data["dataRemarks"] = "拒收订单返还";
					$data["scoreType"] = 1;
					$data["createTime"] = date('Y-m-d H:i:s');
					$m->add($data);
				}
			}	
        }else{//不同意拒收
        	if(I('rejectionRemarks')=='')return $rsdata;//不同意拒收必须填写原因
        	$sql = "UPDATE __PREFIX__orders set orderStatus = -5 WHERE orderId = $orderId and shopId=".$shopId;		
			$rs = $this->execute($sql);
        }
		$data = array();
		$m = M('log_orders');
		$data["orderId"] = $orderId;
		$data["logContent"] = ($type==1)?"商家同意拒收":"商家不同意拒收：".I('rejectionRemarks');
		$data["logUserId"] = $userId;
		$data["logType"] = 0;
		$data["logTime"] = date('Y-m-d H:i:s');
		$ra = $m->add($data);
		$rsdata["status"] = $ra;;
		return $rsdata;
	}
	
	/**
	 * 检查订单是否已支付
	 */
	public function checkOrderPay ($obj){
		$userId = (int)$obj["userId"];
		$orderId = (int)I("orderId");
		if($orderId>0){
			session("WST_ORDER_UNIQUE",$orderId);
			$sql = "SELECT orderId,orderNo FROM __PREFIX__orders WHERE userId = $userId AND orderunique = '$orderId' AND orderFlag = 1 AND orderStatus = -2 AND isPay = 0 AND (payType = 1 OR payType = 3)";
		}else{
			$orderunique = session("WST_ORDER_UNIQUE");
			$sql = "SELECT orderId,orderNo FROM __PREFIX__orders WHERE userId = $userId AND orderunique = '$orderunique' AND orderFlag = 1 AND orderStatus = -2 AND isPay = 0 AND (payType = 1 OR payType = 3)";
		}
		$rsv = $this->query($sql);
		$oIds = array();
		for($i=0;$i<count($rsv);$i++){
			$oIds[] = $rsv[$i]["orderId"];
		}
		$orderIds = implode(",",$oIds);
		$data = array();
		if(count($rsv)>0){
			//查询商品验证库存是否足够
			$sql = "SELECT og.goodsId,og.goodsName,og.goodsAttrName,g.goodsStock,og.goodsNums, og.goodsAttrId, ga.attrStock FROM  __PREFIX__goods g ,__PREFIX__order_goods og
					left join __PREFIX__goods_attributes ga on ga.goodsId=og.goodsId and og.goodsAttrId=ga.id
					WHERE og.goodsId = g.goodsId and og.orderId in($orderIds)";
			$glist = $this->query($sql);
			if(count($glist)>0){
				$rlist = array();
				foreach ($glist as $goods) {
					if($goods["goodsAttrId"]>0){
						if($goods["attrStock"]<$goods["goodsNums"]){
							$rlist[] = $goods;
						}
					}else{
						if($goods["goodsStock"]<$goods["goodsNums"]){
							$rlist[] = $goods;
						}
					}
				}
				if(count($rlist)>0){
					$data["status"] = -2;
					$data["rlist"] = $rlist;
				}else{
					$data["status"] = 1;
				}
			}else{
				$data["status"] = 1;
			}
		}else{
			$data["status"] = -1;
		}
		return $data;
	}
}