<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title>商品列表</title>
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<link rel="stylesheet" type="text/css" href="/static/wx/css/public.css"/>
<link rel="stylesheet" type="text/css" href="/static/wx/css/activity.css"/>
<script type="text/javascript" src="/static/wx/js/jquery.js"></script>
<script type="text/javascript" src="/static/wx/js/common.js"></script></head>
<style type="text/css">
.clearfix:after{display:block;clear:both;content:"";visibility:hidden;height:0}
.clearfix{zoom:1} 
.float-r{ float: right !important;}
.float-l{ float: left !important;}
ul{list-style: none; }
b,i{ font-weight:normal;}
.cont_px{width: 100%;}
.cont_px ul{ border-bottom: 1px solid #f2f2f2; overflow: hidden; padding: 5px 0px; background: #fff;}
.cont_px ul li{width: 25%; float: left; text-align: center; line-height: 25px;}
.cont_px ul .li_cur{color: #dc2222;}

.cont_brand{background:#eeeeee; padding-bottom: 8px; overflow: hidden;}
.cont_brand ul li{ margin: 8px 0px 0px 1.8%; width: 22%; float: left; text-align: center; line-height: 30px;border: 1px solid #e2e2e2; background: #fff; border-radius: 3px;}

.cont_list{ overflow: hidden; width: 100%; background: #fff;}
.list_left{overflow: hidden; width: 120px; height: 120px;}
.list_right{width: 60%; padding:5px 0px 0px 0px;height: 120px;line-height: 20px;margin-left: 8px;}
.list_tit{ font-size:14px ; color: #051b29; height: 40px; overflow: hidden; padding-right: 5px;}
.list_xs{color: #a0a0a0; margin: 15px 0px; }
.list_xs b{ margin: 0px 3px;}
.list_xs span{ margin-right:10px;}
.list_price{ color: #dd2626;}
.list_price span{ font-size:16px; margin-left: 3px;margin-right:10px;}
.list_price b{ color: #9d9d9d;}
.list_line{ width: 500%; height: 1px; border-bottom: 1px solid #ebebeb; margin-top: 6px;}


.column{width: 49%;margin-right: 1%; float: left; }
.column_none{margin-left: 0px;}
.column_brand{background:#eeeeee; padding-bottom: 8px; overflow: hidden;}
.column_brand ul li{ margin: 8px 0px 0px 5%; width: 40%; float: left; text-align: center; line-height: 30px;border: 1px solid #e2e2e2; background: #fff; border-radius: 3px;}
.column_list{ overflow: hidden; width: 100%;margin-top: 2px;}
.column_left{overflow: hidden;}
.column_right{width: 100%; padding:5px 0px 3px 0px;line-height: 20px;overflow: hidden; background: #fff;border-bottom: 1px solid #ebebeb;}
.column_tit{ font-size:14px ; color: #051b29; height: 20px; overflow: hidden; padding: 0px 5px;}
.column_price{  padding: 0px 5px;overflow: hidden; margin: 10px 0px 8px 0px;}
.column_price span{  margin-left: 3px;margin-right:10px;color: #dd2626;}
.column_price span b{ font-size:16px;}
.column_price i{ color: #9d9d9d;}
.column_price b{ margin: 0px 5px;}

.bscurr{
background-image: url("/Apps/Home/View/default/images/sprite.png");
background-position: -60px 0;
display: inline-block;
height: 11px;
width: 12px;
}
.bscurr_up {
	background-image: url("/Apps/Home/View/default/images/sprite.png");
	background-position: -90px 0;
	display: inline-block;
	height: 11px;
	width: 12px;
}
</style>


<body style="background:#eeeeee; font-size: 12px; 	">

	<?php $title_name = "商品列表"; ?>
	<input type="hidden" id="msort" value="<?php echo ($msort); ?>"/>
	<header>
		<div class="tab_nav">
			<div class="header">
				<div class="h-left">
						<a href="<?php echo U('goods/goodsCategory');?>" class="top_bt"></a>
				</div>
				<div class="h-mid"><?php echo ($title_name); ?></div>
				<div class="h-right">
					<aside class="top_bar">
						<div onClick="show_menu();$('#close_btn').addClass('hid');" id="show_more"><a href="javascript:;"></a> </div>
					</aside>
				</div>
			</div>
		</div>
	</header>
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
		<!--
        	描述：排序
        -->
        <div class="cont_px">
        	<ul>
				<input id="c3Id" type="hidden" value="<?php echo ($c3Id); ?>">
				<input id="kW" type="hidden" value="<?php echo ($keyWords); ?>">
				<li <?php if($mark < 6): ?>class="li_cur"<?php endif; ?> onclick="queryGoods(this,1);">综合<s <?php if(($msort == 0) AND ($mark < 6)): ?>class="bscurr_up"<?php else: ?>class="bscurr"<?php endif; ?>></s></li>
				<li <?php if($mark == 6): ?>class="li_cur"<?php endif; ?> onclick="queryGoods(this,6);">人气<s <?php if(($msort == 0) AND ($mark == 6)): ?>class="bscurr_up"<?php else: ?>class="bscurr"<?php endif; ?>></s></li>
				<li <?php if($mark == 7): ?>class="li_cur"<?php endif; ?> onclick="queryGoods(this,7);">销量<s <?php if(($msort == 0) AND ($mark == 7)): ?>class="bscurr_up"<?php else: ?>class="bscurr"<?php endif; ?>></s></li>
				<li <?php if($mark == 8): ?>class="li_cur"<?php endif; ?> onclick="queryGoods(this,8);">价格<s <?php if(($msort == 0) AND ($mark == 8)): ?>class="bscurr_up"<?php else: ?>class="bscurr"<?php endif; ?>></s></li>
        		<!--<li>店铺</li>-->
        		<!--<li style="border-left: 1px solid #f2f2f2;">列表/两列</li>-->
        	</ul>
        </div>
		<!--
        	描述：一列排版
        -->
        <div style="display: block;">
			<!--
	        	描述：品牌
	        -->
			<div class="cont_brand" hidden>
	        	<ul>
					<li <?php if($brandId == 0): ?>class="searched"<?php endif; ?> data="0" onClick="queryGoods(this,3);">全部</li>
					<?php if(is_array($brands)): $i = 0; $__LIST__ = $brands;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li id="brand_<?php echo ($vo['brandId']); ?>" <?php if($vo['brandId'] == $brandId): ?>class="li_cur"<?php endif; ?> data="<?php echo ($vo['brandId']); ?>" onClick="queryGoods(this,3);"><?php echo (substr($vo['brandName'],0,10)); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>

	        	</ul>
	        </div>
			<!--
	        	描述：商品列表
	        -->
			<?php if(!empty($pages['root'])): ?><div  id="container" class="container">
				<?php if(is_array($pages['root'])): $key = 0; $__LIST__ = $pages['root'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods): $mod = ($key % 2 );++$key;?><a href="<?php echo U('Wx/Goods/getGoodsDetails/',array('goodsId'=>$goods['goodsId']));?>" title="<?php echo ($goods['goodsName']); ?>">
			<div class="cont_list" style="display: block;">
	        	<div class="list_left float-l">
	        		<img src="/<?php echo ($goods['goodsThums']); ?>" onerror="javascript:this.src='/Upload/mall/2016-04/570880247854a.gif'" width="120" height="120" />
	        	</div>
	        	<div class="list_right float-l">
	        		<div class="list_tit"><?php echo ($goods['goodsName']); ?></div>
	        		<div class="list_xs">
	        			<span><b><?php echo ($goods["saleCount"]); ?></b>人已购买</span>
	        			<span><?php echo ($goods['shopName']); ?></span>
	        		</div>
	        		<div class="list_price">&#165;<span><?php echo ($goods['shopPrice']); ?></span><b></b></div>
	        		<div class="list_line"></div>
	        	</div>
	        </div>
					</a><?php endforeach; endif; else: echo "" ;endif; ?>

			</div>
			<div id="loading" class="loading-wrap" style="text-align: center;">
				<span class="loading" >加载中，请稍后...</span>
			</div>
				<?php else: ?>
			<div style="text-align: center;color: #004444;padding-bottom: 90%;font-size: 30px;padding-top: 20%;"><span >暂无此分类商品</span></div><?php endif; ?>
			<!--加载中-->

        </div>
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
	<script src="/Apps/Wx/View/goods.js"></script>
	<script type="text/javascript">
		var p=2;
		var b=0;
		$(function(){
			//页面初始化时执行瀑布流
			//用户拖动滚动条，达到底部时ajax加载一次数据
			var loading = $("#loading").data("on", false);//通过给loading这个div增加属性on，来判断执行一次ajax请求
			$(window).scroll(function(){
				if(loading.data("on")) return;
				if($(document).scrollTop() > $(document).height()-$(window).height()-$('.footer').height()){ //页面拖到底部了
					//加载更多数据
					var msort = '<?php echo ($msort); ?>';
					var mark = '<?php echo ($mark); ?>';
					var keywords ='<?php echo ($keyWords); ?>';
					var c3Id ='<?php echo ($c3Id); ?>';
					loading.data("on", true).fadeIn();         //在这里将on设为true来阻止继续的ajax请求///Wx/goods/getMore/keyWords/<?php echo ($keyWords); ?>/msort/<?php echo ($msort); ?>/mark/<?php echo ($mark); ?>/pcurr/"+p
					jQuery.post("/Wx/Goods/getMore",{pcurr:p ,msort:msort,mark:mark,keyWords:keywords,c3Id:c3Id} ,function(data){
								var html = '';
								if($.isArray(data)){
									for(i in data){
										html += '<a href="/wx/goods/getgoodsdetails/goodsId/'+data[i].goodsId+'" title="<?php echo ($goods['goodsName']); ?>">';
										html += '<div class="cont_list" style="display: block;">';
										html += '<div class="list_left float-l">';
										html += '<img src="/'+data[i].goodsThums+'" onerror="javascript:this.src=\'/Upload/mall/2016-04/570880247854a.gif\'" width="120" height="120" />';
										html += '</div>';
										html += '<div class="list_right float-l">';
										html += '<div class="list_tit">'+data[i].goodsName+'</div>';
										html += '<div class="list_xs">';
										html += '<span><b>'+data[i].saleCount+'</b>人已购买</span>';
										html += '<span></span>';
										html += '</div>';
										html += '<div class="list_price">&#165;<span>'+data[i].shopPrice+'</if></span><b></b></div>';
										html += '<div class="list_line"></div>';
										html += '</div>';
										html += '</div>';
										html += '</a>';
										if(i==2){
											 p++;
											 b=1;
										}
									}
									$("#container").append(html);
									//一次请求完成，将on设为false，可以进行下一次的请求
									if(b==1){
										$("#loading").data("on", false);
									}


								}
								loading.fadeOut();
							},
							"json");
				}

			});
		});
		$("#loading").hide();
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