<?php
namespace Admin\Model;
/**
 * ============================================================================
 * QianPokMall商城
 * 官网地址:http://www.qianpok.com
 * 联系QQ:376983512
 * ============================================================================
 * 订单结算服务类
 */
class OrderSettlementsModel extends BaseModel {
	/**
	 * 获取结算列表
	 */
	public function queryByPage(){
		if(date('d')=='14'){
			$this->divide_add();
		}

		$sql = "select * from __PREFIX__divide";
		return  $this->pageQuery($sql,(int)I('p'),30);
	}
	/**
	 * 分成生成
	 */
	public function divide_add(){
		//用户数据
		$userModel = M("users");
		$sql = "select u.* from __PREFIX__users AS u where u.userFlag=1  order by userId Asc ";//
		$userData = $userModel->Query($sql);
		//计算每个用户得到分成
		$prev_month =  strtotime(date('Y-m-t', strtotime('-1 month')));
		$start_time = strtotime(date('Y-m-01', strtotime('-1 month')));
		foreach($userData as $key=>$val){
			$data = M('order_level')->where('level_id ='.$val['userId'].' AND orderStatus=4 and UNIX_TIMESTAMP(active_time)<'.$prev_month.' AND UNIX_TIMESTAMP(active_time)>'.$start_time)->select();//每个用户的分成列表

			foreach($data as $keyy=>$voo){
				$divide[$key][$voo['level_type']]['amount_price'] += $voo['price'];//每个用户每级获得的返利
				$divide[$key][$voo['level_type']]['count']++;//每个用户每级获得分成的数量
			}
		}

		foreach($userData as $key=>$vo){
			$add_data[$key]['user_id'] = $vo['userId'];//用户id
			$add_data[$key]['nickName'] = $vo['nickName'];//用户id
			$add_data[$key]['p_all'] = $divide[$key][0]['amount_price'];//奖金池价格
			$add_data[$key]['p_a'] = $divide[$key][1]['amount_price'];//1级价格
			$add_data[$key]['p_b'] = $divide[$key][2]['amount_price'];//2级价格
			$add_data[$key]['p_c'] = $divide[$key][3]['amount_price'];//3级价格
			$add_data[$key]['p_d'] = $divide[$key][4]['amount_price'];//4级价格
			$add_data[$key]['p_e'] = $divide[$key][5]['amount_price'];//5级价格
			$add_data[$key]['p_f'] = $divide[$key][6]['amount_price'];//6级价格
			$add_data[$key]['p_g'] = $divide[$key][7]['amount_price'];//7级价格
			$add_data[$key]['p_h'] = $divide[$key][8]['amount_price'];//8级价格
			$add_data[$key]['p_j'] = $divide[$key][9]['amount_price'];//9级价格
			$add_data[$key]['count_all'] = $divide[$key][0]['count'];//奖金池数量
			$add_data[$key]['count_a'] = $divide[$key][1]['count'];//1级数量
			$add_data[$key]['count_b'] = $divide[$key][2]['count'];//2级数量
			$add_data[$key]['count_c'] = $divide[$key][3]['count'];//3级数量
			$add_data[$key]['count_d'] = $divide[$key][4]['count'];//4级数量
			$add_data[$key]['count_e'] = $divide[$key][5]['count'];//5级数量
			$add_data[$key]['count_f'] = $divide[$key][6]['count'];//6级数量
			$add_data[$key]['count_g'] = $divide[$key][7]['count'];//7级数量
			$add_data[$key]['count_h'] = $divide[$key][8]['count'];//8级数量
			$add_data[$key]['count_j'] = $divide[$key][9]['count'];//9级数量
			$add_data[$key]['divide_status'] = 0;//分成状态
			$add_data[$key]['dataTime'] = date("Y-m-d");//分成日期
			$add_data[$key]['profit'] = $divide[$key][0]['amount_price']+ $divide[$key][1]['amount_price']+$divide[$key][2]['amount_price']+$divide[$key][3]['amount_price']+$divide[$key][4]['amount_price']+$divide[$key][5]['amount_price']+$divide[$key][6]['amount_price']+$divide[$key][7]['amount_price']+$divide[$key][8]['amount_price']+$divide[$key][9]['amount_price'];
		}
		//存入数据库

		if(isset($add_data)&&!empty($add_data)){
			foreach ($add_data as $key=>$val) {
				  $result_data = array();
				  $prev_data = date("Y-m-d");
				  $result_data = M('divide')->where("dataTime='$prev_data' AND user_id=".$val['user_id'] )->find();
                  if(empty($result_data)){
					 $newData[] =  $val;
				  }
			}
			$result_add = M('divide')->addAll($newData);
		}
		if(isset($result_add)&&!empty($result_add)){
			//计算用户的下个月的大小边规则
			foreach($userData as $key=>$val){
				$maxCount = 0; //用户最大边数量
				$maxUser = 0; //用户最大边用户ID
				$allCount = 0;//用户总数量
				$minCount= 0;
				if($val['userId'] !=1){
					$sql = "select u.userId,u.nickName,(exp.count_a+exp.count_b+exp.count_c+exp.count_d+exp.count_e+exp.count_f+exp.count_g+exp.count_h) AS numAll
from __PREFIX__users AS u LEFT JOIN __PREFIX__users_exp AS exp ON u.userId=exp.uid   where u.userFlag=1 AND u.partner = ".$val['userId'];
					$Data = $userModel->Query($sql);
					foreach($Data as $k=>$v){
						if($v['numAll']>$maxCount){
							$maxCount = $v['numAll'];
							$maxUser = $v['userId'];
						}else{
							$maxCount = $maxCount;
							$maxUser = $maxUser;
						}
						$allCount += ($v['numAll']+1);
					}
					$minCount = $allCount-$maxCount;
					if($maxCount<$allCount*0.2){//不符合大小边
						M("users")->where("userId=".$val['userId'])->save(array("userMeet"=>1,"userOff"=>$maxUser));
					}else{
						M("users")->where("userId=".$val['userId'])->save(array("userMeet"=>0,"userOff"=>0));
					}
				}
				M("divide")->where("user_id=".$val['userId'])->save(array("add_time"=>date('Y-m-d H:i:s'),"maxUser"=>$maxUser,"maxCount"=>$maxCount,"minCount"=>$minCount));
			}
		//	showmsg('生成成功!');
		}else{
			//showmsg("生成错误");
		}
	}
	
	/**
	 * 获取订单结算信息
	 */
	public function get(){
		$id = (int)I('id');
		return $this->where('settlementId='.$id)->find();
	}
	/**
	 * 获取结算详情
	 */
	public function getDetail(){
		$id = (int)I('id');
		$sql = "select os.*,p.shopName from __PREFIX__order_settlements os,__PREFIX__shops p where os.shopId=p.shopId and os.settlementId=".$id;
		$rs =  $this->queryRow($sql);
		//获取订单列表
		$sql = "select orderId,orderNo,userName,realTotalMoney,poundageRate,poundageMoney from __PREFIX__orders where settlementId=".$id;
		$rs['List'] = $this->query($sql);
		return $rs;
	}
	
	/**
	 * 结算
	 */
	public function settlement(){
		$id = (int)I('id');
		$rd = array('status'=>-1);
	 	$rs = $this->where('isFinish=0 and settlementId='.$id)->find();
	 	if($rs['settlementId']!=''){
	 		$data = array();
	 		$data['isFinish'] = 1;
	 		$data['finishTime'] = date('Y-m-d H:i:s');
	 		$data['remarks'] = I('content');
	 	    $rss = $this->where("settlementId=".$id)->save($data);
			if(false !== $rss){
				$rd['status']= 1;
			}
	 	}
	 	return $rd;
	}
}