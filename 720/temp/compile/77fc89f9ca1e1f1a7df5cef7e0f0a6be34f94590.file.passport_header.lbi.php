<?php /* Smarty version Smarty-3.1.7, created on 2017-11-13 15:12:17
         compiled from "C:/PHPWAMP_IN1/wwwroot/720/template\default\library\passport_header.lbi" */ ?>
<?php /*%%SmartyHeaderCode:161505a0945d18cf572-85339990%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '77fc89f9ca1e1f1a7df5cef7e0f0a6be34f94590' => 
    array (
      0 => 'C:/PHPWAMP_IN1/wwwroot/720/template\\default\\library\\passport_header.lbi',
      1 => 1475814470,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '161505a0945d18cf572-85339990',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    '_lang' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5a0945d18f25b',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a0945d18f25b')) {function content_5a0945d18f25b($_smarty_tpl) {?><!DOCTYPE html>
<html lang="zh-ch">
<head>
<meta charset="UTF-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport" />
<title><?php if ($_smarty_tpl->tpl_vars['title']->value){?><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['_lang']->value['title'];?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['_lang']->value['title'];?>
-<?php echo $_smarty_tpl->tpl_vars['_lang']->value['subtitle'];?>
<?php }?></title>
<link rel="stylesheet" href="/static/css/zui.min.css">
<link rel="stylesheet" href="/static/css/zui-theme.css">
<link rel="stylesheet" href="/template/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['moban'];?>
/css/redefine.css">
<script language="JavaScript" type="text/javascript" src="/static/js/jquery-1.9.1.js"></script>

<style>
	.passport_container{
		margin:10% auto 0 auto;
		min-height: 600px;
		width: 300px;
		text-align: center;
	}
</style>
<script>

	function showerr(content,obj){
		alert_notice(content,'default','top');
		if(obj!=null){
			$(obj).parent(".input-group").addClass("has-error");
		}
	}


</script>
</head>

<body>

<?php }} ?>