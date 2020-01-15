<div class="box accord_category">
	<div class="box-heading"><?php echo $heading_title; ?></div>
	<div class="box-content">
		<div class="box-category accordeon_categ">
			<ul>  
			<?php foreach ($categories as $category_1) { ?>
				<li class="<?php echo ( ($category_1['active'] == 1) ? "cat-active" : ""); ?>">
					<a class="<?php echo ( ($category_1['active'] == 1) ? "active" : ""); ?>" href="<?php echo $category_1['href']; ?>"><?php echo $category_1['name']; ?></a>
			<?php   $children = sizeof($category_1['children']) ;  ?>	
			<?php   if ($children > 0) {  ?>
			<?php   	echo '<b class="accordeon_plus"></b>' ;  ?>
					<ul class="accordeon_subcat">
			<?php	foreach ($category_1['children'] as $category_2) { ?>
						<li>
							<a class="<?php echo ( ($category_2['active'] == 1) ? "active" : ""); ?>" href="<?php echo $category_2['href']; ?>"><?php echo $category_2['name']; ?></a>
						</li>
                        <?php if(isset($category_2['children'])){ ?>
                        <?php foreach ($category_2['children'] as $category_3){ ?>
                        <li class="category_3">
                        - &nbsp;<a class="<?php echo ( ($category_3['active'] == 1) ? "active" : ""); ?>" href="<?php echo $category_3['href']; ?>"><?php echo $category_3['name']; ?></a>
                        </li>
                        <?php } ?>
                        <?php } ?>
			<?php   }   ?>
					</ul>
			<?php   }   ?>		
				</li>
			<?php } ?>
			</ul>
		</div>
	</div>
</div>

<script type="text/javascript"><!--
$(document).ready(function() {	
// Categories module 
	$(".box-category .accordeon_plus").each(function(index, element) {
	
		if($(this).parent().hasClass('cat-active') == true){
			$(this).addClass('open');
			$(this).next().addClass('active');
		}	
	});
	$(".box-category .accordeon_plus").click(function(){ 
		if($(this).next().is(':visible') == false) {
			$('.box-category .accordeon_subcat').slideUp(300, function(){
				$(this).removeClass('active');
				$('.accordeon_plus').removeClass('open');
			});
		}
		if($(this).hasClass('open') == true) {
			$(this).next().slideUp(300, function(){
				$(this).removeClass('active');
				$(this).prev().removeClass('open');
			});
		}else{
			$(this).next().slideDown(300, function(){
				$(this).addClass('active');
				$(this).prev().addClass('open');
			});
		}
	}); 

});	
//--></script>
