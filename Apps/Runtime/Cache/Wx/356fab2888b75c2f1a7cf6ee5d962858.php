<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title>我的购物车</title>
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>

<!--<link href="themesmobile/68ecshopcom_mobile/style.css" rel="stylesheet" type="text/css" />-->

<link rel="stylesheet" type="text/css" href="/static/wx/css/public.css"/>
<link rel="stylesheet" type="text/css" href="/static/wx/css/activity.css"/>
<script type="text/javascript" src="/static/wx/js/jquery.js"></script>


<script type="text/javascript" src="/static/wx/js/common.js"></script></head>
<body style="background:#f4f2f3">
<?php $title_name = "我的购物车"; ?>

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

<form action="<?php echo U('shop/order');?>" method="post" id="cart">
    <div id="wst_cartlist_pbox">
        <?php if(empty($cartInfo['cartgoods'])): ?><div style="text-align:center;font-size:20px;line-height:80px;">
                您的购物车空空如也，赶快开始购物吧！
            </div>
            <br/><?php endif; ?>
        <?php if(is_array($cartInfo['cartgoods'])): $i = 0; $__LIST__ = $cartInfo['cartgoods'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$shopgoods): $mod = ($i % 2 );++$i;?><div id="wst_cart_shop_<?php echo ($key); ?>" data="<?php echo ($key); ?>">
                <div class="thing" data-price="<?php if($vo.rel_price): echo ($vo["rel_price"]); else: echo ($vo["discount"]); endif; ?>">
                    <div class="thtop">
                        <ul class="thtopul">
                            <li><a href="<?php echo U('wx/shops/index',array('shopId'=>$shopgoods['shopgoods'][0]['shopId']));?>"><i><img src="/static/wx/images/dianpu.png" class="dianpu"></i><span id="sp_<?php echo ($shopgoods['shopgoods'][0]['shopId']); ?>"><?php echo ($shopgoods["shopgoods"][0]["shopName"]); ?></span>
                                <img src="/static/wx/images/icons_07.png"></a></li>
                        </ul>
                    </div>
                    <div class="thbt"  id="catgoodsList">
                        <?php if(is_array($shopgoods['shopgoods'])): $key2 = 0; $__LIST__ = $shopgoods['shopgoods'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods): $mod = ($key2 % 2 );++$key2;?><ul class="clearfix selgoods_<?php echo ($goods['goodsatts']); ?>" id="selgoods_<?php echo ($goods['goodsId']); ?>_<?php echo ($goods['goodsAttrId']); ?>"  datakey="<?php echo ($goods['goodsatts']); ?>"  class="selgoods" <?php if($goods['goodsStock'] < $goods['cnt'] OR $goods['goodsStock'] == 0): ?>style="border:2px solid red;"<?php endif; ?>>
                            <input type="hidden" value="<?php if($goods['goodsStock'] < $goods['cnt']): ?>-1<?php endif; ?>" class="goodsStockFlag"/>
                                <li style="width: 2%">
                                    <input type="checkbox" style="visibility:hidden;" id="chk_goods_<?php echo ($goods['goodsatts']); ?>" datakey="<?php echo ($goods['goodsatts']); ?>"  name="chk_goods_<?php echo ($goods['goodsatts']); ?>" value="<?php echo ($goods['goodsId']); ?>" parent="<?php echo ($goods['shopId']); ?>" dataId="<?php echo ($goods['goodsAttrId']); ?>" isBook="<?php echo ($goods['isBook']); ?>" <?php if($goods['ischk'] == 1): ?>checked<?php endif; ?>/>
                                    <input type="hidden" class="cgoodsId" dataId="<?php echo ($goods['goodsAttrId']); ?>" datakey="<?php echo ($goods['goodsatts']); ?>" value="<?php echo ($goods['goodsId']); ?>" />
                                    <input type="hidden" id="price_<?php echo ($goods['goodsId']); ?>_<?php echo ($goods['goodsAttrId']); ?>" value="<?php echo ($goods['shopPrice']); ?>" />
                                </li>
                                <li style="width: 30%"><i>
                                    <a target="_blank" href="<?php echo U('Wx/Goods/getGoodsDetails/',array('goodsId'=>$goods['goodsId']));?>" target="_blank"><img src="/<?php echo ($goods['goodsThums']); ?>" onerror="javascript:this.src='/Upload/mall/2016-04/570880247854a.gif'" max-width="60" max-height="60" /></a>
                                </i></li>
                                <li style="width: 66%">
                                    <div class="dianming" style="line-height: 35px; height:70px;"><?php echo WSTMSubstr($goods["goodsName"],0,16);?></div>
                                    <div class="desc" style="color: #999; height: 24px;">
                                        <?php if($goods['attrVal'] != ''): ?><span><?php echo ($goods['attrName']); ?>:<?php echo ($goods['attrVal']); ?> <?php echo (returnattr($goods['goodsatts'])); ?></span><?php endif; ?>
                                    </div>
                                    <div class="dprice">
                                        ￥<?php echo ($goods["shopPrice"]); ?>
                                        <div class="cartnum clearfix">
                                            <span class="cicon minus wst-cartlist-plus" id="numl_<?php echo ($goods['goodsId']); ?>_<?php echo ($goods['goodsAttrId']); ?>" onclick="changeCatGoodsnum(1,'<?php echo ($goods['shopId']); ?>','<?php echo ($goods['goodsId']); ?>','<?php echo ($goods['goodsAttrId']); ?>','<?php echo ($goods['isBook']); ?>','<?php echo ($goods['goodsatts']); ?>')">-</span>
                                            <span class="cnum"><input type="text" id="buy-num_<?php echo ($goods['goodsatts']); ?>" dataId="<?php echo ($goods['goodsAttrId']); ?>" min="0" value="<?php echo ($goods['cnt']); ?>" onkeypress="return WST.isNumberKey(event);" onkeyup="changeCatGoodsnum(0,'<?php echo ($goods['shopId']); ?>','<?php echo ($goods['goodsId']); ?>','<?php echo ($goods['goodsAttrId']); ?>','<?php echo ($goods['isBook']); ?>');"  readonly/></span>
                                            <span class="cicon plus wst-cartlist-add"  id="numr_<?php echo ($goods['goodsId']); ?>_<?php echo ($goods['goodsAttrId']); ?>" onclick="changeCatGoodsnum(2,'<?php echo ($goods['shopId']); ?>','<?php echo ($goods['goodsId']); ?>','<?php echo ($goods['goodsAttrId']); ?>','<?php echo ($goods['isBook']); ?>','<?php echo ($goods['goodsatts']); ?>')">+</span>
                                        </div>
                                        <div style="position: absolute; text-align:center;width:20%; height: 24px; line-height: 20px; border:1px #ccc solid;background: #fff;right:2%;top: -60px;"><a href="javascript:delCatGoods('<?php echo ($goods['shopId']); ?>','<?php echo ($goods['goodsId']); ?>','<?php echo ($goods['goodsAttrId']); ?>','<?php echo ($goods['goodsatts']); ?>');">删除</a></div>
                                    </div>
                                </li>
                             </ul><?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
</form>

<div class="insulate" style="height: 46px;"></div>
<div class="quanbu" style="margin-bottom: 0px;">
  <ul class="clearfix">
    <!--<li><input type="checkbox" id="chk_all" checked class="all-check">全选</li>-->
    <li class="heji">合计<var>￥</var><var id="wst_cart_totalmoney" class="wst-cart-totalmoney"> <?php echo ($cartInfo['totalMoney']); ?></var>元</li>
    <li class="jiesuan" onclick="javascript:goToPay();" >结算</li>
  </ul>
</div>
<!--<footer>
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
<script src="/Public/plugins/layer/layer.min.js"></script>-->
</body>
<script src="/Public/js/common.js"></script>
<script src="/Apps/Wx/View/cartpaylist.js?v=1111"></script>
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
</html>