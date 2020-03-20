/*
    @author: Igor Mirochnik
    @copyright:  Igor Mirochnik
    Site: http://ida-freewares.ru
    Site: http://im-cloud.ru
    Email: dev.imirochnik@gmail.com
    Type: commercial
*/

// Стандартная заглушка
(jQuery.browser = jQuery.browser || {}).msie = false;

// Формируем ссылку
function IMR_formLink(link, name, param_name, param_id) {
	var result = '<a target="_blank" ';
	result += ' href="' + link + '&' + param_name + '=' + param_id  + '" >';
	//result += decodeURIComponent(name);
	result += name;
	return result + '</a>';
}

function IMR_parseDate(date) {
	// Если нечего парсить
	if (!date) return null;
	// Если код изначально был в формате C#
	if (typeof(date) === 'string' && date.indexOf('/Date(') === 0) return new Date(parseInt(date.substring(6)));
	// Если мы взяли iso формат
	else if (typeof(date) === 'string' && date.replace('-', '').length != date.length) {
		return new Date(date.replace(/(\d+)-(\d+)-(\d+)/, '$2/$3/$1'));
	}
	// Если мы взяли русский формат
	else if (typeof(date) === 'string' && date.replace('.', '').length != date.length) {
		return new Date(date.replace(/(\d+)\.(\d+)\.(\d+)/, '$2/$1/$3'));
	}
	// Если передан готовый объект
	else if (typeof(date) === 'object' && date.constructor === Date) return date;
	// Пришел некорректный параметр отдаем пустой объект
	return null;
}

function IMR_toDate(_date) {
	var date;
	// Если входной формат не корректен,
	// то возвращаем пустую строку
	if (!(date = IMR_parseDate(_date))) return '';
	return (date.getDate() < 10 ? '0' + date.getDate() : '' + date.getDate()) + '.' + (date.getMonth() + 1 < 10 ? '0' + (date.getMonth() + 1) : '' + (date.getMonth() + 1)) + '.' + date.getFullYear() + ' ' + (date.getHours() < 10 ? '0' + date.getHours() : '' + date.getHours()) + ':' + (date.getMinutes() < 10 ? '0' + date.getMinutes() : '' + date.getMinutes());
}

function IMR_toDateOnly(_date)
{
	var date;
	// Если входной формат не корректен,
	// то возвращаем пустую строку
	if (!(date = IMR_parseDate(_date))) return '';
	return (date.getDate() < 10 ? '0' + date.getDate() : '' + date.getDate())
		+ '.' + (date.getMonth() + 1 < 10 ? '0' + (date.getMonth() + 1) : '' + (date.getMonth() + 1))
		+ '.' + date.getFullYear();
}

/////////////////////////////////////////////////////////////////////////
// Тюнинг
/////////////////////////////////////////////////////////////////////////

function IMR_OnceRegisterParser(pattern)
{
	if ($.tablesorter.isHaveParser('patterndigit')) {
		return;
	}
	$.tablesorter.addParser({
	    // set a unique id
	    id: 'patterndigit',
	    is: function(s) {
	    	var reg = new RegExp('([0-9]+[\.][0-9]{2})')
	    	;
	    	var	matchs = s.match(reg)
	    	;

	    	if (matchs) {
				return $.trim(pattern.replace('[digit]', matchs[1])) == $.trim(s);
			}
	        return false;
	    },
	    format: function(s) {
	    	var reg = new RegExp('([0-9]+[\.][0-9]{2})')
	    	;
	    	var	matchs = s.match(reg)
	    	;

	    	if (matchs) {
				return $.tablesorter.formatFloat(matchs[1]);
			} else {
				return $.tablesorter.formatFloat(0);
			}

	        // format your data for normalization
	        //return s.toLowerCase().replace(/good/,2).replace(/medium/,1).replace(/bad/,0);
	    	//return $.tablesorter.formatFloat(s);
	    },
	    // set type, either numeric or text
	    type: 'numeric'
	});

}

// Тюнинг таблицы
/*
	options : {
		colspan
		count,
		cost,
		pattern,
		sortList,
		not_need_cost,
		not_need_count,
		not_need_footer,
		not_need_sort,
		table_footer_all,
		funcOnTableApplyWidgets,
		num_rows_displayed,
		footer_fields = array (obj, obj, float, int...)
			obj = {val:, is_cost:}
	}
*/
function IMR_tuneUpTable(form, _options) {
	var table = form.find('table.table-results'),
		options = $.extend(
			true,
			{
				table_footer_all: (table_footer_all ? table_footer_all : ''),
				num_rows_displayed: 10
			},
			_options
		)
	;

	// Добавляем автосчетчик
	if (table.find('thead th.head-counter').length == 0) {
		jQuery('<th class="header head-counter">#</th>')
		.insertBefore(table.find('thead tr:eq(0) th:eq(0)'))
		;
	}

	table.find('tbody').find('tr').each(function (k, i) {
		var row = jQuery(this)
		;
		jQuery('<td class="auto-add-col">' + (k + 1) + '</td>').insertBefore(row.find('td:eq(0)'));
	});

	// Если нужен подвал
	if (!options.not_need_footer) {
		// Формируем подвал
		if (table.children('tfoot').length == 0) {
			table.append('<tfoot>');
		}

		var foot = table.children('tfoot')
		;

		foot.html('');

		var tr = jQuery('<tr/>');

		foot.append(tr);

		tr.append(
			'<td colspan="' + (options.colspan + 1) + '">'
				+ options.table_footer_all
			+ '</td>'
		);

		//footer_fields
		//footer_fields = array (obj, obj, float, int...)
		//	obj = {val:, is_cost:}
		if (options.footer_fields) {
			if (jQuery.isArray(options.footer_fields)) {
				for (var cnt = 0; cnt < options.footer_fields.length; cnt++) {
					var item = options.footer_fields[cnt]
					;
					if (typeof item == 'object') {
						if (item.is_cost) {
							tr.append(
								'<td class="text-right">'
									//+ new Number(options.cost).toFixed(2)
									+ options.pattern.replace('[digit]', (new Number(item.val).toFixed(2)))
								+ '</td>'
							);
						} else {
							tr.append(
								'<td class="text-right">'
									+ item.val
								+ '</td>'
							);
						}
					} else {
						tr.append(
							'<td class="text-right">'
								+ item
							+ '</td>'
						);
					}
				}
			}
		}

		if (!options.not_need_count) {
			tr.append(
				'<td class="text-right">'
					+ options.count
				+ '</td>'
			);
		}

		if (!options.not_need_cost) {
			tr.append(
				'<td class="text-right">'
					//+ new Number(options.cost).toFixed(2)
					+ options.pattern.replace('[digit]', (new Number(options.cost).toFixed(2)))
				+ '</td>'
			);
		}

	}

	if (!options.not_need_cost && options.pattern) {
		IMR_OnceRegisterParser(options.pattern);
	}

	// Если сортировка не нужна
	if (options.not_need_sort) {
		return;
	}

	// Проверяем корректность значения
	options.num_rows_displayed
		= options.num_rows_displayed > 0 ? options.num_rows_displayed : 10;

	// Проверяем, что поля для фильтра нет
	if (table.find('caption').length == 0) {
		table.append(
			'<caption>'
				+ '<div class="col-sm-4 left-part">'
					+ '<div class="input-group mb-2 mr-sm-2 mb-sm-0">'
				    	+ '<div class="input-group-addon">'
				    		+ '<i class="fa fa-search"></i> '
				    	+ '</div>'
				    	+ '<input type="text" class="form-control imrep-table-filter" value="">'
				  	+ '</div>'
				+ '</div>'
				+ '<div class="col-sm-8 right-part form-inline">'
				  	+ '<div class="imrep-table-pager">'
						+ '<div class="pull-right">'
							+ '<button class="btn btn-info first">&lt;&lt;</button>'
							+ '&nbsp;&nbsp;'
							+ '<button class="btn btn-info prev">&lt;</button>'
							+ '&nbsp;&nbsp;'
							+ '<select class=" form-control pagedisplay"/>'
							+ '&nbsp;&nbsp;'
							+ '<button class="btn btn-info next">&gt;</button>'
							+ '&nbsp;&nbsp;'
							+ '<button class="btn btn-info last">&gt;&gt;</button>'
							+ '&nbsp;&nbsp;'
							+ '<select class="pagesize form-control">'
								+ '<option  value="10">10</option>'
								+ '<option  value="25">25</option>'
								+ '<option  value="50">50</option>'
								+ '<option  value="100">100</option>'
								+ '<option  value="250">250</option>'
								+ '<option  value="500">500</option>'
								+' <option  value="10000000">---</option>'
							+ '</select>'
						+ '</div>'
					+ '</div>'
				+ '</div>'
			+ '</caption>'
		);

		var selectPS = table.find('caption select.pagesize'),
			optionPS = selectPS.find('option[value="' + options.num_rows_displayed + '"]')
		;
		if (optionPS.length > 0) {
			optionPS.prop('selected', 'selected');
		} else {
			selectPS.prepend(
				'<option selected="selected" '
					+ ' value="' + options.num_rows_displayed + '">'
						+ options.num_rows_displayed
					+ '</option>'
			);
		}
	}

	// Добавляем сортировку и фильтрацию
	if (!table.data('tablesorter')) {
		table
			.addClass('tablesorter')
			.tablesorter({
				sortList: (options.sortList ? options.sortList : [[0,0]])
			})
			//.tablesorterPager({container: form.find('.imrep-table-pager')})
		;
		table.bind('addpager', function () {
			if (!table.data('is_have_pager')) {
				table.data('is_have_pager', true);
				table.tablesorterPager({
					container: form.find('.imrep-table-pager'),
					size: options.num_rows_displayed
				});
			}
		});
		table.trigger('updateLoad');

		if (typeof(options.funcOnTableApplyWidgets) === 'function') {
			table.bind('applyWidgets', options.funcOnTableApplyWidgets);
		}
		//table.imFilter();
	} else {
		var sorting = table[0].config.sortList,
			numH = sorting[0][0],
			count = sorting[0][1]++ % 2
		;

		table.trigger('updateLoad');

		table.find('thead th:eq(' + numH + ')')[0].count = count;

		table.find('thead th:eq(' + numH + ')').trigger('click');

	}
}

function IMR_loadDataCSV(form) {
	form.append(
		'<input type="hidden" class="input-csv" name="IMReport[is_csv]" value="1" />'
	);

	form.submit();
}
