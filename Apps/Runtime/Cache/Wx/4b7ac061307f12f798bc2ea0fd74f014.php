<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title>商品分类</title>
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
	<link rel="stylesheet" type="text/css" href="/static/wx/css/public.css"/>
<link rel="stylesheet" type="text/css" href="/static/wx/css/catalog.css"/>
</head>
<body >
   
<div class="container">    
  <div class="category-box">
    <div class="category1" style="outline: none;overflow:scroll; -webkit-overflow-scrolling: touch;positon:fixed" tabindex="5000">
      <ul class="clearfix">
          <?php if(is_array($catList)): $i = 0; $__LIST__ = $catList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li <?php if(($i) == "1"): ?>class='cur'<?php endif; ?> >
                  <a href="javascript:void(0);" ><?php echo ($vo['catName']); ?></a>
              </li><?php endforeach; endif; else: echo "" ;endif; ?>
      </ul>
    </div>
  <div class="category2" style=" outline: none;overflow:scroll; -webkit-overflow-scrolling: touch; positon:fixed" tabindex="60000">
      <?php if(is_array($catList)): $m = 0; $__LIST__ = $catList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($m % 2 );++$m;?><dl <?php if($m != 1): ?>style='display:none;'<?php endif; ?> >
        <?php if(is_array($vo['catChildren'])): $i = 0; $__LIST__ = $vo['catChildren'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voo): $mod = ($i % 2 );++$i;?><dt><a href="#" ><?php echo ($voo['catName']); ?></a></dt>
                <dd class="clearfix">
                    <div class="fenimg">
                        <?php if(is_array($voo['catChildren'])): $i = 0; $__LIST__ = $voo['catChildren'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vooo): $mod = ($i % 2 );++$i;?><div class="fen_img">
                                <a href="/Wx/Goods/getGoodsList/c3Id/<?php echo ($vooo['catId']); ?>">

                                    <img src="/<?php echo ($vooo['catImg']); ?>" onerror="javascript:this.src='/Upload/mall/2016-04/570880247854a.gif'"/>
                                    <em><?php echo ($vooo['catName']); ?></em>
                                </a>
                            </div><?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                 </dd><?php endforeach; endif; else: echo "" ;endif; ?>
      </dl><?php endforeach; endif; else: echo "" ;endif; ?>
  </div>
  </div>
</div>
<script type="text/javascript" src="/static/wx/js/jquery.js"></script>
<script type="text/javascript" src="/static/wx/js/common.js"></script>
<script src="/static/wx/js/category.js"></script>
<script src="/static/wx/js/jquery.nicescroll.min.js?v=1"></script>
<script type="text/javascript" src="http://www.zhangxinxu.com/study/js/mini/jquery.scrollLoading-min.js"></script>
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
<script>
    $(function(){
        $(".category1").css("overflow","scroll");
        $(".category2").css("overflow","scroll");
    })
</script>