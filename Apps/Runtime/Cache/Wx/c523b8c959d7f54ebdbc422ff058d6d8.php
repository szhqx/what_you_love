<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html >
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title>用户中心  </title>
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<script src="/static/wx/js/modernizr.js"></script>
<link rel="stylesheet" type="text/css" href="/static/wx/css/public.css"/>
<link rel="stylesheet" type="text/css" href="/static/wx/css/user.css"/>
    <link rel="stylesheet" href="/static/wx/iconfont/iconfont.css">
    <script type="text/javascript" src="/static/wx/js/jquery.js"></script>
<script type="text/javascript" src="/static/wx/js/jquery.json.js"></script><script type="text/javascript" src="/static/wx/js/transport.js"></script><script type="text/javascript" src="/static/wx/js/common.js"></script><script type="text/javascript" src="/static/wx/js/utils.js"></script></head>
<body style="background: rgb(235, 236, 237);">
      
<div class="user_com">

<div class="com_top" style="z-index: 1; position: relative; height: 100px;">
<h2 ><a href="javascript:void(0);">&nbsp;成长指数：&nbsp;<?php echo ($rankName); ?>&nbsp;</a></h2>
<dl >
<dt>
    <a href="<?php echo U('Wx/Users/toEdit/');?>">
    <?php
 if($WST_USER['userPhoto']==""){ echo '<img src="/Apps/Home/View/default/images/logo.png" >'; }elseif(strpos($WST_USER['userPhoto'],'http')===false){ echo '<img src="/'.$WST_USER['userPhoto'].'">'; }else{ echo '<img src="'.$WST_USER['userPhoto'].'" >'; } ?>
        </a>
    <span>
        <?php
 if(!empty($WST_USER['nickName'])){ echo $WST_USER['nickName']; }else{ if(empty($WST_USER['userName'])){ echo $WST_USER['loginName']; }else{ echo $WST_USER['userName']; } } ?>
    </span>
    <dd style="float: left; font-weight: bold;" hidden>等级：&nbsp;<?php echo ($rankName); ?>&nbsp;</dd>
    </dt>

</dl>
</div>
<!--<div class="uer_topnav" >-->
    <style>
        .Wallet1 ul li {
            position:relative;
        }
        /*.test{display: none;}*/
        .iconfont20 em{
            position: absolute;
            background: #ef2b2d;
            color: #fff;
            top: 0;
            height: 20px;
            line-height: 20px;
            min-width: 20px;
            font-size: 12px;
            text-align: center;
            border-radius: 100%;}
    </style>
<!--</div>-->
    <div class="Wallet1" style="z-index: 99900000;">
        <div class="W4div"><a href="goods_collection.html"><span class=" iconfont20 icon-icon47" style="position:relative"><?php if($countGood > '0' ): ?><em><?php echo ($countGood); ?></em><?php endif; ?></span>商品收藏</a></div>
        <div class="W4div"><a href="shop_collection.html"> <span class=" iconfont20 icon-shoucang" style="position:relative"><?php if($countShop > '0' ): ?><em><?php echo ($countShop); ?></em><?php endif; ?></span>店铺收藏</a></div>

        <!--<div class="W4div"><span class=" iconfont20 icon-withdraw"></span>提现</span></div>-->
        <div class="W4div"><a href="myfootprint.html"> <span class=" iconfont20 icon-zuji-copy" style="position:relative"><?php if($countPrint > '0' ): ?><em ><?php echo ($countPrint); ?></em><?php endif; ?></span>我的足迹</a></div>
        <!--<div class="W4div"><a href="/wx/cart/getcartinfo"><span class=" iconfont20 icon-withdraw"></span>购物车</span></a></div>-->
    </div>

    <div class="Wallet1">
        <dl><a href="<?php echo U('orders/queryByPage');?>">
            <!--<em class="Icon Icon2"></em>-->
            <dt>订单管理</dt><dd style="color:#aaaaaa;">查看全部</dd></a></dl>
        <ul>
            <li><a href="<?php echo U('Orders/queryPayByPage');?>"><span  class=" iconfont20 icon-daifukuan" style="position:relative"><?php if($statusList['-2'] > '0' ): ?><em class="test" ><?php echo ($statusList['-2']); ?></em><?php endif; ?></span>待付款</a> </li>
            <li><a href="<?php echo U('Orders/queryDeliveryByPage');?>"><span  class=" iconfont20 icon-clock" style="position:relative"><?php if($statusList['2'] > '0' ): ?><em class="test" ><?php echo ($statusList['2']); ?></em><?php endif; ?></span>待发货</a></li>
            <li><a href="<?php echo U('Orders/queryReceiveByPage');?>"><span  class=" iconfont20 icon-daishouhuo" style="position:relative"><?php if($statusList['3'] > '0' ): ?><em class="test" ><?php echo ($statusList['3']); ?></em><?php endif; ?></span>待收货</a></li>
            <li><a href="<?php echo U('Orders/queryAppraiseByPage');?>"><span  class=" iconfont20 icon-daipingjia" style="position:relative"><?php if($statusList['4'] > '0' ): ?><em class="test" ><?php echo ($statusList['4']); ?></em><?php endif; ?></span>待评价</a></li>
            <!--<li><span  class=" iconfont20 icon-tuikuan"></span>退款/售后</li>-->
        </ul>
    </div>
    <div class="Wallet1">
            <dl><a href="#">
                <!--<em class="Icon Icon6"></em>-->
                <dt>我的资产</dt><dd style="color:#aaaaaa;">查看全部</dd></a></dl>
            <ul>
                <li><a href="purselist.html"> <span  class=" iconfont20 icon-yue"></span>余额</a></li>
                <li><a href="income.html"><span  class=" iconfont20 icon-2"></span>收益</a></li>
                <li><a href="myheecoin.html"> <span class=" iconfont20 icon-jinbi"></span>嘻币</a></li>

                <li><a href="mysorce.html"> <span  class=" iconfont20 icon-jifen"></span>积分</a></li>
            </ul>
            <ul>
                <li><a href="purse.html"> <span class=" iconfont20 icon-chongzhi"></span>充值</a></li>
                <li><a href="withdraw.html"> <span class=" iconfont20 icon-yue"></span>提现</a></li>
                <li><span  class=" iconfont20 icon-youhuiquan"></span>优惠券</li>
            </ul>
    </div>
<div class="Wallet1">
    <!--<?php echo U('Wx/users/myReferrer');?>-->
    <dl><a href="direct_member.html">
        <!--<em class="Icon Icon1"></em>-->
        <dt>会员管理</dt><dd style="color:#aaaaaa;">查看我推荐的人</dd></a></dl>
    <ul>
        <li><a href="member.html" ><span  class=" iconfont20 icon-huiyuan">
            <!--<em><?php echo ($counts); ?></em>-->
        </span>会员总数</a></li>
        <li><a href="direct_member.html" ><span  class=" iconfont20 icon-1221214">
            <!--<em ><?php echo ($count_a); ?></em>-->
        </span>直接推荐</a></li>
        <li><a href="indirect_member.html" ><span  class=" iconfont20 icon-huiyuanxinxi">
            <!--<em><?php echo ($counts-$count_a); ?></em>-->
        </span>间接推荐</a></li>
        <li><a href="valid_member.html" ><span  class=" iconfont20 icon-huiyuangoumai">
            <!--<em><?php echo ($counts); ?></em>-->
        </span>有效会员</a></li>
    </ul>
</div>
<div class="Wallet1">
    <dl><a href="javascript:void(0);">
        <!--<em class="Icon Icon4"></em>-->
        <dt>我的活动</dt></a></dl>
    <ul>
        <li><a href="release_activity.html" ><span  class=" iconfont20 icon-fabu"></span>我要发布</a></li>
        <li><a href="user_activity.html"> <span  class=" iconfont20 icon-yicanjiaren"></span>我参加的</a></li>
        <li><a href="myactivity.html"> <span  class=" iconfont20 icon-huodong"></span>我发布的</a></li>
    </ul>
</div>
<div class="Wallet">
    <dl><a href="<?php echo U('user_address/querybypage');?>">
        <!--<em class="Icon Icon5"></em>-->
        <dt>地址管理</dt><dd>&nbsp;</dd></a></dl>
</div>
</div>
<div class="Wallet1">
    <ul>
        <li style="width: 33.333%;"><a href="<?php echo U('Wx/Users/toEdit/');?>"><span  class=" iconfont20 icon-shezhi"></span>设置</a></li>
        <li style="width: 33.333%;"><a href="feedback.html"> <span  class=" iconfont20 icon-iconfontyijianfankui"></span>意见反馈</a></li>
        <li  style="width: 33.333%;"><a href="gosettled.html"><span  class=" iconfont20 icon-shangjiaruzhu"></span>我要入驻</a></li>
    </ul>
</div>
          
              
           
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
</body>
</html>