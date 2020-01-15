<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/product.png" alt="" /> <?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').attr('action', '<?php echo $enabled; ?>'); $('#form').submit();" class="button"><span><?php echo $button_enable; ?></span></a><a onclick="$('#form').attr('action', '<?php echo $disabled; ?>'); $('#form').submit();" class="button"><span><?php echo $button_disable; ?></span></a><a href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a><a onclick="$('#form').attr('action', '<?php echo $copy; ?>'); $('#form').submit();" class="button"><?php echo $button_copy; ?></a><a onclick="$('form').submit();" class="button"><?php echo $button_delete; ?></a><button id="btn-del-stickers" class="button">Удалить стикеры</button></div>
      <div class="buttons ">
        <a href="<?php echo $check_group_products; ?>" class="button"><span>Проверить количество товаров в группах</span></a>
      </div>
    </div>
    <div class="content">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
		<input hidden id="page" value="1">
		<input hidden id="sort" value="pd.name">
		<input hidden id="order" value="ASC">
        <table class="list">
          <thead>
           <tr id="head">
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="center"><?php echo $column_image; ?></td>
              <td class="left"><?php if ($sort == 'pd.name') { ?>
                <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                <?php } ?></td>
				 <td class="left">                
                <?php echo $column_category; ?>
              </td>
              <td class="left">                
                <?php echo $column_manufacturer; ?>
              </td>
              <td class="left"><?php if ($sort == 'p.model') { ?>
                <a href="<?php echo $sort_model; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_model; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_model; ?>"><?php echo $column_model; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'p.price') { ?>
                <a href="<?php echo $sort_price; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_price; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_price; ?>"><?php echo $column_price; ?></a>
                <?php } ?></td>
              <td class="right"><?php if ($sort == 'p.upc_quantity') { ?>
                <a href="<?php echo $sort_upc_quantity; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_quantity; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_upc_quantity; ?>"><?php echo $column_quantity; ?></a>
                <?php } ?></td>
             <td class="right"><?php if ($sort == 'p.quantity') { ?>
               <a href="<?php echo $sort_quantity; ?>" class="<?php echo strtolower($order); ?>">Количество<br>в группе</a>
               <?php } else { ?>
               <a href="<?php echo $sort_quantity; ?>">Количество<br>в группе</a>
               <?php } ?></td>
              <td class="left"><?php if ($sort == 'p.status') { ?>
                <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                <?php } ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr class="filter">
              <td></td>
              <td></td>
              <td><input type="text" name="filter_name" value="<?php echo $filter_name; ?>" size="48"/></td>
			  <td><select name="filter_category_id" style="width: 130px;">
              <option value="*"></option>
		      <option value="null">-</option>
		      <?php foreach($categories as $category) { ?>
			  <option value="<?php echo $category['category_id'] ?>" <?php if($filter_category_id == $category['category_id']) echo 'selected="selected"'; ?>><?php echo $category['name'] ?></option>
		      <?php }?>
              </select>
			  </td>
              <td><select name="filter_manufacturer_id" style="width: 130px;">
              <option value="*"></option>
              <option value="null">-</option>
			  <?php foreach($manufacturers as $manufacturer) { ?>
			  <option value="<?php echo $manufacturer['manufacturer_id'] ?>"<?php if($filter_manufacturer_id == $manufacturer['manufacturer_id']) echo 'selected="selected"'; ?>><?php echo $manufacturer['name'] ?></option>
			  <?php }?>
              </select>
			  </td>
              <td><input type="text" name="filter_model" value="<?php echo $filter_model; ?>" size="9"/></td>
              <td align="left"><input type="text" name="filter_price" value="<?php echo $filter_price; ?>" size="9"/></td>
              <td align="right"><input type="text" name="filter_upc_quantity" value="<?php echo $filter_upc_quantity; ?>" style="text-align: right;" size="8"/></td>
              <td align="right"><input type="text" name="filter_quantity" value="<?php echo $filter_quantity; ?>" style="text-align: right;" size="8"/></td>
              <td><select name="filter_status">
                  <option value="*"></option>
                  <?php if ($filter_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <?php } ?>
                  <?php if (!is_null($filter_status) && !$filter_status) { ?>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
              <td align="right"><a onclick="clear_filter();" class="button"><?php echo $button_clear; ?></a></td>
            </tr>
            <?php if ($products) { ?>
            <?php foreach ($products as $product) { ?>
            <tr class="m_<?php echo $product['model']; ?><?php echo ($product['option']) ? ' option' : ''; ?><?php echo ($product['gtd']) ? ' gtd' : ''; ?>">
              <td style="text-align: center;"><?php if ($product['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" />
                <?php } ?></td>
              <td class="center"><img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" style="padding: 1px; border: 1px solid #DDDDDD;" /></td>
              <td class="left"><div id="<?php echo $product['product_id']; ?>" class="inlineEditn"><?php echo $product['name']; ?></div></td>
			  <td class="left"><?php foreach ($product['category'] as $cat) echo $cat['name'] . '<br />'; ?></td>
              <td class="left"><?php echo $product['manufacturer']; ?></td>
              <td class="left"><div id="<?php echo $product['product_id']; ?>" class="inlineEditm"><?php echo $product['model']; ?></div></td>
              <td class="left"><?php if ($product['special']) { ?>
                <span style="text-decoration: line-through;"><div class="inlineEdit"><?php echo $product['price']; ?></div></span><br/>
                <span style="color: #b00;"><?php echo $product['special']; ?></span>
                <?php } else { ?>
                <div id="<?php echo $product['product_id']; ?>" class="inlineEdit"><?php echo $product['price']; ?></div>
                <?php } ?></td>
              <td class="right"><?php if ($product['upc_quantity'] <= 0) { ?>
                <span style="color: #FF0000;"><div class="<?php echo ($product['option']) ? '' : 'inlineEditq'; ?>"><?php echo $product['upc_quantity']; ?></div></span>
                <?php } elseif ($product['upc_quantity'] <= 5) { ?>
                <span style="color: #FFA500;"><div class="<?php echo ($product['option']) ? '' : 'inlineEditq'; ?>"><?php echo $product['upc_quantity']; ?></div></span>
                <?php } else { ?>
                <span style="color: #008000;"><div class="<?php echo ($product['option']) ? '' : 'inlineEditq'; ?>"><?php echo $product['upc_quantity']; ?></div></span>
                <?php } ?>
			  </td>
              <td class="right"><?php if ($product['quantity'] <= 0) { ?>
                <span style="color: #FF0000;"><div class="setQuantity"><?php echo $product['quantity']; ?></div></span>
                <?php } elseif ($product['quantity'] <= 5) { ?>
                <span style="color: #FFA500;"><div class="setQuantity"><?php echo $product['quantity']; ?></div></span>
                <?php } else { ?>
                <span style="color: #008000;"><div class="setQuantity"><?php echo $product['quantity']; ?></div></span>
                <?php } ?>
              </td>
              <td class="left"><label><input type="checkbox" name="status"  <?php echo ($product['status'] == $text_enabled ? 'checked="checked"' : ''); ?> /><span><?php echo $product['status']; ?></span></label></td>
              <td class="right"><?php foreach ($product['action'] as $action) { ?>
                [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                <?php } ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
	<div class="bottom">
	<h1><img src="view/image/product.png" alt="" /> <?php echo $heading_title; ?></h1>
	<div class="buttons"><a onclick="$('#form').attr('action', '<?php echo $enabled; ?>'); $('#form').submit();" class="button"><span><?php echo $button_enable; ?></span></a><a onclick="$('#form').attr('action', '<?php echo $disabled; ?>'); $('#form').submit();" class="button"><span><?php echo $button_disable; ?></span></a><a onclick="location = '<?php echo $insert; ?>'" class="button"><span><?php echo $button_insert; ?></span></a><a onclick="$('#form').attr('action', '<?php echo $copy; ?>'); $('#form').submit();" class="button"><span><?php echo $button_copy; ?></span></a><a onclick="$('form').submit();" class="button"><span><?php echo $button_delete; ?></span></a></div>
  </div>
</div>
<script id="productTemplate" type="text/x-jquery-tmpl">
<tr class="m_${model}{{if gtd > 0}} gtd{{/if}}{{if option > 0}} option{{/if}}">
  <td style="text-align: center;"><input type="checkbox" name="selected[]" value="${product_id}" /></td>
  <td class="center"><img src="${image}" alt="${name}" style="padding: 1px; border: 1px solid #DDDDDD;" /></td>
  <td class="left"><div class="inlineEditn">${name}</div></td>
  <td class="left">{{each(i, cat) category}}${cat['name']}<br/>{{/each}}</td>
  <td class="left">${manufacturer}</td>
  <td class="left"><div class="inlineEditm">${model}</div></td>
  <td class="left">{{if special}}
    <span style="text-decoration: line-through;"><div class="inlineEdit">${price}</div></span><br/>
    <span style="color: #b00;">${special}</span>
    {{else}}
    <div class="inlineEdit">${price}</div>
    {{/if}}
  </td>
  <td class="right">
  {{if upc_quantity <= 5}}
      {{if upc_quantity <= 0}}
          <span style="color: #FF0000;"><div class="{{if option == 0}}inlineEditq{{/if}}" >${upc_quantity}</div></span>
      {{else}}
          <span style="color: #FFA500;"><div class="{{if option == 0}}inlineEditq{{/if}}" >${upc_quantity}</div></span>
      {{/if}}
  {{else}}
          <span style="color: #008000;"><div class="{{if option == 0}}inlineEditq{{/if}}" >${upc_quantity}</div></span>
  {{/if}}
    </td>
    <td class="right">
  {{if quantity <= 5}}
      {{if quantity <= 0}}
          <span style="color: #FF0000;"><div class="setQuantity">${quantity}</div></span>
      {{else}}
          <span style="color: #FFA500;"><div class="setQuantity">${quantity}</div></span>
      {{/if}}
  {{else}}
          <span style="color: #008000;"><div class="setQuantity">${quantity}</div></span>
  {{/if}}
    </td>
{{if status == '<?php echo $text_enabled; ?>'  }}
  <td class="left"><label><input type="checkbox" name="status" checked="checked" /><span>${status}</span></label></td>
   {{else}}
  <td class="left"><label><input type="checkbox" name="status"/><span>${status}</span></label></td>
    {{/if}}
  <td class="right">
  {{each action}}
    [ <a href="${href}">${text}</a> ]
  {{/each}}
  </td>
</tr>
</script>
<script type="text/javascript" src="view/javascript/jquery/jquery.tmpl.min.js"></script>
<script>
$('#btn-del-stickers').on('click', function(event) {
  var tgt = $(event.target);
  var doo = confirm("Я хочу удалить все стикеры?");

  if(doo) {
    $.ajax({
      url: 'index.php?route=catalog/product/deleteStickers&token=<?php echo $token; ?>&agry=1',
      type: 'get',
      dataType: 'json',

      beforeSend: function() {
        $(tgt).attr('disabled', true);
      },
      complete: function() {
        $(tgt).attr('disabled', false);
      },
      success: function(json) {
        if (json['error']) {
          alert(json['error']);
        }
        
        if (json['success']) {
          alert(json['success']);
        }
      }
    });
  }
});

function filter() {
	url = 'index.php?route=catalog/product/filter&token=<?php echo $token; ?>';

	url += '&page=' + $('#page').val();

	if ($('#sort').val()) {
		url += '&sort=' + $('#sort').val();
	}
	if ($('#order').val()) {
		url += '&order=' + $('#order').val();
	}
	
	var filter_name = $('input[name=\'filter_name\']').attr('value');
	
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}
	
	var category_id = $('select[name=\'filter_category_id\']').attr('value');
	
	if (category_id != '*') {
		url += '&filter_category_id=' + encodeURIComponent(category_id);
	}	

	var manufacturer_id = $('select[name=\'filter_manufacturer_id\']').attr('value');
	
	if (manufacturer_id != '*') {
		url += '&filter_manufacturer_id=' + encodeURIComponent(manufacturer_id);
	}	
	
	var filter_model = $('input[name=\'filter_model\']').attr('value');
	
	if (filter_model) {
		url += '&filter_model=' + encodeURIComponent(filter_model);
	}
	
	var filter_price = $('input[name=\'filter_price\']').attr('value');
	
	if (filter_price) {
		url += '&filter_price=' + encodeURIComponent(filter_price);
	}
	
	var filter_upc_quantity = $('input[name=\'filter_upc_quantity\']').attr('value');
	
	if (filter_upc_quantity) {
		url += '&filter_upc_quantity=' + encodeURIComponent(filter_upc_quantity);
	}

  var filter_quantity = $('input[name=\'filter_quantity\']').attr('value');

  if (filter_quantity) {
    url += '&filter_quantity=' + encodeURIComponent(filter_quantity);
  }
	
	var filter_status = $('select[name=\'filter_status\']').attr('value');
	
	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status);
	}	

	$.ajax({
		url: url,
		dataType: 'json',
		success : function(json) {
				  $('table.list tr:gt(1)').empty();
				  $("#productTemplate").tmpl(json.products).appendTo("table.list");
				  $('.pagination').html(json.pagination);
			  }
	});
}
</script> 
<script>
function gsUV(e, t, v) {
    var n = String(e).split("?");
    var r = "";
    if (n[1]) {
        var i = n[1].split("&");
        for (var s = 0; s <= i.length; s++) {
            if (i[s]) {
                var o = i[s].split("=");
                if (o[0] && o[0] == t) {
                    r = o[1];
                    if (v != undefined) {
                        i[s] = o[0] +'=' + v;
                    }
                    break;
                }
            }
        }
    }
    if (v != undefined) {
        return n[0] +'?'+ i.join('&');
    }
    return r
}
$('#form input').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#page').val(1);
		filter();
	}
});
$('#form input').bind("input", function() {
	if ($(this).val()=='') {
		$('#page').val(1);
		filter();
	}
});

$('#form select').bind("change", function() {
	$('#page').val(1);
	filter();
});

$('.pagination .links a').live("click", function() {
	var page = gsUV($(this).attr('href'), 'page');
	$('#page').val(page);
	filter();
	return false;
});

$('#head a').live("click", function() {
	var sort = gsUV($(this).attr('href'), 'sort');
	$('#sort').val(sort);
	var order = gsUV($(this).attr('href'), 'order');
	$('#order').val(order);
	$(this).attr('href', gsUV($(this).attr('href'), 'order', order=='DESC'?'ASC':'DESC'));
	$('#head a').removeAttr('class');
	this.className = order.toLowerCase();
	filter();
	return false;
});

function clear_filter() {
	$('tr.filter select option:selected').prop('selected', false);
	$('tr.filter input').val('');
	filter();
	return false;
}
</script> 
<script>
$('.filter input').autocomplete({
	delay: 500,
	source: function(request, response) {
	    filter();
	}
});

</script> 
<script>
  $('input[name=\'status\']').live("click", function () {
    var product_id = $(this).parent().parent().parent().find('input:checkbox').attr('value');
    $.post('index.php?route=catalog/product/status&token=<?php echo $token; ?>', 'status=' + ($(this).attr('checked') ? '1' : '0') + '&product_id=' + product_id);
    var text = $(this).next().text() == '<?php echo $text_disabled; ?>' ? '<?php echo $text_enabled; ?>' : '<?php echo $text_disabled; ?>';
    $(this).next().text(text);
  });

  $(".inlineEdit").live("click", function () {
    var save = '</br><a class="save"><img src="view/image/add.png" alt="<?php echo $button_save; ?>" title="<?php echo $button_save; ?>" /></a>&nbsp;';
    var revert = '<a class="revert"><img src="view/image/delete.png" alt="<?php echo $button_cancel; ?>" title="<?php echo $button_cancel; ?>" /></a>'
    $(this).after('<div class="editor"><input type="text" name="price" value="' + $(this).text() + '" size="30" />' + save + revert + '</div>');
    $(this).hide();
    $(this).parent().find('input').focus();
  });

  $(".revert").live("click", function () {
    $(this).parent().parent().find('.inlineEdit').show();
    $(this).parent().parent().find('.editor').remove();
  });

  $(".save").live("click", function () {
    var product_id = $(this).parent().parent().parent().find('input:checkbox').attr('value');
    var price = $(this).parent().parent().find('input').val();
    $.post('index.php?route=catalog/product/price&token=<?php echo $token; ?>', 'price=' + price + '&product_id=' + product_id);
    $(this).parent().parent().find('.inlineEdit').text(price).show();
    $(this).parent().parent().find('.editor').remove();
  });

  $(".inlineEditq").live("click", function () {
    var saveq = '</br><a class="saveq"><img src="view/image/add.png" alt="<?php echo $button_save; ?>" title="<?php echo $button_save; ?>" /></a>&nbsp;';
    var revertq = '<a class="revertq"><img src="view/image/delete.png" alt="<?php echo $button_cancel; ?>" title="<?php echo $button_cancel; ?>" /></a>'
    $(this).after('<div class="editor"><input type="text" name="quantity" value="' + $(this).text() + '" size="30" />' + saveq + revertq + '</div>');
    $(this).hide();
    $(this).parent().find('input').focus();
  });

  $(".revertq").live("click", function () {
    $(this).parent().parent().find('.inlineEditq').show();
    $(this).parent().parent().find('.editor').remove();
  });

  $(".saveq").live("click", function () {
    const $td = $(this).closest('td');
    const $tr = $td.closest('tr');
    const product_id = $tr.find('input:checkbox').attr('value');
    const quantity = $td.find('input').val();
    const model = $tr.find('.inlineEditm').text();
    var gtd = 0;
    if ($tr.hasClass('gtd')) {
      gtd = 1;
    }
    const data = {
      quantity: quantity,
      gtd: gtd,
      model: model,
      product_id: product_id
    };

    $.ajax({
      url: 'index.php?route=catalog/product/quantity&token=<?php echo $token; ?>',
      type: 'POST',
      dataType: 'json',
      data: data,
      success : function(json) {
        if (json.result === 'success') {
          $td.find('.inlineEditq').text(quantity).show();
          if (gtd) {
            $('tr.m_'+model).each(function (index, value) {
              $(this).find('.setQuantity').text(json.quantity).show();
            });
          } else {
            $tr.find('.setQuantity').text(quantity).show();
          }
        } else {
          alert('Товар имеет опции');
        }
      }
    });

    $(this).parent().parent().find('.editor').remove();
  });

  $(".inlineEditm").live("click", function () {
    var savem = '</br><a class="savem"><img src="view/image/add.png" alt="<?php echo $button_save; ?>" title="<?php echo $button_save; ?>" /></a>&nbsp;';
    var revertm = '<a class="revertm"><img src="view/image/delete.png" alt="<?php echo $button_cancel; ?>" title="<?php echo $button_cancel; ?>" /></a>'
    $(this).after('<div class="editor"><input type="text" name="model" value="' + $(this).text() + '" size="30" />' + savem + revertm + '</div>');
    $(this).hide();
    $(this).parent().find('input').focus();
  });

  $(".revertm").live("click", function () {
    $(this).parent().parent().find('.inlineEditm').show();
    $(this).parent().parent().find('.editor').remove();
  });

  $(".savem").live("click", function () {
    var product_id = $(this).parent().parent().parent().find('input:checkbox').attr('value');
    var model = $(this).parent().parent().find('input').val();
    $.post('index.php?route=catalog/product/model&token=<?php echo $token; ?>', 'model=' + model + '&product_id=' + product_id);
    $(this).parent().parent().find('.inlineEditm').text(model).show();
    $(this).parent().parent().find('.editor').remove();
  });

  $(".inlineEditn").live("click", function () {
    var saven = '</br><a class="saven"><img src="view/image/add.png" alt="<?php echo $button_save; ?>" title="<?php echo $button_save; ?>" /></a>&nbsp;';
    var revertn = '<a class="revertn"><img src="view/image/delete.png" alt="<?php echo $button_cancel; ?>" title="<?php echo $button_cancel; ?>" /></a>'
    $(this).after('<div class="editor"><input type="text" name="name" value="' + $(this).text() + '" size="55" />' + saven + revertn + '</div>');
    $(this).hide();
    $(this).parent().find('input').focus();
  });

  $(".revertn").live("click", function () {
    $(this).parent().parent().find('.inlineEditn').show();
    $(this).parent().parent().find('.editor').remove();
  });

  $(".saven").live("click", function () {
    var product_id = $(this).parent().parent().parent().find('input:checkbox').attr('value');
    var name = $(this).parent().parent().find('input').val();
    $.post('index.php?route=catalog/product/name&token=<?php echo $token; ?>', 'name=' + name + '&product_id=' + product_id);
    $(this).parent().parent().find('.inlineEditn').text(name).show();
    $(this).parent().parent().find('.editor').remove();
  });

  $('#content').on("keydown", '.editor input', function (e) {
    if (e.keyCode == 13) {
      $(this).parent().find('a').first().click();
    }
  });
</script>
<style type="text/css">
#btn-del-stickers {
    cursor: pointer;
    font-size: 12px;
    text-decoration: none;
    color: #FFF;
    display: inline-block;
    padding: 5px 15px 5px 15px;
    background: #0381CB;
    -webkit-border-radius: 3px 3px 3px 3px;
    -moz-border-radius: 3px 3px 3px 3px;
    -khtml-border-radius: 3px 3px 3px 3px;
    border-radius: 3px 3px 3px 3px;
    border: none;
}
</style>
<?php echo $footer; ?>