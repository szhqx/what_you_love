<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>商品评价</title>
        <link rel="stylesheet" href="/Apps/Home/View/default/css/common.css" />
        <link rel="stylesheet" href="/Apps/Home/View/default/css/user.css">
		<script src="/Public/js/jquery.min.js"></script>
	    <script type="text/javascript">
	    var ThinkPHP = window.Think = {
	            "ROOT"   : "",
	            "APP"    : "",
	            "PUBLIC" : "/Public",
	            "DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>",
	            "MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
	            "VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
	    }
	    </script>
	    <script src="/Public/js/think.js"></script>
		<style>
			html{height: 100%;}
			body{height: 100%; overflow: hidden;}
		</style>
    </head>
    
    <body style="background-color:#f5f5f5;">
        <div style="text-align:center;  overflow:scroll; position:relative; z-index:9999; height: 100%; -webkit-overflow-scrolling: touch;" >
        	<div class="wst-appraise-box">
				<div>
					<div class="appraise-title"><span style="color:red;">商品评价</span></div>
				</div>
				<div class='main'>
					<?php if(is_array($orderInfo['goodsList'])): $key1 = 0; $__LIST__ = $orderInfo['goodsList'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods): $mod = ($key1 % 2 );++$key1;?><div class="selgoods">
						<div>
							<a href="<?php echo U('Wx/Goods/getGoodsDetails',array('goodsId'=>$goods['goodsId']));?>" target="_blank">
							<img src="/<?php echo ($goods['goodsThums']); ?>" width="60" height="60" class='goods-img'/>
							</a>
							<?php echo ($goods["goodsName"]); ?>&nbsp;【<?php echo ($goods["goodsAttrName"]); ?>】
							<span id="<?php echo ($goods['goodsId']); ?>_<?php echo ($goods['goodsAttrId']); ?>_status" class="goods-status goods-txt">
								状态：
								<?php if($goods["gaId"] == ""): ?>未评价
									<?php else: ?>
									已评价<?php endif; ?>
							</span>
						</div>
						<!--<div class="goods-buy-time goods-txt"><?php echo ($orderInfo['order']['createTime']); ?></div>-->
						<div style="clear: both;"></div>
					</div>
					<?php if($goods["gaId"] == ""): ?><div id="<?php echo ($goods['goodsId']); ?>_<?php echo ($goods['goodsAttrId']); ?>_appraise" class="appraise-box">
						<div class="main-box">
							<div class="item">
								<div class='title'>商品评分：</div>								
								<div class='content'>
									<div class="<?php echo ($goods['goodsId']); ?>_<?php echo ($goods['goodsAttrId']); ?>_goodsScore" style='float:left'></div>
									<div id="<?php echo ($goods['goodsId']); ?>_<?php echo ($goods['goodsAttrId']); ?>_goodsScore_hint" style='float:left'></div>
								</div>
								<div style="clear: both;"></div>
							</div>
							<div class="item">
								<div class='title'>时效得分：</div>								
								<div class='content'>									
									<div class="<?php echo ($goods['goodsId']); ?>_<?php echo ($goods['goodsAttrId']); ?>_timeScore" style='float:left'></div>
									<div id="<?php echo ($goods['goodsId']); ?>_<?php echo ($goods['goodsAttrId']); ?>_timeScore_hint" style='float:left'></div>
								</div>
								<div style="clear: both;"></div>
							</div>
							<div class="item">
								<div class='title'>服务得分：</div>								
								<div class='content'>
								    <div class="<?php echo ($goods['goodsId']); ?>_<?php echo ($goods['goodsAttrId']); ?>_serviceScore" style='float:left'></div>
								    <div id="<?php echo ($goods['goodsId']); ?>_<?php echo ($goods['goodsAttrId']); ?>_serviceScore_hint" style='float:left'></div>									
								</div>
								<div style="clear: both;"></div>
							</div>
							<div class="item">
								<div class='title'>点评内容：</div>					
								<div class='content'>									
									<textarea rows="5" cols="70" style="width:200px;" name="<?php echo ($goods['goodsId']); ?>_<?php echo ($goods['goodsAttrId']); ?>_content" id="<?php echo ($goods['goodsId']); ?>_<?php echo ($goods['goodsAttrId']); ?>_content" maxlength="50"></textarea>
								</div>
								<div style="clear: both;"></div>
							</div>
							<div id="checkout" class="btn-box" style="float: left; padding-left: 15%;">
								<a class="btn-submit" href="javascript:;" onclick="addGoodsAppraises(<?php echo ($orderInfo['order']['shopId']); ?>,<?php echo ($goods['goodsId']); ?>,'<?php echo ($goods['goodsAttrId']); ?>',<?php echo ($orderInfo['order']['orderId']); ?>)">
									<button class='wst-btn-query'>评价</button>
								</a>
								<div style="clear: both;"></div>
							</div>
							<div style="clear: both;"></div>
						</div>
					</div><?php endif; endforeach; endif; else: echo "" ;endif; ?>					
					
				</div>
				
			</div>
        </div>
    </body>
    <script src="/Public/js/common.js"></script>
	     <script src="/Public/plugins/layer/layer.min.js"></script>
	     <script src="/Apps/Home/View/default/js/usercom.js"></script>
	     <script type="text/javascript" src="/Public/plugins/raty/jquery.raty.min.js"></script>
    	 <script type="text/javascript">
    	 	var shopId = "<?php echo ($orderInfo['shopId']); ?>";
	   		//添加商品评价
			
	   		$(function(){
	   			var options = {
	   					hints         : ['很不满意', '不满意', '一般', '满意', '非常满意'],
	   					width:140,
	   					targetKeep: true,
	   					starHalf:'/Public/plugins/raty/img/star-half-big.png',
	   					starOff:'/Public/plugins/raty/img/star-off-big.png',
	   					starOn:'/Public/plugins/raty/img/star-on-big.png',
	   					cancelOff: '/Public/plugins/raty/img/cancel-off-big.png',
	   				    cancelOn: '/Public/plugins/raty/img/cancel-on-big.png'
	   		    }
	   			<?php if(is_array($orderInfo['goodsList'])): $key1 = 0; $__LIST__ = $orderInfo['goodsList'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods): $mod = ($key1 % 2 );++$key1;?>options.target='#<?php echo ($goods['goodsId']); ?>_<?php echo ($goods['goodsAttrId']); ?>_goodsScore_hint';
	   			$('.<?php echo ($goods['goodsId']); ?>_<?php echo ($goods['goodsAttrId']); ?>_goodsScore').raty(options);
	   			options.target='#<?php echo ($goods['goodsId']); ?>_<?php echo ($goods['goodsAttrId']); ?>_timeScore_hint';
	   			$('.<?php echo ($goods['goodsId']); ?>_<?php echo ($goods['goodsAttrId']); ?>_timeScore').raty(options);
	   			options.target='#<?php echo ($goods['goodsId']); ?>_<?php echo ($goods['goodsAttrId']); ?>_serviceScore_hint';
	   			$('.<?php echo ($goods['goodsId']); ?>_<?php echo ($goods['goodsAttrId']); ?>_serviceScore').raty(options);<?php endforeach; endif; else: echo "" ;endif; ?>
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
</html>