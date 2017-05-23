<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title>用户中心</title>
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<link rel="stylesheet" type="text/css" href="/static/wx/css/public.css">
<link rel="stylesheet" type="text/css" href="/static/wx/css/user.css">
<script type="text/javascript" src="/static/wx/js/jquery.js"></script>
<script type="text/javascript" src="/static/wx/js/common.js"></script>

</head>
<body style="background: rgb(235, 236, 237);">
<header>
    <div class="tab_nav">
        <div class="header">
            <div class="h-left"><a class="sb-back" href="javascript:history.back(-1)" title="返回"></a></div>
            <div class="h-mid"><?php echo ($title_name); ?></div>
            <div class="h-right">
                <aside class="top_bar">
                    <div onClick="show_menu();$('#close_btn').addClass('hid');" id="show_more"><a href="javascript:;"></a> </div>
                </aside>
            </div>
        </div>
    </div>
</header>
<script src="/Public/plugins/layer/layer.min.js"></script>
<script type="text/javascript" src="/static/wx/js/mobile.js" ></script>

<div class="goods_nav hid" id="menu">
    <div class="Triangle">
        <h2></h2>
    </div>
    <ul>
        <li><a href="<?php echo U('index/index');?>"><span class="menu1"></span><i>首页</i></a></li>
        <li><a href="<?php echo U('goods/goodscategory');?>"><span class="menu2"></span><i>分类</i></a></li>
        <li><a href="<?php echo U('Cart/getCartInfo');?>"><span class="menu3"><em class="wst-nvg-cart-cnt">0</em></span><i>购物车</i></a></li>
        <li style=" border:0;"><a href="<?php echo U('users/index');?>"><span class="menu4"></span><i>我的</i></a></li>
    </ul>
</div>
<div id="wrapper">
  <div id="viewport">

      <div class="Personal">
          <div id="tbh5v0">
              <div class="innercontent1" >
                  <div class="name" style="height: auto;">
                      <label>
                          <span>二维码</span>
                          <img src="<?php echo ($imgurl); ?>" style='width:150px;height:150px;'/>
                      </label>
                  </div>
              </div>
          </div>
      </div>
   <div class="Personal">
      <div id="tbh5v0">
      <div class="innercontent1" >
          <form name="myform" method="post" id="myform" autocomplete="off">
 			  <div class="name"><span>昵称</span><input type="text"  id='userName' name='userName' value="<?php echo ($user['userName']); ?>" placeholder="昵称" class="c-f-text"></div>
		      <div class="name1"><span>性　别</span>
                  <label for="radio">   <input name="userSex" type="radio" id="radio" value="3" <?php if($user['userSex'] == 3): ?>checked<?php endif; ?>/>保密</label>
                  <label for="radio2">  <input type="radio" name="userSex" id="radio2" value="1" <?php if($user['userSex'] == 1): ?>checked<?php endif; ?> />男</label>
                  <label for="radio3"> <input type="radio" name="userSex" id="radio3" value="2" <?php if($user['userSex'] == 2): ?>checked<?php endif; ?> />女</label>
            </div>
              <div class="name">
                  <label for="userEmail">
                      <span>邮箱</span>
                      <input type="text" id='userEmail' name='userEmail' value="<?php echo ($user['userEmail']); ?>"  />
                  </label>
              </div>

              <div class="name">
                  <label for="userPhone">
                      <span>手机号码</span>
                      <input type="text" id='userPhone' name='userPhone' value="<?php echo ($user['userPhone']); ?>" maxlength="11"  />
                  </label>
              </div>
              <div class="name">
                  <label for="pname">
                      <span>推荐人</span>
                      <input type="text"  id="pname" value="<?php echo ((isset($user['partnerName']) && ($user['partnerName'] !== ""))?($user['partnerName']):'无推荐人'); ?>"  readonly="readonly"/>
                  </label>
              </div>

			<!--<div style=" padding-top:10px; margin-top:10px; border-top:1px solid #CCC">-->
            <!--<div class="field_pwd">-->
				<!--<label for="sel_ques">-->
               <!--<h4 class="title"> <span class="t-red-g">*</span>密码提示问题：</h4>-->
					<!--<select name="sel_question"  class="required" id="sel_ques">-->
						<!--<option value="0">请选择密码提示问题</option>-->
						<!--<option value="friend_birthday" <?php if($info["sel_question"] == 'friend_birthday'): ?>selected<?php endif; ?>>我最好朋友的生日？</option>-->
                        <!--<option value="old_address" <?php if($info["sel_question"] == 'old_address'): ?>selected<?php endif; ?>>我儿时居住地的地址？</option>-->
                        <!--<option value="motto" <?php if($info["sel_question"] == 'motto'): ?>selected<?php endif; ?>>我的座右铭是？</option>-->
                        <!--<option value="favorite_movie" <?php if($info["sel_question"] == 'favorite_movie'): ?>selected<?php endif; ?>>我最喜爱的电影？</option>-->
                        <!--<option value="favorite_song" <?php if($info["sel_question"] == 'favorite_song'): ?>selected<?php endif; ?>>我最喜爱的歌曲？</option>-->
                        <!--<option value="favorite_food" <?php if($info["sel_question"] == 'favorite_food'): ?>selected<?php endif; ?>>我最喜爱的食物？</option>-->
                        <!--<option value="interest" <?php if($info["sel_question"] == 'interest'): ?>selected<?php endif; ?>>我最大的爱好？</option>-->
                        <!--<option value="favorite_novel" <?php if($info["sel_question"] == 'favorite_novel'): ?>selected<?php endif; ?>>我最喜欢的小说？</option>-->
                        <!--<option value="favorite_equipe" <?php if($info["sel_question"] == 'favorite_equipe'): ?>selected<?php endif; ?>>我最喜欢的运动队？</option>-->
                    <!--</select>-->
				<!--</label>-->
                <!--</div>-->
                <!--</div>-->
                
                <!--<div class="field_pwd">-->
                    <!--<label for="pw_answer" id="passwd_quesetion">                -->
                        <!--<input type="text" name="passwd_answer" value="<?php echo ($info["passwd_answer"]); ?>" class="c_f_text" id="pw_answer"   placeholder="*密码问题答案"/>-->
                       <!-- -->
                    <!--</label>-->
                <!--</div>-->
					<div class="field submit-btn">
					   <input type="submit" value="确认修改" class="btn_big1" />
                    </div>
					<input type="hidden" name="act" value="act_edit_profile"/>
		</form>
       </div>       
         

 </div>
</div>
      <script src="/Public/plugins/formValidator/formValidator-4.1.3.js"></script>
      <script>
          $(function () {
              $.formValidator.initConfig({
                  theme:'Default',mode:'AutoTip',formID:"myform",debug:true,submitOnce:true,onSuccess:function(){
                      editUser();
                      return false;
                  },onError:function(msg){
                  }});
              $("#userName").formValidator({onShow:"",onFocus:"",onCorrect:"输入正确"}).inputValidator({min:6,max:20,onError:"用户昵称长度为6到20位"});
              $("#userPhone").inputValidator({min:0,max:25,onError:"你输入的手机号码非法,请确认"}).regexValidator({
                  regExp:"mobile",dataType:"enum",onError:"手机号码格式错误"
              }).ajaxValidator({
                  dataType : "json",
                  async : true,
                  url : '/Wx/Users/checkLoginKey',
                  success : function(data){
                      var json = {};
                      if(typeof(data )=="object"){
                          json = data;
                      }else{
                          json = eval("("+data+")");
                      }
                      if( json.status == "1" ) {
                          return true;
                      } else {
                          return false;
                      }
                      return "该手机号码已被使用";
                  },
                  buttons: $("#dosubmit"),
                  onError : "该手机号码已存在。",
                  onWait : "请稍候..."
              }).defaultPassed().unFormValidator(true);
              $("#userEmail").inputValidator({min:0,max:25,onError:"你输入的邮箱长度非法,请确认"}).regexValidator({
                  regExp:"email",dataType:"enum",onError:"邮箱格式错误"
              }).ajaxValidator({
                  dataType : "json",
                  async : true,
                  url : '/Wx/Users/checkLoginKey',
                  success : function(data){
                      var json = {};
                      if(typeof(data )=="object"){
                          json = data;
                      }else{
                          json = eval("("+data+")");
                      }
                      if( json.status == "1" ) {
                          return true;
                      } else {
                          return false;
                      }
                      return "该电子邮箱已被使用";
                  },
                  buttons: $("#dosubmit"),
                  onError : "该邮箱已存在。",
                  onWait : "请稍候..."
              }).defaultPassed().unFormValidator(true);
              $("#userPhone").blur(function(){
                  if($("#userPhone").val()==''){
                      $("#userPhone").unFormValidator(true);
                  }else{
                      $("#userPhone").unFormValidator(false);
                  }
              });
              $("#userEmail").blur(function(){
                  if($("#userEmail").val()==''){
                      $("#userEmail").unFormValidator(true);
                  }else{
                      $("#userEmail").unFormValidator(false);
                  }
              });

          });


      </script>


      <footer>
    <div class="footer" style="display: none;">
        <div class="links"  id="ECS_MEMBERZONE">
            <?php if($_SESSION['user_info']['id'] == ''): ?><a href="<?php echo U('user/login');?>"><span>登录</span></a><a href="<?php echo U('user/register');?>"><span>注册</span></a><?php else: ?>
                <a href="<?php echo U('user/index');?>">您好，<?php if($_SESSION['user_info']['username'] == ''): echo ($_SESSION['user_info']['nickname']); endif; echo ($_SESSION['user_info']['username']); ?>，欢迎您回来</a><?php endif; ?>
            <a href="javascript:window.scrollTo(0,0);"><span>回顶部</span></a>
        </div>

        <p class="mf_o4">&copy; 2005-2016 爱乐享 版权所有，并保留所有权利。</p>
    </div>

    <div style="height:50px; line-height:50px; clear:both;"></div>


    <div class="v_nav">
        <div class="vf_nav">
            <ul>
                <li> <a href="<?php echo U('index/index');?>">
                    <i class="vf_1"></i>
                    <span>买啥</span></a></li>
                <li><a href="<?php echo U('activity/index');?>">
                    <i class="vf_3"></i>
                    <span>玩啥</span></a></li>
                <li><a href="<?php echo U('users/index');?>">
                    <i class="vf_5"></i>
                    <span>我的</span></a></li>
                <li><a href="<?php echo U('cart/getcartinfo');?>">
                    <i class="vf_4 wst-nvg-cart-cnt" style="line-height: 14px;text-align: right;color: #ffffff;" >0</i>
                    <span>购物车</span></a></li>
            </ul>
        </div>
    </div>
</footer>
<script src="/Public/plugins/layer/layer.min.js"></script>

  </div>
</div>
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