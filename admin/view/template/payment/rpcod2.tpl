<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  
  <?php if( !empty($error_warning) ) { ?>
  <?php foreach($error_warning as $error) { ?>
  <div class="warning"><?php echo $error; ?></div>
  <?php } ?>
  <?php } ?>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
		<a onclick="$('#stay_field').attr('value', '0'); $('#form').submit();" class="button"
		><span><?php echo $button_save_go; ?></span></a>
		<a onclick="$('#stay_field').attr('value', '1'); $('#form').submit();" class="button"
		><span><?php echo $button_save_stay; ?></span></a>
		<a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a>
		
	  </div>
    </div>
    <div class="content">

      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form"
	class="form-horizontal">
	<input type="hidden" name="stay" id="stay_field" value="1">
		
		<table class="form">
		<tr>
			<td>
				<?php echo $entry_status; ?>
			</td>
			<td>
			<select name="rpcod2_status" class="form-control" >
                <?php if ($rpcod2_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $entry_order_status; ?>
			</td>
			<td>
			<select name="rpcod2_order_status" class="form-control" >
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $rpcod2_order_status) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $entry_geo_zone; ?>
			</td>
			<td>
				<select name="rpcod2_geo_zone_id" class="form-control" >
                <option value="0"><?php echo $text_all_zones; ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $rpcod2_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
                <?php } ?>
				</select>
			</td>
		</tr>
		<?php if( !empty($rpcod2_order_filters) ) { ?>
		<tr>
			<td>
				<?php echo $entry_order_filters; ?>
			</td>
			<td> 
				<?php foreach($rpcod2_order_filters as $ft) { ?>
				<label for="filter_<?php echo $ft['filter_id']; ?>"
				><input type="checkbox" 
				name="rpcod2_order_filters[<?php echo $ft['filter_id']; ?>]"
				value="1"
				id="filter_<?php echo $ft['filter_id']; ?>"
				<?php if( $ft['status'] ) { ?> checked <?php } ?>
				>&nbsp;&nbsp;<?php echo $ft['filtername']; ?></label><br><br>
				<?php } ?> 
			</td>
		</tr>
		<?php } ?>
		<tr>
			<td>
				<?php echo $entry_sort_order; ?>
			</td>
			<td>
			  <input type="text"  class="form-control" name="rpcod2_sort_order" value="<?php echo $rpcod2_sort_order; ?>" size="1" />
			</td>
		</tr>
		</table>
		
    </form>
    </div>
  </div>
</div>
<?php echo $footer; ?> 