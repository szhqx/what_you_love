<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html >
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title>爱乐享活动详细页</title>
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <meta name="format-detection" content="telephone=no">
<link rel="stylesheet" type="text/css" href="/static/wx/css/public.css"/>
<link rel="stylesheet" type="text/css" href="/static/wx/css/activity.css"/>    
<script type="text/javascript" src="/static/wx/js/jquery.js"></script>
<script type="text/javascript" src="/static/wx/js/common.js"></script>
    <style>
        /*消息列表*/
        .msglist{padding-top: 10px;}
        .msglist .msgitem{background: #fff; border-bottom: 1px solid #ebebeb; border-top: 1px solid #ebebeb; padding: 0px 10px; margin-bottom: 5px; position: relative;}
        .msglist .mtit{ margin-bottom: 2px;font-size: 14px }
        .msglist .mtit span{color: #ef2b2d;}
        .msglist .mtime{font-size: 12px;text-align: right;padding-right: 2px; color: #666;}
        .h_right>ul>li{
            white-space:normal;
        }
    </style>

</head>
<body style="background:#f4f2f3">

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

<div style=" width:100%; height:30px;"></div>

  <div class="huodong">
 <div class="huodong_mid">

  <div class="h_right">
 
   <div class="img"><img src="/<?php echo (get_thumb_img($info["picurl"],'')); ?>">
   <span><?php echo ($info["start_time"]); ?>~<?php echo ($info["end_time"]); ?></span>
   </div>
   
     <ul>
       <li><strong>活动主题：</strong><?php echo ($info["activityTitle"]); ?></li>
       <li><strong>活动地点：</strong><?php echo ($info["address"]); ?></li>
       <li><strong>活动预算：</strong><?php echo ($info["expenditure"]); ?></li>
       <li><strong>活动每人预付金额：</strong><?php echo ($info["prepay"]); ?>（多还少补）</li>
       <li><strong>活动预报名人数：</strong><?php echo ($info["user_num"]); ?></li>
       <li><strong>活动已报人数：</strong><?php echo ((isset($info["success_num"]) && ($info["success_num"] !== ""))?($info["success_num"]):'0'); ?></li>
       <li><strong>活动时间：</strong><?php echo ($info["start_time"]); ?>~<?php echo ($info["end_time"]); ?></li>
       <li><strong>报名结束时间：</strong><?php echo ($info["end_apply"]); ?></li>
     </ul>
     <dl class="fanwei">
         <dt>活动内容：</dt>
         <dd>
           <?php echo (htmlspecialchars_decode($info["flow"])); ?>
         </dd>
     </dl>
      <?php if(is_array($info[activityPhoto])): $i = 0; $__LIST__ = $info[activityPhoto];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="imgs">
          <img src="/<?php echo ($vo); ?>">
      </div><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
     <div style=" width:100%; height:30px;"><p><a style="display: block;
    margin: auto;
    width: 120px;
    height: 30px;
    margin-top: 2px;
    margin-buttom: 8px;
    font-size: 14px;
    line-height: 30px;
    color: #fff;
    text-align: center;
    border-radius: 20px;
    <?php if($apply == '2'): ?>background: #666;"<?php else: ?> background: #F30;"<?php endif; ?>
         <?php if($apply == '1'): ?>href="/wx/activity/gojoin/actid/<?php echo ($info["activityId"]); ?>">我要报名<?php endif; ?>
         <?php if($apply == '2'): ?>>活动结束<?php endif; ?>
         <?php if($apply == '3'): ?>>我已报名<?php endif; ?>
         </a></p>
     </div>
     <div style=" width:100%; height:30px;"><p><a style="display: block;
                                    margin: auto;
                                    width: 120px;
                                    height: 30px;
                                    margin-top: 2px;
                                    margin-buttom: 8px;
                                    font-size: 14px;
                                    line-height: 30px;
                                    color: #fff;
                                    text-align: center;
                                    border-radius: 20px;
                                    background: #F30;" href="/wx/activity/lookstatement/actid/<?php echo ($info["activityId"]); ?>">查看财务报表</a>

     </p>
         </div>
    <?php if($isUp != '1' and $joinuser == '1'): ?><div style=" width:100%; height:30px;">
         <p><a style="display: block;
                                    margin: auto;
                                    width: 120px;
                                    height: 30px;
                                    margin-top: 2px;
                                    margin-buttom: 8px;
                                    font-size: 14px;
                                    line-height: 30px;
                                    color: #fff;
                                    text-align: center;
                                    border-radius: 20px;
                                    background: #F30;" href="/wx/activity/upstatement/actid/<?php echo ($info["activityId"]); ?>">上传财务数据</a></p>
     </div><?php endif; ?>
     <div class="msglist">
         <?php if(is_array($joindata)): $i = 0; $__LIST__ = $joindata;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="msgitem">
             <div class="mtit"><?php echo ($vo["username"]); ?><span><?php if($joinuser == '1'): ?>Tel:<?php echo ($vo["mobile"]); endif; ?></span> <var style="float: right;padding-right: 5px;"><?php echo ($vo["createTime"]); ?></var> </div>
             <div class="mtime" hidden></div>
         </div><?php endforeach; endif; else: echo "" ;endif; ?>
     </div>
  </div>
  </div>
   <div class="clear"></div>



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
                if("<?php echo (get_thumb_img($info["picurl"],'')); ?>" ==''){  //<?php echo (get_thumb_img($info["picurl"],'')); ?>
                    var imgurl = 'http://xihuansha.greenfoodweb.com/Upload/goods/2016-04/570f7318257e3.jpg';
                }else{
                    var imgurl = 'http://xihuansha.greenfoodweb.com//<?php echo (get_thumb_img($info["picurl"],'')); ?>';
                }
                if("<?php echo ($info["activityTitle"]); ?>" ==''){
                    var title = '嘻欢啥分享标题';
                }else{
                    var title = '<?php echo ($info["activityTitle"]); ?>';
                }

                wx.onMenuShareTimeline({
                    title: title, // 分享标题
                    desc: title, // 分享描述
                    link: url, // 分享链接
                    imgUrl:imgurl, // 分享图标
                    success: function () {
                    },
                    cancel: function () {
                    }
                });
                //获取“分享给朋友”按钮点击状态及自定义分享内容接口
                wx.onMenuShareAppMessage({
                    title: title, // 分享标题
                    desc: title, // 分享描述
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