<div id="br-progress-dialog">
	<span id="br-progressbar"><img src="./view/image/anyPort/ajax-loader.gif" class="loadingImage"/></span>
    <span id="br-progressinfo"></span><br /><br />
    <button class="br-finishActionButton" style="display: none;">Abort</button>
</div>
<script type="text/javascript">
var br_XHR = null;
var br_loopXHR = null;
var br_updateTimeout = null;
var br_abort = false;

var br_progress = function(data, okay) {
	if (okay) {
		var message = '';
		if (data.done && typeof(data.file) != 'undefined') {
			message = 'Backup is complete. <a target="_blank" href="' + data.file + '">DOWNLOAD</a>';
			$('.br-finishActionButton').html('Finish');
			$('#br-progressbar').hide();
		} else if (data.done) {
			message = data.message;
			$('.br-finishActionButton').html('Finish');
			$('#br-progressbar').hide();
		} else if (data.error) {
			message = data.message;
			$('.br-finishActionButton').html('Finish');
			$('#br-progressbar').hide();
		} else {
			message = data.message;
		}
		$("#br-progressinfo").html(message);
	} else {
		$("#br-progressinfo").html(data.message);
		$('#br-progressbar').hide();
	}
}

var initDialog = function () {
	$( "#br-progress-dialog" ).dialog({
		autoOpen: false,
		width: 680,
		show: "fade",
		modal: true,
		resizable: false,
		closeOnEscape: false,
		open: function(event, ui) { $(".ui-dialog-titlebar").hide(); }
	});
	$('#br-progressbar').show();
};

var closeDialog = function() {
	$( "#br-progress-dialog" ).dialog('close');
	$( "#br-progress-dialog" ).dialog('destroy');
	$('#br-progressinfo').empty();
	$('.br-finishActionButton').removeAttr('disabled').hide();
	initDialog();
}

initDialog();

var begin_br_ProgressUpdate = function() {
	if (br_abort) return;
	loopXHR = $.ajax({
		url: '../temp/anyport_progress.txt',
		type: 'GET',
		timeout: null,
		dataType: 'json',
		cache: false,
		statusCode: {
			404: function(){
				br_updateTimeout = setTimeout(function (){
					begin_br_ProgressUpdate();
				}, 1000);
			}
		},
		success: function(returnData, textStatus, jqXHR) {
			if ($( "#br-progress-dialog" ).dialog('isOpen')) {
				if (returnData != null && returnData.error == false && returnData.done == false) {
					br_progress(returnData, true);
					br_updateTimeout = setTimeout(function (){
						begin_br_ProgressUpdate();
					}, 1000);
				} else if (returnData.error != false) {
					br_progress(returnData, true);
					return;
				} else return;
			} else {
				clearTimeout(br_updateTimeout);
			}
		}
	});
}

var begin_br_AJAX = function(url) {
	br_XHR = $.ajax({
		url: url,
		async: true,
		type: 'GET',
		timeout: null,
		dataType: 'json',
		cache: false,
		statusCode: {
			500: function(){
				br_progress('Server error 500 has occured.', false);
			}
		},
		beforeSend: function() {
			if (!$( "#br-progress-dialog" ).dialog('isOpen')) {
				$( "#br-progress-dialog" ).dialog( "open" );
				$('.loadingImage').show();	
				$('.br-finishActionButton').show();
			}
			br_abort = false;
			begin_br_ProgressUpdate();
		},
		success: function(data, textStatus, jqXHR) {
			br_progress(data, true);
		},
		error: function(jqXHR, textStatus, errorThrown) {
			
		},
		complete: function() {
			br_abort = true;
			$.ajax({
				url: '<?php echo $this->url->link('module/anyport/clearprogress&token='.$this->request->get['token'], '', 'SSL'); ?>',
				type: 'GET'
			});
		}
	});
}

$('.AnyPortSubmitButton').click(function(e) {
	var action = $(this).attr('data-action');
	$('#form').attr('action',$('#form').attr('action').replace(/&submitAction=.*($|&)/g, ''));
	if (action != undefined && action != '') {
		$('#form').attr('action',$('#form').attr('action')+'&submitAction='+action);
	}
	$('#form').submit();
});

<?php if (!empty($this->session->data['startajax']) && !$hadFailure) : ?>
begin_br_AJAX('<?php echo $this->url->link('module/anyport/ajaxrequest&token='.$this->request->get['token'].'&submitAction='.$this->session->data['request_get']['submitAction'], '', 'SSL'); unset($this->session->data['startajax']); ?>');
<?php endif; ?>

$('.br-finishActionButton').click(function() {
	br_abort = true;
	br_XHR.abort();
	clearTimeout(br_updateTimeout);
	$(this).attr('disabled', 'disabled');
    $('#br-progressinfo').html('Aborting... Please wait...');
	closeDialog();
});
</script>