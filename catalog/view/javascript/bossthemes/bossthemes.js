/* SHARED VARS */
var touch = false;

function isSafari(){    
	return $.browser.webkit && !window.chrome;
}
// handles Animate
function dataAnimate(){
  $('[data-animate]').each(function(){
    
    var $toAnimateElement = $(this);
    
    var toAnimateDelay = $(this).attr('data-delay');
    
    var toAnimateDelayTime = 0;
    
    if( toAnimateDelay ) { toAnimateDelayTime = Number( toAnimateDelay ); } else { toAnimateDelayTime = 200; }
    
    if( !$toAnimateElement.hasClass('animated') ) {
      
      $toAnimateElement.addClass('not-animated');
      
      var elementAnimation = $toAnimateElement.attr('data-animate');
      
      $toAnimateElement.appear(function () {
        
        setTimeout(function() {
          $toAnimateElement.removeClass('not-animated').addClass( elementAnimation + ' animated');
        }, toAnimateDelayTime);
        
      },{accX: 0, accY: -80},'easeInCubic');
      
    }
    
  });
}

function boss_addToCart(product_id) {
    $.ajax({
        url: 'index.php?route=bossthemes/cart/add',
        type: 'post',
        data: 'product_id=' + product_id,
        dataType: 'json',
        success: function (json) {
            if (json['redirect']) {
                location = json['redirect'];
            }

            if (json['success']) {
                addProductNotice(json['title'], json['thumb'], json['success'], 'success');
                $('#cart-total').html(json['total']);
                $('#boss_cart').load('index.php?route=module/cart #boss_cart > *');
                $('#top_cart').load('index.php?route=module/carthead #top_cart > *');
            }
        }
    });
}

function boss_addToWishList(product_id) {
	$.ajax({
		url: 'index.php?route=bossthemes/wishlist/add',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {
			if (json['success']) {
				addProductNotice(json['title'], json['thumb'], json['success'], 'success');
				$('#wishlist-total').html(json['total']);
			}
		}
	});
}

function boss_addToCompare(product_id) {
	$.ajax({
		url: 'index.php?route=bossthemes/compare/add',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {
			if (json['success']) {
                addProductNotice(json['title'], json['thumb'], json['success'], 'success');
				$('#compare-total').html(json['total']);
			}
		}
	});
}

function addProductNotice(title, thumb, text, type) {
	if(thumb){
		var tpl = thumb + text;
	}else{
		var tpl = text;
	}
	$.jGrowl(tpl, {		
		life: 4000,
		header: title,
		speed: 'slow'
	});
}

function getWidthBrowser() {
  var myWidth = 0;

  if( typeof( window.innerWidth ) == 'number' ) { 
    //Non-IE 
    myWidth = window.innerWidth;
    //myHeight = window.innerHeight; 
  } 
  else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) { 
    //IE 6+ in 'standards compliant mode' 
    myWidth = document.documentElement.clientWidth; 
    //myHeight = document.documentElement.clientHeight; 
  } 
  else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) { 
    //IE 4 compatible 
    myWidth = document.body.clientWidth; 
    //myHeight = document.body.clientHeight; 
  }
  
  return myWidth;
}

/* mega boss menu */
$(window).load(function(){
	resizeWidth();
	/* Ajax Cart touch*/
	if($('body').hasClass('touch')){
		$('#boss_cart').click(function(e) {
			//e.preventDefault();
			if($('.heading a', this).hasClass('active')){	
				$('.content', this).fadeOut(100);
				$('.heading a', this).removeClass('active');
			}else{
				$('.content', this).slideDown();
				$('.heading a', this).addClass('active');
			}	
		});
	}
});
(function($,sr){
  // debouncing function from John Hann
  // http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
  var debounce = function (func, threshold, execAsap) {
      var timeout;

      return function debounced () {
          var obj = this, args = arguments;
          function delayed () {
              if (!execAsap)
                  func.apply(obj, args);
              timeout = null; 
          };

          if (timeout)
              clearTimeout(timeout);
          else if (execAsap)
              func.apply(obj, args);

          timeout = setTimeout(delayed, threshold || 100); 
      };
  }
// smartresize 
 jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };

})(jQuery,'smartresize');

var TO = false;
$(window).smartresize(function(){
if(TO !== false)
    clearTimeout(TO);
 TO = setTimeout(resizeWidth, 400); //400 is time in miliseconds
 //resizeWidth();
});

function resizeWidth()
{
	var menuWidth = 1182;
	var numColumn = 6;
	var currentWidth = $("#boss_menu").outerWidth()	+2;
	if (currentWidth < menuWidth) {
        new_width_column = currentWidth / numColumn;
        $('#boss_menu div.options_list').each(function(index, element) { 
            var options_list = $(this).next();  
            $(this).width(Math.ceil(parseFloat(options_list.css("width"))/menuWidth*numColumn * new_width_column));     
        });
        $('#boss_menu div.option').each(function(index, element) {
            var option = $(this).next();
            $(this).width(Math.floor(parseFloat(option.css("width"))/menuWidth*numColumn * new_width_column));
        });
        $('#boss_menu ul.column').each(function(index, element) {
            var column = $(this).next();
            $(this).width(Math.floor(parseFloat(column.css("width"))/menuWidth*numColumn * new_width_column));
        });
    }
	
	$('#boss_menu ul.ul_mega_menu  > li > div.options_list').each(function(index, element) {
		var offset_li = $(this).parent('li').offset();
        var offset_boss_menu = $('#boss_menu').offset();

        offset_i = Math.floor(offset_li.left) - Math.floor(offset_boss_menu.left) + $(this).outerWidth() - currentWidth;
        
        if (offset_i > 0) {
            $(this).css('margin-left', '-' + offset_i + 'px');
        }else{
            $(this).css('margin-left', '0px');
        }
	});
}

jQuery(document).ready(function($) {
	
	/* DETECT PLATFORM */
	$.support.touch = 'ontouchend' in document;
	  
	if ($.support.touch) {
		touch = true;
		$('body').addClass('touch');
	}else{
		$('body').addClass('notouch');
	}
	
	/* trasition safari*/
	if(isSafari()){
		$('body').addClass('safari');
	}  
	
	/* Handle Animate */
	if(touch == false){
		dataAnimate();
	}

// added for kindle 03.06.2016
	if((touch == true) && ($(window).width() > 1023)){
		dataAnimate();
	}
// added end

	/* bind search */
	$('#search input[name=\'search\']').bind('keydown', function(e) {
		if (e.keyCode == 13) {
			url = $('base').attr('href') + 'index.php?route=product/search';
			 
			var search = $('input[name=\'search\']').attr('value');
			
			if (search) {
				url += '&search=' + encodeURIComponent(search);
			}
			location = url;
		}
	});	
	
	/* Ajax Cart hover*/    
	$('body.notouch #boss_cart').hover(function() {
        $('.content', this).slideDown();		
		$('.heading a', this).addClass('active');
        $('#boss_cart').mouseleave(function() {
            $('.content', this).fadeOut(100);
			$('.heading a', this).removeClass('active');
        });
    },function(){
        $('#boss_cart').mouseleave(function() {
            $('.content', this).fadeOut(100);
			$('.heading a', this).removeClass('active');
        });
    });
	
	
	/* Remove Cart */
	$('#boss_cart .remove > a').live('click', function() {		
		$('#boss_cart').addClass('active');	
		$('#boss_cart').live('mouseleave', function() {
			$('#boss_cart').removeClass('active');
		});
	});

  /* Ajax Top Cart hover*/    
  $('body.notouch #top_cart').hover(function() {
        $('.content', this).slideDown();    
        $('.heading a', this).addClass('active');
        $(this).mouseleave(function() {
          $('.content', this).hide();
          $('.heading a', this).removeClass('active');
        });
    },function(){
        $(this).mouseleave(function() {
            $('.content', this).hide();
            $('.heading a', this).removeClass('active');
        });
    });
  
  
  /* Remove Top Cart */
  $('#top_cart .remove > a').live('click', function() {   
    $('#top_cart').addClass('active');  
    $('#top_cart').live('mouseleave', function() {
      $('#top_cart').removeClass('active');
    });
  });
		
	/* Tooltip */
	$('.cs-tooltip').tooltip();
	
	/* Select */
	$(".boss_select").selectbox();
	  	
   /* Mega Menu */    
    $("#boss_menu ul.ul_mega_menu > li > a").hover(
        function () {
            $('#boss_menu .sub_menu').removeClass("active");
            $(this).next().slideDown('fast').css('overflow','visible');
            $(this).parent().addClass("active");
            $(this).next().addClass("active");
        }, 
        function () {
            $(this).parent().mouseleave(function() {
				$(this).find('.options_list').slideUp(0);
                $(this).removeClass("active");
                $(this).find('.options_list').removeClass("active");
            });
        }
    );    
	
	$("#boss_menu ul.ul_mega_menu > li > div.options_list ul li.sub_category > a").hover(
        function () {
            $(this).next().slideDown('fast');
            $(this).parent().addClass("active");
            $(this).next().addClass("active");
        }, 
        function () {
            $(this).parent().mouseleave(function() {
				$(this).find('.sub_menu').slideUp(0);
                $(this).removeClass("active");
                $(this).find('.sub_menu').removeClass("active");
            });
        }
    );
	
    $("#menu_default ul.navbar-nav > li > a").hover(
        function () {
            $(this).next().slideDown('fast');
            $(this).parent().addClass("active");
            $(this).next().addClass("active");
        }, 
        function () {
            $(this).parent().mouseleave(function() {
                $(this).find('.sub_menu_default').slideUp(0);
                $(this).removeClass("active");
                $(this).find('.sub_menu_default').removeClass("active");
            });
        }
    );
	

});
