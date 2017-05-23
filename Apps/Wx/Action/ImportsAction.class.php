<?php
 namespace Home\Action;
/**
 * ============================================================================
 * qpSHOP商城
 * 官网地址:http://www.qianpok.com
 * 联系QQ:874570326
 * ============================================================================
 * 数据导入控制器
 */
class ImportsAction extends BaseAction{
	/**
	 * 数据导入首页
	 */
    public function index(){
    	$this->isShopLogin();
    	$this->assign("umark","Imports");
    	$this->display('default/shops/import');
	}
};
?>