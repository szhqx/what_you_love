<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,maximum-scale=1.0,initial-scale=1.0,user-scalable=0">
<meta name="format-detection" content="telephone=no">
<title>会员充值</title>
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
<style>
    textarea{
    width: 94%;
    height: 80px;
    line-height: 36px;
    border: 0;
    background: none;
    padding: 0 3%;
    color: #666;
    font-size: 14px;
    vertical-align: middle;
    margin-top: -3px;
    }
</style>
<!--主页start-->
<div class="pager">
    <div class="bxcont">
        <!--钱包start-->
        <div class="purse clearfix" style="height: auto;">
            <div class="purse_tit"><span>¥</span><b><?php echo ($userBalance); ?></b>可提现金额</div>
            <div class="purse_form">
                <div class="tit">提现信息</div>
                <div class="txt">

                    <form action="/wx/users/gowithdraw" method="post" id="rechargeFrom">
                        <input type="text" name="withdrawNo" style="display: none;"  value="<?php echo ($withdrawNo); ?>">
                        <div class="txtinput">
                            <input type="number" name="money" id="money"  placeholder="提现金额">
                        </div>
                        <div class="txtinput" style="height: auto;">
                            <textarea name="remark" id="remark" placeholder="提现备注"></textarea>
                        </div>
                    </form>
                </div>
            </div>
            <div class="blank"></div>
            <div class="bx_btn" id="czbtn">
                <a href="javascript:void(0);">提现申请</a>
            </div>
        </div>
        <div style="padding-top: 50px;">
        <?php if(!empty($withdrawList)): ?><div class="msglist">
                <?php if(is_array($withdrawList)): $i = 0; $__LIST__ = $withdrawList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="msgitem">
                        <div class="mtit"><?php echo ($vo["createTime"]); ?>提现申请金额-<span>[￥<?php echo ($vo["amount"]); ?>]</span></div>
                        <!--<span hidden>【未读】</span>-->
                        <div class="mtime"><?php if($vo["isFlag"] == '1'): ?>已完成<?php elseif($vo["isFlag"] == '-1'): ?>提交审核不通过<?php else: ?>未审核<?php endif; ?></div>
                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
            <?php else: ?>
            <div style="display:block; width:100%; text-align: center;"><img style="margin-left: -50px;" src="/static/wx/bx/images/cartoon.png"/><br/>暂无提现明细</div><?php endif; ?>
        <!--消息记录为空时显示-->
        <!--钱包end-->
        </div>
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
        //充值start
        $("#czbtn").click(function(){
            <?php if($inweixin == 0): ?>bx_alert("请在微信中打开！");
            return false;
            <?php else: ?>
            var money = $("#money").val();
            if (money == "" || isNaN(money)){
                bx_alert("提现金额错误!请重试");
                return false;
            }
            money = parseFloat(money);
            if (money <= 0){
                bx_alert("提现金额不能小于0!");
                return false;
            }
            if((money)<=0){
                bx_alert("提现金额必须大于0!");
                return false;
            }
            $("#rechargeFrom").submit();<?php endif; ?>
        });
        //关闭loading层
        $("#loading").hide();

    });
</script>
</body>
</html>