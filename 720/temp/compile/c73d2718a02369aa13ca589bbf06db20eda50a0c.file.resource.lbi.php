<?php /* Smarty version Smarty-3.1.7, created on 2017-11-11 00:21:18
         compiled from "plugin\custom_logo\template\resource.lbi" */ ?>
<?php /*%%SmartyHeaderCode:79855a05d1feb5cd06-58791886%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c73d2718a02369aa13ca589bbf06db20eda50a0c' => 
    array (
      0 => 'plugin\\custom_logo\\template\\resource.lbi',
      1 => 1478155406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '79855a05d1feb5cd06-58791886',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5a05d1feb60f0',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a05d1feb60f0')) {function content_5a05d1feb60f0($_smarty_tpl) {?><script>
$(function(){
    $("#logoImg").show();
	plugins_init_function.push(custom_logo_init);
})
function custom_logo_init(data){
	var logoObj = data.custom_logo;
	if(logoObj){
		if(logoObj.useCustomLogo)
        	$('.vrshow_container_logo img').attr('src',logoObj.logoImgPath);
        if(logoObj.logoLink)
            $('.vrshow_container_logo img').attr('onclick','javascript:window.open("'+logoObj.logoLink+'")');
        
    }
}
</script>

<?php }} ?>