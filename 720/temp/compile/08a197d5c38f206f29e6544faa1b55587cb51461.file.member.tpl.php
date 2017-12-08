<?php /* Smarty version Smarty-3.1.7, created on 2017-11-13 15:13:39
         compiled from "C:/PHPWAMP_IN1/wwwroot/720/template\default\member.tpl" */ ?>
<?php /*%%SmartyHeaderCode:183715a0946237118e8-11535903%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '08a197d5c38f206f29e6544faa1b55587cb51461' => 
    array (
      0 => 'C:/PHPWAMP_IN1/wwwroot/720/template\\default\\member.tpl',
      1 => 1475814470,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '183715a0946237118e8-11535903',
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
  'unifunc' => 'content_5a09462375c49',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a09462375c49')) {function content_5a09462375c49($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (($_smarty_tpl->tpl_vars['_lang']->value['moban'])."/library/header.lbi", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<?php echo $_smarty_tpl->getSubTemplate (($_smarty_tpl->tpl_vars['_lang']->value['moban'])."/member/".($_smarty_tpl->tpl_vars['module']->value).".lbi", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<?php echo $_smarty_tpl->getSubTemplate (($_smarty_tpl->tpl_vars['_lang']->value['moban'])."/library/footer.lbi", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }} ?>