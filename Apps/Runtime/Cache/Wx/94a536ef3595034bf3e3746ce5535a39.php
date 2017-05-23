<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <meta name="apple-mobile-web-app-capable" content="no"/>
    <!-- 禁止数字识自动别为电话号码 -->
    <meta name="format-detection" content="telephone=no"/>
    <title>上传报表</title>
    <link rel="stylesheet" href="/static/wx/bx/css/yj-base.css"/>
    <link rel="stylesheet" href="/static/wx/bx/css/feedback.css"/>
    <script src="/static/wx/js/jquery.js"></script>
    <style>
        .yj-full-body input,select{
            width: 90%;
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
<script>
    var GV = {
        DIMAUB: "/",
        JS_ROOT: "Public/js/",
        TOKEN: ""
    };
</script>
<div class="yj-header">
    <a class="yj-icon yj-icon-left yj-left" href='javascript:;' onClick="javascript :history.go(-1);"></a>
    <h1 class="yj-title">上传报表</h1>
</div>
<div class="yj-full-body" style="overflow: scroll;position:relative;  -webkit-overflow-scrolling: touch;">
    <form action="/wx/Activity/upstatement" method="post"  enctype="multipart/form-data">
        <input name="actId" type="hidden" value="<?php echo ($actId); ?>"/>
        <input name="totalIncome" type="text" placeholder="总收入" />
        <input name="totalExpenditure" type="tel"  placeholder="总支出" />
        <input name="aggregateBalance" type="text"  placeholder="总结余" />
        <div class="uc_form_txt">
            <ul class="imglist clearfix" id="imglist">
                <li class="addimg">
                    <a href="javascript:void(0);" class="upimg"><i class="fa fa-plus-circle"></i><br/>报表数据
                        <input type="file" name="file_img" id="file_img" />
                    </a>
                </li>
                <li id="headimg">
                    <img src="/static/wx/bx/images/cartoon.png" />
                </li>
            </ul>
        </div>
        <button type="submit">提交</button>
    </form>
</div>

<script src="/static/wx/js/ajaxfileupload.js"></script>
<script>
    $(function(){
        //添加图片
        $("#file_img").change(function(){
            var objUrl = getObjectURL(this.files[0]);
            if (objUrl) {
                $("#imglist").append('<li><img src='+objUrl+'></li>');
            }
        }) ;
        //建立一个可存取到改file的url
        function getObjectURL(file){
            var url = null;
            if (window.createObjectURL!=undefined){ // basic
                url = window.createObjectURL(file);
            } else if (window.URL!=undefined){ // mozilla(firefox)
                url = window.URL.createObjectURL(file);
            } else if (window.webkitURL!=undefined){ // webkit or chrome
                url = window.webkitURL.createObjectURL(file);
            }
            $("#headimg").hide();
            return url ;
        }
    });
</script>
<script>
    $(function () {
        $(".yj-full-body").height($(window).height() - $(".yj-header").height());
    })
</script>

</body>
</html>