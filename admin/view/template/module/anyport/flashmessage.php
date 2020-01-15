
<?php $hadFailure = false; if (!empty($this->session->data['success'])) { ?>
<div class="success autoSlideUp"><?php echo $this->session->data['success']; ?></div>
<script> $('.autoSlideUp').delay(30000).fadeOut(600, function(){ $(this).show().css({'visibility':'hidden'}); }).slideUp(600);</script>
<?php $this->session->data['success'] = null; } ?>
<?php if (!empty($this->session->data['warning'])) { ?>
<div class="attention"><?php echo $this->session->data['warning']; $this->session->data['warning'] = null; ?></div>
<?php } ?>
<?php if (!empty($this->session->data['failure'])) { ?>
<div class="warning"><?php echo $this->session->data['failure']; $this->session->data['failure'] = null; $hadFailure = true; ?></div>
<?php } ?>
