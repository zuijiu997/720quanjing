<?php /* Smarty version Smarty-3.1.7, created on 2017-11-11 00:21:18
         compiled from "plugin\showlogo\template\resource.lbi" */ ?>
<?php /*%%SmartyHeaderCode:234475a05d1feb706c4-63921569%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6e663afac247e53f1e7e076d31013df561c607f5' => 
    array (
      0 => 'plugin\\showlogo\\template\\resource.lbi',
      1 => 1476095719,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '234475a05d1feb706c4-63921569',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5a05d1feb75db',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a05d1feb75db')) {function content_5a05d1feb75db($_smarty_tpl) {?><script>
$(function(){
	plugins_init_function.push(showlogo_init);
})
function showlogo_init(data){
	if(data.hidelogo_flag=='1'){
        $("#logoImg").hide();
    }else{
    	$("#logoImg").show();
    }
}
</script><?php }} ?>