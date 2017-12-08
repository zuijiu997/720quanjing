$(function () {

    $(".phone tr:odd,.service tr:odd,.activity tr:odd").addClass("odd");

    $(".phone tr:even,.service tr:even,.activity tr:even").addClass("even");

    $(".phone tr:eq(0),.service tr:eq(0),.activity tr:eq(0)").css({ "color": "#000000", "height": "40px" });



    var x = 10;

    var y = 20;

    $("a.flag").mouseover(function (e) {

        this.myTitle = this.title;

        this.title = "";

        var tooltip = "<div id='flag'>" + this.myTitle + "</div>"; //创建 div 元素

        $("body").append(tooltip); //把它追加到文档中						 

        $("#flag")

			.css({

			    "top": (e.pageY + y) + "px",

			    "left": (e.pageX + x) + "px"

			}).show("fast");   //设置x坐标和y坐标，并且显示

    }).mouseout(function () {

        this.title = this.myTitle;

        $("#flag").remove();  //移除 

    }).mousemove(function (e) {

        $("#flag")

			.css({

			    "top": (e.pageY + y) + "px",

			    "left": (e.pageX + x) + "px"

			});

    });

})