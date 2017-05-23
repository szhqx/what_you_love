<?php
 namespace Wx\Model;
/**
 * ============================================================================
 * QianPokMall商城
 * 官网地址:http://www.qianpok.com
 * 联系QQ:376983512
 * ============================================================================
 * 会员推荐人类
 */
class UserReferrerModel extends BaseModel {
	 /**
	  * 获取列表
	  */
	  public function getUserReferrer($usersId){
	     $m = M('users');
		 return $rs = $m->field("nickName,userName,createTime,userId")->where("partner=$usersId and userStatus=1")->order("createTime desc")->select();
	  }


};
?>