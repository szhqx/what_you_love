<?php
namespace Wx\Action;
/**
 * ============================================================================
 * qpSHOP商城
 * 官网地址:http://www.qianpok.com
 * 联系QQ:874570326
 * ============================================================================
 * 会员控制器
 */
class UsersAction extends BaseAction {
    /**
     * 跳去登录界面
     */
	public function login(){
		//如果已经登录了则直接跳去后台
		$USER = session('WST_USER');
		if(!empty($USER) && $USER['userId']!=''){
			$this->redirect("Users/index");
		}
		if(isset($_COOKIE["loginName"])){
			$this->assign('loginName',$_COOKIE["loginName"]);
		}else{
			$this->assign('loginName','');
		}
		$this->display('users/login');
	}
	
	
	/**
	 * 用户退出
	 */
	public function logout(){
		session('WST_USER',null);
		session("WST_CART",null);
		echo "1";
	}
	
	/**
     * 注册界面
     * 
     */
	public function regist(){
		if(isset($_COOKIE["loginName"])){
			$this->assign('loginName',$_COOKIE["loginName"]);
		}else{
			$this->assign('loginName','');
		}
		$this->display('regist');
	}

	/**
	 * 验证登陆
	 * 
	 */
	public function checkLogin(){
	    $rs = array();
	    $rs["status"]= 1;
		if(!$this->checkVerify("4") && ($GLOBALS['CONFIG']["captcha_model"]["valueRange"]!="" && strpos($GLOBALS['CONFIG']["captcha_model"]["valueRange"],"3")>=0)){			
			$rs["status"]= -1;//验证码错误
		}else{
			$m = D('Wx/Users');
			$res = $m->checkLogin();
			if (!empty($res)){
				if($res['userFlag'] == 1){
					session('WST_USER',$res);
					unset($_SESSION['toref']);
					if(strripos($_SESSION['refer'],"regist")>0 || strripos($_SESSION['refer'],"logout")>0 || strripos($_SESSION['refer'],"login")>0){
						$rs["refer"]= __ROOT__;
					}						
				}else if($res['status'] == -1){
					$rs["status"]= -2;//登陆失败，账号或密码错误
				}
			} else {
				$rs["status"]= -2;//登陆失败，账号或密码错误
			}
			
			$rs["refer"]= $rs['refer']?$rs['refer']:__ROOT__;
		}
		echo json_encode($rs);
	}

	/**
	 * 新用户注册
	 */
	public function toRegist(){
		
		$m = D('Wx/Users');
		$res = array();
		$nameType = (int)I("nameType");
		if($nameType!=3 && !$this->checkVerify("3")){			
			$res['status'] = -4;
			$res['msg'] = '验证码错误!';
		}else{			
			$res = $m->regist();
			if($res['userId']>0){//注册成功			
				//加载用户信息				
				$user = $m->get($res['userId']);
				if(!empty($user))session('WST_USER',$user);
				
			}
		}
		echo json_encode($res);

	}
    
 	/**
	 * 获取验证码
	 */
	public function getPhoneVerifyCode(){
		$userPhone = WSTAddslashes(I("userPhone"));
		$rs = array();
		if(!preg_match("#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#",$userPhone)){
			$rs["msg"] = '手机号格式不正确!';
			echo json_encode($rs);
			exit();
		}
		$m = D('Home/Users');
		$rs = $m->checkUserPhone($userPhone,(int)session('WST_USER.userId'));
		if($rs["status"]!=1){
			$rs["msg"] = '手机号已存在!';
			echo json_encode($rs);
			exit();
		}
		$phoneVerify = rand(100000,999999);
		$msg = "欢迎您注册成为".$GLOBALS['CONFIG']['mallName']."会员，您的注册验证码为:".$phoneVerify."，请在30分钟内输入。【".$GLOBALS['CONFIG']['mallName']."】";
		$rv = D('Wx/LogSms')->sendSMS(0,$userPhone,$msg,'getPhoneVerifyByRegister',$phoneVerify);
		if($rv['status']==1){
			session('VerifyCode_userPhone',$phoneVerify);
			session('VerifyCode_userPhone_Time',time());
		}
		echo json_encode($rv);
	}
   /**
    * 会员中心页面
    */
	public function index(){
		$this->isLogin();
		$USER = session('WST_USER');
        //关系网总人数
		$rm = D('Wx/UserRanks');
		$Level = $rm->getUserLevel();
//		$this->assign("counts",$Level['count_num']);//会员总数
//		$this->assign("count_a",$Level['count_a']);//直接会员
		$this->assign("rankName",$Level['rankName']);
		//获取订单列表
		$morders = D('Wx/Orders');
		$obj["userId"] = (int)$USER['userId'];
		$orderList = $morders->queryByPage($obj);
		$statusList = $morders->getUserOrderStatusCount($obj);
		$um = D('Wx/Users');
		//$user = $um->getUserById(array("userId"=>session('WST_USER.userId')));
		//$this->assign("userScore",$user['userScore']);

		/***商品、店铺、足迹数量****/
		$datas = M("favorites")->where("userId = ".$USER['userId'])->select();
		$countGood = 0;
		$countShop = 0;
        foreach($datas as $key=>$val){
            if($val['favoriteType'] ==1){
				$countShop +=1;
			}else{
				$countGood +=1;
			}
		}
		$countPrint = M("user_footprint")->where("userId = ".$USER['userId'])->count(); //足迹
		//print_r($countPrint);
		$this->assign("countPrint",$countPrint);
		$this->assign("countShop",$countShop);
		$this->assign("countGood",$countGood);
		$this->assign("orderList",$orderList);
		$this->assign("statusList",$statusList);
		$this->display("users/index");
	}
	
   /**
    * 跳到修改用户密码
    */
	public function toEditPass(){
		$this->isLogin();
		$this->assign("umark","toEditPass");
		$this->display("users/edit_pass");
	}
	
	/**
	 * 修改用户密码
	 */
	public function editPass(){
		$this->isLogin();
		$USER = session('WST_USER');
		$m = D('Home/Users');
   		$rs = $m->editPass($USER['userId']);
    	$this->ajaxReturn($rs);
	}
	/**
	 * 跳去修改买家资料
	 */
	public function toEdit(){
		$this->isLogin();
		$m = D('Wx/Users');
		$obj["userId"] = session('WST_USER.userId');
		$user = $m->getUserById($obj);
		$this->assign("user",$user);
		$this->assign("umark","toEditUser");
        $userId =session('WST_USER.userId');
		$url = urlencode("http://" . $_SERVER['HTTP_HOST'] . "/wx/index/index/pid/$userId");
		$url = "http://".$_SERVER['HTTP_HOST']."/index.php?m=Wx&c=Utils&a=getqrcode&data=".$url;
		//echo $url;
		$this->assign("imgurl",$url);
		$this->display("users/edit_user");
	}
	
	/**
	 * 跳去修改买家资料
	 */
	public function editUser(){
		$this->isLogin();
		$m = D('Home/Users');
		$obj["userId"] = session('WST_USER.userId');
		$data = $m->editUser($obj);
		
		$this->ajaxReturn($data);
	}
	
	/**
	 * 判断手机或邮箱是否存在
	 */
	public function checkLoginKey(){
		$m = D('Home/Users');
		$key = I('clientid');
		$userId = (int)session('WST_USER.userId');
		$rs = $m->checkLoginKey(I($key),$userId);
		if($rs['status']==1){
			$rs['msg'] = "该账号可用";
		}else if($rs['status']==-2){
			$rs['msg'] = "不能使用该账号";
		}else{
			$rs['msg'] = "该账号已存在";
		}
		$this->ajaxReturn($rs);
	}
	/**
	 * 忘记密码
	 */
    public function forgetPass(){
    	session('step',1);
    	$this->display('default/forget_pass');
    }
    
    /**
     * 找回密码
     */
    public function findPass(){
    	//禁止缓存
    	header('Cache-Control:no-cache,must-revalidate');  
		header('Pragma:no-cache');
    	$step = (int)I('step');
    	switch ($step) {
    		case 1:#第二步，验证身份
    			if (!$this->checkCodeVerify(false)) {
    				$this->error('验证码错误！');
    			}
    			$loginName = WSTAddslashes(I('loginName'));
    			$m = D('Home/Users');
    			$info = $m->checkAndGetLoginInfo($loginName);
    			if ($info != false) {
    				session('findPass',array('userId'=>$info['userId'],'loginName'=>$loginName,'userPhone'=>$info['userPhone'],'userEmail'=>$info['userEmail'],'loginSecret'=>$info['loginSecret']) );
    				if($info['userPhone']!='')$info['userPhone'] = WSTStrReplace($info['userPhone'],'*',3);
    				if($info['userEmail']!='')$info['userEmail'] = WSTStrReplace($info['userEmail'],'*',2,'@');
    				$this->assign('forgetInfo',$info);
    				$this->display('default/forget_pass2');
    			}else $this->error('该用户不存在！');
    			break;
    		case 2:#第三步,设置新密码
    			if (session('findPass.loginName') != null ){
                    if (session('findPass.userEmail')==null) {
                        $this->error('你没有预留邮箱，请通过手机号码找回密码！');
                    }
                    if ( session('findPass.userPhone') == null) {
    				    $this->error('你没有预留手机号码，请通过邮箱方式找回密码！');
                    }
    			}else $this->error('页面过期！');
    			break;
    		case 3:#设置成功
    			$resetPass = session('REST_success');
    			if($resetPass!='1')$this->error("非法的操作!");
                $loginPwd = I('loginPwd');
                $repassword = I('repassword');
                if ($loginPwd == $repassword) {
	                $rs = D('Home/Users')->resetPass();
			    	if($rs['status']==1){
			    	    $this->display('default/forget_pass4');
			    	}else{
			    		$this->error($rs['msg']);
			    	}
                }else $this->error('两次密码不同！');
    			break;
    		default:
    			$this->error('页面过期！'); 
    			break;
    	}  	
    }


	/**
	 * 手机验证码获取
	 */
	public function getPhoneVerify(){
		$rs = array('status'=>-1);
		if(session('findPass.userPhone')==''){
			$this->ajaxReturn($rs);
		}
		$phoneVerify = mt_rand(100000,999999);
		$USER = session('findPass');
		$USER['phoneVerify'] = $phoneVerify;
        session('findPass',$USER);
		$msg = "您正在重置登录密码，验证码为:".$phoneVerify."，请在30分钟内输入。【".$GLOBALS['CONFIG']['mallName']."】";
		$rv = D('Home/LogSms')->sendSMS(0,session('findPass.userPhone'),$msg,'getPhoneVerify',$phoneVerify);
		$rv['time']=30*60;
		$this->ajaxReturn($rv);
	}

	/**
	 * 手机验证码检测
	 * -1 错误，1正确
	 */
	public function checkPhoneVerify(){
		$phoneVerify = I('phoneVerify');
		$rs = array('status'=>-1);
		if (session('findPass.phoneVerify') == $phoneVerify ) {
			//获取用户信息
			$user = D('Home/Users')->checkAndGetLoginInfo(session('findPass.userPhone'));
			$rs['u'] = $user;
			if(!empty($user)){
				$rs['status'] = 1;
				$keyFactory = new \Think\Crypt();
			    $key = $keyFactory->encrypt("0_".$user['userId']."_".time(),C('SESSION_PREFIX'),30*60);
				$rs['url'] = "http://".$_SERVER['HTTP_HOST'].U('Home/Users/toResetPass',array('key'=>$key));
			}
		}
		$this->ajaxReturn($rs);
	}

	/**
	 * 发送验证邮件
	 */
	public function getEmailVerify(){
		$rs = array('status'=>-1);
		$keyFactory = new \Think\Crypt();
		$key = $keyFactory->encrypt("0_".session('findPass.userId')."_".time(),C('SESSION_PREFIX'),30*60);
		$url = "http://".$_SERVER['HTTP_HOST'].U('Home/Users/toResetPass',array('key'=>$key));
		$html="您好，会员 ".session('findPass.loginName')."：<br>
		您在".date('Y-m-d H:i:s')."发出了重置密码的请求,请点击以下链接进行密码重置:<br>
		<a href='".$url."'>".$url."</a><br>
		<br>如果您的邮箱不支持链接点击，请将以上链接地址拷贝到你的浏览器地址栏中。<br>
		该验证邮件有效期为30分钟，超时请重新发送邮件。<br>
		<br><br>*此邮件为系统自动发出的，请勿直接回复。";
		$sendRs = WSTSendMail(session('findPass.userEmail'),'密码重置',$html);
		if($sendRs['status']==1){
			$rs['status'] = 1;
		}else{
			$rs['msg'] = $sendRs['msg'];
		}
		$this->ajaxReturn($rs);
	}
	
    /**
     * 跳到重置密码
     */
    public function toResetPass(){
    	$key = I('key');
	    $keyFactory = new \Think\Crypt();
		$key = $keyFactory->decrypt($key,C('SESSION_PREFIX'));
		$key = explode('_',$key);
		if(time()>floatval($key[2])+30*60)$this->error('连接已失效！');
		if(intval($key[1])==0)$this->error('无效的用户！');
		session('REST_userId',$key[1]);
		session('REST_Time',$key[2]);
		session('REST_success','1');
		$this->display('default/forget_pass3');
    }
    
    /**
     * 跳去用户登录的页面
     */
    public function toLoginBox(){
    	$this->display('default/login_box');
    }
    
    /**
     * 查看积分记录
     */
    public function toScoreList(){
    	$this->isUserLogin();
    	$um = D('Wx/Users');
    	$user = $um->getUserById(array("userId"=>session('WST_USER.userId')));
    	$this->assign("userScore",$user['userScore']);
    	$this->assign("umark","toScoreList");
    	$this->display("default/users/score_list");
    }
    
    /**
     * 查看积分记录
     */
    public function getScoreList(){
    	$this->isUserLogin();
    	$m = D('Wx/UserScore');
    	$rs = $m->getScoreList();
    	$this->ajaxReturn($rs);
    }
	/**********************************************************************************************
	 *                                             账号资金管理                                                                                                                            *
	 **********************************************************************************************/
	/**
	 * 账号余额充值
	 */
	public function purse(){
		$this->isUserLogin();
		$um = D('Wx/Users');
		$user = $um->getUserById(array("userId"=>session('WST_USER.userId')));
		$this->assign("userBalance",$user['userBalance']);
		$inweixin = empty($this->wxopenid) ? '0' : '1';
		$this->assign('inweixin', $inweixin);
		$this->display("/users/purse");
	}
	/**
	 * 账号余额明细
	 */
	public function purselist(){
		$this->isUserLogin();
		$um = D('Wx/Users');
		$user = $um->getUserById(array("userId"=>session('WST_USER.userId')));
		$this->assign("userBalance",$user['userBalance']);
		$dataList = $um->getPurseDetails(array("userId"=>session('WST_USER.userId')));
		$this->assign("DetailsList",$dataList);
		$this->display("/users/purselist");
	}

	/**
	 * 余额充值
	 */
	public function charge(){
		$amount = I("post.money");
		$userId = session('WST_USER.userId');
		if($amount<=0){
			showmsg("充值金额必须大于0.00！");
		}
		if(!is_numeric($amount)|| floatval($amount)<=0){ //
			showmsg("充值金额错误");
		}else{
			//if($userId ==43){
				//$amount = 0.01;
		//	}
			$trannum = 'chong' . time();
			$params['payamount'] = $amount * 100;
			$params['trannum'] = $trannum;
			$params['backurl'] = U('Users/purse');
			$params['successurl'] =  U('Users/purse');//U('User/recharge_success', array("trannum"=>$trannum,"comein" => 1));

			$params['ordersign'] = md5($trannum . "xihuansha.2016.#");
			$params['showwxpaytitle'] = 1;

			$url = 'http://www.xihuansha.com/wx/wxpay/index'."?".http_build_query($params);//. $_SERVER['SERVER_NAME'].
			header("location:$url");
		}
	}
	/**
	 * 提现收入明细
	 */
	public function parter(){
		$this->display("users/parter");
	}
	/**
	 * 意见反馈
	 */
	public function feedback(){
		$this->isLogin();
		if(IS_POST){
			$feedbackType = I("post.suggestType");
			$suggest = I("post.suggest");
			$userId = (int)session('WST_USER.userId');
			$ip = get_client_ip();
			$time = date("Y-m-d");
			$su = M("feedbacks")->where("createTime = '$time' AND userId='$userId'")->count();
			if($su>10){
				showmsg("系统快受不鸟了,一天最多只能投诉建议10次！");
			}
			$data = array("feedbackType"=>$feedbackType,
				"content"=>$suggest,
				"userId"=>$userId,
				"userIp"=>$ip,
				"createTime"=>$time,
				"feedbackType"=>$feedbackType,
				);
			$resoult = M("feedbacks")->add($data);
			if($resoult){
				showmsg("感谢您的投诉和建议！");
			}
			showmsg("系统繁忙，稍后再试。。。");
		}
		$this->display("users/feedback");
	}
	/**
	 * 取消收藏
	 */
	public function quxiao(){
		$id = (int)I("post.id");
		$rs = M('Favorites')->where("favoriteId=".$id." and userId=".(int)session('WST_USER.userId'))->delete();
		if(false !== $rs){
			$rd['status']= 1;
		}
		$this->ajaxReturn($rd);
	}
	/**
	 * 商品收藏
	 */
	public function goods_collection(){
		$this->isLogin();
		$m = D('Wx/Favorites');
		$page = $m->queryGoodsByPage();
		//print_r($page);
		$this->assign("goodspage",$page['root']);
		$this->display("users/goods_collection");
	}
	/**
	 * 店铺收藏
	 */
	public function shop_collection(){
		$this->isLogin();
		$m = D('Wx/Favorites');
		$page = $m->queryShopsByPage();

		$this->assign("shoppage",$page['root']);
		$this->display("users/shop_collection");
	}
	/**
	 * 用户积分明细
	 *
	 */
	public function mysorce(){
		$this->isUserLogin();
		$um = D('Wx/Users');
		$user = $um->getUserById(array("userId"=>session('WST_USER.userId')));//session('WST_USER.userId')
		$this->assign("userScore",$user['userScore']);
		$m = D('Wx/UserScore');
		$sorceList = $m->getScoreList();
		$this->assign("scoreList",$sorceList);
		$this->display("users/mysorce");
	}
	/**
	 * 用户嘻币明细
	 *
	 */
	public function myheecoin(){
		$this->isUserLogin();
//		$um = D('Wx/Users');
//		$user = $um->getUserById(array("userId"=>session('WST_USER.userId')));//session('WST_USER.userId')
//		$this->assign("userScore",$user['userScore']);
//		$m = D('Wx/UserScore');
//		$sorceList = $m->getScoreList();
//		$this->assign("scoreList",$sorceList);
		$this->display("users/myheecoin");
	}
	/**
	 * 用户收益明细
	 *
	 */
	public function income(){
		$this->isUserLogin();
		$m = D('Wx/UserBalance');
		$incomeList = $m->getIncomeList();
		$userIncome = $m->getIncomeTatol();
		$this->assign("userIncome",$userIncome['money']);
		$this->assign("incomeList",$incomeList);
		$this->display("users/income");
	}
	/**
	 * 用户提现明细
	 *
	 */
	public function withdraw(){
		$inweixin = empty($this->wxopenid) ? '0' : '1';
		$this->assign('inweixin', $inweixin);
		$this->isUserLogin();
		$um = D('Wx/Users');
		$this->assign("withdrawNo",time()); //提现号，防重复提交
		$user = $um->getUserById(array("userId"=>session('WST_USER.userId')));//session('WST_USER.userId')
		$m = D('Wx/UserBalance');
		$withdrawList = $m->getWithdrawList();
		$withdrawTotal = $m-> getWithdrawTotal();
		$this->assign("userBalance",$user['userBalance']-$withdrawTotal['amount']); //用户收入总金额-用户余额
		$this->assign("withdrawList",$withdrawList);
		$this->display("users/withdraw");
	}
	/*****提交提现申请*****/
	public function gowithdraw(){
		$amount = I("post.money");
		$withdrawNo = I("post.withdrawNo");
		$remark = I("post.remark");
		$userId = session('WST_USER.userId');
		$um = D('Wx/Users');
		$m = D('Wx/UserBalance');
		$withdrawTotal = $m-> getWithdrawTotal();
		$user = $um->getUserById(array("userId"=>$userId));
		if($user['userBalance']-$withdrawTotal['amount']<$amount){
            showmsg("当前账户可提现余额只有：￥".($user['userBalance']-$withdrawTotal['amount']));
		}
		if(M("user_withdraw")->where("userId=$userId AND withdrawNo='$withdrawNo'")->find()){
			showmsg("提现申请已提交,无需重复申请");
		}
		if($amount<=0){
			showmsg("提现金额必须大于0.00！");
		}
		if(!is_numeric($amount)|| floatval($amount)<=0){ //
			showmsg("提现金额错误");
		}else{
			$data = array(
				"userId"=>$userId,
				"amount" =>$amount,
				"remark" => $remark,
				"withdrawNo" => $withdrawNo,
				"createTime" =>date("Y-m-d H:i:s"),
			);
			$rs = M("user_withdraw")->add($data);
			if($rs){
				showmsg("提现申请已提交");
			}
		}
	}
	/**
	 * 获取我推荐人
	 */
	public function myReferrer(){
		$this->isUserLogin();
		$m = D("Wx/UserReferrer");
		$USER = session('WST_USER');
		$Referrer = $m->getUserReferrer($USER['userId']);
		$this->assign("referrer",$Referrer);
		$this->display("users/myreferrer");
	}
	/**
	 * 入驻管理
	 */
	public function goSettled(){
		$this->isUserLogin();
		if(IS_POST){
			$telePhone = I("post.telePhone");
			$mobile = I("post.mobile");
			$remark = I("post.remark");
			$username = I("post.userName");
			if(empty($username)||(empty($mobile) || !preg_match("/^1[34578]{1}\d{9}$/",$mobile))){
				showmsg("请正确填写手机和联系人...");
			}
			$userId = (int)session('WST_USER.userId');
			$time = date("Y-m-d");
			$su = M("shop_settled")->where("createTime = '$time' AND userId='$userId'")->count();
			if($su>1){
				showmsg("您今天已经申请过了，管理员将在三个工作日内与你联系");
			}
			$data = array("telephone"=>$telePhone,
				"mobile"=>$mobile,
				"userId"=>$userId,
				"remark"=>$remark,
				"createTime"=>$time,
				"userName"=>$username,
			);
			$resoult = M("shop_settled")->add($data);
			if($resoult){
				showmsg("申请成功，我们将在三个工作日内与你联系");
			}
			showmsg("系统繁忙，稍后再试。。。");
		}
		$this->display("users/gosettled");
	}
	/**
	 * 活动发布
	 */
	public function release_activity(){
		$this->isUserLogin();
		$actCate = M("activity_cats")->select();
		$this->assign("actCate",$actCate);
		if(IS_POST){
			//$photo = $this->upload($_FILES['file_img']);
			$upload = new \Think\Upload(C('UPLOAD_SET'));
			if($_FILES['file_img']['size']>0){ //存在
				$file =array();
				$file['file_img'] = $_FILES['file_img'];
				$info = $upload->upload($file);
				$data['value'] = 'Upload/Activity/'.$info['file_img']['savepath'].$info['file_img']['savename'];
				$picurl = $data['value'];
			}
			if(count($_FILES['file_img1']['size'])>0){
				$file = array();
				$file['file_img1'] = $_FILES['file_img1'];
				$photo = $upload->upload($file);
				foreach($photo as $key=>$val){
					$data['photo'][$key] = 'Upload/Activity/'.$val['savepath'].$val['savename'];
				}
				$activityPhoto =json_encode($data['photo']);
			}
			$activityTitle = I("post.activityTitle");
			$initiator = I("post.initiator");
			$catId = I("post.catId");
			$mobile = I("post.mobile");
			$address = I("post.address");
			$expenditure = I("post.expenditure");
			$user_num = I("post.user_num");
			$prepay = I("post.prepay");
			$isShow = I("post.isshow",1);
			$start_time = str_replace('T'," ",I("post.start_time"));
			$end_time = str_replace('T'," ",I("post.end_time"));
			$end_apply = str_replace('T'," ",I("post.end_apply"));
			if(strtotime($end_apply)<time()){
				showmsg("报名结束时间不能小于当前时间");
			}
			if(strtotime($start_time)>strtotime($end_time)){
				showmsg("活动结束时间不能小于活动开始时间");
			}
			$flow= I("post.flow");
			$desc= I("post.desc");
			$userId = (int)session('WST_USER.userId');
			if(empty($initiator)||(empty($mobile) || !preg_match("/^1[34578]{1}\d{9}$/",$mobile))){
				showmsg("请正确填写手机和活动联系人");
			}


			if(empty($activityTitle)){
				showmsg("活动标题不能为空");
			}
			if(empty($address)||empty($user_num)||empty($start_time)||empty($end_time)||empty($end_apply)||empty($flow)){
				showmsg("活动地址或报名时间活动时间等都不能为空");
			}

			$data = array("activityTitle"=>$activityTitle,
				"initiator"=>$initiator,
				"userId"=>$userId,
				"catId"=>$catId,
				"mobile"=>$mobile,
				"address"=>$address,
				"expenditure"=>$expenditure,
				"user_num"=>$user_num,
				"prepay"=>$prepay,
				"start_time"=>$start_time,
				"end_time"=>$end_time,
				"end_apply"=>$end_apply,
				"flow"=>$flow,
				"desc"=>$desc,
				"isShow"=>$isShow,
				'picurl' => empty($picurl)?'Upload/Activity/2016-05/573063b50549d.jpg':$picurl,
				"activityPhoto"=>$activityPhoto,
				"createTime"=>date("Y-m-d H:i:s"),
			);
			$res = M("activity")->add($data);
			if($res){
				showmsg("发布成功");
			}
			showmsg("系统繁忙");
		}
		$this->display("users/release_activity");
	}
	/**
	 *我参加的活动
	 */
	public function user_activity(){
		$this->isUserLogin();
		$userId = (int)session('WST_USER.userId');
		$sql ="select a.*,u.createTime as times from wj_activity as a left join wj_activity_userlog as u on u.act_id=a.activityId where u.userId=$userId";

		$activity = M("activity")->query($sql); //->where("isShow=1 AND userId='$userId'")->order("createTime desc")->select();
       // echo M()->getLastSql();
		foreach($activity as $key=>$val){
			if(strtotime($val['end_apply'])>time()){ //报名未结束
				$activity[$key]['isOff'] = '报名中';
			}else{
				if(strtotime($val['end_time'])<time()){ //活动结束
					$activity[$key]['isOff'] = "已结束";
				}else{
					$activity[$key]['isOff'] = "进行中";
				}
			}
		}
		$this->assign("activity",$activity);
		$this->display("users/user_activity");
	}
	/**
	 *我发布的活动
	 */
	public function myactivity(){
		$this->isUserLogin();
		$userId = (int)session('WST_USER.userId');
		$activity = M("activity")->where("userId='$userId'")->order("createTime desc")->select();
		foreach($activity as $key=>$val){
			if(strtotime($val['end_apply'])>time()){ //报名未结束
				$activity[$key]['isOff'] = '报名中';
			}else{
				if(strtotime($val['end_time'])<time()){ //活动结束
					$activity[$key]['isOff'] = "已结束";
				}else{
					$activity[$key]['isOff'] = "进行中";
				}
			}
		}
		$this->assign("activity",$activity);
		$this->display("users/myactivity");
	}
	/**
	 * 直接会员数
	 */
	public  function  direct_member(){
		$this->isUserLogin();
		//z直接会员列表
		$m = D("Wx/UserReferrer");
		$USER = session('WST_USER');
		$Referrer = $m->getUserReferrer($USER['userId']);
		$this->assign("referrer",$Referrer);
		//关系网总人数
		$rm = D('Wx/UserRanks');
		$Level = $rm->getUserLevel();
		$this->assign("counts",$Level['count_a']);//直接会员

		$this->display('users/direct_member');
	}
	/**
	 * 间接会员数
	 */
	public  function  indirect_member(){
		$this->isUserLogin();
      //关系网总人数
		$rm = D('Wx/UserRanks');
		$Level = $rm->getUserLevel();
		$this->assign("counts",$Level['count_num']-$Level['count_a']);//间接会员数
		$this->display('users/indirect_member');
	}
	/**
	 * 会员总数
	 */
	public  function  member(){
		$this->isUserLogin();
		$rm = D('Wx/UserRanks');
		$Level = $rm->getUserLevel();
		$this->assign("counts",$Level['count_num']);//会员总数
		$this->display('users/member');
	}
	/**
	 *  有效会员数
	 */
	public  function  valid_member(){
		$this->isUserLogin();
		$rm = D('Wx/UserRanks');
		$Level = $rm->getUserLevel();
		$this->assign("counts",$Level['count_num']);//会员总数
		$this->display('users/valid_member');
	}

	/**
	 * 我的足迹
	 */

	public function  myfootprint(){
		$this->isUserLogin();
		$um = D("Wx/Users");
		$footprintList = $um->getMyFootPrint();//获取足迹列表
		//print_r($footprintList);
		$this->assign("footprintList",$footprintList['root']);
		$this->display("users/myfootprint");
	}
	/**
	 * 删除我的足迹
	 */
	public function delfootprint(){
		$id = (int)I("post.id");
		$rs = M('user_footprint')->where("Id=".$id." and userId=".(int)session('WST_USER.userId'))->delete();
		if(false !== $rs){
			$rd['status']= 1;
		}
		$this->ajaxReturn($rd);
	}


}