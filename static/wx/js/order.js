
function orderCancel(id,type){
	if(type==1 || type==2){
		var w = layer.open({
			type: 1,
			title:"取消原因",
			shade: [0.6, '#000'],
			border: [0],
			content: '<textarea id="rejectionRemarks" rows="8" style="width:96%" maxLength="100"></textarea>',
			area: ['500px', '260px'],
			btn: ['提交', '关闭窗口'],
			yes: function(index, layero){
				var rejectionRemarks = $.trim($('#rejectionRemarks').val());
				if(rejectionRemarks==''){
					WST.msg('请输入拒收原因 !', {icon: 5});
					return;
				}
				var ll = layer.load('数据处理中，请稍候...');
				$.post('/Wx/Orders/orderCancel',{orderId:id,type:1,rejectionRemarks:rejectionRemarks},function(data){
					layer.close(w);
					layer.close(ll);
					var json = WST.toJson(data);
					if(json.status>0){
						window.location.reload();
					}else if(json.status==-1){
						WST.msg('操作失败，订单状态已发生改变，请刷新后再重试 !', {icon: 5});
					}else{
						WST.msg('操作失败，请与商城管理员联系 !', {icon: 5});
					}
				});
			}
		});
	}else if(type==-2){
		layer.confirm('您确定要取消该订单吗？',{icon: 3, title:'系统提示'}, function(tips){
			var ll = layer.load('数据处理中，请稍候...');
			$.post('/Wx/Orders/orderCancelunique',{orderId:id},function(data){
				layer.close(ll);
				layer.close(tips);
				var json = WST.toJson(data);
				if(json.status>0){
					window.location.reload();
				}else if(json.status==-1){
					WST.msg('操作失，订单状态已发生改变，请刷新后再重试 !', {icon: 5});
				}else{
					WST.msg('操作失，请与商城管理员联系 !', {icon: 5});
				}
			});
		});
	}else{
		layer.confirm('您确定要取消该订单吗？',{icon: 3, title:'系统提示'}, function(tips){
			var ll = layer.load('数据处理中，请稍候...');
			$.post('/Wx/Orders/orderCancel',{orderId:id},function(data){
				layer.close(ll);
				layer.close(tips);
				var json = WST.toJson(data);
				if(json.status>0){
					window.location.reload();
				}else if(json.status==-1){
					WST.msg('操作失，订单状态已发生改变，请刷新后再重试 !', {icon: 5});
				}else{
					WST.msg('操作失，请与商城管理员联系 !', {icon: 5});
				}
			});
		});
	}
}

//订单确定取消
function orderConfirm(id,type){
	if(type==1){
		layer.confirm('您确定已收货吗？',{icon: 3, title:'系统提示'}, function(tips){
			var ll = layer.load('数据处理中，请稍候...');
			$.post('/Wx/Orders/orderConfirm',{orderId:id,type:type},function(data){
				layer.close(tips);
				layer.close(ll);
				var json = WST.toJson(data);
				if(json.status>0){
					location.reload();
				}else if(json.status==-1){
					WST.msg('操作失败，订单状态已发生改变，请刷新后再重试 !', {icon: 5});
				}else{
					WST.msg('操作失败，请与商城管理员联系 !', {icon: 5});
				}
			});
		});
	}else{
		var w = layer.open({
			type: 1,
			title:"拒收原因",
			shade: [0.6, '#000'],
			border: [0],
			content: '<textarea id="rejectionRemarks" rows="8" style="width:100%;font-size: 14px;"  maxLength="100"></textarea>',
			area: ['300px', '200px'],
			btn: ['拒收订单', '关闭窗口'],
			yes: function(index, layero){
				var rejectionRemarks = $.trim($('#rejectionRemarks').val());
				if(rejectionRemarks==''){
					WST.msg('请输入拒收原因 !', {icon: 5});
					return;
				}
				var ll = layer.load('数据处理中，请稍候...');
				$.post('/Wx/Orders/orderConfirm',{orderId:id,type:type,rejectionRemarks:rejectionRemarks},function(data){
					layer.close(w);
					layer.close(ll);
					var json = WST.toJson(data);
					if(json.status>0){
						location.reload();
					}else if(json.status==-1){
						WST.msg('操作失败，订单状态已发生改变，请刷新后再重试 !', {icon: 5});
					}else{
						WST.msg('操作失败，请与商城管理员联系 !', {icon: 5});
					}
				});
			}
		});
	}
}

//评价
function appraiseOrder(id){
	layer.open({
		type: 2,
		title:"订单详情",
		shade: [0.6, '#000'],
		border: [0],
		content: ['/Wx/GoodsAppraises/toAppraise/orderId/'+id],
		area: ['300px', ($(window).height() - 50) +'px'],
		end:function(){
			window.location.reload();
		}
	});
}
/*
 *订单二次支付
 */
function toPay(id){
	var params = {};
	params.orderId = id;
	jQuery.post('/Wx/Orders/checkOrderPay' ,params,function(data) {
		var json = WST.toJson(data);
		if(json.status==1){
			location.href='/Wx/Orders/toWxPay';
		}else if(json.status==-2){
			var rlist = json.rlist;
			var garr = new Array();
			for(var i=0;i<rlist.length;i++){
				garr.push(rlist[i].goodsName+rlist[i].goodsAttrName);
			}
			WST.msg('订单中商品【'+garr.join("，")+'】库存不足，不能进行支付。', {icon: 5});
		}else{
			WST.msg('您的订单已支付!', {icon: 5});
			setTimeout(function(){
				window.location = '/Wx/orders/queryDeliveryByPage';
			},1500);
		}
	});

}

/**
 * 查看订单详情
 **/
function showOrder(id){
	layer.open({
		type: 2,
		title:"订单详情",
		shade: [0.6, '#000'],
		border: [0],
		offset: ['20px',''],
		content: ['/Wx/Orders/getOrderDetails/orderId/'+id],
		area: ['98%', ($(window).height() - 50) +'px']
	});
}