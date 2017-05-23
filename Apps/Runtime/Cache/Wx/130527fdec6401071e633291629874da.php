<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <meta name="apple-mobile-web-app-capable" content="no"/>
    <!-- 禁止数字识自动别为电话号码 -->
    <meta name="format-detection" content="telephone=no"/>
    <title>活动参加</title>
    <link rel="stylesheet" href="/static/wx/bx/css/yj-base.css"/>
    <link rel="stylesheet" href="/static/wx/bx/css/feedback.css"/>
    <!--[if lt IE9]>
    <script src="/static/wx/js/html5.min.js"></script>
    <![endif]-->
    <style>
        .yj-full-body input{
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
            #div1{
                width: 95%;

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
    <h1 class="yj-title">活动参加</h1>
</div>
<div class="yj-full-body">
    <form  id="myform" name="myform" method="post" >
        <div id="div1">
            <input name="actId" type="hidden" value="<?php echo ($actId); ?>"/>
                <input name="username" type="text" placeholder="联系人" />
                <input name="mobile" type="tel"  placeholder="手机号码" />
                <!--<div class="uc_form_txt">-->
                    <!--<ul class="imglist clearfix" id="imglist">-->
                        <!--<li class="addimg">-->
                            <!--<a href="javascript:void(0);" class="upimg"><i class="fa fa-plus-circle"></i><br/>上传图片-->
                                <!--<input type="file" name="file_img" id="file_img" />-->
                            <!--</a>-->
                        <!--</li>-->
                        <!--<li id="headimg">-->
                            <!--<img src="/static/wx/bx/images/cartoon.png" />-->
                        <!--</li>-->
                    <!--</ul>-->
                <!--</div>-->
        </div>
        <button type="submit">提交</button>
        <!--onclick="upimg()"-->
    </form>
</div>
<script src="/static/wx/js/jquery.min.js"></script>

<script src="/static/wx/js/ajaxfileupload.js"></script>
<script>
    $(function(){
        //添加图片
        $("#file_img").change(function(){
            var objUrl = getObjectURL(this.files[0]);
            if (objUrl) {
                $(".imglist").append('<li><img src='+objUrl+'></li>');
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
    })
    $(function () {
        $(".yj-full-body").height($(window).height() - $(".yj-header").height());
    })
    function upimg(){
        var filearray;
        var objUrl = document.getElementById("file_img").value;
        var fi = 0;
        filearray = 'file_img';
        //console.log("上传成功");
        $.ajaxFileUpload({
            url: "/wx/activity/imgadd",
            secureuri: false,
            fileElementId: filearray,
            dataType: 'data',
            success:function (data) //服务器成功响应处理函数
            {
                myform.submit();
            },
            error:function(data){
              // alert(data.status);
            }
        });
    }
</script>
</body>
</html>