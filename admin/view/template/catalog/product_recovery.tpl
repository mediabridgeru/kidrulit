<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a
                href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
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
            <h1><img src="view/image/product.png" alt=""/> <?php echo $heading_title; ?></h1>
            <div class="buttons ">
            </div>
        </div>
        <div class="content">
            <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
                <input hidden id="page" value="1">
                <input hidden id="sort" value="pd.name">
                <input hidden id="order" value="ASC">
                <h2>Товары с отрицательным количеством</h2>
                <?php if ($negative_products) { ?>
                <table class="list">
                    <thead>
                    <tr>
                        <td width="40" style="text-align: center;">№</td>
                        <td>ID товара</td>
                        <td>модель</td>
                        <td>Описание</td>
                        <td>Количество товара</td>
                        <td>Количество товара в группе</td>
                        <td class="right">Действия</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($negative_products as $p => $product) : ?>
                    <tr>
                        <td style="text-align: center;"><?php echo ($p+1); ?></td>
                        <td class="left"><?php echo $product['product_id']; ?></td>
                        <td class="left"><?php echo $product['model']; ?></td>
                        <td class="left"><?php echo $product['description']; ?></td>
                        <td class="left"><?php echo $product['product_quantity']; ?></td>
                        <td class="left"><?php echo $product['quantity']; ?></td>
                        <td class="right"><a href="<?php echo $product['href']; ?>" target="_blank">Изменить</a></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="10">Всего товаров: <?php echo ($p+1); ?></td>
                    </tr>
                    </tfoot>
                </table>
                <?php } else { ?>
                <p><?php echo $text_no_results; ?></p>
                <?php } ?>

                <h2>Товары без ГТД и опций</h2>
                <?php if ($simple_products) { ?>
                <table class="list">
                    <thead>
                    <tr>
                        <td width="40" style="text-align: center;">№</td>
                        <td>ID товара</td>
                        <td>модель</td>
                        <td>Описание</td>
                        <td>Количество товара</td>
                        <td>Количество товара в группе</td>
                        <td class="right">Действия</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($simple_products as $p => $product) : ?>
                    <tr>
                        <td style="text-align: center;"><?php echo ($p+1); ?></td>
                        <td class="left"><?php echo $product['product_id']; ?></td>
                        <td class="left"><?php echo $product['model']; ?></td>
                        <td class="left"><?php echo $product['description']; ?></td>
                        <td class="left"><?php echo $product['product_quantity']; ?></td>
                        <td class="left"><?php echo $product['quantity']; ?></td>
                        <td class="right"><a href="<?php echo $product['href']; ?>" target="_blank">Изменить</a></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="10">Всего товаров: <?php echo ($p+1); ?></td>
                    </tr>
                    </tfoot>
                </table>
                <?php } else { ?>
                <p><?php echo $text_no_results; ?></p>
                <?php } ?>

                <h2>Товары без ГТД с опциями</h2>
                <?php if ($option_products) { ?>
                <table class="list">
                    <thead>
                    <tr>
                        <td width="40" style="text-align: center;">№</td>
                        <td>ID товара</td>
                        <td>модель</td>
                        <td>Описание</td>
                        <td>Количество товара</td>
                        <td>Количество товара в группе</td>
                        <td class="right">Действия</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($option_products as $p => $product) { ?>
                    <tr>
                        <td style="text-align: center;"><?php echo ($p+1); ?></td>
                        <td class="left"><?php echo $product['product_id']; ?></td>
                        <td class="left"><?php echo $product['model']; ?></td>
                        <td class="left"><?php echo $product['description']; ?></td>
                        <td class="left"><?php echo $product['product_quantity']; ?></td>
                        <td class="left"><?php echo $product['quantity']; ?></td>
                        <td class="right"><a href="<?php echo $product['href']; ?>" target="_blank">Изменить</a></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="10">Всего товаров: <?php echo ($p+1); ?></td>
                    </tr>
                    </tfoot>
                </table>
                <?php } else { ?>
                <p><?php echo $text_no_results; ?></p>
                <?php } ?>

                <h2>Товары с ГТД без опций</h2>
                <?php if ($simple_gtd_products) { ?>
                <table class="list">
                    <thead>
                    <tr>
                        <td width="40" style="text-align: center;">№</td>
                        <td>ID товара</td>
                        <td>модель</td>
                        <td>Описание</td>
                        <td>Количество товара</td>
                        <td>Количество товара в группе</td>
                        <td class="right">Действия</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($simple_gtd_products as $p => $product) { ?>
                    <tr>
                        <td style="text-align: center;"><?php echo ($p+1); ?></td>
                        <td class="left"><?php echo $product['product_id']; ?></td>
                        <td class="left"><?php echo $product['model']; ?></td>
                        <td class="left"><?php echo $product['description']; ?></td>
                        <td class="left"><?php echo $product['product_quantity']; ?></td>
                        <td class="left"><?php echo $product['quantity']; ?></td>
                        <td class="right"><a href="<?php echo $product['href']; ?>" target="_blank">Изменить</a></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="10">Всего товаров: <?php echo ($p+1); ?></td>
                    </tr>
                    </tfoot>
                </table>
                <?php } else { ?>
                <p><?php echo $text_no_results; ?></p>
                <?php } ?>

                <h2>Товары с ГТД и опциями</h2>
                <?php if ($option_gtd_products) { ?>
                <table class="list">
                    <thead>
                    <tr>
                        <td width="40" style="text-align: center;">№</td>
                        <td>ID товара</td>
                        <td>модель</td>
                        <td>Описание</td>
                        <td>Количество товара</td>
                        <td>Количество товара в группе</td>
                        <td class="right">Действия</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($option_gtd_products as $p => $product) { ?>
                    <tr>
                        <td style="text-align: center;"><?php echo ($p+1); ?></td>
                        <td class="left"><?php echo $product['product_id']; ?></td>
                        <td class="left"><?php echo $product['model']; ?></td>
                        <td class="left"><?php echo $product['description']; ?></td>
                        <td class="left"><?php echo $product['product_quantity']; ?></td>
                        <td class="left"><?php echo $product['quantity']; ?></td>
                        <td class="right"><a href="<?php echo $product['href']; ?>" target="_blank">Изменить</a></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="10">Всего товаров: <?php echo ($p+1); ?></td>
                    </tr>
                    </tfoot>
                </table>
                <?php } else { ?>
                <p><?php echo $text_no_results; ?></p>
                <?php } ?>
            </form>
        </div>
        <div class="bottom">
            <h1><img src="view/image/product.png" alt=""/> <?php echo $heading_title; ?></h1>
        </div>
    </div>
    <?php echo $footer; ?>