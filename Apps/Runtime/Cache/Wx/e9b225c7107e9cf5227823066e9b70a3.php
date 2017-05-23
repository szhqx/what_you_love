<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <meta name="apple-mobile-web-app-capable" content="no"/>
    <!-- 禁止数字识自动别为电话号码 -->
    <meta name="format-detection" content="telephone=no"/>
    <title>我参加的</title>
    <link rel="stylesheet" href="/static/wx/bx/css/yj-base.css"/>
    <link rel="stylesheet" href="/static/wx/bx/css/collection.css"/>
</head>
<body>
<div class="yj-header">
    <a class="yj-icon yj-icon-left yj-left" href='javascript:;' onClick="javascript :history.go(-1);"></a>

    <h1 class="yj-title">我参加的</h1>
</div>
<div class="yj-full-body">
    <div class="yj-media yj-full-media">
        <?php if(!empty($activity)): if(is_array($activity)): $i = 0; $__LIST__ = $activity;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="/wx/activity/show/id/<?php echo ($vo["activityId"]); ?>">
                    <div class="yj-media-list">
                        <div class="yj-media-img yj-pull-left">
                            <img src="/<?php echo ($vo["picurl"]); ?>"/>
                        </div>
                        <div class="yj-media-body yj-pull-right">
                            <h4 class="yj-media-title"><?php echo ($vo["activityTitle"]); ?></h4>
                            <p class="yj-media-content"><?php echo ($vo["desc"]); ?></p>
                            <p class="yj-media-cash"><i><?php echo ($vo["createTime"]); ?></i></p>
                            <button type="button" style="    height: 1.5em;width:4em; color: #fff;"><?php echo ($vo["isOff"]); ?></button>
                        </div>
                    </div></a><?php endforeach; endif; else: echo "" ;endif; ?>
            <?php else: ?>
            <div class="yj-media-list" >
                暂无参加过活动...
            </div><?php endif; ?>
    </div>
</div>
<script src="/static/wx/js/jquery.js"></script>
<script src="/static/wx/bx/js/hammer.min.js"></script>
<script src="/static/wx/bx/js/jquery.hammer.js"></script>
<script>
    $(function () {
        $(".yj-full-body").height($(window).height() - $(".yj-header").height());
        $("button").on("click",function(){
            //$(".yj-full-body").prepend("<div class=alert>活动已结束</div>");
            //$(".alert").delay(800).fadeOut(300);
        })
//        $(".yj-media-body").each(function () {
//            $(this).find("button").hammer().on("tap", function () {
////                if ($(".alert").is(":hidden"))
////                    $(".alert").remove()
////                $(this).parents(".yj-media-list").remove();
//                $(".yj-full-body").prepend("<div class=alert>已取消收藏</div>");
//                $(".alert").delay(800).fadeOut(300);
//            })
//        })
    })
</script>
</body>
</html>