function setRPPVZFromSelect(th, is_replod, type){
	
	if( !type )
		type = 'ops';
	
	
	if( typeof th !== 'undefined' && typeof $(th) !== 'undefined' && typeof $(th).val() !== 'undefined' )
	{
		var data_str = $('#'+$(th).attr('id')+' option[value="'+$(th).val()+'"]').data('dat');
		
		setRpPvz($(th).attr('id'), data_str, is_replod, type);
	
		var data = data_str.split('|');
		$('#'+data[0].replace("russianpost2_", "russianpost2_"+type+"_sel") ).val( data[1] );
		
		$('input[value=\''+data[0]+'\']').prop('checked', true);
	}
}
 

function setRpPvzFromMap(ID, selecterId, type){
	var data_str = $('#'+ID).html();
	
	if( !type )
		type = 'ops';
	
	setRpPvz(selecterId, data_str, 1, type);
	
	var data = data_str.split('|');
	  
	$('#'+data[0].replace("russianpost2_", "russianpost2_"+type+"_sel") ).val( data[1] );
	
	hideRpPopup();
} 

function setRpPvz(selecterId, data_str, is_reload, type)
{
	var data = data_str.split('|');
	
	if( !type )
		type = 'ops';
	
	var inputId = data[0];
	var methodCode = data[1];
	var delivery_point_index = data[2];
	var cost = data[3];
	var work_time = data[4];
	var title = data[5];
	var address = data[6];
	var map = data[7];
	var cost_text = data[8];
	var latitude = data[9];
	var longitude = data[10];
	var brand_name = data[11];
	
	var service_key = data[12];
	var cod = data[13];
	var city = data[14]; 
	var listtype = data[15];
	
	selectId = selecterId.replace("_", ".");
	
	var inp = $('input[name="shipping_method"][value="'+selectId+'"]');
	
	if( typeof $(inp).val() === 'undefined' )
	{
		console.log('m0.1');
		var inp = $('#'+selecterId).parent('div').parent('label').children( "input:radio" );
	}
	
	if( typeof $(inp).val() === 'undefined' )
	{
		console.log('m1');
		var inp = $('#'+selecterId).parent('div').parent('span').parent('label').children( "input:radio" );
	}
	
	if( typeof $(inp).val() === 'undefined' )
	{ 
		var inp = $('#'+selecterId).parent('div').parent('span').parent('span').parent('span').parent('label').children( "input:radio" );
	}
	
	if( typeof $(inp).val() === 'undefined' )
	{ 
		var inp = $('#'+selecterId).parent('div').parent('div').parent('label').parent('td').parent('tr').children("td:first-child").children( "input:radio" );
	}
	
	var ID = 'input:radio[value="'+$(inp).val()+'"]';
	
    $.ajax({
		url: 'index.php?route=payment/rpcod2/setTerminal',
		type: 'post',
        dataType: 'json',
		data: {
			type: type,
			code: methodCode,
			delivery_point_index: delivery_point_index,
			work_time: work_time,
			title: title,
			cost: cost,
			text: cost_text,
			address: address, 
			brand_name: brand_name, 
			service_key: service_key, 
			cod: cod ,
			city: city,
			listtype: listtype
		},
        success: function(json) {
           
		   if( json.status == 'OK' )
		   {
		    setCookie('rp_selected_pvz___'+listtype, delivery_point_index, 1);
			
			$('span[id="rp-'+type+'-address'+inputId+'"]').html(address);
			 
			$('span[id="rp-'+type+'-work_time'+inputId+'"]').html(work_time);
			$('span[id="rp-'+type+'-cod'+inputId+'"]').html(cod);
			
			//if( type == 'pvz' )
			//	$('span[id="rp-'+type+'-brand_name'+inputId+'"]').html(brand_name);
			 
			if( $('span[id="rp-'+type+'-map'+inputId+'"]').length )
			{
				$('span[id="rp-'+type+'-map'+inputId+'"]').attr("href", map);
			}
			$('span[id="rp-'+type+'-postcode'+inputId+'"]').html(delivery_point_index);
			
			$('#'+methodCode).val( delivery_point_index );
			
			$(ID).prop('checked', 'checked');
			$(ID).attr('checked', true);
			 
			if( $('select[name=\'shipping_method\']').length )
			{
				$('select[name=\'shipping_method\']').val(inputId);
				$('select[name=\'shipping_method\']').trigger('change'); 
			} 
			
			
			if( json.address_1 )
			{ 
				if( $('#input-shipping-address-1').length )
				{ 
					$('#input-shipping-address-1').val( json.address_1 );
				}
				
				if( $('#input-payment-address-1').length )
				{
					$('#input-payment-address-1').val( json.address_1 );
				}
					
				if( $('#shipping_address_address_1').length )
				{
					$('#shipping_address_address_1').val( json.address_1 );
				}
				
				if( $('#payment_address_address_1').length )
				{
					$('#payment_address_address_1').val( json.address_1 );
				}
			}
			
			if( json.address_2 )
			{
				if( $('#input-shipping-address-2').length )
				{
					$('#input-shipping-address-2').val( json.address_2 );
				} 
				
				if( $('#input-payment-address-2').length )
				{
					$('#input-payment-address-2').val( json.address_2 );
				}
					
				if( $('#shipping_address_address_2').length )
				{
					$('#shipping_address_address_2').val( json.address_2 );
				}
					
				if( $('#payment_address_address_2').length )
				{
					$('#payment_address_address_2').val( json.address_2 );
				}  
			}  
			
			
			if( !delivery_point_index.match(/^9/) )
			{
				if( delivery_point_index && $('#shipping_address_postcode').length )
				{
					$('#shipping_address_postcode').val( delivery_point_index );
				}
				
				if( delivery_point_index && $('#payment_address_postcode').length )
				{
					$('#payment_address_postcode').val( delivery_point_index );
				}
				
				if( delivery_point_index && $('input[name="postcode"]').length )
				{ 
					$('input[name="postcode"]').val( delivery_point_index );
				} 
			}
			
			if( typeof json.city !== 'undefined' && $('#shipping_address_city').length && $('#shipping_address_city').val() !== json.city )
			{
				$('#shipping_address_city').val( json.city );
			}
			
			if( typeof json.city !== 'undefined' && $('#payment_address_city').length && $('#payment_address_city').val() !== json.city )
			{
				$('#payment_address_city').val( json.city );
			}
			
			if( json.comment && $('#comment').length )
			{
				$('#comment').val( json.comment );
			}
			
			if( is_reload )
			{
				if (typeof simplecheckout_reload === "function") 
				{ 
					simplecheckout_reload('shipping_changed');
				} 
				else
				{
					$(ID).trigger('shipping_changed'); 
					$(ID).trigger('click'); 
					
					if( check_is_func_exists("reloadAll") )
					{					
						reloadAll();
					}
				}
			}
			 
			if( $('input[name=\'shipping_method\'][value=\'' + inputId + '\']').length && $('#input-payment-address-1').length )
				$('input[name=\'shipping_method\'][value=\'' + inputId + '\']').attr('checked', 'checked');
			
			if( $('.checkout__input-box-title').length )
			{
				refreshmetods();
			}
			
			if( $('#custcart').length )
			{
				refreshcart();
			}
		   }
		   else
		   {
			  alert('ERROR: '+html);
		   }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

function showRpMap(inputId, selecterId, city, type)
{
	if( !type )
		type = 'ops';
	
	jQuery('#rp2box').remove();
	jQuery('#rp2overlay').remove();
	jQuery('#rp2boxHeader').remove();
	jQuery('#rp2boxBody').remove();
	
	// -------
	
	var setWidth = 800;
	var setWidthBody = 765;
	var setHeight = 520;
	var setHeightBody = 420;
	
	if( jQuery(window).width() > setWidth )
	{
		var left = (jQuery(window).width() - setWidth)/2;
		jQuery('#rp2box').css("width", setWidth+'px');
		console.log('M1: '+jQuery(window).width()+' --- '+setWidth);
	}
	else
	{
		var left = 5;
		var setWidth = jQuery(window).width() - 10;
		setWidthBody = jQuery(window).width() - 40;
		
		console.log('M2: '+jQuery(window).width()+' --- '+setWidth);
		console.log('M3: '+setWidth);
		
		jQuery('#rp2box').css('width', setWidth+'px');
	}
	
	jQuery('body').prepend('<div id="rp2overlay" onclick="hideRpPopup();"></div>');
	
	html = '<div id="rp2box" style="height: '+setHeight+'px; width: '+setWidth+'px; ">';
	
	html += '<div id="rp2boxHeader">Выбор пункта выдачи заказа</div>';
	
	html += '<div id="rp2boxClose"><a href=\'javascript: hideRpPopup();\'>X</a></div>';
	html += '<div id="rp2boxBody" style="width: '+setWidthBody+'px; height: '+setHeightBody+'px;"></div>';
	html += '</div>';
	
	jQuery('body').prepend(html);
	
	var top =  (jQuery(window).height() - setHeight)/2;
	if( top < 0  ) top = 0;
	
	//jQuery('#rp2box').css("width", setWidth+'px');
	jQuery('#rp2box').css("left", left+'px');
	jQuery('#rp2box').css("top", top+'px');
	
	// -------
	
	var data_str = jQuery('option[value=' + jQuery('#'+selecterId).val() + ']', jQuery('#'+selecterId)).data('dat');
	var data = data_str.split('|');
	 
	
	var geoX = data[9];
	var geoY = data[10]; 
	
	
	ymaps.ready(function() {
		var map = new ymaps.Map("rp2boxBody", {
				center: [geoX, geoY], 
				zoom: 12
		});
		
		
		var tmpHtml = '<div style="width: 200px;">';
		
		tmpHtml += '<div><b>Отделение/ПВЗ:</b> $[properties.value] </div>';
		
		tmpHtml += '<div><b>Город:</b> $[properties.city] </div>';
		tmpHtml += '<div><b>Адрес:</b> $[properties.address]</div>'+ 
		'$[properties.cod]'+
		'<div><span id="span_$[properties.value]" style="display:none;">$[properties.data_str]</span>';
		
		tmpHtml += '<input type="button" style="color: #ffffff; background-color: #229ac8;  border: 0px;" value="Выбрать" onclick="setRpPvzFromMap(\'span_$[properties.value]\', \''+selecterId+'\', \'ops\');"></div>';
		
		tmpHtml += '</div>';
		
		
		var balloon = ymaps.templateLayoutFactory.createClass(
			tmpHtml
		);
		
		var points = [];
		jQuery("#"+selecterId+" option").each(function() { 
			var data2_str = jQuery(this).data('dat'); 
			var data2 = data2_str.split('|');
			
	
			points[ points.length ] = {
					value: data2[2],
					geoX: data2[9], 
					geoY: data2[10],
					address: data2[6],
					work_time: data2[4],
					brand_name:	data2[11],
					data_str: data2_str,
					selecterId:	selecterId,
					service_key:	data2[12],
					cod:	data2[13],
					city:	data2[14]
			};
		});
		
		var myGeoObjects = [];
		
		for(var i =0; i<points.length; i++)
		{
			geoObject = new ymaps.GeoObject({
				geometry: {
					type: "Point",// тип геометрии - точка
					coordinates: [points[i]['geoX'], points[i]['geoY']] // координаты точки
				},
				properties: {
					value: 		points[i]['value'],
					geoX: 		points[i]['geoX'],
					geoY: 		points[i]['geoY'],
					address: 	points[i]['address'],
					work_time: 	points[i]['work_time'],
					brand_name: points[i]['brand_name'],
					data_str:	points[i]['data_str'],
					service_key:	points[i]['service_key'],
					cod:	points[i]['cod'],
					city:	points[i]['city']
				}
			},
			{
				//	balloonLayout: LayoutWrapper,
					balloonContentLayout: balloon,
					balloonPanelMaxMapArea: 0,
					iconColor: '#3caa3c'
			}
			);
			
			geoObject.events.add('click', function (e) {
				var object = e.get('target');
				
				object.balloon.open();
				//geoObject.openBalloon([object.properties.get('geoX'), object.properties.get('geoY')], 
				//object.properties.get('address'));
				
				//ymaps.openBalloon( object.properties.get('address'), {maxWidth: 100} );
			});
			
			myGeoObjects[ i ] = geoObject;
			//map.geoObjects.add(geoObject); 
		}
		
		
		var clusterer = new ymaps.Clusterer({ clusterDisableClickZoom: false, gridSize: 128, hasBalloon: false, hasHint: false, minClusterSize: 4 });
		clusterer.add(myGeoObjects);
		map.geoObjects.add(clusterer);
		
		
		
		
	});
}

function clearAddressIfNoRp(value)
{ 
	var payment_address_1 = '';
	var payment_address_2 = '';
	var shipping_address_1 = '';
	var shipping_address_2 = '';
	 
	if( $('#payment_address_address_1').length )
		payment_address_1 = $('#payment_address_address_1').val();
	else if( $('#input-payment-address-1').length )
		payment_address_1 = $('#input-payment-address-1').val();
	
	if( $('#payment_address_address_2').length )
		payment_address_2 = $('#payment_address_address_2').val();
	else if( $('#input-payment-address-2').length )
		payment_address_2 = $('#input-payment-address-2').val();
	
	if( $('#shipping_address_address_1').length )
		shipping_address_1 = $('#shipping_address_address_1').val();
	else if( $('#input-shipping-address-1').length )
		shipping_address_1 = $('#input-shipping-address-1').val();
	
	if( $('#shipping_address_address_2').length )
		shipping_address_2 = $('#shipping_address_address_2').val();
	else if( $('#input-shipping-address-2').length )
		shipping_address_2 = $('#input-shipping-address-2').val(); 
				
				
	 $.ajax({
		url: 'index.php?route=payment/rpcod2/clearAddressIfNoRp',
        dataType: 'json',
		type: 'post',
		data: {
			payment_address_1: payment_address_1,
			payment_address_2: payment_address_2,
			shipping_address_1: shipping_address_1,
			shipping_address_2: shipping_address_2
		},
		success: function(json) { 
		   
			if( json.address_1 )
			{ 
				if( $('#input-shipping-address-1').length )
				{ 
					$('#input-shipping-address-1').val( json.address_1 );
				}
				
				if( $('#input-payment-address-1').length )
				{
					$('#input-payment-address-1').val( json.address_1 );
				}
					
				if( $('#shipping_address_address_1').length )
				{
					$('#shipping_address_address_1').val( json.address_1 );
				}
				
				if( $('#payment_address_address_1').length )
				{
					$('#payment_address_address_1').val( json.address_1 );
				}
			}
			
			if( json.address_2 )
			{
				if( $('#input-shipping-address-2').length )
				{
					$('#input-shipping-address-2').val( json.address_2 );
				} 
				
				if( $('#input-payment-address-2').length )
				{
					$('#input-payment-address-2').val( json.address_2 );
				}
					
				if( $('#shipping_address_address_2').length )
				{
					$('#shipping_address_address_2').val( json.address_2 );
				}
					
				if( $('#payment_address_address_2').length )
				{
					$('#payment_address_address_2').val( json.address_2 );
				}  
			}  
			
			if( $('#comment').length )
			{
				$('#comment').val( json.comment ); 
			}
			
			if( $('textarea[name=\'comment\']').length )
			{
				$('textarea[name=\'comment\']').val( json.comment );
			}
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

function hideRpPopup()
{
	$('#rp2box').hide();
	$('#rp2overlay').hide();
	$('#rp2boxHeader').hide();
	$('#rp2boxBody').hide();
	
	$('#rp2box').remove();
	$('#rp2overlay').remove();
	$('#rp2boxHeader').remove();
	$('#rp2boxBody').remove();
}

function check_is_func_exists(func)
{
	var obj =  window[func];
	
	if (obj && typeof obj === 'function')
	{
		return true;
	}
	else
	{
		return false;
	}
}

function changeRPPostcode(postcode)
{
	if( !postcode )
		return;
	
    $.ajax({
		url: 'index.php?route=payment/rpcod2/setPostcode',
		type: 'post',
        dataType: 'json',
		data: {
			postcode: postcode, 
		},
        success: function(json) {
		   if( json.listTypes.length > 0 )
		   {
			   for(var i=0; i<json.listTypes.length; i++)
			   {
				   setCookie('rp_selected_pvz___'+json.listTypes[i], postcode, 1);
			   }
		   }
        },
        error: function(xhr, ajaxOptions, thrownError) {
           // alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    }); 
}

function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}