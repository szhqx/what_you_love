<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html >
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title>爱乐享活动列表页</title>
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>

<!--<link href="themesmobile/68ecshopcom_mobile/style.css" rel="stylesheet" type="text/css" />-->

<link rel="stylesheet" type="text/css" href="/static/wx/css/public.css"/>
<link rel="stylesheet" type="text/css" href="/static/wx/css/activity.css"/>    
<script type="text/javascript" src="/static/wx/js/jquery.js"></script>


<script type="text/javascript" src="/static/wx/js/common.js"></script></head>
<body style="background:#f4f2f3">
<!--loading start-->
<div class="cover" id="loading" data-page="0">
    <div class="loading">
        <div class="dot white"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div>
    </div>
</div>
<!--loading end-->
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
     
     <?php if(is_array($activity['root'])): $i = 0; $__LIST__ = $activity['root'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="huodong">
          <a href="<?php echo U('activity/show',array('id'=>$vo['activityId']),'');?>"><div class="huodong_mid">
              <div class="h_right">
               <div class="img"><img src="/<?php echo ($vo["picurl"]); ?>">
               <span><strong>活动主题：</strong><?php echo ($vo["activityTitle"]); ?></span>
               </div>
                </div>
              </div>
          </a>
      </div><?php endforeach; endif; else: echo "" ;endif; ?>

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
<script>
    $(function(){
        //关闭loading层
        $("#loading").hide();
    });
</script>
<script type="text/javascript">
    //console.log(111);
    var p=2;
    $(function(){
        //页面初始化时执行瀑布流
        //用户拖动滚动条，达到底部时ajax加载一次数据
        var loading = $("#loading").data("page", 0);//通过给loading这个div增加属性on，来判断执行一次ajax请求
        $(window).scroll(function(){
            //console.log($("#loading").data("page"));
            if($("#loading").data("page")==1){
                return false;
            }
            if($(document).scrollTop() > $(document).height()-$(window).height()-$('footer').height()){ //页面拖到底部了
                //加载更多数据
                var ll = layer.msg('数据加载中，请稍候...', {icon: 16,shade: [0.5, '#B3B3B3']});
                loading.data("page",1);         //在这里将on设为true来阻止继续的ajax请求///Wx/goods/getMore/keyWords/<?php echo ($keyWords); ?>/msort/<?php echo ($msort); ?>/mark/<?php echo ($mark); ?>/pcurr/"+p
                jQuery.post("/Wx/Activity/index",{p:p} ,function(data){
                    layer.close(ll);
                    p++;
                    if(data.status){
                        $(".bxcont .msglist").append(data.message);
                        $("#loading").data("page",0);
                    }else{
                        $("#loading").data("page",1);
                    }

                },"json");
            }

        });
    });
    //
</script>
    </body>
</html>