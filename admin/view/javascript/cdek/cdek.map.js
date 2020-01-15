function showMap(element){

	var self = element;
	var tariff_id = $(self).data('id');

	var input = $('input[name=shipping_method][value^=\'cdek.pvz_' + tariff_id + '\']');

	if (!input.length) {
		return false;
	}

	$('input[name=shipping_method]').attr('checked', '').removeAttr('checked');

	$(input).prop('checked', 'checked');

	$.ajax({
		url: '/index.php?route=shipping/cdek/map',
		data: 'tariff_id=' + tariff_id + '&city_id=' + $(self).data('city') + '&active=' + encodeURIComponent($(self).data('active')),
		dataType: 'html',
		complete: function() {
			$('body').data('cdek_binding')
		},
		success: function(json) {

			$('#modal-cdek-map').remove();

			html  = '<div id="modal-cdek-map">';
			html += '	<div class="modal-header">';
			html += '		<div class="modal-title">Выберите адрес</div>';
			html += '	</div>';
			html += '	<div class="modal-body">';
			html += json;
			html += '	</div>';
			html += '</div> ';

			$.colorbox({
				overlayClose: true,
				opacity: 0.5,
				width: '800px',
				href: false,
				html: html,
				onComplete: function(){

					if (markers && markers.length > 0) {

						$('.cdek-map-container .pvz-list').btsListFilter('.cdek-pvz-search', {
							initial: false,
							resetOnBlur: false,
							cancelNode: function() {
								return '<span class="form-control-feedback" aria-hidden="true">˟</span>';
							},
							emptyNode: function(data) {
								return '<span class="list-group-item first last">Нет совпадений</span>';
							}
						});

						renderMap({
							mapContainer: 'cdek-map',
							lat: markers[0].center[0],
							lng: markers[0].center[1],
							markers: markers,
							input: input,
							zoom: 10
						});

					}

				}
			});



		}
	});

};

function renderMap(options) {

	ymaps.ready(function() {

		var map = new ymaps.Map(options.mapContainer, {
			center: [options.lat, options.lng],
			zoom: options.zoom,
			controls: ['zoomControl', 'typeSelector']
		});

		LayoutWrapper = ymaps.templateLayoutFactory.createClass(
			'<div class="cdek-placemark">' +
				'<div class="popover top">' +
					'<div class="map-info">' +
						'<a class="close" href="#">˟</a>' +
						'<div class="arrow"></div>' +
						'$[[options.contentLayout observeSize minWidth=270 maxWidth=370 maxHeight=720]]' +
					'</div>' +
				'</div>' +
			'</div>',
			{
				build: function() {
					LayoutWrapper.superclass.build.call(this);
					this._$element = $('.map-info', this.getParentElement());
					this.setOffset();
					this._$element.find('.close').on('click', $.proxy(this.close, this));
					this._$element.find('.btn').on('click', $.proxy(this.select, this));
				},
				clear: function() {
					LayoutWrapper.superclass.clear.call(this);
				},
				onSublayoutSizeChange: function() {
					LayoutWrapper.superclass.onSublayoutSizeChange.apply(this, arguments);
					if (!this._isElement(this._$element)) {
						return;
					}
					this.setOffset();
					this.events.fire('shapechange');
				},
				setOffset: function () {
					this._$element.css({
						left: -42,
						top: -($(this._$element).outerHeight() + 10)
					});
				},
				close: function(e) {
					e.preventDefault();
					this.events.fire('userclose');
				},
				select: function(e) {

					e.preventDefault();

					var info = this._data.properties;

					var code = info.get('code'),
						tariff_id = info.get('tariff_id');

					var link = $('.cdek-container a[data-id=' + tariff_id + ']');

					if (code != link.data('active')) {

						var data = {
							code: code,
							tariff_id: tariff_id,
							old_key: options.input.val()
						};

						var html = '<strong>Адрес</strong>: ' + info.get('address');
						html += '<br />';

						if (info.get('phone') != '') {
							html += '<strong>Телефон</strong>: ' + info.get('phone') + '<br />';
						}

						if (info.get('work_time') != '') {
							html += '<strong>Режим работы</strong>: ' + info.get('work_time');
						}

						link.data('active', code);

						$('.cdek-pvz-info', link.parent()).html(html);

						$.getJSON("/index.php?route=shipping/cdek", data, function (json) {

							if (json.status == 'ok') {

								var parts = data.old_key.split('.');
								var code_parts = parts[1].split('_');

								if (2 < code_parts.length) {
									$(options.input).attr('value', 'cdek.pvz_' + tariff_id + '_' + code);
								}

								$(options.input).trigger('change');

							}

							$('body').data('cdek_binding', 0);

						});

					}

					this.events.fire('userclose');

					$.colorbox.close();
				},
				_isElement: function(element) {
					return element && element[0] && element.find('.arrow')[0];
				},
				getShape: function() {

					if (!this._isElement(this._$element)) {
						return LayoutWrapper.superclass.getShape.call(this);
					}
					var position = this._$element.position();

					return new ymaps.shape.Rectangle(new ymaps.geometry.pixel.Rectangle([
						[position.left, position.top],
						[position.left + this._$element[0].offsetWidth, position.top + this._$element[0].offsetHeight + this._$element.find('.arrow')[0].offsetHeight]
					]));
				},
			}
		);

		var balloon = ymaps.templateLayoutFactory.createClass(
			'<div class="map-info--body">' +
				'<div class="map-info--body__row">' +
					'<span class="map-info--body__label">Адрес</span>: <span class="map-info--body__value">$[properties.address]</span>' +
				'</div>' +
				'{% if properties.phone %}<div class="map-info--body__row">' +
					'<span class="map-info--body__label">Телефон</span>: <span class="map-info--body__value">{{properties.phone}}</span>' +
				'</div>{% endif %}' +
				'<div class="map-info--body__row">' +
					'<span class="map-info--body__label">Режим работы</span>: <span class="map-info--body__value">{{properties.work_time}}</span>' +
				'</div>' +
			'</div>' +
			'<div class="map-info--footer">' +
				'<a class="btn">Выбрать</a>' +
			'</div>'
		);

		var clusterer = new ymaps.Clusterer({
			preset: 'islands#darkGreenClusterIcons',
		});

		var geoObjects = [];

		options.markers.forEach(function(item, i, array) {

			var coords = item.center;

			var placemark = new ymaps.GeoObject({
				geometry: {
					type: "Point",
					coordinates: [coords[0], coords[1]]
				},
				properties: {
					code: item.code,
					name: item.name,
					address: item.address,
					phone: item.phone,
					work_time: item.work_time,
					tariff_id: item.tariff_id,
					hintContent: item.address
				}
			}, {
				balloonLayout: LayoutWrapper,
				balloonContentLayout: balloon,
				balloonPanelMaxMapArea: 0,
				iconColor: '#3caa3c'
			});

			$('.pvz-list a[data-code=' + item.code + ']').click(function(event){

				event.preventDefault();

				showPlacemark(map, placemark);

				setActiveItem(item.code)
			})

			geoObjects[i] = placemark;
		});

		clusterer.add(geoObjects);
		map.geoObjects.add(clusterer);

		$('.pvz-list a[data-code=all]').click(function(event){

			event.preventDefault();

			for (var i in geoObjects) {
				geoObjects[i].balloon.close();
			}

			window.centerMap();

			setActiveItem('all');

			$('.cdek-pvz-search').prop('value', '').trigger('keyup');
		});

		$('body').on('change', 'select[name=list_pvz_mobile]', function(event){

			event.preventDefault();

			var code = $(this).val();

			for (var i in geoObjects) {

				if (geoObjects[i].properties.get('code') == code) {

					showPlacemark(map, geoObjects[i]);

					break;
				}

			}

		});

		window.centerMap = function() {
			map.setBounds(clusterer.getBounds(), {
				checkZoomRange: true,
				zoomMargin: 15
			});
		}

		window.centerMap();
	});

	function setActiveItem(code)
	{
		$('.pvz-list a').removeClass('active');
		$('.pvz-list a[data-code=' + code + ']').addClass('active');
	}

	function showPlacemark(map, placemark)
	{
		map.setCenter(placemark.geometry.getCoordinates());
		map.setZoom(16);

		placemark.balloon.open();
	}
}