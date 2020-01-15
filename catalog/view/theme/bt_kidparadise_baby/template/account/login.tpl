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
<div id="content">
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php echo $content_top; ?>
  <h1><?php echo $heading_title; ?></h1>
  <div class="login-content">
	  <div class="row">
		<div class="col-lg-12 col-sm-12 col-xs-24">
		  <h2><?php echo $text_new_customer; ?></h2>
		  <div class="content">
			<p><b><?php echo $text_register; ?></b></p>
			<p><?php echo $text_register_account; ?></p>
			<a href="<?php echo $register; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
		</div>
		<div class="col-lg-12 col-sm-12 col-xs-24">
		  <h2><?php echo $text_returning_customer; ?></h2>
		  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
			<div class="content">
			  <p><?php echo $text_i_am_returning_customer; ?></p>
			  <b><?php echo $entry_email; ?></b><br />
			  <input class="form-control" type="text" name="email" value="<?php echo $email; ?>" />
			  
			 
			  <b><?php echo $entry_password; ?></b><br />
			  <input class="form-control" type="password" name="password" value="<?php echo $password; ?>" />
	
			  <input type="submit" value="<?php echo $button_login; ?>" class="btn btn-primary" /></br />
			   <a class="forgotten" href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a><br />
			  <?php if ($redirect) { ?>
			  <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
			  <?php } ?>
			</div>
		  </form>
		</div>
	  </div>
  </div>
  <?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
$('#login input').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#login').submit();
	}
});
//--></script> 
<?php echo $footer; ?>