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
<?php echo $column_left; ?>	<?php echo $column_right; ?>

<div id="content"><?php echo $content_top; ?>
  <h1><?php echo $heading_title; ?></h1>
  <?php echo $text_message; ?>
    <?php if (!empty($docs)) : ?>
    <div class="docs">
        <h2>Документы</h2>
        <ul>
            <li><a target="_blank" href="<?php echo $invoice; ?>"><i class="fa fa-download"></i>Скачать счет на оплату в формате Excel</a></li>
            <li><a target="_blank" href="<?php echo $html_invoice; ?>"><i class="fa fa-external-link"></i>Посмотреть счет в новой вкладке</a></li>
        </ul>
        <ul>
            <li><a target="_blank" href="<?php echo $torg12; ?>&excel7"><i class="fa fa-download"></i>Скачать накладную ТОРГ-12 в формате Excel</a></li>
            <li><a target="_blank" href="<?php echo $html_torg12; ?>"><i class="fa fa-external-link"></i>Посмотреть накладную ТОРГ-12 в новой вкладке</a></li>
        </ul>
        <?php if(!$do_hidesbrf_card) { ?>
        <?php if (!empty($html_btn)) : ?>
        <?php echo $html_btn; ?>
        <?php endif; ?>
        <?php } ?>
    </div>
    <?php else : ?>
    <div class="buttons">
        <div class="right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
    </div>
    <?php endif; ?>
  <?php echo $content_bottom; ?>
</div>
<?php echo $footer; ?>