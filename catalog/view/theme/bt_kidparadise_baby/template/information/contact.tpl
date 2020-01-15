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
<div>
<div id="content"><?php echo $content_top; ?>
  <h1><?php echo $heading_title; ?></h1>
  
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
    <h2><?php echo $text_location; ?></h2>
    <div class="contact-info">
      <div class="content"><div class="left"><b><?php echo $text_address; ?></b><br />
        <?php echo $store; ?><br />
        <?php echo $address; ?></div>
      <div class="right">
        <?php if ($telephone) { ?>
        <b><?php echo $text_telephone; ?></b><br />
        <?php echo $telephone; ?><br />
        <br />
        <?php } ?>
        <?php if ($fax) { ?>
        <b><?php echo $text_fax; ?></b><br />
        <?php echo $fax; ?>
        <?php } ?>
      </div>
    </div>
    </div>
    <h2><?php echo $text_contact; ?></h2>
    <div class="content">
		<b><?php echo $entry_name; ?></b><br />
		<input type="text" name="name" value="<?php echo $name; ?>" />
		<br />
		<?php if ($error_name) { ?>
		<span class="error"><?php echo $error_name; ?></span>
		<?php } ?>
		<br />
		<b><?php echo $entry_email; ?></b><br />
		<input type="text" name="email" value="<?php echo $email; ?>" />
		<br />
		<?php if ($error_email) { ?>
		<span class="error"><?php echo $error_email; ?></span>
		<?php } ?>
		<br />
		<b><?php echo $entry_enquiry; ?></b><br />
		<textarea name="enquiry" cols="40" rows="10" ><?php echo $enquiry; ?></textarea>

		<?php if ($error_enquiry) { ?>
		<span class="error"><?php echo $error_enquiry; ?></span>
		<?php } ?>
		<br />
		<?php /*
		<b><?php echo $entry_captcha; ?></b><br />
		<input type="text" name="captcha" value="<?php echo $captcha; ?>" />
		<br />
		<img src="index.php?route=information/contact/captcha" alt="" />
		*/?>
		<?php if ($error_captcha) { ?>
		<span class="error"><?php echo $error_captcha; ?></span>
		<?php } ?>
	
    </div>    
	<div style="width:60%;">        
	<input type="checkbox" id="acceptance" name="acceptance" 
	<?php if(isset($acceptance)) echo "checked"; ?>>        
	<label for="acceptance">Даю согласие на обработку персональных данных</label>
	<br>        
	<small>Ставя отметку, я даю свое согласие на обработку моих персональных данных в соответствии с законом №152-ФЗ «О персональных данных» от 27.07.2006 и принимаю условия <a href="<?php echo $oferta; ?>" style="color: #e85e5e;">Пользовательского соглашения&#8203;&#8203;</a></small>
    </div>    
	
	<script>    
	function onFormSubmit() {
		$('#form')[0].submit();
	}
	
	$(document).ready(function() {
        $('#form').on('submit', function(e) {
			e.preventDefault();
            if(!$("#acceptance")[0].checked) {
				alert('Необходимо согласиться с условиями пользовательского соглашения!')            
			} else {
				grecaptcha.execute();
			}			
		});    
	});    
	</script>
    <div class="buttons">
      <div class="left">
	  <div class="g-recaptcha" data-size='invisible' data-sitekey="6Lf_34kUAAAAAO4lhpAv1AXAc0dF54jXuh99OL6e" data-callback="onFormSubmit"></div>
	  
	  <input type="submit" value="<?php echo $button_continue; ?>" class="btn btn-primary" >


	  </div>
    </div>
  </form>
  <?php echo $content_bottom; ?></div></div>
<?php echo $footer; ?>