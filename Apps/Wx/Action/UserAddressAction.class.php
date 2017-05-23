<?php
 namespace Wx\Action;;
/**
 * ============================================================================
 * qpSHOP商城
 * 官网地址:http://www.qianpok.com
 * 联系QQ:874570326
 * ============================================================================
 * 会员地址控制器
 */
class UserAddressAction extends BaseAction{
	/**
	 * 跳到新增/编辑页面
	 */
	public function toEdit(){
		$this->isUserLogin();
	    $m = D('Wx/UserAddress');
    	$object = array();
    	if((int)I('id',0)>0){
    		$object = $m->get();
    	}else{
    		$object = $m->getModel();
    	}
		//print_r(I());
    	//获取地区信息
		$m = D('Wx/Areas');
		$this->assign('areaList',$m->getProvinceList());
    	$this->assign('object',$object);
    	$this->assign("umark","addressQueryByPage");
		$this->view->display('/users/address');
	}
	/**
	 * 新增/修改操作
	 */
	public function edit(){
		
		$this->isUserLogin();
		$m = D('Wx/UserAddress');
    	$rs = array();
    	if((int)I('id',0)>0){
    		$rs = $m->edit();
    	}else{
    		$rs = $m->insert();
    	}
    	$this->ajaxReturn($rs);
	}
	/**
	 * 删除操作
	 */
	public function del(){
		$this->isUserLogin();
		$m = D('Wx/UserAddress');
    	$rs = $m->del();
    	$this->ajaxReturn($rs);
	}
	/**
	 * 设默认地址操作
	 */
	public function setdefault(){
		$this->isUserLogin();
		$m = D('Wx/UserAddress');
		$rs = $m->setdefault();
		$this->ajaxReturn($rs);
	}
	/**
	 * 分页查询
	 */
	public function queryByPage(){
		$this->isLogin();
		$USER = session('WST_USER');
		$m = D('Wx/UserAddress');
    	$list = $m->queryByList($USER['userId']);
		//print_r($list);
    	$this->assign('List',$list);
    	$this->assign("umark","addressQueryByPage");
        $this->display("/users/addresslist");
	}
	/**
	 * 获取用户地址
	 */
	public function getUserAddress(){
		$this->isUserLogin();
		$m = D('Wx/UserAddress');
		$address = $m->getUserAddressInfo();	
		$addressInfo = array();
		$addressInfo["status"] = 1;
		$addressInfo["address"] = $address;
		$this->ajaxReturn($addressInfo);	
	}
	
	/**
	 * 获取区县
	 */
	public function getDistricts(){
		
		$m = D('Wx/UserAddress');
		$areaId2 = (int)I("areaId2");
		$communitys = $m->getDistricts($areaId2);	
		$this->ajaxReturn($communitys);
			
	}
	
	/**
	 * 获取社区
	 */
	public function getCommunitys(){
		
		$m = D('Wx/UserAddress');
		$districtId = (int)I("districtId");
		$communitys = $m->getCommunitys($districtId);	
		$this->ajaxReturn($communitys);
			
	}
	
	/**
	 * 获取区县
	 */
	public function getDistrictsOption(){
		
		$m = D('Wx/UserAddress');
		$areaId2 = (int)I("areaId2");
		$communitys = $m->getDistrictsOption($areaId2);	
		$this->ajaxReturn($communitys);
			
	}
	
	/**
	 * 获取社区
	 */
	public function getCommunitysOption(){
		
		$m = D('Wx/UserAddress');
		$districtId = (int)I("districtId");
		$communitys = $m->getCommunitysOption($districtId);	
		$this->ajaxReturn($communitys);
			
	}
	
	/**
	 * 获取店铺配送区县
	 */
	public function getShopDistricts(){
	
		$m = D('Wx/UserAddress');
		$areaId2 = (int)I("areaId2");
		$shopId = (int)I("shopId");
		$communitys = $m->getShopDistricts($areaId2,$shopId);
		$this->ajaxReturn($communitys);
			
	}
	
	/**
	 * 获取店铺配送社区
	 */
	public function getShopCommunitys(){
	
		$m = D('Wx/UserAddress');
		$districtId = (int)I("districtId");
		$shopId = (int)I("shopId");
		$communitys = $m->getShopCommunitys($districtId,$shopId);
		$this->ajaxReturn($communitys);
			
	}
	
};
?>