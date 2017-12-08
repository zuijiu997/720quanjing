<?php /* Smarty version Smarty-3.1.7, created on 2017-11-11 00:21:18
         compiled from "plugin\custom_user\template\resource.lbi" */ ?>
<?php /*%%SmartyHeaderCode:198745a05d1feb9e241-69025762%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5f0765f13dc5d95be23dcdff18eac846db9db4b2' => 
    array (
      0 => 'plugin\\custom_user\\template\\resource.lbi',
      1 => 1476095718,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '198745a05d1feb9e241-69025762',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5a05d1feba22d',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a05d1feba22d')) {function content_5a05d1feba22d($_smarty_tpl) {?><script>
$(function(){
	$("#authorDiv").show();
	plugins_init_function.push(custom_user_init);
})
function custom_user_init(data){
	var logoObj = data.custom_logo;
	if(logoObj && logoObj.user){
        $("#user_nickName").text(logoObj.user);
    }
}
</script>

<?php }} ?>