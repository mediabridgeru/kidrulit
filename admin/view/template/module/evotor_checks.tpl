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
      <h1><img src="view/image/payment.png" alt="" /><?php echo $heading_title; ?></h1>
    </div>
    <div class="content">
      <table class="list">
      <thead>
        <tr>
            <th><?php echo $text_id; ?></th>
            <th><?php echo $text_order_id; ?></th>
            <th><?php echo $text_cashiername; ?></th>
            <th><?php echo $text_user; ?></th>
            <th><?php echo $text_email; ?></th>
            <th><?php echo $text_status; ?></th>
            <th><?php echo $text_date_created; ?></th>
            <th><?php echo $text_date_added; ?></th>
            <th><?php echo $text_checknum; ?></th>
            <th><?php echo $text_method; ?></th>
            <th><?php echo $text_electronicpayment; ?></th>
            <th><?php echo $text_cash; ?></th>
            <th><?php echo $text_type; ?></th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($viewstatuses as $viewstatus){   ?>
          <tr>
          <td><?php echo $viewstatus['id']?></td>
          <td><?php echo $viewstatus['order_id']?></td>
          <td><?php echo $viewstatus['cashiername']?></td>
          <td><?php echo $viewstatus['user']?></td>
          <td><?php echo $viewstatus['email']?></td>
          <td><?php if ($viewstatus['status'] == 0) { echo $text_status_wait; } else if($viewstatus['status'] == 1) { echo $text_status_ok; } else if($viewstatus['status'] == 2) { echo $text_status_error ;} else if($viewstatus['status'] == 3) { echo $text_status_curier; } else { echo $viewstatus['status']; } ?></td>
          <td><?php echo $viewstatus['date_created']?></td>
          <td><?php echo $viewstatus['date_added']?></td>
          <td><?php echo $viewstatus['checknum']?></td>
          <td><?php echo $viewstatus['method']?></td>
          <td><?php echo $viewstatus['electronicpayment']?></td>
          <td><?php echo $viewstatus['cash']?></td>
          <td><?php if ($viewstatus['type'] == 0) { echo $text_type_prihod; } else if($viewstatus['type'] == 1) { echo $text_type_return; } else { echo $viewstatus['type']; } ?></td>
          </tr>
        <?php }
        ?>
        </tbody>
        </table>

  </div>
</div>
</div>
</div>
<?php echo $footer; ?>