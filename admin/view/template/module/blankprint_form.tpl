<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
<HTML>
    <HEAD>
    <META charset="utf-8">
	<link rel="stylesheet" href="view/stylesheet/blankprint_styles.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-1.7.1.min.js"></script>

    </HEAD>
<BODY>
	<form name="printblank" method="post" target="_blank" action="../system/blankprint/index.php">
	
		<br><input name="products" type="hidden" value=<?php echo str_replace(" ","&@",serialize($products))?>>
		<input name="bkey" type="hidden" value=<?php echo $bkey; ?>>
			<h1 style="position: absolute;  top: -5;left: 100;">Интернет-магазин</h1>
			
			<div>
				<br><input name="shop_name" type="hidden" size="40">
				<br><input name="shop_phone" type="hidden" size="10" >
			</div>
			<div>
				<br><input name="shop_index" type="hidden" size="6" >
				<br><input name="shop_addr" rows="3" type="hidden">
			</div>
			<div class="fiz" style="height: 220px;">

				<br><input name="shop_document_name" type="hidden" size="13">
				<input name="shop_document_seria" type="hidden" > 
				<input name="shop_document_nomer" type="hidden" >
				<br><input name="shop_document_kemv" rows="2" type="hidden">
				<br><input name="shop_document_datav"  size="13" type="hidden">
			</div>
			<input type='hidden' name='layout_id'  value='0'>
			<div class="jur">

				<br><input name="shop_inn" type="hidden" size="15">
				<br><input name="shop_bank_name" type="hidden" size="25"> 
				<br><input name="shop_bank_ks" type="hidden" size="15">
				<br><input name="shop_bank_rs" type="hidden" size="15">
				<br><input name="shop_bank_bik" type="hidden" size="15">
			</div>
		
		<div class="sol-left">
		<h1 style="position: absolute;  top: -38;left:100;">Покупатель</h1> 
		
			<select id="profiles" style='position: absolute;top: -55;left: -0;'> 
			</select>
			<div>
				<label >ФИО</label>
				<br><input name="client_name" type="text" size="40" value="<?php echo $client_name; ?>">
				<br><label >Телефон</label>
				<br><input name="client_phone" type="text" size="10" value="<?php echo $client_phone; ?>">
			</div>
			<div>
				<br><label for="index">Индекс</label>
				<br><input name="client_index" type="index" size="6" value="<?php echo $client_index; ?>">
				<input name="client_city" type="hidden" value="<?php echo $client_city; ?>">
				<br><label for="addres">Адрес</label>
				<br><textarea name="client_addr" rows="3" ><?php echo $client_addr; ?></textarea>
			</div>			
		</div>
		<div class="summa" style="left:20;"> 
			<div>
				<label >Сумма объявленной ценности, руб.</label>
				<br><input name="sum_ob" type="text" size="10">
				<br><label >Сумма наложенного платежа, руб.</label>
				<br><input name="sum_nal" type="text" size="10">
				<br>
			</div>	
		</div>	
		
		<div id="blanks_btns" style="position: absolute; top: 0; left: 310; width: 322px;">	
		</div>					
	</form>

<script type="text/javascript" >
$(document).ready(function() {
    var settings = <?php echo json_encode($settings);?>;
    var profiles = <?php echo json_encode($profiles);?>;

    if (settings['typesum'] == 'auto') {
        document.getElementsByName("sum_nal")[0].value = 0;
        document.getElementsByName("sum_ob")[0].value = 10;
    }

    $.each(profiles, function(i,v) {
        if ($.isNumeric(i))
            $('#profiles').append('<option value="' + i + '">' + ((v.typejf == 'fiz') ? "Физ. лицо: ":"Юр. лицо: ") + v.shop_name + '</option>');
	});

    $('#profiles').change(function() {
        var v = $('#profiles').val();
        if ((v != null) && ($.isNumeric(v))){
            if (profiles[v]['typejf'] == 'fiz') {$('.jur').hide(); $('.fiz').show();} else {$('.jur').show(); $('.fiz').hide();}
        }
        else {
            $('.jur').hide(); $('.fiz').show();
        }

        if (v) {
            $.each(profiles[v], function(k,vv) {
                if (k != 'typejf')  {
                    document.getElementsByName(k)[0].value = vv;
                }
            });
        }
    });

    var n = {
		 new_b7p_112:"Наклейка на коробку + Прием почтового перевода [1xA5+1xA5=A4]",
		 new_b7p_6a:"ф.7-п - Наклейка на коробку [1xA6=A4]",
 		 b112116:"ф.112ЭП + ф.116 - Посылка с наложенным платежом [2xA5=A4]",
		 b112ep:"ф.112ЭП - Прием почтового перевода [A4]",
		 b112_a5:"ф.112ЭП - Прием почтового перевода [1xA5=A4]",
		 b116:"ф.116 - Сопроводительный адрес к посылке [A4]",
		 b116_2:"ф.116 - Сопроводительный адрес к посылке [2xA4]",
		 b116_origin:"ф.116 - Сопроводительный адрес к посылке [2xA5=1xA4]",
		 b116_2_a5:"ф.116 - Сопроводительный адрес к посылке [2xA5=2xA4]",
		 o107:"ф.107 - Опись содержимого в посылке [2xA5=A4]",
		 b7a:"ф.7-a - Первый класс [1xA6=A4]",
		 b7b:"ф.7-б - Бандероль [1xA6=A4]",
		 new_b7p_p:"Новая ф.7-п - Наклейка на коробку [1xA5=A4]",
		 new_b7p_b:"Новая ф.7-п - Наклейка на бандероль [1xA5=A4]",
		 new_b7a_p:"Новая ф.7-а - Наклейка на письмо (первый класс) [1xA5=A4]",
		 new_b7a_b:"Новая ф.7-а - Наклейка на бандероль (первый класс) [1xA5=A4]",
		 b7p:"ф.7-п - Наклейка на коробку [1xA6=A4]",				
		 b7p2:"ф.7-п - Наклейка на коробку [1xA5=A4]",
		 bcn23:"ф.CN23 - Таможенная декларация [1xA5=A4]",
		 bcp71:"ф.CP71 - Сопроводительный адрес к посылке за границу [1xA5=A4]",
		 sticker:"Универсальная наклейка [1xA6=A4]",
		 sticker_2:"Универсальная наклейка с полным адресом [1xA6=A4]",
		 bfind:"Заявление на розыск внутренних отправлений [A4]"}; 


    function reverseForIn(obj, f) {
      var arr = [];
      for (var key in obj) {
        // add hasOwnPropertyCheck if needed
        arr.push(key);
      }
      for (var i=arr.length-1; i>=0; i--) {
        f.call(obj, arr[i]);
      }
    }

    reverseForIn(settings['blanks'], function(key){
        if (this[key] == 'on')
            $('#blanks_btns').append('<button style="width:100%; height:100%;" name="blank_type" value="' + key + '" type="submit">' + n[key] + '</button>');
    });

    $('#profiles').change();

    if (profiles.length == 0) {
        alert("Заполните профиль интернет-магазина в настройках модуля: Дополнения -> Модули -> Почта России - Печать почтовых бланков");
    }

});
</script>
</BODY>
</HTML>