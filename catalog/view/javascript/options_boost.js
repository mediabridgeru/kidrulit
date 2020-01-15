jQuery(document).ready(function(){
    var $select_number = $('.select_number').find("input");

    $select_number.on('change', function() {
        changeQty(0);
    });

});
// added
function recalcSummPp() {
    var qty = $('.product-info .select_number').find("input").val();
    var $price = $('.product-info .price_info span.price');
    if ($price.length == 0) {
        $price = $('.product-info .price_info span.price-new');
    }
    var summ =  parseInt( $price.html() );
    $('.product-info .price-summ').remove();
    if(qty > 0) {
        var html = 'В сумме: ' + qty*summ + ' руб';
        $('<span class="price-summ">' + html + '</span>').insertAfter('.product-info .select_number');
    }
}
function recalcSumm() {
    var qty = $('.product-info-qs .select_number').find("input").val();
    var $price = $('.product-info-qs .price_info span.price');
    if ($price.length == 0) {
        $price = $('.product-info-qs .price_info span.price-new');
    }
    var summ =  parseInt( $price.html() );
    $('.product-info-qs .price-summ').remove();
    if(qty > 0) {
        var html = 'В сумме: ' + qty*summ + ' руб';
        $('<span class="price-summ">' + html + '</span>').insertAfter('.product-info-qs .select_number');
    }
}
jQuery(document).ready(function(){
    $(".product-info .price_info").on('DOMSubtreeModified', ".price", function () { 
        recalcSummPp();
    });
    $(".product-info-qs .price_info").on('DOMSubtreeModified', ".price", function () { 
        recalcSumm();
    });
});
//

function changeQtyPp(amount) {
    var $select_number = $('.product-info .select_number').find("input");
    var qty = 0;
    if(amount == 1) {
        qty = parseInt($select_number.val()) + amount;
    } else {
        qty = parseInt($select_number.val()) - 1;
    }

    if (qty > 0) {
        $select_number.val(qty);
    }
    recalcSummPp(); //
}
function changeQty(amount) {
    var $select_number = $('.product-info-qs .select_number').find("input");
    var qty = 0;
    if(amount == 1) {
        qty = parseInt($select_number.val()) + amount;
    } else {
        qty = parseInt($select_number.val()) - 1;
    }

    if (qty > 0) {
        $select_number.val(qty);
    }
    recalcSumm(); //
}
function StrToNum(a) {
    return (a-0);
}