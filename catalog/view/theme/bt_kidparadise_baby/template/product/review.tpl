<?php if ($reviews) { ?>
<?php foreach ($reviews as $review) { ?>
<div itemprop="reviews" itemscope="itemscope" itemtype="http://schema.org/Review" class="review-list">
  <div  itemprop="author" class="author"><b><?php echo $review['author']; ?></b> <?php echo $text_on; ?> <?php echo $review['date_added']; ?></div>
  <div class="rating"><img src="catalog/view/theme/bt_kidparadise_baby/image/stars-<?php echo $review['rating'] . '.png'; ?>" alt="<?php echo $review['reviews']; ?>" /></div>
  <div class="text"><?php echo $review['text']; ?></div>
</div>
<?php } ?>
<div class="pagination"><?php echo $pagination; ?></div>
<?php } else { ?>
<div class="content"><?php echo $text_no_reviews; ?></div>
<?php } ?>
