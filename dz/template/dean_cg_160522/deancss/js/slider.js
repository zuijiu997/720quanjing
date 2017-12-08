/**
 * 使用方式：
 * 	jq(function(){
 *		jq('#sliderDemo').mokoSlider(); 
 *	});
 *
 *
 */

(function(jq){

	jq.fn.mokoSlider = function(options){
		//定义常量
		var settings = jq.extend({
            speed: 800,		//速度
			width: 1180,		//移动步长
			interval:5000,	//切换时间
			controller:true	//是否显示控制器
        },options);
		
		//控制器
		var Ctrl2 = function(jqthis,callback){
			var count = jqthis.find('li').size();
			if(count <= 1)
				return ;
			var html = '<div class="point-ctrl">\
						<a class="left-point" href="javascript:void(0)" hidefocus="true"></a>\
						<a class="right-point" href="javascript:void(0)" hidefocus="true"></a>\
						</div>';
			var jqpointCtrl = jq(html);
			jqpointCtrl.find('.left-point').click(function(){
				callback.call(this,'left');
			});
			jqpointCtrl.find('.right-point').click(function(){
				callback.call(this,'right');
			});
			jqpointCtrl.appendTo(jqthis);
			
		};
		//控制器
		var Ctrl= function(jqthis,callback){
			var count = jqthis.find('ul li').size();
			var jqcontroller = jq('<p>',{'class':'controller'});
			if(count <= 1)
				return ;
			//创建对应个数的span标签
			for(var a=0;a < count; a++){
				jq('<a/>',{ 'hidefocus':'true','href':'javascript:void(0);','text':'●'}).click(callback).appendTo(jqcontroller);
			}
			//设置默认第一个选中
			jqcontroller.children(':first').addClass('moko-slider-on');
			//添加到slider中
			jqcontroller.appendTo(jqthis);
			//对外调用的更新选中
			this.update = function(index){
				jqcontroller.find(':eq('+index+')').addClass('moko-slider-on').siblings().removeClass('moko-slider-on');
			}
			return this;
		};
		
		this.each(function() {
			var jqthis = jq(this),jqul = jqthis.find('ul');
			var jqlist = jqul.find('li'), count = jqlist.size(),index=0,timer,hoverTimer;

			jqthis.width(settings.width);
			//设置ul的宽度，使li排成一行
			jqul.width(settings.width * count);
			
			jqul.hover(function(){
				//当鼠标移上超过 1000毫秒时清除滚动计时器
				hoverTimer = setTimeout(function(){
					//清除定时器
					clearInterval(timer);
					timer = null;
				},1000);
			},function(){
				//清除鼠标以上的计时
				clearTimeout(hoverTimer);
				//如果滚动计时器被清楚则重新启动
				if(!timer){
					next();				
					interval();
				}
			});

			var ctrl2 = new Ctrl2(jqthis,function(direction){
				//停止动画效果
				jqul.stop();
				if('left' == direction){
					pre();
				}
				else{
					next();
				}
				//清除定时器
				clearInterval(timer);
				//从当前的index继续定时切换
				interval();
			});

			var ctrl = new Ctrl(jqthis,function(){
				//获得被点击的span 索引
				index = jq(this).index();
				//停止动画效果
				jqul.stop();
				//切换到指定的索引
				rolling(index);
				//清除定时器
				clearInterval(timer);
				//从当前的index继续定时切换
				interval();
			});
			
			var interval = function(){
				if(count <= 1)
					return ;
				timer = setInterval(function(){
					next();
				},settings.interval);
			};
			//
			interval();
			//滚动第 i 个
			var rolling = function(i){
				if(ctrl.update)
					ctrl.update(i);
				jqul.animate({'margin-left': -i * settings.width}, settings.speed);
			},
			//下一个
			next = function(){
				index++;
				if(index >= count)
					index=0;
				rolling(index);
			},
			//上一个
			pre = function(){
				index--;
				if(index < 0)
					index = count-1;
				rolling(index); //执行继续滚动
			}
		});
		
	};
})(jQuery1);
//图片切换
jQuery1(function(){
	jQuery1('.moko-slider').mokoSlider();
});