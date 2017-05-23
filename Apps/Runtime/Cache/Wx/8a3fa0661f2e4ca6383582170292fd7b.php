<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
	<title>嘻欢啥</title>
	<meta name="Keywords" content="嘻欢啥" />
	<meta name="Description" content="嘻欢啥" />
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
	<script type="text/javascript" src="/static/wx/js/TouchSlide.1.1.js"></script>
	<link rel="stylesheet" type="text/css" href="/static/wx/css/public.css"/>
	<link rel="stylesheet" type="text/css" href="/static/wx/css/index.css"/>
	<script type="text/javascript" src="/static/wx/js/jquery.js"></script>
	<script type="text/javascript" src="/static/wx/js/jquery.json.js"></script>
    <script type="text/javascript" src="/static/wx/js/transport.js"></script>
    <script type="text/javascript" src="/static/wx/js/touchslider.dev.js"></script>
    <script type="text/javascript" src="/static/wx/js/jquery.more.js"></script>
	<script type="text/javascript" src="/static/wx/js/common.js"></script>
</head>
<body>
	<div id="page" class="showpage">
    <div>
<header id="header">
    <script type="text/javascript">
var process_request = "正在处理您的请求...";
</script>
<script language="javascript">
<!--
/*屏蔽所有的js错误*/
function killerrors() {
return true;
}
window.onerror = killerrors;
//-->
</script>
<a href="<?php echo U('goods/goodsCategory');?>" class="top_bt" style="z-index: 99999999;"></a>
    <!--<em class="wst-nvg-cart-cnt" style="color: #bb120f;-->
    <!--position: absolute;-->
    <!--background: #fff;-->
    <!--right: 0;-->
    <!--top: 0;-->
    <!--height: 15px;-->
    <!--line-height: 15px;-->
    <!--min-width: 15px;-->
    <!--text-align: center;-->
    <!--border-radius: 100%;">0</em>-->
    <!--<a href="<?php echo U('Cart/getCartInfo');?>" class='user_btn' style="z-index: 90000"></a>-->
     <!--<span href="javascript:void(0)" class="logo">嘻欢啥</span>-->
    <div class="index_search"  style="width: 90%;margin: auto;background: rgba(255, 255, 255, 0);">
        <div class="index_search_mid" style="margin-top: -15px;">
            <span style="border-left: 1px solid #fff;"><img src="/static/wx/images/icosousuo.png"></span>
            <input style="color:#fff;border: 1px solid #fff;" class="text" id="search_text" type="text" value="请输入您所搜索的商品"/>
        </div>
    </div>
</header>
<style>
	.scrollimg{position:relative; overflow:hidden; margin:0px auto; /* 设置焦点图最大宽度 */}
	.scrollimg .hd{ position: absolute;
bottom:0px;
text-align: center;
width: 100%;}
	.scrollimg .hd li{display: inline-block;
width: .4em;
height: .4em;
margin: 0 .4em;
-webkit-border-radius: .8em;
-moz-border-radius: .8em;
-ms-border-radius: .8em;
-o-border-radius: .8em;
border-radius: .8em;
background: #FFF;
filter: alpha(Opacity=60);
opacity: .6;
box-shadow: 0 0 1px #ccc; text-indent:-100px; overflow:hidden; }
	.scrollimg .hd li.on{ filter: alpha(Opacity=90);
opacity: .9;
background: #f8f8f8;
box-shadow: 0 0 2px #ccc; }
.scrollimg .bd{position:relative; z-index:0;}
.scrollimg .bd li{position:relative; text-align:center;}
.scrollimg .bd li img{ vertical-align:top; width:100%;/* 图片宽度100%，达到自适应效果 background:url(/static/wx/images/loading.gif) center center no-repeat; */}

.scrollimg .bd li .tit{display:block; width:100%;  position:absolute; bottom:0; text-indent:10px; height:28px; line-height:28px; background:url(/static/wx/images/focusBg.png) repeat-x; color:#fff;  text-align:left;}
</style>
<div id="scrollimg" class="scrollimg">
				<div class="bd">
					<ul>
			          <li><a href="#"><img src="/static/wx/testimg/1444326581816727837.jpg" width="100%" /></a></li>
                      <li><a href="#"><img src="/static/wx/testimg/1447190340323728176.jpg" width="100%" /></a></li>
                      <li><a href="#"><img src="/static/wx/testimg/1444326630503657826.jpg" width="100%" /></a></li>
				  </ul>
				</div>
				<div class="hd">
					<ul style="display: none;"></ul>
				</div>
</div>
			<script type="text/javascript">
				TouchSlide({
					slideCell:"#scrollimg",
					titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
					mainCell:".bd ul",
					effect:"leftLoop",
					autoPage:true,//自动分页
					autoPlay:true //自动播放
				});
			</script>

<section class="index_floor">
  <div class="floor_body1" >
<h2><em></em>今日精选<span class="geng"><a href="<?php echo U('goods/getGoodsList');?>" >更多<i></i></a></span></h2>
    <div id="scroll_hot" class="scroll_hot">
      <div class="bd">
        <ul>
            <?php if(is_array($jpgoods)): $i = 0; $__LIST__ = array_slice($jpgoods,0,6,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
            <a href="<?php echo U('Goods/getGoodsDetails',array('goodsId'=>$vo['goodsId']));?>" title="<?php echo ($vo["goodsName"]); ?>">
              <div class="products_kuang"  >
                <img src="/<?php echo ($vo['goodsThums']); ?>" onerror="javascript:this.src='/Upload/mall/2016-04/570880247854a.gif'" height="100"></div>
              <div class="goods_name" style="text-align:center;"><?php echo ($vo["goodsName"]); ?></div>
              <div class="price">
              <span href="<?php echo U('Goods/getGoodsDetails',array('goodsId'=>$vo['goodsId']));?>" class="price_pro">￥<?php if($vo["attrPrice"] != ''): echo ($vo["attrPrice"]); else: echo ($vo["shopPrice"]); endif; ?>元</span>
                 <a href="javascript:;">
                <!--<img src="/static/wx/images/index_flow.png"> addToCart('<?php echo ($vo["goodsId"]); ?>','<?php echo ((isset($vo["goodsAttrId"]) && ($vo["goodsAttrId"] !== ""))?($vo["goodsAttrId"]):0); ?>')-->
                </a>
              </div>
            </a>
          </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
          </div>
        </div>
        <div class="hd">
          <ul></ul>
        </div>
      </div>

  </section>
<script type="text/javascript">
    TouchSlide({
      slideCell:"#scroll_hot",
      titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
      effect:"leftLoop",
      autoPage:true, //自动分页
      //switchLoad:"_src" //切换加载，真实图片路径为"_src"
    });
  </script>
<?php if(!empty($recomgoods)): ?><section class="index_floor">
          <div class="floor_body1" >
            <h2><em></em>商城推荐<span class="geng"><a href="<?php echo U('goods/getGoodsList');?>" >更多<i></i></a></span></h2></div>

            <div class="index_hdlist">
            <?php if(is_array($recomgoods)): $i = 0; $__LIST__ = $recomgoods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Goods/getGoodsDetails',array('goodsId'=>$vo['goodsId']));?>" title="<?php echo ($vo["goodsName"]); ?>">
                    <ul><div class="hd01"><img  src="/<?php echo ($vo['goodsThums']); ?>" onerror="javascript:this.src='/Upload/mall/2016-04/570880247854a.gif'" ></div><div class="hd02"><h2><?php echo ($vo["goodsName"]); ?> </h2>

                        <span href="<?php echo U('Goods/getGoodsDetails',array('goodsId'=>$vo['goodsId']));?>" class="price_pro">￥<?php if($vo["attrPrice"] != ''): echo ($vo["attrPrice"]); else: echo ($vo["shopPrice"]); endif; ?>元</span></div>
                    </ul>
                </a><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
     </section><?php endif; ?>
        <!--<section class="index_floor">-->
            <!--<div class="floor_body1" >-->
                <!--<h2><em></em>商城推荐<span class="geng"><a href="<?php echo U('activity/index');?>" >更多<i></i></a></span></h2></div>-->

            <!--<div class="index_hdlist">-->
                <!--volist name="activity" id="vo">-->
                    <!--<a href="<?php echo U('activity/show',array('id'=>$vo['activityId']),'');?>">-->
                        <!--<ul><div class="hd01"><img src="/<?php echo (get_thumb_img($vo["picurl"],'_thumb')); ?>"></div><div class="hd02"><h2><?php echo ($vo["activityTitle"]); ?> </h2><p>开始时间：<?php echo ($vo["start_time"]); ?></p>-->
                            <!--<p>结束时间：<?php echo ($vo["end_time"]); ?></p>-->
                            <!--<p>地点：<?php echo ($vo["address"]); ?></p></div>-->
                        <!--</ul>-->
                    <!--</a>-->
                <!--</volist>-->
            <!--</div>-->
        <!--</section>-->
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
<script>
function goTop(){
	$('html,body').animate({'scrollTop':0},600);
}
</script>
<a href="javascript:goTop();" class="gotop"><img src="/static/wx/images/topup.png"></a>
</div>
<div id="search_hide" class="search_hide">
<h2>关键词搜索</h2>
<div class="search_body">
  <div class="search_box">
    <form action="/Wx/Goods/getGoodsList" method="post" id="searchForm" name="searchForm">
      <div>
      <button type="submit" value="搜 索" ></button>
        <input class="text" type="search" name="keyWords" id="keywordBox" autofocus>
      </div>
    </form>
  </div>
  <span class="close"> </span>
</div>
<section class="mix_recently_search"><h3>热门搜索</h3>
     <ul style="display: none;">
        <li>
           <a href="javascript:void(0);">11</a>
        </li>
    </ul>
  </section>
</div>
</div>
<script type="Text/Javascript" language="JavaScript">
function selectPage(sel)
{
   sel.form.submit();
}
</script>
<script type="text/javascript">
var button_compare = "";
var exist = "您已经选择了%s";
var count_limit = "最多只能选择4个商品进行对比";
var goods_type_different = "\"%s\"和已选择商品类型不同无法进行对比";
var compare_no_goods = "您没有选定任何需要比较的商品或者比较的商品数少于 2 个。";
var btn_buy = "购买";
var is_cancel = "取消";
var select_spe = "请选择商品属性";
</script>
<script type="text/javascript">
$(function() {
	$('#search_text').click(function(){
		$(".showpage").children('div').hide();
		$("#search_hide").css('position','fixed').css('top','0px').css('width','100%').css('z-index','999').show();
	})
	$('#get_search_box').click(function(){
		$(".showpage").children('div').hide();
		$("#search_hide").css('position','fixed').css('top','0px').css('width','100%').css('z-index','999').show();
	})
	$("#search_hide .close").click(function(){
		$(".showpage").children('div').show();
		$("#search_hide").hide();
	})
});
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