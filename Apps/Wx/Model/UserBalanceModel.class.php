<?php
namespace Wx\Model;
/**
 * ============================================================================
 * QianPokMall商城
 * 官网地址:http://www.qianpok.com
 * 联系QQ:376983512
 * ============================================================================
 * 会员服务类
 */
class UserBalanceModel extends BaseModel {
	
     /**
	  * 获取用户余额列表
	  */
     public function getScoreList(){
		$scoreType = (int)I("scoreType",0);
	 	$userId=(int)session('WST_USER.userId');
	 	$sql = "select us.scoreId,us.userId,us.score,us.dataSrc,us.dataId,us.scoreType,us.createTime,us.dataRemarks,o.orderNo from __PREFIX__user_score us, __PREFIX__orders o  
	 			where us.dataId=o.orderId and us.userId=".$userId;
	 	if($scoreType>0){
	 		$sql.=" and us.scoreType= $scoreType";
	 	}
	 	$sql.=" order by us.createTime desc ";
	 	$rs = $this->pageQuery($sql);
	 	return $rs;
	 }
	public function getIncomeTatol(){
		$userId=(int)session('WST_USER.userId');
		$incomeDate = M('order_level')->field("sum(price) as money")->where('level_id ='.$userId.' AND orderStatus=4 ')->find();
		return $incomeDate;
	}
	/**
	 * 获取用户收益列表
	 */
	public function getIncomeList(){
		$userId=(int)session('WST_USER.userId');
		$sql = "select * from __PREFIX__order_level
	 			where  level_id='".$userId."' AND orderStatus=4 ";//and UNIX_TIMESTAMP(active_time)<".$prev_month." AND UNIX_TIMESTAMP(active_time)>".$start_time ----按月结算
		$sql.=" order by active_time desc ";
		$rs = $this->pageQuery($sql);
		return $rs;
	}
	/**
	 * 获取用户提现申请列表
	 */
	public function getWithdrawList(){
		$userId=(int)session('WST_USER.userId');
		$sql = "select * from __PREFIX__user_withdraw
	 			where  userId='".$userId."'";//and UNIX_TIMESTAMP(active_time)<".$prev_month." AND UNIX_TIMESTAMP(active_time)>".$start_time ----按月结算
		$sql.=" order by createTime desc ";
		$rs = $this->Query($sql);
		return $rs;
	}
	/**
	 * 获取用户提现申请未完成总金额
	 */
	public function getWithdrawTotal(){
		$userId=(int)session('WST_USER.userId');
		$sql = "select sum(amount) as amount from __PREFIX__user_withdraw
	 			where  userId='".$userId."' AND isFlag=0";//and UNIX_TIMESTAMP(active_time)<".$prev_month." AND UNIX_TIMESTAMP(active_time)>".$start_time ----按月结算
		$rs = $this->queryRow($sql);
		return $rs;
	}
}