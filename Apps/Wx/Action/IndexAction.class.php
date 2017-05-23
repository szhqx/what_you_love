<?php
namespace Wx\Action;
/**
 * ============================================================================
 * qpSHOP商城
 * 官网地址:http://www.qianpok.com
 * 联系QQ:874570326
 * ============================================================================
 * 首页控制器
 */
class IndexAction extends BaseAction {
	/**
	 * 获取首页信息
	 * 
	 */
    public function index(){
   		$ads = D('Wx/Ads');
   		$areaId2 = $this->getDefaultCity();
   		//获取分类
		$gcm = D('Wx/GoodsCats');
		$catList = $gcm->getGoodsCatsAndGoodsForIndex($areaId2);
		//取精品推荐商品
		$jpgoods = array();
		foreach($catList as $key=>$val){
			if(!empty($val['jpgoods'])){
				$jpgoods =	$val['jpgoods'];
			}
			if(!empty($val['hotgoods'])){ //获取商城推荐商品
				$recomgoods =	$val['hotgoods'];
			}
		}
		$this->assign("recomgoods", $recomgoods);
		$this->assign('jpgoods',$jpgoods);
   		$this->assign('ishome',1);

		//活动数据
		$act = D("Activity");
		$this->activity = $act->getActivityList(3);

   		if(I("changeCity")){
   			echo $_SERVER['HTTP_REFERER'];
   		}else{
   			$this->display("index/index");
   		}
		
    }

	public function test(){
		$this->display('index/test');
	}
    /**
     * 广告记数
     */
    public function access(){
    	$ads = D('Home/Ads');
    	$ads->statistics((int)I('id'));
    }
    /**
     * 切换城市
     */
    public function changeCity(){
    	$m = D('Home/Areas');
    	$areaId2 = $this->getDefaultCity();
    	$provinceList = $m->getProvinceList();
    	$cityList = $m->getCityGroupByKey();
    	$area = $m->getArea($areaId2);
    	$this->assign('provinceList',$provinceList);
    	$this->assign('cityList',$cityList);
    	$this->assign('area',$area);
    	$this->assign('areaId2',$areaId2);
    	$this->display("default/change_city");
    }
    /**
     * 跳到用户注册协议
     */
    public function toUserProtocol(){
    	$this->display("default/user_protocol");
    }
    
    /**
     * 修改切换城市ID
     */
    public function reChangeCity(){
    	$this->getDefaultCity();
    }
    
}