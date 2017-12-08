<?php /* Smarty version Smarty-3.1.7, created on 2017-11-12 08:34:17
         compiled from "C:/PHPWAMP_IN1/wwwroot/720quanjing/template\zz_theme\library\pc_header.lbi" */ ?>
<?php /*%%SmartyHeaderCode:54925a07970990bc70-40369175%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6b2e0b64c3952f60441bbb5386610153c1a083e2' => 
    array (
      0 => 'C:/PHPWAMP_IN1/wwwroot/720quanjing/template\\zz_theme\\library\\pc_header.lbi',
      1 => 1478155406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '54925a07970990bc70-40369175',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    '_lang' => 0,
    'user' => 0,
    'video_tag' => 0,
    'p_tags' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5a07970998085',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a07970998085')) {function content_5a07970998085($_smarty_tpl) {?><!DOCTYPE html>
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
<link rel="stylesheet" href="/template/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['moban'];?>
/css/common.css">
<script language="JavaScript" type="text/javascript" src="/static/js/jquery-1.9.1.js"></script>
<script language="JavaScript" type="text/javascript" src="/static/js/datetimepicker.js"></script>
</head>

<body>
<header>
	<nav class="navbar navbar-default" >
	  <div class="container">
	    	<div class="row">
	    		<div class="col-md-1 pull-left top_nav_sc" ><i class="icon-star-empty"></i>&nbsp;<span  onclick="JavaScript:addFavorite2()">加入收藏</span></div>
	    		<div class="col-md-1 pull-left top_nav_sj">
	    			<div class="top_nav_qr">
	    				<span style="margin-left: 33px;">请打开微信扫一扫</span>
	    				<img src="/template/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['moban'];?>
/images/mobile_qr.png" alt="">
	    			</div>
	    			<i class="icon-mobile"></i>&nbsp;手机版
	    		</div>
	    		<div class="col-md-2 pull-right navbar_top_right">
	    		<?php if ($_smarty_tpl->tpl_vars['user']->value['pk_user_main']<1){?>
	    			<ul class="not_login">
	    				<li>
	    					<a href="/passport/" style="margin-right: 10px;">登录</a>
		    				<span class="sep-lines"></span>
	    				</li>
	    				<li>
	    					<a href="/passport/register" style="margin-left: 10px;">注册</a>
	    				</li>
	    			</ul>
		    	<?php }else{ ?>	
		    		<ul class="a_login">
		    		   <li class="dropdown">
    		               <a  class="dropdown-toggle" data-toggle="dropdown" style="background:none;text-decoration: none;cursor: pointer;"><?php echo $_smarty_tpl->tpl_vars['user']->value['nickname'];?>
<b class="caret"></b></a>
    		               <ul class="dropdown-menu pull-right" role="menu">
    		                 <li><a href="/member/profile">账户管理</a></li>
    		                 <li class="divider"></li>
    		                 <li><a href="/member/project">图片管理</a></li>
    		                 <li><a href="/member/project?act=videos">视频管理</a></li>
    		                 <li><a href="/member/mediares">素材管理</a></li>
    						 <li><a href="/member/logout">退　　出</a></li>
    		               </ul>
    		             </li>
					</ul>
		    	<?php }?>

	    		</div>
	    	</div>
	  </div>
	</nav>

</header>
	<div class="container">
		<div class="row ">
			<div class="col-md-2" style="padding: 0;">
				<a href="/"><img src="/template/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['moban'];?>
/images/logo.png" width="100%" height="60px"></a>
			</div>
			<div class="col-md-4 col-md-offset-5" style="margin-top:6px">
				<div class="input-group">
				  <input type="text" id="search_box" class="form-control input-lg" placeholder="搜索VR漫游">
				  <span class="input-group-btn">
				    <button class="btn btn-default btn-lg" type="button" onclick="search()"><i class="icon-search"></i></button>
				  </span>
				</div>
			</div>
			<div class="col-md-1" style="margin-top:6px;margin-left: -7px;">
				 <button  type="button" class="btn btn-warning btn-lg" onclick="javascript:window.location.href='/add/pic'">
				   <i class="cloud-upload"></i> 发布
				  </button>
			</div>
		</div>
		<div class="row cate_top">
			<div class="col-md-2 all_cate_span">
				<span>全部分类</span>
				<span class="pull-right" style="margin-right: 15px;"><i id="cate_up_down" class="icon-chevron-down"></i></span>
				<div class="sub_cate">
					<ul>
						<?php if ($_smarty_tpl->tpl_vars['video_tag']->value){?>
							<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['p_tags']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
								<li><a href="/videos?tag=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</a></li>
							<?php } ?>

							<?php }else{ ?>
							
							<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['p_tags']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
								<li><a href="/pictures?tag=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</a></li>
							<?php } ?>

						<?php }?>
					</ul>
				</div>
			</div>
			<div class="col-md-1"><a href="/" style="clear: both">首页</a></div>
			<div class="col-md-1"><a href="/videos" style="clear: both">全景视频</a></div>
			<div class="col-md-1"><a href="/#jxpp" style="clear: both">精选品牌</a></div>
			<div class="col-md-1"><a href="/#new_join" style="clear: both">最新入驻</a></div>
		</div>
	</div>
	<script>
		$(function(){
			$(".all_cate_span").mouseover(function(){
				$('#cate_up_down').attr("class",'icon-chevron-up');
			}).mouseout(function(){
				$('#cate_up_down').attr("class",'icon-chevron-down');
			})
			$('#search_box').bind('keyup', function(event) {
				if (event.keyCode == "13") {
					//回车执行查询
					search();
				}
			});
			$(".top_nav_sc").mouseover(function(){
				$(this).children("i").addClass("icon-star top_nav_sc_check").removeClass("icon-star-empty");
			}).mouseout(function(){
				$(this).children("i").removeClass("icon-star top_nav_sc_check").addClass("icon-star-empty");
			})
		})
		function search(){
			var word = $.trim($("#search_box").val());
			if (word.length<=0) {
				alert_notice("请输入搜索关键词");
				return false;
			}
			window.location.href = "/search?word="+word;
		}
		function addFavorite2() {
		    var url = window.location;
		    var title = document.title;
		    var ua = navigator.userAgent.toLowerCase();
		    if (ua.indexOf("360se") > -1) {
		      alert_notice('您的浏览器不支持,请按 Ctrl+D 手动收藏!');
		    }
		    else if (ua.indexOf("msie 8") > -1) {
		        window.external.AddToFavoritesBar(url, title); //IE8
		    }
		    else if (document.all) {
		  try{
		   window.external.addFavorite(url, title);
		  }catch(e){
		   alert_notice('您的浏览器不支持,请按 Ctrl+D 手动收藏!');
		  }
		    }
		    else if (window.sidebar) {
		        window.sidebar.addPanel(title, url, "");
		    }
		    else {
		  alert_notice('您的浏览器不支持,请按 Ctrl+D 手动收藏!');
		    }
		}
	</script><?php }} ?>