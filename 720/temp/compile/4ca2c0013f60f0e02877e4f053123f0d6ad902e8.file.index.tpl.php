<?php /* Smarty version Smarty-3.1.7, created on 2016-12-20 16:40:44
         compiled from "D:/phpStudy/WWW_krpano100/vradmin/template\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:147115858ee8cb11329-77372122%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4ca2c0013f60f0e02877e4f053123f0d6ad902e8' => 
    array (
      0 => 'D:/phpStudy/WWW_krpano100/vradmin/template\\index.tpl',
      1 => 1479439070,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '147115858ee8cb11329-77372122',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    '_lang' => 0,
    'title' => 0,
    'module' => 0,
    'admin' => 0,
    'nav' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5858ee8cf0111',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5858ee8cf0111')) {function content_5858ee8cf0111($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noarchive">
<link href="/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['admin_path'];?>
/template/css/public.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['admin_path'];?>
/template/js/jquery.min.js"></script>
<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['_lang']->value['title'];?>
</title>
</head>
<body>

<div id="dcWrap">

<?php if ($_smarty_tpl->tpl_vars['module']->value=='login'){?>
   <?php echo $_smarty_tpl->getSubTemplate ("lib/login.lbi", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }else{ ?>
 <div id="dcHead">
 <div id="head">
  <div class="logo"><a href="/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['admin_path'];?>
/"><?php echo $_smarty_tpl->tpl_vars['_lang']->value['title'];?>
</a></div>
  <div class="nav">
   <ul>
    <li class="M"><a href="JavaScript:void(0);" class="topAdd">新建</a>
     <div class="drop mTopad"><a href="/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['admin_path'];?>
/?m=user&act=profile">会员</a> <a href="/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['admin_path'];?>
/?m=tag&act=profile">标签</a></div>
    </li>
    <li><a href="/" target="_blank">查看站点</a></li>
    <li><a onclick="clear_cache(this)" href="javascript:;">清除缓存</a></li>
	<li <?php if ($_smarty_tpl->tpl_vars['_lang']->value['customvip']){?>class="noRight"<?php }?>><a target="_blank" href="http://www.krpano100.com/docs.html">使用文档</a></li>
    <?php if (!$_smarty_tpl->tpl_vars['_lang']->value['customvip']){?><li class="noRight"><a target="_blank" href="http://www.krpano100.com">krpano100官网</a></li><?php }?>
   </ul>
  
   <ul class="navRight">
    <li class="M noLeft"><a href="JavaScript:void(0);">您好，<?php echo $_smarty_tpl->tpl_vars['admin']->value['admin_name'];?>
</a>
     <div class="drop mUser">
      <a href="/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['admin_path'];?>
/?m=passwd">修改登录密码</a>
     </div>
    </li>
    <li class="noRight"><a href="/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['admin_path'];?>
/?m=logout">退出</a></li>
   </ul>
  </div>
 </div>
</div>
<!-- Head 结束 --> 
<div id="dcLeft">
 <div id="menu">
 <ul class="top">
  <li><a href="/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['admin_path'];?>
/"><i class="home"></i><em>管理首页</em></a></li>
 </ul>
 <ul>
  <li <?php if ($_smarty_tpl->tpl_vars['module']->value=='system'){?>class="cur"<?php }?>><a href="/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['admin_path'];?>
/?m=system"><i class="system"></i><em>系统设置</em></a></li>
  <li <?php if ($_smarty_tpl->tpl_vars['module']->value=='plugin'){?>class="cur"<?php }?>><a href="/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['admin_path'];?>
/?m=plugin"><i class="case"></i><em>插件管理</em></a></li>
  <li <?php if ($_smarty_tpl->tpl_vars['module']->value=='theme'){?>class="cur"<?php }?>><a href="/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['admin_path'];?>
/?m=theme"><i class="theme"></i><em>设置模板</em></a></li>
 </ul>
 <ul>
  <li <?php if ($_smarty_tpl->tpl_vars['module']->value=='material'){?>class="cur"<?php }?>><a href="/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['admin_path'];?>
/?m=material"><i class="show"></i><em>图片素材</em></a></li>
  <li <?php if ($_smarty_tpl->tpl_vars['module']->value=='voice'){?>class="cur"<?php }?>><a href="/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['admin_path'];?>
/?m=voice"><i class="link"></i><em>音频素材</em></a></li>
 </ul>
 <ul>
  <li <?php if ($_smarty_tpl->tpl_vars['module']->value=='user'){?>class="cur"<?php }?>><a href="/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['admin_path'];?>
/?m=user"><i class="user"></i><em>会员管理</em></a></li>
  <li <?php if ($_smarty_tpl->tpl_vars['module']->value=='level'){?>class="cur"<?php }?>><a href="/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['admin_path'];?>
/?m=level"><i class="nav"></i><em>组与权限</em></a></li>
 </ul>
 <ul> 
  <li <?php if ($_smarty_tpl->tpl_vars['module']->value=='tag'){?>class="cur"<?php }?>><a href="/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['admin_path'];?>
/?m=tag"><i class="page"></i><em>标签管理</em></a></li>
  <li <?php if ($_smarty_tpl->tpl_vars['module']->value=='pic'){?>class="cur"<?php }?>><a href="/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['admin_path'];?>
/?m=pic"><i class="productCat"></i><em>全景图片</em></a></li>
  <li <?php if ($_smarty_tpl->tpl_vars['module']->value=='video'){?>class="cur"<?php }?>><a href="/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['admin_path'];?>
/?m=video"><i class="product"></i><em>全景视频</em></a></li>
 </ul>
 <ul> 
  <li <?php if ($_smarty_tpl->tpl_vars['module']->value=='articlecat'){?>class="cur"<?php }?>><a href="/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['admin_path'];?>
/?m=articlecat"><i class="articleCat"></i><em>文章分类</em></a></li>
  <li <?php if ($_smarty_tpl->tpl_vars['module']->value=='article'){?>class="cur"<?php }?>><a href="/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['admin_path'];?>
/?m=article"><i class="article"></i><em>文章管理</em></a></li>
 </ul>
 <ul class="bot">
  <li <?php if ($_smarty_tpl->tpl_vars['module']->value=='upgrade'){?>class="cur"<?php }?>><a href="/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['admin_path'];?>
/?m=upgrade&act=step_1"><i class="downloadCat"></i><em>自动升级</em></a></li>
 </ul>
 </div>
</div>
<div id="dcMain">
   <!-- 当前位置 -->
<div id="urHere"><?php echo $_smarty_tpl->tpl_vars['_lang']->value['title'];?>
 管理中心<?php if (!empty($_smarty_tpl->tpl_vars['nav']->value)){?><b>></b><strong><?php echo $_smarty_tpl->tpl_vars['nav']->value;?>
</strong><?php }?> </div>   
<div class="mainBox">
    <?php echo $_smarty_tpl->getSubTemplate ("lib/".($_smarty_tpl->tpl_vars['module']->value).".lbi", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</div>
</div>
<?php }?>
<div class="clear"></div>
<div id="dcFooter">
 <div id="footer">
  <div class="line"></div>
  <ul>
   Copyright&copy;2015　<?php echo $_smarty_tpl->tpl_vars['_lang']->value['title'];?>

  </ul>
 </div>
</div><!-- Footer 结束 -->
<div class="clear"></div> 
</div>

<script type="text/javascript" src="/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['admin_path'];?>
/template/js/global.js"></script>
<script type="text/javascript" src="/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['admin_path'];?>
/template/js/jquery.tab.js"></script>
<script type="text/javascript" src="/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['admin_path'];?>
/template/js/common.js"></script>
<script type="text/javascript" src="/static/js/jquery.form.js"></script>
<script type="text/javascript" src="/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['admin_path'];?>
/template/js/jquery.form.submit.js"></script>
<script type="text/javascript" src="/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['admin_path'];?>
/template/js/calendar.js"></script>
<script>
function clear_cache(ele) {
    if(confirm("该操作不会删除/temp/krpano目录下生成的临时切图文件，如果要删除请使用ftp手动删除！")){
        $(ele).css({
		            "background-image":"url(/static/images/tm_loading.gif)",
					"background-position":"left center ",
					"background-repeat":"no-repeat",
					"background-size":"15px",
					"padding-left":"20px",
				  });
		$.get('/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['admin_path'];?>
/?m=clear_cache',{
        },function(res){
          if (res.status==1) {
            $(ele).css({
			            "background-image":"none",
						"padding-left":"15px",
					  });
          }
        },'json');
    }
}
</script>
</body>
</html><?php }} ?>