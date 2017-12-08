/**
 *      本程序由尹兴飞开发
 *      若要二次开发或用于商业用途的，需要经过尹兴飞同意。
 *
 *		http://app.yinxingfei.com			插件技术支持
 *
 *		http://www.cglnn.com			    插件演示站点
 *
 ->		==========================================================================================
 *
 *      2014-11-01 开始由6.1升级到6.2！
 *
 *		愿我的同学、家人、朋友身体安康，天天快乐！
 ->		同时也祝您使用愉快！
 */
var zzza_jq = jQuery.noConflict();
var isBegin = false;
zzza_jq(document).ready(function(){
	juzhong();
	juzhong();
	juzhong();
});
function yjyema(){
	zzza_jq(".yyl-random-box").slideToggle(1000);
}
function juzhong(){
	var a = document.getElementById("yyl-random-box");
	a.style.left = (zzza_jq(window).width()/2 - 585/2)+"px";
	a.style.top = (zzza_jq(window).scrollTop()+zzza_jq(window).height()/2 - 403/2)+"px";
	zzza_jq(".yyl-random-box").css('display','block');
}
function go_yj(){
	if(isBegin) return false;
	isBegin = true;
	
	var num = document.getElementById('zzza_fw1').value;
	var num_arr = (num+'').split('');
	zzza_jq(".yinxingfei_zzza_num").each(function(index){
		var num = zzza_jq(this).children();
		var gbz = -693 + (77*num_arr[index]);
		setTimeout(function(){
			num.animate({
				'marginTop': gbz
			},{
				duration: 3000+index*1000,
				easing: "easeInOutCirc",
				complete: function(){
					if(index==2){ 
						isBegin = false;
						document.getElementById('yinxingfei_zzza_form').submit();
					}
				}
			});
		}, index * 100);
	});
}