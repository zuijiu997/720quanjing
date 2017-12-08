<?php /* Smarty version Smarty-3.1.7, created on 2017-11-13 15:23:49
         compiled from "C:/PHPWAMP_IN1/wwwroot/720/vradmin/template\lib\voice.lbi" */ ?>
<?php /*%%SmartyHeaderCode:120595a09488532e2f0-31632016%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4f8e8c48183232597f241ddcf127828fdeb983cb' => 
    array (
      0 => 'C:/PHPWAMP_IN1/wwwroot/720/vradmin/template\\lib\\voice.lbi',
      1 => 1477478911,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '120595a09488532e2f0-31632016',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'act' => 0,
    'up_url' => 0,
    '_lang' => 0,
    'lists' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5a09488539bd3',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a09488539bd3')) {function content_5a09488539bd3($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['act']->value=='add'){?>
    	<script src=""></script>
    				<table class="tableBasic" border="0" cellpadding="4" cellspacing="0"  width="100%">
    					<tbody>
    					<tr>
    						<th width="120"><i class="require-red">*</i>标题：</th>
    						<td>
    							<input class="common-text required" name="title" id="title"  type="text">
    							请填写1到20个字符
    						</td>
    					</tr>
    					<tr>
    						<th width="120"><i class="require-red">*</i>上传素材：</th>
    						<td>
    							<div style="float: left;">
    								<button id="material_input" class="btn">选择文件</button>
    							</div>
    							<div style="float: left;line-height: 30px;width: 200px;" id="progress_material_input">

    							</div>
    						</td>

    					</tr>
    					<tr id="dyn_thumb_tr" style="display: none;">
    						<th width="120"><i class="require-red">*</i>动态热点缩略图：</th>
    						<td>
    							<div style="float: left;">
    								<button id="dyn_thumb_input" class="btn">选择文件</button>
    							</div>
    							<div style="float: left;line-height: 30px;width: 200px;" id="progress_dyn_thumb_input">

    							</div>
    							<div style="float: left; margin-left: 50px ; line-height: 30px;">
    							动态热点需要额外上传一张缩略图,  示例：<a href="">缩略图</a>
    							</div>
    						</td>

    					</tr>
    					<tr>
    						<th></th>
    						<td>
    						    <div id="wrong_text" class="warning" style="display:none"></div>
    							<div class="clear"></div>
    							<input type="button" class="btn btn-primary btn6 mr10" value="提交" id="sub_btn">
    							<input class="btn btn6" onClick="history.go(-1)" value="返回" type="button">
    						</td>
    					</tr>
    					</tbody>
    				</table>
    			<script language="JavaScript" type="text/javascript" src="/static/js/plupload/moxie.js"></script>
    			<script language="JavaScript" type="text/javascript" src="/static/js/plupload/plupload.dev.js"></script>
    			<script>
    				var up_url = '<?php echo $_smarty_tpl->tpl_vars['up_url']->value;?>
';
    				var key ;
    				var qn_token;
    				var material_up;
    				var dyn_thumb_up;
    				var url = '/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['admin_path'];?>
/?m=voice&act=add';
    				
    				$(function(){
    					material_up = getUploader("material_input");
    					$("#type").change(function(){
    						if($(this).val() == 1){
    							$("#dyn_thumb_tr").show();
    							dyn_thumb_up = getUploader("dyn_thumb_input");
    						}
    					});
    					$("#sub_btn").click(function(){
    						var params = {};
    						var flag1 = false;

    						params.title = $.trim($("#title").val());
    						if (params.title.length<1||params.title.length>20) {
    							alert("请填写1到20个字符的标题");
    							return false;
    						}

    						$("#sub_btn").val("正在提交");
    						$("#sub_btn").attr("disabled","disabled");
    						material_up.start();
    						material_up.bind('FileUploaded',function(up,file,info){
    							params.absolutelocation = up.getOption().multipart_params.key;
    							flag1 = true;
    						});

    						if (dyn_thumb_up) {
    							dyn_thumb_up.start();
    							dyn_thumb_up.bind('FileUploaded',function(up,file,info){
    								params.thumb_path = up.getOption().multipart_params.key;
    							});
    						}
    						var inter = setInterval(function(){
    							if (flag1) {
    								clearInterval(inter);
    								$.post(url,{
    									'params':JSON.stringify(params)
    								},function(res){
    									if (res.status==1) {
    										$("#sub_btn").val("编辑成功");
    										setTimeout(function(){
    											window.location.href = url;
    										},1000);
    									}else{
    										alert(res.msg);
    										$("#sub_btn").removeAttr("disabled");
    									}
    								},'json');
    							}
    						},500);

    					});
    				})
    				function set_upload_param(up, filename, ret)
    				{
    				    if (ret == false)
    				    {
    				        qn_token ={};
    		            	$.ajax({
    		            		url:"/get_token.php",
    		            		data:{"act":"def_material"},
    		    	    		async: false,
    		    	    		success:function(result){
    		    	    		 	result = eval("("+result+")");
    	 		    	    		qn_token.prefix= result.prefix;
    		    	    		 	if (qn_token.policy) {
    	 			    		 		qn_token.policy = result.policy;
    	 			    		 		qn_token.OSSAccessKeyId = result.accessid;
    	 			    		 		qn_token.host = result.host;
    	 			    		 		qn_token.signature = result.signature;
    		    	    		 	}else{
    		    	    		 		qn_token.token = result.token;
    		    	    		 	}

    		    	    		}
    		    	    	})
    				    }else{
    			            key = qn_token.prefix+generic_name()+filename.substr(filename.lastIndexOf("."));
    			            var new_multipart_params;
    			            if (qn_token.policy) {
    			            	new_multipart_params = {
    						        'key' : key,
    						        'policy': qn_token.policy,
    						        'OSSAccessKeyId': qn_token.OSSAccessKeyId,
    						        'success_action_status' : '200', //让服务端返回200,不然，默认会返回204
    						        'host' : qn_token.host,
    						        'signature': qn_token.signature,
    					    	}
    			            }else{
    			            	 new_multipart_params = {
    					        	'key' : key,
    					        	'token':qn_token.token
    					    	}
    			            }
    					    up.setOption({
    					        'url': up_url,
    					        'multipart_params': new_multipart_params
    					    });
    					}
    				}
    				function generic_name() {
    				　　var $chars = 'abcdefghijklmnopqrstwxyz0123456789';
    				　　var maxPos = $chars.length;
    				　　var pwd = '';
    				　　for (i = 0; i < 3; i++) {
    				　　　　pwd += $chars.charAt(Math.floor(Math.random() * maxPos));
    				　　}
    				　　return new Date().getTime()+pwd;
    				}
    				function getUploader(pk){
    				 var uploader = new plupload.Uploader({
    				    runtimes : 'html5,flash,silverlight,html4',
    				    browse_button : pk,
    				    multi_selection: false,
    				    flash_swf_url: '/static/js/plupload/Moxie.swf',
    				    silverlight_xap_url : '/static/js/plupload/Moxie.xap',
    				    url : up_url,
    				    filters: {
    			            mime_types : [ //只允许上传图片
    			            { title : "Img files", extensions : "mp3,wav,au,snd,raw,afc" },
    			            ],
    			            max_file_size : '10240kb', //
    			            prevent_duplicates : true //不允许选取重复文件
    			        },
    				    init: {
    				        PostInit: function() {
    				        	set_upload_param(uploader, '', false);
    				        },
    				        FilesAdded: function(up, files) {
    							var file= files[files.length-1];
    							$("#progress_"+pk).append('<div class="progress" id="'+file.id+'">'+
    									'<div class="progress-bar" style="width: 0%">'+
    									'</div><span class="text-muted" style="font-size:11px;font-weight:normal;">点击下方提交按钮开始上传</span>'+
    								'</div>');
    							$("#progress_"+pk).show();
    				            return false;
    				        },
    				        BeforeUpload: function(up, file) {
    				            $("#"+pk).css('pointer-events','none');
    				            set_upload_param(up, file.name, true);
    				        },

    				        UploadProgress: function(up, file) {
    				            var d = document.getElementById(file.id);
    				            d.getElementsByTagName('span')[0].innerHTML = '  ' + file.percent + "%";
    				            var progBar = d.getElementsByTagName('div')[0];
    				            progBar.style.width= file.percent+'%';
    				            progBar.setAttribute('aria-valuenow', file.percent);
    				        },

    				        // FileUploaded: function(up, file, info) {
    				        //     if (info.status == 200)
    				        //     {
    				        //     	$("#"+file.id).data("imgsrc",key);
    				        //     }
    				        //     else
    				        //     {
    				        //         alert("上传失败");
    				        //     }
    				        //     $("#selectfiles").css('pointer-events','');
    				        // },

    				        Error: function(up, err) {
    				            if (err.code == -600) {
    				                alert("选择的文件太大了,不能超过10mb");
    				            }
    				            else if (err.code == -601) {
    				                 alert("只能上传jpg、gif、png格式大小的图片");
    				            }
    				            else if (err.code == -602) {
    				                 alert("这个文件已经上传过一遍了");
    				            }
    				            else
    				            {
    				                alert("上传异常");
    				            }
    				        }
    				    }
    				 });
    				 uploader.init();
    				 return uploader;
    			}
    				
    			</script>
<?php }else{ ?>
	   <h3>
	   		<a href="/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['admin_path'];?>
/?m=voice&act=add" class="actionBtn add" style="margin-top: -10px;">添加素材</a>
		</h3>
		<table  class="tableBasic" border="0" cellpadding="8" cellspacing="0"  width="100%" style="text-align: center;">
			<tr>
				<th>音频名称</th>
				<th>试听</th>
				<th>操作</th>
			</tr>
			<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['lists']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
			<tr>
				<td><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</td>
				<td><audio controls="controls">
                      <source src="<?php echo $_smarty_tpl->tpl_vars['v']->value['absolutelocation'];?>
" type="audio/mpeg">
                    </audio>
				</td>
				<td><a class="del" href="javascript:;" onclick="delete_voice(<?php echo $_smarty_tpl->tpl_vars['v']->value['pk_voice'];?>
)">删除</a></td>
			</tr>
			<?php } ?>
		</table>
		<script>
			function delete_voice(tid){
				  if(confirm("确认删除该音频吗？")){
					$.post("/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['admin_path'];?>
/?m=voice&act=del",
						{
							"tid":tid
						},function(data){
								data = eval("("+data+")");
								if (data.status==1) {
									alert('成功删除音频');
									window.location.reload();
								}else{
									alert(data.msg);
								}
						})
				  }
			}
		</script>
<?php }?>	<?php }} ?>