<?php /* Smarty version Smarty-3.1.7, created on 2017-11-11 01:27:36
         compiled from "plugin\custom_user\template\edit.lbi" */ ?>
<?php /*%%SmartyHeaderCode:86595a05e1886d8379-28402659%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'de114fbf114c8a3f1f852238ddd81cb3608f0640' => 
    array (
      0 => 'plugin\\custom_user\\template\\edit.lbi',
      1 => 1476175130,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '86595a05e1886d8379-28402659',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5a05e1886e284',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a05e1886e284')) {function content_5a05e1886e284($_smarty_tpl) {?> <button type="button" class="btn btn-custom-logo"  data-toggle="tooltip" <?php if ($_smarty_tpl->tpl_vars['v']->value['level_enable']==0){?>title="您当前没有该权限"<?php }else{ ?>title="为全景加入左上角自定义作者名" onclick="openUserModal()"<?php }?> >自定义作者名</button><?php }} ?>