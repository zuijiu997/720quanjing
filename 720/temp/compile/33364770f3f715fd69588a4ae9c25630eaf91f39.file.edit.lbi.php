<?php /* Smarty version Smarty-3.1.7, created on 2017-11-11 01:27:36
         compiled from "plugin\private_access\template\edit.lbi" */ ?>
<?php /*%%SmartyHeaderCode:256095a05e1886f6dd6-50476382%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '33364770f3f715fd69588a4ae9c25630eaf91f39' => 
    array (
      0 => 'plugin\\private_access\\template\\edit.lbi',
      1 => 1482228002,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '256095a05e1886f6dd6-50476382',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5a05e1887013c',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a05e1887013c')) {function content_5a05e1887013c($_smarty_tpl) {?> <button type="button" class="btn btn-custom-logo"  data-toggle="tooltip" <?php if ($_smarty_tpl->tpl_vars['v']->value['level_enable']==0){?>title="您当前没有该权限"<?php }else{ ?>title="设置输入密码才能访问项目" onclick="openPrivacyWordModal()"<?php }?> >密码访问</button><?php }} ?>