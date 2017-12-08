<?php /* Smarty version Smarty-3.1.7, created on 2017-11-11 01:27:36
         compiled from "plugin\custom_logo\template\edit.lbi" */ ?>
<?php /*%%SmartyHeaderCode:51335a05e1886b5685-06897102%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3841ef69c1744f0dff6d56b36457cdb0fd153da6' => 
    array (
      0 => 'plugin\\custom_logo\\template\\edit.lbi',
      1 => 1476175130,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '51335a05e1886b5685-06897102',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5a05e1886c134',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a05e1886c134')) {function content_5a05e1886c134($_smarty_tpl) {?> <button type="button" class="btn btn-custom-logo"  data-toggle="tooltip" <?php if ($_smarty_tpl->tpl_vars['v']->value['level_enable']==0){?>title="您当前没有该权限"<?php }else{ ?>title="为全景加入左上角自定义LOGO" onclick="openLogo()"<?php }?>>自定义LOGO</button><?php }} ?>