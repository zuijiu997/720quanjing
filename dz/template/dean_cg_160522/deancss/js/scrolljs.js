(function ($) {
    $.extend({
        'eye': function (con) {
            var $container = $('.eye_box'), 
			$imgs = $container.find('li.hero'), 
			$leftBtn = $container.find('a.eye_next'), 
			$rightBtn = $container.find('a.eye_prev'), 
			config = {
                interval: con && con.interval || 3500,
                animateTime: con && con.animateTime || 500,
                direction: con && (con.direction === 'right'),
                _imgLen: $imgs.length
            }, 
			i = 0, 
			getNextIndex = function (y) { return i + y >= config._imgLen ? i + y - config._imgLen : i + y; }, 
			getPrevIndex = function (y) { return i - y < 0 ? config._imgLen + i - y : i - y; }, 
			silde = function (d) {
                $imgs.eq((d ? getPrevIndex(2) : getNextIndex(2))).css('left', (d ? '-2000px' : '2000px'))
                $imgs.animate({
                    'left': (d ? '+' : '-') + '=1000px'
                }, config.animateTime);
                i = d ? getPrevIndex(1) : getNextIndex(1);
				$('.eye_pag li').eq(i).addClass('current').siblings().removeClass('current');
				//.$('.eye_tit a').eq(i).css('display','block').siblings().hide();
                                $('.eye_tit a').eq(i).show().siblings().hide();
            }, 
			s = setInterval(function () { silde(config.direction); }, config.interval);
            $imgs.eq(i).css('left', 0).end().eq(i + 1).css('left', '1000px').end().eq(i - 1).css('left', '-1000px');
            $container.find('.hero_wrap').add($leftBtn).add($rightBtn).hover(function () { clearInterval(s); }, function () { s = setInterval(function () { silde(config.direction); }, config.interval); });
            $leftBtn.click(function () {
                if ($(':animated').length === 0) {
                    silde(false);
                }
            });
            $rightBtn.click(function () {
                if ($(':animated').length === 0) {
                    silde(true);
                }
            });
		
			
        }
    });
}(jQuery));
