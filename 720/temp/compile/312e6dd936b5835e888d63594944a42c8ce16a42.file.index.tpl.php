<?php /* Smarty version Smarty-3.1.7, created on 2016-12-20 16:40:37
         compiled from "D:/phpStudy/WWW_krpano100/template\default\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:192475858ee854f8f34-15526596%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '312e6dd936b5835e888d63594944a42c8ce16a42' => 
    array (
      0 => 'D:/phpStudy/WWW_krpano100/template\\default\\index.tpl',
      1 => 1475814470,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '192475858ee854f8f34-15526596',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    '_lang' => 0,
    'module' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5858ee85723ab',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5858ee85723ab')) {function content_5858ee85723ab($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (($_smarty_tpl->tpl_vars['_lang']->value['moban'])."/library/header.lbi", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<?php echo $_smarty_tpl->getSubTemplate (($_smarty_tpl->tpl_vars['_lang']->value['moban'])."/index/".($_smarty_tpl->tpl_vars['module']->value).".lbi", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<?php echo $_smarty_tpl->getSubTemplate (($_smarty_tpl->tpl_vars['_lang']->value['moban'])."/library/footer.lbi", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }} ?>