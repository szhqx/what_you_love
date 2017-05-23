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
class CouponModel extends BaseModel {
    /**
	  * 新增
	  */
	 public function insert(){
	 	$rd = array('status'=>-1);
	 	$id = (int)I("id",0);
		$data = array();
		$data["couponType"] = (int)I("couponType");
		 $data["couponName"] = I("couponName");
		 $data["isShow"] = (int)I("isShow",0);
		 $data["money"] = I("money");
		 $data["maxget"] = I("maxget");
		 $data["maxuse"] = I("maxuse");
		 $data["couponImg"] = I("couponImg");
		 $data["returnValue"] = I("returnValue");
		 $data["indate"] = I("indate");
		 $data["usageRule"] = I("usageRule");
		$data["createTime"] = date('Y-m-d H:i:s');
	    if($this->checkEmpty($data,true)){
			$rs = M('cfg_coupon')->add($data);
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
		 $data["couponType"] = (int)I("couponType");
		 $data["couponName"] = I("couponName");
	     $data["isShow"] = (int)I("isShow",0);
		 $data["money"] = I("money");
		 $data["maxget"] = I("maxget");
		 $data["maxuse"] = I("maxuse");
		 $data["couponImg"] = I("couponImg");
		 $data["returnValue"] = I("returnValue");
		 $data["indate"] = I("indate");
		 $data["usageRule"] = I("usageRule");
		 //print_r($data);
	     if($this->checkEmpty($data,true)){
		    $rs = M('cfg_coupon')->where("couponId=".(int)I('id',0))->save($data);
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
		return  M('cfg_coupon')->where("couponId=".(int)I('id'))->find();
	 }
	 /**
	  * 分页列表
	  */
     public function queryByPage(){
	 	$sql = "select a.*
	 	    from __PREFIX__cfg_coupon as a
	 	    where a.isShow=1";
	 	if(I('couponName')!='')$sql.=" and  a.couponName like '%".WSTAddslashes(I('couponName'))."%'";
	 	$sql.=' order by couponId desc';
		return M('cfg_coupon')->pageQuery($sql);
	 }
	 /**
	  * 获取列表
	  */
	  public function queryByList(){
	     $sql = "select * from __PREFIX__cfg_coupon where isShow=1 order by couponId desc";
		 $rs = M('cfg_coupon')->query($sql);
		 return $rs;
	  }
	  
	 /**
	  * 删除
	  */
	 public function del(){
	 	$rd = array('status'=>-1);
	    $rs = M('cfg_coupon')->delete((int)I('couponId'));
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
	 	$rs = M('cfg_coupon')->where("couponId=".(int)I('id',0))->save();
	    if(false !== $rs){
			$rd['status']= 1;
		}
	 	return $rd;
	 }
};
?>