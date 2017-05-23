<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title><?php echo ($CONF['shopTitle']['fieldValue']); ?>后台管理中心</title>
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
      <script src="/Public/plugins/formValidator/formValidator-4.1.3.js"></script>
      <script src="/Public/plugins/kindeditor/kindeditor.js"></script>
      <script src="/Public/plugins/kindeditor/lang/zh_CN.js"></script>

       <script src="/Apps/Home/View/default/js/common.js"></script>
       <script src="/Public/plugins/layer/layer.min.js"></script>
       <link rel="stylesheet" type="text/css" href="/Public/plugins/webuploader/style.css" />
       <link rel="stylesheet" type="text/css" href="/Public/plugins/webuploader/webuploader.css" />
       <script type="text/javascript" src="/Public/plugins/webuploader/webuploader.js"></script>
       <script type="text/javascript" src="/Apps/Home/View/default/js/goodsbatchupload.js"></script>
       <script>
           var GV = {
               DIMAUB: "/",
               JS_ROOT: "Public/js/",
               TOKEN: ""
           };
       </script>
       <script  type="text/javascript"  src="/Public/js/wind.js"></script>
       <script  type="text/javascript"  src="/Public/js/datePicker/datePicker.js"></script>

   </head>
   <script>
   $(function () {
	   KindEditor.ready(function(K) {
			editor1 = K.create('textarea[name="activityContent"]', {
				height:'350px',
				allowFileManager : false,
				allowImageUpload : true,
				items:[
				        'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
				        'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
				        'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
				        'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
				        'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
				        'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|','image','table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
				        'anchor', 'link', 'unlink', '|', 'about'
				],
				afterBlur: function(){ this.sync(); }
			});
		});

       var uploading = null;
       uploadFile({
           server:"<?php echo U('Admin/Activity/uploadPic');?>",pick:'#goodImgPicker',
           formData: {dir:'Activity'},
           callback:function(f){
               layer.close(uploading);
               var json = WST.toJson(f);
               $('#goodsImgPreview').attr('src',"/"+json.file.savepath+json.file.savename);
               $('#goodsImg').val(json.file.savepath+json.file.savename);
               $('#goodsThums').val(json.file.savepath+json.file.savethumbname);
               $('#goodsImgPreview').show();
           },
           progress:function(rate){
               uploading = WST.msg('正在上传图片，请稍后...');
           }
       });

	   $.formValidator.initConfig({
		   theme:'Default',mode:'AutoTip',formID:"myform",debug:true,submitOnce:true,onSuccess:function(){
				   edit();
			       return false;
			},onError:function(msg){
		}});
	   $("#activityTitle").formValidator({onFocus:"请输入活动标题"}).inputValidator({min:1,max:100,onError:"请输入100字以内活动标题"});
	   $("#catId").formValidator({onFocus:"请选择活动分类"}).inputValidator({min:1,onError: "请选择活动分类"});
       $("#activityKey").formValidator({onFocus:"请输入活动联系人"}).inputValidator({min:1,max:80,onError:"请输入活动联系人"});
       $("#activityMobile").formValidator({onFocus:"请输入活动联系电话"}).inputValidator({min:1,max:80,onError:"请输入活动联系电话"});
       $("#activityAddress").formValidator({onFocus:"请输入活动地址"}).inputValidator({min:1,max:80,onError:"请输入活动地址"});
       $("#expenditure").formValidator({onFocus:"请输入活动经费"}).inputValidator({min:1,max:80,onError:"请输入活动经费"});
       $("#prepay").formValidator({onFocus:"请输入活动费用/人"}).inputValidator({min:1,max:80,onError:"请输入活动费用/人"});
       $("#user_num").formValidator({onFocus:"请输入活动预报名人数"}).inputValidator({min:1,max:80,onError:"请输入活动预报名人数"});
       $("#title").formValidator({onFocus:"请输入微信分享标题"}).inputValidator({min:1,max:80,onError:"请输入微信分享标题"});
       $("#desc").formValidator({onFocus:"请输入微信分享描述"}).inputValidator({min:1,max:80,onError:"请输入微信分享描述"});

   });


   function imglimouseover(obj){
       if(!$(obj).find('.file-panel').html()){
           $(obj).find('.setdel').addClass('trconb');
           $(obj).find('.setdel').css({"display":""});
       }
   }

   function imglimouseout(obj){

       $(obj).find('.setdel').removeClass('trconb');
       $(obj).find('.setdel').css({"display":"none"});
   }

   function imglidel(obj){
       if (confirm('是否删除图片?')) {
           $(obj).parent().remove("li");
           return;
       }
   }

   function imgmouseover(obj){
       $(obj).find('.wst-gallery-goods-del').show();
   }
   function imgmouseout(obj){
       $(obj).find('.wst-gallery-goods-del').hide();
   }
   function delImg(obj){
       $(obj).parent().remove();
   }


   function edit(){
	   var params = {};
	   params.id = $('#id').val();
	   params.activityTitle = $('#activityTitle').val();
	   params.catId = $('#catId').val();
	   params.isShow = $("input[name='isShow']:checked").val();
	   params.flow = $('#activityContent').val();
	   params.initiator = $('#activityKey').val();
       params.mobile = $('#activityMobile').val();
       params.address = $('#activityAddress').val();
       params.expenditure = $('#expenditure').val();
       params.prepay = $('#prepay').val();
       params.user_num = $('#user_num').val();
       params.title = $('#title').val();
       params.desc = $('#desc').val();
       params.start_time = $('#start_time').val();
       params.end_time = $('#end_time').val();
       params.end_apply = $('#end_apply').val();
       params.picurl = $('#goodsImg').val();
	   if(params.flow==''){
		   Plugins.Tips({title:'信息提示',icon:'error',content:'请输入活动内容!',timeout:1000});
		   return;
	   }
	   Plugins.waitTips({title:'信息提示',content:'正在提交数据，请稍后...'});
	   $.post("<?php echo U('Admin/Activity/edit');?>",params,function(data,textStatus){
			var json = WST.toJson(data);
			if(json.status=='1'){
				Plugins.setWaitTipsMsg({ content:'操作成功',timeout:1000,callback:function(){
				   location.href="<?php echo U('Admin/Activity/index');?>";
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
        <input type='hidden' id='id' value='<?php echo ($object["activityId"]); ?>'/>
        <table class="table table-hover table-striped table-bordered wst-form">
           <tr>
             <th width='120' align='right'>活动标题<font color='red'>*</font>：</th>
             <td><input type='text' id='activityTitle' class="form-control wst-ipt" value='<?php echo ($object["activityTitle"]); ?>' maxLength='25'/></td>
           </tr>
           <tr>
             <th align='right'>分类<font color='red'>*</font>：</th>
             <td>
             <select id='catId'>
                <option value=''>请选择</option>
                <?php if(is_array($catList)): $i = 0; $__LIST__ = $catList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value='<?php echo ($vo['catId']); ?>' <?php if($object['catId'] == $vo['catId'] ): ?>selected<?php endif; ?>><?php echo ($vo['catName']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
             </select>
             </td>
           </tr>
            <tr>
                <th width='120'>活动图片<font color='red'></font>：</th>
                <td >
                    <div>
                        <img id='goodsImgPreview' src='<?php if($object['picurl'] =='' ): ?>/<?php echo ($CONF['goodsImg']); else: ?>/<?php echo ($object['picurl']); endif; ?>' height='152'/><br/>
                    </div>
                    <input type='hidden' id='goodsImg' class='wstipt' value='<?php echo ($object["picurl"]); ?>'/>
                    <input type='hidden' id='goodsThums' class='wstipt' value='<?php echo ($object["goodsThums"]); ?>'/>
                    <div id="goodImgPicker" style='margin-left:0px;margin-top:5px;height:30px;overflow:hidden'>上传活动图片</div>
                    <div>图片大小:150 x 150 (px)，格式为 gif, jpg, jpeg, png</div>
                </td>
            </tr>
           <tr>
             <th align='right'>是否显示<font color='red'>*</font>：</th>
             <td>
             <label>
             <input type='radio' id='isShow1' name='isShow' value='1' <?php if($object['isShow'] ==1 ): ?>checked<?php endif; ?> />显示&nbsp;&nbsp;
             </label>
             <label>
             <input type='radio' id='isShow0' name='isShow' value='0' <?php if($object['isShow'] ==0 ): ?>checked<?php endif; ?> />隐藏
             </label>
             </td>
           </tr>
            <tr>
                <th align='right'>活动联系人<font color='red'>*</font>：</th>
                <td>
                    <input type='text' id='activityKey' class="form-control wst-ipt" value='<?php echo ($object["initiator"]); ?>' maxLength='80'/>
                </td>
            </tr>
            <tr>
                <th align='right'>活动联系电话<font color='red'>*</font>：</th>
                <td>
                    <input type='text' id='activityMobile' class="form-control wst-ipt" value='<?php echo ($object["mobile"]); ?>' maxLength='80'/>
                </td>
            </tr>
            <tr>
                <th align='right'>活动地点<font color='red'>*</font>：</th>
                <td>
                    <input type='text' id='activityAddress' class="form-control wst-ipt" value='<?php echo ($object["address"]); ?>' maxLength='80'/>
                </td>
            </tr>
            <tr>
                <th align='right'>活动经费<font color='red'>*</font>：</th>
                <td>
                    <input type='text' id='expenditure' class="form-control wst-ipt" value='<?php echo ($object["expenditure"]); ?>' maxLength='80'/>
                </td>
            </tr>
            <tr>
                <th align='right'>活动费用/人<font color='red'>*</font>：</th>
                <td>
                    <input type='text' id='prepay' class="form-control wst-ipt" value='<?php echo ($object["prepay"]); ?>' maxLength='80'/>
                </td>
            </tr>
            <tr>
                <th align='right'>活动预报名人数<font color='red'>*</font>：</th>
                <td>
                    <input type='text' id='user_num' class="form-control wst-ipt" value='<?php echo ($object["user_num"]); ?>'/>
                </td>
            </tr>
            <tr>
                <th align='right'>活动微信分享标题<font color='red'>*</font>：</th>
                <td>
                    <input type='text' id='title' class="form-control wst-ipt" value='<?php echo ($object["title"]); ?>' maxLength='80'/>
                </td>
            </tr>
            <tr>
                <th align='right'>活动微信分享描述<font color='red'>*</font>：</th>
                <td>
                    <textarea id="desc" maxLength='80' style="width: 360px;height: 100px;"><?php echo ($object["desc"]); ?></textarea>
                    <!--<input type='text' id='desc' class="form-control wst-ipt" value='<?php echo ($object["desc"]); ?>' maxLength='80'/>-->
                </td>
            </tr>
            <tr>
                <th align='right'>活动开始时间-结束时间<font color='red'>*</font>：</th>
                <td>
                    <!--<input type='text' id='start_time' class="form-control wst-ipt" value='<?php echo ((isset($object["start_time"]) && ($object["start_time"] !== ""))?($object["start_time"]):"2016-01-01 00:00"); ?>' />-->
                    <input type='text' id='start_time' name='start_time' class="wstipt wst-ipt js-datetime" value='<?php echo ((isset($object["start_time"]) && ($object["start_time"] !== ""))?($object["start_time"]):"2016-01-01 00:00"); ?>'/>
                    <!--~ <input type='text' id='end_time' class="form-control wst-ipt" value='<?php echo ((isset($object["end_time"]) && ($object["end_time"] !== ""))?($object["end_time"]):"2016-01-01 00:00"); ?>' />-->
                    ~ <input type='text' id='end_time' name='end_time' class="wstipt wst-ipt js-datetime" value='<?php echo ((isset($object["start_time"]) && ($object["start_time"] !== ""))?($object["start_time"]):"2016-01-01 00:00"); ?>'/>
                </td>
            </tr>
            <tr>
                <th align='right'>报名结束时间<font color='red'>*</font>：</th>
                <td>
                    <input type='text' id='end_apply' name='end_apply' class="wstipt wst-ipt js-datetime" value='<?php echo ((isset($object["end_apply"]) && ($object["end_apply"] !== ""))?($object["end_apply"]):"2016-01-01 00:00"); ?>'/>
                </td>
            </tr>
            <tr>
                <th align='right'>内容<font color='red'>*</font>：</th>
                <td>
                    <textarea id='activityContent' name='activityContent' style='width:80%;height:400px;'><?php echo ($object["flow"]); ?></textarea>
                </td>
            </tr>

           <tr>
             <td colspan='2' style='padding-left:250px;'>
                 <button type="submit" class="btn btn-success">保&nbsp;存</button>
                 <button type="button" class="btn btn-primary" onclick='javascript:location.href="<?php echo U('Admin/Activity/index');?>"'>返&nbsp;回</button>
             </td>
           </tr>
        </table>
       </form>
       <script>
           $(function(){
               //日期选择器
               var dateInput = $("input.js-date")
               if (dateInput.length) {
                   Wind.use('datePicker', function () {
                       dateInput.datePicker();
                   });
               }

               //日期+时间选择器
               var dateTimeInput = $("input.js-datetime");
               if (dateTimeInput.length) {
                   Wind.use('datePicker', function () {
                       dateTimeInput.datePicker({
                           time: true
                       });
                   });
               }
           })
       </script>
   </body>
</html>