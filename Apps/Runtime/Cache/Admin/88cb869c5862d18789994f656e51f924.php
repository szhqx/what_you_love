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
   </head>
   <script>
   function getAreaList(objId,parentId,t,id){
	   var params = {};
	   params.parentId = parentId;
	   $('#'+objId).empty();
	   if(t<1){
		   $('#areaId3').empty();
		   $('#areaId3').html('<option value="">请选择</option>');
	   }
	   var html = [];
	   $.post("<?php echo U('Admin/Areas/queryByList');?>",params,function(data,textStatus){
		    html.push('<option value="">请选择</option>');
			var json = WST.toJson(data);
			if(json.status=='1' && json.list.length>0){
				var opts = null;
				for(var i=0;i<json.list.length;i++){
					opts = json.list[i];
					html.push('<option value="'+opts.areaId+'" '+((id==opts.areaId)?'selected':'')+'>'+opts.areaName+'</option>');
				}
			}
			$('#'+objId).html(html.join(''));
	   });
   }
   $(function(){
       <?php if($areaId1!=0){ ?>
	   getAreaList("areaId2",'<?php echo ($areaId1); ?>',0,'<?php echo ($areaId2); ?>');
	   <?php } ?>  
	   <?php if($areaId2 != 0){ ?>
	   getAreaList("areaId3",'<?php echo ($areaId2); ?>',1,'<?php echo ($areaId3); ?>');
	   <?php } ?>
	   $('#orderStatus').val(<?php echo ($orderStatus); ?>);
   });
   function settlement(url){
	   Plugins.Modal({url:url,title:'结算订单',width:600});
   }
   </script>
   <body class='wst-page'>
      <form method="post" action='<?php echo U("Admin/OrderSettlements/index");?>'>
       <div class='wst-tbar'>
                             地区：<select name='areaId1' id='areaId1' onchange='javascript:getAreaList("areaId2",this.value,0)'>
             <option value=''>请选择</option>
             <?php if(is_array($areaList)): $i = 0; $__LIST__ = $areaList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value='<?php echo ($vo['areaId']); ?>' <?php if($areaId1 == $vo['areaId'] ): ?>selected<?php endif; ?>><?php echo ($vo['areaName']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
          </select>
          <select name='areaId2' id='areaId2' onchange='javascript:getAreaList("areaId3",this.value,1);'>
             <option value=''>请选择</option>
          </select>
          <select name='areaId3' id='areaId3'>
             <option value=''>请选择</option>
          </select>
       </div>
       <div class='wst-tbar'>
       结算编号：<input type='text' name='settlementNo' id='settlementNo' value='<?php echo ($settlementNo); ?>'/>  
     结算状态：  <select name='isFinish' id='isFinish'>
             <option value='-1'  <?php if($isFinish == -1 ): ?>selected<?php endif; ?>>请选择</option>
             <option value='0' <?php if($isFinish == 0 ): ?>selected<?php endif; ?>>未结算</option>
             <option value='1' <?php if($isFinish == 1 ): ?>selected<?php endif; ?>>已结算</option>
         </select>
       <button type="submit" class="btn btn-primary glyphicon glyphicon-search">查询</button> 
       </div>
       </form>
       <div class="wst-body"> 
        <table class="table table-hover table-striped table-bordered wst-list">
           <thead>
             <tr>
               <th width='40'>序号</th>
               <th width='120'>用户昵称</th>
               <th width='80'>分成总价</th>
               <th width='120'>来自一层的钱</th>
               <th width='120'>来自二层的钱</th>
               <th width='120'>来自三层的钱</th>
               <th width='120'>来自四层的钱</th>
               <th width='120'>来自五层的钱</th>
               <th width='120'>来自六层的钱</th>
               <th width='120'>来自七层的钱</th>
               <th width='120'>来自八层的钱</th>
               <th width='120'>来自九层的钱</th>
                 <th width='120'>大边用户ID</th>
                 <th width='120'>大边总人数</th>
                 <th width='80'>总人数</th>
               <th width='100'>结算日期</th>
               <!--<th width='130'>操作</th>-->
             </tr>
           </thead>
           <tbody>
           <?php if(is_array($Page['root'])): $key = 0; $__LIST__ = $Page['root'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;?><tr>
               <td><?php echo ($key); ?></td>
               <td><?php if($vo['user_id'] == 1): ?>奖金池<?php else: if($vo['nickName'] == ''): ?>嘻粉_<?php echo ($vo['user_id']); else: echo ($vo['nickName']); endif; endif; ?></td>
               <td><?php echo ($vo['profit']); ?></td>
                 <td><?php echo ($vo['p_a']); ?></td>
                 <td><?php echo ($vo['p_b']); ?></td>
                 <td><?php echo ($vo['p_c']); ?></td>
                 <td><?php echo ($vo['p_d']); ?></td>
                 <td><?php echo ($vo['p_e']); ?></td>
                 <td><?php echo ($vo['p_f']); ?></td>
                 <td><?php echo ($vo['p_g']); ?></td>
                 <td><?php echo ($vo['p_h']); ?></td>
                 <td><?php echo ($vo['p_j']); ?></td>
               <td><?php echo ($vo['maxUser']); ?></td>
               <td><?php echo ($vo['maxCount']); ?></td>
               <td><?php echo ($vo['minCount']+$vo['maxCount']); ?></td>
                 <td><?php echo ($vo['dataTime']); ?></td>

               <!--<td>-->
               <!--<a class="btn btn-primary glyphicon" href="<?php echo U('Admin/OrderSettlements/toView',array('id'=>$vo['settlementId']));?>"">查看</a>-->
               <!--<?php if($vo['isFinish'] ==0 ): ?>-->
               <!--<?php if(in_array('js_04',$WST_STAFF['grant'])){ ?>-->
               <!--<a class="btn btn-primary glyphicon" href="javascript:settlement('<?php echo U('Admin/OrderSettlements/toSettlement',array('id'=>$vo['settlementId']));?>')"">结算</a>-->
               <!--<?php } ?>-->
               <!--<?php endif; ?>-->
               <!--</td>-->
             </tr><?php endforeach; endif; else: echo "" ;endif; ?>
             <tr>
                <td colspan='10' align='center'><?php echo ($Page['pager']); ?></td>
             </tr>
           </tbody>
        </table>
       </div>
   </body>
</html>