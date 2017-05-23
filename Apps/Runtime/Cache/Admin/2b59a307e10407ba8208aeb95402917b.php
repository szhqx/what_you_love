<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo ($CONF['mallTitle']); ?>后台管理中心</title>
	<link href="/Public/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="/Apps/Admin/View/css/AdminLTE.css" rel="stylesheet" type="text/css" />
	<!--[if lt IE 9]>
	<script src="/Public/js/html5shiv.min.js"></script>
	<script src="/Public/js/respond.min.js"></script>
	<![endif]-->
	<script src="/Public/js/jquery.min.js"></script>
	<script src="/Public/plugins/bootstrap/js/bootstrap.min.js"></script>
	<script src="/Public/js/common.js"></script>
	<script src="/Public/plugins/plugins/plugins.js"></script>
	<style>
		.board {
			background: url("/Public/images/bg_repno.gif") no-repeat scroll 0 0 transparent;
			padding-left: 55px;
		}
	</style>
</head>
<body class='wst-page'>
<div class="wrap">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#A" data-toggle="tab">微信配置</a></li>
	</ul>
	<form method="post" class="js-ajax-form" action="<?php echo U('wechat/menu_post');?>">
		<div class="tabbable">
			<div class="tab-content">
				<div class="row-fluid">

					<div class="span8 control-group">
						<a href="javascript:void(0);" class="btn" id="add_menu"><i class="icon-plus"></i>添加主菜单</a>
						<!--<i class="icon-plus cursor_p add" title="添加子菜单" rel="451"></i>-->
					</div>
				</div>
				<div class="tab-pane active" id="A">
					<table id="listTable" class="table table-bordered table-hover dataTable">
						<thead>
						<tr>
							<th>显示顺序</th>
							<th>主菜单名称</th>
							<th>触发关键词或链接地址</th>
							<th>启用</th>
							<th>操作</th>
						</tr>
						</thead>
						<tbody>
						<?php if(is_array($class)): $i = 0; $__LIST__ = $class;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$class): $mod = ($i % 2 );++$i;?><tr class="ptr">
								<td>
									<input type="text" size="3" value="<?php echo ($class["sort"]); ?>" name="ps[<?php echo ($class["id"]); ?>][sort]" /></td>
								<td>
									<input type="text" size="15" value="<?php echo ($class["title"]); ?>"  name="ps[<?php echo ($class["id"]); ?>][title]" />&nbsp;
									<i class="icon-plus cursor_p add" title="添加子菜单" rel="<?php echo ($class["id"]); ?>">+</i>
								</td>
								<td>
									<input type="text" class="type" size="15" value="<?php echo ($class["keyword"]); ?>"  name="ps[<?php echo ($class["id"]); ?>][keyword]" />
									<input type="hidden" value="<?php echo ($class["id"]); ?>" name="ps[<?php echo ($class["id"]); ?>][pid]"/>
									<input type="hidden" class="key_type" value="1" name="ps[<?php echo ($class["id"]); ?>][type]">
								</td>
								<td>
									<input type="checkbox" name="ps[<?php echo ($class["id"]); ?>][is_show]" value="1" <?php if($class["is_show"] == 1): ?>checked="checked"<?php endif; ?> /></td>
								<td><a href="<?php echo U('wechat/class_del',array('id'=>$class['id']));?>">删除</a></td>
							</tr>
							<?php if(is_array($class['class'])): $i = 0; $__LIST__ = $class['class'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$class1): $mod = ($i % 2 );++$i;?><tr class="ztr">
									<td>
										&nbsp;&nbsp;<input type="text" size="3" value="<?php echo ($class1["sort"]); ?>" name="ps[<?php echo ($class1["id"]); ?>][sort]"/>
									</td>
									<td>
										<i class="board"></i>
										<input type="text" size="15" value="<?php echo ($class1["title"]); ?>"  name="ps[<?php echo ($class1["id"]); ?>][title]" />
									</td>
									<td>
										<input type="text" class="type" size="15" value="<?php echo ($class1["keyword"]); ?>"  name="ps[<?php echo ($class1["id"]); ?>][keyword]" />
										<input type="hidden" value="<?php echo ($class1["pid"]); ?>" name="ps[<?php echo ($class1["id"]); ?>][pid]"/>
										<input type="hidden" class="key_type" value="1" name="ps[<?php echo ($class1["id"]); ?>][type]">
									</td>
									<td>
										<input type="checkbox" name="ps[<?php echo ($class1["id"]); ?>][is_show]" value="1" <?php if($class1["is_show"] == 1): ?>checked="checked"<?php endif; ?> /></td>
									<td><a href="<?php echo U('wechat/class_del',array('id'=>$class1['id']));?>">删除</a></td>
								</tr><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>

				</div>
			</div>
		</div>
		<div class="form-actions">
			<button type="submit" class="btn btn-primary js-ajax-submit">保存</button>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<button id="create_menu" type="button"  class="btn btn-primary" style="cursor:pointer">生成微信自定义菜单</button>
		</div>
	</form>
</div>
<script type="text/javascript">
	$(window).ready(function () {
		var $add_menu = $("#add_menu");
		var $add_zmenu = $("i.add");
		var $menu_index = 0;

		$add_menu.click(function (e) {
			if($("#listTable>tbody>tr").length>2){
				return false;
			}
			e.preventDefault();
			$menu_index++;
			var _menuPtrtmp = '<tr>'
					+ ' <td>'
					+ '  <input name="new[sort][' + $menu_index + ']" size="3" type="text" value="0" class="input-mini" ata-rule-number="true" /></td>'
					+ ' <td>'
					+ '<input name="new[title][' + $menu_index + ']" size="15" type="text" class="input-medium" data-rule-required="true" data-rule-maxlength="30" /></td>'
					+ '<td>'
					+ ' <input name="new[keyword][' + $menu_index + ']" size="15" type="text" class="input-medium type" data-rule-required="true" data-rule-maxlength="500" />'
					+ '   <input type="hidden" name="new[pid][' + $menu_index + ']" value="{pid}" /></td>'
					+ '  <input type="hidden" name="new[type][' + $menu_index + ']" class="key_type" value="1" /></td>'

					+ ' <td>'
					+ '  <input type="checkbox" name="new[is_show][' + $menu_index + ']" checked="checked" value="1"/></td>'
					+ ' <td><a href="javascript:void(0)" class="del">删除</a></td>'
					+ '</tr> ';
			$("#listTable").append(_menuPtrtmp.replace("{pid}", 0));

		})
		$add_zmenu.click(function myfunction() {
			var $pid = $(this).attr("rel");
			var $thistr = $(this).parent().parent();

			var next = $thistr.nextAll("tr");
			$menu_index++;
			var _menuPtrtmp = '<tr>'
					+ ' <td>'
					+ '  <input name="new[sort][' + $menu_index + ']" size="3" type="text" value="0" class="input-mini"ata-rule-number="true" /></td>'
					+ ' <td>{z}'
					+ '<input name="new[title][' + $menu_index + ']" size="15" type="text" class="input-medium" data-rule-required="true" data-rule-maxlength="30" /></td>'
					+ '<td>'
					+ ' <input name="new[keyword][' + $menu_index + ']" size="15" type="text" class="input-medium type" data-rule-required="true" data-rule-maxlength="500" />'
					+ '  <input type="hidden" name="new[pid][' + $menu_index + ']" value="{pid}" /></td>'
					+ '  <input type="hidden" name="new[type][' + $menu_index + ']" class="key_type" value="1" /></td>'

					+ ' <td>'
					+ '  <input type="checkbox" name="new[is_show][' + $menu_index + ']" checked="checked" value="1" /></td>'
					+ ' <td><a href="javascript:void(0)" class="del">删除</a></td>'
					+ '</tr> ';
			var tp = _menuPtrtmp.replace("{pid}", $pid).replace("{z}", "<i class='board'></i>  ");
			if (next.length > 0) {
				next.first().before(tp);
			} else {
				$("#listTable").append(tp);
			}


		});
		$("#listTable").on("click",".del", function () {
			$(this).parents("tr").remove();
		});
		$("input.type").on("change", function () {
			var $this = $(this);
			var $val = $this.val();
			var $nex = $this.nextAll("input.key_type");
			var re = /^((http|https|ftp):\/\/)?(\w(\:\w)?@)?([0-9a-z_-]+\.)*?([a-z0-9-]+\.[a-z]{2,6}(\.[a-z]{2})?(\:[0-9]{2,6})?)((\/[^?#<>\/\\*":]*)+(\?[^#]*)?(#.*)?)?$/i;
			if (re.test($val)) { $nex.val(2) } else { $nex.val(1) };
		});
		$("#create_menu").click(function () {
			var $idsCheck = $("#listTable :checkbox");
			var $isnew = false;
			$idsCheck.each(function () {
				var $hidden_name = $(this).parents("tr").find("input[type=hidden]").attr("name");
				if ($hidden_name.indexOf("new") >= 0) $isnew = true; return;
			});
			if ($isnew) {
				G.ui.tips.info("当前页面存在有保存菜单 请保存后生成!")
			} else {
				var $p = 0;
				var $z = 0;
				var $ftr = $("#listTable .ptr");
				$ftr.each(function (k, v) {
					if ($p > 3) { G.ui.tips.info("1级菜单最多只能开启3个"); return false };
					if ($z > 5) { G.ui.tips.info("2级菜单最多只能开启5个"); return false };
					$z = 0;
					var $this = $(this);
					if ($this.find("input[type='checkbox']:checked").length > 0) {
						$p++;
						$this.nextUntil(".ptr").each(function () {
							if ($(this).find("input[type='checkbox']:checked").length > 0) {
								$z++;
							}
						});
						if ($z == 0 && k == $ftr.length) {
							$this.nextAll(".ztr").each(function () {
								if ($(this).find("input[type='checkbox']:checked").length > 0) {
									$z++;
								}
							});
						}
					}
				});
				if ($p > 3) { G.ui.tips.info("1级菜单最多只能开启3个"); return false };
				if ($z > 5) { G.ui.tips.info("2级菜单最多只能开启5个"); return false };
				$.get('<?php echo U("wechat/class_send");?>', {}, function (data) {
					if(data == 0)  alert('菜单创建成功');
					if(data == 1)  alert('操作失败,系统繁忙，请稍后再提交!');
					if(data == 2)  alert('非法操作');
					if(data == 40001)  alert('获取access_token时AppSecret错误，或者access_token无效');
					if(data == 40002)  alert('不合法的凭证类型');
					if(data == 40013)  alert('不合法的APPID');
					if(data == 40014)  alert('不合法的access_token');
					if(data == 40015)  alert('不合法的菜单类型');
					if(data == 40018)  alert('不合法的按钮名字长度');
					if(data == 40019)  alert('不合法的按钮KEY长度');
					if(data == 40020)  alert('不合法的按钮URL长度');
					if(data == 40021)  alert('不合法的菜单版本号');
					if(data == 40022)  alert('不合法的子菜单级数');
					if(data == 40023)  alert('不合法的子菜单按钮个数');
					if(data == 40024)  alert('不合法的子菜单按钮类型');
					if(data == 40025)  alert('不合法的子菜单按钮名字长度');
					if(data == 40026)  alert('不合法的子菜单按钮KEY长度');
					if(data == 40027)  alert('不合法的子菜单按钮URL长度');
					if(data == 40028)  alert('不合法的自定义菜单使用用户');
					if(data == 41001)  alert('	缺少access_token参数');
					if(data == 4)  alert('必须先填写微信【AppId】【 AppSecret】');
				}, 'json');
			}
		});
	});
</script>
</body>
</html>