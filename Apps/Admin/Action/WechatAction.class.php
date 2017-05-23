<?php
namespace Admin\Action;
use Common\Common\Wxapi;

/**
 * ============================================================================
 * QianPokMall商城
 * 官网地址:http://www.qianpok.com
 * 联系QQ:376983512
 * ============================================================================
 * 微信控制器
 */
class WechatAction extends BaseAction {
	private $wechat;
	public function __construct()
	{
		parent::__construct();
		$this->wechat = F("wechat");
	}

	/*
	 * 自定义菜单列表
	 */
	public function menu(){
		$token = $this->wechat[0]["fieldValue"];
		$app_id  = $this->wechat[1]["fieldValue"];
		$app_secret = $this->wechat[2]["fieldValue"];
		if((!isset($token)||!isset($app_id)||!isset($app_secret))||(empty($token)||empty($app_id)||empty($app_secret)))
			$this->error("你未进行微信配置,请先进行微信配置",U('Index/toMallConfig'));

		$class=M('Wechat_menu')->where(array('token'=>$token,'pid'=>0))->order('sort asc')->select();//dump($class);
		foreach($class as $key=>$vo){
			$c=M('Wechat_menu')->where(array('token'=>$token,'pid'=>$vo['id']))->order('sort asc')->select();
			$class[$key]['class']=$c;
		}
		$this->assign('class',$class);

		$this->display('/wechat/menu');
	}

	/**
	 * 自定义菜单提交
	 */

	public function menu_post(){

		$datas =array();
		$data  =array();
		$data['token']= $datas['token']= $this->wechat[0]["fieldValue"];
		$db = M('Wechat_menu');

		if($_REQUEST['new']){
			for($i=1;$i<=count($_REQUEST['new']['sort']);$i++){
				foreach($_REQUEST['new'] as $k=>$v){
					$data[$k] = htmlspecialchars($_REQUEST['new'][$k][$i], ENT_QUOTES);
				}
				if($data) $db->data($data)->add();
			}
		}

		foreach($_REQUEST['ps'] as $kp=>$vp){
			$datas['id'] = $kp;
			$datas['title']   =   htmlspecialchars($_REQUEST['ps'][$kp]['title'], ENT_QUOTES);
			$datas['keyword'] =   $_REQUEST['ps'][$kp]['keyword'];
			$datas['sort']    =   intval($_REQUEST['ps'][$kp]['sort']);
			$datas['type']    =   intval($_REQUEST['ps'][$kp]['type']);
			$datas['is_show'] =   $_REQUEST['ps'][$kp]['is_show']==1?1:0;
			$db->data($datas)->save();
		}
		$this->success("操作成功！");
	}
	/*
	 * 自定义菜单删除
	 */
	public function  class_del(){
		$class=M('Wechat_menu')->where(array('token'=>$this->wechat[0]["fieldValue"],'pid'=>I('get.id')))->order('sort desc')->find();
		if($class==false){
			$back=M('Wechat_menu')->where(array('token'=>$this->wechat[0]["fieldValue"],'id'=>I('get.id')))->delete();
			if($back==true){
				$this->success('删除成功');
			}else{
				$this->error('删除失败');
			}
		}else{
			$this->error('请删除该分类下的子分类');

		}
	}

	/**
	 * 生成自定义菜单数据
	 */

	public function  class_send(){
		if(IS_GET){
			$token = $this->wechat[0]["fieldValue"];
			$data = '{"button":[';
			$class=M('Wechat_menu')->where(array('token'=>$token,'pid'=>0,'is_show'=>1))->limit(3)->order('sort asc')->select();
			$kcount=M('Wechat_menu')->where(array('token'=>$token,'pid'=>0,'is_show'=>1))->limit(3)->order('sort asc')->count();
			$k=1;
			foreach($class as $key=>$vo){
				//主菜单
				$data.='{"name":"'.$vo['title'].'",';
				$c=M('Wechat_menu')->where(array('token'=>$token,'pid'=>$vo['id'],'is_show'=>1))->limit(5)->order('sort asc')->select();
				$count=M('Wechat_menu')->where(array('token'=>$token,'pid'=>$vo['id'],'is_show'=>1))->limit(5)->order('sort asc')->count();
				//子菜单
				if($c!=false){
					$data.='"sub_button":[';
				}else{
					if(stristr($vo['keyword'],"http")){
						$data.='"type":"view","name":"'.$vo['title'].'","url":"'.$vo['keyword'].'"';
					}else{
						$data.='"type":"click","name":"'.$vo['title'].'","key":"'.$vo['keyword'].'"';
					}
				}
				$i=1;
				foreach($c as $voo){
					//echo 2;
					if($i==$count){
						if(stristr($voo['keyword'],"http")){
							$data.='{"type":"view","name":"'.$voo['title'].'","url":"'.$voo['keyword'].'"}';
						}else{
							$data.='{"type":"click","name":"'.$voo['title'].'","key":"'.$voo['keyword'].'"}';
						}
					}else{
						if(stristr($voo['keyword'],"http")){
							$data.='{"type":"view","name":"'.$voo['title'].'","url":"'.$voo['keyword'].'"},';
						}else{
							$data.='{"type":"click","name":"'.$voo['title'].'","key":"'.$voo['keyword'].'"},';
						}
					}
					$i++;
				}
				if($c!=false){
					$data.=']';
				}

				if($k==$kcount){
					$data.='}';
				}else{
					$data.='},';
				}
				$k++;
			}
			$data.=']}';
			$wxapi = new Wxapi();
			$obj=json_decode($wxapi->createMenu($data));
			echo $obj->errcode;
			exit;
		} else {
			echo 3;
			exit;
		}
	}


	public function curl_get_contents($url, $timeout=1){
		$curlHandle = curl_init();
		curl_setopt($curlHandle, CURLOPT_URL, $url);
		curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 5);
		curl_setopt($curlHandle, CURLOPT_TIMEOUT, $timeout);
		$result = curl_exec($curlHandle);
		curl_close($curlHandle);
		return $result;
	}
}