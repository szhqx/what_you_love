<?php
namespace Wx\Action;
use Common\Common\Wxapi;
use Think\Controller;

//微信消息控制器
class WxmsgAction extends Controller{
    private $postObj;
    private $time;
    private $wechat;
    function _initialize() {
        $this->time = time();
        $wechat_data = F("wechat");
        if(!is_array($wechat_data)){
            $m = D('Admin/Index');
            $p = $m->loadConfigsForParent();
            F("wechat",$p[4]);
        }
        $this->wechat = F("wechat");;
    }


    public function index() {

        $this->valid();
    }

    public function valid() {
        $echoStr = $_GET["echostr"];
        //valid signature , option
        if ($this->checkSignature()) {
            if($echoStr){
               echo $echoStr;exit;
            }
            $this->requestMsg();
            exit;
        }
    }

    /* 处理请求 */
    public function requestMsg() {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        logger("\n[" . date('H:i:s') . "] Request\n" . $postStr, 'Wxmsg');
        if (!empty($postStr)) {
            $this->postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $type = strval($this->postObj->MsgType);
            if($type == 'event'){
                //保存事件
                $data = array(
                    'msgtype' => $type,
                    'tousername' => strval($this->postObj->ToUserName),
                    'fromusername' => strval($this->postObj->FromUserName),
                    'event' => strval($this->postObj->Event),
                    'xml' => $postStr,
                    'createtime' => strval($this->postObj->CreateTime)
                );
                M('wx_event')->add($data);
                //处理事件
                $this->reqevent();
            }elseif(in_array($type, array('text', 'image', 'voice', 'video', 'shortvideo', 'location', 'link'))){
                //保存消息
                $data = array(
                    'msgid' => strval($this->postObj->MsgId),
                    'msgtype' => $type,
                    'tousername' => strval($this->postObj->ToUserName),
                    'fromusername' => strval($this->postObj->FromUserName),
                    'xml' => $postStr,
                    'createtime' => strval($this->postObj->CreateTime)
                );
                M('wx_message')->add($data);
            }

            //自动回复
            $this->autoreply();

        } else {
            echo "";
            exit;
        }
    }

    /* 处理事件 */
    private function reqevent(){
        $event = strval($this->postObj->Event);
        $openid = strval($this->postObj->FromUserName);
        $eventkey = strval($this->postObj->EventKey);
        if($event == 'subscribe'){
            //扫码关注 - 未关注
            if($eventkey != ''){
                $ticket = strval($this->postObj->Ticket);
                M('wx_qrcode_scan')->add(array('openid' => $openid, 'subscribe' => 0, 'scene_id' => $eventkey, 'ticket' => $ticket, 'dateline' => time()));
            }
            //查找关注
            M('account')->where(array('openid' => $openid))->save(array('subscribe'=> 1));
        }elseif($event == 'unsubscribe'){
            //取消关注
            M('account')->where(array('openid' => $openid))->save(array('subscribe'=> 2));
        }elseif($event == 'SCAN'){
            //扫码关注 - 已关注
            $ticket = strval($this->postObj->Ticket);
            M('wx_qrcode_scan')->add(array('openid' => $openid, 'subscribe' => 1, 'scene_id' => $eventkey, 'ticket' => $ticket, 'dateline' => time()));
        }elseif($event == 'LOCATION'){
            //上报位置 $postObj->Latitude;
        }
    }

    /* 自动回复 */
    private function autoreply(){
        $type = strval($this->postObj->MsgType);
        $content = trim(strval($this->postObj->Content));
        $event = strval($this->postObj->Event);
        if($type == 'text'){
            //关键字回复
            $replys = M('wx_reply')->where(array('reqtype' => 'text', 'enable' => 1))->order("sort DESC, id DESC")->select();
            foreach ($replys as $reply){
                //消息自动回复
                if($reply['rules'] == '') return $this->responseMsg($reply);
                //规则匹配
                $rules = json_decode($reply['rules'], 1);
                foreach ($rules as $rule){
                    foreach($rule as $key => $value){
                        if($key == 'full' && $content == $value) return $this->responseMsg($reply);
                        if($key == 'like' && strpos($content, $value) !== false) return $this->responseMsg($reply);
                    }
                }
            }
        }elseif($type == 'event' && $event == 'subscribe'){
            //关注回复
            $reply = M('wx_reply')->where(array('reqtype' => 'subscribe', 'enable' => 1))->find();
            if(is_array($reply)) $this->responseMsg($reply);
        }elseif($type == 'event' && $event == 'CLICK'){
            //点击
            $eventkey = strval($this->postObj->EventKey);//rules
            $reply = M('wx_reply')->where(array('reqtype' => 'click', 'rules' =>$eventkey, 'enable' => 1))->find();
            if(is_array($reply)) $this->responseMsg($reply);
        }
    }

    /* 回复信息 */
    private function responseMsg($reply){
        if($reply['msgtype'] == 'text'){
            $this->rsptext($reply['content']);
        }elseif($reply['msgtype'] == 'news'){
            $data = json_decode($reply[content], 1);
            if(count($data)) $this->rspnews($data);
        }
    }

    /*
     * 输出文本
     * @param string $content   发送内容
     */
    private function rsptext($content){
        $data['ToUserName'] = $this->postObj->FromUserName;
        $data['FromUserName'] = $this->postObj->ToUserName;
        $data['CreateTime'] = $this->time;
        $data['MsgType'] = "text";
        $data['Content'] = $content;
        $resultStr = $this->ary2xml($data, 'xml');
        logger("\n[" . date('H:i:s') . "] Response\n" . $resultStr, 'Wxmsg');
        echo $resultStr;
    }

    /*
     * 输出多图文
     * @param array $news   文章 Title / Description / PicUrl / Url
     */
    public function rspnews($news){
        $data['ToUserName'] = strval($this->postObj->FromUserName);
        $data['FromUserName'] = strval($this->postObj->ToUserName);
        $data['CreateTime'] = $this->time;
        $data['MsgType'] = "news";
        $data['ArticleCount'] = count($news);
        foreach ($news as $new){
            $data['Articles'][] = array('item' => $new);
        }
        $resultStr = $this->ary2xml($data, 'xml');
       logger("\n[" . date('H:i:s') . "] Response\n" . $resultStr, 'Wxmsg');
        echo $resultStr;
    }

    private function ary2xml($ary, $code){
        $result = "";
        if($code && !is_numeric($code)) $result.= "<$code>\n";
        foreach($ary as $key => $value){
            if(is_array($value)){
                $result.= $this->ary2xml($value, $key);
            }else{
                if(!is_numeric($key)) $result.= "<$key>";
                $result.= is_numeric($value) ? $value : "<![CDATA[$value]]>";
                if(!is_numeric($key)) $result.= "</$key>\n";
            }
        }
        if($code && !is_numeric($code)) $result.= "</$code>\n";
        return $result;
    }



    private function checkSignature() {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = $this->wechat[0]['fieldValue'];
        $tmpArr = array($token, $timestamp, $nonce);//C('token')
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }





}
