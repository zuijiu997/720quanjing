<?php /* Smarty version Smarty-3.1.7, created on 2017-11-12 08:35:09
         compiled from "C:/PHPWAMP_IN1/wwwroot/720quanjing/template\zz_theme\library\member_paths.lbi" */ ?>
<?php /*%%SmartyHeaderCode:299555a07973d5a7fc3-23265068%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '439fad68f2e3abbf668135c8bd3d4f33bbc19fea' => 
    array (
      0 => 'C:/PHPWAMP_IN1/wwwroot/720quanjing/template\\zz_theme\\library\\member_paths.lbi',
      1 => 1475906307,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '299555a07973d5a7fc3-23265068',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'module' => 0,
    'act' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5a07973d5ee16',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a07973d5ee16')) {function content_5a07973d5ee16($_smarty_tpl) {?><style type="text/css">
.navbar{
margin-bottom:0;
}
.navbar-default .navbar-second li>a{
padding-top:7px;
padding-bottom:8px;
}
.navbar-default .navbar-second>.active>a, .navbar-default .navbar-second>.active>a:focus, .navbar-default .navbar-second>li>a:hover, .navbar-default .navbar-second>.active>a:hover{
background:none;
line-height:27px;
border-bottom:3px solid #4aab4e;
}
</style>
<div class="navbar" style="margin-bottom:20px;z-index:0;background:#fff;">
	<div class="container" style="line-height:45px">
		<div class="navbar-right navbar-default" style="background:none">
			<ul class="navbar-second nav navbar-nav">
				<?php if ($_smarty_tpl->tpl_vars['module']->value=='profile'||$_smarty_tpl->tpl_vars['module']->value=='passwd'||$_smarty_tpl->tpl_vars['module']->value=='bind'){?>
					<li <?php if ($_smarty_tpl->tpl_vars['module']->value=='profile'){?>class="active"<?php }?>><a href="/member/profile">作者资料</a></li>
					<li <?php if ($_smarty_tpl->tpl_vars['module']->value=='passwd'){?>class="active"<?php }?>><a href="/member/passwd">修改密码</a></li>
					<li <?php if ($_smarty_tpl->tpl_vars['module']->value=='bind'){?>class="active"<?php }?>><a href="/member/bind">社交绑定</a></li>
				<?php }else{ ?>
					<li <?php if ($_smarty_tpl->tpl_vars['module']->value=='pic'){?>class="active"<?php }?>><a href="/add/pic">发布作品</a></li>
					<li <?php if ($_smarty_tpl->tpl_vars['module']->value=='project'&&$_smarty_tpl->tpl_vars['act']->value=='list'){?>class="active"<?php }?>><a href="/member/project">全景图片</a></li>
					<li <?php if ($_smarty_tpl->tpl_vars['module']->value=='project'&&$_smarty_tpl->tpl_vars['act']->value=='videos'){?>class="active"<?php }?>><a href="/member/project?act=videos">全景视频</a></li>
					<li <?php if ($_smarty_tpl->tpl_vars['module']->value=='mediares'){?>class="active"<?php }?>><a href="/member/mediares">素材管理</a></li>
				<?php }?>
		  </ul>
		</div>
	</div>
</div><?php }} ?>