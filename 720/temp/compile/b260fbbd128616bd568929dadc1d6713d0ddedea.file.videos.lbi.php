<?php /* Smarty version Smarty-3.1.7, created on 2017-11-11 00:58:48
         compiled from "C:/PHPWAMP_IN1/wwwroot/720quanjing/template\default\index\videos.lbi" */ ?>
<?php /*%%SmartyHeaderCode:243825a05dac88a7235-68571840%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b260fbbd128616bd568929dadc1d6713d0ddedea' => 
    array (
      0 => 'C:/PHPWAMP_IN1/wwwroot/720quanjing/template\\default\\index\\videos.lbi',
      1 => 1479549043,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '243825a05dac88a7235-68571840',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    '_lang' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5a05dac88eeae',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a05dac88eeae')) {function content_5a05dac88eeae($_smarty_tpl) {?><style type="text/css">
h2.video-tit{
color:#888;font-weight:normal
}
h2.video-tit a{
font-size:14px;
}
h2.video-tit .btn{
padding:2px 5px;
}
.of_hide{
	display: block;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>
<div class="container">

<h2 class="video-tit">全景视频
<div style="float:right">
<a onclick="list_by_recommend(1,this)" class="btn btn-primary">精选</a>　<a onclick="list_by_recommend(0,this)"  class="btn">全部</a>
</div>
</h2>

<div class="clearfix"></div>

<!--一个卡片列表行-->
<div class="row">
	<div class="cards" style="margin:0;" id="video_content">
		<!--卡片列表循环-->
	         
		<!--卡片列表循环结束-->	
	</div>
</div>
<!--一个卡片列表行结束-->

</div>
<script>
	var play_host = '<?php echo $_smarty_tpl->tpl_vars['_lang']->value['cdn_host'];?>
video/play.html?vid=';
 	var page = 1;
 	var recommend = 1 ;
	$(function(){
		list();
		$(window).scroll(function(){
		　　var scrollTop = $(this).scrollTop();
		　　var scrollHeight = $(document).height();
		　　var windowHeight = $(this).height();
		　　if(scrollTop + windowHeight == scrollHeight){
		　　　　list();
		　　}
		});
	})
	function list(){
		alert_notice("加载中...",'success','bottom',500);
		$.post('/videos',{
			'act':'list',
			'recommend':recommend,
			'page':page
		},function(res){
			if (res.length==0) {
				alert_notice("没有更多了",'default','bottom');
			}else{
				var html = '';
				for(var i=0 ; i<res.length;i++){
					var p = res[i];
					html+='<div class="col-md-3 col-sm-3 col-xs-6 col-lg-3">'+
					   '<div class="card" href="###">'+
						' <a target="_blank" href="'+play_host+p.id+'"><img src="'+p.thumb_path+'" alt="'+p.vname+'"></a>'+
						 '<div class="card-heading">'+
						'	<div class="col-md-9 col-xs-8 of_hide padding0">'+
						'		<strong class="text-primary">'+p.vname+'</strong> '+
						'	</div>'+
						'	<div class="col-md-3 col-xs-4 of_hide padding0">'+
						'		<div class="pull-right text-danger"><i class="icon-heart-empty"></i>'+p.browsing_num+'</div>'+
						'	</div>'+
						' </div>'+
					 ' </div>'+
					' </div>';
				}
				page++;
				$("#video_content").append(html);
			}
			
		},'json');
	}
	function list_by_recommend(_recommend,obj){
		page=1;
		recommend = _recommend
		$("#video_content").html("");
		list();
		$(obj).siblings().removeClass("btn-primary");
		$(obj).addClass("btn-primary");
	}
</script><?php }} ?>