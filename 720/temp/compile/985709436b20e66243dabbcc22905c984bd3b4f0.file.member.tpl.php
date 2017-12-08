<?php /* Smarty version Smarty-3.1.7, created on 2016-12-20 18:11:06
         compiled from "D:/phpStudy/WWW_krpano100/template\default\member.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15949585903ba594582-69028208%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '985709436b20e66243dabbcc22905c984bd3b4f0' => 
    array (
      0 => 'D:/phpStudy/WWW_krpano100/template\\default\\member.tpl',
      1 => 1475814470,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15949585903ba594582-69028208',
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
  'unifunc' => 'content_585903ba5e279',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_585903ba5e279')) {function content_585903ba5e279($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (($_smarty_tpl->tpl_vars['_lang']->value['moban'])."/library/header.lbi", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<?php echo $_smarty_tpl->getSubTemplate (($_smarty_tpl->tpl_vars['_lang']->value['moban'])."/member/".($_smarty_tpl->tpl_vars['module']->value).".lbi", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<?php echo $_smarty_tpl->getSubTemplate (($_smarty_tpl->tpl_vars['_lang']->value['moban'])."/library/footer.lbi", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }} ?>