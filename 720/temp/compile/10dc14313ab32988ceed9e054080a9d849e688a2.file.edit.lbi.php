<?php /* Smarty version Smarty-3.1.7, created on 2017-11-11 01:27:36
         compiled from "plugin\open_alert\template\edit.lbi" */ ?>
<?php /*%%SmartyHeaderCode:324205a05e1886a6907-52081158%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '10dc14313ab32988ceed9e054080a9d849e688a2' => 
    array (
      0 => 'plugin\\open_alert\\template\\edit.lbi',
      1 => 1476175130,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '324205a05e1886a6907-52081158',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5a05e1886b0dd',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a05e1886b0dd')) {function content_5a05e1886b0dd($_smarty_tpl) {?> <button type="button" class="btn" data-toggle="tooltip" <?php if ($_smarty_tpl->tpl_vars['v']->value['level_enable']==0){?>title="您当前没有该权限"<?php }else{ ?>title="设置进入全景时显示的提示信息" onclick="openOpen()"<?php }?>>开场提示</button><?php }} ?>