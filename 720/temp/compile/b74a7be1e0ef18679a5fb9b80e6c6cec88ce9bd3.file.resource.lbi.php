<?php /* Smarty version Smarty-3.1.7, created on 2017-11-11 00:21:18
         compiled from "plugin\showuser\template\resource.lbi" */ ?>
<?php /*%%SmartyHeaderCode:86865a05d1febc6537-01460796%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b74a7be1e0ef18679a5fb9b80e6c6cec88ce9bd3' => 
    array (
      0 => 'plugin\\showuser\\template\\resource.lbi',
      1 => 1476095719,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '86865a05d1febc6537-01460796',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5a05d1febcb61',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a05d1febcb61')) {function content_5a05d1febcb61($_smarty_tpl) {?><script>
$(function(){
	plugins_init_function.push(showuser_init);
})
function showuser_init(data){
	if(data.hideuser_flag=='1'){
        $("#authorDiv").hide();
    }else{
    	$("#authorDiv").show();
    }
}
</script><?php }} ?>