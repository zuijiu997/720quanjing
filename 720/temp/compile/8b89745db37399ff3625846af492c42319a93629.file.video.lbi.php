<?php /* Smarty version Smarty-3.1.7, created on 2017-11-13 21:44:02
         compiled from "C:/PHPWAMP_IN1/wwwroot/720/template\edit\lib\video.lbi" */ ?>
<?php /*%%SmartyHeaderCode:283225a09a1a2abdfc7-88858130%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8b89745db37399ff3625846af492c42319a93629' => 
    array (
      0 => 'C:/PHPWAMP_IN1/wwwroot/720/template\\edit\\lib\\video.lbi',
      1 => 1482227802,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '283225a09a1a2abdfc7-88858130',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'video' => 0,
    'tag_list' => 0,
    'list' => 0,
    'source' => 0,
    'k' => 0,
    'v' => 0,
    'cdn_host' => 0,
    '_lang' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5a09a1a2b7981',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a09a1a2b7981')) {function content_5a09a1a2b7981($_smarty_tpl) {?><div class="works-container">
<div class="container container_works" style="margin-top: 0;">
    <div class="row">
        <div class="col-md-10">
            <ol class="breadcrumb clear_padding_left">
                <li><a href="/member/project?act=videos"><i class="icon icon-home"></i>&nbsp;作品列表</a></li>
                <li class="active"><?php echo $_smarty_tpl->tpl_vars['video']->value['vname'];?>
</li>
            </ol>
        </div>
    </div>

    <div class="row row_margin_bottom" style="margin-top: 0px;">
        <div class="col-md-10 advanced-setting-block" style="padding-top:10px;padding-bottom:10px;">
            <div class="row">
                <div class="col-md-4">
                    <img id="thumbpath" style="height:200px;" class="img-responsive" src="<?php if ($_smarty_tpl->tpl_vars['video']->value['thumb_path']){?><?php echo $_smarty_tpl->tpl_vars['video']->value['thumb_path'];?>
<?php }else{ ?>/static/images/play.png<?php }?>">
                    <div class="col-md-12 row_margin_bottom" style="padding: 0">
                        <!-- <input id="picUpload" name="file" type="file" class="file-loading"> -->
                        <button type="button" id="workCover" data-imgtype="custom" data-usetype="workCover" data-modalid="#media_icon" class="btn btn-block">从素材库选择封面</button>
                        <span class="help-block">请选择或上传2比1的封面图片
                        </strong> 支持格式: <strong class="text-warning">JPG / PNG / JPEG </strong></span>
                    </div>
                    <div id="errorMsgDiv" class="col-md-12 text-danger" style="padding: 0;display: none">
                        <i class="icon icon-exclamation-sign"></i>
                        <span id="errorMsg"></span>
                    </div>

                </div>
                <div class="col-md-8">
                    <form class="form-horizontal" method="post" role="form">
                        <div class="form-group">

                            <label class="col-md-2 control-label">作品标题</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="vname" name="vname" value="<?php echo $_smarty_tpl->tpl_vars['video']->value['vname'];?>
" placeholder="请输入全景作品名称" maxlength="100">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">作品介绍</label>
                            <div class="col-md-10">
                                <textarea class="form-control" rows="4" id="profile" name="profile"  placeholder="请输入全景作品简介" maxlength="800"><?php echo $_smarty_tpl->tpl_vars['video']->value['profile'];?>
</textarea>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-md-2 control-label">标签</label>
                            <div class="col-md-10">
                                 <select data-placeholder="请选择3个以内的标签" id="video_chosen" class="chosen-select form-control" tabindex="-1" multiple="">
                                    <?php  $_smarty_tpl->tpl_vars['list'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['list']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['tag_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['list']->key => $_smarty_tpl->tpl_vars['list']->value){
$_smarty_tpl->tpl_vars['list']->_loop = true;
?>
                                        <option value="<?php echo $_smarty_tpl->tpl_vars['list']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['list']->value['selected']){?>selected = "selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['list']->value['name'];?>
</option>
                                    <?php } ?>
                                 </select>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-md-2 control-label">公开作品</label>
                               <div class="col-md-2" data-toggle="tooltip" title="若不想作品被浏览，可选择不发布该作品" >
                                  <div class="checkbox">
                                      <label>
                                        <input id="flag_publish" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['video']->value['flag_publish']){?>checked="checked"<?php }?> > 是
                                      </label>
                                    </div>
                              </div>
                        </div>
                    </form>
                </div>
            </div>

      
        </div>
        <div class="col-md-2">
            <div class="btn_fixed_works">
                <button class="btn btn-block btn-primary" onclick="update_videos(<?php echo $_smarty_tpl->tpl_vars['video']->value['id'];?>
)" type="button" id="save_btn">保存</button>
                <button class="btn btn-block advanced-setting-btn" type="button" onclick="preview_videos(<?php echo $_smarty_tpl->tpl_vars['video']->value['id'];?>
)">预览</button>
            </div>
        </div>
    </div>

    <h3>视频列表
        <small>共<?php echo count($_smarty_tpl->tpl_vars['source']->value);?>
个视频</small>
    </h3>

    <div class="row">
        <div class="col-md-10 advanced-setting-block">
            <div class="row" style="margin-top:5px;" id="source_wrap">
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['source']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                <div class="col-md-4 " id="source_<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
">
                    <a class="card">
                    <div class="top_cover"><span class="pull-right" onclick="delete_source(<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
)"><i class="icon-trash"></i>删除</span></div>
                    <img src="<?php echo $_smarty_tpl->tpl_vars['v']->value['thumb_path'];?>
" style="height:200px;width:100%" >
                    <div class="card-content">
                        <div class="row">
                            <div class="col-md-8"><span class="text-muted card_text" ><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</span></div>
                            <div class="col-md-4">
                                <input type="text" class="form-control " maxlength="4" style="margin-top:10px" data-location="<?php echo $_smarty_tpl->tpl_vars['v']->value['location'];?>
" placeholder="清晰度" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['progressive'];?>
">
                            </div>
                         </div>
                      </div>
                    </a>
                </div>
                <?php } ?>

            </div>
        </div>
    </div>

    <h3>作品使用和分享</h3>

    <div class="row">
        <div class="col-md-10 advanced-setting-block" style="padding-top:10px">
            <form class="form-horizontal" method="post" role="form">
                <div class="form-group">
                    <label class="col-md-2 control-label"><a href="<?php echo $_smarty_tpl->tpl_vars['cdn_host']->value;?>
video/play.html?vid=<?php echo $_smarty_tpl->tpl_vars['video']->value['id'];?>
"  target="_blank">作品地址</a></label>

                    <div class="col-md-8">
                        <input type="text" class="form-control" id="videolocation" name="videoname" value="<?php echo $_smarty_tpl->tpl_vars['cdn_host']->value;?>
video/play.html?vid=<?php echo $_smarty_tpl->tpl_vars['video']->value['id'];?>
">
                    </div>
                    <div class="col-md-2">
                        <button class="btn copyable" type="button">复制</button>
                   </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">嵌入到网站</label>

                    <div class="col-md-8">
                        <input type="text" class="form-control" id="video_site" name="video_site" value='<iframe width="100%" height="500px" src="<?php echo $_smarty_tpl->tpl_vars['cdn_host']->value;?>
video/play.html?vid=<?php echo $_smarty_tpl->tpl_vars['video']->value['id'];?>
" frameborder="no" border="0" ></iframe>'>
                    </div>
                    <div class="col-md-2">
                        <button class="btn copyable" type="button">复制</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


</div>
</div>
<div class="modal fade" id="media_icon" data-backdrop="static" data-keyboard="false" data-position="5%">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <ul id="myTab" class="nav nav-tabs">
                    <li class="active"><a href="#pic" data-toggle="tab" class="img_tab">图片</a></li>
                    <li><a href="#upload" data-toggle="tab" id="upload_tab">上传</a></li>
                    <div class="btn_confirm">
                        <li>
                            <button class="btn btn-primary confirm-choose" type="button" onclick="confirmChoseCover()">确定选择</button>
                        </li>
                        <li>
                            <button class="btn" type="button" id="cancel_icon" data-dismiss="modal">取消
                            </button>
                        </li>
                    </div>
                </ul>
                <div id="myTabContent" class="tab-content" style="height:410px;overflow: auto;">
                    <div class="tab-pane fade clearfix active in" id="pic">
                    </div>
                    <div class="tab-pane fade" id="upload">
                       <input id="imgUpload" name="file" type="file" class="">
                        <p id="mediaTyPrompt">上传文件格式：png、jpg格式。</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var cdn_host = "<?php echo $_smarty_tpl->tpl_vars['cdn_host']->value;?>
";
var up_url = "<?php echo $_smarty_tpl->tpl_vars['_lang']->value['up_url'];?>
";
</script>
<script src="/static/js/jquery.zclip.min.js"></script>
<script src="/static/js/kr/choose_cover.js"></script>
<script src="/static/js/kr/video_edit.js"></script>
<?php }} ?>