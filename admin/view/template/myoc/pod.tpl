<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="attention"><?php echo $text_nothing; ?></div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $copy; ?>" method="post" enctype="multipart/form-data" id="form-pod-copy" class="form-horizontal">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_product_source; ?></td>
            <td>
              <select id="product-category" class="form-control">
                <option value="http://"><?php echo $text_select; ?></option>
                <?php foreach ($categories as $category) { ?>
                <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                <?php } ?>
              </select>
              <select id="source-product" name="source_product" class="form-control"><option value="0"><?php echo $text_select; ?></option>
              </select>
              <?php if ($error_source_product) { ?>
              <span class="error"><?php echo $error_source_product; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_product_target; ?></td>
            <td>
              <input type="text" name="product" value="" size="53" /><br /><br />
              <div class="scrollbox" id="target-product" style="height: 140px;"></div>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_category_target; ?></td>
            <td><div class="scrollbox" style="height: 140px;">
                <?php $class = 'odd'; ?>
                <?php foreach ($categories as $category) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <label><input type="checkbox" name="target_categories[]" value="<?php echo $category['category_id']; ?>" />
                    <?php echo $category['name']; ?></label>
                  </div>
                <?php } ?>
              </div>
              <a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a>
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <a onclick="confirm('<?php echo $text_copy_warning; ?>') ? $('#form-pod-copy').submit() : false;" class="button"><span><?php echo $button_copy; ?></span></a>
            </td>
          </tr>
        </table>
      </form>
      <div style="font-size:11px;color:#666;"><?php echo $myoc_copyright; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    var category_products = [];
    <?php foreach ($category_products as $category_id => $products) { ?>
    category_products[<?php echo $category_id; ?>] = [];
    <?php foreach ($products as $product_id => $product) { ?>
    category_products[<?php echo $category_id; ?>][<?php echo $product_id; ?>] = "<?php echo $product; ?>";
    <?php } ?>
    <?php } ?>
    $("select#product-category").change(function() {
      $("select#source-product option").remove();
      $('<option value="http://"><?php echo $text_select; ?></option>').appendTo($("select#source-product"));
      for(var product_id in category_products[$(this).val()])
      {
        $('<option value="' + product_id + '">' + category_products[$(this).val()][product_id] + '</option>').appendTo($("select#source-product"));
      }
    });
});
$('input[name=\'product\']').autocomplete({
  delay: 0,
  source: function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request.term),
      type: 'POST',
      dataType: 'json',
      data: 'filter_name=' +  encodeURIComponent(request.term),
      success: function(data) {   
        response($.map(data, function(item) {
          return {
            label: item.name,
            value: item.product_id
          }
        }));
      }
    });
  },
  select: function(event, ui) {
    $('#target-product' + ui.item.value).remove();

    $('#target-product').append('<div id="target-product' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" /><input type="hidden" name="target_products[]" value="' + ui.item.value + '" /></div>');

    $('#target-product div:odd').attr('class', 'odd');
    $('#target-product div:even').attr('class', 'even');

    return false;
  },
  focus: function(event, ui) {
    return false;
  }
});

$('#target-product div img').live('click', function() {
  $(this).parent().remove();

  $('#target-product div:odd').attr('class', 'odd');
  $('#target-product div:even').attr('class', 'even');
});
</script>
<?php echo $footer; ?>