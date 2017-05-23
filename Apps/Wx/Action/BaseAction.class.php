<?php
namespace Wx\Action;
/**
 * ============================================================================
 * qpSHOP商城
 * 官网地址:http://www.qianpok.com
 * 联系QQ:874570326
 * ============================================================================
 * 基础控制器
 */
use Common\Common\Wxapi;
use Think\Controller;
class BaseAction extends Controller {
	public $wxopenid;
	public function __construct(){
		parent::__construct();

		/* 新增**/
		if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
			$wxapi = new Wxapi();
			//微信分享
			$signPackage = $wxapi->getSignPackage();

			$this->assign("signPackage",$signPackage);
			$this->wxopenid = $wxapi->getOpenid();
			if($this->wxopenid=='oXEA5vwZo7hMQkTmgnQOnGz6uh_M'){
				$this->wxopenid = 'oXEA5vyq5IeZFTFWEqczEJisVUGA';
			}
			session('WST_USER',null);
		}

		if (!session('WST_USER') && !empty($this->wxopenid)) { //微信访问
			$um = D('Wx/Users');
			$userinfo  = $um->loginByOpenid($this->wxopenid);
			if(empty($userinfo['nickName'])){
				$wxapi = new Wxapi();
				$wxuser = $wxapi->getUserInfo();
				if($wxuser['nickname']){
					M("users")->where("userId=".$userinfo['userId'])->save(array("nickName"=>$wxuser['nickname']));
				}
			}
			//未注册自动注册
			if(!is_array($userinfo)){
				$wxapi = new Wxapi();
				$wxuser = $wxapi->getUserInfo();
				$data['loginName'] = '';
				$data['chkPhone'] = 0;
				$data['openid'] = $this->wxopenid;
				$data['subscribe'] = $wxuser['subscribe']?1:0;
				$data['nickName'] = $wxuser['nickname'];
				$data['userSex'] = empty($wxuser['sex']) ? '2' : ($wxuser['sex']==1 ? '1' : '0');
				$data['userPhoto'] =empty($wxuser['headimgurl']) ? '/data/upload/avatar/default_32.jpg' : $wxuser['headimgurl'];
				$data['partner'] = 0;
				if(isset($_GET['pid'])){ //推广专用字段
					$data['partner'] = $_GET['pid'] ? $_GET['pid'] : 0;
				}
				$data['createTime'] =  date('Y-m-d H:i:s');
				$data['lastTime'] = date('Y-m-d H:i:s');
				$data['lastIP'] = get_client_ip();
				$us = M('users')->add($data);
				if($us){
					$exp_info = M("users_exp")->where("uid=$us")->find();
					if(empty($exp_info)){
						$user_exp = array();
						$user_exp['uid'] = $us;
						M("users")->where("userId=".$us)->save(array("userName"=>"嘻粉_".$us));
						M("users_exp")->add($user_exp);
					}
				}
				//存在推荐人
				if($data['partner']>0&&$us){
					$this->partner($data['partner'],$us);
				}
				D('Wx/Users')->loginByOpenid($this->wxopenid);
			}
		}
		/* 新增 end**/
		//初始化系统信息
		$m = D('Home/System');
		$GLOBALS['CONFIG'] = $m->loadConfigs();
		$this->assign("WST_USER",session('WST_USER'));//用户登录数据
		$this->assign("WST_IS_LOGIN",(session('WST_USER.userId')>0)?1:0); //用户是否登录

		//IP定位注释
		$areas= D('Home/Areas');
		$areaId2 = $this->getDefaultCity();
		$currArea = $areas->getArea($areaId2);
		$this->assign('currArea',$currArea);
   		$this->assign('searchType',(int)I("searchType",1));
   		$this->assign('CONF',$GLOBALS['CONFIG']);
   		$this->assign('WST_REFERE',$_SERVER['HTTP_REFERER']);
		$this->footer(); //加入底部
	}

	/**
	 * 分销会员操作
	 * $pid 推荐人ID
	 * $new_uid 新用户ID
	 */
	public function partner($pid,$new_uid){//推荐人ID
		$user['uid'] = $new_uid;
		$m = M ( "Users_exp" );
		$where = array();
		$where["uid"] = (int)$pid;
		$results = $m->where($where)->find();
		if(!empty($results['uid'])){
			$user ["p_a"] = $results['uid'];
			//增加分销人
			$a_info = array();
			$a_map = array();
			$a_map['uid'] = $results['uid'];
			$a_info['count_a'] = (int)$results['count_a']+1;
			$user_id = $m->where($a_map)->save ($a_info);
			if($results['p_a']){ //二级
				$where = array();
				$where["uid"] = $results['p_a'];
				$b_results = $m->where($where)->find ();
				if(!empty($b_results)){
					$b_info = array();
					$b_map = array();
					$b_map['uid'] = $b_results['uid'];
					$b_info['count_b'] = (int)$b_results['count_b']+1;
					$user_id =$m->where($b_map)->save ( $b_info );
					$user["p_b"] = $b_results['uid'];
					//推送消息暂无做
					if($b_results['p_a']){ //三级
						$where = array();
						$where["uid"] = $b_results['p_a'];
						$c_results = $m->where($where)->find ();
						if(!empty($c_results)){
							$c_info = array();
							$c_map = array();
							$c_map['uid'] = $c_results['uid'];
							$c_info['count_c'] = (int)$c_results['count_c']+1;
							$user_id = $m->where($c_map)->save ($c_info);
							$user["p_c"] = $c_results['uid'];
							//
							if($c_results['p_a']){ //四级
								$where = array();
								$where["uid"] = $c_results['p_a'];
								$d_results = $m->where($where)->find ();
								if(!empty($d_results)){
									$d_info = array();
									$d_map = array();
									$d_map['uid'] = $d_results['uid'];
									$d_info['count_d'] = (int)$d_results['count_d']+1;
									$user_id = $m->where($d_map)->save ($d_info);
									$user["p_d"] = $d_results['uid'];
									//
									if($d_results['p_a']){ //五级
										$where = array();
										$where["uid"] = $d_results['p_a'];
										$e_results = $m->where($where)->find ();
										if(!empty($e_results)){
											$e_info = array();
											$e_map = array();
											$e_map['uid'] = $e_results['uid'];
											$e_info['count_e'] = (int)$e_results['count_e']+1;
											$user_id = $m->where($e_map)->save ($e_info);
											$user["p_e"] = $e_results['uid'];
											//
											if($e_results['p_a']){ //六级
												$where = array();
												$where["uid"] = $e_results['p_a'];
												$f_results = $m->where($where)->find ();
												if(!empty($f_results)){
													$f_info = array();
													$f_map = array();
													$f_map['uid'] = $f_results['uid'];
													$f_info['count_f'] = (int)$f_results['count_f']+1;
													$user_id = $m->where($f_map)->save ($f_info);
													$user["p_f"] = $f_results['uid'];
													//
													if($f_results['p_a']){ //七级
														$where = array();
														$where["uid"] = $f_results['p_a'];
														$g_results = $m->where($where)->find ();
														if(!empty($g_results)){
															$g_info = array();
															$g_map = array();
															$g_map['uid'] = $g_results['uid'];
															$g_info['count_g'] = (int)$g_results['count_g']+1;
															$user_id = $m->where($g_map)->save ($g_info);
															$user["p_g"] = $g_results['uid'];
															//
															if($g_results['p_a']){ //八级
																$where = array();
																$where["uid"] = $g_results['p_a'];
																$h_results = $m->where($where)->find ();
																if(!empty($h_results)){
																	$h_info = array();
																	$h_map = array();
																	$h_map['uid'] = $h_results['uid'];
																	$h_info['count_h'] = (int)$h_results['count_h']+1;
																	$user_id = $m->where($h_map)->save ($h_info);
																	$user["p_h"] = $h_results['uid'];
																	//
																	if($h_results['p_a']){ //九级
																		$where = array();
																		$where["uid"] = $h_results['p_a'];
																		$j_results = $m->where($where)->find ();
																		if(!empty($j_results)){
																			$j_info = array();
																			$j_map = array();
																			$j_map['uid'] = $j_results['uid'];
																			$j_info['count_j'] = (int)$j_results['count_j']+1;
																			$user_id = $m->where($j_map)->save ($j_info);
																			$user["p_j"] = $j_results['uid'];
																		}
																	}
																}
															}
														}
													}
												}
											}
										}
									}
								}
							}//四级以后end
						}
					}
				}
			}
		}
		$map['uid'] = $new_uid;
		$m->where($map)->save($user);
	}


	/**
	 * 空操作处理
	 */
    public function _empty($name){
        $this->assign('msg',"你的思想太飘忽，系统完全跟不上....");
        $this->display('default/sys_msg');
    }
	/**
     * ajax程序验证,只要不是会员都返回-999
     */
    public function isUserLogin() {
    	$USER = session('WST_USER');
		if (empty($USER) || ($USER['userId']=='')){
			if(IS_AJAX){
				$this->ajaxReturn(array('status'=>-999,'url'=>'Users/login'));
			}else{
				$this->redirect("Users/login");
			}
		}
	}
	/**
	 * 商家ajax登录验证
	 */
	public function isShopLogin(){
		$USER = session('WST_USER');
		if (empty($USER) || $USER['userType']!=1){
			if(IS_AJAX){
				$this->ajaxReturn(array('status'=>-999,'url'=>'Shops/login'));
			}else{
				$this->redirect("Shops/login");
			}
		}
	}
	/**
	 * 用户登录验证-主要用来判断会员和商家共同功能的部分
	 */
	public function isLogin($userType = 'Users'){
		$USER = session('WST_USER');
		if (empty($USER)){
			if(IS_AJAX){
			    $this->redirect($userType."/login");
			}else{
				$this->isUserLogin();//hiro888
				//$this->ajaxReturn(array('status'=>-999,'url'=>$userType.'/login'));
			}
		}
   }
   /**
    * 检查登录状态
    */
   public function checkLoginStatus(){
   	   $USER = session('WST_USER');
	   if (empty($USER)){
	   	    die("{status:-999}");
	   }else{
	   		die("{status:1}");
	   }
   }
   /**
	 * 验证模块的码校验
	 */
	public function checkVerify($type){
		if(stripos($GLOBALS['CONFIG']['captcha_model'],$type) !==false) {
			$verify = new \Think\Verify();
			return $verify->check(I('verify'));
		}else{
			return true;
		}
		return false;
	}
	
    /**
     * 核对单独的验证码
	 * $re = false 的时候不是ajax返回
	 * @param  boolean $re [description]
	 * @return [type]      [description]
	 */
	public function checkCodeVerify($re = true){
		$code = I('code');
		$verify = new \Think\Verify(array('reset'=>false));    
		$rs =  $verify->check($code);		
		if ($re == false) return $rs;
		else $this->ajaxReturn(array('status'=>(int)$rs));
	}
    /**
	 * 单个上传图片
	 */
    public function uploadPic(){
	   $config = array(
		        'maxSize'       =>  0, //上传的文件大小限制 (0-不做限制)
		        'exts'          =>  array('jpg','png','gif','jpeg'), //允许上传的文件后缀
		        'rootPath'      =>  './Upload/', //保存根路径
		        'driver'        =>  'LOCAL', // 文件上传驱动
		        'subName'       =>  array('date', 'Y-m'),
		        'savePath'      =>  I('dir','uploads')."/"
		);
	    $folder = I("folder");
		$upload = new \Think\Upload($config);
		$rs = $upload->upload($_FILES);
		$Filedata = key($_FILES);
		if(!$rs){
			$this->error($upload->getError());
		}else{
			$images = new \Think\Image();
			$images->open('./Upload/'.$rs[$Filedata]['savepath'].$rs[$Filedata]['savename']);
			$newsavename = str_replace('.','_thumb.',$rs[$Filedata]['savename']);
			$vv = $images->thumb(I('width',300), I('height',300))->save('./Upload/'.$rs[$Filedata]['savepath'].$newsavename);
		    if(C('WST_M_IMG_SUFFIX')!=''){
		        $msuffix = C('WST_M_IMG_SUFFIX');
		        $mnewsavename = str_replace('.',$msuffix.'.',$rs[$Filedata]['savename']);
		        $mnewsavename_thmb = str_replace('.',"_thumb".$msuffix.'.',$rs[$Filedata]['savename']);
			    $images->open('./Upload/'.$rs[$Filedata]['savepath'].$rs[$Filedata]['savename']);
			    $images->thumb(I('width',700), I('height',700))->save('./Upload/'.$rs[$Filedata]['savepath'].$mnewsavename);
			    $images->thumb(I('width',250), I('height',250))->save('./Upload/'.$rs[$Filedata]['savepath'].$mnewsavename_thmb);
			}
			$rs[$Filedata]['savepath'] = "Upload/".$rs[$Filedata]['savepath'];
			$rs[$Filedata]['savethumbname'] = $newsavename;
			$rs['status'] = 1;
			if($folder=="Filedata"){
				$sfilename = I("sfilename");
				$fname = I("fname");
				$srcpath = $rs[$Filedata]['savepath'].$rs[$Filedata]['savename'];
				$thumbpath = $rs[$Filedata]['savepath'].$rs[$Filedata]['savethumbname'];
				echo "<script>parent.getUploadFilename('$sfilename','$srcpath','$thumbpath','$fname');</script>";
			}else{
				echo json_encode($rs);
			}
			
		}	
    }
	
	/**
	 * 产生验证码图片
	 * 
	 */
	public function getVerify(){
		// 导入Image类库
    	$Verify = new \Think\Verify();
    	$Verify->entry();
    }
   /**
	 * 页尾参数初始化
	 */
	public function footer(){
		$m = D('Home/Friendlinks');
		$friendLikds = $m->getFriendLinks();
		$this->assign('friendLikds',$friendLikds);
		$m = D('Home/Articles');
		$helps = $m->getHelps();
		$this->view->assign("helps",$helps);
	}
	/**
	 * 设置所在城市
	 */
	public function setDefaultCity($cityId){
		setcookie("areaId2", $cityId, time()+3600*24*90);
	}
	/**
	 * 定位所在城市
	 */
	public function getDefaultCity(){
		$areas= D('Home/Areas');
		return $areas->getDefaultCity();
	}
	

	/**
	 * 返回所有参数
	 */
	function WSTAssigns(){
		$params = I();
		$this->assign("params",$params);
	}
	
}