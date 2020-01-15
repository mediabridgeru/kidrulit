<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
<?php if ($errors) { ?>
<?php foreach($errors as $err) { ?>
<div class="warning"><?php echo $err; ?></div>
<?php } ?>
<?php } ?>
<?php if( $success ) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>

  <div class="box">
    <div class="heading">
      <h1><img src="view/image/shipping.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
	  
		<a onclick="$('#form').submit();" class="button"
		><span><?php echo $button_setlicense; ?></span></a>
	  <a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a
	  ></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><?php echo $entry_license; ?></td>
            <td><input type="text" name="code" value="" style="width: 300px;">
				<div><?php echo $entry_license_notice; ?></div></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?> 