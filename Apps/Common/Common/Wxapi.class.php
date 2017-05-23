<?php
namespace Common\Common;
use Think\Controller;
class Wxapi extends Controller {

    private $data = array();
    private $nonceStr;
    private $timestamp;
    private $token;
    private $app_id;
    private $app_secret;
    private $MCH_ID;
    private $MCH_APIKEY;
    private $NOTIFY_URL;

    public function __construct() {
        header('Content-Type:text/html; charset=utf-8');
        $this->nonceStr = $this->createNoncestr(32);
        $this->timestamp = time();
        $m = D('Admin/Index');
        $wechat_data = F("wechat");
        if(!is_array($wechat_data)){
            $p = $m->loadConfigsForParent();
            F("wechat",$p[4]);
        }
        $this->MCH_ID = "1318628201";
        $this->MCH_APIKEY = "XHSxihuansha1350181xihuanshaQsiq";
        $this->NOTIFY_URL = "http://www.xihuansha.com/wxnotify.php";
        $this->token = $wechat_data[0]["fieldValue"];
        $this->app_id = $wechat_data[1]["fieldValue"];
        $this->app_secret = $wechat_data[2]["fieldValue"];
    }



    // 判断是否是在微信浏览器里
   public function isWeixinBrowser($from = 0) {
        if ((! $from && defined ( 'IN_WEIXIN' ) && IN_WEIXIN) || isset ( $_GET ['is_stree'] ))
            return true;

        $agent = $_SERVER ['HTTP_USER_AGENT'];
        if (! strpos ( $agent, "icroMessenger" )) {
            return false;
        }
        return true;
    }

    // php获取当前访问的完整url地址
   public function GetCurUrl() {
        $url = 'http://';
        if (isset ( $_SERVER ['HTTPS'] ) && $_SERVER ['HTTPS'] == 'on') {
            $url = 'https://';
        }
        if ($_SERVER ['SERVER_PORT'] != '80') {
            $url .= $_SERVER ['HTTP_HOST'] . ':' . $_SERVER ['SERVER_PORT'] . $_SERVER ['REQUEST_URI'];
        } else {
            $url .= $_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'];
        }
        // 兼容后面的参数组装
        if (stripos ( $url, '?' ) === false) {
            $url .= '?t=' . time ();
        }
        return $url;
    }

    //跳转
    public function location($url = "") {
        if ($url)
            $redirct = "window.location.href = '$url';";
        echo '<!doctype html><html><head><meta charset="utf-8"><title>正在跳转</title></head><body><script>' . $redirct . '</script></body></html>';
        exit;
    }

    /* 获取openid
     * $scope = snsapi_base 
     * snsapi_base （不弹出授权页面，直接跳转，只能获取用户openid），
     * snsapi_userinfo （弹出授权页面，可通过openid拿到昵称、性别、所在地。并且，即使在未关注的情况下，只要用户授权，也能获取其信息）
     */
    public function getOpenid() {
        $jurl = $this->GetCurUrl();
        if (!cookie('openid') || cookie('openidsafecode') != md5(cookie('openid')."xclk764j")) { //验证伪造cookie
            if (isset($_GET['code']) && $_GET['state'] == session('authorizestate')) {//验证伪造链接
                //第二步：通过code换取网页授权access_token
                $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $this->app_id . "&secret=" . $this->app_secret . "&code=" . $_GET['code'] . "&grant_type=authorization_code";
                $jsonkey = json_decode(file_get_contents($url), 1);
                if ($jsonkey['openid'] != "") {
                    cookie('openid', $jsonkey['openid'], time() + 3600 * 24 * 30);
                    cookie('openidsafecode', md5($jsonkey['openid']."xclk764j"), time() + 3600 * 24 * 30); //防止伪造cookie
                    $this->location($jurl);
                }
            }
            //第一步：用户同意授权，获取code
            $authorizestate = time();
            session('authorizestate', $authorizestate); //防止伪造链接
            $this->location("https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $this->app_id . "&redirect_uri=" . urlencode($jurl) . "&response_type=code&scope=snsapi_base&state=".$authorizestate."#wechat_redirect");
        }
        return cookie('openid');
    }
    

    /*
      获取access token
     */
    public function getAccessToken() {
        $data = S('wx_access_token');
        if ($data['expire_time'] < time()) {
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $this->app_id . "&secret=" .  $this->app_secret;
            $res = json_decode(file_get_contents($url), 1);
            $access_token = $res['access_token'];
            if ($access_token) {
                $data2['expire_time'] = time() + 7000;
                $data2['access_token'] = $access_token;
                $data2['expires_in'] = $res['expires_in'];
                S('wx_access_token', $data2);
            }
        } else {
            $access_token = $data['access_token'];
        }
        return $access_token;
    }
    
    /*
     * 获取未关注用户信息
     * snsapi_userinfo （弹出授权页面，可通过openid拿到昵称、性别、所在地。并且，即使在未关注的情况下，只要用户授权，也能获取其信息）
     * retuan array openid, nickname, sex, province, city, country, headimgurl, privilege, unionid
     */
    public function getSnsUserInfo(){
        $jurl = $this->GetCurUrl();
        if (isset($_GET['code']) && $_GET['state'] == session('authorizestate')) {//验证伪造链接
            //第二步：通过code换取网页授权access_token
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" .  $this->app_id . "&secret=" .  $this->app_secret . "&code=" . $_GET['code'] . "&grant_type=authorization_code";
            $jsonkey = json_decode(file_get_contents($url), 1);
            //第四步：拉取用户信息(需scope为 snsapi_userinfo)
            $access_token = $jsonkey['access_token'];
            $openid = $jsonkey['openid'];
            $url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
            $result = json_decode(file_get_contents($url), 1);
            
            //更新用户信息
            $account = M('user')->where(array('openid' => $result['openid']))->find();
            if(is_array($account)){
                $data = array();
                if(!$account['nickname'])
                    $data['nickname'] = $result['nickname'];
                if(!$account['gender'])
                    $data['gender'] = $result['sex'];
                if(!$account['headpic'] || $account['headpic'] == 'avatar/face.jpg')
                    $data['headpic'] = empty($result['headimgurl']) ? 'avatar/face.jpg' : $result['headimgurl'];
                M('account')->where(array('id' => $account['id']))->save($data);
            }
            return $result;
        }
        //第一步：用户同意授权，获取code
        $authorizestate = time();
        session('authorizestate', $authorizestate); //防止伪造链接
        $this->location("https://open.weixin.qq.com/connect/oauth2/authorize?appid=" .  $this->app_id . "&redirect_uri=" . urlencode($jurl) . "&response_type=code&scope=snsapi_userinfo&state=".$authorizestate."#wechat_redirect");
    }
    
    /*
     * 通过全局Access Token获取用户基本信息
     * @param string $returntype 'html'-返回json，'array'-返回数组
     */
    public function getUserInfo($returntype = '', $openid = '') {
        if($openid == '')
            $openid = $this->getOpenid();
        $acctoken = $this->getAccessToken();
        $urluser = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $acctoken . "&openid=" . $openid . "&lang=zh_CN";
        if ($returntype == 'html') {
            $userdata = file_get_contents($urluser);
        } else {
            $userdata = json_decode(file_get_contents($urluser), 1);
            $userdata['nickname'] = filter_utf8_char($userdata['nickname']);//转码特殊符号
        }
        return $userdata;
    }

    /*
      获取微信 jsaip ticket
     */
    public function getJsApiTicket() {
        $data = S('wx_jsapi_ticket');
        if ($data['expire_time'] < time()) {
            $accessToken = $this->getAccessToken();
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
            $res = json_decode(file_get_contents($url), 1);
            $ticket = $res['ticket'];
            if ($ticket) {
                $data2['expire_time'] = time() + 7000;
                $data2['jsapi_ticket'] = $ticket;
                S('wx_jsapi_ticket', $data2);
            }
            //$ticket = $res['jsapi_ticket'];
        } else {
            $ticket = $data['jsapi_ticket'];
        }
        return $ticket;
    }

    /**
     * 微信分享
     */
    public function getSignPackage() {
        $jsapiTicket = $this->getJsApiTicket();
        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $timestamp = $this->timestamp;
        $nonceStr = $this->nonceStr;
        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);

        $signPackage = array(
            "appId" => $this->app_id,
            "nonceStr" => $nonceStr,
            "timestamp" => $timestamp,
            "url" => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signPackage;
    }

    /*
      创建微信菜单
     */
    public function createMenu($param) {
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=' . $this->getAccessToken();
        if (!$param){
            $param = '{"button":[
    {"name":"订餐","sub_button":[{"type":"view","name":"便当","url":"http://'.$_SERVER['SERVER_NAME'].'/?m=home&c=menu&a=index2"}]},
    {"name":"活动","sub_button":[{"type":"view","name":"拍（zan）砖（mei）","url":"http://'.$_SERVER['SERVER_NAME'].'/?c=bbs&a=index"}]},
    {"name":"我的","sub_button":[{"type":"click", "name":"饥饿热线","key":"V1001_CALL"},
    {"type":"view","name":"我的订单","url":"http://'.$_SERVER['SERVER_NAME'].'/?c=order&a=orderlist"}]}
]}';
        }
        return http_post($url, $param);
    }
    
    /*
     * 创建二维码ticket
     * @param string $scene_type   二维码类型，QR_SCENE为临时,QR_LIMIT_SCENE为永久,QR_LIMIT_STR_SCENE为永久的字符串参数值
     * @param string $scene_id      场景ID，临时二维码非0整型，永久二维码1--100000，永久字符串长度为64位以内
     * @param string $expire_seconds    该二维码有效时间，不超过604800（即7天），临时二维码才需要传递
     * @return array array("errcode" => "1", "errmsg" => "二维码类型不能为空")
     * @return array array("ticket" => "", "expire_seconds" => 60, "url" => "")
     */
    public function createQrcode($scene_type, $scene_id, $expire_seconds = 0){
        $typeary = array('QR_SCENE', 'QR_LIMIT_SCENE', 'QR_LIMIT_STR_SCENE');
        $acctoken = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$acctoken";
        // 有效性检查
        if(!$scene_type) return array("errcode" => "1", "errmsg" => "二维码类型不能为空");
        if(!$scene_id) return array("errcode" => "2", "errmsg" => "场景ID不能为空");
        if(is_array(M('wx_qrcode')->where(array("scene_id"=>$scene_id))->find())) return array("errcode" => "3", "errmsg" => "场景ID已存在");
        // 接口查询
        if($expire_seconds) $param['expire_seconds'] = $expire_seconds;
        $param['action_name'] = $typeary[$scene_type];
        $param['action_info']['scene']['scene_id'] = $scene_id;
        $json = json_encode($param);
        $result = json_decode(http_post($url, $json), 1);
        //记录日志
        logger("\n[" . date('H:i:s') . "] Request\n" . $json, 'Wxqrcode');
        logger("\n[" . date('H:i:s') . "] Response\n" . $result, 'Wxqrcode');
        return $result;
    }
    
    /*
     * 长链接转短链
     * @param string 长链接地址
     * @return array array("errcode" => "1", "errmsg" => "二维码类型不能为空")
     * @return array array("errcode" => "0", "short_url" => "http:\/\/w.url.cn\/s\/AvCo6Ih")
     */
    public function shorturl($long_url){
        $acctoken = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/shorturl?access_token=$acctoken";
        if(!$long_url) return array("errcode" => "1", "errmsg" => "长链接地址不能为空");
        // 接口查询
        $param['action'] = "long2short";
        $param['long_url'] = $long_url;
        $json = json_encode($param);
        $result = json_decode(http_post($url, $json), 1);
        //记录日志
        logger("\n[" . date('H:i:s') . "] Request\n" . $json, 'Wxshturl');
        logger("\n[" . date('H:i:s') . "] Response\n" . $result, 'Wxshturl');
        return $result;
    }
    
    public function getusers($nextopenid){
        $acctoken = $this->getAccessToken();
        $json = '';
        $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=$acctoken&next_openid=$nextopenid";
        return json_decode(http_post($url, $json), 1);
    }

    /**
     * 	作用：产生随机字符串，不长于32位
     */
    public function createNoncestr($length = 32) {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str.= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /**
     * 	作用：格式化参数，签名过程需要使用
     */
    function formatBizQueryParaMap($paraMap, $urlencode) {
        $buff = "";
        foreach ($paraMap as $k => $v)
        {
            if($k != "sign" && $v != "" && !is_array($v)){
                $buff .= $k . "=" . $v . "&";
            }
        }

        $buff = trim($buff, "&");
        return $buff;
    }

    /**
     * 	作用：生成签名
     * 待生成
     */
    public function getSign($Obj) {
        //签名步骤一：按字典序排序参数
        foreach ($Obj as $k => $v) {
            $Parameters[$k] = $v;
        }
        ksort($Parameters);

        $String = $this->formatBizQueryParaMap($Parameters, false);
        //签名步骤二：在string后加入KEY
        $String = $String . "&key=" . $this->MCH_APIKEY;
        //签名步骤三：MD5加密
        $String = md5($String);
        //签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);
        return $result_;
    }

    /**
     * 	作用：array转xml
     */
    function arrayToXml($arr) {
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_numeric($val))
                $xml.="<" . $key . ">" . $val . "</" . $key . ">";
            else
               // $xml.="<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
                $xml.="<" . $key . ">" . $val . "</" . $key . ">";
        }
        $xml.="</xml>";
        return $xml;
    }

    /**
     * 	作用：将xml转为array
     */
    public function xmlToArray($xml) {
        //将XML转为array        
        $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $array_data;
    }

    /**
     * 	作用：以post方式提交xml到对应的接口url
     */
    public function postXmlCurl($xml, $url, $second = 30) {
        //初始化curl        
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOP_TIMEOUT, $second);
        //这里设置代理，如果有的话
        //curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
        //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);
        curl_close($ch);
        //返回结果
        if ($data) {
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            logger("[" . date('H:i:s') . "] postXmlCurl出错\n错误码:$error $url \n$xml", 'Wxpay');
           // showmsg("微信服务器繁忙，请重试！");
            return false;
        }
    }

    /**
     * 	作用：使用证书，以post方式提交xml到对应的接口url
     */
    function postXmlSSLCurl($xml, $url, $second = 30) {
        $ch = curl_init();
        //超时时间
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        //这里设置代理，如果有的话
        //curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
        //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //设置证书
        //使用证书：cert 与 key 分别属于两个.pem文件
        //默认格式为PEM，可以注释
        curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
        curl_setopt($ch, CURLOPT_SSLCERT, getcwd().'/App/Common/Common/apiclient_cert.pem');
        //默认格式为PEM，可以注释
        curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
        curl_setopt($ch, CURLOPT_SSLKEY, getcwd().'/App/Common/Common/apiclient_key.pem');
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        $data = curl_exec($ch);
        //返回结果
        if ($data) {
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            logger("[" . date('H:i:s') . "] postXmlSSLCurl出错\n错误码:$error $url \n$xml", 'Wxpay');
            //showmsg("微信服务器繁忙，请重试！");
            return false;
        }
    }

    /**
     * 	作用：打印数组
     */
    function printErr($wording = '', $err = '') {
        print_r('<pre>');
        echo $wording . "</br>";
        var_dump($err);
        print_r('</pre>');
    }

    /** 预生成订单
     * openid	用户openid
     * ordernum	订单号
     * amount	订单总金额
     * attach	填写帐户accid

     * return_code	通信标识 SUCCESS/FAIL
     * result_code	交易标识 SUCCESS/FAIL 交易是否成功
     * return_msg	返回信息，如非空，为错误原因
     * trade_type	【双标识均成历】功交易类型：JSAPI，NATIVE，APP
     * prepay_id	【双标识均成历】预支付交易会话标识 微信生成的预支付回话标识，用于后续接口调用中使用，该值有效期为2小时
     * code_url		【双标识均成历】二维码链接	trade_type为NATIVE是有返回，可将该参数值生成二维码展示出来进行扫码支付
     */
    public function unifiedorder($openid, $ordernum, $amount, $attach = '', $trade_type='JSAPI') {
        $ip = get_client_ip();
        if(substr($ordernum, 0, 5) == 'chong'){
            $body = "wxzf";
        }else{
            $body = "ddzf";
        }

        //判断是否是扫码支付
        if ($trade_type=='JSAPI'){
            $params = array(
                'appid' => $this->app_id,
                'attach' => $attach, //原样返回
                'body' => $body,
                'mch_id' => $this->MCH_ID,
                'nonce_str' => $this->nonceStr,
                'notify_url' => $this->NOTIFY_URL,
                'openid' => $openid,
                'out_trade_no' => $ordernum, //订单号
                'spbill_create_ip' => $ip,
                'total_fee' => $amount, //总金额（分）
                'trade_type' => 'JSAPI'
            );
        }elseif ($trade_type=='NATIVE'){
            $params = array(
                'appid' => $this->app_id,
                'mch_id' => $this->MCH_ID,
                'device_info' => "WEB",
                'nonce_str' => $this->nonceStr,
                'body' => $body,
                'attach' => $attach, //原样返回
                'out_trade_no' => $ordernum, //订单号
                'total_fee' => $amount, //总金额（分）
                'spbill_create_ip' => gethostbyname($_SERVER["SERVER_NAME"]),
                'time_start' => date('YmdHis', time()),
                'time_expire' => date('YmdHis', time() + 301),
                'notify_url' => $this->NOTIFY_URL,
                'trade_type' => "NATIVE",
                'product_id' => $ordernum
            );
        }

        ksort($params, SORT_STRING);
        $sign = $this->getSign($params);
        $params['sign'] = $sign;
        $postxml = $this->arrayToXml($params);
        logger("[" . date('H:i:s') . "] unifiedorder $ordernum\n" . json_encode($params), 'Wxpay');
        $posturl = "https://api.mch.weixin.qq.com/pay/unifiedorder";
        $poststr = $this->postXmlCurl($postxml, $posturl);
        logger("[" . date('H:i:s') . "] unifiedorder return $ordernum\n" . $poststr, 'Wxpay');
        $result = simplexml_load_string($poststr, 'SimpleXMLElement', LIBXML_NOCDATA);
        return $result;
    }
    
    public function getParameters($prepay_id) {
        $params = array('appId' => $this->app_id,
            'timeStamp' => $this->timestamp,
            'nonceStr' => $this->nonceStr, //随机字符串
            'package' => "prepay_id=$prepay_id",
            'signType' => 'MD5');
        ksort($params, SORT_STRING);
        $params['paySign'] = $this->getSign($params);
        return $params;
    }

    public function checkSign($data) {
        $tmpData = $data;
        unset($tmpData['sign']);
        $sign = $this->getSign($tmpData); //本地签名
        if ($data['sign'] == $sign) {
            return TRUE;
        }
        return FALSE;
    }
    
    /** 派送红包
     * $openid	用户openid
     * $ordernum	订单号,yyyymmdd+10位一天内不能重复的数字。 
     * $amount	订单总金额
     * $wishing	红包祝福语
     * $act_name    活动名称
     * $remark  备注信息

     * return_code	返回状态码
     * return_msg	返回信息，如非空，为错误原因
     * 以下字段在return_code为SUCCESS的时候有返回
     * sign             签名
     * result_code      业务结果，SUCCESS/FAIL
     * err_code         错误码信息
     * err_code_des     结果信息描述
     * 以下字段在return_code和result_code都为SUCCESS的时候有返回
     * mch_billno       商户订单号
     * mch_id           商户号
     * wxappid          公众账号appid
     * re_openid        用户openid
     * total_amount     付款金额
     * send_time        发放成功时间
     * send_listid      微信单号
     */
    public function sendMoneygift($openid, $ordernum, $amount, $wishing, $act_name, $remark) {
        $ip = get_client_ip();
        
        $params = array(
            'nonce_str' => $this->nonceStr,
            'mch_billno' => $this->MCH_ID.$ordernum,//data('Ymd').rand(),
            'mch_id' =>  $this->MCH_ID,
            'wxappid' => $this->app_id,
            'nick_name' => 'BBOX',
            'send_name' => 'BBOX',
            're_openid' => $openid,
            'total_amount' => $amount, //总金额（分）
            'min_value' => $amount, //总金额（分）
            'max_value' => $amount, //总金额（分）
            'total_num' => 1, //总金额（分）
            'wishing' => $wishing, //红包祝福语
            'client_ip' => $ip,
            'act_name' => $act_name, //活动名称
            'remark' => $remark, //备注
            'logo_imgurl' => 'http://b-box.cc/Public/Home/images/moneygift.jpg');//商户logo的url
        ksort($params, SORT_STRING);
        $sign = $this->getSign($params);
        $params['sign'] = $sign;

        $postxml = $this->arrayToXml($params);
        logger("[" . date('H:i:s') . "] sendMoneygift $ordernum\n" . json_encode($params), 'Wxgift');
        $posturl = "https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack";
        $poststr = $this->postXmlSSLCurl($postxml, $posturl);
        logger("[" . date('H:i:s') . "] sendMoneygift reutrn $ordernum\n" . $poststr, 'Wxgift');
        $result = simplexml_load_string($poststr, 'SimpleXMLElement', LIBXML_NOCDATA);
        return $result;
    }
    
    //$body-商品描述,$detail-商品详情
    public function scanqrcodepay($body, $detail, $openid, $ordernum, $amount, $attach = '') {
        $ip = get_client_ip();
        $params = array('appid' => $this->app_id,
            'mch_id' => $this->MCH_ID,
            'device_info' => 'WEB',
            'nonce_str' => $this->nonceStr,
            'body' => $body,
            'detail' => $detail,
            'attach' => $attach, //原样返回
            'out_trade_no' => $ordernum, //订单号
            'fee_type' => 'CNY',
            'total_fee' => $amount, //总金额（分）
            'spbill_create_ip' => $ip,
            'time_start' => date('YmdHis', time()),
            'time_expire' => date('YmdHis', time() + 600),
            'notify_url' =>  $this->NOTIFY_URL,
            'trade_type' => 'JSAPI',
            'openid' => $openid
        );
        ksort($params, SORT_STRING);
        $sign = $this->getSign($params);
        $params['sign'] = $sign;
        $postxml = $this->arrayToXml($params);
        logger("[" . date('H:i:s') . "] scanqrcodepay $ordernum\n" . json_encode($params), 'Wxpay');
        $posturl = "https://api.mch.weixin.qq.com/pay/unifiedorder";
        $poststr = $this->postXmlCurl($postxml, $posturl);
        logger("[" . date('H:i:s') . "] scanqrcodepay return $ordernum\n" . $poststr, 'Wxpay');
        $result = simplexml_load_string($poststr, 'SimpleXMLElement', LIBXML_NOCDATA);
        return $result;
    }

}
