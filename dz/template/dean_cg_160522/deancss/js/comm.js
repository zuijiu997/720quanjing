/**
 * Created with IntelliJ IDEA.
 * Date: 13-5-27
 * Time: 下午3:56
 * To change this template use File | Settings | File Templates.
 */

jq.fn.focusShow = function () {
    var obj = jq(this);

    //幻灯切换
    var topCol = obj.find(".topCol");

    var topItem = topCol.find("a");
    var topItemLength = topItem.length;

    var topNow = 0;
    var timer;

    var points = jq("<ul></ul>");
    topCol.append(points);

    for (var i = 0; i < topItemLength; i++) {
        points.append("<li></li>")
    }
    var point = points.find("li");
    point.first().addClass("now");

    var scrollTop = function() {
        point.filter(".now").removeClass("now");
        point.eq(topNow).addClass("now");

        topItem.filter(":not(:eq(" + topNow + "))").fadeOut();
        topItem.eq(topNow).fadeIn();

        topNow++;
            if (topNow == topItemLength) {
            topNow = 0;
        }
        timer = setTimeout(scrollTop, 5000);
    }
    scrollTop();


    topCol
        .mouseenter(function () {
            points.hide();
            clearTimeout(timer);
        })
        .mouseleave(function () {
            points.show();
            timer = setTimeout(scrollTop, 2500);
        })

    //鼠标高亮
    var item = obj.find("a");

    item
        .each(function () {
            jq(this).prepend("<em></em>")
        })
        .mouseenter(function () {
            var shadow = item.not(jq(this)).find("em");
            shadow.stop().animate({opacity: 0.4}, (0.4-shadow.css("opacity"))/0.4*500)
        })
        .mouseleave(function () {
            var shadow = item.not(jq(this)).find("em");
            item.find("em").stop().animate({opacity: 0}, (shadow.css("opacity"))/0.4*500)
        })
}

jq.fn.picShow = function () {
    var obj = jq(this);
    var item = obj.find("li");

    item.eq(0).addClass("current");

    item.mouseenter(function() {
        if (!jq(this).hasClass("current")) {
            obj.find(".current").removeClass("current");
            jq(this).addClass("current");
        }
    })
}

jq.fn.slideShow = function () {
    var obj = jq(this);

    var pics = obj.find("li");
    var pic_num = pics.length;
    var pic_cur = 0;

    var timer;

    obj.append("<div class=\"toggle\"></div>");
    var toggles = obj.find(".toggle");
    for (var i = 0; i< pic_num; i++) {
        toggles.append("<a></a>");
    }

    var toggle = toggles.find("a");
    toggle.each(function() {
        jq(this).click(function() {
            pic_cur = jq(this).index();
            rollPic();
            return false
        })
    })

    var showPic = function (id) {
        toggle.filter(".current").removeClass("current");
        toggle.eq(id).addClass("current");

        pics.filter(":visible").hide();
        pics.eq(id).show();

        return false
    }

    var rollPic = function () {
        clearTimeout(timer);

        if (pic_cur >= pic_num) {
            pic_cur = 0;
        }

        showPic(pic_cur);

        pic_cur++;

        timer = setTimeout(rollPic, 5000);
    }

    if (pic_num > 0) {
        rollPic();

        obj.mouseover(function() {
            clearTimeout(timer)
        })

        obj.mouseleave(function() {
            timer = setTimeout(rollPic, 5000)
        })
    }
}

jq.fn.initBbsNav = function () {
//    var bbsToggle = bbsNav.find(".bbsToggle");

//    bbsToggle.click(function() {
//        jq(this).parent(".bbsNav").addClass("bbsNav_show");
//        return
//    })
    jq(this).each(function() {
        var bbsNav = jq(this);
        var showFlag = 0;
        var bbsToggle = bbsNav.prev("a");

        var bbsNavHide = function() {
            if (showFlag == 0) {
                bbsNav.removeClass("bbsNav_show");
            }
        }

        bbsToggle
            .mouseover(function () {
                jq(this).next(".bbsNav").addClass("bbsNav_show");
                showFlag = 1;
            })
            .mouseleave(function () {
                showFlag = 0;
                setTimeout(bbsNavHide, 100);
            })

        bbsNav
            .mouseover(function () {
                showFlag = 1;
            })
            .mouseleave(function () {
                showFlag = 0;
                bbsNavHide();
            })
    })
}

jq.fn.searchBar = function () {
    var obj = jq(this);
    var str = obj.find("#indexTxtSearch");

    obj.click(function(e) {
        if (obj.hasClass("fold")) {
            obj.removeClass("fold");
            e.stopPropagation();
            return false
        }
    })

    str
        .keydown(function(e){
            if(e.keyCode == 13){
                iSearch.post();
            }
        })
}

// search
var iSearch = {
    init: function(){
        var iSearchObj = jq("#indexSearch"),
            iSpan     =  iSearchObj.find("span"),
            iTxt      =  jq("#indexTxtSearch"),
            spanHide  = function(){
                iSpan.hide();
                iTxt.focus();
            }

        iSpan.click(spanHide);
        iTxt.click(spanHide)
            .keydown(function(e){
                if(e.keyCode == 13){
                    iSearch.post();
                }
            })
        iTxt.val("");
    },
    post: function(){
        _gaq.push(['_trackEvent', '新版首页', '搜索按钮']);

        var itext =  jq("#indexTxtSearch"), txt = itext.val();
        if (txt.length === 0 ){
            alert("请您输入内容！");
            itext.focus();
            return;
        }
        var search_type = jq("#search_type").val();
        if(search_type=='news'){
            window.open("http://www.xiaomi.cn/index.php?m=search&c=index&a=init&typeid=1&siteid=1&q=" + txt);
        }else{
            //location.href = "http://bbs.xiaomi.cn/search.php?srchtxt=" + txt;
            window.open("http://bbs.xiaomi.cn/search.php?srchtxt=" + txt);
        }
    }
}

function addFavorite(url, title) {
	try {
		window.external.addFavorite(url, title);
	} catch (e){
		try {
			window.sidebar.addPanel(title, url, '');
        	} catch (e) {
			alert("请按 Ctrl+D 键添加到收藏夹");
		}
	}
}

function setHomepage(sURL) {
	if(navigator.userAgent.indexOf("MSIE")>0){
		document.body.style.behavior = 'url(#default#homepage)';
		document.body.setHomePage(sURL);
	} else {
		alert("非 IE 浏览器请手动将本站设为首页");
	}
}

jq(document).ready(function () {
    jq(".bbsNav").initBbsNav();
    jq(".deanfocus").focusShow();
//    jq(".picShow").picShow();
    jq("#picShow").slideShow();
    jq(".search").searchBar();
    jq("#xm_store").slideShow();
})