<?php
 namespace Admin\Model;
/**
 * ============================================================================
 * QianPokMall商城
 * 官网地址:http://www.qianpok.com
 * 联系QQ:376983512
 * ============================================================================
 * 文章服务类
 */
class ActivityModel extends BaseModel {
    /**
	  * 新增
	  */
	 public function insert(){
	 	$rd = array('status'=>-1);
	 	$id = (int)I("id",0);
		$data = array();
//		  echo "<pre>";
//		 print_r(I());exit;
//		$data["catId"] = (int)I("catId");
//		$data["activityTitle"] = I("activityTitle");
//		$data["isShow"] = (int)I("isShow",0);
//		$data["activityContent"] = I("activityContent");
//		$data["activityKey"] = I("activityKey");
//		$data["staffId"] = (int)session('WST_STAFF.staffId');
//		$data["createTime"] = date('Y-m-d H:i:s');
		 $data["catId"] = (int)I("catId");
		 $data["activityTitle"] = I("activityTitle");
		 $data["isShow"] = (int)I("isShow",0);
		 $data["flow"] = I("flow");
		 $data["initiator"] = I("initiator");
		 $data["mobile"] = I("mobile");
		 $data["address"] = I("address");
		 $data["expenditure"] = I("expenditure");
		 $data["prepay"] = I("prepay");
		 $data["user_num"] = I("user_num");
		 $data["title"] = I("title");
		 $data["desc"] = I("desc");
		 $data["picurl"] = I("picurl");
		 $data["start_time"] = I("start_time");
		 $data["end_time"] = I("end_time");
		 $data["end_apply"] = I("end_apply");
		 $data["createTime"] = date('Y-m-d H:i:s');
	    if($this->checkEmpty($data,true)){
			$rs = $this->add($data);
		    if(false !== $rs){
				$rd['status']= 1;
			}
		}
		return $rd;
	 } 
     /**
	  * 修改
	  */
	 public function edit(){
	 	 $rd = array('status'=>-1);
	 	 $id = (int)I("id",0);
		 $data = array();
		 $data["catId"] = (int)I("catId");
		 $data["activityTitle"] = I("activityTitle");
	     $data["isShow"] = (int)I("isShow",0);
		 $data["flow"] = I("flow");
		 $data["initiator"] = I("initiator");
		 $data["mobile"] = I("mobile");
		 $data["address"] = I("address");
		 $data["expenditure"] = I("expenditure");
		 $data["prepay"] = I("prepay");
		 $data["user_num"] = I("user_num");
		 $data["title"] = I("title");
		 $data["desc"] = I("desc");
		 $data["picurl"] = I("picurl");
		 $data["start_time"] = I("start_time");
		 $data["end_time"] = I("end_time");
		 $data["end_apply"] = I("end_apply");
	     if($this->checkEmpty($data,true)){
		    $rs = $this->where("activityId=".(int)I('id',0))->save($data);
			if(false !== $rs){
				$rd['status']= 1;
			}
		 }
		 return $rd;
	 } 
	 /**
	  * 获取指定对象
	  */
     public function get(){
		return $this->where("activityId=".(int)I('id'))->find();
	 }
	 /**
	  * 分页列表
	  */
     public function queryByPage(){
	 	$sql = "select a.*,c.catName
	 	    from __PREFIX__activity a,__PREFIX__activity_cats c
	 	    where a.catId=c.catId";
	 	if(I('activityTitle')!='')$sql.=" and activityTitle like '%".WSTAddslashes(I('activityTitle'))."%'";
	 	$sql.=' order by activityId desc';
		return $this->pageQuery($sql);
	 }
	 /**
	  * 获取列表
	  */
	  public function queryByList(){
	     $sql = "select * from __PREFIX__activity where isShow =1 order by activityId desc";
		 $rs = $this->query($sql);
		 return $rs;
	  }
	  
	 /**
	  * 删除
	  */
	 public function del(){
	 	$rd = array('status'=>-1);
	    $rs = $this->delete((int)I('id'));
		if(false !== $rs){
		   $rd['status']= 1;
		}
		return $rd;
	 }
	 /**
	  * 显示分类是否显示/隐藏
	  */
	 public function editiIsShow(){
	 	$rd = array('status'=>-1);
	 	if(I('id',0)==0)return $rd;
	 	$this->isShow = ((int)I('isShow')==1)?1:0;
	 	$rs = $this->where("activityId=".(int)I('id',0))->save();
	    if(false !== $rs){
			$rd['status']= 1;
		}
	 	return $rd;
	 }
};
?>