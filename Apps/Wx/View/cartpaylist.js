
//atts规格商品
//修改购物车中的商品数量
function changeCatGoodsnum(flag,shopId,goodsId,priceAttrId,isBook,atts){
	isBook = 0;
	var num = parseInt($("#buy-num_"+atts).val(),10);
	if(num<0){
		num = Math.abs(num);
		$("#buy-num_"+atts).val(num);
	}
	
	if(flag==1){
		if(num>1)num = num-1;		
	}else if(flag==2){
		num = num+1;
	}
	if(num<1){
		num = 1;
		//$("#buy-num_"+atts).val(1);
	}
	$("#buy-num_"+atts).val(num);  //先减
	if($("#chk_goods_"+atts).is(":checked")){
		checkCartPay(shopId,goodsId,num,1,isBook,priceAttrId,atts);
	}else{
		checkCartPay(shopId,goodsId,num,0,isBook,priceAttrId,atts);
	}
	
}

//多规格使用atts
function checkCartPay(shopId,goodsId,num,ischk,isBook,goodsAttrId,atts){
	jQuery.post( '/Wx/Goods/getGoodsStock' ,{goodsId:goodsId,isBook:isBook,goodsAttrId:goodsAttrId},function(data) {
		var json = WST.toJson(data);
		if(json.goodsStock==0){
			$("#stock_"+json.goodsId).html("<span style='color:red;'>无货</span>");
		}
		num = parseInt(num,10);
		if(json.goodsStock>=num){
			num = num>100?100:num;	
			$("#stock_"+json.goodsId+"_"+goodsAttrId).html("有货");
			$("#selgoods_"+json.goodsId+"_"+goodsAttrId).css({"border":"0"});
		}else{
			num = json.goodsStock;	
			$("#stock_"+json.goodsId+"_"+goodsAttrId).html("<span style='color:red;'>仅剩最后"+json.goodsStock+"份</span>");
			$("#selgoods_"+json.goodsId+"_"+goodsAttrId).css({"border":"0"});
		}
		jQuery.post( '/Wx/Cart/changeCartGoodsNum' ,{goodsId:goodsId,num:num,ischk:ischk,goodsAttrId:goodsAttrId,goodsattr:atts},function(rsp) {
			if(rsp){
				var totalMoney = 0;	
				//$("#buy-num_"+atts).val(num);后减操作注释
				$("#buy-num_"+atts).css({"border":""});
				var price = parseFloat($("#price_"+goodsId+"_"+goodsAttrId).val(),10);
				$("#prc_"+goodsId+"_"+goodsAttrId).html((num*price).toFixed(2));
				//店铺下的商品
				var shopTotalMoney = 0;
				$("input[name='chk_goods_"+atts+"']").each(function(){
					if($(this).is(":checked")){
						var goodsAttrId = $(this).attr('dataId');
						var goodsattrs = $(this).attr('datakey');
						var gid = $(this).val();
						var gnum = $("#buy-num_"+goodsattrs).val();
						var gprice = parseFloat($("#price_"+gid+"_"+goodsAttrId).val(),10);
						shopTotalMoney += gnum*gprice;
					}
				});
				$("#shop_totalMoney_"+shopId).html(shopTotalMoney.toFixed(2));
				//所有商品
				$(".cgoodsId").each(function(){
					var goodsAttrId = $(this).attr('dataId');
					var gid = $(this).val();
					var goodsattrs = $(this).attr('datakey');
					if($("#chk_goods_"+goodsattrs).is(":checked")){
						var price = parseFloat($("#price_"+gid+"_"+goodsAttrId).val(),10);
						var cnt = parseInt($("#buy-num_"+goodsattrs).val(),10);

						totalMoney += price*cnt;
					}
				});

				$("#wst_cart_totalmoney").html(totalMoney.toFixed(2));
			}
		});
	});
}

function toContinue(){
	location.href= WST.DOMAIN ;
}

//去结算
function goToPay(){
	var flag = true;
	var cflag = true;
	var chkId;
	var payGoodsNum = 0;
	if(WST.IS_LOGIN==0){
		loginWin();
		return;
	}
	$("input[id^='buy-num_']").each(function(){
		chkId = $(this).attr('id').replace('buy-num_','chk_goods_');
		if($("#"+chkId).prop('checked'))payGoodsNum++;
		if($(this).val()<1 && $("#"+chkId).prop('checked')){
			$(this).css({"border":"2px solid red"});
			layer.tips("购买数量不能小于1","#"+$(this).attr("id"));
			if(cflag){
				cflag = false;
			}
				
		}
	});
	if(payGoodsNum==0){
		WST.msg('请选择要结算的商品!',{icon:5,offset: '200px'});
		return;
	}
	if(!cflag){
		return false;
	}
	jQuery.post('/Wx/Cart/checkCartGoodsStock' ,{},function(data) {
		var goodsInfo = WST.toJson(data);		
		for(var i=0;i<goodsInfo.length;i++){
			var goods = goodsInfo[i];
			if(goods.cnt<1 && $('#chk_goods_'+goods.goodsId+"_"+goods.goodsAttrId).prop('checked')){
				cflag = false;
				$("#buy-num_"+goods.goodsId+"_"+goods.goodsAttrId).css({"border":"2px solid red"});
				layer.tips("购买数量不能小于1","#buy-num_"+goods.goodsId+"_"+goods.goodsAttrId);
			}
			if(goods.stockStatus<1 && $('#chk_goods_'+goods.goodsId+"_"+goods.goodsAttrId).prop('checked')){
				flag = false;
				$("#selgoods_"+goods.goodsId+"_"+goods.goodsAttrId).css({"border":"2px solid red"});				
				if(goods.goodsStock>0){
					$("#stock_"+goods.goodsId+"_"+goods.goodsAttrId).html("<span style='color:red;'>仅剩最后"+goods.goodsStock+"份</span>");
				}else{
					$("#stock_"+goods.goodsId+"_"+goods.goodsAttrId).html("<span style='color:red;'>无货</span>");
				}				
			}else{
				$("#stock_"+goods.goodsId+"_"+goods.goodsAttrId).html("有货");
			}
		}
		if(!cflag){
			return false;
		}
		if(flag){
			location.href = '/Wx/Orders/checkOrderInfo/'+'rnd/'+new Date().getTime();
		}else{
			$("#showwarnmsg").show();
		}
	});
	
	
}

//删除购物车中的商品 atts 新增
function delCatGoods(shopId,goodsId,priceAttrId,atts){
	layer.confirm('您确定要从购物车中删除该商品吗？',{icon: 3, title:'系统提示',offset: '150px'}, function(tips){
		var ll = layer.load('数据处理中，请稍候...');
		var num = parseInt($("#buy-num_"+goodsId+"_"+priceAttrId).val(),10);	
		var totalMoney = parseFloat($("#wst_cart_totalmoney").html(),10);
		var shop_totalMoney = parseFloat($("#shop_totalMoney_"+shopId).html(),10);
		var price = parseFloat($("#price_"+goodsId+"_"+priceAttrId).val(),10);
		var ischk = $("#chk_goods_"+goodsId+"_"+priceAttrId).prop('checked');
		jQuery.post('/Wx/Cart/delCartGoods' ,{goodsId:goodsId,goodsAttrId:priceAttrId,goodsattr:atts},function(data) {
			layer.close(ll);
	    	layer.close(tips);
			var vd = WST.toJson(data);
			$(".selgoods_"+atts).remove();
			if($("input[name='chk_goods_"+atts+"']").length==0){
				//$("#wst_cart_shop_"+shopId).remove();
			}
			if(ischk){
			    $("#shop_totalMoney_"+shopId).html(parseFloat((shop_totalMoney-price*num),10).toFixed(2));
			    $("#wst_cart_totalmoney").html(parseFloat((totalMoney-price*num),10).toFixed(2));
			}
			//if($("div[id^='wst_cart_shop_']").length==0){
			//	$("#wst_cartlist_pbox").html("<div style='height:80px;line-height:80px;font-size:20px;text-align:center;'>您的购物车空空如也，赶快开始购物吧！</div><br/>");
			//	$('.wst-btn-checkout').hide();
			//}
		});	
	});
}

/**
 * 提交订单
 */
function submitOrder(){
	var flag = true;
	$(".tst").each(function(){
		if($(this).val()==-1){
			flag = false;
		}
	});
	if(!flag){
		WST.msg("抱歉，您的订单金额未达到该店铺的配送订单起步价，不能提交订单。", {icon: 5});
		return;
	}
	var ll = layer.msg('正在提交订单，请稍候...', {icon: 16,shade: [0.5, '#B3B3B3']});
	jQuery.post('/Wx/Goods/checkGoodsStock' ,{},function(data) {
		var goodsInfo = WST.toJson(data);
		layer.close(ll);
		var flag = true;
		for(var i=0;i<goodsInfo.length;i++){
			var goods = goodsInfo[i];
			if(goods.isSale<1 || goods.goodsStock<=0){
				flag = false;
			}
		}
		if(flag){
			var params = {};
			params.consigneeId = $("#consigneeId").val();
			if(params.consigneeId<1){
				WST.msg("请填写收货人地址", {icon: 5});
				return ;
			}
			params.invoiceClient = $.trim($("#invoiceClient").val());
			var rdate = $("#requestdate").val();
			var rtime = $("#requesttime").val();
			params.requireTime = rdate+" "+rtime+":00";
			params.payway = $('input:radio[name="paytype"]:checked').val();
			params.needreceipt = $('input:radio[name="needreceipt"]:checked').val();
			params.isself = $('input:radio[name="isself"]:checked').val();
			params.remarks = $.trim($("#remarks").val());
			//var d1 = params.requireTime;
			//d1 = d1.replace(/-/g,"/");
			//var date1 = new Date(d1);
			//var d2 = addHour(1);
			//d2 = d2.replace(/-/g,"/");
			//var date2 = new Date(d2);
			//alert(params.payway);
			if(params.payway!='1'&&params.payway!='3'){
				WST.msg("请选择支付方式", {icon: 5});
				return ;
			}
			//alert('11111');
			//return false;
			params.isScorePay = 0;
			if($("#isScorePay").length>0){
				if($("#isScorePay").prop('checked')){
					params.isScorePay = 1;
				}
			}
			if(params.needreceipt==1 && params.invoiceClient==""){
				WST.msg("请输入抬头", {icon: 5});
				return ;
			}
			//if(date1<date2){
			//	WST.msg("亲，期望送达时间必须设定为下单时间1小时后哦！", {icon: 5});
			//	return ;
			//}
			//if(!subCheckArea()){
			//	WST.msg("您选的商品不在配送区域内！", {icon: 5});
			//	return ;
			//}
			//params.orderunique = new Date().getTime();

			var ll = layer.msg('提交订单，请稍候...', {icon: 16,shade: [0.5, '#B3B3B3']});
			jQuery.post('/Wx/Orders/submitOrder' ,params,function(data) {
				var json = WST.toJson(data);
				if(json.status==1){
					if(params.payway==1||params.payway==3){
						location.href='/Wx/Orders/toWxPay';
					}else{
						//location.href= '/Wx/Orders/orderSuccess';querydeliverybypage
						location.href= '/Wx/Orders/querydeliverybypage';
					}
				}else{
					WST.msg(json.msg, {icon: 5});
				}
			});
		}else{
			if(goods.isSale<1){
				WST.msg('商品'+goods.goodsName+'已下架，请返回重新选购!', {icon: 5});
			}else if(goods.goodsStock<=0){
				WST.msg('商品'+goods.goodsName+'库存不足，请返回重新选购!', {icon: 5});
			}
		}

	});


}



jQuery(function(){
	jQuery(".goodsStockFlag").each(function(){		
		if($(this).val()==-1){
			$("#showwarnmsg").show();
			return;
		}
	});

	$("#chk_all").click(function(){
		if($(this).prop("checked")){
			$("input[id^='chk_shop_']").each(function(){
				$(this).prop("checked",true);
				var shopId = $(this).val();
				$("input[name='chk_goods_"+shopId+"']").each(function(){
					$(this).prop("checked",true);
					var shopId = $(this).attr("parent");
					var priceAttrId = $(this).attr("dataId");
					var goodsId = $(this).val();
					var num = $("#buy-num_"+goodsId+"_"+priceAttrId).val();
					var isBook = $(this).attr("isBook");
					checkCartPay(shopId,goodsId,num,1,isBook,priceAttrId);
					
				});
			});
		}else{
			$("input[id^='chk_shop_']").each(function(){
				$(this).prop("checked",false);
				var shopId = $(this).val();
				$("input[name='chk_goods_"+shopId+"']").each(function(){
					$(this).prop("checked",false);
					var priceAttrId = $(this).attr("dataId");
					var shopId = $(this).attr("parent");
					var goodsId = $(this).val();
					var num = $("#buy-num_"+goodsId+"_"+priceAttrId).val();
					var isBook = $(this).attr("isBook");
					checkCartPay(shopId,goodsId,num,0,isBook,priceAttrId);
				});
			});
		}
	});
	
	
	$("input[id^='chk_shop_']").click(function(){
		var shopId = $(this).val();
		var priceAttrId = $(this).attr("dataId");
		if($(this).prop("checked")){
			$("input[name='chk_goods_"+shopId+"']").each(function(){
				var priceAttrId = $(this).attr("dataId");
				$(this).prop("checked",true)
				var shopId = $(this).attr("parent");
				var goodsId = $(this).val();
				var num = $("#buy-num_"+goodsId+"_"+priceAttrId).val();
				var isBook = $(this).attr("isBook");
				checkCartPay(shopId,goodsId,num,1,isBook,priceAttrId);
				
			});
		}else{
			$("input[name='chk_goods_"+shopId+"']").each(function(){
				var priceAttrId = $(this).attr("dataId");
				$(this).prop("checked",false);
				var shopId = $(this).attr("parent");
				var goodsId = $(this).val();
				var num = $("#buy-num_"+goodsId+"_"+priceAttrId).val();
				var isBook = $(this).attr("isBook");
				checkCartPay(shopId,goodsId,num,0,isBook,priceAttrId);
			});
		}
	});
	
	$("input[id^='chk_goods_']").click(function(){
		var priceAttrId = $(this).attr("dataId");
		var shopId = $(this).attr("parent");
		var goodsId = $(this).val();
		var num = $("#buy-num_"+goodsId+"_"+priceAttrId).val();
		var isBook = $(this).attr("isBook");
		if($(this).is(":checked")){
			checkCartPay(shopId,goodsId,num,1,isBook,priceAttrId);
		}else{
			checkCartPay(shopId,goodsId,num,0,isBook,priceAttrId);
		}
		
	});
	
});
