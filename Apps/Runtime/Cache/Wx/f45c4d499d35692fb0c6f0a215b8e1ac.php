<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>
<meta name="Generator" content="qianpok" />
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title>用户中心_添加地址</title>
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<link rel="stylesheet" type="text/css" href="/static/wx/css/public.css">
<link rel="stylesheet" type="text/css" href="/static/wx/css/user.css">
<script type="text/javascript" src="/static/wx/js/jquery.js"></script>
<script type="text/javascript" src="/static/wx/js/common.js"></script>
    <script type="text/javascript" src="/static/wx/js/mobile.js" ></script>
    <script type="text/javascript" src="/static/wx/js/address.js"></script>
    <script src="/Public/plugins/formValidator/formValidator-4.1.3.js"></script>
</head>
<body style="background: rgb(235, 236, 237);">
<script>
    $(function () {
        <?php if($object['addressId'] != 0): ?>getAreaList('areaId2','<?php echo ($object['areaId1']); ?>',0,'<?php echo ($object['areaId2']); ?>');
                 getAreaList("areaId3",'<?php echo ($object["areaId2"]); ?>',1,'<?php echo ($object["areaId3"]); ?>');<?php endif; ?>
    });

</script>
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
<div id="wrapper">
  <div id="viewport">

<div class="addressmone">
    <input type='hidden' id='consigneeId' value='<?php echo ($object['addressId']); ?>'/>
    <form name="myform" method="post" id="myform" autocomplete="off" onclick="">
	<ul>
       <li>
    	<span>收货人</span>  <input type="text" id='userName' name='userName'  value='<?php echo ($object['userName']); ?>'  placeholder="收货人"/>
		</li>
       <li>
    		<select id='areaId1' onchange='javascript:getAreaList("areaId2",this.value,0)' class="province_select" >
                     <option value="0">请选择</option>
                        <?php if(is_array($areaList)): $i = 0; $__LIST__ = $areaList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value='<?php echo ($vo['areaId']); ?>' <?php if($object['areaId1'] == $vo['areaId'] ): ?>selected<?php endif; ?>><?php echo ($vo['areaName']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
           <select id='areaId2' onchange='javascript:getAreaList("areaId3",this.value,1);'>
               <option value=''>请选择</option>
           </select>
           <select id='areaId3'>
               <option value=''>请选择</option>
           </select>
        	</li>
           <li>
    		 <span>详细地址</span> <input type="text"  id='address' name='address'  value='<?php echo ($object['address']); ?>' placeholder="详细地址"/>
	        </li>
           <li>
		<span>电话</span> <input type="text" id='userTel' name='userTel' value="<?php echo ($object['userTel']); ?>"  placeholder="电话" onkeyup="javascript:WST.isChinese(this,1)"/>
	        </li>
            <li>
		 <span>手机</span> <input type="text"  maxlength="11" id='userPhone' name='userPhone' value="<?php echo ($object['userPhone']); ?>" onkeyup="javascript:WST.isChinese(this,1)" onkeypress="return WST.isNumberdoteKey(event)"  placeholder="手机"/>
	        </li>
        <li>
            <span>设默认地址</span>
            <input type='radio' id='isDefault1' style="margin-top: 10px;" name='isDefault' value='1' <?php if($object['isDefault'] == 1): ?>checked<?php endif; ?>/>是
            <input type='radio' id='isDefault0'  style="margin-top: 10px;" name='isDefault' value='0' <?php if($object['isDefault'] == 0): ?>checked<?php endif; ?>/>否
        </li>
    	</ul>
            <div style=" height:50px"></div>
                  <div class="dotm_btn" style="padding-left: 30%;">
				<input type="button" value="保存" onclick="saveAddress();"  class="dotm_btn1 wst-btn-query"/>
                </div>


    </form>
</div>
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