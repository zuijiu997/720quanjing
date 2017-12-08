<?php /* Smarty version Smarty-3.1.7, created on 2017-11-12 09:12:55
         compiled from "C:/PHPWAMP_IN1/wwwroot/720quanjing/template\zz_theme\index\search.lbi" */ ?>
<?php /*%%SmartyHeaderCode:14095a07a0172f0dd1-50054165%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3d35f4d6c96ce4e0d5042c30fac76ffeb566ec99' => 
    array (
      0 => 'C:/PHPWAMP_IN1/wwwroot/720quanjing/template\\zz_theme\\index\\search.lbi',
      1 => 1477310646,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14095a07a0172f0dd1-50054165',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tag' => 0,
    'picture_tags' => 0,
    'v' => 0,
    'list' => 0,
    'page' => 0,
    'word' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5a07a01738191',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a07a01738191')) {function content_5a07a01738191($_smarty_tpl) {?><div class="container" style="padding:0">

<!--一个卡片列表行-->
<div class="row">
	<div class="cards" style="margin:0;">
		<!--卡片列表循环-->
		<!-- <div class="col-md-3 col-sm-3 col-xs-12 col-lg-3">
		 <div class="card channel-box">
		  <h2>频道</h2>
		  <ul class="channel">
		   <li><a href="/pictures?tag=0" <?php if ($_smarty_tpl->tpl_vars['tag']->value===0){?>class="active"<?php }?>>全部</a></li>
		   <li><a href="/pictures?tag=-1" <?php if ($_smarty_tpl->tpl_vars['tag']->value===-1){?>class="active"<?php }?>>编辑推荐</a></li>
		   <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['picture_tags']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
		   	<li><a href="/pictures?tag=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['tag']->value==$_smarty_tpl->tpl_vars['v']->value['id']){?>class="active"<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</a></li>
		   <?php } ?>
		   </ul>
		   <div class="clearfix"></div>
		  </div>
		 </div> -->
		 
		<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['list']->value['res']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
		<div class="col-md-3 col-sm-3 col-xs-6 col-lg-3">
		   <div class="card" href="###">
			 <a target="_blank" href="/tour/<?php echo $_smarty_tpl->tpl_vars['v']->value['view_uuid'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['v']->value['thumb_path'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" style="width: 100%"></a>
			 <div class="card-heading">
				<div class="col-md-9 col-xs-8 of_hide padding0">
					<strong class="text-primary"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</strong> 
				</div>
				<div class="col-md-3 col-xs-4 of_hide padding0">
					<div class="pull-right text-danger"><i class="icon-heart-empty"></i> <?php echo $_smarty_tpl->tpl_vars['v']->value['browsing_num'];?>
</div>
				</div>
			 </div>
			 
		   </div>
		 </div>
		<?php } ?>	         
		<!--卡片列表循环结束-->	
	</div>
</div>
<!--一个卡片列表行结束-->
<div class="list-page"><?php echo $_smarty_tpl->getSubTemplate ("../library/pages.lbi", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div>
</div>
<script>
	$(function(){
		var page = <?php echo $_smarty_tpl->tpl_vars['page']->value;?>
;
		var count = <?php echo $_smarty_tpl->tpl_vars['list']->value['count'];?>
;
		if(page==1){
			if(count > 0)
				alert_notice("为您找到"+count+"条结果",'success');
			else 
				alert_notice("未能查询到结果",'success');
		}
		$("#search_box").val('<?php echo $_smarty_tpl->tpl_vars['word']->value;?>
');
	})
</script><?php }} ?>