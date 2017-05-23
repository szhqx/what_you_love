/**商品详情页的加减商品**/
//加商品
$(document).on("click", ".plus", function(){
    var input = $(this).parent().find('input').val();
    var stock = $(this).parent().find('input').attr('max');
    var qty = input == '' ? 0 : parseInt(input);
    qty++;
    if(qty > stock){
        return;
    }
    $(this).parent().find('input').val(qty);
});
//减商品
$(document).on("click", ".minus", function(){
    var input = $(this).parent().find('input').val();
    var qty = input == '' ? 1 : parseInt(input);
    qty = qty > 1 ? qty - 1 : 1;
    $(this).parent().find('input').val(qty);
});

//有价格的选择
function checkStock(obj){
    $(obj).addClass('wst-goods-attrs-on').siblings().removeClass('wst-goods-attrs-on');
    getPriceAttrInfo($(obj).attr('dataId'));
}
//无价格的选择
function checkStocks(obj){
    $(obj).addClass('wst-goods-attrs-on').siblings().removeClass('wst-goods-attrs-on');
    $("#attrs"+$(obj).attr("dataid")).val($(obj).attr("dataid")+"_"+$(obj).attr("datakey"));

}
//获取属性价格
function getPriceAttrInfo(id){
    var goodsId = $("#goodsId").val();
    jQuery.post('/Wx/Goods/getPriceAttrInfo' ,{goodsId:goodsId,id:id},function(data) {
        var json = WST.toJson(data);
        if(json.id){
            $('#shopGoodsPrice_'+goodsId).html(json.attrPrice);
            var buyNum = parseInt($("#buy-num").val());
            $("#buy-num").attr('maxVal',json.attrStock);
            $("#goodsStock").html(json.attrStock);
            if(buyNum>json.attrStock){
                $("#buy-num").val(json.attrStock);
            }
            $('#shopGoodsPrice_'+goodsId).attr('dataId',id);
            $("#testattr").val(id);
        }
    });
}


function go_cart(goods_id){ //立即购买
    var number       = 1;
    if($("#buy-num").val()){
        number = $("#buy-num").val();
    }else {
        number = 1;
    }
    var params = {};
    params.goodsId = goods_id;
    params.gcount = number;
    params.rnd = Math.random();
    params.goodsAttrId = $('#shopGoodsPrice_'+goods_id).attr('dataId');
    if($("#test").val()==1&&$("#testattr").val()==''){
        bx_alert("请选择商品属性!");
        return false;
    }
    var atts = '';
    var els = $("#attrs").find("input");
    if(els.length>0){
        for(var i=0;i<els.length;i++) {
            if(els[i].value==''){
                bx_alert("请选择商品属性");
                return false;
            }
            atts += els[i].value+'-';
        }
    }
    params.attrs = atts;

    jQuery.post('/Wx/Cart/addToCartAjax' ,params,function(result){
        window.location.href='/Wx/Cart/getCartInfo';
    });
}
function add_cart(goods_id){ //
    var number       = 1;
    if($("#buy-num").val()){
        number = $("#buy-num").val();
    }else {
        number = 1;
    }

    var params = {};
    params.goodsId = goods_id;
    params.gcount = number;
    params.rnd = Math.random();
    params.goodsAttrId = $('#shopGoodsPrice_'+goods_id).attr('dataId');
    if($("#test").val()==1&&$("#testattr").val()==''){
        bx_alert("请选择商品属性!");
        return false;
    }

    var atts = '';
    var els = $("#attrs").find("input");
    if(els.length>0){
        for(var i=0;i<els.length;i++) {
            if(els[i].value==''){
                bx_alert("请选择商品属性");
                return false;
            }
            atts += els[i].value+'-';
        }
    }
    params.attrs = atts;
    //
    ////动态效果
    //var flyElm = $(".swiper-container ").find('.swiper-slide').first().clone().css('opacity','0.9');
    //flyElm.css({
    //    'z-index': 1800,
    //    'display': 'block',
    //    'position': 'absolute',
    //    'top': $('.jiaru').offset().top +'px',
    //    'left': $('.jiaru').offset().left +'px',
    //    'width': $('.jiaru').width() +'px',
    //    'height': $('.jiaru').height() +'px',
    //    'text-align':'center',
    //    'margin':'0'
    //});
    //$('body').append(flyElm);
    //flyElm.animate({
    //    top:$('.h-right').offset().top,
    //    left:$('.h-right').offset().left,
    //    width:50,
    //    height:50,
    //    opacity:0
    //},'slow');
    //setTimeout(function(){ //清除动画样式
    //    flyElm.remove();
    //},1000);
    $("#spxq").prepend("<div class=alert>添加商品成功</div>");
    $(".alert").delay(800).fadeOut(300);
 //   $(".wst-nvg-cart-cnt").html(parseInt($(".wst-nvg-cart-cnt").html())+parseInt(number));
    jQuery.post('/Wx/Cart/addToCartAjax' ,params,function(result){
        if (result.status > 0)
        {
            if (result.status == 2)
            {
                alert(result.msg);
            }
            else if (result.status == 6)
            {
                openSpeDiv(result.data['spec'], result.data['goods_id']);
            }
            else
            {
                alert(result.msg);
            }
        } else
        {
            checkCart();
            var cartInfo = document.getElementById('ECS_CARTINFO');
            var cart_url = '/Wx/Cart/getCartInfo';
            if (cartInfo)
            {
                cartInfo.innerHTML = result.content;
            }
            switch(result.confirm_type)
            {
                default :
                    opencartDiv(result.shop_price,result.goods_name,result.goods_thumb,result.goods_brief,result.goods_id,result.goods_price,result.goods_number);
                    break;
            }
        }
    }, 'json');
}

