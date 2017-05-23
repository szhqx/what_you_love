<?php
namespace Wx\Model;
/**
 * ============================================================================
 * QianPokMall商城
 * 官网地址:http://www.qianpok.com
 * 联系QQ:376983512
 * ============================================================================
 * 购物车服务类
 */
class CartModel extends BaseModel {
	protected $tableName = 'goods';
	/**
	 * 添加[正常]商品到购物车
	 */
	public function addToCart(){
		//判断一下该商品是否正常	出售
		$goodsInfo = self::getGoodsInfo((int)I("goodsId"),(int)I("goodsAttrId"));
		//无价格规格
		$attrnoprice = I("attrs");
		if($attrnoprice !='') $attrnoprice = trim($attrnoprice,'-');
		if($goodsInfo['goodsId']=='')return array();
		$goodsInfo["cnt"] = ((int)I("gcount")>0)?(int)I("gcount"):1;
		$goodsInfo["ischk"] = 1;
		$cartgoods = array();
		$totalMoney = 0;
		$cartattrs = $goodsInfo["goodsId"]."_".$goodsInfo["goodsAttrId"]."-".$attrnoprice;
		$USER = session('WST_USER');
		$WST_CART = M('cart')->where('userId='.$USER['userId']." AND cartAttrs='$cartattrs'")->find();
		//如果 购物车为空则放入购物车中
		if(empty($WST_CART)){
			$shopcat = array();
			$shopcat['attrsVal'] =  json_encode($goodsInfo);
			$shopcat['cartAttrs'] = $goodsInfo["goodsId"]."_".$goodsInfo["goodsAttrId"]."-".$attrnoprice;
			$shopcat['userId'] = $USER['userId'];
			M("cart")->add($shopcat);
		}else{
			//存在则修改该属性选中的数量
			$shopcat = array();
			$shopcat = json_decode($WST_CART['attrsVal'],true);
			//如果已经存在则要把数量相加
			$shopcat["cnt"]=$shopcat["cnt"]+$goodsInfo["cnt"];
			M("cart")->where('userId='.$USER['userId']." AND cartAttrs='$cartattrs'")->save(array("attrsVal"=>json_encode($shopcat)));
		}
		$shopcat = array();
		$CART =  M('cart')->where('userId='.$USER['userId'])->select();
		foreach($CART as $key=>$val){
			$shopcat[$val['cartAttrs']] = json_decode($val['attrsVal'],true);
		}
		//重新把购物车内的数据拿到外边
		foreach($shopcat as $key=>$cgoods){
			$totalMoney += $cgoods["cnt"]*$cgoods["shopPrice"];
			$cartgoods[] = $cgoods;

		}

		$cartInfo = array();
		$cartInfo["cartgoods"] = $cartgoods;
		$cartInfo["totalMoney"] = $totalMoney;
		return $cartInfo;
	}
	
	/**
	 * 获取商品信息
	 */
	public function getGoodsInfo($goodsId,$goodsAttrId = 0){
		$sql = "SELECT g.attrCatId,g.goodsId,g.goodsSn,g.goodsName,g.goodsThums,g.shopId,g.marketPrice,g.shopPrice,g.goodsStock,g.bookQuantity,g.isBook,sp.shopName
				FROM __PREFIX__goods g ,__PREFIX__shops sp WHERE g.shopId=sp.shopId AND goodsFlag=1 and isSale=1 and goodsStatus=1 and g.goodsId = $goodsId";
		$goodslist = $this->queryRow($sql);
		//如果商品有价格属性的话则获取其价格属性
		if(!empty($goodslist) && $goodslist['attrCatId']>0){
			$sql = "select ga.id,ga.attrPrice,ga.attrStock,a.attrName,ga.attrVal,ga.attrId from __PREFIX__attributes a,__PREFIX__goods_attributes ga
			        where a.attrId=ga.attrId and a.catId=".$goodslist['attrCatId']." and a.isPriceAttr=1 
			        and ga.goodsId=".$goodslist['goodsId']." and id=".$goodsAttrId;
			$priceAttrs = $this->queryRow($sql);
			if(!empty($priceAttrs)){
				$goodslist['attrId'] = $priceAttrs['attrId'];
				$goodslist['goodsAttrId'] = $priceAttrs['id'];
				$goodslist['attrName'] = $priceAttrs['attrName'];
				$goodslist['attrVal'] = $priceAttrs['attrVal'];
				$goodslist['shopPrice'] = $priceAttrs['attrPrice'];
				$goodslist['goodsStock'] = $priceAttrs['attrStock'];
			}
		}
		$goodslist['goodsAttrId'] = (int)$goodslist['goodsAttrId'];
		return $goodslist;
	}

	
	/**
	 * 获取购物车信息
	 */
	public function getCartInfo(){
		$mgoods = D('Wx/Goods');
		$totalMoney = 0;
		$shopcart = getcart();//session("WST_CART")?session("WST_CART"):array();
		$cartgoods = array();
		foreach($shopcart as $goodsId=>$cgoods){
			$goodsatts = $goodsId;
			$temp = explode('_',$goodsId);
			$goodsId = (int)$temp[0];
			$goodsAttrId = (int)$temp[1];
			$sql = "SELECT  g.goodsThums,g.goodsId,g.shopPrice,g.isBook,g.goodsName,g.shopId,g.goodsStock,g.shopPrice,shop.shopName,shop.qqNo,shop.deliveryType,shop.shopAtive,
					shop.shopTel,shop.shopAddress,shop.deliveryTime,shop.isInvoice, shop.deliveryStartMoney,
					shop.deliveryFreeMoney,shop.deliveryMoney ,g.goodsSn,shop.serviceStartTime,shop.serviceEndTime
					FROM __PREFIX__goods g, __PREFIX__shops shop
					WHERE g.goodsId = $goodsId AND g.shopId = shop.shopId AND g.goodsFlag = 1 and g.isSale=1 and g.goodsStatus=1 ";
			$goods = self::queryRow($sql);
		    //如果商品有价格属性的话则获取其价格属性
		    if(!empty($goods) && $cgoods['attrCatId']>0){
			    $sql = "select ga.id,ga.attrPrice,ga.attrStock,a.attrName,ga.attrVal,ga.attrId from __PREFIX__attributes a,__PREFIX__goods_attributes ga
			             where a.attrId=ga.attrId and a.catId=".$cgoods['attrCatId']." and a.isPriceAttr=1 and ga.attrId=".$cgoods['attrId']." 
			             and ga.goodsId=".$goodsId." and id=".$goodsAttrId;
				$priceAttrs = $this->queryRow($sql);
				if(!empty($priceAttrs)){
					$goods['goodsAttrId'] = $priceAttrs['id'];
					$goods['attrName'] = $priceAttrs['attrName'];
					$goods['attrVal'] = $priceAttrs['attrVal'];
					$goods['shopPrice'] = $priceAttrs['attrPrice'];
					$goods['goodsStock'] = $priceAttrs['attrStock'];
				}
			}
			$goods['goodsAttrId'] = (int)$goods['goodsAttrId'];
			$goods['goodsatts'] = $goodsatts; //新增进去做多规格加减
			
			if($goods["isBook"]==1){
				$goods["goodsStock"] = $goods["goodsStock"]+$goods["bookQuantity"];
			}
			$goods["cnt"] = $cgoods["cnt"];
			$goods["ischk"] = $cgoods["ischk"];
			if($goods["ischk"]==1)$totalMoney += $goods["cnt"]*$goods["shopPrice"];

			if($startTime<$goods["startTime"]){
				$startTime = $goods["startTime"];
			}
			if($endTime>$goods["endTime"]){
				$endTime = $goods["endTime"];
			}
		
			$cartgoods[$goods["shopId"]]["shopgoods"][] = $goods;
			$cartgoods[$goods["shopId"]]["deliveryFreeMoney"] = $goods["deliveryFreeMoney"];//店铺免运费最低金额
			$cartgoods[$goods["shopId"]]["deliveryMoney"] = $goods["deliveryMoney"];//店铺配送费
			$cartgoods[$goods["shopId"]]["deliveryStartMoney"] = $goods["deliveryStartMoney"];//店铺配送费
			$cartgoods[$goods["shopId"]]["totalCnt"] = $cartgoods[$goods["shopId"]]["totalCnt"]+$cgoods["cnt"];
			$cartgoods[$goods["shopId"]]["totalMoney"] = $cartgoods[$goods["shopId"]]["totalMoney"]+(($goods["ischk"]==1)?$goods["cnt"]*$goods["shopPrice"]:0);
		}
		
		foreach($cartgoods as $key=> $cshop){
			if($cshop["totalMoney"]<$cshop["deliveryFreeMoney"]){
				$totalMoney = $totalMoney + $cshop["deliveryMoney"];
			}
		}
		
		$cartInfo = array();
		$cartInfo["totalMoney"] = $totalMoney;
		$cartInfo["cartgoods"] = $cartgoods;
		return $cartInfo;
		
	}
   
	/**
	 * 检测购物车中商品库存
	 */
	public function checkCatGoodsStock(){
		$shopcart = getcart();//session("WST_CART")?session("WST_CART"):array();
		$mgoods = D('Wx/Goods');
		$cartgoods = array();		
		foreach($shopcart as $key=>$cgoods){
			$temp = explode('_',$key);
			$goodsId = (int)$temp[0];
			$goodsAttrId = (int)$temp[1];
			$obj = array();
			$obj["goodsId"] = $goodsId;
			$obj["goodsAttrId"] = $goodsAttrId;
			$goods = $mgoods->getGoodsStock($obj);
			if($goods["isBook"]==1){
				$goods["goodsStock"] = $goods["goodsStock"]+$goods["bookQuantity"];
			}
			$goods['goodsAttrId'] = $goodsAttrId;
			$goods["cnt"] = $cgoods["cnt"];
			$goods["stockStatus"] = ($goods["goodsStock"]>=$goods["cnt"])?1:0;		
			$cartgoods[] = $goods;
		}
		
		return $cartgoods;
		
	}
	
	/**
	 * 删除购物车中的商品
	 */
	public function delCartGoods(){
		$USER = session('WST_USER');
		$goodsKey = I('goodsattr');
		$shopcart = getcart();
		$newShopcat = array();
		foreach($shopcart as $key=>$cgoods){	
			if($goodsKey == $key){
				M('cart')->where('userId='.$USER['userId']." AND cartAttrs='$goodsKey'")->delete();
			}			
		}
		return 1;
		
	}
	
	/**
	 * 修改购物车中的商品数量
	 * 
	 */
	public function changeCartGoodsnum(){
		$USER = session('WST_USER');
		$goodsatts = I("goodsattr");
		$num = abs((int)I("num"));
		$ischk = (int)I("ischk",0);
		$shopcart = getcart();
		//session("WST_CART",null);
		$newShopcart = array();
		foreach($shopcart as $key=>$cgoods){	
			$cartgoods = $shopcart[$key];
			if($goodsatts == $key){
				$cartgoods["cnt"] = $num;
				$cartgoods["ischk"] = $ischk;
			}
			M("cart")->where('userId='.$USER['userId']." AND cartAttrs='$goodsatts'")->save(array("attrsVal"=>json_encode($cartgoods)));
			//$newShopcart[$key] = $cartgoods;
		}
		//session("WST_CART",$newShopcart);
		return 1;
	}
	
}