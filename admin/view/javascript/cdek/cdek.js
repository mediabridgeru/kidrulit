function changePVZ(element){
alert('asa');
	if (1 === $('body').data('cdek_binding')) {
		return false;
	}

	$('body').data('cdek_binding', 1);

	var self = element;
	var tariff_id = $(self).data('id');

	//var input = $('input[name=shipping_method][value^=\'cdek.pvz_' + tariff_id + '\']');
	var input = $('input[value^=\'cdek.pvz_' + tariff_id + '\']');

	if (!input.length) {
		return false;
	}

	$('input[name=shipping_method]').attr('checked', '').removeAttr('checked');

	$(input).prop('checked', 'checked');

	var parent = $(self).closest('.cdek-container');
	var code = $(self).val();
	var option = $('option[value=' + code + ']', self);

	var html = '<strong>Адрес</strong>: ' + $(option).data('address');

	html += '<br />';

	if ($(option).data('phone') != '') {
		html += '<strong>Телефон</strong>: ' + $(option).data('phone') + '<br />';
	}

	if ($(option).data('worktime') != '') {
		html += '<strong>Режим работы</strong>: ' + $(option).data('worktime');
	}

	$('.cdek-pvz-info', parent).html(html);

	var data = {
		'code': code,
		'tariff_id': tariff_id,
		'old_key': input.val()
	};

	$.getJSON("/index.php?route=shipping/cdek", data, function (json) {

		if ('ok' == json.status) {

			var parts = data.old_key.split('.');
			var code_parts = parts[1].split('_');

			if (2 < code_parts.length) {
				$(input).attr('value', 'cdek.pvz_' + tariff_id + '_' + code);
			}

			$(input).trigger('change');
		}

		$('body').data('cdek_binding', 0);
	});
};
