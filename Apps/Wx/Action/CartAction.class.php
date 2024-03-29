<?php
namespace Wx\Action;
/**
 * ============================================================================
 * qpSHOP商城
 * 官网地址:http://www.qianpok.com
 * 联系QQ:874570326
 * ============================================================================
 * 购物车控制器
 */
class CartAction extends BaseAction {
	/**
	 * 跳到购物车列表
	 */
    public function toCart(){
   		$m = D('Wx/Cart');
		$cartInfo = $m->getCartInfo();
   		$pnow = (int)I("pnow",0);
   		$this->assign('cartInfo',$cartInfo);
   		$this->display('shop/cart_pay_list');

    }
    
    /**
     * 添加商品到购物车(ajax)
     */
	public function addToCartAjax(){
   		$m = D('Wx/Cart');
   		$res = $m->addToCart();
   		echo "{status:1}";
    }
    /**
     * 修改购物车商品
     * 
     */
    public function changeCartGoods(){
    	$m = D('Wx/Cart');
   		$res = $m->addToCart();
   		echo "{status:1}";
    }
    
	/**
	 * 获取购物车信息
	 * 
	 */
	public function getCartInfo() {
		$m = D('Wx/Cart');
		$cartInfo = $m->getCartInfo();
		$axm = (int)I("axm",0);
		if($axm ==1){
			echo json_encode($cartInfo);
		}else{
			$this->assign('cartInfo',$cartInfo);
			$this->display('shop/cart_pay_list');
		}
		
	}
	
	/**
	 * 获取购物车商品数量
	 */
	public function getCartGoodCnt(){
		$shopcart = session("WST_CART")?session("WST_CART"):array();
		echo json_encode(array("goodscnt"=>count($shopcart)));
	}
    
	/**
	 * 检测购物车中商品库存
	 * 
	 */
	public function checkCartGoodsStock(){
		$m = D('Wx/Cart');
		$res = $m->checkCatGoodsStock();
		echo json_encode($res);

	}
	
	
	
	/**
	 * 删除购物车中的商品
	 * 
	 */
	public function delCartGoods(){	
		$m = D('Wx/Cart');
		$res = $m->delCartGoods();
		echo "{status:1}";
		
	}
	
	/**
	 * 修改购物车中的商品数量
	 * 
	 */
	public function changeCartGoodsNum(){
		$m = D('Wx/Cart');
		$res = $m->changeCartGoodsnum();
		echo "{status:1}";
		
	}
	
	/**
	 *去购物车结算
	 * 
	 */
	public function toCatpaylist(){	
		$m = D('Wx/Cart');
		$cartInfo = $m->getCartInfo();
		$this->assign("cartInfo",$cartInfo);
		
		$this->display('shop/cat_pay_list');
	}
	
}