<?php /* Smarty version Smarty-3.1.7, created on 2017-11-11 01:27:36
         compiled from "plugin\allowed_recomm\template\edit.lbi" */ ?>
<?php /*%%SmartyHeaderCode:227405a05e18881b0d5-36642039%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5a5da99469e777bbeaa750bff58094bdecce9c06' => 
    array (
      0 => 'plugin\\allowed_recomm\\template\\edit.lbi',
      1 => 1482227844,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '227405a05e18881b0d5-36642039',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5a05e18882cca',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a05e18882cca')) {function content_5a05e18882cca($_smarty_tpl) {?><div class="col-md-4">
<label  class="col-md-6 control-label">允许推荐</label>
<div class="col-md-6" data-toggle="tooltip"  <?php if ($_smarty_tpl->tpl_vars['v']->value['level_enable']==0){?>title="您当前没有该权限"<?php }else{ ?>title="是否允许管理员将你的作品推荐到首页"<?php }?>>
<input id="flag_allowed_recomm" name="switch_checkbox" class="form-control" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['v']->value['level_enable']==0){?>disabled<?php }?>/>
</div>
</div><?php }} ?>