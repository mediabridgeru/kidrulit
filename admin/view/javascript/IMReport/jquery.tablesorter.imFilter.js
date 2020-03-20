/*
    @author: Igor Mirochnik
    @copyright:  Igor Mirochnik
    Site: http://ida-freewares.ru
    Site: http://im-cloud.ru
    Email: dev.imirochnik@gmail.com
    Type: commercial
*/

(function($){
	$.fn.imFilter = function () {

		var table = $(this)
		;

		var config = { rowsCopy:[], totalRows: 0 };
		var actConfig = $(this).data('tablesorter');

		if (!actConfig.rowsCopyActual) {
			actConfig.rowsCopyActual = [];
			for(var cnt = 0; cnt < config.totalRows; cnt++) {
				actConfig.rowsCopyActual.push(actConfig.rowsCopy[cnt].clone());
			}
			$(this).data('tablesorter', actConfig);
		}

		actConfig.totalRows = actConfig.rowsCopyActual.length;
		config.totalRows = actConfig.totalRows;
		for(var cnt = 0; cnt < config.totalRows; cnt++) {
			config.rowsCopy.push(actConfig.rowsCopyActual[cnt].clone());
		}

		table[0].config.rowsCopyCurrent = config.rowsCopy;

		// событие для элемента ввода
		table.closest('form').find('input.imrep-table-filter').unbind().keyup(function() {

			// Получаем значение фильтра
			var filter = $(this).val().toLowerCase();

			var currentConfig = table[0].config,
				rows = config.rowsCopy,
				totalRows = config.totalRows,
				actTotalRows = 0,
				actRows = []
			;

			delete currentConfig.rowsCopy;

			for(var cnt = 0; cnt < totalRows; cnt++)
			{
				var regE = new RegExp(/<[^>]+>/g),
					regEFirstCell = new RegExp(/^<td[^>]+>[^<]<\/td>/g),
					regEgt = new RegExp(/&gt;/g),
					regEDSpace = new RegExp(/\s{2,}/g),
					checkVal
						= rows[cnt].html()
							.replace(regEFirstCell,' ')
							.replace(regE,' ')
							.replace(regEgt,' > ')
							.replace(regEDSpace,' ')
				;
				if ($.trim(filter) == ''
					|| checkVal.toLowerCase().indexOf(filter) >= 0)
				{
					actRows.push(rows[cnt]);
					actTotalRows++;
				}
			}

			currentConfig.rowsCopy = actRows;
			currentConfig.totalRows = actTotalRows;
			currentConfig.page = 0;
			currentConfig.size = currentConfig.size ? currentConfig.size : 10;
			currentConfig.totalPages = Math.ceil(currentConfig.totalRows / currentConfig.size);

			table.trigger('updateCache');

			if (actTotalRows == 0) {
				renderTable(table[0], currentConfig.rowsCopy);
			}

			//$(this).data('tablesorter', currentConfig);
		});

		table.closest('form').find('input.imrep-table-filter').trigger('keyup');

		function renderTable(table, rows) {

			var c = table.config;
			var l = rows.length;
			var s = (c.page * c.size);
			var e = (s + c.size);
			if(e > rows.length ) {
				e = rows.length;
			}


			var tableBody = $(table.tBodies[0]);

			// clear the table body

			$.tablesorter.clearTableBody(table);

			for(var i = s; i < e; i++) {

				//tableBody.append(rows[i]);

				var o = rows[i];
				var l = o.length;
				for(var j=0; j < l; j++) {

					tableBody[0].appendChild(o[j]);

				}
			}

			$(table).trigger("applyWidgets");

			updatePageDisplay(table, c);
		}

		function updatePageDisplay(c) {
			var s = $(c.cssPageDisplay,c.container).val((c.page+1) + c.seperator + c.totalPages);
		}
	}

})(jQuery);
