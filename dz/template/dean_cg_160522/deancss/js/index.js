// JavaScript Document


jq(function(){ 

	jq('.deannav li').hover(function(){ 
		jq(this).find('span').stop(true).animate({'top':0},200);
		if(!jq(this).hasClass('deannavThis')){
			jq(this).addClass('deannavThisJs');
		};
	},function(){ 
		jq(this).find('span').animate({'top':80},200).parents('li').removeClass('deannavThisJs');
	});
	
	jq('.weixin').hover(function(){ 
		jq(this).find('span').show();
	},function(){ 
		jq(this).find('span').hide();
	});
	
	
	jq('.tuijian li,.xl-list-img').hover(function(){ 
		jq(this).css({'opacity':0.8});
	},function(){ 
		jq(this).css({'opacity':1});
	});

	
	(function(jq){
		var slide = {
			init:function(settings){
				this.index = 0;	
				this.bindEvent(settings);	
				this.zidong(settings);
			},
			bindEvent:function(settings){
				var that = this;
				jq(".jdt-list").find("span").mouseover(function(){
					that.index = jq(this).index();
					that.eff(settings);
				});
				
				jq(".jdt-r").click(function(){
					that.index +=1;
					if(that.index == 3){
						that.index = 0;
					}
					that.eff(settings);
				});
				jq(".jdt-l").click(function(){
					that.index -=1;
					if(that.index < 0){
						that.index = 2;
					}
					that.eff(settings);
				});
			},
			
			steInfo:function(){
				jq('.jdt-text li').eq(this.index).show().siblings().hide();
				jq(".jdt-list").find("span").eq(this.index).addClass("jdtThis").siblings().removeClass("jdtThis");
			},
			
			eff:function(settings){
				this.steInfo();
				jq('.jdt-img li').eq(this.index).fadeIn(500,function(){jq(this).css({'z-index':2});}).siblings().fadeOut(500,function(){jq(this).css({'z-index':1});});
			},
			
			zidong:function(settings){
				var timed = setInterval(function(){
					jq(".jdt-r").click();
				},4000);
				jq(".jdt-list-box,.jdt-l,.jdt-r").hover(function(){
					clearInterval(timed);	
				},function(){
					timed = setInterval(function(){
						jq(".jdt-r").click();
					},4000);
				})
			}
		}
		
		jq.fn.slide = function(optian){
			var settings = {};
			jq.extend(true, settings, optian || {});
			slide.init(settings);
		}
    }(jQuery));
	
	jq("document").slide();

	
/*图片滚动*/
	
	jq(function(){ 
		//var runW   = 0 ;
		var jqulBox = jq('.huiyuan-list');
		var btnL   = jq('.huiyuan-l');
		var btnR   = jq('.huiyuan-r');
		var liW    = jqulBox.find('li:first').width();
		jqulBox.css('width',jqulBox.find('li').length*liW);
		if(jqulBox.find('li').length>3){
			jq('.huiyuan-r').addClass('huiyuan-r2');
		}
		btnL.click(function(){ 
			var ulL = jqulBox.position().left;
			if(ulL<0){
				var runW   = liW ;
				runNow(runW,ulL);
			}
		});
		btnR.click(function(){ 
			var ulL = jqulBox.position().left;
			if(ulL>-jqulBox.width()+liW*3){
				var runW   = -liW ;
				runNow(runW,ulL);
			};
		});
		function runNow(runW,ulL){
			if(ulL%liW==0){
				jqulBox.animate({'left':ulL+runW},500,function(){
					if(jqulBox.position().left==0){
						btnL.removeClass('huiyuan-l2');
					}else{btnL.addClass('huiyuan-l2');};
					if(jqulBox.position().left==-jqulBox.width()+liW*3){
						btnR.removeClass('huiyuan-r2');
					}else{btnR.addClass('huiyuan-r2');};
				});
			}
		};
	
	});










});




