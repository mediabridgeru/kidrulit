<table style="width:100%;margin-bottom:5px;">
<tbody><tr><td style="text-align:center;font-family:arial;font-weight:bold;font-size:20px;color:#333;"><?php echo $title;?></td></tr></tbody>
</table>
<table style="width:100%;margin-bottom:20px;">
 <tbody>
 <?php $cols = 4; foreach ($products as $i => $product) { ?>
 <?php if( $i++%$cols == 0 ) { ?>
  <tr>
 <?php } ?>
  <td style="border:0;text-align:center;float:left;width:24%;padding:0.5%;">
   <div style="margin:0;border:1px solid #ebeef2;">
    <?php if ($product['thumb']) { ?>
    <div style="text-align:center;margin-top:5px;margin-bottom:5px;border:0px;">
     <a href="<?php echo $product['href']; ?>"><img style="max-width:100%;height:auto;display:block;margin-left:auto;margin-right:auto;" src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" /></a>
    </div>
    <?php } ?>
    <div style="text-align:center;font-size:14px;color:#333;height:38px;overflow:hidden;padding-left:10px;padding-right:10px;margin-bottom:5px;font-family:arial;line-height:1.3;"><a style="color:#222222;text-decoration:none;" href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
    <?php if ($product['price']) { ?>
     <div style="font-weight:bold;font-size:17px;margin-bottom:5px;">
     <?php if (!$product['special']) { ?>
      <?php echo $product['price']; ?>
     <?php } else { ?>
      <span style="font-weight:bold;font-size:15px;text-decoration:line-through;color:#E64B4B;"><?php echo $product['price']; ?></span> <span style="font-weight:bold;font-size:17px;"><?php echo $product['special']; ?></span>
     <?php } ?>
     </div>
    <?php } ?>
    <?php if ($product['rating']) { ?>
     <div style="margin:5px 0;"><img src="<?php echo $product['rating']; ?>" alt="" /></div>
    <?php } ?>
   </div>
  </td>
 <?php if (($i%$cols == 0) || ($i==count($products))) { ?>
  </tr>
 <?php } ?>				
 <?php } ?>
 </tbody>
</table>