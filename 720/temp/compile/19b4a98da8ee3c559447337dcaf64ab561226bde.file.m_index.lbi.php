<?php /* Smarty version Smarty-3.1.7, created on 2017-11-12 08:34:17
         compiled from "C:/PHPWAMP_IN1/wwwroot/720quanjing/template\zz_theme\index\m_index.lbi" */ ?>
<?php /*%%SmartyHeaderCode:109095a079709987017-72992374%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '19b4a98da8ee3c559447337dcaf64ab561226bde' => 
    array (
      0 => 'C:/PHPWAMP_IN1/wwwroot/720quanjing/template\\zz_theme\\index\\m_index.lbi',
      1 => 1478155406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '109095a079709987017-72992374',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'i' => 0,
    'recommend' => 0,
    'video_recommmend' => 0,
    '_lang' => 0,
    'v' => 0,
    'new_join' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5a079709a219c',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a079709a219c')) {function content_5a079709a219c($_smarty_tpl) {?>	<div class="container">
	<div class="row">
		<script>
			function isMobile(){
			        if(/android/i.test(navigator.userAgent)){
			                return true;
			        }
			        if(/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)){
			                return true;
			        }
			        if(/Linux/i.test(navigator.userAgent)){
			                return true;
			        }
			        if(/Linux/i.test(navigator.platform)){
			                return true;
			        }
			        if(/MicroMessenger/i.test(navigator.userAgent)){
			                return true;
			        }

			        return false;
			}
			$(function(){
				if(isMobile()){
					$("#map_tour").css("height","350px");
				}
			})
		</script>
	</div>
	</div>
	<div class="container" style="padding: 0">
	<div class="row" id="jxpp">
		<div class="col-md-3">
			<h2 class="text-muted">精选品牌<small style="margin-left:10px;">优质的全景作品赏析</small></h2>
		</div>
	</div>
	<div class="row chosen_wrap" >
		<div class="col-md-5" style="height:445px;">
			<div id="myNiceCarousel" class="carousel slide" data-ride="carousel">
			  <!-- 轮播项目 -->
			  <div class="carousel-inner">
			   <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->value = 0;
  if ($_smarty_tpl->tpl_vars['i']->value<3){ for ($_foo=true;$_smarty_tpl->tpl_vars['i']->value<3; $_smarty_tpl->tpl_vars['i']->value++){
?>
			    <div class="item <?php if ($_smarty_tpl->tpl_vars['i']->value==0){?>active<?php }?>">
			     <img src="<?php echo $_smarty_tpl->tpl_vars['recommend']->value[$_smarty_tpl->tpl_vars['i']->value]['thumb_path'];?>
"  class="img-responsive" style="width: 100%;height: 445px;">
			      <div class="carousel-caption">
			        <h3><?php echo $_smarty_tpl->tpl_vars['recommend']->value[$_smarty_tpl->tpl_vars['i']->value]['name'];?>
</h3>
			      </div>
			    </div>
			   <?php }} ?>
			  </div>
			  <!-- 项目切换按钮 -->
			   <a class="left carousel-control" href="#myNiceCarousel" data-slide="prev">
			     <span class="icon icon-chevron-left"></span>
			   </a>
			   <a class="right carousel-control" href="#myNiceCarousel" data-slide="next">
			     <span class="icon icon-chevron-right"></span>
			   </a>
			 </div>
		</div>

		<div class="col-md-7">
			<div class="row chosen_wrap">
			    <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->value = 3;
  if ($_smarty_tpl->tpl_vars['i']->value<9){ for ($_foo=true;$_smarty_tpl->tpl_vars['i']->value<9; $_smarty_tpl->tpl_vars['i']->value++){
?>
				<div class="col-md-4 col-sm-4 col-xs-6 img_list">
					<a href="/tour/<?php echo $_smarty_tpl->tpl_vars['recommend']->value[$_smarty_tpl->tpl_vars['i']->value]['view_uuid'];?>
" target="_blank">
						<img src="<?php echo $_smarty_tpl->tpl_vars['recommend']->value[$_smarty_tpl->tpl_vars['i']->value]['thumb_path'];?>
" class="img-responsive">
					</a>
					<div style="position:relative">
						<div class="title_cover of_hide"><?php echo $_smarty_tpl->tpl_vars['recommend']->value[$_smarty_tpl->tpl_vars['i']->value]['name'];?>
</div>
					</div>
				</div>
			    <?php }} ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<h2 class="text-muted">全景视频<small style="margin-left:10px;">为您推荐的精选视频</small><a href="/pictures"><small class="text-muted  pull-right more">更多>></small></a></h2>
		</div>
	</div>
	<!--一个卡片列表行-->
	<div class="row" id="new_join">
		<div class="cards" style="margin:0;">
			<!--卡片列表循环-->
			<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['video_recommmend']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
			<div class="col-md-4 col-sm-4 col-xs-6 col-lg-3">
			   <div class="card" href="###">
			     <a target="_blank" href="<?php echo $_smarty_tpl->tpl_vars['_lang']->value['cdn_host'];?>
video/play.html?vid=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['v']->value['thumb_path'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
"></a>
			     <div class="card-heading">
			     	<div class="col-md-9 col-xs-8 of_hide padding0">
			     		<strong class="text-primary"><?php echo $_smarty_tpl->tpl_vars['v']->value['vname'];?>
</strong>
			     	</div>
			     	<div class="col-md-3 col-xs-4 of_hide padding0">
			     		<div class="pull-right text-danger"><i class="icon-heart-empty"></i> <?php echo $_smarty_tpl->tpl_vars['v']->value['browsing_num'];?>
</div>
			     	</div>
			     </div>
			     <div class="card-content text-muted">
			     <span class="of_hide"><?php echo $_smarty_tpl->tpl_vars['v']->value['profile'];?>
</span>
			     </div>
			   </div>
			 </div>
			<?php } ?>
			<!--卡片列表循环结束-->
		</div>
	</div>
	<!--一个卡片列表行结束-->


	<div class="row">
		<div class="col-xs-12">
			<h2 class="text-muted">最新入驻<small style="margin-left:10px;">他们刚刚在四元VR上传了自己的作品</small></h2>
		</div>
	</div>
	<!--一个卡片列表行-->
	<div class="row" id="new_join">
		<div class="cards" style="margin:0;">
			<!--卡片列表循环-->
			<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['new_join']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
			<div class="col-md-3 col-sm-3 col-xs-6 col-lg-2">
			   <div class="card" href="###">
			     <a target="_blank" href="/tour/<?php echo $_smarty_tpl->tpl_vars['v']->value['view_uuid'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['v']->value['thumb_path'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
"></a>
			     <div class="card-heading">
			     	<div class="col-md-9 col-xs-8 of_hide padding0">
			     		<strong class="text-primary"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</strong>
			     	</div>
			     	<div class="col-md-3 col-xs-4 of_hide padding0">
			     		<div class="pull-right text-danger"><i class="icon-heart-empty"></i> <?php echo $_smarty_tpl->tpl_vars['v']->value['browsing_num'];?>
</div>
			     	</div>
			     </div>
			     <div class="card-content text-muted">
			     <span class="of_hide"><?php echo $_smarty_tpl->tpl_vars['v']->value['profile'];?>
</span>
			     </div>
			   </div>
			 </div>
			<?php } ?>
			<!--卡片列表循环结束-->
		</div>
	</div>
	<!--一个卡片列表行结束-->

</div><?php }} ?>