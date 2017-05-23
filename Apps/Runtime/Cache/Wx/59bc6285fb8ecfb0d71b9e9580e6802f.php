<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <meta name="apple-mobile-web-app-capable" content="no"/>
    <!-- 禁止数字识自动别为电话号码 -->
    <meta name="format-detection" content="telephone=no"/>
    <title>建议反馈</title>
    <link rel="stylesheet" href="/static/wx/bx/css/yj-base.css"/>
    <link rel="stylesheet" href="/static/wx/bx/css/feedback.css"/>
</head>
<body>
<div class="yj-header">
    <a class="yj-icon yj-icon-left yj-left" href='javascript:;' onClick="javascript :history.go(-1);"></a>
    <h1 class="yj-title">建议反馈</h1>
</div>
<div class="yj-full-body">
    <form action="/wx/users/feedback" method="post">
        <select name="suggestType" style="width: 90%;
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
    font-size: 14px;">
            <option value="0">平台投诉意见</option>
            <option value="1">产品投诉意见</option>
            <option value="2">商铺投诉意见</option>
        </select>
        <textarea name="suggest" placeholder="在这里写上您的意见或投诉"></textarea>
        <button type="submit">提交</button>
    </form>
</div>
<script src="/static/wx/js/jquery.js"></script>
<script>
    $(function () {
        $(".yj-full-body").height($(window).height() - $(".yj-header").height());
    })
</script>
</body>
</html>