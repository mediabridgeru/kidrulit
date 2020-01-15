<div id="boss_login">
	<?php if (!$logged) { ?>
	<h3 class="heading">
	    <?php echo $text_login; ?>
	</h3>
	<!-- Login -->
	<div class="frame_big">
	<div class="content-login">
		<form action="<?php echo $action_login; ?>" method="post" enctype="multipart/form-data" id="logintop" >
			<div class="login-frame">
				<span class="title-login"><?php echo $text_email; ?></span>
 			<input type="text" name="email" value="<?php echo $email; ?>" />
				<span class="title-login"><?php echo $entry_password; ?></span>
				<input type="password" name="password" value="<?php echo $password; ?>" />
				<a onclick="$('#logintop').submit();" class="btn btn-primary"><span><?php echo $button_login; ?></span></a>
				<a href="<?php echo $register; ?>" class="btn btn-checkout"><?php echo $text_register; ?></a>
			</div>
		</form>
	</div>
	</div><!-- end frame_big -->
	<?php } else { ?>
	    <?php echo $text_logged; ?>
	<?php } ?>
</div>
<script type="text/javascript"><!--
		
	/* Ajax Cart hover*/    
	var count_search = 0;
	$('body #boss_login').hover(function() {
		if($('body').hasClass('notouch')){
			$('.frame_big',this).slideDown();
			$('h3.heading',this).addClass('active');			
			$("#boss_login input").focus(function() {
				count_search=1;
			});
			$('#boss_login').mouseleave(function() {
				if(count_search==0){
					$('.frame_big', this).hide();
				}
			});
		}
	},function(){
		if($('body').hasClass('notouch')){
			if(count_search == 0){
				$('.frame_big',this).hide();
				$('h3.heading',this).removeClass('active');
			}
		}
	});

	$('body').mouseup(function(login) {
		if(!($(login.target).parents('#boss_login').length > 0)) {
			if($('#boss_login .frame_big').css('display') == "block"){
				count_search = 0;
				$('#boss_login .frame_big').hide();
				$('#boss_login > h3.heading').removeClass('active');
			}
		}
	});	

	/* Ajax Cart touch*/
	$('body #boss_login > h3.heading').click(function(e) {	
		if($('body').hasClass('touch')){
			if($(this).hasClass('active')){	
				$(this).parent().children('.frame_big').hide();
				$(this).removeClass('active');
			}else{
				$(this).parent().children('.frame_big').slideDown();
				$(this).addClass('active');
			}	
		}
	});
	
	$('#boss_login input[name=\'password\']').bind('keydown', function(e) {
		if (e.keyCode == 13) {
			$('#logintop').submit();
		}
	});

//--></script> 