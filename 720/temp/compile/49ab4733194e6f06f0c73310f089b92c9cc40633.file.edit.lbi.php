<?php /* Smarty version Smarty-3.1.7, created on 2017-11-11 01:27:36
         compiled from "plugin\link\template\edit.lbi" */ ?>
<?php /*%%SmartyHeaderCode:261665a05e188687e33-25730083%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '49ab4733194e6f06f0c73310f089b92c9cc40633' => 
    array (
      0 => 'plugin\\link\\template\\edit.lbi',
      1 => 1476175130,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '261665a05e188687e33-25730083',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5a05e1886922e',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a05e1886922e')) {function content_5a05e1886922e($_smarty_tpl) {?><button type="button" class="btn" data-toggle="tooltip" <?php if ($_smarty_tpl->tpl_vars['v']->value['level_enable']==0){?>title="您当前没有该权限"<?php }else{ ?> title="全景中加入站外链接、电话号码或导航" onclick="openLink()"<?php }?>>链接、电话与导航</button><?php }} ?>