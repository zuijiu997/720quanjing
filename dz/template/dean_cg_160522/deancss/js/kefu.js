// 懒人图库 搜集整理 www.lanrentuku.com
jq(function(){
	var tophtml="<div id=\"izl_rmenu\" class=\"izl-rmenu\"><a href=\"tencent://Message/?Uin=3555729100&websiteName=#=&Menu=yes\" class=\"btn btn-qq\"></a><div class=\"btn btn-wx\"><img class=\"pic\" src=\"./template/dean_cg_160522/deancss/wx.png\" onclick=\"window.location.href=\'#\'\"/></div><div class=\"btn btn-phone\"><div class=\"phone\">18990183328</div></div><div class=\"btn btn-top\"></div></div>";
	jq("#top").html(tophtml);
	jq("#izl_rmenu").each(function(){
		jq(this).find(".btn-wx").mouseenter(function(){
			jq(this).find(".pic").fadeIn("fast");
		});
		jq(this).find(".btn-wx").mouseleave(function(){
			jq(this).find(".pic").fadeOut("fast");
		});
		jq(this).find(".btn-phone").mouseenter(function(){
			jq(this).find(".phone").fadeIn("fast");
		});
		jq(this).find(".btn-phone").mouseleave(function(){
			jq(this).find(".phone").fadeOut("fast");
		});
		jq(this).find(".btn-top").click(function(){
			jq("html, body").animate({
				"scroll-top":0
			},"fast");
		});
	});
	var lastRmenuStatus=false;
	jq(window).scroll(function(){//bug
		var _top=jq(window).scrollTop();
		if(_top>200){
			jq("#izl_rmenu").data("expanded",true);
		}else{
			jq("#izl_rmenu").data("expanded",false);
		}
		if(jq("#izl_rmenu").data("expanded")!=lastRmenuStatus){
			lastRmenuStatus=jq("#izl_rmenu").data("expanded");
			if(lastRmenuStatus){
				jq("#izl_rmenu .btn-top").slideDown();
			}else{
				jq("#izl_rmenu .btn-top").slideUp();
			}
		}
	});
});