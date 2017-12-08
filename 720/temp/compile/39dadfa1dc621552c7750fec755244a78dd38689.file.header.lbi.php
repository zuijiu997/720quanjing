<?php /* Smarty version Smarty-3.1.7, created on 2017-11-12 08:35:09
         compiled from "C:/PHPWAMP_IN1/wwwroot/720quanjing/template\zz_theme\library\header.lbi" */ ?>
<?php /*%%SmartyHeaderCode:19815a07973d5162e9-73227969%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '39dadfa1dc621552c7750fec755244a78dd38689' => 
    array (
      0 => 'C:/PHPWAMP_IN1/wwwroot/720quanjing/template\\zz_theme\\library\\header.lbi',
      1 => 1477033515,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19815a07973d5162e9-73227969',
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
  'unifunc' => 'content_5a07973d5714b',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a07973d5714b')) {function content_5a07973d5714b($_smarty_tpl) {?><!DOCTYPE html>
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
<link rel="stylesheet" href="/template/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['moban'];?>
/css/zui-theme.css">
<link rel="stylesheet" href="/template/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['moban'];?>
/css/redefine.css">
<script language="JavaScript" type="text/javascript" src="/static/js/jquery-1.9.1.js"></script>
<script language="JavaScript" type="text/javascript" src="/static/js/datetimepicker.js"></script>
</head>

<body>
<?php echo $_smarty_tpl->getSubTemplate (($_smarty_tpl->tpl_vars['_lang']->value['moban'])."/library/nav.lbi", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>