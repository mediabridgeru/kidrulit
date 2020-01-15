<?php echo $header; ?>
<style>
.list th{
border:1px solid;
}
</style>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="box">    
    <div class="heading">
      <h1><img src="view/image/payment.png" alt="" /><?php echo $status_title ?> <?php echo $heading_title; ?></h1>
    </div>
    <div class="content">
      <table class="list">
      <thead>
        <tr>
            <th>ID</th>
            <th>Номер заказа</th>
            <th>Сумма</th>
            <th>Пользователь</th>
            <th>email</th>
            <th>Дата создания</th>
            <th>Дата оплаты</th>
            <th>Идентификатор операции</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($viewstatuses as $viewstatus){   ?>
          <tr>
          <td><?php echo $viewstatus['yandex_id']?></td>
          <td><?php echo $viewstatus['num_order']?></td>
          <td><?php echo $viewstatus['sum']?></td>
          <td><?php echo $viewstatus['user']?></td>
          <td><?php echo $viewstatus['email']?></td>
          <td><?php echo $viewstatus['date_created']?></td>
          <td><?php echo $viewstatus['date_enroled']?></td>
          <td><?php echo $viewstatus['sender']?></td>
          </tr>
        <?php }
        ?>
        </tbody>
        </table>

  </div>
</div>
</div>
<?php echo $footer; ?> 

