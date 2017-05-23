<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
	<head>
  		<meta charset="utf-8">
      	<meta http-equiv="X-UA-Compatible" content="IE=edge">
      	<link rel="shortcut icon" href="favicon.ico"/>
      	<meta name="viewport" content="width=device-width, initial-scale=1">
      	<title>忘记密码 - <?php echo ($CONF['mallTitle']); ?></title>
      	<meta name="keywords" content="<?php echo ($CONF['mallKeywords']); ?>" />
      	<meta name="description" content="<?php echo ($CONF['mallDesc']); ?>,忘记密码" />
      	<link rel="stylesheet" href="/Apps/Home/View/default/css/common.css">
     	<link rel="stylesheet" href="/Apps/Home/View/default/css/footer.css">

   	</head>
   	<body>
	<div id="shortcut-2013">
		<script src="/Public/js/jquery.min.js"></script>
<script src="/Public/plugins/lazyload/jquery.lazyload.min.js?v=1.9.1"></script>
<script type="text/javascript">
var WST = ThinkPHP = window.Think = {
        "ROOT"   : "",
        "APP"    : "",
        "PUBLIC" : "/Public",
        "DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>",
        "MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
        "VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"],
        "DOMAIN" : "<?php echo WSTDomain();?>",
        "CITY_ID" : "<?php echo ($currArea['areaId']); ?>",
        "CITY_NAME" : "<?php echo ($currArea['areaName']); ?>",
        "DEFAULT_IMG": "<?php echo WSTDomain();?>/<?php echo ($CONF['goodsImg']); ?>",
        "MALL_NAME" : "<?php echo ($CONF['mallName']); ?>",
        "SMS_VERFY"  : "<?php echo ($CONF['smsVerfy']); ?>",
        "PHONE_VERFY"  : "<?php echo ($CONF['phoneVerfy']); ?>",
        "IS_LOGIN" :"<?php echo ($WST_IS_LOGIN); ?>"
}
    $(function() {
    	$('.lazyImg').lazyload({ effect: "fadeIn",failurelimit : 10,threshold: 200,placeholder:WST.DEFAULT_IMG});
    });
</script>
<script src="/Public/js/think.js"></script>
<div id="wst-shortcut">
	<div class="w">
		<ul class="fl lh" hidden>
			<li class="fore1 ld"><b></b><a href="javascript:addToFavorite()"
				rel="nofollow">收藏<?php echo ($CONF['mallName']); ?></a></li><s></s>
			<li class="fore3 ld menu" id="app-jd" data-widget="dropdown">
				<span class="outline"></span> <span class="blank"></span> 
				<a href="#" target="_blank"><img src="/Apps/Home/View/default/images/icon_top_02.png"/>&nbsp;<?php echo ($CONF['mallName']); ?> 手机版</a>
			</li>
			<li class="fore4" id="biz-service" data-widget="dropdown" style='padding:0;'>&nbsp;<s></s>&nbsp;&nbsp;&nbsp;
				所在城市
				【<span class='wst-city'>&nbsp;<?php echo ($currArea["areaName"]); ?>&nbsp;</span>】
				<img src="/Apps/Home/View/default/images/icon_top_03.png"/>	
				&nbsp;&nbsp;<a href="javascript:;" onclick="toChangeCity();">切换城市</a><i class="triangle"></i>
			</li>
		</ul>
	
		<ul class="fr lh" style='float:right;'>
			<li class="fore1" id="loginbar"><a href="<?php echo U('Home/Orders/queryByPage');?>"><span style='color:blue'><?php echo ($WST_USER['loginName']); ?></span></a> 欢迎您来到 <a href='<?php echo WSTDomain();?>'><?php echo ($CONF['mallName']); ?></a>！<s></s>&nbsp;
			<span  >
				<?php if(!$WST_USER['userId']): ?><a hidden href="<?php echo U('Home/Users/login');?>">[登录]</a>
				<a hidden href="<?php echo U('Home/Users/regist');?>"	class="link-regist">[免费注册]</a><?php endif; ?>
				<?php if($WST_USER['userId'] > 0): ?><a href="javascript:logout();">[退出]</a><?php endif; ?>
			</span>
			</li>
			<li class="fore2 ld"><s></s>
			<?php if(session('WST_USER.userId')>0){ ?>
				<?php if(session('WST_USER.userType')==0){ ?>
				    <a href="<?php echo U('Home/Shops/toOpenShopByUser');?>" rel="nofollow">我要开店</a>
				<?php }else{ ?>
				    <?php if(session('WST_USER.loginTarget')==0){ ?>
				        <a href="<?php echo U('Home/Shops/index');?>" rel="nofollow">卖家中心</a>
				    <?php }else{ ?>
				        <a href="<?php echo U('Home/Users/index');?>" rel="nofollow">卖家中心</a>
				    <?php } ?>
				<?php } ?>
			<?php }else{ ?>
			    <a href="<?php echo U('Home/Shops/toOpenShop');?>" rel="nofollow">我要开店</a>
			<?php } ?>
			</li>
		</ul>
		<span class="clr"></span>
	</div>
</div>

	</div>
	<div class="main">
	    <div class="main-top">
	        <div class="forget-pwd">
	            <h5>找回密码</h5>
	            <div id="stepflex" class="stepflex">
	                <dl class="first done">
	                    <dt class="s-num">1</dt>
	                    <dd class="s-text">填写账户名<s></s><b></b></dd>
	                    <dd></dd>
	                </dl>
	                <dl class="normal doing">
	                    <dt class="s-num">2</dt>
	                    <dd class="s-text">验证身份<s></s><b></b></dd>
	                </dl>
	                <dl class="normal">
	                    <dt class="s-num">3</dt>
	                    <dd class="s-text">设置新密码<s></s><b></b></dd>
	                </dl>
	                <dl class="last">
	                    <dt class="s-num">&nbsp;</dt>
	                    <dd class="s-text">完成<s></s><b></b></dd>
	                </dl>
	            </div>
	            <form method="post" id="loginForm" action="<?php echo U('Users/findPass'); ?>" autocomplete="off">
	            <input type="hidden" name="step" value="2">
	            <input type="hidden" name="userPhone" id="userPhone" value="<?php echo $forgetInfo['userPhone']; ?>">
	            <input type="hidden" name="loginName" id="loginName" value="<?php echo $forgetInfo['loginName']; ?>">
	            <table style="margin:0 auto;width:570px" class='forgettbl2'>
	                    <tbody>
	                        <tr>
	                            <th width='180px' nowrap>请选择验证身份方式：</th>
	                            <td><select name="type" id="type">
	                                <option value="phone">手机</option>
	                                <option value="email">邮箱</option>
	                            </select></td>
	                            <td><div id="typeTip" style="width:280px;text-align:left;"></div></td>
	                        </tr>
	                        <tr>
	                            <th>用户名：</th>
	                            <td colspan='2'><?php echo session('findPass.loginName'); ?></td>
	                        </tr>
	                        <tr class="phone-verify">
	                            <th>手机：</th>
	                            <td colspan='2'><?php echo $forgetInfo['userPhone'] == '' ? "没有预留手机号码，请尝试用邮箱找回！" : $forgetInfo['userPhone'] ; ?></td>
	                        </tr>
	                        <?php if($forgetInfo['userPhone'] != ''){ ?>
	                        <tr class="phone-verify">
	                            <th>请填写手机校验码：</th>
	                            <td>
	                                <input type="text" class='text' style='width:130px;' name="phoneVerify" id="phoneVerify">
	                            </td>
	                            <td><input class='btn-red' type="button" value="点击获取" id="getPhoneVerify"></td>
	                        </tr>
	                        <tr class="phone-verify">
	                            <td></td>
	                            <td colspan='2'><span id="phoneVerifyTip" style="width:280px;text-align:left;"></span></td>
	                        </tr>
	                        <tr class="phone-verify">
	                            <td colspan='3' style='padding-left:150px;'>
	                                <input class='btn-red' type="submit" id="goform" value="下一步">
	                            </td>
	                        </tr>
	                        <?php } ?>
	                        <tr class="email-verify">
	                            <th>邮箱地址：</th>
	                            <td colspan='2'><?php echo $forgetInfo['userEmail'] == '' ? "没有预留邮箱，请尝试用手机号码找回！" : $forgetInfo['userEmail'] ; ?></td>
	                        </tr>
	                        <?php if ($forgetInfo['userEmail'] != ''){ ?>
	                        <tr class="email-verify">
	                            <td colspan='3' style='padding-left:150px;'>
	                                <input class='btn-red' type="button" id="sendEmail" value="发送验证邮件">
	                            </td>
	                        </tr>
                            <?php } ?>
	                    </tbody></table>
	
	                </form>
	            </div>
	            <div class="clearfix"></div>
	        </div>
	    </div>
	</div>
	<!--footer start--> 
	<div >
<div class="wst-footer-fl-box">
	<div class="wst-footer" >
		<div class="wst-footer-cld-box">
			<div class="wst-footer-fl">友情链接：</div>
			<div style="padding-left:30px;">
				<?php if(is_array($friendLikds)): $k = 0; $__LIST__ = $friendLikds;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><div style="float:left;"><a href="<?php echo ($vo["friendlinkUrl"]); ?>" target="_blank"><?php echo ($vo["friendlinkName"]); ?></a>&nbsp;&nbsp;</div><?php endforeach; endif; else: echo "" ;endif; ?>
				<div class="wst-clear"></div>
			</div>
		</div>
	</div>
</div>

<div class="wst-footer-hp-box">
	<div class="wst-footer">
		<div class="wst-footer-hp-ck1">
			<?php if(is_array($helps)): $k1 = 0; $__LIST__ = $helps;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($k1 % 2 );++$k1;?><div class="wst-footer-wz-ca">
				<div class="wst-footer-wz-pt">
				    <img src="/Apps/Home/View/default/images/a<?php echo ($k1); ?>.jpg" height="18" width="18"/>
					<span class="wst-footer-wz-pn"><?php echo ($vo1["catName"]); ?></span>
					<div style='margin-left:30px;'>
						<?php if(is_array($vo1['articlecats'])): $k2 = 0; $__LIST__ = $vo1['articlecats'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($k2 % 2 );++$k2;?><a href="<?php echo U('Home/Articles/index/',array('articleId'=>$vo2['articleId']));?>"><?php echo ($vo2['articleTitle']); ?></a><br/><?php endforeach; endif; else: echo "" ;endif; ?>
					</div>
				</div>
			</div><?php endforeach; endif; else: echo "" ;endif; ?>
			
			<div class="wst-footer-wz-clt">
				<div style="padding-top:5px;line-height:25px;">
				    <img src="/Apps/Home/View/default/images/a6.jpg" height="18" width="18"/>
					<span class="wst-footer-wz-kf">联系客服</span>
					<div style='margin-left:30px;'>
						<a href="#">联系电话</a><br/>
						<?php if($CONF['phoneNo'] != ''): ?><span class="wst-footer-pno"><?php echo ($CONF['phoneNo']); ?></span><br/><?php endif; ?>
						<?php if($CONF['qqNo'] != ''): ?><a href="tencent://message/?uin=<?php echo ($CONF['qqNo']); ?>&Site=QQ交谈&Menu=yes">
						<img border="0" src="http://wpa.qq.com/pa?p=1:<?php echo ($CONF['qqNo']); ?>:7" alt="QQ交谈" width="71" height="24" />
						</a><br/><?php endif; ?>
						
					</div>
				</div>
			</div>
			<div class="wst-clear"></div>
		</div>
	    
		<div class="wst-footer-hp-ck2">
			<img src="/Apps/Home/View/default/images/alipay.jpg" height="40" width="120"/>支付宝签约商家&nbsp;|&nbsp;
			<span class="wst-footer-frd">正品保障</span><span >100%原产地</span>&nbsp;|&nbsp;
			<span class="wst-footer-frd">7天退货保障</span>购物无忧&nbsp;|&nbsp;
			<span class="wst-footer-frd">免费配送</span>满98包邮&nbsp;|&nbsp;
			<span class="wst-footer-frd">货到付款</span>400城市送货上门
		</div>
	    <div class="wst-footer-hp-ck3">
	        <div class="links"> 
	            <?php $_result=WSTNavigation(1);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a rel="nofollow" <?php if($vo['isOpen'] == 1): ?>target="_blank"<?php endif; ?> href="<?php echo ($vo['navUrl']); ?>"><?php echo ($vo['navTitle']); ?></a>&nbsp;<?php if($vo['end'] == 0): ?>|&nbsp;<?php endif; endforeach; endif; else: echo "" ;endif; ?>
	        </div>

	        <div class="copyright">

	         <?php if($CONF['mallFooter']!=''){ echo htmlspecialchars_decode($CONF['mallFooter']); } ?>
	      	<?php if($CONF['visitStatistics']!=''){ echo htmlspecialchars_decode($CONF['visitStatistics'])."<br/>"; } ?>
	        <?php if($CONF['mallLicense'] ==''): ?><div>
				Copyright©2015 Powered By <a target="_blank" href="http://www.qianpok.com">QianPokMall</a>
			</div>
			<?php else: ?>
				<div id="wst-mallLicense" data='1' style="display:none;">Copyright©2015 Powered By <a target="_blank" href="http://www.qianpok.com">QianPokMall</a></div><?php endif; ?>
	        </div>

	    </div>
	</div>
</div>
</div>
	<!--footer end-->
	</body>
	<script src="/Public/plugins/formValidator/formValidator-4.1.3.js"></script>
	<script src="/Public/plugins/layer/layer.min.js"></script>
    <script src="/Public/js/common.js"></script>
    <script src="/Apps/Home/View/default/js/common.js"></script>
    <script src="/Apps/Home/View/default/js/findpass.js"></script>
	<script type="text/javascript">
	var resetPassUrl = '';
	var findPassTime = 0;
	$(document).ready(function(){
	    $('#type').change(function(){
	        if ($('#type').val() == 'phone') {
	            $('.phone-verify').show();
	            $('.email-verify').hide();
	        }else{
	            $('.phone-verify').hide();
	            $('.email-verify').show();
	        }
	    })
	    $.formValidator.initConfig({formID:"loginForm",theme:"Default",debug:true,submitOnce:true,onSuccess:function(){
			   location.href=resetPassUrl;
		       return false;
		    },
	        onError:function(msg,obj,errorlist){
	            console.log(msg);
	        },
	        ajaxPrompt : '有数据正在异步验证，请稍等...'
	    });
	   $("#phoneVerify").formValidator({onShowText:"请输入手机验证码",onShow:"",onFocus:"",onCorrect:"手机验证码正确"}).inputValidator({min:6,max:6,onError:"手机验证码错误"})
	        .ajaxValidator({
	        dataType : "json",
	        async : true,
	        url : "<?php echo U('Home/Users/checkPhoneVerify'); ?>",
	        success : function(data){
	        	var json = WST.toJson(data);
	            if( json.status == "1" ) {
	            	resetPassUrl = json.url;
	                return true;
				} else {
					return "手机验证码错误,请检查！";
				}
	            return "手机验证码错误,请检查！";
	        },
	        buttons: $("#goform"),
	        error: function(jqXHR, textStatus, errorThrown){alert("服务器没有返回数据，可能服务器忙，请重试"+errorThrown);},
	        onError : "手机验证码错误！",
	        onWait : "正在对手机验证码进行合法性校验，请稍候..."
	    });
	});
	</script>
	<style>
   	.layui-layer-btn a{background:#e23c3d;}
   	</style>
</html>