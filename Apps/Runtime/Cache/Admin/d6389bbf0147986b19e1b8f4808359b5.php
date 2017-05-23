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
      <script src="/Public/plugins/formValidator/formValidator-4.1.3.js"></script>
      <script src="/Public/js/common.js"></script>
      <script src="/Public/plugins/plugins/plugins.js"></script>
       <script src="/Apps/Home/View/default/js/common.js"></script>
       <script src="/Public/plugins/layer/layer.min.js"></script>
       <link rel="stylesheet" type="text/css" href="/Public/plugins/webuploader/style.css" />
       <link rel="stylesheet" type="text/css" href="/Public/plugins/webuploader/webuploader.css" />
       <script type="text/javascript" src="/Public/plugins/webuploader/webuploader.js"></script>
       <script type="text/javascript" src="/Apps/Home/View/default/js/goodsbatchupload.js"></script>
   </head>
   <script>
   $(function () {
	   $.formValidator.initConfig({
		   theme:'Default',mode:'AutoTip',formID:"myform",debug:true,submitOnce:true,onSuccess:function(){
				   edit();
			       return false;
			},onError:function(msg){
		}});
	   $("#catName").formValidator({onShow:"",onFocus:"",onCorrect:"输入正确"}).inputValidator({min:1,max:20,onError:"商品分类不能超过20个字符"});
       var uploading = null;
       uploadFile({
           server:"<?php echo U('Admin/GoodsCats/uploadPic');?>",pick:'#goodImgPicker',
           formData: {dir:'GoodsCats'},
           callback:function(f){
               layer.close(uploading);
               var json = WST.toJson(f);
               $('#goodsImgPreview').attr('src',"/"+json.file.savepath+json.file.savename);
               $('#catImg').val(json.file.savepath+json.file.savename);
               $('#goodsImgPreview').show();
           },
           progress:function(rate){
               uploading = WST.msg('正在上传图片，请稍后...');
           }
       });
   });
   function edit(){
	   var params = {};
	   params.id = $('#id').val();
	   params.parentId = $('#parentId').val();
       params.catName = $('#catName').val();
       params.catImg = $('#catImg').val();
	   params.priceSection = $('#priceSection').val();
	   params.isShow = $('input[name="isShow"]:checked').val();;
	   params.catSort = $('#catSort').val();
	   Plugins.waitTips({title:'信息提示',content:'正在提交数据，请稍后...'});
	   $.post("<?php echo U('Admin/GoodsCats/edit');?>",params,function(data,textStatus){
			var json = WST.toJson(data);
			if(json.status=='1'){
				Plugins.setWaitTipsMsg({ content:'操作成功',timeout:1000,callback:function(){
				   location.href='<?php echo U("Admin/GoodsCats/index");?>';
				}});
			}else{
				Plugins.closeWindow();
				Plugins.Tips({title:'信息提示',icon:'error',content:'操作失败!',timeout:1000});
			}
	   });
   }
   
   </script>
   <body class="wst-page">
       <form name="myform" method="post" id="myform" autocomplete="off">
        <input type='hidden' id='id' value='<?php echo ($object["catId"]); ?>'/>
        <input type='hidden' id='parentId' value='<?php echo ($object["parentId"]); ?>'/>
        <table class="table table-hover table-striped table-bordered wst-form">
           <tr>
             <th width='120' align='right'>商品分类名称<font color='red'>*</font>：</th>
             <td><input type='text' id='catName' class="form-control wst-ipt" value='<?php echo ($object["catName"]); ?>' maxLength='25'/></td>
           </tr>
            <tr>
                <th width='120'>分类图片<font color='red'></font>：</th>
                <td >
                    <div>
                        <img id='goodsImgPreview' src='<?php if($object['catImg'] =='' ): ?>/<?php echo ($CONF['goodsImg']); else: ?>/<?php echo ($object['catImg']); endif; ?>' height='152'/><br/>
                    </div>
                    <input type='hidden' id='catImg' class='wstipt' value='<?php echo ($object["catImg"]); ?>'/>
                    <div id="goodImgPicker" style='margin-left:0px;margin-top:5px;height:30px;overflow:hidden'>上传活动图片</div>
                    <div>图片大小:150 x 150 (px)，格式为 gif, jpg, jpeg, png</div>
                </td>
            </tr>
           <tr>
             <th align='right'>是否显示<font color='red'>*</font>：</th>
             <td>
             <label>
             <input type='radio' id='isShow1' value='1' name='isShow' <?php if($object['isShow'] ==1 ): ?>checked<?php endif; ?>/>显示
             </label>
             <label>
             <input type='radio' id='isShow0' value='0' name='isShow' <?php if($object['isShow'] ==0 ): ?>checked<?php endif; ?>/>隐藏
             </label>
             </td>
           </tr>
           <tr>
             <th align='right'>排序号：</th>
             <td><input type='text' id='catSort' class="form-control wst-ipt" value='<?php echo ($object["catSort"]); ?>' style='width:80px' onkeypress="return WST.isNumberKey(event)" onkeyup="javascript:WST.isChinese(this,1)" maxLength='8'/></td>
           </tr>
           <tr>
             <td colspan='2' style='padding-left:250px;'>
                 <button type="submit" class="btn btn-success">保&nbsp;存</button>
                  <a class="btn btn-primary" href='<?php echo U("Admin/GoodsCats/index");?>'>返&nbsp;回</button>
             </td>
           </tr>
        </table>
       </form>
   </body>
</html>