<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="favicon.ico"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<meta http-equiv="Expires" content="0">
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="Cache-control" content="no-cache">
		<meta http-equiv="Cache" content="no-cache">
        <title><?php echo ($CONF['mallTitle']); ?>后台管理中心</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="/Public/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="/Apps/Admin/View/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="/Apps/Admin/View/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="/Apps/Admin/View/css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <script src="/Public/js/jquery.min.js"></script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="/Public/js/html5shiv.min.js"></script>
          <script src="/Public/js/respond.min.js"></script>
        <![endif]-->
        
        <script src="/Public/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="/Apps/Admin/View/js/jquery-ui.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="/Apps/Admin/View/js/AdminLTE/app.js" type="text/javascript"></script>
        <script src="/Public/js/common.js"></script>
        <script src="/Public/plugins/plugins/plugins.js"></script>
    </head>
        <script>
	      $(function () {
	    	  $('#pageContent').height(WST.pageHeight()-98);
	    	  getTask();
	      });
	      $(window).resize(function() {
	    	  $('#pageContent').height(WST.pageHeight()-98);
	      });
	      function logout(){
	    	  Plugins.confirm({ title:'信息提示',content:'您确定要退出系统吗?',okText:'确定',cancelText:'取消',okFun:function(){
	   		     Plugins.closeWindow();
	   		     Plugins.waitTips({title:'信息提示',content:'正在退出系统...'});
	   		     $.post("<?php echo U('Admin/Index/logout');?>",{},function(data,textStatus){
	   		    	  location.reload();
	   		     });
	          }});
	      }
	      function getTask(){
	    	  $.post("<?php echo U('Admin/Index/getTask');?>",{},function(data,textStatus){
	  			    var json = WST.toJson(data);
	  			    if(json.status==1){
	  			    	if(json.goodsNum>0){
	  			    		$('#goodsTips').html(json.goodsNum).show();
	  			    	}else{
	  			    		$('#goodsTips').hide();
	  			    	}
	  			    	if(json.shopsNum>0){
	  			    		$('#shopsTips').html(json.shopsNum).show();
	  			    	}else{
	  			    		$('#shopsTips').hide();
	  			    	}
	  			    	setTimeout("getTask();",10000);
	  			    }
	    	  });
	      }
	      function cleanCache(){
	    	  Plugins.waitTips({title:'信息提示',content:'正在清除缓存，请稍后...'});
	    	  $.post("<?php echo U('Admin/Index/cleanAllCache');?>",{},function(data,textStatus){
	    		  var json = WST.toJson(data);
	    		  if(json.status==1)Plugins.setWaitTipsMsg({content:'缓存清除成功!',timeout:1000});
	    	  });
	      }
	    </script>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="#" class="logo">
                QianPok Mall
            </a>
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="<?php echo WSTDomain();?>" target='_blank'>
                                <i class="glyphicon glyphicon-home"></i>
                                <span>前台&nbsp;</span>
                            </a>
                        </li>
                        <li class="dropdown user user-menu">
                            <a href="javascript:cleanCache()">
                                <i class="glyphicon glyphicon glyphicon-refresh"></i>
                                <span>清除缓存</span>
                            </a>
                        </li>
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo session('WST_STAFF.staffName');?>&nbsp;<i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="/<?php echo session('WST_STAFF.staffPhoto');?>" class="img-circle" alt="<?php echo session('WST_STAFF.roleName');?>" />
                                    <p>
                                        <?php echo session('WST_STAFF.staffName');?> - <?php echo session('WST_STAFF.roleName');?>
                                        <small>职员编号：<?php echo ($WST_STAFF["staffNo"]); ?></small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <li class="user-body" style='display:none'>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?php echo U('Admin/Staffs/toEditPass');?>" target='pageContent' class="btn btn-default btn-flat">修改密码</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="javascript:logout()" class="btn btn-default btn-flat">退出系统</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="/<?php echo session('WST_STAFF.staffPhoto');?>" class="img-circle" alt="<?php echo session('WST_STAFF.staffName');?>" />
                        </div>
                        <div class="pull-left info">
                            <p>Hello, <?php echo session('WST_STAFF.staffName');?></p>
                        </div>
                    </div>
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <?php if(in_array('spgl_00',$WST_STAFF['grant'])){ ?>
                        <li class="treeview">
                            <a href="#">
                                <span>商品管理</span>
                                <small id='goodsTips' style='display:none' class="badge pull-right bg-green">0</small>
                            </a>
                            <ul class="treeview-menu">
                                <?php if(in_array('spfl_00',$WST_STAFF['grant'])){ ?>
                                <li><a href="<?php echo U('Admin/GoodsCats/index');?>" target='pageContent'>商品分类</a></li>
                                <?php } ?>
                                <?php if(in_array('ppgl_00',$WST_STAFF['grant'])){ ?>
					            <li><a href="<?php echo U('Admin/Brands/index');?>" target='pageContent'>品牌管理</a></li>
					            <?php } ?>
                                <?php if(in_array('splb_00',$WST_STAFF['grant'])){ ?>
					            <li><a href="<?php echo U('Admin/Goods/index');?>" target='pageContent'>商品列表</a></li>
					            <?php } ?>
                                <?php if(in_array('spsh_00',$WST_STAFF['grant'])){ ?>
					            <li><a href="<?php echo U('Admin/Goods/queryPenddingByPage');?>" target='pageContent'>商品审核</a></li>
					            <?php } ?>
                                <?php if(in_array('sppl_00',$WST_STAFF['grant'])){ ?>
					            <li><a href="<?php echo U('Admin/GoodsAppraises/index');?>" target='pageContent'>商品评价</a></li>
					            <?php } ?>
                            </ul>
                        </li>
                        <?php } ?>
                        <?php if(in_array('ddgl_00',$WST_STAFF['grant'])){ ?>
                        <li class="treeview">
                            <a href="#">
                                <span>订单管理</span>
                            </a>
                            <ul class="treeview-menu">
                                <?php if(in_array('ddlb_00',$WST_STAFF['grant'])){ ?>
                                <li><a href="<?php echo U('Admin/Orders/index');?>" target='pageContent' >订单列表</a></li>
                                <?php } ?>
                                <?php if(in_array('ddts_00',$WST_STAFF['grant'])){ ?>
                                <li><a href="<?php echo U('Admin/OrderComplains/index');?>" target='pageContent' >订单投诉</a></li>
                                <?php } ?>
                                <?php if(in_array('tk_00',$WST_STAFF['grant'])){ ?>
                                <li><a href="<?php echo U('Admin/Orders/queryRefundByPage');?>" target='pageContent' >退款列表</a></li>
                                <?php } ?>
                                <?php if(in_array('js_00',$WST_STAFF['grant'])){ ?>
                                <li><a href="<?php echo U('Admin/OrderSettlements/index');?>" target='pageContent' >订单结算</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php } ?>

                        <?php if(in_array('dpgl_00',$WST_STAFF['grant'])){ ?>
                        <li class="treeview">
                            <a href="#">
                                <span>店铺管理</span>
                                <small id='shopsTips' style='display:none' class="badge pull-right bg-green">3</small>
                            </a>
                            <ul class="treeview-menu">
                                <?php if(in_array('dplb_01',$WST_STAFF['grant'])){ ?>
                                <li><a href="<?php echo U('Admin/Shops/toEdit');?>" target='pageContent' >添加店铺</a></li>
                                <?php } ?>
                                <?php if(in_array('dplb_00',$WST_STAFF['grant'])){ ?>
					            <li><a href="<?php echo U('Admin/Shops/index');?>" target='pageContent' >店铺列表</a></li>
					            <?php } ?>
                                <?php if(in_array('dpsh_00',$WST_STAFF['grant'])){ ?>
					            <li><a href="<?php echo U('Admin/Shops/queryPeddingByPage');?>" target='pageContent' >店铺审核</a></li>
					            <?php } ?>
                            </ul>
                        </li>
                        <?php } ?>

                        <?php if(in_array('yxgl_00',$WST_STAFF['grant'])){ ?>
                        <li class="treeview">
                            <a href="pages/mailbox.html">
                                <span>营销管理</span>
                            </a>
                            <ul class="treeview-menu">
                                <?php if(in_array('yhqlb_00',$WST_STAFF['grant'])){ ?>
                                <li><a href="<?php echo U('Admin/Coupon/index');?>" target='pageContent' >优惠券列表</a></li>
                                <?php } ?>
                                <?php if(in_array('yhqlb_01',$WST_STAFF['grant'])){ ?>
                                <li><a href="<?php echo U('Admin/Coupon/toEdit');?>" target='pageContent' >添加优惠券</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php } ?>

                        <?php if(in_array('hdgl_00',$WST_STAFF['grant'])){ ?>
                        <li class="treeview">
                            <a href="pages/mailbox.html">
                                <span> 活动管理</span>
                            </a>
                            <ul class="treeview-menu">
                                <?php if(in_array('hdlb_00',$WST_STAFF['grant'])){ ?>
                                <li><a href="<?php echo U('Admin/Activity/index');?>" target='pageContent' >活动列表</a></li>
                                <?php } ?>
                                <?php if(in_array('hdfl_00',$WST_STAFF['grant'])){ ?>
                                <li><a href="<?php echo U('Admin/ActivityCats/index');?>" target='pageContent' >活动分类</a></li>
                                <?php } ?>
                                <?php if(in_array('hdlb_01',$WST_STAFF['grant'])){ ?>
                                <li><a href="<?php echo U('Admin/Activity/toEdit');?>" target='pageContent' >添加活动</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php } ?>

                        <?php if(in_array('hygl_00',$WST_STAFF['grant'])){ ?>
                        <li class="treeview">
                            <a href="#">
                                <span>会员管理</span>
                            </a>
                            <ul class="treeview-menu">
                                <?php if(in_array('hydj_00',$WST_STAFF['grant'])){ ?>
                                <li><a href="<?php echo U('Admin/UserRanks/index');?>" target='pageContent' >会员等级</a></li>
                                <?php } ?>
                                <?php if(in_array('hylb_00',$WST_STAFF['grant'])){ ?>
                                <li><a href="<?php echo U('Admin/Users/index');?>" target='pageContent' >会员列表</a></li>
                                <?php } ?>
                                <?php if(in_array('hylb_01',$WST_STAFF['grant'])){ ?>
                                <li><a href="<?php echo U('Admin/Users/toEdit/');?>" target='pageContent'>添加会员</a></li>
                                <?php } ?>
                                <?php if(in_array('hyzh_00',$WST_STAFF['grant'])){ ?>
                                <li><a href="<?php echo U('Admin/Users/queryAccountByPage');?>" target='pageContent' >账号管理</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php } ?>
                        <?php if(in_array('bbtj_00',$WST_STAFF['grant'])){ ?>
                        <li class="treeview">
                            <a href="#">
                                <span>报表统计</span>
                            </a>
                            <ul class="treeview-menu">
                                <?php if(in_array('dttj_00',$WST_STAFF['grant'])){ ?>
                                <li><a href="<?php echo U('Admin/OrderRpts/index');?>" target='pageContent' >订单统计</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php } ?>

                        <?php if(in_array('wzgl_00',$WST_STAFF['grant'])){ ?>
                        <li class="treeview">
                            <a href="pages/mailbox.html">
                                <span> 文章管理</span>
                            </a>
                            <ul class="treeview-menu">
                               <?php if(in_array('wzlb_00',$WST_STAFF['grant'])){ ?>
                               <li><a href="<?php echo U('Admin/Articles/index');?>" target='pageContent' >文章列表</a></li>
                               <?php } ?>
                               <?php if(in_array('wzfl_00',$WST_STAFF['grant'])){ ?>
					           <li><a href="<?php echo U('Admin/ArticleCats/index');?>" target='pageContent' >文章分类</a></li>
					           <?php } ?>
                               <?php if(in_array('wzlb_01',$WST_STAFF['grant'])){ ?>
					           <li><a href="<?php echo U('Admin/Articles/toEdit');?>" target='pageContent' >添加文章</a></li>
					           <?php } ?>
                            </ul>
                        </li>
                        <?php } ?>

                        <?php if(in_array('xtgl_00',$WST_STAFF['grant'])){ ?>
                        <li class="treeview">
                            <a href="#">
                                <span>系统管理</span>
                            </a>
                            <ul class="treeview-menu">
                                <?php if(in_array('jsgl_00',$WST_STAFF['grant'])){ ?>
                                <li><a href="<?php echo U('Admin/Roles/index');?>" target='pageContent' >角色管理</a></li>
                                <?php } ?>
                                <?php if(in_array('zylb_00',$WST_STAFF['grant'])){ ?>
					            <li><a href="<?php echo U('Admin/Staffs/index');?>" target='pageContent' >职员管理</a></li>
					            <?php } ?>
                                <?php if(in_array('dlrz_00',$WST_STAFF['grant'])){ ?>
					            <li><a href="<?php echo U('Admin/LogLogins/index');?>" target='pageContent' >登录日志</a></li>
					            <?php } ?>
                            </ul>
                        </li>
                        <?php } ?>
                        <?php if(in_array('scsz_00',$WST_STAFF['grant'])){ ?>
                        <li class="treeview">
                            <a href="#">
                                <span>商城设置</span>
                            </a>
                            <ul class="treeview-menu">
                                <?php if(in_array('scxx_00',$WST_STAFF['grant'])){ ?>
                                <li><a href="<?php echo U('Admin/Index/toMallConfig');?>" target='pageContent' >商城信息</a></li>
                                <?php } ?>
                                <?php if(in_array('dhgl_00',$WST_STAFF['grant'])){ ?>
                                <li><a href="<?php echo U('Admin/Navs/index');?>" target='pageContent' >导航管理</a></li>
                                <?php } ?>
                                <?php if(in_array('yqlj_00',$WST_STAFF['grant'])){ ?>
                                <li><a href="<?php echo U('Admin/Friendlinks/index');?>" target='pageContent'>友情链接</a></li>
                                <?php } ?>
                                <?php if(in_array('gggl_00',$WST_STAFF['grant'])){ ?>
                                <li><a href="<?php echo U('Admin/Ads/index');?>" target='pageContent'>广告管理</a></li>
                                <?php } ?>
                                <?php if(in_array('yhgl_00',$WST_STAFF['grant'])){ ?>
                                <li><a href="<?php echo U('Admin/Banks/index');?>" target='pageContent'>银行管理</a></li>
                                <?php } ?>
                                <?php if(in_array('zfgl_00',$WST_STAFF['grant'])){ ?>
                                <li><a href="<?php echo U('Admin/Payments/index');?>" target='pageContent'>支付管理</a></li>
                                <?php } ?>

                            </ul>
                        </li>
                        <?php } ?>
                        <?php if(in_array('wxsz_00',$WST_STAFF['grant'])){ ?>
                        <li class="treeview">
                            <a href="#">
                                <span>微信设置</span>
                            </a>
                            <ul class="treeview-menu">

                                <?php if(in_array('wxcd_00',$WST_STAFF['grant'])){ ?>
                                <li><a href="<?php echo U('Admin/Wechat/menu');?>" target='pageContent' >微信菜单</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php } ?>

                        <?php if(in_array('dqgl_00',$WST_STAFF['grant'])){ ?>
                        <li class="treeview">
                            <a href="pages/calendar.html">
                                <span>地区管理</span>
                            </a>
                            <ul class="treeview-menu">
                                <?php if(in_array('dqlb_00',$WST_STAFF['grant'])){ ?>
                                <li><a href="<?php echo U('Admin/Areas/index');?>" target='pageContent' >地区管理</a></li>
                                <?php } ?>
                                <?php if(in_array('sqlb_00',$WST_STAFF['grant'])){ ?>
                                <li><a href="<?php echo U('Admin/Communitys/index');?>" target='pageContent' >社区列表</a></li>
                                <?php } ?>
                                <?php if(in_array('sqlb_01',$WST_STAFF['grant'])){ ?>
                                <li><a href="<?php echo U('Admin/Communitys/toEdit');?>" target='pageContent' >添加社区</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php } ?>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <small>后台管理中心</small>
                    </h1>
                </section>

                <!-- Main content -->
                <section class="content" style='margin:0px;padding:0px;'>
                    <iframe id='pageContent' name='pageContent' src="<?php echo U('Admin/Index/toMain');?>" width='100%' height='100%' frameborder="0"></iframe>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
    </body>
</html>