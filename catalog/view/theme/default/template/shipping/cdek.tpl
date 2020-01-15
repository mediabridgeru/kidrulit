<style type="text/css">
	#modal-cdek-map {
		font-family: 'Open Sans', sans-serif;
		max-width: 800px;
	}
	#modal-cdek-map .modal-header {
		min-height: 16px;
		padding: 15px;
		border-bottom: 1px solid #e5e5e5;
	}
	#modal-cdek-map .modal-header .modal-title {
		line-height: 1.42857143;
		font-size: 15px;
		color: #444;
		font-weight: 500;
	}
	#modal-cdek-map .modal-body {
		position: relative;
		padding: 15px;
	}
	#modal-cdek-map .cdek-placemark {
		color: #666;
	}
	#modal-cdek-map .cdek-placemark .title {
		font-size: 14px;
		font-weight: 500;
		margin-bottom: 10px;
	}
	#modal-cdek-map .cdek-placemark .popover {
		display: block;
	}
	#modal-cdek-map .cdek-placemark .close {
		position: absolute;
		right: 20px;
		top: 14px;
		font-size: 31px;
		height: 26px;
		text-decoration: none;
		z-index: 999;
		color: #888888;
	}
	#modal-cdek-map .cdek-placemark .map-info {
		position: absolute;
		box-shadow: 0 5px 15px rgba(0,0,0,.5);
		-webkit-box-shadow: 0 5px 15px rgba(0,0,0,.5);
		border-radius: 6px;
		outline: 0;
		background-color: #fff;
		-webkit-background-clip: padding-box;
	}
	#modal-cdek-map .cdek-placemark .map-info:after {
		content: "";
		position: absolute;
		bottom: -17px;
		left: 28px;
		width: 0;
		height: 0;
		border-left: 12px solid transparent;
		border-right: 12px solid transparent;
		border-top: 18px solid #fff;
	}
	#modal-cdek-map .map-info--body {
		position: relative;
		padding: 20px 35px 15px 15px;
		font-size: 11px;
	}
	#modal-cdek-map .map-info--body__row {
		margin-bottom: 2px;
	}
	#modal-cdek-map .map-info--body__label {
		font-weight: bold;
	}
	#modal-cdek-map .map-info--footer {
		padding: 15px;
		border-top: 1px solid #e5e5e5;
	}
	#modal-cdek-map .map-info--footer .btn {
		display: inline-block;
		padding: 6px 12px;
		margin-bottom: 0;
		font-size: 14px;
		font-weight: 400;
		line-height: 1.42857143;
		text-align: center;
		white-space: nowrap;
		vertical-align: middle;
		-ms-touch-action: manipulation;
		touch-action: manipulation;
		cursor: pointer;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
		border: 1px solid;
		border-radius: 4px;
		color: #ffffff;
		text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
		background-color: #229ac8;
		background-image: linear-gradient(to bottom, #23a1d1, #1f90bb);
		background-repeat: repeat-x;
		border-color: #1f90bb #1f90bb #145e7a;
		text-decoration: none;
	}
	#modal-cdek-map .map-info--footer .btn:active:focus,
	#modal-cdek-map .map-info--footer .btn:active:hover {
		color: #fff;
		background-color: #204d74;
		border-color: #122b40;
	}
	#modal-cdek-map .map-info--footer .btn:active:focus,
	#modal-cdek-map .map-info--footer .btn:focus {
		outline: thin dotted;
		outline: 5px auto -webkit-focus-ring-color;
		outline-offset: -2px;
	}
	#modal-cdek-map .map-info--footer .btn:hover,
	#modal-cdek-map .map-info--footer .btn:active {
		background-color: #1f90bb;
		background-position: 0 -15px;
	}
	#modal-cdek-map .map-info--footer .btn:active {
		background-image: none;
	}
	#modal-cdek-map .cdek-map-container {
		max-width: 800px;
		margin-bottom: 0;
	}
	#modal-cdek-map .cdek-map-container .col-md-8 {
		height: 100%;
	}
	#modal-cdek-map .list-group a {
		color: #888888;
		text-decoration: none;
	}
	#modal-cdek-map .list-group a.active,
	#modal-cdek-map .list-group a.active:hover,
	#modal-cdek-map .list-group a:hover {
		color: #444444;
		background: #eeeeee;
		border: 1px solid #DDDDDD;
		text-shadow: 0 1px 0 #FFF;
	}
	#modal-cdek-map .list-group .list-group-item {
		width: 100% !important;
		position: relative;
		display: block;
		padding: 10px 15px;
		margin-bottom: -1px;
		background-color: #fff;
		border: 1px solid #ddd;
	}
	#modal-cdek-map .list-group .list-group-item:first-child {
		border-top-left-radius: 4px;
		border-top-right-radius: 4px;
	}
	#modal-cdek-map .list-group .list-group-item:last-child {
		margin-bottom: 0;
		border-bottom-right-radius: 4px;
		border-bottom-left-radius: 4px;
	}

	#modal-cdek-map .list-group a:focus {
		color: #555;
		text-decoration: none;
		background-color: #f5f5f5;
	}
	#modal-cdek-map .list-group .list-group-item.selected {
		font-weight: bold;
	}
	#modal-cdek-map .list-group .list-group-item.first {
		border-top-left-radius: 4px;
		border-top-right-radius: 4px;
	}
	#modal-cdek-map .list-group .list-group-item.last {
		margin-bottom: 0;
		border-bottom-right-radius: 4px;
		border-bottom-left-radius: 4px;
	}
	#modal-cdek-map .list-group .list-group-item span {
		display: none;
	}
	#modal-cdek-map .cdek-map-container .row {
		height: 500px;
		margin-right: -15px;
		margin-left: -15px;
	}
	#modal-cdek-map .cdek-map-container  .row:before {
		display: table;
		content: " ";
	}
	#cdek-map {
		width:100%;
		height:100%;
	}
	.cdek-map-container .pvz-list {
		padding-right: 0;
	}
	#modal-cdek-map .cdek-map-container .pvz-list .js-link {
		margin-left: 10px;
	}
	#modal-cdek-map .cdek-map-container .pvz-list .list-group {
		max-height: 415px;
		overflow-y: auto;
		padding-left: 0;
		margin-bottom: 20px;
	}
	#modal-cdek-map .col-md-4,
	#modal-cdek-map .col-md-8 {
		position: relative;
		min-height: 1px;
		padding-right: 15px;
		padding-left: 15px;
		float: left;
	}
	#modal-cdek-map .col-md-4 {
		width: 33.33333333%;
		padding-right: 0px;
	}
	#modal-cdek-map .col-md-8 {
		width: 66.66666667%;
	}
	#modal-cdek-map :after, :before {
		-webkit-box-sizing: border-box;
		box-sizing: border-box;
	}
	#modal-cdek-map .has-feedback {
		position: relative;
	}
	#modal-cdek-map .form-control {
		display: block;
		width: 100%;
		height: 34px;
		padding: 6px 12px;
		font-size: 14px;
		line-height: 1.42857143;
		color: #555;
		background-color: #fff;
		background-image: none;
		border: 1px solid #ccc;
		border-radius: 4px;
		-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
		box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
		-webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
		-o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
		transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
		margin: 0;
	}
	#modal-cdek-map .form-group {
		margin-bottom: 15px;
	}
	#modal-cdek-map input[type=search] {
		-webkit-appearance: none !important;
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		box-sizing: border-box;
	}
	#modal-cdek-map input[type="search"]::-webkit-search-decoration,
	#modal-cdek-map input[type="search"]::-webkit-search-cancel-button,
	#modal-cdek-map input[type="search"]::-webkit-search-results-button,
	#modal-cdek-map input[type="search"]::-webkit-search-results-decoration {
		display: none;
	}
	#modal-cdek-map input[type="search"].form-control {
		font-size: 12px;
	}
	#modal-cdek-map .form-control-feedback {
		color: #888888;
		cursor: pointer;
		font-style: normal;
		font-weight: 400;
		-webkit-font-smoothing: antialiased;
		-moz-osx-font-smoothing: grayscale;
		font-size: 31px;
		text-decoration: none;
		position: absolute;
		top: 0;
		right: 0;
		z-index: 2;
		display: block;
		width: 34px;
		height: 34px;
		line-height: 34px;
		text-align: center;
		pointer-events: none;
	}
</style>
<div class="cdek-map-container">
	<div class="row">
		<div class="col-md-4 pvz-list">
			<div class="cdek-search">
				<div class="form-group">
					<input type="search" class="cdek-pvz-search form-control" value="" placeholder="Введите адрес..." />
				</div>
			</div>
			<a href="#" data-code="all" class="js-link">Все адреса</a>
			<div class="list-types">
				<div class="list-group">
					<?php foreach ($pvz_list as $pvz_item) { ?>
					<a href="#" data-code="<?php echo $pvz_item['code']; ?>" class="<?php if ($active == $pvz_item['code']) echo 'selected '; ?>list-group-item"><?php echo $pvz_item['name']; ?><span><?php echo $pvz_item['address']; ?></span></a>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div id="cdek-map"></div>
		</div>
	</div>
</div>
<script type="text/javascript">

	var markers = [];

	<?php foreach ($pvz_list as $pvz_item) { ?>
		markers.push({
			center: [<?php echo $pvz_item['y']; ?>, <?php echo $pvz_item['x']; ?>],
			name: '<?php echo $pvz_item['name']; ?>',
			address: '<?php echo $pvz_item['address']; ?>',
			code: '<?php echo $pvz_item['code']; ?>',
			active: <?php echo (int)($pvz_item['code'] == $active); ?>,
			phone: '<?php echo $pvz_item['phone']; ?>',
			work_time: '<?php echo $pvz_item['work_time']; ?>',
			tariff_id: <?php echo $tariff_id; ?>
		});
	<?php } ?>
</script>