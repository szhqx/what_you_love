<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>
    <meta name="Generator" content="qianpok" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>支付</title>
    <meta name="Keywords" content="" />
    <meta name="Description" content="" />
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <script type="text/javascript" src="/static/alert/js/jquery.min.js"></script>
    <script src="/static/alert/js/sweetalert.min.js"></script>
    <script src="/static/alert/js/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="/static/alert/css/sweetalert.css">
</head>
<body style="background: rgb(235, 236, 237);">

<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
    wx.config({
        debug: false,
        appId: '<?php echo $signPackage["appId"];?>',
        timestamp: '<?php echo $signPackage["timestamp"];?>',
        nonceStr: '<?php echo $signPackage["nonceStr"];?>',
        signature: '<?php echo $signPackage["signature"];?>',
        jsApiList: ['chooseWXPay']
    });
  
    wx.ready(function () {
        var successurl = "<?php echo ($successurl); ?>";
        var backurl = "<?php echo ($backurl); ?>";
        // 在这里调用 API
        wx.chooseWXPay({
            appId: '<?php echo $jsApiParameters["appId"];?>',
            timestamp: '<?php echo $jsApiParameters["timeStamp"];?>', // 支付签名时间戳
            nonceStr: '<?php echo $jsApiParameters["nonceStr"];?>', // 支付签名随机串，不长于 32 位
            package: '<?php echo $jsApiParameters["package"];?>', // 统一支付接口返回的prepay_id参数值，提交格式如：prepay_id=***）
            signType: '<?php echo $jsApiParameters["signType"];?>', // 签名方式，默认为'SHA1'，使用新版支付需传入'MD5'
            paySign: '<?php echo $jsApiParameters["paySign"];?>', // 支付签名
            success: function (res) {
                <?php if($closemsg != ''): ?>window.location.href=successurl;
                <?php else: ?>
                     // 支付成功后的回调函数
                      swal("支付成功！","","success");
		              setTimeout(function(){window.location.href=successurl}, 3000);<?php endif; ?>
            },
            cancel: function (res) {
                swal("您已取消支付！");
	         	setTimeout(function(){window.location.href=backurl}, 1000);
            }
        });
    });
</script>
</body>
</html>