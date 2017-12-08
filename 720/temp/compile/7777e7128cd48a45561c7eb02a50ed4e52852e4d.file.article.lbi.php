<?php /* Smarty version Smarty-3.1.7, created on 2017-11-11 00:00:38
         compiled from "C:/PHPWAMP_IN1/wwwroot/720quanjing/template\default\index\article.lbi" */ ?>
<?php /*%%SmartyHeaderCode:39715a05cd264a7d48-32992247%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7777e7128cd48a45561c7eb02a50ed4e52852e4d' => 
    array (
      0 => 'C:/PHPWAMP_IN1/wwwroot/720quanjing/template\\default\\index\\article.lbi',
      1 => 1478942754,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '39715a05cd264a7d48-32992247',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'a' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5a05cd264e6c9',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a05cd264e6c9')) {function content_5a05cd264e6c9($_smarty_tpl) {?><style type="text/css">
h2.art-tit{
margin:0;color:#888;font-weight:normal;padding:10px;background:#fff;border-bottom:1px solid #e4e4e4;
}
.art-box{
border:1px solid #e4e4e4;margin-bottom:20px;
}
.art-content{
padding:10px;overflow:hidden;
}
.art-content img{
max-width:100%;
}
</style>

<div class="container">

	<div class="art-box">
	
		<h2 class="art-tit">
		<?php echo $_smarty_tpl->tpl_vars['a']->value['title'];?>

		</h2>
	
		<div class="clearfix"></div>
	
		<div class="art-content">
		<?php echo $_smarty_tpl->tpl_vars['a']->value['content'];?>

		</div>
	
	</div>

</div><?php }} ?>