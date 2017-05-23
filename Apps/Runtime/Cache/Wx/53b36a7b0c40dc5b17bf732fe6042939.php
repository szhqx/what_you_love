<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html >
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title>用户中心_订单</title>
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<link rel="stylesheet" type="text/css" href="/static/wx/css/public.css">
<link rel="stylesheet" type="text/css" href="/static/wx/css/user.css">
<script type="text/javascript" src="/static/wx/js/jquery.js"></script>
    <script type="text/javascript" src="/static/wx/js/common.js"></script>
    <script type="text/javascript" src="/static/wx/js/order.js"></script>
	</head>
<style>
     ul{list-style: none; }
     b,i{ font-weight:normal;}
    .cont_px{width: 100%;}
    .cont_px ul{ border-bottom: 1px solid #f2f2f2; overflow: hidden; padding: 5px 0px; background: #fff;}
    .cont_px ul li{width: 20%; float: left; text-align: center; line-height: 25px;font-size: 14px;}
    .cont_px ul .li_cur{color: #dc2222;}
</style>
<body style="background: rgb(235, 236, 237);">
      <header>
      <div class="tab_nav">
        <div class="header">
          <div class="h-left"><a class="sb-back" href="javascript:history.back(-1)" title="返回"></a></div>
          <div class="h-mid">我的订单</div>
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
      <div class="cont_px">
          <ul>
              <a href="<?php echo U('Orders/queryPayByPage');?>"> <li <?php if($umark == 'queryPayByPage'): ?>class="li_cur"<?php endif; ?> >待付款</li></a>
              <a href="<?php echo U('Orders/queryDeliveryByPage');?>"> <li <?php if($umark == 'queryDeliveryByPage'): ?>class="li_cur"<?php endif; ?>>待发货</li></a>
              <a href="<?php echo U('Orders/queryReceiveByPage');?>"> <li <?php if($umark == 'queryReceiveByPage'): ?>class="li_cur"<?php endif; ?>>待收货</li></a>
              <a href="<?php echo U('Orders/queryAppraiseByPage');?>"> <li <?php if($umark == 'queryAppraiseByPage'): ?>class="li_cur"<?php endif; ?>>待评价</li></a>
              <a href="<?php echo U('Orders/queryCancelOrders');?>"> <li <?php if($umark == 'queryCancelOrders'): ?>class="li_cur"<?php endif; ?>>退款</li></a>
          </ul>
      </div>
      <div id="wrapper">
          <div id="viewport">
              <div class="order_list">
                  <?php if(is_array($receiveOrders['root'])): $key1 = 0; $__LIST__ = $receiveOrders['root'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$order): $mod = ($key1 % 2 );++$key1;?><div id="OrderList" class="ord_list">
                          <h3>订单编号：<?php echo ($order["orderNo"]); ?><span style="float: right; padding-right: 10%;"><var style="color: #999;"> 状态：</var><?php if($order["orderStatus"] == -3): ?>拒收
                              <?php elseif($order["orderStatus"] == -2): ?>未付款
                              <?php elseif($order["orderStatus"] == -1): ?>已取消
                              <?php elseif($order["orderStatus"] == 0): ?>未受理
                              <?php elseif($order["orderStatus"] == 1): ?>已受理
                              <?php elseif($order["orderStatus"] == 2): ?>打包中
                              <?php elseif($order["orderStatus"] == 3): ?>配送中
                              <?php elseif($order["orderStatus"] == 4): ?>已到货
                              <?php elseif($order["orderStatus"] == 5): ?>确认收货<?php endif; ?></span></h3>
                          <?php if(is_array($order['goodslist'])): $key2 = 0; $__LIST__ = $order['goodslist'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods): $mod = ($key2 % 2 );++$key2;?><dl class="dingdan">
                                  <dt><a href="<?php echo U('Wx/Goods/getGoodsDetails/',array('goodsId'=>$goods['goodsId']));?>"><img src="/<?php echo ($goods['goodsThums']); ?>" onerror="javascript:this.src='/Upload/mall/2016-04/570880247854a.gif'"></a></dt>
                                  <dd>
                                      <p>&nbsp;<?php echo ($goods['goodsName']); ?></p>
                                      <p>
                                          <span>&nbsp;<?php echo ($goods['goodsAttrsName']); ?></span>&nbsp;&nbsp;
                                      </p>
                                      <span>&nbsp;<?php echo ($goods['goodsPrice']); ?>&nbsp;x&nbsp;<?php echo ($goods['goodsNums']); ?></span>
                                  </dd>
                              </dl><?php endforeach; endif; else: echo "" ;endif; ?>
                          <ul>
                              <li>总价<strong>：￥<?php echo ($order["totalMoney"]); ?>元</strong> </li>
                              <li>


                                      <a href="javascript:;" onclick="orderConfirm(<?php echo ($order['orderId']); ?>,1)">确认收货</a>
                                  <a href="javascript:;" onclick="orderConfirm(<?php echo ($order['orderId']); ?>,-1)">拒收</a>
                                  <a href="javascript:;" onclick="showOrder('<?php echo ($order["orderId"]); ?>')">查看</a>
                              </li>
                          </ul>
                      </div><?php endforeach; endif; else: echo "" ;endif; ?>

                  <div style="background:#FFF;">
                      <section class="list-pagination">
                          <div style="" class="pagenav-wrapper" id="J_PageNavWrap">
                              <div class="pagenav-content">
                                  <div class="pagenav" id="J_PageNav">
                                      <?php echo ($order_show); ?>
                                  </div>
                              </div>
                          </div>
                      </section>
                  </div>
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