// JavaScript Document

// by noos

if(typeof jQuery != "undefined") {
	(function($) {
		$.fn.noosSlider = function(){
			var animation = {
				slide:function($a,$s){
					
					var s = $(this).data('s');
					var $t = $(this);
					var t1, t2;
					var temp = {};
					var l = {
						s:'',
						a:''
					};

					if($s.index() > $a.index()) {
						l.s = '100%';
						l.a = '-100%';
					} else {
						l.s = '-100%';
						l.a = '100%';
					}
					
					temp.t1 = $t.hasClass('animated');
					temp.t2 = $s.css('left');
					/*temp.t3 = $a.css('left');*/
					
					$s.css({
						'left':l.s
					});
					
					temp.t1 = $t.hasClass('animated');
					temp.t2 = $s.css('left');
					/*temp.t3 = $a.css('left');*/
					
					$t.addClass('animated');
					t1 = $s.css('transition-delay');
					t2 = $s.css('transition-duration');
					t1 = /\d+\.*\d*[s|ms]/.exec(t1);
					t1 = t1[0];
					t2 = /\d+\.*\d*[s|ms]/.exec(t2);
					t2 = t2[0];
					
					$a.css({
						'left':l.a
					});
					
					$s.css({
						'left':0
					});
					
					//console.log($t.hasClass('animated'), $s.css('left'), $a.css('left'));
					
					if(/ms/.test(t1)) {
						t1 = parseInt(t1) * 10;
					} else if(/s/.test(t1)){
						t1 = parseFloat(t1) * 1000;
					} else {
						t1 = 0;
					}
					if(/ms/.test(t2)) {
						t2 = parseInt(t2) * 10;
					} else if(/s/.test(t2)){
						t2 = parseFloat(t2) * 1000;
					} else {
						t2 = 0;
					}
					if(t2+t1){
						setTimeout(function(){
							$t.removeClass('animated');
							$a.removeClass('active');
							$s.addClass('active');
						}, t2+t1);
					} else {
						$t.removeClass('animated');
						$a.removeClass('active');
						$s.addClass('active');
					}
                                        
					return t2+t1;
                                        
				},
				fade:function($a,$s){
                            
					var s = $(this).data('s');
					var $t = $(this);
					var t1, t2;
					var temp = {}

					temp.t1 = $s.css('opacity');
					$s.css({
						'z-index':99,
						'opacity':0
					});
					
					$a.css({
						'z-index':1
					});
					
					temp.t1 = $a.css('opacity');
					temp.t1 = $s.css('opacity');
					
					$t.addClass('animated');
					
					$s.css({
						'opacity':1
					});
					
					t1 = $s.css('transition-delay');
					t2 = $s.css('transition-duration');
					t1 = /\d+\.*\d*[s|ms]/.exec(t1);
					t1 = t1[0];
					t2 = /\d+\.*\d*[s|ms]/.exec(t2);
					t2 = t2[0];
					if(/ms/.test(t1)) {
						t1 = parseInt(t1) * 10;
					} else if(/s/.test(t1)){
						t1 = parseFloat(t1) * 1000;
					} else {
						t1 = 0;
					}
					if(/ms/.test(t2)) {
						t2 = parseInt(t2) * 10;
					} else if(/s/.test(t2)){
						t2 = parseFloat(t2) * 1000;
					} else {
						t2 = 0;
					}
					
					if(t2+t1){
						setTimeout(function(){
							$t.removeClass('animated');
							$s.addClass('active');
							temp.t1 = $a.css('opacity');
							temp.t2 = $s.css('opacity');
							$a.css({
								'z-index':1,
								'opacity':0
							}).removeClass('active');
						}, t2+t1);
					} else {
						$t.removeClass('animated');
						$s.addClass('active');
						temp.t1 = $a.css('opacity');
						temp.t2 = $s.css('opacity');
						$a.css({
							'z-index':1,
							'opacity':0
						}).removeClass('active');
					}
                                        
					return t2+t1;
				}
			};
			var app = {
				init:function(settings){
					if(!$(this).hasClass('noos-slider')) {
                                            
						var t = this;
						var $t = $(t);
						var st = $t.data();
						var s = $.extend({}, $.fn.noosSlider.defaults, settings); s = $.extend({}, s, st);
						var $o = {
							s:$('.'+s.slides, t),
							sli:$('.'+s.slides+' > li', t),
							slia:$('.'+s.slides+' > li.active', t),
							p:$('.'+s.pagination, t),
							pli:$('.'+s.pagination+' > li', t),
							plia:$('.'+s.pagination+' > li.active', t)
						};
						var indexAcive = 0;
						var autoAnimation;
						var pagination = '';
						s.animation = $.extend({}, animation, s.animation);
						$t.data('s', s);
						$t.addClass(s.animateType+' noos-slider');
						
						if(s.autopagination) {
							pagination = '<ul class="'+s.pagination+'">';
							for(var i=0;i<$o.sli.size();i++) {
								pagination += '<li><span></span></li>';
							};
							pagination += '</ul>';
							$t.append(pagination);
							$o.p = $('.'+s.pagination, t);
							$o.pli = $('.'+s.pagination+' > li', t);
							
						}
						
						if(!$o.plia.size()) { $o.plia = $o.pli.eq(0).addClass('active'); }
						if(!$o.slia.size()) { $o.slia = $o.sli.eq(0).addClass('active'); }
	
						if(s.height == 'auto'){
							$o.s.css({
								height:$o.slia.outerHeight()
							});
						} else {
							$o.s.css({
								height:s.height
							});
						}
						app.checkInWindow.call(t);
						
						s.onInit.call(t);
						
						$t.on('mouseover', function(){
							var s = $(this).data('s');
							s.hover = true;
							$(this).data('s', s);
							app.stop.call(this);
						}).on('mouseleave', function(){
							var s = $(this).data('s');
							s.hover = false;
							$(this).data('s', s);
							app.start.call(this);
						}).on('click', '.'+s.pagination+' li', function(){
                                                    
							if(!$(this).hasClass('active'))
								app.animate.call($(this).closest('.noos-slider'), $(this).index());
						}).on('click', ' .nav.next', function(e){
							e.preventDefault();
							app.animate.call($(this).closest('.noos-slider').get(0), 'next');
						}).on('click', ' .nav.prev', function(e){
							e.preventDefault();
							app.animate.call($(this).closest('.noos-slider').get(0), 'prev');
						});
						$(window).on('scroll.noosSlider', function(){
							$('.noos-slider').noosSlider('checkInWindow');
						});
					}
				},
				animate:function(direction){
					if(direction!=null && typeof(direction)!='string' && typeof(direction)!='number') {
//console.log('не указано направление');
						return false;
					}
                                       // console.log(this);
                                        
                                        //console.log(direction);
                                        
					var t = this;
					var $t = $(t);
					var s = $t.data('s');
                                        
					if(s.timeout) {
						clearTimeout(s.timeout);
						s.timeout = false;
					}
					if(!$t.hasClass('animated')) {
						var $o = {
							s:$('.'+s.slides, t),
							sli:$('.'+s.slides+' > li', t),
							slia:$('.'+s.slides+' > li.active', t),
							slis:false,
							p:$('.'+s.pagination, t),
							pli:$('.'+s.pagination+' > li', t),
							plia:$('.'+s.pagination+' > li.active', t)
						};
						
						if(typeof(direction)=='number'){
							$o.slis = $o.sli.eq(direction);
						} else {
							if(direction == 'next') {
								$o.slis = $o.slia.next();
                                                                
								if(!$o.slis.size()) $o.slis = $o.sli.eq(0);
							}
							if(direction == 'prev') {
								$o.slis = $o.slia.prev();
								if(!$o.slis.size()) $o.slis = $o.sli.eq($o.sli.size()-1);
							}
						}
						if($o.slis.length && $o.slia.length && s.animation[s.animateType]) {
							if(s.height == 'auto'){
								/*$t.css({
									height:$o.slis.height()
								});*/
                                                
								$o.s.css({
									height:$o.slis.outerHeight()
								});
							}
//console.log($o.slis.index(), $o.slia.index())
							s.beforeAnimation.call(t);
							$o.plia.removeClass('active');
							$o.pli.eq($o.slis.index()).addClass('active');

    if( $o.slis.index() > $o.slia.index() ) {

                                vs = validate_slider(1);
                            if(vs==0&&$o.slis.index()==1) {
                                $('#catg').addClass('required');
                                $('#mark').addClass('required');
                                $('#publish_btn').css('opacity','0.4');
                                $('.slide_ctrl_prev').css('opacity','1');
                                disableprev = 0;
                                disablepublishandsave = 1;
                                $('#header1').toggleClass('active','');
                                $('#header2').toggleClass('active','');

                            } else if(vs==0&&$o.slis.index()==2) {
                                $('#classes_year_select').addClass('required');
                                $('#classes_subject_select').addClass('required');
                                $('#deadline_date').addClass('required');
                                $('#deadline_time').addClass('required');
//                                $('.slide_ctrl_prev').css('opacity','0.2');
                                $('#publish_btn').css('opacity','1');
                                $('.slide_ctrl_next').css('opacity','0.2');
                                disablenext = 1;
                                disablepublishandsave = 0;
                                $('#header2').toggleClass('active','');
                                $('#header3').toggleClass('active','');
                            } else if(vs==1) {
                                if( $o.slis.index() == 1 ) {
                                    sid = '.s1';
                                } else {
                                    sid = '.s2';
                                }
                                var actli = $( $(sid).parent() );
                                $('.slides').css('height', actli.outerHeight()+50);
                                return false;
                            }
    } else {
                            if($o.slis.index()==0) {
                                $('#catg').removeClass('required');
                                $('#mark').removeClass('required');
                                $('#publish_btn').css('opacity','0.4');
                                $('.slide_ctrl_prev').css('opacity','0.2');
                                disableprev = 1;
                                disablepublishandsave = 1;
                                $('#header1').toggleClass('active','');
                                $('#header2').toggleClass('active','');
                            } else if($o.slis.index()==1) {
                                $('#classes_year_select').removeClass('required');
                                $('#classes_subject_select').removeClass('required');
                                $('#deadline_date').removeClass('required');
                                $('#deadline_time').removeClass('required');

                                $('#publish_btn').css('opacity','0.4');
                                $('.slide_ctrl_next').css('opacity','1');
                                disablenext = 0;
                                disablepublishandsave = 1;
                                $('#header2').toggleClass('active','');
                                $('#header3').toggleClass('active','');
                            }
        vs = validate_slider(0);
    }
							time = s.animation[s.animateType].call(t, $o.slia, $o.slis);
							if(time){
                                                            
								setTimeout(function(){
									s.afterAnimation.call(t);
									app.start.call(t);
								}, time);
							} else {
								s.afterAnimation.call(t);
								app.start.call(t);
							}
						}
					}
				},
				start:function(){
					var t = this;
					var $t = $(t);
					var s = $t.data('s');
					
					if(s.autoAnimate && s.inFocus && !s.hover && !s.timeout){
						s.timeout = setTimeout(function(){
							app.animate.call(t, 'next');
						}, s.autoAnimate);
						$t.data('s',s);
					}
                                        
				},
				stop:function(){
					var t = this;
					var $t = $(t);
					var s = $t.data('s');
					clearTimeout(s.timeout);
					s.timeout = false;
					$t.data('s', s);
				},
				checkInWindow:function(){
                            
					var t = this;
					var $t = $(t);
					var s = $t.data('s');
					var h = {
						w:$(window).height(),
						t:$t.outerHeight()
					}
					var to = $t.offset().top;
					var st = $(window).scrollTop();
					if((to > st) && (to < st + (h.w - h.w/4))) {
						s.inFocus = true;
						app.start.call(t);
					} else {
						s.inFocus = false;
						app.stop.call(t);
					}
					$t.data('s',s);
                }
			};
			
			if((arguments && arguments.length == 1 && typeof(arguments[0]) == 'object') || !arguments.length) {
				var settings = $.extend({}, $.fn.noosSlider.defaults, arguments[0]);
				return this.each(function(){
					if(!$(this).hasClass('slider-init')) app.init.call(this, settings);
				});
			}
			if(arguments && typeof(arguments[0]) == 'string') {
				if(app[arguments[0]]){
					var a = arguments;
					var a2 = arguments;
					if(arguments.lengtn > 1) a2.shift();
					return this.each(function(){
						app[a[0]].apply(this, a2);
					});
				}
			}
			
		};
		$.fn.noosSlider.defaults = {
			autoAnimate:5000,
			slides:'slides',
			pagination:'pagination',
			autopagination:false,
			prevButton:'prev',
			nextButton:'next',
			animateType:'slide', // fade/slide
			width:'100%',
			height:'auto',
			afterAnimation:function(){
                           SlideCompleted();
                        },
			beforeAnimation:function(){},
			onInit:function(){},
			animation:{}
		}
	})(jQuery);
}