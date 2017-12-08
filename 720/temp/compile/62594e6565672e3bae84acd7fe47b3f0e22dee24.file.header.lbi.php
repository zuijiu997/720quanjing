<?php /* Smarty version Smarty-3.1.7, created on 2016-12-20 18:01:24
         compiled from "D:/phpStudy/WWW_krpano100/template\default\library\header.lbi" */ ?>
<?php /*%%SmartyHeaderCode:13405858ee85766147-89962815%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '62594e6565672e3bae84acd7fe47b3f0e22dee24' => 
    array (
      0 => 'D:/phpStudy/WWW_krpano100/template\\default\\library\\header.lbi',
      1 => 1482227914,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13405858ee85766147-89962815',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5858ee858257f',
  'variables' => 
  array (
    'title' => 0,
    '_lang' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5858ee858257f')) {function content_5858ee858257f($_smarty_tpl) {?><!DOCTYPE html>
<html lang="zh-ch">
<head>
<meta charset="UTF-8" />
<meta name="renderer" content="webkit">
<meta http-equiv="x-ua-compatible" content="IE=edge,chrome=1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport" />
<title><?php if ($_smarty_tpl->tpl_vars['title']->value){?><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['_lang']->value['title'];?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['_lang']->value['title'];?>
-<?php echo $_smarty_tpl->tpl_vars['_lang']->value['subtitle'];?>
<?php }?></title>
<meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['_lang']->value['desciption'];?>
" />
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