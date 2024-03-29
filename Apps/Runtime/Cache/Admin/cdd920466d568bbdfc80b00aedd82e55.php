<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <link rel="shortcut icon" href="favicon.ico"/>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title><?php echo ($CONF['mallTitle']); ?>后台管理中心登录</title>
      <link href="/Public/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="/Apps/Admin/View/css/login.css">
      <!--[if lt IE 9]>
      <script src="/Public/js/html5shiv.min.js"></script>
      <script src="/Public/js/respond.min.js"></script>
      <![endif]-->
      <script src="/Public/js/jquery.min.js"></script>
      <script src="/Public/plugins/bootstrap/js/bootstrap.min.js"></script>
      <script src="/Public/js/common.js"></script>
      <script src="/Public/plugins/plugins/plugins.js"></script>
      <script>
      var ThinkPHP = window.Think = {
	        "ROOT"   : "",
	        "APP"    : "",
	        "PUBLIC" : "/Public",
	        "DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>",
	        "MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
	        "VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
	  }
      </script>
      <script src="/Public/js/think.js"></script>
   </head>
   <script>
   $(function(){
	   getVerify();
	   $('.form-actions').click(function(){login()});
	   $(document).keypress(function(e) { 
		   if(e.which == 13) {  
			   login();  
		   } 
	   }); 
   })
   function login(){
	   var params = {};
	   params.loginName = $.trim($('#loginName').val());
	   params.loginPwd = $.trim($('#loginPwd').val());
	   params.verify = $.trim($('#verfyCode').val());
	   params.id = $('#id').val();
	   if(params.loginName==''){
		   Plugins.Tips({title:'信息提示',icon:'error',content:'请输入账号!',timeout:1000});
		   $('#loginName').focus();
		   return;
	   }
	   if(params.loginPwd==''){
		   Plugins.Tips({title:'信息提示',icon:'error',content:'请输入密码!',timeout:1000});
		   $('#loginPwd').focus();
		   return;
	   }
	   if(params.verify==''){
		   Plugins.Tips({title:'信息提示',icon:'error',content:'请输入验证码!',timeout:1000});
		   $('#verfyCode').focus();
		   return;
	   }
	   Plugins.waitTips({title:'信息提示',content:'正在登录，请稍后...'});
		$.post(Think.U("Admin/index/login"),params,function(data,textStatus){
			var json = WST.toJson(data);
			if(json.status=='1'){
				Plugins.setWaitTipsMsg({ content:'登录成功',timeout:1000,callback:function(){
					location.href=Think.U("Admin/Index/index");
				}});
			}else if(json.status=='-2'){
				Plugins.closeWindow();
				Plugins.Tips({title:'信息提示',icon:'error',content:'验证码错误!',timeout:1000});
				getVerify();
			}else{
				Plugins.closeWindow();
				Plugins.Tips({title:'信息提示',icon:'error',content:'账号或密码错误!',timeout:1000});
				getVerify();
			}
		});
   }
   function getVerify() {
	   $('.verifyImg').attr('src',Think.U('Admin/Index/getVerify','rnd='+Math.random()));
   }
   </script>
   <body>
        <div id="loginbox"> 
            <div class='logo'></div>            
            <form id="loginform" class="form-vertical" />
                <div class="control-group">
                    <div class="controls"> 
                        <div class="input-prepend">
                            <span class="add-on">账号：</span><input type="text" name='loginName' id='loginName' placeholder="用户名" />
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on">密码：</span><input type="password" name='loginPwd' id='loginPwd' placeholder="密码" />
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on">验证码：</span><input type="text" style='width:115px;' name='verfyCode' id='verfyCode' placeholder="验证码" />
                            <label class="img">
			                	<img style='vertical-align:middle;cursor:pointer;height:25px;' class='verifyImg' src='/Apps/Home/View/default/images/clickForVerify.png' title='刷新验证码' onclick='javascript:getVerify()'/> 
							</label>
                        </div>
                    </div>
                </div>
                <div class="form-actions"></div>
            </form>
        </div> 
    </body>
</html>