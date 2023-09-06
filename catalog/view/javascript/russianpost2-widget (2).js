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

function showRpMapWidget(widgetId, inputId, selecterId, city, type, title_with_no_pvz, cost, cost_text, weight, startZip, region)
{
	
	jQuery('#rp2box').remove();
	jQuery('#rp2overlay').remove();
	jQuery('#rp2boxHeader').remove();
	jQuery('#rp2boxBody').remove();
	
	var setWidth = 825;
	var setWidthBody = 795; 
	var setHeight = 620;
	var setHeightBody = 520; 
	
	var top =  (jQuery(window).height() - setHeight)/2;
	
	if( jQuery(window).width() > setWidth )
	{
		var left = (jQuery(window).width() - setWidth)/2;
		jQuery('#rp2box').css("width", setWidth+'px');
		//console.log('M1: '+jQuery(window).width()+' --- '+setWidth);
	}
	else
	{
		var left = 5;
		var setWidth = jQuery(window).width() - 10;
		setWidthBody = jQuery(window).width() - 40;
		
		//console.log('M2: '+jQuery(window).width()+' --- '+setWidth);
		//console.log('M3: '+setWidth);
		
		jQuery('#rp2box').css('width', setWidth+'px');
	}
	
	if( jQuery(window).height() > setHeight )
	{
		var top = (jQuery(window).height() - setHeight)/2;
		jQuery('#rp2box').css("height", setHeight+'px');
		//console.log('M4: '+jQuery(window).height()+' --- '+setHeight);
	}
	else
	{
		var top = 5;
		var setHeight = jQuery(window).height() - 10;
		setHeightBody = jQuery(window).height() - 40;
		
		//console.log('M5: '+jQuery(window).height()+' --- '+setHeight);
		//console.log('M6: '+setHeight);
		
		jQuery('#rp2box').css('height', setHeight+'px');
	}
	
	
	
	jQuery('body').prepend('<div id="rp2overlay" onclick="hideRpPopup();"></div>');
	
	html = '<div id="rp2box" style="height: '+setHeight+'px; width: '+setWidth+'px; " ';
	html += ' data-type="'+type+'"  data-inputid="'+inputId+'" data-selecterid="'+selecterId+'"';
	html += ' data-title_with_no_pvz="'+title_with_no_pvz+'"  data-cost="'+cost+'" data-cost_text="'+cost_text+'"';
	html += '>';
	
	
	html += '<div id="rp2boxHeader">Выбор пункта выдачи заказа</div>';
	
	html += '<div id="rp2boxClose"><a href=\'javascript: hideRpPopup();\'>X</a></div>';
	html += '<div id="rp2boxBody" style="width: '+setWidthBody+'px; height: '+setHeightBody+'px;"></div>';
	html += '</div>';
	
	jQuery('body').prepend(html);
	
	if( top < 0  ) top = 0;
	if( left < 0  ) left = 0;
	
	//jQuery('#rp2box').css("width", setWidth+'px');
	jQuery('#rp2box').css("left", left+'px');
	jQuery('#rp2box').css("top", top+'px');
	
	if( weight == '{weight_gramm}' )
		weight = 1000;
	
	var start_location = '';
	if( region && city )
	{
		start_location = region+', г '+city;
	}
	
    ecomStartWidget({
        id: widgetId,
        callbackFunction: russianpost2widgetHandler,
        containerId: 'rp2boxBody',
		weight: weight,
		start_location: start_location
    });
	 
	jQuery('#rp2boxBody iframe').css("width", setWidthBody+'px');
	jQuery('#rp2boxBody iframe').css("height", setHeightBody+'px');
}


function setRpPvz(selecterId, data_str, is_reload, type)
{
	var data = data_str.split('|');
	
	var REQUEST = {
		inputId: data[0],
		methodCode: data[1],
		delivery_point_index: data[2],
		cost: data[3],
		work_time: data[4],
		title: data[5],
		address: data[6],
		map: data[7],
		cost_text: data[8],
		latitude: data[9],
		longitude: data[10],
		brand_name: data[11],
		service_key: data[12],
		cod: data[13],
		type: type,
		indexTo: '',
		cityTo: '',
		regionTo: '',
		addressTo: '',
		listtype: data[15],
	};
	
	setTerminal(data[0], REQUEST, selecterId, is_reload);
}

function russianpost2widgetHandler(DATA)
{
	//console.log(DATA);
/*	
	addressTo: "ул Восточная 21"
areaTo: null
cashOfDelivery: 13800
cityTo: "г Екатеринбург"
deliveryDescription: {description: "от 1 до 1-х дней", values: {…}}
indexTo: "620100"
mailType: "ONLINE_PARCEL"
regionTo: "обл Свердловская"
weight: "1000"
*/
	var type = jQuery('#rp2box').data('type');
	var inputId = jQuery('#rp2box').data('inputid');
	var selecterId = jQuery('#rp2box').data('selecterid');
	var title_with_no_pvz = jQuery('#rp2box').data('title_with_no_pvz');
	var default_cost = jQuery('#rp2box').data('cost');
	var default_cost_text = jQuery('#rp2box').data('cost_text');
	
	// ---
	
	/*
	// russianpost2.rp1|
	russianpost2_rp1|
	927983|
	300|
	<strong>Режим работы</strong>: пн, вт, ср, чт, пт, сб, вс - с 10:00 до 19:30 (перерыв 10:00-19:30); <br> |
	
	ЕКОМ ПВЗ: г Екатеринбург, ул 8 Марта, 185, Гермес (#927983), Режим работы: пн, вт, ср, чт, пт, сб, вс - с 10:00 до 19:30 (перерыв 10:00-19:30);   Оплата заказа: только наличными|
	
	г Екатеринбург, ул 8 Марта, 185, Гермес|
	https://maps.yandex.ru/?z=17&text=%D0%B3+%D0%95%D0%BA%D0%B0%D1%82%D0%B5%D1%80%D0%B8%D0%BD%D0%B1%D1%83%D1%80%D0%B3%2C+%D1%83%D0%BB+8+%D0%9C%D0%B0%D1%80%D1%82%D0%B0%2C+185%2C+%D0%93%D0%B5%D1%80%D0%BC%D0%B5%D1%81|
	300.00 р.|
	56.795643|
	60.611135|
	Гермес|
	ecom|
	<strong>Оплата заказа</strong>: только наличными|
	*/
	
	var data_str = '';
	if( !$("#"+selecterId+" option[value='"+DATA.indexTo+"']").length )
	{
		var optionText = DATA.cityTo+', '+DATA.addressTo;
		
		var valuesArray = [];
		valuesArray[0] = inputId; // russianpost2.rp1|
		valuesArray[1] = selecterId; // russianpost2_rp1|
		valuesArray[2] = DATA.indexTo; // 927983|
		valuesArray[3] = default_cost; // 300|
		valuesArray[4] = '' //  Режим работы: пн, вт, ср, чт, пт, сб, вс - с 10:00 до 19:30 (перерыв 10:00-19:30);   Оплата заказа: только наличными|
		
		if( title_with_no_pvz.indexOf('{pvz_block}') >= 0 )
			valuesArray[5] = title_with_no_pvz.replace('{pvz_block}', 'ПВЗ '+DATA.indexTo+', '+optionText); //г Екатеринбург, ул 8 Марта, 185, Гермес|
		else if( title_with_no_pvz.indexOf('{ops_block}') >= 0 )
			valuesArray[5] = title_with_no_pvz.replace('{ops_block}', 'ПВЗ '+DATA.indexTo+', '+optionText); //г Екатеринбург, ул 8 Марта, 185, Гермес|
		else
			valuesArray[5] = 'ПВЗ '+optionText;
		
		valuesArray[6] = optionText; 
		valuesArray[7] = ''; //https://maps.yandex.ru/?z=17&text=%D0%B3+%D0%95%D0%BA%D0%B0%D1%82%D0%B5%D1%80%D0%B8%D0%BD%D0%B1%D1%83%D1%80%D0%B3%2C+%D1%83%D0%BB+8+%D0%9C%D0%B0%D1%80%D1%82%D0%B0%2C+185%2C+%D0%93%D0%B5%D1%80%D0%BC%D0%B5%D1%81|
		valuesArray[8] = default_cost_text; //300.00 р.|
		valuesArray[9] = ''; //56.795643|
		valuesArray[10] = ''; //60.611135|
		valuesArray[11] = 'Почта России или партнерская сеть'; //Гермес|
		valuesArray[12] = 'parcel_online';
		valuesArray[13] = ''; //<strong>Оплата заказа</strong>: только наличными| 
		
		var html = '<option data-dat="'+valuesArray.join("|")+'"></option>';
		
		$("#"+selecterId).append($(html)
						.attr("value", DATA.indexTo)
						.text(optionText)
		); 
		
		valuesArray[14] = '';
		
		if( $("#"+selecterId+"").prop("selectedIndex", 0).length )
		{
			valuesArray[15] = '';
			var first_ar = $("#"+selecterId+" option").prop("selectedIndex", 0).data('dat').split("|");
			
			valuesArray[15] = first_ar[15];
		}
		
		data_str = valuesArray.join("|");
	}
	else
	{
		data_str = jQuery('option[value=' + DATA.indexTo + ']', jQuery('#'+selecterId)).data('dat');
	}
	
	// <option value="927983" data-dat="russianpost2.rp1|russianpost2_rp1|927983|300|<strong>Режим работы</strong>: пн, вт, ср, чт, пт, сб, вс - с 10:00 до 19:30 (перерыв 10:00-19:30); <br> |ЕКОМ ПВЗ: г Екатеринбург, ул 8 Марта, 185, Гермес (#927983), Режим работы: пн, вт, ср, чт, пт, сб, вс - с 10:00 до 19:30 (перерыв 10:00-19:30);   Оплата заказа: только наличными|г Екатеринбург, ул 8 Марта, 185, Гермес|https://maps.yandex.ru/?z=17&amp;text=%D0%B3+%D0%95%D0%BA%D0%B0%D1%82%D0%B5%D1%80%D0%B8%D0%BD%D0%B1%D1%83%D1%80%D0%B3%2C+%D1%83%D0%BB+8+%D0%9C%D0%B0%D1%80%D1%82%D0%B0%2C+185%2C+%D0%93%D0%B5%D1%80%D0%BC%D0%B5%D1%81|300.00 р.|56.795643|60.611135|Гермес|ecom|<strong>Оплата заказа</strong>: только наличными|">г Екатеринбург, ул 8 Марта, 185, Гермес Оплата заказа: только наличными </option>
	
	jQuery('#'+selecterId).val(DATA.indexTo);
	
	var is_reload = 1;
	var data = data_str.split('|');
 
	var REQUEST = {
		inputId: data[0],
		methodCode: data[1],
		delivery_point_index: data[2],
		cost: data[3],
		work_time: data[4],
		title: data[5],
		address: data[6],
		map: data[7],
		cost_text: data[8],
		latitude: data[9],
		longitude: data[10],
		brand_name: data[11],
		service_key: data[12],
		cod: data[13],
		type: type,
		indexTo: DATA.indexTo,
		cityTo: DATA.cityTo,
		regionTo: DATA.regionTo,
		addressTo: DATA.addressTo, 
		listtype: data[15],
	};
	
	setTerminal(data[0], REQUEST, selecterId, is_reload);
}


function setTerminal(inputId, REQUEST, selecterId, is_reload)
{
	if( !REQUEST.type )
		REQUEST.type = 'ops';
	
	selectId = selecterId.replace("_", ".");
	
	var inp = $('input[name="shipping_method"][value="'+selectId+'"]');
	
	if( typeof $(inp).val() === 'undefined' )
	{
		//console.log('m0.1');
		var inp = $('#'+selecterId).parent('div').parent('label').children( "input:radio" );
	}
	
	if( typeof $(inp).val() === 'undefined' )
	{
		//console.log('m1');
		var inp = $('#'+selecterId).parent('div').parent('span').parent('label').children( "input:radio" );
	}
	
	if( typeof $(inp).val() === 'undefined' )
	{ 
		var inp = $('#'+selecterId).parent('div').parent('span').parent('span').parent('span').parent('label').children( "input:radio" );
	}
	
	var ID = 'input:radio[value="'+$(inp).val()+'"]';
	
	//console.log("input: "+inp);
	//console.log("indexTo: "+REQUEST.indexTo);
	//console.log("selecterId: "+jQuery('#'+selecterId).val());
	
	
    $.ajax({
		url: 'index.php?route=payment/rpcod2/setTerminal',
		type: 'post',
        dataType: 'json',
		data: {
			type: REQUEST.type,
			code: REQUEST.methodCode,
			delivery_point_index: REQUEST.delivery_point_index,
			work_time: REQUEST.work_time,
			title: REQUEST.title,
			cost: REQUEST.cost,
			text: REQUEST.cost_text,
			address: REQUEST.address, 
			brand_name: REQUEST.brand_name, 
			service_key: REQUEST.service_key, 
			cod: REQUEST.cod, 
			cityTo: REQUEST.cityTo,
			regionTo: REQUEST.regionTo,
			addressTo: REQUEST.addressTo,
			listtype: REQUEST.listtype,
		},
        success: function(json) {
           
		   if( json.status == 'OK' )
		   {
		   setCookie('rp_selected_pvz___'+REQUEST.listtype, REQUEST.delivery_point_index, 1);
			
			$('span[id="rp-'+REQUEST.type+'-address'+inputId+'"]').html(REQUEST.address);
			 
			$('span[id="rp-'+REQUEST.type+'-work_time'+inputId+'"]').html(REQUEST.work_time);
			$('span[id="rp-'+REQUEST.type+'-cod'+inputId+'"]').html(REQUEST.cod);
			if( REQUEST.indexTo.length )
				$('span[id="rp-'+REQUEST.type+'-postcode'+inputId+'"]').html(REQUEST.indexTo);
			else if( REQUEST.delivery_point_index.length )
				$('span[id="rp-'+REQUEST.type+'-postcode'+inputId+'"]').html(REQUEST.delivery_point_index);
			else 
				$('span[id="rp-'+REQUEST.type+'-postcode'+inputId+'"]').html('');
			
			if( REQUEST.type == 'pvz' )
				$('span[id="rp-'+REQUEST.type+'-brand_name'+inputId+'"]').html(REQUEST.brand_name);
			 
			if( $('span[id="rp-'+REQUEST.type+'-map'+inputId+'"]').length )
			{
				$('span[id="rp-'+REQUEST.type+'-map'+inputId+'"]').attr("href", REQUEST.map);
			}
			
			$('#'+REQUEST.methodCode).val( REQUEST.delivery_point_index );
			
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
			
			if( json.new_postcode && !json.new_postcode.match(/^9/) )
			{
				if( $('#input-shipping-postcode').length )
				{
					$('#input-shipping-postcode').val(json.new_postcode);
				}
				
				if( $('#shipping_address_postcode').length )
				{
					$('#shipping_address_postcode').val(json.new_postcode);
				}
			}
			
			if( json.new_city )
			{
				if( $('#input-shipping-city').length )
				{
					$('#input-shipping-city').val(json.new_city);
				}
				
				if( $('#shipping_address_city').length )
				{
					$('#shipping_address_city').val(json.new_city);
				}
				if( $('#input-payment-city').length )
				{
					$('#input-payment-city').val(json.new_city);
				}
				
				
			}
			
			if( json.new_zone_id )
			{
				if( $('#input-shipping-zone').length )
				{
					$('#input-shipping-zone').val(json.new_zone_id);
				}
				
				if( $('#shipping_address_zone_id').length )
				{
					$('#shipping_address_zone_id').val(json.new_zone_id);
				}
				
				if( $('#input-payment-zone').length )
				{
					$('#input-payment-zone').val(json.new_zone_id);
				}
			}
			
			
			if( json.rp_opsinfo )
			{
				if( $('#rp_opsinfo').length )
				{
					$('#rp_opsinfo').replaceWith(json.rp_opsinfo);
				}					 
			}
			
			if( json.comment && $('#comment').length )
			{
				$('#comment').val( json.comment );
			}
			if( is_reload )
			{
				$(ID).trigger('change'); 
				$(ID).trigger('click'); 
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
			
			hideRpPopup();
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