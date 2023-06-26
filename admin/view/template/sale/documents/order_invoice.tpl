<?
if(isset($_GET['excel7'])){
  header("Pragma: public");
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Cache-Control: private", false);
  header("Content-Type: application/x-msexcel");
  header("Content-Disposition: attachment; filename=invoice-" . time() . ".xls;");
  header("Content-Transfer-Encoding: -binary");
}
?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $language; ?>"
xml:lang="<?php echo $language; ?>">
<head>
  <title><?php echo $title; ?></title>
  <link rel="stylesheet" type="text/css" href="view/template/sale/documents/order_invoice.stylesheet.css"/>
    <style type="text/css" media="print">
        @page {
            size: portrait;
        }
    </style>
</head>
<body>
  <?php
foreach ( $orders as $order ): ?>
  <div style="page-break-after: always; max-width: 830px">
    <div class="invoice-heading">
      <p>
        Внимание! Оплата данного счета означает согласие с условиями поставки товара. Уведомление об оплате
        обязательно, в противном случае не гарантируется наличие товара на складе. Товар отпускается по факту
        прихода денег на р/с Поставщика, самовывозом, при наличии доверенности и паспорта.<br/>
      </p>
    </div>
    <div class="invoice-body">
      <table class="invoice-company-info">
        <tr>
          <td rowspan="2" colspan="2">СБЕРБАНК РОССИИ ПАО Г. МОСКВА<br/><br/>Банк получателя</td>
          <td>БИК</td>
          <td rowspan="2">044525225<br/>30101810400000000225</td>
        </tr>
        <tr>
          <td>Сч. №</td>
        </tr>
        <tr>
          <td>ИНН 502919620199</td>
          <td>КПП</td>
          <td rowspan="2">Сч. №</td>
          <td rowspan="2">40802810140000117404</td>
        </tr>
        <tr>
          <td colspan="2">Индивидуальный предприниматель Подоляко Александр Валерьевич<br/><br/>Получатель</td>
        </tr>
      </table>
      <?php
      $date = strtotime($order['date_added']);
      setlocale(LC_ALL, 'ru_RU.UTF-8');
      ?>
      <h2 class="invoice-account">Счет-заказ № <?php echo $order['order_id']; ?> от <?php echo strftime('%d %B %Y', $date); ?> г.</h2>
      <table class="invoice-address-info">
        <tr>
          <td>Поставщик</td>
          <td>
            <b>Индивидуальный предприниматель Подоляко Александр Валерьевич, ИНН 502919620199, Московская обл., Мытищи, ул.Колпакова, дом № 40, корпус 3, кв.66, тел.: +7 (985) 092-92-91</b>
          </td>
        </tr>
        <tr></tr>
        <tr>
          <td>Грузоотправитель</td>
          <td>
            <b>Индивидуальный предприниматель Подоляко Александр Валерьевич, ИНН 502919620199, Московская обл., Мытищи, ул.Колпакова, дом № 40, корпус 3, кв.66, тел.: +7 (985) 092-92-91</b>
          </td>
        </tr>
        <tr></tr>
        <tr>
          <td>Покупатель</td>
          <td><b><?php echo $order['payment_address'] . ', тел.: ' . $order['telephone'] ?></b></td>
        </tr>
        <tr></tr>
        <tr>
          <td>Грузополучатель</td>
          <td><b><?php echo $order['payment_address'] . ', тел.: ' . $order['telephone'] ?></b></td>
        </tr>
      </table>
      <br/>
      <table class="invoice-products">
        <tr>
          <th>№</th>
          <th>Артикул</th>
          <th>Товары (работы, услуги)</th>
          <th>Кол-во</th>
          <th>Ед.</th>
          <th>Цена</th>
          <th>Сумма</th>
        </tr>
        <?php
      //setlocale(LC_ALL, 'en_US.UTF-8');
        $i = 0;
        $sum     = 0.00;
        foreach ( $order['product'] as $product ) : ?>
          <?php
          $i++;
          $clean_total = (float) str_replace( ',', '', $product['total'] );
          $sum += $clean_total;
          ?>
          <tr>
            <td style="text-align: center;"><?php echo $i; ?></td>
            <td><?php echo $product['model']; ?></td>
            <td>
              <?php echo $product['report_name']; ?>
              <?php foreach ( $product['option'] as $option ) : ?>
                <?php echo $option['value']; ?>
              <?php endforeach; ?>
            </td>
            <td style="text-align: right;"><?php echo $product['quantity']; ?></td>
            <td>шт</td>
            <td style="text-align: right;"><?php echo $product['price']; ?></td>
            <td style="text-align: right;"><?php echo $product['total']; ?></td>
          </tr>
        <?php endforeach; ?>
        <?php $sum = sprintf('%0.2f', $sum); ?>
      </table>
      <div style="float: right; font-weight: bold;">
        <table class="invoice-total">
          <tr>
            <td>Итого:</td>
            <td style="text-align: right;"><?php echo $sum ?></td>
          </tr>
          <tr>
            <td>Сумма НДС:</td>
            <td style="text-align: right;"></td>
          </tr>
          <tr>
            <td>Всего к оплате:</td>
            <td style="text-align: right;"><?php echo $sum; ?></td>
          </tr>
        </table>
      </div>
      <div style="clear: both"></div>
      <span class="invoice-total-names">Всего наименований <?php echo $i; ?>, на сумму <?php echo $sum; ?> руб.</span>
      <?php $sum_string = num2str($sum); ?>
      <span class="invoice-total-summ"><?php echo mb_strtoupper(mb_substr($sum_string, 0, 1)) . mb_substr($sum_string, 1); ?></span>
      <br/>
      <table class="invoice-posts">
        <tr style="height: 30px;">
          <th><b>Руководитель:</b></th>
          <td class="underscore" colspan="2"><b></b><span class="sign">должность</span></td>
          <td class="underscore" colspan="2"><span class="sign">подпись</span></td>
          <td class="underscore" colspan="2"><b>Подоляко А. В.</b><span class="sign">расшифровка подписи</span></td>
        </tr>
        <tr style="height: 30px;">
          <th><b>Главный (старший) бухгалтер:</b></th>
          <td colspan="2">&nbsp;</td>
          <td class="underscore" colspan="2"><span class="sign">подпись</span></td>
          <td class="underscore" colspan="2"><b>Подоляко А. В.</b><span class="sign">расшифровка подписи</span></td>
        </tr>
        <tr style="height: 30px;">
          <th><b>Ответственный:</b></th>
          <td colspan="2">&nbsp;</td>
          <td class="underscore" colspan="2"><span class="sign">подпись</span></td>
          <td class="underscore" colspan="2"><b>Подоляко А. В.</b><span class="sign">расшифровка подписи</span></td>
        </tr>
      </table>
    </div>
  </div>
<?php endforeach; ?>
</body>
</html>