<?php if(!empty($tabs)){ ?>
<div id="blogarticles_<?php echo $module; ?>" class="blogarticles not-animated" data-animate="fadeInUp" data-delay="200">
  <h3><?php echo $heading_title; ?></h3>
  <h4><?php echo $text_title; ?></h4>
  <div class="blog_article_content">
		<ul class="box-product">
			<?php foreach ($tabs as $tab) { ?><li>
				<?php if ($tab['thumb']) { ?>
				<div class="image">
				<a href="<?php echo $tab['href']; ?>"><img src="<?php echo $tab['thumb']; ?>" alt="<?php echo $tab['name']; ?>" title="<?php echo $tab['name']; ?>"/><b></b></a>
				</div>
				<?php } ?>
				<div class="name"><a href="<?php echo $tab['href']; ?>"><?php echo $tab['name']; ?></a></div>
				<div class="readmore"><a href="<?php echo $tab['href']; ?>"><?php echo $text_more; ?></a></div>
			  </li><?php } ?>
		</ul>
  </div>
</div>
<?php } ?>