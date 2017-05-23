<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="shortcut icon" href="favicon.ico"/>
  		<title>卖家中心 - <?php echo ($CONF['mallTitle']); ?></title>
  		<meta name="keywords" content="<?php echo ($CONF['mallKeywords']); ?>" />
      	<meta name="description" content="<?php echo ($CONF['mallDesc']); ?>,卖家中心" />
  		<meta http-equiv="Expires" content="0">
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="Cache-control" content="no-cache">
		<meta http-equiv="Cache" content="no-cache">
  		<link rel="stylesheet" href="/Apps/Home/View/default/css/common.css" />
    	<link rel="stylesheet" href="/Apps/Home/View/default/css/shop.css">
    	<link rel="stylesheet" type="text/css" href="/Public/plugins/webuploader/webuploader.css" />
		<?php echo WSTLoginTarget(1);?>
    </head>
    <body>
        <div class="wst-wrap" >
          <div class='wst-header' >
			  <div >
			<script src="/Public/js/jquery.min.js"></script>
<script src="/Public/plugins/lazyload/jquery.lazyload.min.js?v=1.9.1"></script>
<script type="text/javascript">
var WST = ThinkPHP = window.Think = {
        "ROOT"   : "",
        "APP"    : "",
        "PUBLIC" : "/Public",
        "DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>",
        "MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
        "VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"],
        "DOMAIN" : "<?php echo WSTDomain();?>",
        "CITY_ID" : "<?php echo ($currArea['areaId']); ?>",
        "CITY_NAME" : "<?php echo ($currArea['areaName']); ?>",
        "DEFAULT_IMG": "<?php echo WSTDomain();?>/<?php echo ($CONF['goodsImg']); ?>",
        "MALL_NAME" : "<?php echo ($CONF['mallName']); ?>",
        "SMS_VERFY"  : "<?php echo ($CONF['smsVerfy']); ?>",
        "PHONE_VERFY"  : "<?php echo ($CONF['phoneVerfy']); ?>",
        "IS_LOGIN" :"<?php echo ($WST_IS_LOGIN); ?>"
}
    $(function() {
    	$('.lazyImg').lazyload({ effect: "fadeIn",failurelimit : 10,threshold: 200,placeholder:WST.DEFAULT_IMG});
    });
</script>
<script src="/Public/js/think.js"></script>
<div id="wst-shortcut">
	<div class="w">
		<ul class="fl lh" hidden>
			<li class="fore1 ld"><b></b><a href="javascript:addToFavorite()"
				rel="nofollow">收藏<?php echo ($CONF['mallName']); ?></a></li><s></s>
			<li class="fore3 ld menu" id="app-jd" data-widget="dropdown">
				<span class="outline"></span> <span class="blank"></span> 
				<a href="#" target="_blank"><img src="/Apps/Home/View/default/images/icon_top_02.png"/>&nbsp;<?php echo ($CONF['mallName']); ?> 手机版</a>
			</li>
			<li class="fore4" id="biz-service" data-widget="dropdown" style='padding:0;'>&nbsp;<s></s>&nbsp;&nbsp;&nbsp;
				所在城市
				【<span class='wst-city'>&nbsp;<?php echo ($currArea["areaName"]); ?>&nbsp;</span>】
				<img src="/Apps/Home/View/default/images/icon_top_03.png"/>	
				&nbsp;&nbsp;<a href="javascript:;" onclick="toChangeCity();">切换城市</a><i class="triangle"></i>
			</li>
		</ul>
	
		<ul class="fr lh" style='float:right;'>
			<li class="fore1" id="loginbar"><a href="<?php echo U('Home/Orders/queryByPage');?>"><span style='color:blue'><?php echo ($WST_USER['loginName']); ?></span></a> 欢迎您来到 <a href='<?php echo WSTDomain();?>'><?php echo ($CONF['mallName']); ?></a>！<s></s>&nbsp;
			<span  >
				<?php if(!$WST_USER['userId']): ?><a hidden href="<?php echo U('Home/Users/login');?>">[登录]</a>
				<a hidden href="<?php echo U('Home/Users/regist');?>"	class="link-regist">[免费注册]</a><?php endif; ?>
				<?php if($WST_USER['userId'] > 0): ?><a href="javascript:logout();">[退出]</a><?php endif; ?>
			</span>
			</li>
			<li class="fore2 ld"><s></s>
			<?php if(session('WST_USER.userId')>0){ ?>
				<?php if(session('WST_USER.userType')==0){ ?>
				    <a href="<?php echo U('Home/Shops/toOpenShopByUser');?>" rel="nofollow">我要开店</a>
				<?php }else{ ?>
				    <?php if(session('WST_USER.loginTarget')==0){ ?>
				        <a href="<?php echo U('Home/Shops/index');?>" rel="nofollow">卖家中心</a>
				    <?php }else{ ?>
				        <a href="<?php echo U('Home/Users/index');?>" rel="nofollow">卖家中心</a>
				    <?php } ?>
				<?php } ?>
			<?php }else{ ?>
			    <a href="<?php echo U('Home/Shops/toOpenShop');?>" rel="nofollow">我要开店</a>
			<?php } ?>
			</li>
		</ul>
		<span class="clr"></span>
	</div>
</div>

			  </div><!--
			<div class='wst-user-top'>
			<div class="wst-user-top-main">
					<div class='wst-user-top-logo' >
						<a href="<?php echo WSTDomain();?>"  title='商城首页'>
						<img src="<?php echo WSTDomain();?>/<?php echo ($CONF['mallLogo']); ?>" height="132" width='240'/>	
						</a>
					</div>
					<div class='wst-user-top-search' hidden>
						<div class="search-box">
							<input id="wst-search-type" type="hidden" value="1"/>
							<input id="keyword" class="wst-search-ipt" me="q" tabindex="9" placeholder="搜索 商品" autocomplete="off" >
							<div id="btnsch" class="wst-search-btn">搜&nbsp;索</div>
						</div>
					</div>
					
				</div>
			</div>-->
			<div class="wst-shop-nav">
				<div class="wst-nav-box">
					<li class="liselect"><a href="<?php echo U('Home/Shops/index');?>" style='color:#FFFFFF;'>我是卖家</a></li>
					<div class="wst-clear"></div>
				</div>
			</div>
			<div class="wst-clear;"></div>
		</div>
          <div class='wst-nav'></div>
          <div class='wst-main'>
            <div class='wst-menu'>
            	<span class='wst-menu-title'><span></span>交易管理</span>
            
              	<a href='<?php echo U("Home/Orders/toShopOrdersList");?>'><li id='li_toShopOrdersList' <?php if($umark == "toShopOrdersList"): ?>class='liselect'<?php endif; ?>>订单管理<span style="display:none;" class="wst-msg-tips-box"></span></li></a>
            	<a href="<?php echo U('Home/OrderComplains/queryShopComplainByPage');?>"><li <?php if($umark == "queryShopComplainByPage"): ?>class='selected'<?php endif; ?>>投诉订单</li></a>
            	<a href="<?php echo U('Home/OrderSettlements/toSettlementIndex');?>"><li <?php if($umark == "toSettlementIndex"): ?>class='selected'<?php endif; ?>>订单结算</li></a>
            	<span class='wst-menu-title' style='border-top:0px;'><span></span>商品管理</span>
            
               	<a href="<?php echo U('Home/ShopsCats/index');?>"><li <?php if($umark == "index"): ?>class='liselect'<?php endif; ?>>本店分类</li></a>
              	<a href="<?php echo U('Home/Goods/queryOnSaleByPage');?>"><li <?php if($umark == "queryOnSaleByPage"): ?>class='liselect'<?php endif; ?>>出售中的商品</li></a>
               	<a href="<?php echo U('Home/Goods/queryPenddingByPage');?>"><li <?php if($umark == "queryPenddingByPage"): ?>class='liselect'<?php endif; ?>>待审核商品</li></a>
               	<a href="<?php echo U('Home/Goods/queryUnSaleByPage');?>"><li <?php if($umark == "queryUnSaleByPage"): ?>class='liselect'<?php endif; ?>>仓库中的商品</li></a>
               	<a href="<?php echo U('Home/Goods/toEdit/',array('umark'=>'toEditGoods'));?>"><li <?php if($umark == "toEditGoods"): ?>class='liselect'<?php endif; ?>>新增商品</li></a>
               	<a href="<?php echo U('Home/GoodsAppraises/index');?>"><li <?php if($umark == "GoodsAppraises"): ?>class='liselect'<?php endif; ?>>评价管理</li></a>

               	<a href="<?php echo U('Home/AttributeCats/index');?>"><li <?php if($umark == "AttributeCats"): ?>class='liselect'<?php endif; ?>>商品规格分类</li></a>
               	<a href="<?php echo U('Home/Imports/index');?>" hidden><li <?php if($umark == "Imports"): ?>class='liselect'<?php endif; ?>>数据导入</li></a>
			
              	<span class='wst-menu-title'><span></span>网店设置</span>
            	<a href="<?php echo U('Home/Shops/toEdit/');?>"><li <?php if($umark == "toEdit"): ?>class='liselect'<?php endif; ?>>店铺资料</li></a>
              	<a href="<?php echo U('Home/Shops/toShopCfg/');?>"><li <?php if($umark == "setShop"): ?>class='liselect'<?php endif; ?>>店铺设置</li></a>
              	<a href="<?php echo U('Home/Messages/queryByPage/');?>"><li <?php if($umark == "queryMessageByPage"): ?>class='liselect'<?php endif; ?>>店铺消息<span style="display:none;" class="wst-msg-tips-box"></span></li></a>
				<!--id='li_queryMessageByPage' -->
              	<a href="<?php echo U('Home/Shops/toEditPass');?>"><li <?php if($umark == "toEditPass"): ?>class='liselect'<?php endif; ?>>修改密码</li></a>
            </div>
            <div class='wst-content'>
            
	<script>
	var statusMark = 0;
	$(function () {
		$('#tab').TabPanel({tab:statusMark,callback:function(tab){
			switch(tab){
			   case 0:querySettlementsByPage(0);break;
			   case 1:queryUnSettlementOrdersByPage(0);break;
			   case 2:querySettlementsOrdersByPage(0);break;
			}
		}});
	});
	</script>
	<div class="wst-body" style="margin-bottom: 8px;"> 
		<div class='wst-page-header'>卖家中心 > 订单结算</div>
		<div class='wst-page-content' style="padding-top:10px;">
		   <div id='tab' class="wst-tab-box">
			<ul class="wst-tab-nav">
				<li id="wst-msg-li-0">结算信息<span style="display:none;"></span></li>
				<li id="wst-msg-li-1">未结算订单<span style="display:none;"></span></li>
				<li id="wst-msg-li-2">已结算订单<span style="display:none;"></span></li>
			</ul>
			<div class="wst-tab-content" style='width:98%;'>
			    <!-- 结算信息 -->
				<div class='wst-tab-item'>
					<div>
						<table class='wst-list' style="font-size:13px;">
							<thead>
								<tr>
									<th colspan="10" class="wst-form">
									结算单号：<input type="text" id="settlementNo_0" style='width:120px;' autocomplete="off"/>
									结算状态：<select id='isFinish_0' autocomplete="off">
									    <option value='-1'>全部</option>
									    <option value='0'>未结算</option>
									    <option value='1'>已结算</option>
									</select>
									<button class='wst-btn-query' onclick="querySettlementsByPage(0)">查询</button>

									</th>
								</tr>
								<tr>
								    <th width='20'>&nbsp;</th>
									<th width='100'>结算单号</th>
									<th width='40'>类型</th>
									<th width='60'>订单金额</th>
									<th width='60'>结算金额</th>
									<th width='60'>佣金</th>
									<th width='130'>创建时间</th>
									<th width='60'>结算状态</th>
									<th width='130'>结算时间</th>
									<th width='*'>备注</th>
								</tr>
							</thead>
							<script id="tblist0" type="text/html">
							{{# for(var i = 0; i < d.length; i++){ }}
							<tr>
								<td>{{i+1}}</td>
							    <td><a style='color:blue' href='javascript:view("{{d[i].settlementNo}}")'>{{d[i].settlementNo}}</a></td>
								<td>{{# if(d[i].settlementType==1){ }}定时{{# }else{ }}手动{{# } }}</td>
                                <td>{{d[i].orderMoney}}</td>
								<td>{{d[i].settlementMoney}}</td>
                                <td>{{d[i].poundageMoney}}</td>
                                <td>{{d[i].createTime}}</td>
								<td>{{# if(d[i].isFinish==1){ }}已结算{{# }else{ }}未结算{{# } }}</td>
                                <td>{{WST.blank(d[i].finishTime,'-')}}</td> 
                                <td>{{WST.blank(d[i].remarks)}}</td>
							</tr>
							{{# } }}
                            </script>
							<tbody id="otbody0"></tbody>
							<tfoot>
								<tr>
									<td colspan='10' align='center' id="opage_0">
										<div id="wst-page-0" class='wst-page' style="float:right;padding-bottom:10px;"></div>
									</td>
								</tr>
							 </tfoot>
						</table>
					</div>
					<div style='clear:both;'></div>
				</div>
				<!-- 未结算订单 -->
				<div class='wst-tab-item' style="display:none;">
					<div>
						<table class='wst-list' style="font-size:13px;">
							<thead>
								<tr>
									<th colspan="7" class="wst-form">
									订单号：<input type="text" id="orderNo_1" style='width:120px;' autocomplete="off"/>
									收货人：<input type="text" id="userName_1" style='width:120px;' autocomplete="off"/>
									<button class='wst-btn-query' onclick="queryUnSettlementOrdersByPage(0)">查询</button>
									<button class='wst-btn-query' style='width:80px;' onclick="settlement()">申请结算</button>
									</th>
								</tr>
								<tr>
								    <th width='20'><input type='checkbox' onclick='WST.checkChks(this,".chk_1")'/></th>
									<th width='100'>订单号</th>
									<th width='100'>收货人</th>
									<th width='130'>下单时间</th>
									<th width='70'>订单金额</th>
									<th width='70'>佣金比例</th>
									<th width='70'>佣金</th>
									
								</tr>
							</thead>
							<script id="tblist1" type="text/html">
							{{# for(var i = 0; i < d.length; i++){ }}
							<tr>
								<td><input type='checkbox' class='chk_1' value='{{d[i].orderId}}'/></td>
							    <td>{{d[i].orderNo}}</td>
								<td>{{d[i].userName}}</td>
                                <td>{{d[i].createTime}}</td>
								<td>{{d[i].realTotalMoney }}</td>
                                <td>{{d[i].poundageRate}}</td>
                                <td>{{d[i].poundageMoney}}</td>
							</tr>
							{{# } }}
                            </script>
							<tbody id="otbody1">
							</tbody>
							<tfoot>
								<tr>
									<td colspan='6' align='center' id="opage_1">
										<div  id="wst-page-1" class="wst-page" style="float:right;padding-bottom:10px;"></div>
									</td>
								</tr>
							 </tfoot>
						</table>
					</div>
					<div style='clear:both;'></div>
				</div>
				<!-- 打包中 -->
				<div class='wst-tab-item' style="display:none;">
					<div>
						<table class='wst-list' style="font-size:13px;">
							<thead>
								<tr>
									<th colspan="9" class="wst-form">
									结算单号：<input type="text" id="settlementNo_2" style='width:120px;' autocomplete="off"/>
									订单号：<input type="text" id="orderNo_2" style='width:120px;' autocomplete="off"/>
									结算状态：<select id='isFinish_2' autocomplete="off">
									    <option value='-1'>全部</option>
									    <option value='0'>未结算</option>
									    <option value='1'>已结算</option>
									</select>
									<button class='wst-btn-query' onclick="querySettlementsOrdersByPage(0)">查询</button>
									</th>
								</tr>
								<tr>
								    <th width='20'>&nbsp;</th>
									<th width='100'>订单号</th>
									<th width='100'>收货人</th>
									<th width='70'>订单金额</th>
									<th width='70'>佣金比例</th>
									<th width='70'>结算金额</th>
									<th width='130'>结算单号</th>
									<th width='100'>结算时间</th>
								</tr>
							</thead>
							<script id="tblist2" type="text/html">
							{{# for(var i = 0; i < d.length; i++){ }}
							<tr>
								<td width='10'>{{i+1}}</td>
							    <td width='100'>{{d[i].orderNo}}</td>
								<td width='70'>{{d[i].userName}}</td>
								<td width='100'>{{d[i].realTotalMoney }}</td>
                                <td>{{d[i].poundageRate}}</td>
                                <td width='100'>{{d[i].settlementMoney }}</td>
								<td width='120'>{{d[i].settlementNo}}</td>
                                <td width='120'>{{WST.blank(d[i].finishTime,'-')}}</td>
							</tr>
							{{# } }}
                            </script>
							<tbody id="otbody2">
							</tbody>
							<tfoot>
								<tr>
									<td colspan='9' align='center' id="opage_2">
										<div  id="wst-page-2" class="wst-page" style="float:right;padding-bottom:10px;"></div>
									</td>
								</tr>
							 </tfoot>
						</table>
					</div>
					<div style='clear:both;'></div>
				</div>
			</div>
			</div>
		</div>
		<div style='clear:both;'></div>
	</div>
	<script src="/Apps/Home/View/default/js/settlements.js"></script>

            </div>
          </div>
          <div style='clear:both;'></div>
          <br/>
         <!-- <div class='wst-footer'>
          	<div >
<div class="wst-footer-fl-box">
	<div class="wst-footer" >
		<div class="wst-footer-cld-box">
			<div class="wst-footer-fl">友情链接：</div>
			<div style="padding-left:30px;">
				<?php if(is_array($friendLikds)): $k = 0; $__LIST__ = $friendLikds;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><div style="float:left;"><a href="<?php echo ($vo["friendlinkUrl"]); ?>" target="_blank"><?php echo ($vo["friendlinkName"]); ?></a>&nbsp;&nbsp;</div><?php endforeach; endif; else: echo "" ;endif; ?>
				<div class="wst-clear"></div>
			</div>
		</div>
	</div>
</div>

<div class="wst-footer-hp-box">
	<div class="wst-footer">
		<div class="wst-footer-hp-ck1">
			<?php if(is_array($helps)): $k1 = 0; $__LIST__ = $helps;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($k1 % 2 );++$k1;?><div class="wst-footer-wz-ca">
				<div class="wst-footer-wz-pt">
				    <img src="/Apps/Home/View/default/images/a<?php echo ($k1); ?>.jpg" height="18" width="18"/>
					<span class="wst-footer-wz-pn"><?php echo ($vo1["catName"]); ?></span>
					<div style='margin-left:30px;'>
						<?php if(is_array($vo1['articlecats'])): $k2 = 0; $__LIST__ = $vo1['articlecats'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($k2 % 2 );++$k2;?><a href="<?php echo U('Home/Articles/index/',array('articleId'=>$vo2['articleId']));?>"><?php echo ($vo2['articleTitle']); ?></a><br/><?php endforeach; endif; else: echo "" ;endif; ?>
					</div>
				</div>
			</div><?php endforeach; endif; else: echo "" ;endif; ?>
			
			<div class="wst-footer-wz-clt">
				<div style="padding-top:5px;line-height:25px;">
				    <img src="/Apps/Home/View/default/images/a6.jpg" height="18" width="18"/>
					<span class="wst-footer-wz-kf">联系客服</span>
					<div style='margin-left:30px;'>
						<a href="#">联系电话</a><br/>
						<?php if($CONF['phoneNo'] != ''): ?><span class="wst-footer-pno"><?php echo ($CONF['phoneNo']); ?></span><br/><?php endif; ?>
						<?php if($CONF['qqNo'] != ''): ?><a href="tencent://message/?uin=<?php echo ($CONF['qqNo']); ?>&Site=QQ交谈&Menu=yes">
						<img border="0" src="http://wpa.qq.com/pa?p=1:<?php echo ($CONF['qqNo']); ?>:7" alt="QQ交谈" width="71" height="24" />
						</a><br/><?php endif; ?>
						
					</div>
				</div>
			</div>
			<div class="wst-clear"></div>
		</div>
	    
		<div class="wst-footer-hp-ck2">
			<img src="/Apps/Home/View/default/images/alipay.jpg" height="40" width="120"/>支付宝签约商家&nbsp;|&nbsp;
			<span class="wst-footer-frd">正品保障</span><span >100%原产地</span>&nbsp;|&nbsp;
			<span class="wst-footer-frd">7天退货保障</span>购物无忧&nbsp;|&nbsp;
			<span class="wst-footer-frd">免费配送</span>满98包邮&nbsp;|&nbsp;
			<span class="wst-footer-frd">货到付款</span>400城市送货上门
		</div>
	    <div class="wst-footer-hp-ck3">
	        <div class="links"> 
	            <?php $_result=WSTNavigation(1);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a rel="nofollow" <?php if($vo['isOpen'] == 1): ?>target="_blank"<?php endif; ?> href="<?php echo ($vo['navUrl']); ?>"><?php echo ($vo['navTitle']); ?></a>&nbsp;<?php if($vo['end'] == 0): ?>|&nbsp;<?php endif; endforeach; endif; else: echo "" ;endif; ?>
	        </div>

	        <div class="copyright">

	         <?php if($CONF['mallFooter']!=''){ echo htmlspecialchars_decode($CONF['mallFooter']); } ?>
	      	<?php if($CONF['visitStatistics']!=''){ echo htmlspecialchars_decode($CONF['visitStatistics'])."<br/>"; } ?>
	        <?php if($CONF['mallLicense'] ==''): ?><div>
				Copyright©2015 Powered By <a target="_blank" href="http://www.qianpok.com">QianPokMall</a>
			</div>
			<?php else: ?>
				<div id="wst-mallLicense" data='1' style="display:none;">Copyright©2015 Powered By <a target="_blank" href="http://www.qianpok.com">QianPokMall</a></div><?php endif; ?>
	        </div>

	    </div>
	</div>
</div>
</div>
          </div>-->
        </div>
       <!-- <object id="player" height="360" width="300" classid="CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6" style="display:none;">
			<param name="AUTOSTART" value="0"/>
			<param name="SHUFFLE" value="0"/>
			<param name="PREFETCH" value="0"/>
			<param name="NOLABELS" value="0"/>
			<param name="url" value=""/>
			<param name="CONTROLS" value="ImageWindow"/>
			<param name="CONSOLE" value="Clip1"/>
			<param name="LOOP" value="0"/>
			<param name="NUMLOOP" value="0"/>
			<param name="CENTER" value="0"/>
			<param name="MAINTAINASPECT" value="0"/>
			<param name="BACKGROUNDCOLOR" value="#000000"/>
		</object>-->
    </body>
      	<script src="/Public/plugins/formValidator/formValidator-4.1.3.js"></script>
     	<script src="/Public/js/common.js"></script>
      	<script src="/Apps/Home/View/default/js/shopcom.js"></script>
      	<script src="/Apps/Home/View/default/js/head.js"></script>
      	<script src="/Apps/Home/View/default/js/common.js"></script>
      	<script src="/Public/plugins/layer/layer.min.js"></script>
      	<script src="/Apps/Home/View/default/js/audio.js"></script>
      	<script type="text/javascript" src="/Public/plugins/webuploader/webuploader.js"></script>
</html>