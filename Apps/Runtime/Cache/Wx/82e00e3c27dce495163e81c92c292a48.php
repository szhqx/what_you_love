<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>确定订单</title>
    <meta name="Keywords" content="" />
    <meta name="Description" content="" />
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <link rel="stylesheet" type="text/css" href="/static/wx/css/public.css"/>
    <link rel="stylesheet" type="text/css" href="/static/wx/css/activity.css"/>
    <script type="text/javascript" src="/static/wx/js/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="/static/wx/css/order.css"/>

    <script type="text/javascript" src="/static/wx/js/common.js"></script></head>


<body style="background:#f4f2f3; font-size: 12px; ">
<?php $title_name = "确定订单"; ?>

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
<form action="<?php echo U('shop/order_post');?>" method="post" id="order_post">
<a href="<?php echo U('UserAddress/queryByPage');?>"  class="ad_tjdz">
    <input type="hidden" id="consigneeId" name="consigneeId" value="<?php echo ($addressList[0]['addressId']); ?>"/>
    <?php if(!empty($addressList)): if(is_array($addressList)): $k = 0; $__LIST__ = $addressList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$address): $mod = ($k % 2 );++$k;?><div class="tjdz_top clearfix">
                    <div class="tjdz_name float-l">
                        收货人：<span><?php echo ($address["userName"]); ?></span>&nbsp;&nbsp;&nbsp;
                        联系电话：
                        <span>
                            <?php if($address['userPhone'] != ''): echo ($address["userPhone"]); ?>
                                <?php else: ?>
                                <?php echo ($address["userTel"]); endif; ?>
                        </span>
                    </div>
                </div>
                <div class="tjdz_add">
                    收货地址:<span><?php echo ($address["areaName1"]); echo ($address["areaName2"]); echo ($address["areaName3"]); echo ($address["communityName"]); echo ($address["address"]); ?></span>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
    <?php else: ?>
        请选择或添加收货人地址<?php endif; ?>
    <img class="ad_wz" src="/static/wx/images/icons_07.png" width="10" height="15" />
</a>
<?php if(is_array($catgoods)): $key = 0; $__LIST__ = $catgoods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$shopgoods): $mod = ($key % 2 );++$key;?><div class="zc_bt"><?php echo ($shopgoods["shopgoods"][0]["shopName"]); ?> <span style="float:right">包邮起步价：¥<?php echo ($shopgoods["shopgoods"][0]["deliveryFreeMoney"]); ?>元</span></div>
        <?php if(is_array($shopgoods['shopgoods'])): $key2 = 0; $__LIST__ = $shopgoods['shopgoods'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods): $mod = ($key2 % 2 );++$key2;?><div class="zc_pic">
                    <div class="mall_img float-l">
                        <a href="<?php echo U('Wx/Goods/getGoodsDetails/',array('goodsId'=>$goods['goodsId']));?>">
                            <img width="100" height="100" src="/<?php echo ($goods['goodsThums']); ?>"  onerror="javascript:this.src='/Upload/mall/2016-04/570880247854a.gif'"/>
                        </a>
                    </div>
                    <div class="zc_text1 float-r">
                        <div class="zc_text1_left float-l">商品：<?php echo ($goods["goodsName"]); ?></div>
                        <div class="zc_text1_right float-r"><span class="zc_color">
                                &#165;<b><?php echo ($goods["shopPrice"]); ?></b></span><br/>
                            <span>x<?php echo ($goods['cnt']); ?></if></span>
                        </div>
                            <div class="zc_text1_left float-l" style="margin-top: 5px; color: #999;"><?php if($goods['attrVal'] != ''): echo ($goods['attrName']); ?>:<span><?php echo ($goods['attrVal']); ?></span><?php endif; ?> <?php echo (returnattr($goods['goodsatts'])); ?></div>
                    </div>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>

    <div class="zc_center">
        <div class="zc_hang">
            <div class="zc_left">快递费</div>
            <div class="zc_right zc_color">
                <input type="hidden" id="deliveryMoney_<?php echo ($key); ?>" value='<?php if($shopgoods["totalMoney"] < $shopgoods["shopgoods"][0]["deliveryFreeMoney"]): ?>¥<?php echo ($shopgoods["shopgoods"][0]["deliveryMoney"]); else: ?>免运费<?php endif; ?>'/>
                <span id="deliveryMoney_span_<?php echo ($key); ?>">
                <?php if($shopgoods["totalMoney"] < $shopgoods["shopgoods"][0]["deliveryFreeMoney"]): ?>¥<?php echo ($shopgoods["shopgoods"][0]["deliveryMoney"]); else: ?>免运费<?php endif; ?>
                </span>
            </div>
        </div>
    </div><?php endforeach; endif; else: echo "" ;endif; ?>
    <div class="zc_center">
        <div class="zc_hang">
            <div class="zc_left">微信支付</div>
            <div class="zc_right zc_color">
               <input type="radio" name="paytype" value="1">
            </div>
        </div>
        <div class="zc_hang">
            <div class="zc_left">余额支付（当前用户余额：<?php echo ($WST_USER['userBalance']); ?>）</div>
            <div class="zc_right zc_color">
                <input type="radio" name="paytype" value="3">
            </div>
        </div>
    </div>
</form>


<div style="height:100px; line-height:50px; clear:both;"></div>

<div class="v_nav" style="height:37px; background: #fff;">
    <div class="mstzbox">
        <div class="car_fxk car_fxk1"><span class="icon-xuanzeyixuanze span_wz3"></span></div>
        <input type="hidden" id="gtotalMoney" value="<?php echo ($gtotalMoney); ?>"/>
        <input type="hidden" id="totalMoney" value="<?php echo ($totalMoney); ?>"/>
        <a class="wyzc mstzbox-cor1"><div class="wyzc_cc">合计：<span class="zc_color">&#165;<b><?php echo ($totalMoney); ?></b></span></div></a>
        <a href="javascript:submitOrder()"  id="zcPay" class="wyzc mstzbox-gz mstzbox-cor2">确定</a>
    </div>
</div>
<script src="/Public/js/common.js"></script>
<script src="/Apps/Wx/View/cartpaylist.js"></script>

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