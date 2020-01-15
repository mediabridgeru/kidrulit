<?php 
if($data_template){
	echo $data_template;
} else { ?>
<?php 
	function showSubmenu($category) {
		if (count($category['children']) > 0) {
			echo '<div class="sub_menu"><ul>';
			foreach ($category['children'] as $cat) {
				if(count($cat['children']) > 0){
					echo '<li class="sub_category"><a href="'.$cat['href'].'">'.$cat['name'].'</a>';
					showSubmenu($cat);
					echo '</li>';
				}else{
					echo '<li ><a href="'.$cat['href'].'">'.$cat['name'].'</a></li>';
				}
			}
			echo '</ul></div>';
		}
	}
	function showmenuChild($category) {
		if (count($category['children']) > 0) {
			echo '<ul>';
			foreach ($category['children'] as $cat) {
                $parent = ($cat['children']) ? 'parent' : '';
				echo '<li class="'.$parent.'"><a href="'.$cat['href'].'">'.$cat['name'].'</a>';
				showmenuChild($cat);
				echo '</li>';
			}
			echo '</ul>';
		}
	}
?>
<nav class="navbar" id="boss_menu" role="navigation">
<?php if ($status) { ?><!-- Mega menu -->
    <div class="boss-menu">
    <div class="cs_mega_menu hidden-xs" >
        <ul class="nav navbar-nav ul_mega_menu ">
        <?php foreach ($menus as $menu) { ?>
        <li class="menu_item level-1 parent dropdown">
            <a class="title_menu_parent<?php if (count($menu['menuchilds']) > 0) { echo ' sub_child'; }?> dropdown-toggle" href="<?php echo $menu['href']; ?>"><span class="menu-title"><?php echo $menu['title'] ?></span></a>
            <?php if (count($menu['menuchilds']) > 0) { ?>
            <div class="options_list dropdown-menu" style="width: <?php echo floor($menu['dropdown_width']); ?>px;">
            <div class="dropdown-menu-inner">
                <?php foreach ($menu['menuchilds'] as $menuchild) { ?>
                <div class="option" style="width: <?php echo floor($menuchild['child_width']); ?>px; float: left">

                    <?php if ($menuchild['type'] == 'html') { ?><!-- html-->
                        <div class="staticblock"><?php echo $menuchild['content']; ?></div>
                    <?php } ?>

                    <?php if ($menuchild['type'] == 'url') { ?><!-- url-->
                        <div class="url"><a href="<?php echo $menuchild['href']; ?>" title="<?php echo $menuchild['content']; ?>"><?php echo $menuchild['content']; ?></a></div>
                    <?php } ?>

                    <?php if ($menuchild['type'] == 'information') { ?><!-- information -->
                        <ul class="column information">
                            <?php foreach($menuchild['content'] as $information) { ?>
                            <li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
                            <?php } ?>
                        </ul>
                    <?php } ?>

                    <?php if ($menuchild['type'] == 'manufacturer') { ?><!-- manufacturer -->
                        <ul class="column manufacturer">
                            <?php foreach($menuchild['content'] as $manufacturer) { ?>
                                <li><a class="image" href="<?php echo $manufacturer['href']; ?>">
                                    <?php if ($manufacturer['show_image']) { ?><img src="<?php echo $manufacturer['image']; ?>" alt="<?php echo $manufacturer['name']; ?>"/><?php } ?>
                                    <?php if ($manufacturer['show_name']) { ?><?php echo $manufacturer['name']; ?><?php } ?>
                                </a></li>
                            <?php } ?>
                        </ul>
                    <?php } ?>

                    <?php if ($menuchild['type'] == 'category') { ?><!-- category -->

                        <?php if ($menuchild['parent']) { ?>
                        <?php if ($menuchild['parent']['show_parent']) { ?>
                            <a href="<?php echo $menuchild['parent']['href']; ?>" class="parent">
                                <?php if (($menuchild['parent']['show_image']) && $menuchild['parent']['image']) { ?><img src="<?php echo $menuchild['parent']['image']; ?>" alt="<?php echo $menuchild['parent']['name']; ?>" /><?php } ?>
                                <?php echo $menuchild['parent']['name']; ?>
                            </a>
                        <?php } ?>
                        <?php } ?>

                        <ul class="column category">
                            <?php foreach($menuchild['content'] as $category) { ?>
                                <li class="<?php if ($category['show_sub'] && count($category['children']) > 0) { echo 'sub_category'; } ?>">
                                    <a href="<?php echo $category['href']; ?>">
                                    <?php if (($category['show_image']) && $category['image']) { ?><img src="<?php echo $category['image']; ?>" alt="<?php echo $category['name']; ?>"/><?php } ?>
                                    <?php echo $category['name']; ?>
                                    </a>
                                    <?php if ($category['show_sub']) { showSubmenu($category); } ?>
                                </li>
                            <?php } ?>
                        </ul>

                    <?php } ?>

                    <?php if ($menuchild['type'] == 'product') { ?>
                        <ul class="column product product-grid"><!-- product -->
                            <?php foreach($menuchild['content'] as $product) { ?>
                                <li>
                                    <?php if ($product['thumb']) { ?><a class="image" href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>"/></a><br/><?php } ?>
                                    <?php if ($product['rating']) { ?>
                                        <div class="rating"><img src="catalog/view/theme/<?php echo $this->config->get('config_template');?>/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /><span><?php echo $product['reviews']; ?></span></div>
                                        <?php } ?>
                                        <a class="product_name" href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a><br />

                                        <div class="price">
                                        <?php if (!$product['special']) { ?>
                                            <?php echo $product['price']; ?>
                                        <?php } else { ?>
                                            <span class="price-new"><?php echo $product['special']; ?></span>
                                            <span class="price-old"><?php echo $product['price']; ?></span>
                                        <?php } ?>
                                        </div>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>

                </div>
                <span class="spanOption" style="width: <?php echo floor($menuchild['child_width']); ?>px;" ></span>
                <?php } ?>
            </div>
            </div>
            <span class="spanOptionList" style="width: <?php echo floor($menu['dropdown_width']); ?>px;" ></span>
            <?php } ?>
        </li>
        <?php } ?>
        </ul>
    </div>
    </div>

<?php } else { ?>

    <?php if ($categories) { ?><!-- Menu Default -->
    <div class="boss-menu" id="menu_default">
        <div class="hidden-xs">
      <ul class="nav navbar-nav">
        <?php foreach ($categories as $category) { ?>
        <li><a <?php if (count($category['children']) > 0) { echo 'class="sub_child"'; }?> href="<?php echo $category['href']; ?>"><span class="menu-title"><?php echo $category['name']; ?></span></a>
          <?php if ($category['children']) { ?>
          <div class="sub_menu_default dropdown-menu">
            <?php for ($i = 0; $i < count($category['children']);) { ?>
            <ul>
              <?php $j = $i + ceil(count($category['children']) / $category['column']); ?>
              <?php for (; $i < $j; $i++) { ?>
              <?php if (isset($category['children'][$i])) { ?>
              <li><a href="<?php echo $category['children'][$i]['href']; ?>"><?php echo $category['children'][$i]['name']; ?></a></li>
              <?php } ?>
              <?php } ?>
            </ul>
            <?php } ?>
          </div>
          <?php } ?>
        </li>
        <?php } ?>
      </ul>
        </div>
    </div>
    <?php } ?>
<?php } ?>

    <div id="megamenu-responsive" class="visible-xs navbar" ><!-- Menu Responsive-->
        <div class="navbar navbar-inverse">
        <div id="megamenu-responsive-root">
            <div class="navbar-header"><a class="navbar-toggle">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </a>
                <b>Navigation</b>
            </div>
            <div class="root">
                <ul>
                <?php foreach ($categories as $category) { ?>
                    <li <?php if ($category['children']) echo 'class="parent"'; ?>><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
                      <?php if ($category['children']) { ?>
                        <?php for ($i = 0; $i < count($category['children']);) { ?>
                        <ul>
                          <?php $j = $i + ceil(count($category['children']) / $category['column']); ?>
                          <?php for (; $i < $j; $i++) { ?>
                          <?php if (isset($category['children'][$i])) { ?>
                          <li <?php if($category['children'][$i]['children']){ echo 'class="parent"'; }?>>
                          <a href="<?php echo $category['children'][$i]['href']; ?>"><?php echo $category['children'][$i]['name']; ?></a>
                          <?php showmenuChild($category['children'][$i]); ?>
                          </li>
                          <?php } ?>
                          <?php } ?>
                        </ul>
                        <?php } ?>
                      <?php } ?>
                    </li>
                <?php } ?>
                </ul>
            </div>
        </div>
        <script type="text/javascript">
            $('document').ready(function(){
                $('#megamenu-responsive-root li.parent').prepend('<p>+</p>');

                $('a.navbar-toggle').click(function(){
                    $('.root').toggleClass('open');
                });

                $('#megamenu-responsive-root li.parent > p').click(function(){
                    if ($(this).text() == '+'){
                        $(this).parent('li').children('ul').slideDown(300);
                        $(this).text('-');
                    }else{
                        $(this).parent('li').children('ul').slideUp(300);
                        $(this).text('+');
                    }
                });
            });
        </script>
        </div>
    </div>
		
</nav>
<?php } ?>