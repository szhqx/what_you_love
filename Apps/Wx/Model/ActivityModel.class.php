<?php
namespace Wx\Model;
/**
 * ============================================================================
 * QianPokMall商城
 * 官网地址:http://www.qianpok.com
 * 联系QQ:376983512
 * ============================================================================
 * 活动类
 */
class ActivityModel extends BaseModel {
	
     /**
	  * 获取活动列表
	  * $cate 分类
	  * $limit 获取条数
	  */
     public function getActivityList($limit='10000'){
//		    $actfield = "activityId,picurl,activityTitle,start_time,end_time,address,ordid,desc";
//		 	$activity = $this->where("isShow=1")->field($actfield)->limit($limit)->order("activityId asc")->select();
		 $sql = "select activityId,picurl,activityTitle,start_time,end_time,address,ordid from __PREFIX__activity
	 			where isShow=1";
		 $sql.=" order by createTime desc";
		// echo $sql;
		 $rs = $this->pageQuery($sql);
	     return $rs;
	 }
	/**
	 * 获取活动详情
	 */
	public function getActivity($obj){
		$activityId = (int)$obj["activityId"];
		$sql ="SELECT * FROM __PREFIX__activity WHERE activityId=$activityId";
		$activity = $this->queryRow($sql);
		return $activity;
	}



}