<?php
 namespace Wx\Model;
/**
 * ============================================================================
 * QianPokMall商城
 * 官网地址:http://www.qianpok.com
 * 联系QQ:376983512
 * ============================================================================
 * 会员等级服务类
 */
class UserRanksModel extends BaseModel {
	 /**
	  * 获取列表
	  */
	  public function checkUserRank($score){
	     $m = M('user_ranks');
		 return $rs = $m->where($score.' between  startScore and endScore ')->find();
	  }
	  /**
	   * 获取用户等级
	   */
	  function getUserRank(){
	  	$userId = (int)session('WST_USER.userId');
	  	$sql = "select userId,userScore,userTotalScore from __PREFIX__users WHERE userId=$userId ";
	  	$user = $this ->queryRow($sql);
	  	
	  	$rank = array();
	  	if($user["userId"]>0){
	  		$userTotalScore = (int)$user["userTotalScore"];
	  		$sql = "select * from __PREFIX__user_ranks where startScore<=$userTotalScore and endScore>$userTotalScore";
	  		$rank = $this->queryRow($sql);
	  	}
	  	return $rank;
	  }
	/*
	 * 获取用户关系网人数及等级
	 *
	 */
	 function getUserLevel(){
		 $userId = (int)session('WST_USER.userId');
		 $countlist = M("users_exp")->where("uid=".$userId)->find();
		 $Level['count_num'] = $countlist['count_a']+$countlist['count_b']+$countlist['count_c']+$countlist['count_d']+$countlist['count_e']+$countlist['count_f']+$countlist['count_g']+$countlist['count_h']+$countlist['count_j'];
		 $Level['count_num'] = $Level['count_num']==''?0:$Level['count_num'];
		 $Level['count_a'] =  $countlist['count_a']==''?0:$countlist['count_a'];
		 if($userId>0){
			 $userTotalNum = (int)$Level['count_num'];
			 $sql = "select * from __PREFIX__user_ranks where startScore<=$userTotalNum and endScore>$userTotalNum";
			 $rank = $this->queryRow($sql);
			 $rank['count_num'] =  $Level['count_num'];
			 $rank['count_a'] =  $Level['count_a'];
		 }
		 return $rank;
	 }

};
?>