<?php /* Smarty version Smarty-3.1.7, created on 2017-11-11 00:21:18
         compiled from "plugin\custom_right_button\template\resource.lbi" */ ?>
<?php /*%%SmartyHeaderCode:250725a05d1febb05d4-75278028%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'afc14059fc783b0e96c80bb59598d409477639bf' => 
    array (
      0 => 'plugin\\custom_right_button\\template\\resource.lbi',
      1 => 1478570734,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '250725a05d1febb05d4-75278028',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5a05d1febb99f',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a05d1febb99f')) {function content_5a05d1febb99f($_smarty_tpl) {?><script>
	$(function(){
		plugins_init_function.push(custom_right_init);
	})
	function custom_right_init(data){
		// $(".vrshow_container_3_min .img_desc_container_min:first").nextAll().remove();
		// if (data.url_phone_nvg.linkSettings && data.url_phone_nvg.linkSettings.length > 0) {
		//     $(data.custom_right_button.linkSettings).each(function(idx){
		//         var title = this.title;
		//         var htmlStr = '';
		//         var url = this.content;
	 //            if(!isNaN(url)){
	 //                url = "tel://" + url;
	 //            }else{
	 //                if(!(url.indexOf('http://') == 0)){
	 //                    url = 'http://' + url;
	 //                }
	 //            }
	          
		//     });
		// }
		
	}
	function lookLinkUrl(url){
    	window.open(url);
	}
	
</script><?php }} ?>