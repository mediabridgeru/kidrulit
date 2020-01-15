

<div id="blogarticles_0" class="blogarticles fadeInUp animated" data-animate="fadeInUp" data-delay="300">
  <h3><?php echo $heading_title; ?></h3>
  <h4><?php echo $heading_title; ?></h4>

  <div class="blog_article_content">
  <ul>
      <?php foreach ($articles as $article) { ?>
      <li style="margin:0 0 10px;width:100%;overflow:auto;">
        <?php if ($article['thumb']) { ?>
        <div class="image" style="float:left;margin-right:20px;"><a href="<?php echo $article['href']; ?>"><img src="<?php echo $article['thumb']; ?>" alt="<?php echo $article['name']; ?>" /></a></div>
        <?php } ?>
        <div class="name"><a href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a></div>
		<div class="description"><?php echo $article['description']; ?> <a href="<?php echo $article['href']?>">...&raquo;</a></div>
		<div class="added-viewed" style="text-align:right;margin:10px 0 5px;"><i class="fa fa-clock-o"></i> <?php echo $article["date_added"];?>&nbsp;&nbsp;&nbsp;<i class="fa fa-eye"></i> <?php echo $text_views; ?> <?php echo $article["viewed"];?></div>
		<div class="rating" style="text-align:right;overflow:hidden;">
          <?php for ($i = 1; $i <= 5; $i++) { ?>
          <?php if ($article['rating'] < $i) { ?>
          <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
          <?php } else { ?>
          <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
          <?php } ?>
          <?php } ?>
        </div>
        </li>
      <?php } ?>
  </ul>
  </div>
</div>
