<!--module boss-category-->
<?php function showSubcate($category) {
	echo '<dd>';
	if (count($category['children']) > 0) {		
		foreach ($category['children'] as $cat) {
			echo(count($cat['children']) >0 ? '<dl class="cate-list-item submenu">':'<dl class="cate-list-item">');
				echo '<dt>';
				echo '<a href="'.$cat['href'].'">'.$cat['name'].'</a>';				
				echo '</dt>';
				showSubcate($cat);
			echo '</dl>';
		}		
	}
	echo '</dd>';
} ?>
<div id="submenu" class="box b_raidus b_first">
	<div class="box-heading"><?php echo $heading_title; ?></div>
	<div class="submenu-inside box-content">
			<?php foreach ($categories as $category) { ?>
			<dl class="cate-list-item<?php echo($category['children'])? ' submenu':''; ?>">
				<dt class="cate-name">
				 <?php if ($category['category_id'] == $category_id) { ?>
					<a href="<?php echo $category['href']; ?>" class="active"><?php echo $category['name']; ?></a>
				<?php } else { ?>
					<a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
				<?php } ?>
				</dt>
				<dd class="sub-cate-list" style="top:0px;width:<?php echo $width; ?>px">
				<?php for ($i = 0; $i < count($category['children']);) { ?>
					<div class="sub-item" style="width:<?php echo floor($width/$column); ?>px;">
					  <?php $j = $i + ceil(count($category['children'])/$column); ?>
					  <?php for (; $i < $j; $i++) { ?>
						  <?php if (isset($category['children'][$i])) { ?>
						  <dl class="cate-list-item<?php echo($category['children'][$i]['children'])? ' submenu':''; ?>">
							<dt><a href="<?php echo $category['children'][$i]['href']; ?>">
								<?php echo $category['children'][$i]['name']; ?>
							</a></dt>
							<?php showSubcate($category['children'][$i]);?>
							</dl>
						  <?php } ?>
					  <?php } ?>
					</div>
				<?php } ?>
				</dd>
			</dl>
			<?php } ?>		
	</div>
</div>
<script type="text/javascript"><!--	
		$('#submenu > .submenu-inside > dl.submenu > dt.cate-name').hover(
		function(){
			$('#submenu dd.sub-cate-list').hide();
			$(this).parent().addClass('cate_hover');
			$(this).next('dd.sub-cate-list').slideDown();
		},function () {
			$(this).parent().mouseleave(function() {
				$(this).removeClass('cate_hover');
				$('#submenu dd.sub-cate-list').hide(0);
			});
		}
	);
	
//--></script> 
<!--module boss-category-->