<?php echo $header; ?>
<div class="col-xs-24 col-sm-24 col-md-24">
	<div    id="breadcrumb">	
	<?php $i = 1; $count = count($breadcrumbs);  ?>
	<b></b>
	<?php foreach ($breadcrumbs as $breadcrumb) { ?>
	<a class="<?php if($i==$count){echo 'breadcrumb_last';} else if($i==$count-1){echo 'breadcumb_middle';} else{echo 'breadcumb_first';} ?>" href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
	<?php $i++; } ?>
	</div>	
</div>
<?php echo $column_left; ?>	<?php echo $column_right; ?>

<div id="content"><?php echo $content_top; ?>
 <div class="voucher_fr boss_margin">
  <h1><?php echo $heading_title; ?></h1>
  <p><?php echo $text_description; ?></p>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <table class="form">
      <tr>
        <td><?php echo $entry_to_name; ?><span class="required">*</span> </td></tr>
        <tr><td><input type="text" name="to_name" value="<?php echo $to_name; ?>" />
          <?php if ($error_to_name) { ?>
          <span class="error"><?php echo $error_to_name; ?></span>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_to_email; ?><span class="required">*</span> </td></tr>
        <tr><td><input type="text" name="to_email" value="<?php echo $to_email; ?>" />
          <?php if ($error_to_email) { ?>
          <span class="error"><?php echo $error_to_email; ?></span>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_from_name; ?><span class="required">*</span> </td></tr>
        <tr><td><input type="text" name="from_name" value="<?php echo $from_name; ?>" />
          <?php if ($error_from_name) { ?>
          <span class="error"><?php echo $error_from_name; ?></span>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_from_email; ?><span class="required">*</span> </td></tr>
        <tr><td><input type="text" name="from_email" value="<?php echo $from_email; ?>" />
          <?php if ($error_from_email) { ?>
          <span class="error"><?php echo $error_from_email; ?></span>
          <?php } ?></td>
      </tr>
      <tr>
        <td class ="gift"><?php echo $entry_theme; ?><span class="required">*</span> </td></tr>
        <tr><td class="radio"><?php foreach ($voucher_themes as $voucher_theme) { ?>
          <?php if ($voucher_theme['voucher_theme_id'] == $voucher_theme_id) { ?>
          <input type="radio" name="voucher_theme_id" value="<?php echo $voucher_theme['voucher_theme_id']; ?>" id="voucher-<?php echo $voucher_theme['voucher_theme_id']; ?>" checked="checked" />
          <label for="voucher-<?php echo $voucher_theme['voucher_theme_id']; ?>"><?php echo $voucher_theme['name']; ?></label>
          <?php } else { ?>
          <input type="radio" name="voucher_theme_id" value="<?php echo $voucher_theme['voucher_theme_id']; ?>" id="voucher-<?php echo $voucher_theme['voucher_theme_id']; ?>" />
          <label for="voucher-<?php echo $voucher_theme['voucher_theme_id']; ?>"><?php echo $voucher_theme['name']; ?></label>
          <?php } ?>
          <br />
          <?php } ?>
          <?php if ($error_theme) { ?>
          <span class="error"><?php echo $error_theme; ?></span>
          <?php } ?></td>
      </tr>
      <tr>
        <td class="message"><?php echo $entry_message; ?></td></tr>
        <tr><td><textarea name="message" cols="40" rows="5"><?php echo $message; ?></textarea></td>
      </tr>
      <tr>
        <td><span class="required">*</span><?php echo $entry_amount; ?></td></tr>
        <tr><td><input type="text" name="amount" value="<?php echo $amount; ?>" size="5" />
          <?php if ($error_amount) { ?>
          <span class="error"><?php echo $error_amount; ?></span>
          <?php } ?></td>
      </tr>
    </table>
    <div class="buttons">
      <div class="left">
        <?php if ($agree) { ?>
        <input type="checkbox" name="agree" value="1" checked="checked" />
        <?php } else { ?>
        <input type="checkbox" name="agree" value="1" />
        <?php } ?><?php echo $text_agree; ?>
        </br></br></br><span class="button_fr_ip"><input type="submit" value="<?php echo $button_continue; ?>" class="btn btn-primary" /></span>
      </div>
    </div>
  </form>
  <?php echo $content_bottom; ?></div></div>
<?php echo $footer; ?>