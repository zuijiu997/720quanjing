<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('sign');?><?php include template('common/header'); ?><h3 class="flb">
<em id="return_sign">每日签到</em>
<span><a href="javascript:;" onclick="hideWindow('sign');" class="flbc" title="关闭">关闭</a></span>
</h3>
<style type="text/css">
.layer_dcsignin { padding: 10px 0 0; width: 322px; overflow: hidden; position: relative; }
.layer_dcsignin .dcsignin_title{background:url("source/plugin/dc_signin/images/top.png")  no-repeat;	width
:162px;	height:15px;	margin:0 15px 10px;}
.layer_dcsignin .dcsignin_list{	padding:0 0 5px 15px;	}
.layer_dcsignin .dcsignin_list li{	float:left;	text-align:center;	cursor:pointer;	height:60px;	}
.layer_dcsignin .dcsignin_list li div{	padding:4px 5px 2px;	width:48px;}
.layer_dcsignin .dcsignin_list li.current div{	border:1px solid #99d0ff;	background:#eaf6ff;	padding:3px 4px
 1px;}

.layer_dcsignin .dcsignin_list li img{	display:block;	margin:0 0 3px;	margin-left:8px;	*margin-left:3px;}
.layer_dcsignin .dcsignin_send{	padding:5px 15px;}
.layer_dcsignin .dcsignin_send textarea{	width:280px;	padding:5px;	border:1px solid #c6c6c6;	font-family:"Tahoma"
;	line-height:18px;	height:55px;}

</style>
<form method="post" id="signform" action="plugin.php?id=dc_signin:sign" onsubmit="ajaxpost(this.id, 'floatlayout_signin','','onerror');return false;">
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>" />
<input type="hidden" name="signsubmit" value="yes" />
<input type="hidden" name="handlekey" value="signin" />
<input type="hidden" name="emotid" id="emotid" />
<input type="hidden" name="referer" value="<?php echo dreferer();; ?>" />
<div class="layer_dcsignin">
<div class="dcsignin_title"></div>
<ul class="dcsignin_list"><?php if(is_array($emots)) foreach($emots as $e) { ?><li onmouseover="this.className='current'" onmouseout="this.className=$('emotid').value==<?php echo $e['id'];?>?this.className:''" onclick="check(this, <?php echo $e['id'];?>)"><div class="dcsignin2"><img width="32" height="32" id="emot_<?php echo $e['id'];?>" src="source/plugin/dc_signin/images/emot/<?php echo $e['icon'];?>" title="<?php echo $e['text'];?>" alt="<?php echo $e['name'];?>"><?php echo $e['name'];?></div></li>
<?php } ?>
</ul>
<div class="dcsignin_send">
 		<textarea name="content" id="content"></textarea>
 	</div>
</div>
<p class="o pns">
<button type="submit" name="signpn" value="true" class="pn pnc"><strong>确定</strong></button>
</p>
</form>
<div id="floatlayout_signin" style="display:none"></div>
<script type="text/javascript">
function check(obj, id) {
var lis = obj.parentNode.childNodes;
for(var i = 0; i < lis.length; i ++) {
lis[i].className = '';
}
obj.className = 'current';
$('emotid').value = id;
$('content').innerText = $('emot_' + id).title;
}
function succeedhandle_signin(href, message, param){
hideWindow('<?php echo $_GET['handlekey'];?>');
showDialog(message, 'right', '', 'window.location.href=\''+href+'\'', '','','','','','',3);
}
</script><?php include template('common/footer'); ?>