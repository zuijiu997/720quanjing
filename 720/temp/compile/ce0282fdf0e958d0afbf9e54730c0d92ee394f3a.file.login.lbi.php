<?php /* Smarty version Smarty-3.1.7, created on 2017-11-13 15:09:31
         compiled from "C:/PHPWAMP_IN1/wwwroot/720/vradmin/template\lib\login.lbi" */ ?>
<?php /*%%SmartyHeaderCode:91475a09452b8643e2-45769661%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ce0282fdf0e958d0afbf9e54730c0d92ee394f3a' => 
    array (
      0 => 'C:/PHPWAMP_IN1/wwwroot/720/vradmin/template\\lib\\login.lbi',
      1 => 1476095719,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '91475a09452b8643e2-45769661',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    '_lang' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5a09452b869e3',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a09452b869e3')) {function content_5a09452b869e3($_smarty_tpl) {?><div id="login">
  <div class="dologo"></div>
  <form id="admin_login" action="/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['admin_path'];?>
/?m=login" method="post" enctype="multipart/form-data">
   <div id="wrong_text" class="warning" style="display:none"></div>
   <ul>  
    <li class="inpLi"><b>登录账号</b><input type="text" name="admin_name" class="inpLogin"></li>
    <li class="inpLi"><b>登录密码</b><input type="password" name="passwd" class="inpLogin"></li>
    <li style="height:auto"><label><input type="checkbox" name="remember" value="1"> 7天内免登录</label></li>
    <li class="sub"><input type="button" id="sub_btn" value="确认登录" class="btn" style="width:100%;" onclick="javascript:ajaxFormSubmit('admin_login','登录');"></li> 
   </ul>
  </form>
</div>
<?php }} ?>