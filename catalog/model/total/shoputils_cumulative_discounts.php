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

class ModelTotalShoputilsCumulativeDiscounts extends Model {
    private $_tablename = 'shoputils_cumulative_discounts';
    private $_tablename_cmsdata = 'shoputils_cumulative_discounts_cmsdata';
    private $_tablename_to_store = 'shoputils_cumulative_discounts_to_store';
    private $_tablename_description = 'shoputils_cumulative_discounts_description';
    private $_tablename_to_customer_group = 'shoputils_cumulative_discounts_to_customer_group';

    public function getTotal(&$total_data, &$total, &$taxes) {
        if (!$this->config->get('shoputils_cumulative_discounts_status')){
            return;
        }

        if (!$this->customer->isLogged()){
            return;
        }

        if ($discount = $this->getLoggedCustomerDiscount()){
            $this->language->load('total/shoputils_cumulative_discounts');

            $products_total = $this->cart->getTotal();

            $discount_total = round($products_total * ($discount['percent'] / 100), 2);

            if ($discount_total > 0){
                $total_data[] = array(
                    'code'       => 'shoputils_cumulative_discounts',
                    'title'      => sprintf($this->language->get('text_cumulative_discounts'), $discount['percent']),
                    'text'       => '-' . $this->currency->format($discount_total),
                    'value'      => - $discount_total,
                    'sort_order' => $this->config->get('shoputils_cumulative_discounts_sort_order')
                  );
                  $total -= $discount_total;
            }
        };
    }

    public function getDiscountsCMSData($language_id){
        $query = $this->db->query("SELECT
            *
        FROM
            " . DB_PREFIX . $this->_tablename_cmsdata . "
        WHERE
            language_id='" . $language_id . "' AND store_id = '".$this->config->get('config_store_id')."'");
        if (isset($query->rows[0])){
            $rows = $query->rows[0];
        } else {
            $rows = array();
        }
        return $rows;
    }

    public function getDiscounts($store_id, $customer_group_id, $language_id, $sort_order = 'ASC'){
        $sql = 'SELECT
                    d.discount_id,
                    d.days,
                    d.summ,
                    d.percent,
                    dd.description
                FROM
                    '.DB_PREFIX . $this->_tablename . ' d
                LEFT JOIN
                    '.DB_PREFIX . $this->_tablename_description . ' dd ON (d.discount_id = dd.discount_id)
                LEFT JOIN
                    '.DB_PREFIX . $this->_tablename_to_store . ' d2s ON (d.discount_id = d2s.discount_id)
                LEFT JOIN
                    '.DB_PREFIX . $this->_tablename_to_customer_group . ' d2cg ON (d.discount_id = d2cg.discount_id)
                WHERE
                    d2s.store_id="' . $store_id . '" AND
                    d2cg.customer_group_id="' . $customer_group_id . '" AND
                    dd.language_id="' . $language_id . '" 
                ORDER BY 
                    d.percent '. $sort_order;
        
        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getCustomerDiscount($store_id, $customer_group_id, $language_id, $customer_id){
        if (!$this->config->get('shoputils_cumulative_discounts_statuses')){
            return false;
        }
        $discounts = $this->getDiscounts($store_id, $customer_group_id, $language_id, 'DESC');

        foreach ($discounts as $discount){
            //Search order
            $time = time() - $discount['days'] * 24 * 60 * 60;
            if ($time < 0) $time = 0;
            $date = date('Y-m-d H:i:s', $time);

            $sql = "SELECT SUM(op.total) as summ FROM `" . DB_PREFIX . "order_product` op, `". DB_PREFIX . "order` o WHERE
                o.order_id = op.order_id AND
                o.customer_id='" . $customer_id . "' AND
                o.store_id='" . $store_id . "' AND
                (
                    order_status_id IN (".$this->config->get('shoputils_cumulative_discounts_statuses').") AND
                    (date_added >= '" . $date . "' OR date_modified >= '" . $date . "')
                )

                GROUP BY o.customer_id";
            $query = $this->db->query($sql);


            if (isset($query->rows[0]['summ'])){
                if ($query->rows[0]['summ'] >= $discount['summ']){
                    return $discount;
                }
            }
        }
        return false;
    }

    function getLoggedCustomerDiscount(){

        return $this->getCustomerDiscount(
            (int)$this->config->get('config_store_id'),
            $this->customer->getCustomerGroupId() ? $this->customer->getCustomerGroupId() : $this->config->get('config_customer_group_id'),
            (int)$this->config->get('config_language_id'),
            $this->customer->getId()
        );
        
    }
    
}
?>