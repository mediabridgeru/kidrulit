<?php if (($has_oauth_token || $kassa->getShopId()) && $isConnectionFailed && $kassa->isEnabled()) : ?>
    <div class="col-sm-offset-3 alert alert-danger"><i
                class="fa fa-exclamation-circle"></i> <?= $lang->get('kassa_auth_connection_error') ?>
    </div>
    <div class="row">
        <div class="col-sm-offset-3 col-sm-9 form-group">
            <button class="btn btn-warning btn_oauth_connect qa-yookassa-entrance ">
                <?= $lang->get('kassa_auth_connect_to_kassa') ?>
            </button>
        </div>
    </div>
<?php elseif ($has_oauth_token) : ?>
    <div class="col-sm-offset-3 col-sm-9 qa-oauth-info">

        <?php if ($kassa->isEnabled()) : ?>
            <p class="qa-shop-type" data-qa-shop-type="<?= $is_test_shop ? 'test' : 'prod' ?>">
                <?= $is_test_shop ? $lang->get('kassa_auth_test_shop') : $lang->get('kassa_auth_real_shop') ?>
            </p>
        <?php endif ?>

        <?php if ($kassa->getShopId()) : ?>
        <p class="qa-shop-id" data-qa-shop-id="<?= $kassa->getShopId() ?>">Shop ID: <?= $kassa->getShopId() ?></p>
        <?php endif ?>

        <?php if ($is_test_shop && $kassa->isEnabled()) : ?>
        <p style="margin-top: 20px;"><?= $lang->get('kassa_auth_switch_mode') ?></p>
        <?php endif ?>

    </div>

    <div class="row">
        <div class="col-sm-offset-3 col-sm-9 form-group">
            <button class="btn btn-warning btn_oauth_connect qa-change-shop-button ">
                <?= $lang->get('kassa_auth_change_btn_title') ?>
            </button>
        </div>
    </div>
<?php elseif ($kassa->getShopId()) : ?>
    <div class="row">
        <h4 class="form-heading"><?php echo $lang->get('kassa_auth_connect_title'); ?></h4>
        <div class="col-md-12">
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="yoomoney_kassa_shop_id" class="col-sm-3 control-label">
                        <?php echo $lang->get('kassa_shop_id_label'); ?>
                    </label>
                    <div class="col-sm-9">
                        <input name="yoomoney_kassa_shop_id" type="text" class="form-control" id="yoomoney_kassa_shop_id"
                               value="<?php echo htmlspecialchars($kassa->getShopId()); ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="yoomoney_kassa_password" class="col-sm-3 control-label">
                        <?php echo $lang->get('kassa_password_label'); ?>
                    </label>
                    <div class="col-sm-9">
                        <input name="yoomoney_kassa_password" type="text" class="form-control" id="yoomoney_kassa_password"
                               value="<?php echo htmlspecialchars($kassa->getPassword()); ?>" />
                        <p class="help-block"><?= $lang->get('kassa_auth_help') ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-offset-3 col-sm-9 form-group">
            <button class="btn btn-warning btn_oauth_connect qa-change-shop-button ">
                <?= $lang->get('kassa_auth_change_btn_title') ?>
            </button>
        </div>
    </div>
<?php else : ?>
    <div class="row">
        <div class="col-sm-offset-3 col-md-6">
            <h3><?= $lang->get('kassa_auth_connect_title') ?></h3>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-offset-3 col-sm-9 form-group">
            <button class="btn btn-warning btn_oauth_connect qa-connect-shop-button ?> ">
                <?= $lang->get('kassa_auth_connect_btn_title') ?>
            </button>
        </div>
    </div>
<?php endif ?>


<div class="row hidden auth-error-alert">
    <div class="col-sm-offset-3 warning"><i class="fa fa-exclamation-circle"></i>
        <?= $lang->get('kassa_auth_connect_error') ?>
    </div>
</div>

<script>
    jQuery(document).ready(function () {

        /**
         * Событие на кнопки Подключить магазин и Сменить магазин
         */
        jQuery(document).on('click', 'button.btn_oauth_connect', function (e) {
            jQuery(this).attr('disabled', true);
            jQuery(this).text('');
            jQuery(this).html('<span class="glyphicon glyphicon-hourglass qa-spinner" aria-hidden="true"></span>');
            e.preventDefault();
            fetchOauthLink();
        })

        /**
         * Запрос на бэк для получения ссылки на авторизацию в OAuth
         */
        function fetchOauthLink() {
            jQuery.ajax({
                url: "<?= $oauth_connect_url ?>",
                dataType: "json",
                method: "GET",
                success: function (response) {
                    const responseData = JSON.parse(response);
                    showOauthWindow(responseData.oauth_url);
                },
                error: function(jqXHR, textStatus, error){
                    showError();
                    if (typeof jqXHR.responseJSON == "undefined") {
                        console.error(jqXHR, textStatus, error);
                        return;
                    }
                    console.error(jqXHR.responseJSON, textStatus, error);
                }
            });
        }

        /**
         * Показ окна с авторизацией в OAuth
         * @param url - Ссылка в OAuth
         */
        function showOauthWindow(url) {
            const oauthWindow = window.open(
                url,
                'Авторизация',
                'width=600,height=600, top='+((screen.height-600)/2)+', left='+((screen.width-600)/2 + window.screenLeft)+', menubar=no, toolbar=no, location=no, resizable=yes, scrollbars=no, status=yes');

            const timer = setInterval(function() {
                if(oauthWindow.closed) {
                    if(oauthWindow.closed) {
                        clearInterval(timer);
                        getOauthToken();
                    }
                }
            }, 1000);
        }

        /**
         * Инициализация получения OAuth токена
         */
        function getOauthToken() {
            jQuery.ajax({
                url: "<?= $oauth_token_url ?>",
                dataType: "json",
                method: "GET",
                success: function (response) {
                    location.reload();
                },
                error: function(jqXHR, textStatus, error){
                    showError();
                    if (typeof jqXHR.responseJSON == "undefined") {
                        console.error(jqXHR, textStatus, error);
                        return;
                    }
                    console.error(jqXHR.responseJSON, textStatus, error);
                }
            });
        }

        function showError() {
            jQuery('.auth-error-alert').removeClass('hidden');
        }
    })
</script>