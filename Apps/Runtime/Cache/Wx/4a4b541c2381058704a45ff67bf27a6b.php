<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<!DOCTYPE html >
<html>
<head>
<meta name="Generator" content="ECSHOP v2.7.3" />
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width">
  <title>会员登录</title>
  <meta name="Keywords" content="" />
  <meta name="Description" content="" />
  <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
  <link rel="stylesheet" href="/static/wx/css/public.css">
  <link rel="stylesheet" href="/static/wx/css/loginxin.css">
<script type="text/javascript" src="/static/wx/js/jquery.js"></script>
<script type="text/javascript" src="/static/wx/js/jquery.json.js"></script><script type="text/javascript" src="/static/wx/js/transport.js"></script>    <script type="text/javascript" src="/static/wx/js/common.js"></script><script type="text/javascript" src="/static/wx/js/utils.js"></script><script type="text/javascript" src="/static/wx/js/user.js"></script></head>
<body>
<div class="tab_nav">
        <div class="header">
          <div class="h-left"><a class="sb-back" href="javascript:history.back(-1)" title="返回"></a></div>
          <div class="h-mid">会员登录                                                                	
                </div>

        </div>
      </div>
  
    <div class="layout">
    <div class="nl-content">
      <div class="nl-frame-container">
        <div class="ng-form-area ">
          <!---->
            <div class="shake-area" >
            <dl style=" border-bottom:1px solid #ccc">
            <dt>账户</dt><dd><input type="text"   id="loginName" name="loginName"  placeholder="请输入用户名/邮箱" value=""/></dd>
            </dl>

              <dl>
                <dt>登录密码</dt> <dd><input type="password"   id="loginPwd" name="loginPwd"  placeholder="请输入密码" class="c-form-txt-normal"/></dd>
              </dl>

              <dl>
                <dt>验证码</dt> <dd> <input id="verify" style="ime-mode:disabled" name="verify" class="text text-1" tabindex="6" autocomplete="off" maxlength="6" placeholder="验证码" type="text"/></dd>
              </dl>

               <dl>
                <dt>&nbsp;</dt> <dd> <img style='vertical-align:middle;cursor:pointer;height:39px;' class='verifyImg' src='/Apps/Home/View/default/images/clickForVerify.png' title='刷新验证码' onclick='javascript:getVerify()'/> </dd>
              </dl>
            </div>
                        
            <input class="button orange" type="submit" onclick="checkLoginInfo();" value="立即登录">

            <div class="ng-foot">
              <div class="ng-cookie-area" >
                <label >
                  <input class="checkbox" id="rememberPwd" name="rememberPwd" checked="checked" type="checkbox"/>&nbsp;请保存我这次的登录信息</label>
              </div>
              <div class="ng-link-area" >
                <span >
                  <a href="#<?php echo U('user/register');?>" >免费注册</a>
                </span>
                 <span class="user_line"></span>
                   <span >
                  <a href="<?php echo U('Users/forgetPass');?>" >忘记密码？</a>
                </span>
              </div>
              <div class="third-area ">
                <div class="third-area-a">用以下方式互联登录</div>
                <a class="ta-qq" href="#<?php echo U('oauth/index',array('mod'=>'qq'));?>" target="_blank" title="QQ"></a>
                <a class="ta-weibo" href="#<?php echo U('oauth/index',array('mod'=>'weibo'));?>" target="_blank" title="weibo"></a>
                <a class="ta-alipay" href="#<?php echo U('oauth/index',array('mod'=>'alipay'));?>" target="_blank" title="alipay"></a>
              </div>
            </div>

        </div>
      </div>
    </div>

  </div>
<script src="/Public/js/common.js"></script>
<script src="/Apps/Wx/View/userlogin.js"></script>
<script>
  $(function(){getVerify();})
</script>
<script type="text/javascript">
var process_request = "正在处理您的请求...";
var username_empty = "- 用户名不能为空。";
var username_shorter = "- 用户名长度不能少于 3 个字符。";
var username_invalid = "- 用户名只能是由字母数字以及下划线组成。";
var password_empty = "- 登录密码不能为空。";
var password_shorter = "- 登录密码不能少于 6 个字符。";
var confirm_password_invalid = "- 两次输入密码不一致";
var email_empty = "- Email 为空";
var email_invalid = "- Email 不是合法的地址";
var agreement = "- 您没有接受协议";
var msn_invalid = "- msn地址不是一个有效的邮件地址";
var qq_invalid = "- QQ号码不是一个有效的号码";
var home_phone_invalid = "- 家庭电话不是一个有效号码";
var office_phone_invalid = "- 办公电话不是一个有效号码";
var mobile_phone_invalid = "- 手机号码不是一个有效号码";
var msg_un_blank = "* 用户名不能为空";
var msg_un_length = "* 用户名最长不得超过7个汉字";
var msg_un_format = "* 用户名含有非法字符";
var msg_un_registered = "* 用户名已经存在,请重新输入";
var msg_can_rg = "* 可以注册";
var msg_email_blank = "* 邮件地址不能为空";
var msg_email_registered = "* 邮箱已存在,请重新输入";
var msg_email_format = "* 邮件地址不合法";
var msg_blank = "不能为空";
var no_select_question = "- 您没有完成密码提示问题的操作";
var passwd_balnk = "- 密码中不能包含空格";
var username_exist = "用户名 %s 已经存在";
//刷新验证码
function getVerify() {
  $('.verifyImg').attr('src','/Wx/Users/getVerify','rnd='+Math.random());
}
</script>
<link rel="stylesheet" href="/Public/plugins/layer/skin/layerwx.css">
<script src="/static/wx/bx/js/msgalert.js"></script>
<script src="http://cdn.bootcss.com/fastclick/1.0.6/fastclick.min.js"></script>
<script>
    $(document).ready(function(){
            //加速点击
        FastClick.attach(document.body);
    })
</script>
<!--微信分享-->
<?php if($signPackage != ''): ?><script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script>
        wx.config({
            appId: '<?php echo $signPackage["appId"];?>',
            timestamp:'<?php echo $signPackage["timestamp"];?>',
             nonceStr: '<?php echo $signPackage["nonceStr"];?>',
            signature: '<?php echo $signPackage["signature"];?>',
            jsApiList: ['onMenuShareTimeline', 'onMenuShareAppMessage']
        });
        wx.ready(function (){
            var word = window.location.href;
            var bbb = word.split(".htm");
            var url =  bbb[0]+"/pid/<?php echo ($WST_USER['userId']); ?>";
            var imgurl = 'http://xihuansha.greenfoodweb.com/Upload/goods/2016-04/570f7318257e3.jpg';
            wx.onMenuShareTimeline({
                title: '分享标题', // 分享标题
                desc: '分享描述', // 分享描述
                link: url, // 分享链接
                imgUrl:imgurl, // 分享图标
                success: function () {
                },
                cancel: function () {
                }
            });
           //获取“分享给朋友”按钮点击状态及自定义分享内容接口
            wx.onMenuShareAppMessage({
                title: '分享标题', // 分享标题
                desc: '分享描述', // 分享描述
                link: url, // 分享链接
                imgUrl:imgurl, // 分享图标
                type: '', // 分享类型,music、video或link，不填默认为link
                dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                success: function () {
                },
                cancel: function () {
                }
            });
        });

    </script><?php endif; ?>
</body>
</html>