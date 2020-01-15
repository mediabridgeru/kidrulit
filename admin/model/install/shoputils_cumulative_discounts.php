<?php
/*
 * Shoputils
 *
 * ПРИМЕЧАНИЕ К ЛИЦЕНЗИОННОМУ СОГЛАШЕНИЮ
 *
 * Этот файл связан лицензионным соглашением, которое можно найти в архиве,
 * вместе с этим файлом. Файл лицензии называется: LICENSE.1.5.x.RUS.txt
 * Так же лицензионное соглашение можно найти по адресу:
 * http://opencart.shoputils.ru/LICENSE.1.5.x.RUS.txt
 * 
 * =================================================================
 * OPENCART 1.5.x ПРИМЕЧАНИЕ ПО ИСПОЛЬЗОВАНИЮ
 * =================================================================
 *  Этот файл предназначен для Opencart 1.5.x. Shoputils не
 *  гарантирует правильную работу этого расширения на любой другой 
 *  версии Opencart, кроме Opencart 1.5.x. 
 *  Shoputils не поддерживает программное обеспечение для других 
 *  версий Opencart.
 * =================================================================
*/

class ModelInstallShoputilsCumulativeDiscounts extends Model {

    private $_version = '1.0.1';
    private $_tablename = 'shoputils_cumulative_discounts';
    private $_tablename_cmsdata = 'shoputils_cumulative_discounts_cmsdata';
    private $_tablename_to_store = 'shoputils_cumulative_discounts_to_store';
    private $_tablename_description = 'shoputils_cumulative_discounts_description';
    private $_tablename_to_customer_group = 'shoputils_cumulative_discounts_to_customer_group';
    
    public function install(){
        $this->load->model('setting/setting');
        $settings = $this->model_setting_setting->getSetting('shoputils_cumulative_discounts');

        if (!array_key_exists('version', $settings)){
            $query = $this->db->query("show tables like '".DB_PREFIX . $this->_tablename."'");
            if (!$query->rows){
                $sql = "CREATE TABLE `".DB_PREFIX . $this->_tablename."` (
                    `discount_id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
                    `days` INT NOT NULL DEFAULT '0',
                    `summ` DECIMAL( 11, 2 ) NOT NULL DEFAULT '0',
                    `percent` DECIMAL( 5, 2 ) NOT NULL ,
                    PRIMARY KEY ( `discount_id` )
                ) ENGINE = MYISAM COMMENT = 'Cumulative discounts'";
                $this->db->query($sql);

                $sql = "CREATE TABLE `". DB_PREFIX . $this->_tablename_to_store . "` (
                    `discount_id` INT( 11 ) NOT NULL ,
                    `store_id` INT( 11 ) NOT NULL
                ) ENGINE = MYISAM COMMENT = 'Cumulative discounts to store'";
                $this->db->query($sql);

                $sql = "ALTER TABLE `".DB_PREFIX . $this->_tablename_to_store."` ADD UNIQUE `IDX_".DB_PREFIX . $this->_tablename_to_store."` ( `discount_id` , `store_id` )";
                $this->db->query($sql);

                $sql = "CREATE TABLE `". DB_PREFIX . $this->_tablename_to_customer_group . "` (
                    `discount_id` INT( 11 ) NOT NULL ,
                    `customer_group_id` INT( 11 ) NOT NULL
                ) ENGINE = MYISAM COMMENT = 'Cumulative discounts to customer group'";
                $this->db->query($sql);

                $sql = "ALTER TABLE `".DB_PREFIX . $this->_tablename_to_customer_group."` ADD UNIQUE `IDX_".DB_PREFIX . $this->_tablename_to_customer_group."` ( `discount_id` , `customer_group_id` )";
                $this->db->query($sql);

                $sql = "CREATE TABLE `". DB_PREFIX . $this->_tablename_description . "` (
                    `discount_id` INT( 11 ) NOT NULL ,
                    `language_id` INT( 11 ) NOT NULL,
                    `description` text NOT NULL
                ) ENGINE = MYISAM COMMENT = 'Cumulative discounts descriptions'";
                $this->db->query($sql);

                $sql = "CREATE TABLE `". DB_PREFIX . $this->_tablename_cmsdata . "` (
                    `language_id` INT( 11 ) NOT NULL,
                    `store_id` INT( 11 ) DEFAULT 0,
                    `description_before` text NOT NULL,
                    `description_after` text NOT NULL
                ) ENGINE = MYISAM COMMENT = 'Cumulative discounts CMS data'";
                $this->db->query($sql);

                $sql = "ALTER TABLE `".DB_PREFIX . $this->_tablename_description."` ADD UNIQUE `IDX_".DB_PREFIX . $this->_tablename_description."` ( `discount_id` , `language_id` )";
                $this->db->query($sql);
            }
            $settings['version'] = $this->_version;
            $this->model_setting_setting->editSetting('shoputils_cumulative_discounts', $settings);
        }
    }
}
/* uninstall script
DROP TABLE IF EXISTS shoputils_cumulative_discounts_cmsdata;
DROP TABLE IF EXISTS oc_shoputils_cumulative_discounts;
DROP TABLE IF EXISTS oc_shoputils_cumulative_discounts_to_store;
DROP TABLE IF EXISTS oc_shoputils_cumulative_discounts_description;
DROP TABLE IF EXISTS oc_shoputils_cumulative_discounts_to_customer_group;
DELETE FROM oc_setting WHERE `group` = 'shoputils_cumulative_discounts';
*/
?>