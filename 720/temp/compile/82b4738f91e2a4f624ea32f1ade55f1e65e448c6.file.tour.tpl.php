<?php /* Smarty version Smarty-3.1.7, created on 2017-11-12 08:39:15
         compiled from "C:/PHPWAMP_IN1/wwwroot/720quanjing/template\zz_theme\tour.tpl" */ ?>
<?php /*%%SmartyHeaderCode:190065a079833eceb08-65451650%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '82b4738f91e2a4f624ea32f1ade55f1e65e448c6' => 
    array (
      0 => 'C:/PHPWAMP_IN1/wwwroot/720quanjing/template\\zz_theme\\tour.tpl',
      1 => 1478431615,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '190065a079833eceb08-65451650',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    '_lang' => 0,
    'pro' => 0,
    'plugins' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5a079834043de',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a079834043de')) {function content_5a079834043de($_smarty_tpl) {?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <title></title>
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta content="no-cache, no-store, must-revalidate" http-equiv="Cache-Control" />
    <meta content="no-cache" http-equiv="Pragma" />
    <meta content="0" http-equiv="Expires" />



    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <link rel="stylesheet" href="/template/<?php echo $_smarty_tpl->tpl_vars['_lang']->value['moban'];?>
/css/redefine.css">
    <script language="JavaScript" type="text/javascript" src="/static/js/kr/uhweb.js"></script>
    <script language="JavaScript" type="text/javascript" src="/static/js/kr/vrshow.js"></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <style>
        @-ms-viewport { width:device-width; }
        @media only screen and (min-device-width:800px) { html { overflow:hidden; } }
        html { height:100%; }
        body { height:100%; overflow:hidden; margin:0; padding:0; font-family:microsoft yahei, Helvetica, sans-serif;  background-color:#000000; }
    </style>
</head>
<body>

    <script language="JavaScript" type="text/javascript" src="/tour/tour.js"></script>
    <div id="fullscreenid" style="position:relative;width:100%; height:100%;">
        <div id="panoBtns" style="display:none">
            <div class="vrshow_container_logo">
                <img id="logoImg" src="/plugin/custom_logo/images/custom_logo.png" style="display: none;"  onclick="javascript:window.open('<?php echo $_smarty_tpl->tpl_vars['_lang']->value['host'];?>
')">

                <div class="vrshow_logo_title" id="user_name_wrap"  >
                    <div id="authorDiv" style="display: none;">作者：<span id="user_nickName"><?php echo $_smarty_tpl->tpl_vars['pro']->value['nickname'];?>
</span></div>
                    <div style="clear:both;"></div>

                </div>
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['plugins']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                    <?php if ($_smarty_tpl->tpl_vars['v']->value['enable']==1&&$_smarty_tpl->tpl_vars['v']->value['view_container']=="left_top"){?>
                        <?php echo $_smarty_tpl->getSubTemplate ("plugin/".($_smarty_tpl->tpl_vars['k']->value)."/template/view.lbi", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

                    <?php }?>
                <?php } ?>

            </div>

            <div class="vrshow_container_1_min">
                <div class="btn_fullscreen" onClick="fullscreen(this)" title="" style="display:none"></div>
                <!-- <div class="btn_bgmusic" onClick="pauseMusic(this)" style="display:none"></div> -->
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['plugins']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                    <?php if ($_smarty_tpl->tpl_vars['v']->value['enable']==1&&$_smarty_tpl->tpl_vars['v']->value['view_container']=="right_top"){?>
                        <?php echo $_smarty_tpl->getSubTemplate ("plugin/".($_smarty_tpl->tpl_vars['k']->value)."/template/view.lbi", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

                    <?php }?>
                <?php } ?>
                <!-- <div class="btn_music" style="display:none" onClick="pauseSpeech(this)"></div> -->
               <!--  <div class="btn_gyro"  onClick="toggleGyro(this)"></div> -->
                <!--<a class="btn_music" onclick="showthumbs()"></a>-->
                <!--<a class="btn_comment" onclick="addHotSpot()"></a>-->
                <!--<a class="btn_comment" onclick="openGyro()"></a>-->
            </div>
            <div class="vrshow_radar_btn" onClick="toggleKrpSandTable()">
                <span class="btn_sand_table_text">沙盘</span>
            </div>
            <div class="vrshow_tour_btn" onClick="startTourGuide()">
                <span class="btn_tour_text">一键导览</span>
            </div>
            <div class="vrshow_container_2_min">
            
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['plugins']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                    <?php if ($_smarty_tpl->tpl_vars['v']->value['enable']==1&&$_smarty_tpl->tpl_vars['v']->value['view_container']=="right_bottom"){?>
                        <?php echo $_smarty_tpl->getSubTemplate ("plugin/".($_smarty_tpl->tpl_vars['k']->value)."/template/view.lbi", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

                    <?php }?>
                <?php } ?>
            </div>
            

            <div class="vrshow_container_3_min">
                <div class="img_desc_container_min scene-choose-width" style="display:none">
                    <img src="/static/images/kr/vr-btn-scene.png" onClick="showthumbs()">
                    <div class="img_desc_min">场景选择</div>
                </div>
            </div>
        </div>
        
        <div id="pano" style="width:100%; height:100%;">
        </div>



   
		
		<div class="modal" id="pictextModal" data-backdrop="static" data-keyboard="false" style="z-index:2002">
            <div class="modal-dialog">
                <div class="modal-header text-center" >
                    <button type="button" class="close" onClick="hidePictext()"><span>&times;</span></button>
                    <span style="color: #353535;font-weight:700" id="pictextWorkName"></span>
                </div>
                <div class="modal-body" style="height:400px;overflow-y:scroll ">
                    <div class="row">                   
                        <div class="col-sm-offset-1 col-md-offset-1 col-md-10 col-sm-10 col-xs-12" id="pictextContent">
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
        <div class="modal" id="privacyPwdModal" data-backdrop="static" data-keyboard="false" style="z-index:2002">
            <div class="modal-dialog modal-350">
                <div class="modal-content">
                    <div class="modal-header login-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span
                                class="sr-only">关闭</span></button>
                        <img src="/static/images/logo.png">
                    </div>
                    <div class="modal-body padding-l-r">
                        <div class="row">
                            <div class="col-md-12">
                                <form class="form-horizontal" method="post" role="form">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <h6 class="text-center" style="margin-top:0;line-height: 2;color: #666;">请输入访问密码</h6>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="password" placeholder="访问密码" id="privacyPwd"
                                                       class="form-control btn-block">
                                            </div>
                                            <div class="col-md-12" style="margin-top: 20px;">
                                                <button class="btn btn-primary btn-block" type="button" id="pwdConfirmBtn">
                                                    确定
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div id="logreg">
        </div>
        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['plugins']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
            <?php if ($_smarty_tpl->tpl_vars['v']->value['enable']==1&&$_smarty_tpl->tpl_vars['v']->value['view_resource']==1){?>
                <?php echo $_smarty_tpl->getSubTemplate ("plugin/".($_smarty_tpl->tpl_vars['k']->value)."/template/resource.lbi", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

            <?php }?>
        <?php } ?>
    </div>

</body>
<script language="JavaScript" type="text/javascript" src="/static/js/kr/jssdk.js"></script>

</html><?php }} ?>