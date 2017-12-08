<?php /* Smarty version Smarty-3.1.7, created on 2017-11-11 01:27:36
         compiled from "plugin\shade_sky_floor\template\edit.lbi" */ ?>
<?php /*%%SmartyHeaderCode:105515a05e188696ac4-87110092%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c818773793d203619c595108d9e31c583c7f9a2f' => 
    array (
      0 => 'plugin\\shade_sky_floor\\template\\edit.lbi',
      1 => 1476175130,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '105515a05e188696ac4-87110092',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5a05e1886a130',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a05e1886a130')) {function content_5a05e1886a130($_smarty_tpl) {?>  <button type="button" class="btn" data-toggle="tooltip" <?php if ($_smarty_tpl->tpl_vars['v']->value['level_enable']==0){?>title="您当前没有该权限"<?php }else{ ?>title="为天空/地面增加一张遮罩图片，可加入自定义信息或用来遮住脚架" onclick="openSky()"<?php }?>>天空/地面遮罩</button><?php }} ?>