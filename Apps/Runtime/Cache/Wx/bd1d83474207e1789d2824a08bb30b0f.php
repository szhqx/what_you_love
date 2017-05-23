<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <meta name="apple-mobile-web-app-capable" content="no"/>
    <!-- 禁止数字识自动别为电话号码 -->
    <meta name="format-detection" content="telephone=no"/>
    <title>商品收藏</title>
    <link rel="stylesheet" href="/static/wx/bx/css/yj-base.css"/>
    <link rel="stylesheet" href="/static/wx/bx/css/collection.css"/>
</head>
<body>
<div class="yj-header">
    <a class="yj-icon yj-icon-left yj-left" href='javascript:;' onClick="javascript :history.go(-1);"></a>
    <h1 class="yj-title">商品收藏</h1>
</div>
<div class="yj-full-body" style="overflow: scroll;position:relative;  -webkit-overflow-scrolling: touch;">
    <div class="yj-media yj-full-media">
        <?php if(!empty($goodspage)): if(is_array($goodspage)): $i = 0; $__LIST__ = $goodspage;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="yj-media-list">
                    <div class="yj-media-img yj-pull-left">
                        <a href="/wx/goods/getgoodsdetails/goodsId/<?php echo ($vo["goodsId"]); ?>"><img src="/<?php echo ($vo["goodsThums"]); ?>"/></a>
                    </div>
                    <div class="yj-media-body yj-pull-right">
                        <h4 class="yj-media-title"><?php echo ($vo["goodsName"]); ?></h4>

                        <p class="yj-media-content"><?php echo ($vo["goodsName"]); ?></p>

                        <p class="yj-media-cash">￥<i><?php echo ($vo["shopPrice"]); ?></i></p>
                        <button type="button" data-goodsid="<?php echo ($vo["favoriteId"]); ?>"><span class="yj-icon yj-icon-like" ></span></button>
                    </div>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
        <?php else: ?>
            <div class="yj-media-list" >
                暂无收藏商品...
            </div><?php endif; ?>
    </div>
</div>
<script src="/static/wx/js/jquery.js"></script>
<script src="/static/wx/bx/js/hammer.min.js"></script>
<script src="/static/wx/bx/js/jquery.hammer.js"></script>

<script>
    $(function () {
        $(".yj-full-body").height($(window).height() - $(".yj-header").height());
        $(".yj-media-body").each(function () {
            $(this).find("button").hammer().on("tap", function () {
                if ($(".alert").is(":hidden"))
                    $(".alert").remove()
                $(this).parents(".yj-media-list").remove();
                var id = $(this).data("goodsid");
                $.post("/Wx/Users/quxiao", {id:id}, function(data){
                    if(data.status==1){
                       //成功
                        $(".yj-full-body").prepend("<div class=alert>已取消收藏</div>");
                        $(".alert").delay(800).fadeOut(300);
                    }else{
                        $(".yj-full-body").prepend("<div class=alert>取消收藏失败</div>");
                        $(".alert").delay(800).fadeOut(300);
                        //失败
                    }
                });

            })
        })
    })
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