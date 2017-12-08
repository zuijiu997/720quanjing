<?php /* Smarty version Smarty-3.1.7, created on 2017-11-11 01:27:36
         compiled from "plugin\bgvoice\template\edit_resource.lbi" */ ?>
<?php /*%%SmartyHeaderCode:34425a05e1888388a0-86469898%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b54dd7989bdfba77745fa1b6fc2b5ae290059cef' => 
    array (
      0 => 'plugin\\bgvoice\\template\\edit_resource.lbi',
      1 => 1475906307,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '34425a05e1888388a0-86469898',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5a05e18883af3',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a05e18883af3')) {function content_5a05e18883af3($_smarty_tpl) {?><div class="modal fade" id="voiceModal" data-backdrop="static" data-keyboard="false" data-position="5%">
    <div class="modal-dialog modal-lg">
         <div class="modal-header">
            <h2>语音解说</h2>
        </div>
        <div class="modal-content">
            <div class="voice">
                <div class="radio">
                    <label><input type="radio" name="radioSpeak" checked="checked" value="0"> 全局语音解说</label>
                    <label><input type="radio" name="radioSpeak" value="1"> 单个场景语音解说</label>
                </div>
                <div class="voice_content">
                    <div>
                        <div class="row">
                            <div class="col-md-4"><label>还未选择语音</label></div>
                            <div class="col-md-4"><a data-modalid="#media_icon" data-mediatype="1" data-imgtype="custom" href="javascript:void(0);" class="icon_media">从媒体库选择音乐</a></div>
                            <div class="col-md-4">
                                <div class="btn-group">
                                    <button class="btn voice-music-play" disabled="disabled" onclick="playVoice(this)">试听</button>
                                    <button class="btn" disabled="disabled" onclick="removeVoice(this)">移除</button>
                                    <audio src="" style="display:none" preload="none"></audio>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="display: none">

                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button class="btn btn-primary" data-dismiss="modal">完成</button>
        </div>
    </div>
</div>
<script src="/plugin/bgvoice/js/bgvoice_edit.js"></script><?php }} ?>