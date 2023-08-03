function bb_select_pvz(url_base, bb_callback) {
    $('html, body').css("cursor", "wait");
    $('#bb-sel-dlg').remove();
    var dlg = $('<div id="bb-sel-dlg" style="background: white; width:100%; height:100%"><div id="left-pane" style="float: left; width: 24%; height: 100%;"><div style="display: block;width: 100%; height: 75px;"><img src="/image/delivery_bb/bb_logo.png"></div><div id="citylist" style="overflow: auto; height: calc(100% - 75px);"> </div></div><div id="yd_map" style="overflow: hidden;width:76%; height:100%"></div></div>');
    var window_w = $(window).width();
    var window_h = $(window).height();
    var h = Math.max(window_h * 3 / 5, 480) | 0;
    var w = Math.max(window_w * 3 / 5, 640) | 0;
    var ydMap;

    dlg.dialog({
        title: 'Выбор ПВЗ Boxberry',
        autoOpen: false,
        resize: function(event, ui) { 
		if (ydMap !== undefined) 
			ydMap.container.fitToViewport(); 
	},
        height: h,
        width: w,
        modal: false
    }).bind('dialogclose', function(event) {
        $("#shipping-method .checkout-content").slideDown("slow");
    }).bind('dialogopen', function(event) {
        $("#shipping-method .checkout-content").slideUp("slow");
    });
    ymaps.ready(init);

    function init() {
        ydMap = new ymaps.Map("yd_map", {
            center: [55.76, 37.64],
            controls: ['zoomControl', 'searchControl', 'trafficControl'],
            zoom: 8
        });
        BalloonContentLayout = ymaps.templateLayoutFactory.createClass('<div style="line-height: 170%; margin: 10px;">' + '<h4>{{properties.pvz_name}}</h4>' + 'Срок доставки (дней): {{properties.period}}<br />[if properties.cod]<span style="color: #808080">Только предоплаченные заказы</span><br />[else][endif]' + '{{properties.pvz_addr}}<br />' + '{{properties.phone}}<br />' + '{{properties.work}}<br /><br />' + '<button id="counter-button" data-pvz-id="{{properties.pvz_id}}"> Выбрать </button>' + '</div>', {
            build: function() {
                BalloonContentLayout.superclass.build.call(this);
                $('#counter-button').bind('click', this.onCounterClick);
            },
            clear: function() {
                $('#counter-button').unbind('click', this.onCounterClick);
                BalloonContentLayout.superclass.clear.call(this);
            },
            onCounterClick: function() {
		var id = $('#counter-button').attr('data-pvz-id');
                $('#bb-sel-dlg').dialog('close');
                ydMap.destroy();
		$('input[value="bb.pickup"]').prop('checked', true);
                bb_callback(id);
            }
        });
        objectManager = new ymaps.ObjectManager({
            clusterize: true,
            clusterHasBalloon: true
        });
        objectManager.clusters.options.set('preset', 'islands#redClusterIcons');

        objectManager.objects.options.set({
            balloonContentLayout: BalloonContentLayout,
	    preset: 'islands#redIcon'
        });
        ydMap.geoObjects.add(objectManager);
        $.ajax({
            url: url_base,
            dataType: 'json'
        }).done(function(data) {
            $("#citylist").html(data.cities);
            objectManager.add(data.om);
            var loc = data.position.location.split(',');
            ydMap.setCenter(loc, data.position.zoom);
            dlg.dialog("open");
            $('html, body').css("cursor", "auto");
            $(".select-city-anchor").on("click", function(event) {
                event.preventDefault();
                var point = $(this).data().gps.split(',');
                ydMap.setCenter(point, 10);
            });
        });
    };
}