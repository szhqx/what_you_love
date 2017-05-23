<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>
<meta name="Generator" content="qianpok" />
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title>用户中心_地址管理</title>
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<link rel="stylesheet" type="text/css" href="/static/wx/css/public.css">
<link rel="stylesheet" type="text/css" href="/static/wx/css/user.css">
<script type="text/javascript" src="/static/wx/js/jquery.js"></script>
    <script type="text/javascript" src="/static/wx/js/common.js"></script>
    <script type="text/javascript" src="/static/wx/js/address.js"></script>
</head>
<body style="background: rgb(235, 236, 237);">
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
<style>
    .addresslist{
        border: 1px solid red;
        padding:1px;
    }
    .list_footer{
        text-align: center;
    }
    .list_footer a{
        display:initial;
        padding: 5px 10px 5px 10px;
    }
</style>
<div id="wrapper">
      <div id="viewport">
          <div class="address_list">
              <div id="OrderList" class="ord_list">
                  <?php if(is_array($List)): $i = 0; $__LIST__ = $List;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div data-id="<?php echo ($vo['addressId']); ?>" <?php if($vo['isDefault'] == 1): ?>class="addresslist address"<?php else: ?>class="address"<?php endif; ?>>
                  <h2><span>收件人：</span> <?php echo ($vo['userName']); ?></h2>
                      <dl class="dingdan">
                          <dd><p>联系电话 &nbsp;<?php echo ($vo['userTel']); ?>&nbsp;<?php echo ($vo['userPhone']); ?></p></dd>
                      </dl>
                      <dl class="dingdan">
                          <dd><p><?php echo ($vo['areaName1']); echo ($vo['areaName2']); echo ($vo['areaName3']); echo ($vo['address']); ?></p></dd>
                      </dl>
                   </div>
                  <ul>
                      <li> &nbsp;</li>
                      <li>
                          <a href="javascript:delAddress(<?php echo ($vo['addressId']); ?>)">删除</a>&nbsp;
                          <a href="javascript:toEditAddress(<?php echo ($vo['addressId']); ?>)">编辑</a>
                      </li>
                  </ul><?php endforeach; endif; else: echo "" ;endif; ?>
              </div>
          </div>
      </div>
    <div style=" width:100%; height:50px;">
    </div>
    <div class="list_footer">
        <a href="<?php echo U('Orders/checkOrderInfo');?>">返回确认订单</a>
        <a href="javascript:void(0);" onclick='javascript:toEditAddress(0)'>添加新地址</a>
    </div>
</div>
<script>
    $(".address").click(function(){
        var this_event = $(this);
        var address_id = this_event.data("id");
        $.ajax({
            url:"/Wx/UserAddress/setdefault",
            data:{id:address_id},
            type:'post',
            dataType:'json',
            success:function(data){
                if(data.status ==1){
                    WST.msg('操作成功!', {icon: 1}, function(){
                        this_event.addClass("addresslist").siblings().removeClass("addresslist");
                    });
                }else{
                    WST.msg('操作失败!', {icon: 5});
                    return false;
                }
            }
        });
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