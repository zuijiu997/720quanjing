<?php /* Smarty version Smarty-3.1.7, created on 2017-11-11 01:27:36
         compiled from "plugin\bgmusic\template\edit.lbi" */ ?>
<?php /*%%SmartyHeaderCode:110005a05e188669b50-04234756%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '31af5126984a73878f72ddb2bbae400c6518607f' => 
    array (
      0 => 'plugin\\bgmusic\\template\\edit.lbi',
      1 => 1476175130,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '110005a05e188669b50-04234756',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5a05e18867413',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a05e18867413')) {function content_5a05e18867413($_smarty_tpl) {?> <button type="button" class="btn" data-toggle="tooltip" <?php if ($_smarty_tpl->tpl_vars['v']->value['level_enable']==0){?>title="您当前没有该权限"<?php }else{ ?>title="为全景加入背景音乐" onclick="openMusic()"<?php }?> > 背景音乐设置 </button><?php }} ?>