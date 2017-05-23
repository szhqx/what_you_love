<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <meta name="apple-mobile-web-app-capable" content="no"/>
    <!-- 禁止数字识自动别为电话号码 -->
    <meta name="format-detection" content="telephone=no"/>
    <title>查看报表</title>
    <link rel="stylesheet" href="/static/wx/bx/css/yj-base.css"/>
    <link rel="stylesheet" href="/static/wx/bx/css/feedback.css"/>
    <script src="/static/wx/js/jquery.js"></script>
    <style>
        .yj-full-body input,select{
            width: 75%;
            padding: 0 3%;
            height: 36px;
            margin-right: 5%;
            margin-bottom: 3%;
            background: transparent;
            border: none;
            vertical-align: middle;
            margin-top: -2px;
            -webkit-appearance: none;
            color: #666;
            font-size: 14px;
            border: 1px solid #aaaaaa;
        }
        .yj-full-body img{
            width: 90%;
            padding: 0 3%;
            margin-right: 5%;
            margin-bottom: 3%;
            background: transparent;
            border: none;
            vertical-align: middle;
            margin-top: -2px;
            -webkit-appearance: none;
            color: #666;
            font-size: 14px;
            border: 1px solid #aaaaaa;
        }
        #calhead select{color:black;}
        .uc_form_txt{
            margin-left: 5%;
        }
        .uc_form_txt .imglist li{ margin-right: 10px; float: left;}
        .uc_form_txt .imglist img{height: 60px;}
        .uc_form_txt .imglist .addimg{width: 60px; border: 1px solid #eee; text-align: center; font-size: 12px; color: #aaa; line-height: 18px; cursor: pointer;}
        .uc_form_txt .imglist .addimg .fa{font-size: 18px; color: #ccc;}
        .uc_form_txt .imglist .upimg{display: block; position: relative; text-decoration: none; color: #ccc; padding: 11px 0; margin: 0;}
        .uc_form_txt .imglist .upimg input { position: absolute; top: 0; left: 0; width: 60px; height: 60px; opacity: 0; filter: alpha(opacity: 0);}
        .uc_form_txt span{display: inline-block;}
    </style>
</head>
<body>

<div class="yj-header">
    <a class="yj-icon yj-icon-left yj-left" href='javascript:;' onClick="javascript :history.go(-1);"></a>
    <h1 class="yj-title">查看报表</h1>
</div>
<div class="yj-full-body" style="overflow: scroll;position:relative;  -webkit-overflow-scrolling: touch;">
    <?php if(!empty($object)): ?><form>
        总收入：<input name="totalIncome" type="text" value="<?php echo ($object["totalIncome"]); ?>"  disabled="disabled" />
        总支出：<input name="totalExpenditure" type="text" value="<?php echo ($object["totalExpenditure"]); ?>" disabled="disabled" />
        总结余：<input name="aggregateBalance" type="text" value="<?php echo ($object["aggregateBalance"]); ?>" disabled="disabled" />
        <img src="/<?php echo ($object["picurl"]); ?>" />
    </form>
        <?php else: ?>
        <div>
            暂无数据
        </div><?php endif; ?>
</div>


</body>
</html>