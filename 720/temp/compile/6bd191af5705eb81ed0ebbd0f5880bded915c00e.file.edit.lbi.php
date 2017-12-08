<?php /* Smarty version Smarty-3.1.7, created on 2017-11-11 01:27:36
         compiled from "plugin\bgvoice\template\edit.lbi" */ ?>
<?php /*%%SmartyHeaderCode:30255a05e188678c60-32995081%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6bd191af5705eb81ed0ebbd0f5880bded915c00e' => 
    array (
      0 => 'plugin\\bgvoice\\template\\edit.lbi',
      1 => 1476175130,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '30255a05e188678c60-32995081',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5a05e1886835d',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a05e1886835d')) {function content_5a05e1886835d($_smarty_tpl) {?> <button type="button" class="btn" data-toggle="tooltip" <?php if ($_smarty_tpl->tpl_vars['v']->value['level_enable']==0){?>title="您当前没有该权限"<?php }else{ ?>title="为全景加入语音解说" onclick="openVoice()"<?php }?> >语音解说设置</button><?php }} ?>