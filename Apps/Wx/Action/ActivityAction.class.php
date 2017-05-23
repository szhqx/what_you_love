<?php
namespace Wx\Action;
use Common\Common\Wxapi;

class ActivityAction extends BaseAction {
    public function _initialize(){
        $this->_activity_mod = D("activity");
    }
    //首页
    public function index(){
        //活动公开数据
        $rs = $this->_activity_mod->getActivityList();
        //print_r($rs);
        $this->assign("activity",$rs);
        if(IS_AJAX){
            if($rs['totalPage']<$rs['currPage']){
                $data['status'] = 0;
                $data['message'] = '';
            }else{
                $data['status'] = 1;
                $data['message'] = $this->fetch('activity/index_p');
            }
            echo json_encode($data);
            exit;
        }
        $this->assign("title_name","活动列表");
        $this->display('activity/index');
	}
    /**
     * 详情
     */
	public function show(){

        $this->assign("title_name","活动详情");
        $act_id['activityId'] = I("get.id");
        if(empty($act_id)){
            $this->error("没找到该活动！");
        }
        $activity = $this->_activity_mod->getActivity($act_id);

        if(empty($activity)){
            $this->error("没找到该活动！");
        }
        $nowtime = time();
        $apply = 2; //活动结束
        if(strtotime($activity['end_apply'])>$nowtime){ //报名结束时间大于现在时间，可以报名
           $apply = 1;
        }
        $userId = (int)session('WST_USER.userId');
        $log = M("activity_userlog")->where("act_id=".$act_id['activityId'])->select();

        foreach($log as $key=>$val){
             if($val['userId'] == $userId ){ //报过名
                 $apply =3;
             }
        }
        //print_r($apply);
        if($activity['userId'] == $userId){
            $apply = 3;
            $this->assign("joinuser",1);
        }
        $activity['activityPhoto'] = json_decode($activity['activityPhoto']);

        $this->assign("joindata",$log);
        $this->assign("apply",$apply);
        $this->assign("info",$activity);
        $this->display('activity/show');
    }

    /**
     * 活动报名
     */
    public function  gojoin(){
        $this->isUserLogin();
        $actId = I('get.actid');
        $actData = M("activity")->where("activityId='$actId'")->find();
        $userId = (int)session('WST_USER.userId');
        $am = M("activity_userlog");
        if($am->where("userId='$userId' AND act_id='$actId'")->find()){
            showmsg("你已经报名此活动,无需重复报名","/wx/activity/index");
        }

       if(strtotime($actData['end_apply'])<time()){
            showmsg("活动报名已结束","/wx/activity/index");
        }
        $this->assign("actId",$actId);
        if(empty($actId)){
            showmsg("报名活动不存在");
        }
        if(IS_POST){
           // $images =  session("upimg");
            //if(empty($images)){
            //    showmsg("收据上传失败");
           // }
            $username = I('post.username');
            $mobile = I('post.mobile');
            $actIds = I('post.actId');
            if(empty($username)){
                showmsg("请填写联系人");
            }
            if((empty($mobile) || !preg_match("/^1[34578]{1}\d{9}$/",$mobile))){
                showmsg("请正确填写手机号码");
            }
            $actData = M("activity")->where("activityId='$actIds'")->find();
            if(strtotime($actData['end_apply'])<time()){
                showmsg("活动报名已结束","/wx/activity/index");
            }
            if($actData['user_num']<$actData['success_num']){
                showmsg("活动人数已经达到！","/wx/activity/index");
            }
            if($userId==$actData['userId']){
                showmsg("该活动是你发起的，无需报名！","/wx/activity/index");
            }
            $data = array(
                "userId"=>$userId,
                "act_id"=>$actIds,
               // "receipt_img"=>$images,
                "username"=>$username,
                "mobile"=>$mobile,
                "createTime"=>date("Y-m-d H:i:s"),
            );
            if($am ->add($data)){
                M('activity')->where("activityId='$actIds'")->setInc('success_num', 1);
                showmsg("活动报名成功","/wx/activity/index");
            }
            showmsg("系统繁忙，稍后重试！");
        }
        $this->display('activity/gojoin');
    }

    /**
     * 查看报表
     ***/
    public function lookstatement(){
        $actid = I("get.actid");
        if(empty($actid)){
            $this->error("没找到该活动！");
        }
        $data = M("activity_data")->where("actId=$actid")->find();
        $this->assign("object",$data);
        $this->display('activity/lookstatement');
    }
    /**
     * 上传报表
     ***/
    public function upstatement(){
        $act_id = I("get.actid");
        $datas = M("activity_data")->where("actId=$act_id")->find();
        if(!empty($datas)){
            $url = 'http://'.$_SERVER['SERVER_NAME'].'/wx/activity/lookstatement/actid/'.$act_id;
            header("location:$url");
        }
        if(empty($act_id)){
            $this->error("没找到该活动！");
        }
        $this->assign("actId",$act_id);
        if(IS_POST){
            $totalIncome = I('post.totalIncome');
            $totalExpenditure = I('post.totalExpenditure');
            $aggregateBalance = I('post.aggregateBalance');
            $actId = I('post.actId');
            $upload = new \Think\Upload(C('UPLOAD_SET'));
            if($_FILES['file_img']['size']>0){ //存在
                $file =array();
                $file['file_img'] = $_FILES['file_img'];
                $info = $upload->upload($file);
                $data['value'] = 'Upload/Activity/'.$info['file_img']['savepath'].$info['file_img']['savename'];
                $picurl = $data['value'];
            }
            if(empty($actId)){
                $this->error("没找到该活动！");
            }
            if(empty($totalIncome)){
                showmsg("活动总收入不能为空");
            }
            if(empty($totalExpenditure)){
                showmsg("活动总支出不能为空");
            }
            if(empty($aggregateBalance)){
                showmsg("活动总结余不能为空");
            }
            if(empty($picurl)){
                showmsg("活动报表数据图不能为空");
            }
            $data = array(
                "totalIncome"=>$totalIncome,
                "totalExpenditure"=>$totalExpenditure,
                "aggregateBalance"=>$aggregateBalance,
                "actId"=>$actId,
                "picurl"=>$picurl,
                "createTime"=>date("Y-m-d H:i:s"),
            );
            $res = M("activity_data")->add($data);
            if($res){
                M("activity")->where("activityId='$actId'")->save(array("isUp"=>1));
                showmsg("提交成功");
            }
        }
        $this->display('activity/upstatement');
    }


    public function imgadd(){
        header("Content-type: application/json");
        $result = $this->upload($_FILES['file_img']);
    }

    public function upload($file) {

       // $id=$_GET['id']=1;
        //删除原图
        //$old_picimg = M("items")->where(array('id'=>$id))->getField('picture'); //原图
       // $smallpic = M("items")->where(array('id'=>$id))->getField('smallpic');//小图
//        if($old_picimg!=''){
//            // $old_s_img = $this->get_thumb_img($old_picimg,'');
//            $old_smallimg ='small/'.$smallpic;//$this->get_thumb_img($smallpic,'');
//            is_file('./Public/upload/'.$old_picimg) && @unlink('./Public/upload/'.$old_picimg);
//            is_file('./Public/upload/'.$old_smallimg) && @unlink('./Public/upload/'.$old_smallimg);
//        }
        $year = date('Y');
        $month = date('m');
        $uploaddir = './Upload/Activity/'.$year."/".$month."/";
        $this->make_dir($uploaddir);
        $upload = new \Common\Common\Upload($uploaddir,"");
        //上传新图
        if ($file['name'] != "") {
            $upfile = $upload->upload_image($file, $uploaddir); //上传的文件域
            $to_files = TRUE;
            if($to_files){
                $smalldir = $uploaddir . '/small';
                $this->make_dir($smalldir);
                $thumb_img = $upload->make_thumb($upfile,$uploaddir, '50', '50');//设置图片上传大小
            }
            $data['picture'] = $upfile;
            $data['smallpic'] = $thumb_img;
            session("upimg",$uploaddir.$data['picture']);
        }
        return ;
    }


    /*
    * *扩展上传创建目录
    * *$uploaddir = './Data/upload/upfile/' . $a . '/';
     *  $tath = $this->make_dir($uploaddir);
    */
    function make_dir($folder) {  //创建目录
        $reval = false;
        if (!file_exists($folder)) {
            @umask(0);
            preg_match_all('/([^\/]*)\/?/i', $folder, $atmp);
            $base = ($atmp[0][0] == '/') ? '/' : '';
            foreach ($atmp[1] AS $val) {
                if ('' != $val) {
                    $base .= $val;
                    if ('..' == $val || '.' == $val) {
                        $base .= '/';
                        continue;
                    }
                } else {
                    continue;
                }
                $base .= '/';
                if (!file_exists($base)) {
                    if (@mkdir(rtrim($base, '/'), 0777)) {
                        @chmod($base, 0777);
                        $reval = true;
                    }
                }
            }
        } else {
            $reval = is_dir($folder);
        }
        clearstatcache();
        return $reval;
    }


}
