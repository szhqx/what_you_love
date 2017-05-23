<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <meta name="apple-mobile-web-app-capable" content="no"/>
    <!-- 禁止数字识自动别为电话号码 -->
    <meta name="format-detection" content="telephone=no"/>
    <title>我的足迹</title>
    <link rel="stylesheet" href="/static/wx/bx/css/yj-base.css"/>
    <link rel="stylesheet" href="/static/wx/bx/css/collection.css"/>
</head>
<body>
<div class="yj-header">
    <a class="yj-icon yj-icon-left yj-left" href='javascript:;' onClick="javascript :history.go(-1);"></a>

    <h1 class="yj-title">我的足迹</h1>
</div>
<div class="yj-full-body" style="overflow: scroll;position:relative;  -webkit-overflow-scrolling: touch;" >
    <div class="yj-media yj-full-media">
        <?php if(!empty($footprintList)): if(is_array($footprintList)): $i = 0; $__LIST__ = $footprintList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="yj-media-list">
                    <div class="yj-media-img yj-pull-left">
                        <a href="/wx/goods/getgoodsdetails/goodsId/<?php echo ($vo["goodsId"]); ?>"><img src="/<?php echo ($vo["goodsThums"]); ?>"/></a>
                    </div>
                    <div class="yj-media-body yj-pull-right">
                        <h4 class="yj-media-title"><?php echo ($vo["goodsName"]); ?></h4>

                        <p class="yj-media-content"><?php echo ($vo["goodsName"]); ?></p>

                        <p class="yj-media-cash">￥<i><?php echo ($vo["shopPrice"]); ?></i></p>
                        <button type="button" data-goodsid="<?php echo ($vo["Id"]); ?>"><span class="yj-icon yj-icon-like" ></span></button>
                    </div>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
            <?php else: ?>
            <div class="yj-media-list" >
                当前未浏览过商品...
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
                $.post("/Wx/Users/delfootprint", {id:id}, function(data){
                    if(data.status==1){
                        //成功
                        $(".yj-full-body").prepend("<div class=alert>已删除足迹</div>");
                        $(".alert").delay(800).fadeOut(300);
                    }else{
                        $(".yj-full-body").prepend("<div class=alert>删除足迹失败</div>");
                        $(".alert").delay(800).fadeOut(300);
                        //失败
                    }
                });

            })
        })
    })
</script>
</body>
</html>