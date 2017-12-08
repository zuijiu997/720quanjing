<?php /* Smarty version Smarty-3.1.7, created on 2017-11-10 23:40:40
         compiled from "C:/PHPWAMP_IN1/wwwroot/720quanjing/vradmin/template\lib\theme.lbi" */ ?>
<?php /*%%SmartyHeaderCode:130575a05c878e80e38-66229582%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '533d29fdf3f2116096be48facd234b86b5f2a064' => 
    array (
      0 => 'C:/PHPWAMP_IN1/wwwroot/720quanjing/vradmin/template\\lib\\theme.lbi',
      1 => 1476592498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '130575a05c878e80e38-66229582',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'theme_cur' => 0,
    'themes' => 0,
    'v' => 0,
    '_lang' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5a05c878ef4c4',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a05c878ef4c4')) {function content_5a05c878ef4c4($_smarty_tpl) {?><div id="theme" style="height:auto!important;height:550px;min-height:550px;">
   <ul class="tab">
    <li><a href="javascript:;" class="selected">管理模板</a></li>
    <li><a href="http://www.krpano100.com/theme.php" target="_blank">获取更多模板</a></li>
   </ul>
   <div class="enable">
    <h2>当前启用的模板</h2>
    <p><img src="/template/<?php echo $_smarty_tpl->tpl_vars['theme_cur']->value['code'];?>
/thumb.png" width="280" height="175"></p>
    <dl>
     <dt><?php echo $_smarty_tpl->tpl_vars['theme_cur']->value['name'];?>
</dt>
     <dd>版本：<?php echo $_smarty_tpl->tpl_vars['theme_cur']->value['version'];?>
</dd>
     <dd>作者：<a href="<?php echo $_smarty_tpl->tpl_vars['theme_cur']->value['authorurl'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['theme_cur']->value['author'];?>
</a></dd>
     <dd>简介：<?php echo $_smarty_tpl->tpl_vars['theme_cur']->value['intro'];?>
</dd>
    </dl>
   </div>
   <div class="themeList">
    <h2>可用模板</h2>
	<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['themes']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
	 <dl>
     <p><img src="/template/<?php echo $_smarty_tpl->tpl_vars['v']->value['code'];?>
/thumb.png" width="280" height="220"></p>
     <dt><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
 <?php echo $_smarty_tpl->tpl_vars['v']->value['version'];?>
</dt>
     <dd class="btnList">
	  作者：<a href="<?php echo $_smarty_tpl->tpl_vars['v']->value['authorurl'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['v']->value['author'];?>
</a>
	  <span><a href="/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['admin_path'];?>
/?m=theme&unique=<?php echo $_smarty_tpl->tpl_vars['v']->value['code'];?>
" class="del" style="color:#0072C6">启用</a></span>
	 </dd>
    </dl>
	<?php } ?>
   </div>
</div><?php }} ?>