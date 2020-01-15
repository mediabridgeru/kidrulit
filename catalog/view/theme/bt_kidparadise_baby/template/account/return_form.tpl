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
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="return_form_fr boss_margin">
  <h1><?php echo $heading_title; ?></h1>
  <?php echo $text_description; ?>
  <form class="return-form" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
    <h2><?php echo $text_order; ?></h2>
    <div class="content">
      <div class="left six columns alpha">
		<span class="tt_input"><?php echo $entry_firstname; ?></span><span class="required">*</span> <br />
        <input type="text" name="firstname" value="<?php echo $firstname; ?>" class="large-field" />
        
        <?php if ($error_firstname) { ?>
        <span class="error"><?php echo $error_firstname; ?></span>
        <?php } ?>
        <br />
        <span class="tt_input"><?php echo $entry_lastname; ?></span><span class="required">*</span> <br />
        <input type="text" name="lastname" value="<?php echo $lastname; ?>" class="large-field" />
        
        <?php if ($error_lastname) { ?>
        <span class="error"><?php echo $error_lastname; ?></span>
        <?php } ?>
        <br />
        <span class="tt_input"><?php echo $entry_email; ?></span><span class="required">*</span> <br />
        <input type="text" name="email" value="<?php echo $email; ?>" class="large-field" />
       
        <?php if ($error_email) { ?>
        <span class="error"><?php echo $error_email; ?></span>
        <?php } ?>
        <br />
        <span class="tt_input"><?php echo $entry_telephone; ?></span><span class="required">*</span> <br />
        <input type="text" name="telephone" value="<?php echo $telephone; ?>" class="large-field" />
       <br/>
        <?php if ($error_telephone) { ?>
        <span class="error"><?php echo $error_telephone; ?></span>
        <?php } ?>
        <br />
      </div>
      <div class="right six columns omega">
		<span class="tt_input"><?php echo $entry_order_id; ?></span><span class="required">*</span> <br />
        <input type="text" name="order_id" value="<?php echo $order_id; ?>" class="large-field" />
        
        <?php if ($error_order_id) { ?>
        <span class="error"><?php echo $error_order_id; ?></span>
        <?php } ?>
        <br />
        <span class="tt_input"><?php echo $entry_date_ordered; ?></span><br />
        <input type="text" name="date_ordered" value="<?php echo $date_ordered; ?>" class="large-field date" />
       
      </div>
    </div>
    <h2><?php echo $text_product; ?></h2>
    <div id="return-product">
      <div class="content">
        <div class="return-product">
          <div class="return-name four columns alpha">
			<span class="tt_input"><?php echo $entry_product; ?></span><span class="required">*</span> <br />
            <input type="text" name="product" value="<?php echo $product; ?>" />
            <br />
            <?php if ($error_product) { ?>
            <span class="error"><?php echo $error_product; ?></span>
            <?php } ?>
          </div>
          <div class="return-model four columns">
			<span class="tt_input"><?php echo $entry_model; ?></span><span class="required">*</span> <br />
            <input type="text" name="model" value="<?php echo $model; ?>" />
            <br />
            <?php if ($error_model) { ?>
            <span class="error"><?php echo $error_model; ?></span>
            <?php } ?>
          </div>
          <div class="return-quantity four columns omega">
			<span class="tt_input"><?php echo $entry_quantity; ?></span><br />
            <input type="text" name="quantity" value="<?php echo $quantity; ?>" />
          </div>
        </div>
        <div class="return-detail">
          <div class="return-reason four columns alpha">
			<h2><?php echo $entry_reason; ?><span class="required">*</span></h2>
            <table>
              <?php foreach ($return_reasons as $return_reason) { ?>
              <?php if ($return_reason['return_reason_id'] == $return_reason_id) { ?>
              <tr>
                <td width="1"><input type="radio" name="return_reason_id" value="<?php echo $return_reason['return_reason_id']; ?>" id="return-reason-id<?php echo $return_reason['return_reason_id']; ?>" checked="checked" /></td>
                <td><label for="return-reason-id<?php echo $return_reason['return_reason_id']; ?>"><?php echo $return_reason['name']; ?></label></td>
              </tr>
              <?php } else { ?>
              <tr>
                <td width="1"><input type="radio" name="return_reason_id" value="<?php echo $return_reason['return_reason_id']; ?>" id="return-reason-id<?php echo $return_reason['return_reason_id']; ?>" /></td>
                <td><label for="return-reason-id<?php echo $return_reason['return_reason_id']; ?>"><?php echo $return_reason['name']; ?></label></td>
              </tr>
              <?php  } ?>
              <?php  } ?>
            </table>
            <?php if ($error_reason) { ?>
            <span class="error"><?php echo $error_reason; ?></span>
            <?php } ?>
          </div>
          <div class="return-opened four columns">
			<h2><?php echo $entry_opened; ?></h2>
            <?php if ($opened) { ?>
            <input type="radio" name="opened" value="1" id="opened" checked="checked" />
            <?php } else { ?>
            <input type="radio" name="opened" value="1" id="opened" />
            <?php } ?>
            <label for="opened"><?php echo $text_yes; ?></label>
            <?php if (!$opened) { ?>
            <input type="radio" name="opened" value="0" id="unopened" checked="checked" />
            <?php } else { ?>
            <input type="radio" name="opened" value="0" id="unopened" />
            <?php } ?>
            <label for="unopened"><?php echo $text_no; ?></label>
            <br />
            <br />
            <span class="tt_input"><?php echo $entry_fault_detail; ?></span><br />
            <textarea name="comment" cols="150" rows="6"><?php echo $comment; ?></textarea>
          </div>
          <div class="return-captcha four columns omega">
			<span class="tt_input"><?php echo $entry_captcha; ?></span><br />
            <input type="text" name="captcha" value="<?php echo $captcha; ?>" />
            <br />
            <img src="index.php?route=account/return/captcha" alt="" />
            <?php if ($error_captcha) { ?>
            <span class="error"><?php echo $error_captcha; ?></span>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>    <div>        <input type="checkbox" id="acceptance" name="acceptance" <?php if(isset($acceptance)) echo "checked"; ?>>        <label for="acceptance">Даю согласие на обработку персональных данных</label><br>        <small>Ставя отметку, я даю свое согласие на обработку моих персональных данных в соответствии с законом №152-ФЗ «О персональных данных» от 27.07.2006 и принимаю условия <a href="<?php echo $oferta; ?>" style="color: #e85e5e;">Пользовательского соглашения&#8203;&#8203;</a></small>    </div>    <script>    $(document).ready(function() {        $('#form').on('submit', function(e) {            if(!$("#acceptance")[0].checked) {                e.preventDefault();                 alert('Необходимо согласиться с условиями пользовательского соглашения!')            }        });    });    </script>
    <div class="buttons">        
      <div class="left"><a href="<?php echo $back; ?>" class="btn btn-primary"><span class="button_fr"><?php echo $button_back; ?></span></a></div>
      <div class="right">
        <span class="button_fr_ip"><input type="submit" value="<?php echo $button_continue; ?>" class="btn btn-primary" /></span>
      </div>
    </div>
  </form>
  <?php echo $content_bottom; ?></div></div>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.date').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script> 

<?php echo $footer; ?>