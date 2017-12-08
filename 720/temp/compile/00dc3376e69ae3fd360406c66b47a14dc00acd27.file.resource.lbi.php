<?php /* Smarty version Smarty-3.1.7, created on 2017-11-11 00:21:18
         compiled from "plugin\footmarker\template\resource.lbi" */ ?>
<?php /*%%SmartyHeaderCode:261345a05d1feb68652-57626296%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '00dc3376e69ae3fd360406c66b47a14dc00acd27' => 
    array (
      0 => 'plugin\\footmarker\\template\\resource.lbi',
      1 => 1478251649,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '261345a05d1feb68652-57626296',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5a05d1feb6be6',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a05d1feb6be6')) {function content_5a05d1feb6be6($_smarty_tpl) {?>
<script>
	$(function(){
		plugins_init_function.push(footmarker_init);
	})
	function footmarker_init(data){
		 if (data.footmark=='0') {
            $('#footmarkDiv').hide();
        }
	}
	function hideShareAndFootmarkBtn(){
	    //$("#shareDiv").hide();
	    $("#footmarkDiv").hide();
	}
	function showFootMark(){
	    var krpano = document.getElementById('krpanoSWFObject');
	    var sceneName = krpano.get('xml.scene');
	    var viewuuid = (sceneName.split('_'))[1].toUpperCase();
	    var locationData = $('body').data(viewuuid);
	    if(locationData){
	        _U.mapMarkModal().openModal(locationData,true);
	    }else{
	        $.zui.messager.show('没有足迹', {placement: 'center', type: 'warning', time: '3000', icon: 'warning-sign'});
	    }
	}
</script>
<?php }} ?>