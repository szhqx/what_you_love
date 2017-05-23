$(function () {
    //滚动条
    $(".category1,.category2").niceScroll({ cursorwidth: 0,cursorborder:0,autohidemode:false });
	//$(".category2").niceScroll({
	//	cursorcolor: "#ccc",//#CC0071 光标颜色
	//	cursoropacitymax: 1, //改变不透明度非常光标处于活动状态（scrollabar“可见”状态），范围从1到0
	//	touchbehavior: false, //使光标拖动滚动像在台式电脑触摸设备
	//	cursorwidth: "5px", //像素光标的宽度
	//	cursorborder: "0", //     游标边框css定义
	//	cursorborderradius: "5px",//以像素为光标边界半径
	//	autohidemode: false //是否隐藏滚动条
	//});

    //图片延迟加载
   $(".lazyload").scrollLoading({ container: $(".category2") });

    $('.category-box').height($(window).height());

    //点击切换2 3级分类
	var array=new Array();
	$('.category1 li').each(function(){ 
		array.push($(this).position().top-56);
	});
	
	$('.category1 li').click(function() {
		var index=$(this).index();
		$('.category1').delay(200).animate({scrollTop:array[index]},300);
		$(this).addClass('cur').siblings().removeClass();
		$('.category2 dl').eq(index).show().siblings().hide();
	});

});
