<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,maximum-scale=1.0,initial-scale=1.0,user-scalable=0">
<meta name="format-detection" content="telephone=no">
<title>我的嘻币</title>
    <link rel="stylesheet" type="text/css" href="/static/wx/css/public.css"/>
    <link rel="stylesheet" type="text/css" href="/static/wx/css/user.css"/>
    <link rel="stylesheet" href="/static/wx/iconfont/iconfont.css">
<link type="text/css" href="/static/wx/bx/css/common.css" rel="stylesheet">
<link type="text/css" href="/static/wx/bx/css/user.css" rel="stylesheet">
<link type="text/css" href="/static/wx/bx/lib/animate-css/animate.min.css" rel="stylesheet">
<link type="text/css" href="/static/wx/bx/lib/font-awesome/font-awesome.min.css" rel="stylesheet">
</head>
<body>
<!--loading start-->
<div class="cover" id="loading">
    <div class="loading">
        <div class="dot white"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div>
    </div>
</div>
<!--loading end-->
<!--主页start-->
<div class="pager">
    <div class="bxcont">
        <div class="purse">
        <div class="purse_tit"><span>嘻币</span><b><?php echo ((isset($userScore) && ($userScore !== ""))?($userScore):'0'); ?></b></div>
            </div>
        <?php if(!empty($scoreList)): ?><div class="msglist">
                    <?php if(is_array($scoreList["root"])): $i = 0; $__LIST__ = $scoreList["root"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="msgitem">
                            <div class="mtit">您通过订单<span>[<?php echo ($vo["orderNo"]); ?>]</span>分成获得<?php echo ($vo["score"]); ?>嘻币</div>
                            <!--<span hidden>【未读】</span>-->
                            <div class="mtime"><?php echo ($vo["createTime"]); ?></div>
                        </div><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
         <?php else: ?>
                 <div class="pempty" style="display:block;"><img src="/static/wx/bx/images/cartoon.png"/><br/>暂无嘻币明细</div><?php endif; ?>
        <!--消息记录为空时显示-->

    </div>
</div>
<!--主页end-->
<script src="/static/wx/bx/lib/jquery/jquery.min.js"></script>
<!--底部导航start-->
<div id="wrapper">
    <div id="viewport">
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
<!--底部导航end-->

<script src="/static/wx/bx/js/msgalert.js"></script>
<script>
    $(function(){
        //关闭loading层
        $("#loading").hide();
    });
</script>
</body>
</html>