<?php /* Smarty version Smarty-3.1.7, created on 2017-11-15 10:25:06
         compiled from "C:/PHPWAMP_IN1/wwwroot/720/template\default\passport\findpwd.lbi" */ ?>
<?php /*%%SmartyHeaderCode:202945a0ba5829343c7-08633497%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c214ea153b4ec46dc6910970d1cf03cc72746ba4' => 
    array (
      0 => 'C:/PHPWAMP_IN1/wwwroot/720/template\\default\\passport\\findpwd.lbi',
      1 => 1479196293,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '202945a0ba5829343c7-08633497',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    '_lang' => 0,
    'step' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5a0ba582995f1',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a0ba582995f1')) {function content_5a0ba582995f1($_smarty_tpl) {?><div class="container">
	
	<div class="passport_container">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<a href="/"><img src="/static/images/logo.png" alt="<?php echo $_smarty_tpl->tpl_vars['_lang']->value['title'];?>
"></a>
			</div>
		</div>
		<div class="row top15">
			<h3>与世界分享你的全景</h3>
		</div>
		<div class="row top15">
			<div class="col-md-3 col-md-offset-3 <?php if ($_smarty_tpl->tpl_vars['step']->value=='validate'){?>text-success<?php }?>"><strong>验证手机</strong></div> 
			<div class="col-md-3 <?php if ($_smarty_tpl->tpl_vars['step']->value=='reset'){?>text-success<?php }?>"><strong>重设密码</strong></div>
		</div>
		<div class="row ">
			<div class="col-md-12 top15">
			<?php if ($_smarty_tpl->tpl_vars['step']->value=='validate'){?>
			<form id="find_form" action="/passport/findpwd" method="post">
				<div class="input-group top15">
				 <span class="input-group-addon">验证码</span>
				  <input type="text" id="pic_captcha" class="form-control" width="200">
				  <span class="input-group-addon" style="width:60px;padding:0;border:0"><img id="captcha_img" src="/captcha.php?act=find" alt="点击图片，切换验证码" style="width:100%;height:32px;cursor:pointer"></span>
				</div>
				<div class="input-group top15">
				  <span class="input-group-addon"><i class="icon icon-tablet"></i></span>
				  <input type="text" id="phone" name="phone" class="form-control" placeholder="手机号" width="200">
				  <span class="input-group-btn">
				      <button class="btn btn-info" type="button" id="send_btn">获取验证码</button>
				   </span>
				</div>
				<div class="input-group top15">
				 <span class="input-group-addon">手机验证码</span>
				  <input type="text" id="sms_captcha" name="sms_captcha" class="form-control">
				</div>
				<button class="btn btn-block btn-primary top15" type="button" id="find_btn" onclick="ajaxFormSubmit('find_form','find_btn');">验证手机</button>
			</form>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['step']->value=='reset'){?>
			<form id="find_form" action="/passport/findpwd" method="post">
				<div class="input-group top15">
				 <span class="input-group-addon">密　　码</span>
				  <input type="password" name="pwd" class="form-control">
				</div>
				<div class="input-group top15">
				 <span class="input-group-addon">重复密码</span>
				  <input type="password" name="repwd" class="form-control">
				</div>
				<button class="btn btn-block btn-primary top15" type="button" id="find_btn" onclick="ajaxFormSubmit('find_form','find_btn');">重设密码</button>
			</form>
			<?php }?>
			</div>
		</div>
	</div>

</div>
<script src="/static/js/sendsms.js"></script>
<script type="text/javascript">
    $("#captcha_img").click(function(){
		$(this).attr('src','/captcha.php?act=find&v'+(new Date().getTime()));
	});
	$("#send_btn").click(function(){
		$(".input-group").removeClass('has-error');
		var pic_captcha = $.trim($("#pic_captcha").val());
		if (pic_captcha=="") {
			showerr("请输入正确图形验证码",$("#pic_captcha"));
			return false;
		}
		var phone = $.trim($("#phone").val());
		if (phone.length!=11) {
			showerr("请输入正确的手机号",$("#phone"));
			return false;
		}
		sendSms("find",phone,pic_captcha);
	})
</script><?php }} ?>