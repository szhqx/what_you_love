<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>产品详情</title>
    <meta name="Keywords" content="" />
    <meta name="Description" content="" />
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <link href="/static/wx/css/royalslider.css" rel="stylesheet">
    <link href="/static/wx/css/rs-minimal-white.css" rel="stylesheet">
    <link rel="stylesheet" href="/static/wx/css/mui.min.css">
    <link rel="stylesheet" type="text/css" href="/static/wx/css/public.css"/>
    <link rel="stylesheet" type="text/css" href="/static/wx/css/activity.css?d=20160512"/>
</head>
<style>
    .wst-goods-attrs-on {
        border: 2px solid #fb4f1c;
        color: #fb4f1c;}
    .clear{clear:both;}
    html,body{overflow-x:hidden;}
    .cpmessage ul li a {
        font-size: 13px;
    }
    .cpname .wst-goods-attrs {
        border: 1px solid #fff;
    }
    .cpname .wst-goods-attrs-on {
        border: 1px solid #fb4f1c;
        padding: 0px 10px;
    }
    .liji, .jiaru {
        font-size: 18px;
    }
    .cpcase ul {
        border-top: 0px solid #efefef;
        padding-left: 20px;
    }
    .cpcase{
        margin-left: 0px;
    }
    .header {
        width: 100%;
        height: 45px;
        background: rgba(239, 43, 45, 0);
        top: 0;
        z-index: 9999;
        border: 0;
        border-bottom: 1px solid #c2c2c2; }
    .cpmessage ul li{
        display: inline-block;
        width: 22.333%;
        float: left;
        text-align: center;
        background-color: transparent;
        position: relative;
        left: 18.5%;
        line-height:40px;
    }
    .alert{
        width: 100px;
        height: 100px;
        background: rgba(0,0,0,.8);
        color: #ffffff;
        position: fixed;
        top: 50%;
        left: 50%;
        /*margin-top: -50px;*/
        /*margin-left: -50px;*/
        line-height: 100px;
        text-align: center;
        -webkit-border-radius: 10px;
        -webkit-transform:translate(-50%,-50%);
        -moz-border-radius: 10px;
        border-radius: 10px;
        font-size: 14px;
        z-index: 999999;
    }

</style>
<body style="background:#f4f2f3; overflow-x:hidden;overflow-y:auto">

<!--<?php $title_name='商品详情' ?>-->
<!--<header>
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
<script src="/Public/plugins/layer/layer.min.js"></script>-->
<!--<script type="text/javascript" src="/static/wx/js/mobile.js" ></script>

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
</div>-->
<div style="height: 45px"></div>
<header  style="position: fixed;top:0px;width:100%;z-index: 99;    background: #F4F2F3;">
    <a class="mui-action-back mui-icon mui-icon-left-nav"  style="position: absolute;top: 10px;color: #000;left: 2%"></a>
    <div class="tab_nav">
        <div class="header">
            <div class="cpmessage" style="margin-top: 0px;">
                <ul>
                    <li class="cur"><a href="javascript:void(0);">商品</a></li>
                    <li class=""><a  href="javascript:void(0);">详情</a></li>
                    <li class=""><a  href="javascript:void(0);">评价</a></li>
                </ul>
            </div>
        </div>
    </div>

</header>
<div class="categoodsimg">
<div id="spxq">

    <input id="shopId" type="hidden" value="<?php echo ($goodsDetails['shopId']); ?>"/>
    <input id="goodsId" type="hidden" value="<?php echo ($goodsDetails['goodsId']); ?>"/>
    <div class="banner">
        <!--焦点图-->
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="/<?php echo ($goodsDetails['goodsImg']); ?>" /></div>
                <?php if(is_array($goodsImgs)): $i = 0; $__LIST__ = $goodsImgs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="swiper-slide"><img src="/<?php echo ($vo['goodsImg']); ?>"  /></div><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <div class="cpname" style="overflow:hidden">
        <span style="white-space:normal;border-buttom: 1px solid #efefef;"><?php echo ($goodsDetails["goodsName"]); ?><a href="javascript:void(0);" onclick="favoriteGoods(<?php echo ($goodsDetails['goodsId']); ?>);"><var id="f0_txt" style="font-size: 14px;float: right;padding-right: 18px;color: red;" f="<?php echo ($favoriteGoodsId); ?>">[<?php if($favoriteGoodsId != '0'): ?>已收藏<?php else: ?>收藏<?php endif; ?>]</var></a></span>
        <strong>￥<var id='shopGoodsPrice_<?php echo ($goodsDetails["goodsId"]); ?>' dataId='<?php echo ($goodsDetails["goodsAttrId"]); ?>'><?php if($goodsDetails["attrPrice"] != ''): echo ($goodsDetails["attrPrice"]); else: echo ($goodsDetails["shopPrice"]); endif; ?></var>
        </strong>
        <div class="cpcase">
            <ul>
                <li>库存：<var id='goodsStock'><?php echo ($goodsDetails['goodsStock']); ?></var><?php echo ($goodsDetails['goodsUnit']); ?></li>
                <li>运费：<var><?php echo ($goodsDetails["deliveryStartMoney"]); ?>元起，配送费<?php echo ($goodsDetails["deliveryMoney"]); ?>元，<?php echo ($goodsDetails["deliveryFreeMoney"]); ?>元起免配送费</var></li>
            </ul>
        </div>
        <input id="test" hidden value="<?php if(( count($goodsAttrs['priceAttrs']) > 0)): ?>1<?php endif; ?>">
        <input id="testattr" hidden value="" >
        <?php if(( count($goodsAttrs['priceAttrs']) > 0) or ( count($goodsAttrs['attrs']) > 0) ): ?><span style="font-size: 14px;">商品属性</span><?php endif; ?>
        <?php if( count($goodsAttrs['priceAttrs']) > 0): ?><div class="cpcase">
                <ul style=" border-top: 1px solid #efefef;">
                    <li><?php echo ($goodsAttrs["priceAttrName"]); ?>：
                        <?php if(is_array($goodsAttrs['priceAttrs'])): $i = 0; $__LIST__ = $goodsAttrs['priceAttrs'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$avo): $mod = ($i % 2 );++$i;?><span class='wst-goods-attrs' dataId='<?php echo ($avo["id"]); ?>' onclick='javascript:checkStock(this)'><?php echo ($avo['attrVal']); ?></span>
                            <!--<?php if( $goodsDetails['goodsAttrId'] == $avo['id']): ?>wst-goods-attrs-on<?php endif; ?> 默认选择--><?php endforeach; endif; else: echo "" ;endif; ?>
                    </li>
                </ul>
            </div><?php endif; ?>
        <?php if( count($goodsAttrs['attrs']) > 0): ?><div class="cpcase" id="attrs">
                <ul>
                    <?php if(is_array($goodsAttrs['attrs'])): $i = 0; $__LIST__ = $goodsAttrs['attrs'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voa): $mod = ($i % 2 );++$i;?><li><es ><?php echo ($voa["attrName"]); ?></es>：
                            <?php if(is_array($voa['attrContent'])): $m = 0; $__LIST__ = $voa['attrContent'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$bvo): $mod = ($m % 2 );++$m;?><span class='wst-goods-attrs ' dataid='<?php echo ($voa[id]); ?>' datakey='<?php echo ($m-1); ?>' onclick='javascript:checkStocks(this)'><?php echo ($bvo); ?></span>
                                <!--<?php if($bvo == $voa['attrContent'][0]): ?>wst-goods-attrs-on<?php endif; ?> 默认选择--><?php endforeach; endif; else: echo "" ;endif; ?>
                            <input id="attrs<?php echo ($voa[id]); ?>" type="hidden" data-attrid='<?php echo ($voa[id]); ?>' value=""/>
                            <!--<?php echo ($voa[id]); ?>_<?php echo ($m-$m); ?>-->
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>

                </ul>
            </div><?php endif; ?>

        <div class="cartnum clearfix" style="top: 80px;    right: 18px;">
            <span class="cicon minus">-</span>
            <span class="cnum"><input type="text" value="1" max="<?php echo ($goodsDetails["goodsStock"]); ?>" min="1" id="buy-num" readonly/></span>
            <span class="cicon plus">+</span>
        </div>
    </div>

    <div class="store">
        <ul>
            <li><a href="<?php echo U('wx/shops/index',array('shopId'=>$shopId));?>">
                <div class="store-lef"><i><img src="/static/wx/images/dianpu.png" class="dianpu"></i>商家名称：<?php echo ($goodsDetails["shopName"]); ?></div>
            </a>
            </li>
        </ul>
    </div>
</div>
<div  id="spcs" style="display: none;">
    <div class="spxq" style="overflow:hidden;  width: 100%;    font-size: 14px;">
        <?php echo (stripslashes($goodsDetails["goodsDesc"])); ?>
    </div>
    <div class="spcs"  style="padding: 10px;  width: 100%;    font-size: 14px;">
        <?php echo (stripslashes($goodsDetails["goodsParameter"])); ?>
    </div>
</div>
<div class="sppj" id="sppj" style="display: none; font-size: 14px;">
    <table style="font-size: 16px;
    color: #333333;
    font-family: 黑体;
    background-color: #FFFFFF;width: 100%;">
        <?php if(!empty($appraise)): if(is_array($appraise)): $i = 0; $__LIST__ = $appraise;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr style="">
                    <td style="width: 40%;">[<?php if($vo["nickName"] !=''): echo ($vo["nickName"]); else: if($vo["userName"] ==''): ?>匿名<?php else: echo ($vo["userName"]); endif; endif; ?>]说：</td>
                    <td><?php echo ($vo["content"]); ?></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            <?php else: ?>
            <tr>
                暂无评论
            </tr><?php endif; ?>
    </table>
</div>
</div>
<script type="text/javascript" src="/static/wx/js/jquery.js"></script>

<script type="text/javascript" src="/static/wx/js/common.js"></script>
<script type="text/javascript" src="/static/wx/js/detail.js?v=111"></script>
<script src="/Apps/Wx/View/goods.js?v=222"></script>
<script src="/Public/plugins/layer/layer.min.js"></script>
<footer>
    <div class="footer" style="display: none;">
        <div class="links"  id="ECS_MEMBERZONE">
            <?php if($_SESSION['user_info']['id'] == ''): ?><a href="<?php echo U('user/login');?>"><span>登录</span></a><a href="<?php echo U('user/register');?>"><span>注册</span></a><?php else: ?>
                <a href="<?php echo U('user/index');?>">您好，<?php if($_SESSION['user_info']['username'] == ''): echo ($_SESSION['user_info']['nickname']); endif; echo ($_SESSION['user_info']['username']); ?>，欢迎您回来</a><?php endif; ?>
            <a href="javascript:window.scrollTo(0,0);"><span>回顶部</span></a>
        </div>

        <p class="mf_o4">&copy; 2005-2016 爱乐享 版权所有，并保留所有权利。</p>
    </div>

    <div style="height:50px; line-height:50px; clear:both;"></div>


    <div class="v_nav">
        <div class="vf_nav">
            <ul>
                <li> <a href="<?php echo U('index/index');?>">
                    <i class="vf_1"></i>
                    <span>买啥</span></a></li>
                <li><a href="<?php echo U('activity/index');?>">
                    <i class="vf_3"></i>
                    <span>玩啥</span></a></li>
                <li><a href="<?php echo U('users/index');?>">
                    <i class="vf_5"></i>
                    <span>我的</span></a></li>
                <li><a href="<?php echo U('cart/getcartinfo');?>">
                    <i class="vf_4 wst-nvg-cart-cnt" style="line-height: 14px;text-align: right;color: #ffffff;" >0</i>
                    <span>购物车</span></a></li>
            </ul>
        </div>
    </div>
</footer>
<script src="/Public/plugins/layer/layer.min.js"></script>
<div style="height:40px; line-height:50px; clear:both;"></div>
<div style="height:50px; line-height:50px; clear:both;"></div>
<div id="caidan">
    <div class="caidan liji" onclick="go_cart('<?php echo ($goodsDetails["goodsId"]); ?>')">  立即购买</div>
    <div class="caidan jiaru " onclick="add_cart('<?php echo ($goodsDetails["goodsId"]); ?>')" >加入购物车</div>
</div>
<script src="/static/wx/js/mui.min.js"></script>
<script src="/static/wx/js/jquery-1.8.3.min.js"></script>
<script src="/static/wx/js/jquery.royalslider.min.js"></script>
<!--焦点图-->
<link rel="stylesheet" href="/static/wx/css/swiper.min.css" type="text/css">
<script src="/static/wx/js/swiper.min.js"></script>
<script type="text/javascript" src="http://www.zhangxinxu.com/study/js/mini/jquery.scrollLoading-min.js"></script>
<script>
    //焦点图
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        spaceBetween: 0,
        autoplay : 8000
    });
</script>
<script type="text/javascript">
    var button_compare = "";
    var exist = "您已经选择了%s";
    var count_limit = "最多只能选择4个商品进行对比";
    var goods_type_different = "\"%s\"和已选择商品类型不同无法进行对比";
    var compare_no_goods = "您没有选定任何需要比较的商品或者比较的商品数少于 2 个。";
    var btn_buy = "购买";
    var is_cancel = "取消";
    var select_spe = "请选择商品属性";
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".lazyload").scrollLoading({ container: $(".categoodsimg") });
        $(".cpmessage li").click(function(){
            $(this).addClass("cur").siblings().removeClass("cur");
            if($(this).children("a").html() =='商品'){
                $("#spxq").show();
                $("#sppj").hide();
                $("#spcs").hide();
            }
            if($(this).children("a").html() =='评价'){
                $("#sppj").show();
                $("#spxq").hide();
                $("#spcs").hide();
            }
            if($(this).children("a").html() =='详情'){
                $("#spcs").show();
                $("#spxq").hide();
                $("#sppj").hide();
            }
        });
    });
    //spxq 商品 spcs 商品详情及参数 sppj 评价
    $(function(){
        $(window).scroll(function(){
            if($(document).scrollTop() > $(document).height()-$(window).height()-$('.footer').height()) { //页面拖到底部了
//                if($(".cur").children("a").html() =='商品'){
//                    $("#spcs").show();
//                    $("#sppj").hide();
//                    $("#spxq").hide();
//                    $('.cpmessage').children('ul:first').children('li:eq('+1+')').addClass("cur").siblings().removeClass("cur");
//                    return false;
//                }
//                if($(".cur").children("a").html() =='详情'){
//                    $("#sppj").show();
//                    $("#spcs").hide();
//                    $("#spxq").hide();
//                    $('.cpmessage').children('ul:first').children('li:eq('+2+')').addClass("cur").siblings().removeClass("cur");
//                    return false;
//                }
//                if($(".cur").children("a").html() =='评价'){
//                    $('.cpmessage').children('ul:first').children('li:eq('+0+')').addClass("cur").siblings().removeClass("cur");
//                    $("#spxq").show();
//                    $("#sppj").hide();
//                    $("#spcs").hide();
//                    return false;
//                }
                //$('.cpmessage').children('ul:first').children('li:eq('+i+')').show().siblings('li').hide();
            }
        })
    })
</script>
<script src="/Public/js/common.js"></script>
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