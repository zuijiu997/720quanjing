<?php /* Smarty version Smarty-3.1.7, created on 2017-11-13 15:07:27
         compiled from "C:/PHPWAMP_IN1/wwwroot/720/template\default\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:79565a0944af4d5d28-77984767%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '256d27df70a24ac936628fafaf59816372171404' => 
    array (
      0 => 'C:/PHPWAMP_IN1/wwwroot/720/template\\default\\index.tpl',
      1 => 1475814470,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '79565a0944af4d5d28-77984767',
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
  'unifunc' => 'content_5a0944af52ca1',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a0944af52ca1')) {function content_5a0944af52ca1($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (($_smarty_tpl->tpl_vars['_lang']->value['moban'])."/library/header.lbi", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<?php echo $_smarty_tpl->getSubTemplate (($_smarty_tpl->tpl_vars['_lang']->value['moban'])."/index/".($_smarty_tpl->tpl_vars['module']->value).".lbi", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<?php echo $_smarty_tpl->getSubTemplate (($_smarty_tpl->tpl_vars['_lang']->value['moban'])."/library/footer.lbi", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }} ?>