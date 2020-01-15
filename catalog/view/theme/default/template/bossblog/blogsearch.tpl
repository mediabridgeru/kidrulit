<?php echo $header; ?>
<div class="col-xs-24 col-sm-24 col-md-24">
	<div id="breadcrumb">	
	<?php $i = 1; $count = count($breadcrumbs);  ?>
	<b></b>
	<?php foreach ($breadcrumbs as $breadcrumb) { ?>
	<a class="<?php if($i==$count){echo 'breadcrumb_last';} else if($i==$count-1){echo 'breadcumb_middle';} else{echo 'breadcumb_first';} ?>" href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
	<?php $i++; } ?>
	</div>	
</div>
<?php echo $column_left; ?><?php echo $column_right; ?>

<div id="content"><?php echo $content_top; ?>
  <h1><?php echo $heading_title; ?></h1>
  <b><?php echo $text_critea; ?></b>
  <div class="content">
    <p><?php echo $entry_search; ?>
      <?php if ($filter_name) { ?>
      </br><input type="text" name="filter_name" value="<?php echo $filter_name; ?>" /></br>
      <?php } else { ?>
      </br><input type="text" name="filter_name" value="<?php echo $filter_name; ?>" onclick="this.value = '';" onkeydown="this.style.color = '000000'" style="color: #999;" /></br>
      <?php } ?>
      <select name="filter_category_id">
        <option value="0"><?php echo $text_category; ?></option>
        <?php foreach ($categories as $category_1) { ?>
        <?php if ($category_1['blog_category_id'] == $filter_category_id) { ?>
        <option value="<?php echo $category_1['blog_category_id']; ?>" selected="selected"><?php echo $category_1['name']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $category_1['blog_category_id']; ?>"><?php echo $category_1['name']; ?></option>
        <?php } ?>
        <?php foreach ($category_1['children'] as $category_2) { ?>
        <?php if ($category_2['blog_category_id'] == $filter_category_id) { ?>
        <option value="<?php echo $category_2['blog_category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $category_2['blog_category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
        <?php } ?>
        <?php foreach ($category_2['children'] as $category_3) { ?>
        <?php if ($category_3['blog_category_id'] == $filter_category_id) { ?>
        <option value="<?php echo $category_3['blog_category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $category_3['blog_category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
        <?php } ?>
        <?php } ?>
        <?php } ?>
        <?php } ?>
      </select></br>
      <?php if ($filter_sub_category) { ?>
      <input type="checkbox" name="filter_sub_category" value="1" id="sub_category" checked="checked" />
      <?php } else { ?>
      <input type="checkbox" name="filter_sub_category" value="1" id="sub_category" />
      <?php } ?>
      <label for="sub_category"><?php echo $text_sub_category; ?></label>
    </p>
    <?php if ($filter_content) { ?>
    <input type="checkbox" name="filter_content" value="1" id="description" checked="checked" />
    <?php } else { ?>
    <input type="checkbox" name="filter_content" value="1" id="description" />
    <?php } ?>
    <label for="description"><?php echo $entry_description; ?></label>
  </div>
  <div class="buttons">
    <div class="left" style="margin-bottom:20px;width:100%"><input type="button" value="<?php echo $button_search; ?>" id="button-search" class="btn btn-primary" /></div>
  </div>
  </br>
  <h2 style="clear:both"><?php echo $text_search; ?></h2>
    <?php if ($articles) { ?>   
        <div class="boss_article-items  row">
		<div class="article-list">
            <?php foreach ($articles as $key => $article) { ?>
            <div class="boss_article-item">	
				<div class="row not-animated" data-animate="fadeInUp" data-delay="<?php echo $key*50+100; ?>" >
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-24" >
                 <div class="article-image"><a href="<?php echo $article['href']; ?>"><span><img src="<?php echo $article['thumb']; ?>" title="<?php echo $article['name']; ?>" alt="<?php echo $article['name']; ?>" /><b></b></span></a></div>
				 </div>
				 <div class="std col-lg-18 col-md-18 col-sm-18 col-xs-24">
				<div class="article-name">
                   <h2><a href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a></div></h2>
                <div class="time-stamp" ><small >
                        <?php $date = new DateTime($article['date_modified']);?>
                        <?php echo $date->format('l, M j, Y');?>
                    </small>
                </div>
                <div class="std">
                   
                    <p><?php  echo $article['title']; ?></p>
                </div>
                <div class="article-footer">
                    <span class="post-by">Post by <span><?php echo $article['author']; ?></span></span>
					<span class="separator">|</span>
					<span class="comment-count"><span><?php echo $article['comment']; ?></span> <a href="<?php echo $article['href']; ?>">Comments</a></span>
                </div>
				</div>
				</div>
            </div>
            <?php } ?>
			</div>
        </div>
        <div class="pagination"><?php echo $pagination; ?></div>  
    <?php } else { ?>
      <div class="content"><?php echo $text_empty; ?></div>
    <?php }?>
  <?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
$('#content input[name=\'filter_name\']').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#button-search').trigger('click');
	}
});

$('#button-search').bind('click', function() {
	url = 'index.php?route=bossblog/blogsearch';
	
	var filter_name = $('#content input[name=\'filter_name\']').attr('value');
	
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

	var filter_category_id = $('#content select[name=\'filter_category_id\']').attr('value');
	
	if (filter_category_id > 0) {
		url += '&filter_category_id=' + encodeURIComponent(filter_category_id);
	}
	
	var filter_sub_category = $('#content input[name=\'filter_sub_category\']:checked').attr('value');
	
	if (filter_sub_category) {
		url += '&filter_sub_category=true';
	}
		
	var filter_content = $('#content input[name=\'filter_content\']:checked').attr('value');
	
	if (filter_content) {
		url += '&filter_content=true';
	}

	location = url;
});
//--></script> 
<?php echo $footer; ?>