<?php
 namespace Admin\Action;;
/**
 * ============================================================================
 * QianPokMall商城
 * 官网地址:http://www.qianpok.com
 * 联系QQ:376983512
 * ============================================================================
 * 活动分类控制器
 */
class ActivityCatsAction extends BaseAction{
	/**
	 * 跳到新增/编辑页面
	 */
	public function toEdit(){
		$this->isLogin();
	    $m = D('Admin/ActivityCats');
    	$object = array();
    	if(I('id',0)>0){
    		$this->checkPrivelege('hdfl_02');
    		$object = $m->get();
    	}else{
    		$this->checkPrivelege('hdfl_01');
    		$object = $m->getModel();
    		$object['parentId'] = I('parentId',0);
    	}
    	$this->assign('object',$object);
		$this->view->display('/activitycats/edit');
	}
	/**
	 * 新增/修改操作
	 */
	public function edit(){
		$this->isLogin();
		$m = D('Admin/ActivityCats');
    	$rs = array();
    	if(I('id',0)>0){
    		$this->checkPrivelege('hdfl_02');
    		$rs = $m->edit();
    	}else{
    		$this->checkPrivelege('hdfl_01');
    		$rs = $m->insert();
    	}
    	$this->ajaxReturn($rs);
	}
	/**
	 * 修改名称
	 */
	public function editName(){
		$this->isLogin();
		$m = D('Admin/ActivityCats');
    	$rs = array('status'=>-1);
    	if(I('id',0)>0){
    		$this->checkPrivelege('hdfl_02');
    		$rs = $m->editName();
    	}
    	$this->ajaxReturn($rs);
	}
	/**
	 * 删除操作
	 */
	public function del(){
		$this->isLogin();
		$this->checkPrivelege('hdfl_03');
		$m = D('Admin/ActivityCats');
    	$rs = $m->del();
    	$this->ajaxReturn($rs);
	}
	/**
	 * 分页查询
	 */
	public function index(){
		$this->isLogin();
		$this->checkPrivelege('hdfl_00');
		$m = D('Admin/ActivityCats');
    	$list = $m->queryByList(I('parentId',0));
    	$this->assign('List',$list);
        $this->display("/activitycats/list");
	}
	/**
	 * 列表查询
	 */
    public function queryByList(){
    	$this->isLogin();
		$m = D('Admin/ActivityCats');
		$list = $m->queryByList(I('id',0));
		$rs = array();
		$rs['status'] = 1;
		$rs['list'] = $list;
		$this->ajaxReturn($rs);
	}
    /**
	 * 显示分类是否显示/隐藏
	 */
	 public function editiIsShow(){
	 	$this->isLogin();
	 	$this->checkPrivelege('hdfl_02');
	 	$m = D('Admin/ActivityCats');
		$rs = $m->editiIsShow();
		$this->ajaxReturn($rs);
	 }

};
?>