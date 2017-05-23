<?php
 namespace Admin\Model;
/**
 * ============================================================================
 * QianPokMall商城
 * 官网地址:http://www.qianpok.com
 * 联系QQ:376983512
 * ============================================================================
 * 店铺分类服务类
 */
class ShopsCatsModel extends BaseModel {
	 /**
	  * 获取列表
	  */
	  public function queryByList($shopId,$parentId){
		 return $this->where('shopId='.(int)$shopId.' and catFlag=1 and parentId='.(int)$parentId)->select();
	  }
	 
};
?>