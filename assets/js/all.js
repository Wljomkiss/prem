jQuery(function($) { "use strict";
	
	/*============================*/
	/* 01 - VARIABLES */
	/*============================*/					
	
	var swipers = [], winW, winH, winScr, _isresponsive, xsPoint = 480, smPoint = 768, mdPoint = 992, lgPoint = 1200, addPoint = 1600, _ismobile = navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i);

	function pageCalculations(){
		winW = $(window).width();
		winH = $(window).height(); 
	}
	pageCalculations();
	
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");
    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))
    {
       $('body').addClass('ie-bg'); 
    }
					
   if(_ismobile) {$('body').addClass('mobile');}
					
	function updateSlidesPerView(swiperContainer){
		if(winW>=addPoint) return parseInt(swiperContainer.attr('data-add-slides'),10);
		else if(winW>=lgPoint) return parseInt(swiperContainer.attr('data-lg-slides'),10);
		else if(winW>=mdPoint) return parseInt(swiperContainer.attr('data-md-slides'),10);
		else if(winW>=smPoint) return parseInt(swiperContainer.attr('data-sm-slides'),10);
		else return parseInt(swiperContainer.attr('data-xs-slides'),10);
	}             

	function resizeCall(){
		pageCalculations();
      
		$('.swiper-container.initialized[data-slides-per-view="responsive"]').each(function(){
			var thisSwiper = swipers['swiper-'+$(this).attr('id')], $t = $(this), slidesPerViewVar = updateSlidesPerView($t), centerVar = thisSwiper.params.centeredSlides;
			thisSwiper.params.slidesPerView = slidesPerViewVar;
			thisSwiper.update();
			if(!centerVar){
				var paginationSpan = $t.find('.pagination span');
				var paginationSlice = paginationSpan.hide().slice(0,(paginationSpan.length+1-slidesPerViewVar));
				if(paginationSlice.length<=1 || slidesPerViewVar>=$t.find('.swiper-slide').length) $t.addClass('pagination-hidden');
				else $t.removeClass('pagination-hidden');
				paginationSlice.show();
			}
		});
	}
	if(!_ismobile){
		$(window).resize(function(){
			resizeCall();
		});
	}else{
		window.addEventListener("orientationchange", function() {
			resizeCall();
		}, false);
	}
                                                  
	/*============================*/
	/* 02 - SWIPER SLIDER */
	/*============================*/
                          
	function initSwiper(){
		var initIterator = 0;
		$('.swiper-container').each(function(){								  
			var $t = $(this);								  
			var index = 'swiper-unique-id-'+initIterator;

			$t.addClass('swiper-'+index + ' initialized').attr('id', index);
			$t.find('.pagination').addClass('pagination-'+index);

			var autoPlayVar = parseInt($t.attr('data-autoplay'),10);
            var slideEffect = $t.attr('data-effect');
			var slidesPerViewVar = $t.attr('data-slides-per-view');
	
			if(slidesPerViewVar == 'responsive'){
				slidesPerViewVar = updateSlidesPerView($t);
			}

            var directMode = $t.attr('data-mode');
			var loopVar = parseInt($t.attr('data-loop'),10);
			var speedVar = parseInt($t.attr('data-speed'),10);
            var centerVar = parseInt($t.attr('data-center'),10);
			var freeMode = parseInt($t.attr('data-freemode'),10);
			swipers['swiper-'+index] = new Swiper('.swiper-'+index,{
				speed: speedVar,
				pagination: '.pagination-'+index,
				paginationHide:false,
				loop: loopVar,
				paginationClickable: true,
				autoplay: autoPlayVar,
				slidesPerView: slidesPerViewVar,
				keyboardControl: true, 
				simulateTouch: true,
				centeredSlides: centerVar,
				effect: slideEffect,
                coverflow: {
                    rotate: 50,
                    stretch: 0,
                    depth: 100,
                    modifier: 1,
                    slideShadows : false
                },
				direction: directMode,
				freeMode: freeMode,
                updateTranslate: true,
                observer:true,
                preventClicks: true,
                longSwipesRatio: 0.1,
                onInit: function(swiper){},
                onSlideChangeStart: function(swiper){
		           var activeIndex = (loopVar===1)?swiper.activeLoopIndex:swiper.activeIndex;
					   if($t.closest('.slider-swiching').length){
							swipers['swiper-'+$t.closest('.slider-swiching').find('.swich-parent').attr('id')].slideTo(swiper.activeIndex);
						    $t.closest('.slider-swiching').find('.slide-swich').removeClass('active');
						    $t.closest('.slider-swiching').find('.slide-swich').eq(activeIndex).addClass('active');
					    }   
				}
                
			});
			
			swipers['swiper-'+index].update();
			initIterator++;
		});
	}
     
                    
    $(document).on('click','.slide-swich', function(){
		var swichIndex = $(this).closest('.slider-swiching').find('.slide-swich').index(this);
		 $(this).closest('.slider-swiching').find('.slide-swich').removeClass('active');	
		  $(this).addClass('active');	
			swipers['swiper-'+$(this).closest('.slider-swiching').find('.container-swich').attr('id')].slideTo(swichIndex);		
		  return false;
	});                
           
    $(document).on('click', '.swiper-arrow-left', function(){
		swipers['swiper-'+$(this).closest('.arrow-closest').find('.swiper-container').attr('id')].slidePrev();
	});
                    
	$(document).on('click', '.swiper-arrow-right', function(){
		swipers['swiper-'+$(this).closest('.arrow-closest').find('.swiper-container').attr('id')].slideNext();  
	});
	
	/*============================*/
	/* 03 - WINDOW LOAD */
	/*============================*/
	
	$(window).load(function(){
	    $('.preloader').addClass('act').delay(1000).fadeOut(300);
        $('.product-item').each(function(){
          var productNumb = $('.product-item').length;    
            $('.product-count span').text(productNumb);
        });
        initSwiper();
        headerScroll();
		izotopInit();
        $('.skill-circle').circliful();
        if ($('.map-wrapper').length){	
            setTimeout(function(){initialize();}, 1000);
        }
	});
	
	/*============================*/
	/* 04 - MENU */
	/*============================*/
	
	
	$('.nav-menu-icon a').on('click', function() { 
	  if ($('.navigation nav').hasClass('slide-menu')){
		   $('.navigation nav').removeClass('slide-menu'); 
		   $('.wrap').removeClass('hold');
		   $('.center-menu').removeClass('act');
		   $('.left-slide').removeClass('slide-menu'); 
           $('.navigation').removeClass('open-center-menu');
		   $(this).removeClass('active');
		   $('body').removeClass('overflow');
	  }else {
		   $('.navigation nav').addClass('slide-menu');
		   $('.center-menu').addClass('act');
           $('.navigation').addClass('open-center-menu');
		   $('.left-slide').addClass('slide-menu');
		   $('.wrap').addClass('hold');
		   $(this).addClass('active');
		   $('body').addClass('overflow');
	  }
		return false;
	 });

	
	$('nav > ul > li > a').on('click', function(){
	  if ($(this).parent().find('.dropmenu').hasClass('act')){
	      $(this).parent().find('.dropmenu').removeClass('act');
	  }else{
		  $('.dropmenu').removeClass('act');
	      $(this).parent().find('> .dropmenu').addClass('act');
	  }
	
	});
	
	$('.dropmenu > li > a').on('click', function(){
	  if ($(this).parent().find('.dropmenu').hasClass('act')){
	      $(this).parent().find('.dropmenu').removeClass('act');
	  }else{
		  $('.dropmenu .dropmenu').removeClass('act');
	      $(this).parent().find('> .dropmenu').addClass('act');
	  }
	
	});
                               
	$('.more-link').on('click', function(){
       $('.nav').toggleClass('open');   
         if ($(window).width() < 992) {
             $('body').toggleClass('overflow');
             $('.header-style-7').toggleClass('style-mobile');
			 $('header').removeClass('open-submenu');
         }
    });

	$('.close-menu').on('click', function(){
		$('.layer-black').removeClass('act');
	    $('.left-menu').removeClass('act');
		$('.holder').removeClass('act');
        $('.navigation').removeClass('open-center-menu');
        $('body').removeClass('overflow');
        $('.navigation nav').removeClass('slide-menu'); 
        $('.nav-menu-icon.rel a').removeClass('active');
		return false;
	});
     
    $('.sub-nav-menu-icon, .close-sub-menu').on('click', function(){
        $('header').toggleClass('open-submenu');
        $('body').toggleClass('overflow');
		$('.nav').removeClass('open');
		if ($('.header-style-7').hasClass('style-mobile')){
			$('.header-style-7').removeClass('style-mobile');
		}
		
    }); 
                    
    $('.submenu-layer').on('click', function(){
        $('header').removeClass('open-submenu');
        $('body').removeClass('overflow'); 
    });                
	
	/*============================*/
	/* 05 - WINDOW SCROLL */
	/*============================*/
                    
    $(window).scroll(function() {
	   headerScroll();
	   skillLine();
	}); 

    function skillLine() {
        if ($('.time-line').length) {
		    $('.time-line').not('.animated').each(function(index){
		        if($(window).scrollTop() >= $(this).offset().top - $(window).height()*0.5){
                    $(this).addClass('animated').find('.timer').countTo();
                         
                         

                    }
                });
                $('.skill-line div').each(function(){
                    var objel = $(this);
                    var pb_width = objel.attr('data-width-pb');
                    objel.css({'width':pb_width});
                });
        }    
    }
                    
    function headerScroll() {
       if ($(window).scrollTop() >= $('.header').height()) {
		   $('header').addClass('scrol');
		}else{
		   $('header').removeClass('scrol');
		} 
    }
                    
    $('.up-button').on('click', function(){
		$('body, html').animate({'scrollTop':'0'});
		   return false;
	});	
	
	/*============================*/
	/* 06 - CLICK */
	/*============================*/
	
    $('.serch-button').on('click', function(){
	   $('.search-popup').addClass('open');
		return false;
	});
	
	$('.search-form-wr .close').on('click', function(){
	   $('.search-popup').removeClass('open');
		return false;
	});
	
	$('.input').focusin(function(){
	    $('.input-field').addClass('active');
	});
	$('.input').focusout(function(){
	    $('.input-field').removeClass('active');
	});

    $('.close-block').on('click', function(){
	   $(this).parent().fadeOut(280);
		return false;
	});
                    
    if ($(window).width()<992) {
       $('.select-txt').on('click', function(){ 
          $(this).parent().find('.filter-list').slideToggle(300);
           return false;
       }); 
        
       $('.filter-list li').on('click', function(){
          $('.select-txt p').text($(this).text());
            $('.filter-list').slideUp(300);
       });   
    }                
                    
    /*============================*/
	/* 07 - ISOTOPE */
	/*============================*/                
                    
    function izotopInit() {
	  if ($('.izotope-container').length) {
	    var $container = $('.izotope-container');
	  	  $container.isotope({
			itemSelector: '.item',
			layoutMode: 'masonry',
			masonry: {
			  columnWidth: '.grid-sizer'
			}
		  });
			$('.filter-list').on('click', 'li', function() {
			  $('.izotope-container').each(function(){
				 $(this).find('.item').removeClass('animated');
			  });
				 $('.filter-list li').removeClass('active');
				 $(this).addClass('active');
				   var filterValue = $(this).attr('data-filter');
					$container.isotope({filter: filterValue});
			});  
	  }
	}                
    izotopInit();
                    
     
                
                    
    /*============================*/
	/* 08 - PRODUCT */
	/*============================*/
                    
    $(document).on('click', '.custom-input-number .cin-increment', function(e) {
         var $input = $(this).siblings('.cin-input'),
            val = parseInt($input.val()),
            max = parseInt($input.attr('max')),
            step = parseInt($input.attr('step'));
         var temp = val + step;
        $input.val(temp <= max ? temp : max);
    });
    $(document).on('click', '.custom-input-number .cin-decrement', function(e) {
        var $input = $(this).siblings('.cin-input'),
            val = parseInt($input.val()),
            min = parseInt($input.attr('min')),
            step = parseInt($input.attr('step'));
        var temp = val - step;
        $input.val(temp >= min ? temp : min);
    });
                    
                    
     $('.tabs-link li').on('click', function(index){
        var indexTab = $('.tabs-link li').index(this);
          $('.tabs-link li').removeClass('active');     
            $(this).addClass('active');
             $('.tab-item').fadeOut(0).removeClass('animate');
             $('.tab-item').eq(indexTab).fadeIn(300).addClass('animate');
             if ($('.tab-item').eq(indexTab).find('.swiper-container').length) {
                initSwiper();
             }
             return false;
     });
                    
    /*============================*/
	/* 09 - GOOGLE MAP */
	/*============================*/
                    
    var marker = [], infowindow = [], map, image = $('.map-wrapper').attr('data-marker');

     function addMarker(location,name,contentstr){
        marker[name] = new google.maps.Marker({
            position: location,
            map: map,
			icon: image
        });
        marker[name].setMap(map);

		infowindow[name] = new google.maps.InfoWindow({
			content:contentstr
		});
		
		google.maps.event.addListener(marker[name], 'click', function() {
			infowindow[name].open(map,marker[name]);
		});
     }
	
	 function initialize() {

		var lat = $('#map-canvas').attr("data-lat");
		var lng = $('#map-canvas').attr("data-lng");
		var mapStyle = $('#map-canvas').attr("data-style");

		var myLatlng = new google.maps.LatLng(lat,lng);

		var setZoom = parseInt($('#map-canvas').attr("data-zoom"),10);

		var styles = "";

		if (mapStyle=="1"){
			styles = [{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]}];
		}else{
            if (mapStyle=="2"){
              styles = [{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"lightness":20},{"color":"#000000"}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"administrative.country","elementType":"labels.text.fill","stylers":[{"visibility":"on"},{"color":"#ffffff"}]},{"featureType":"administrative.province","elementType":"geometry.fill","stylers":[{"visibility":"simplified"}]},{"featureType":"administrative.province","elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"administrative.province","elementType":"labels.text.stroke","stylers":[{"weight":"0.01"},{"invert_lightness":true},{"color":"#f26c4f"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"visibility":"simplified"},{"weight":"0.05"},{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#f26c4f"},{"weight":"0.10"},{"invert_lightness":true},{"lightness":29}]},{"featureType":"road.highway","elementType":"labels.text.fill","stylers":[{"color":"#f26c4f"}]},{"featureType":"road.highway.controlled_access","elementType":"geometry","stylers":[{"weight":"0.30"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]}];   
            }else{
            if (mapStyle=="3"){
               styles = [{"featureType":"administrative","elementType":"all","stylers":[{"visibility":"on"},{"lightness":33}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2e5d4"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#c5dac6"}]},{"featureType":"poi.park","elementType": "labels","stylers":[{"visibility":"on"},{"lightness":20}]},{"featureType":"road","elementType":"all","stylers": [{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#c5c6c6"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#e4d7c6"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#fbfaf7"}]},{"featureType":"water","elementType":"all","stylers":[{"visibility":"on"},{"color":"#acbcc9"}]}]; 
            }
            } 
        }
		var styledMap = new google.maps.StyledMapType(styles,{name: "Styled Map"});
        
        var draggMap;
        if (!_ismobile) {
           draggMap = true;  
        }else{
           draggMap = false;  
        }
         
		var mapOptions = {
			zoom: setZoom,
			disableDefaultUI: false,
			scrollwheel: false,
			zoomControl: true,
			streetViewControl: true,
			center: myLatlng,
            draggable: draggMap
		};
		map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
		
		map.mapTypes.set('map_style', styledMap);
  		map.setMapTypeId('map_style');
		

		$('.addresses-block a').each(function(){
			var mark_lat = $(this).attr('data-lat');
			var mark_lng = $(this).attr('data-lng');
			var this_index = $('.addresses-block a').index(this);
			var mark_name = 'template_marker_'+this_index;
			var mark_locat = new google.maps.LatLng(mark_lat, mark_lng);
			var mark_str = $(this).attr('data-string');
			addMarker(mark_locat,mark_name,mark_str);	
		});
	 } 
                    
    /*============================*/
	/* 10 - VIDEO YOUTUBE - VIMEO  */
	/*============================*/				
					
	$(document).on('click', '.play-button', function(){
	   var videoLink = $(this).attr('data-video'),
		   thisAppend = $(this).closest('.video-open').find('.video-iframe');
		   $(this).closest('.video-open').find('.video-item').addClass('act');
           $('.video-open').addClass('over');
		   $('<iframe>').attr('src', videoLink).appendTo(thisAppend);
		return false;
	});
			  
	$(document).on('click', '.close-video', function(){
		var videoClose = $(this).parent().find('.video-iframe');
	     $(this).closest('.video-open').find('.video-item').removeClass('act');
         $('.video-open').removeClass('over');
		  videoClose.find('iframe').remove();
		  return false;
	});
                    
    $(document).on('click', '.play-trigger', function(){
        $(this).closest('.video-open').find('.play-button').click();
       return false; 
    });                
                   
                    
    /*============================*/
	/* 11 - ACCORDEON  */
	/*============================*/
                   			
	$('.accordeon-triger').on('click', function(){
		var $this = $(this),
			item = $this.closest('.accordeon-item'),
			list = $this.closest('.accordeon-list'),
			items = list.find('.accordeon-item'),
			content = item.find('.accordeon-inner'),
			otherContent = list.find('.accordeon-inner'),
			times = 300;
		if (!item.hasClass('active')){
		   items.removeClass('active');
		   item.addClass('active');
		   otherContent.stop(true, true).slideUp(times);
		   content.stop(true, true).slideDown(times);
		}else{
		   item.removeClass('active');	
		   content.stop(true, true).slideUp(times);	
		}
        return false;
	});
                    
    $('.slider-tabs li').on('click', function(){
        var indexSlTab = $('.slider-tabs li').index(this); 
        $('.slider-tabs li').removeClass('active');
         $(this).addClass('active');
         $('.slider-container-item').removeClass('active');    
         $('.slider-container-item').eq(indexSlTab).addClass('active');
    });
                    
    $('.grid-type-project').on('click', function(){
        $('.izotope-container').addClass('grid-types');
        setTimeout(function(){
            izotopInit(); 
        },500);
      return false;
    });                
                    
    $('.list-type-project').on('click', function(){
        $('.izotope-container').removeClass('grid-types');
         setTimeout(function(){
            izotopInit(); 
         },500);
       return false;
    });                 
                    
    /*============================*/
	/* 12 - TIMER */
	/*============================*/
                    
//    if ($('.countdown').length){
//          $('.countdown').each(function(index){
//             $(this).attr('id', 'count-' + index).final_countdown({
//                    selectors: {
//                        value_seconds: '.clock-seconds .val',
//                        canvas_seconds: 'second'+index,
//                        value_minutes: '.clock-minutes .val',
//                        canvas_minutes: 'min'+index,
//                        value_hours: '.clock-hours .val',
//                        canvas_hours: 'hour'+index,
//                        value_days: '.clock-days .val',
//                        canvas_days: 'day'+index,
//                    },
//                    seconds: {
//                        borderWidth: '3'
//                    },
//                    minutes: {
//                        borderWidth: '3'
//                    },
//                    hours: {
//                        borderWidth: '3'
//                    },
//                    days: {
//                        borderWidth: '3'
//                    }
//                });
//          });  
//    }
                    
    
     function initCounter(){
          if(!$('.countdown').length) return false;
          $('.countdown').not('.initialized').each(function(){
                   $(this).addClass('initialized').ClassyCountdown({
                       end: (new Date($(this).data('end'))).getTime(),
                       labels: true,
                       style: {
                           element: "",
                           days: {
                                gauge: {
                                    thickness: $(this).data('line'),
                                    fgColor: $(this).data('fgcolor'),
                                    bgColor: $(this).data('bgcolor')
                                }
                            },
                            hours: {
                                gauge: {
                                    thickness: $(this).data('line'),
                                    fgColor: $(this).data('fgcolor'),
                                    bgColor: $(this).data('bgcolor')
                                }
                            },
                            minutes: {
                                gauge: {
                                    thickness: $(this).data('line'),
                                    fgColor: $(this).data('fgcolor'),
                                    bgColor: $(this).data('bgcolor')
                                }
                            },
                            seconds: {
                                gauge: {
                                    thickness: $(this).data('line'),
                                    fgColor: $(this).data('fgcolor'),
                                    bgColor: $(this).data('bgcolor')
                                }
                            }
                       }

            }); 
        });
     } 
     initCounter();                

	$('.prev.page-numbers').parent().css({'float':'left'});				
	$('.next.page-numbers').parent().css({'float':'right'});				
					
					
	
});