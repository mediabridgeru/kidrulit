$(document).ready(function() {
	/* Search */
	$('.button-search').on('click', function() {
		url = $('base').attr('href') + 'index.php?route=product/search';
				 
		var search = $('header input[name=\'search\']').attr('value');
		
		if (search) {
			url += '&search=' + encodeURIComponent(search);
		}
		
		location = url;
	});

    $('#button-search').on('click', function() {
        url = $('base').attr('href') + 'index.php?route=product/search';

        var search = $('#content input[name=\'search\']').attr('value');

        if (search) {
            url += '&search=' + encodeURIComponent(search);
        }

        location = url;
    });
	
	$('input[name=\'search\']').on('keydown', function(e) {
		if (e.keyCode == 13) {
			url = $('base').attr('href') + 'index.php?route=product/search';
			 
			var search = $(this).attr('value');
			
			if (search) {
				url += '&search=' + encodeURIComponent(search);
			}
			
			location = url;
		}
	});
	
	/* Ajax Cart */
	$('#cart > .heading a').on('click', function() {
		$('#cart').addClass('active');
		
		$('#cart').load('index.php?route=module/cart #cart > *');
		
		$('#cart').on('mouseleave', function() {
			$(this).removeClass('active');
		});
	});
	
	/* Mega Menu */
	$('#menu ul > li > a + div').each(function(index, element) {
		// IE6 & IE7 Fixes
		if ($.browser.msie && ($.browser.version == 7 || $.browser.version == 6)) {
			var category = $(element).find('a');
			var columns = $(element).find('ul').length;
			
			$(element).css('width', (columns * 143) + 'px');
			$(element).find('ul').css('float', 'left');
		}		
		
		var menu = $('#menu').offset();
		var dropdown = $(this).parent().offset();
		
		i = (dropdown.left + $(this).outerWidth()) - (menu.left + $('#menu').outerWidth());
		
		if (i > 0) {
			$(this).css('margin-left', '-' + (i + 5) + 'px');
		}
	});

	// IE6 & IE7 Fixes
	if ($.browser.msie) {
		if ($.browser.version <= 6) {
			$('#column-left + #column-right + #content, #column-left + #content').css('margin-left', '195px');
			
			$('#column-right + #content').css('margin-right', '195px');
		
			$('.box-category ul li a.active + ul').css('display', 'block');	
		}
		
		if ($.browser.version <= 7) {
			$('#menu > ul > li').on('mouseover', function() {
				$(this).addClass('active');
			});
				
			$('#menu > ul > li').on('mouseout', function() {
				$(this).removeClass('active');
			});	
		}
	}
	
	$('.success img, .warning img, .attention img, .information img').on('click', function() {
		$(this).parent().fadeOut('slow', function() {
			$(this).remove();
		});
	});
});

function simplecheckout_cart_clear() {
	const clear_cart = confirm("Вы уверены, что хотите очистить всю корзину?");
	if (clear_cart) {
        $('body').find('.quantity input').val(0);
    } else {
		return false;
	}
}

function getURLVar(key) {
	var value = [];
	
	var query = String(document.location).split('?');
	
	if (query[1]) {
		var part = query[1].split('&');

		for (i = 0; i < part.length; i++) {
			var data = part[i].split('=');
			
			if (data[0] && data[1]) {
				value[data[0]] = data[1];
			}
		}
		
		if (value[key]) {
			return value[key];
		} else {
			return '';
		}
	}
} 

function addToCart(product_id, quantity) {
	quantity = typeof(quantity) != 'undefined' ? quantity : 1;

	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: 'product_id=' + product_id + '&quantity=' + quantity,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information, .error').remove();
			
			if (json['redirect']) {
				location = json['redirect'];
			}
			
			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
				
				$('.success').fadeIn('slow');
				
				$('#cart-total').html(json['total']);
				
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	
		}
	});
}
function addToWishList(product_id) {
	$.ajax({
		url: 'index.php?route=account/wishlist/add',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information').remove();
						
			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
				
				$('.success').fadeIn('slow');
				
				$('#wishlist-total').html(json['total']);
				
				$('html, body').animate({ scrollTop: 0 }, 'slow');
			}	
		}
	});
}

function addToCompare(product_id) { 
	$.ajax({
		url: 'index.php?route=product/compare/add',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information').remove();
						
			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
				
				$('.success').fadeIn('slow');
				
				$('#compare-total').html(json['total']);
				
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	
		}
	});
}

function getCdekHtml(quotes) {
	let html = '';
	const code = '';

	$.each(quotes, function(i, quote) {
		let quote_code = quote['code'];
		let checked = (quote_code === code) ? 'checked="checked"' : '';
		let title = (quote['title_sub']) ? quote['title_sub'] : quote['title'];
		html += '<tr>';
		html += '<td class="code">';
		html += '<input type="radio" name="shipping_method" value="'+quote_code+'" id="'+quote_code+'" '+checked+' onchange="simplecheckout_reload(\'shipping_changed\');" />';
		html += '</td>';
		html += '<td class="title" valign="middle">';
		html += '<label for="'+quote_code+'">';
		html += title;
		html += '</label>';
		if (quote['img']) {
			html += '<label for="'+quote_code+'">';
			html += '<img src="'+ quote['img']+'" width="60" height="32" border="0" style="display:block;margin:3px;">';
			html += '</label>';
		}
		html += '</td>';
		html += '<td class="quote">';
		html += '<label for="'+quote_code+'">'+ quote['text']+'</label>';
		html += '</td>';
		html += '</tr>';

		if (quote['description']) {
			html += '<tr>';
			html += '<td class="code"></td>';
			html += '<td class="title">';
			html += '<label for="'+quote_code+'">'+ quote['description']+'</label>';
			html += '</td>';
			html += '<td class="quote"></td>';
			html += '</tr>';
		}
	});

	return html;
}