<?php
include_once(DIR_APPLICATION . "/controller/sale/xlsxwriter.class.php");

require DIR_ROOT.'/vendors/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Html;

class ControllerSaleOrder extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('sale/order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/order');

        $this->load->helper('spreadsheet');

		$this->getList();
	}

    public function insert() {
    	$this->language->load('sale/order');

    	$this->document->setTitle($this->language->get('heading_title'));

    	$this->load->model('sale/order');

    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
    		$this->model_sale_order->addOrder($this->request->post);

    		$this->session->data['success'] = $this->language->get('text_success');

    		$url = '';

    		if (isset($this->request->get['filter_order_id'])) {
    			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
    		}

    		if (isset($this->request->get['filter_customer'])) {
    			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
    		}

    		if (isset($this->request->get['filter_order_status_id'])) {
    			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
    		}

    		if (isset($this->request->get['filter_total'])) {
    			$url .= '&filter_total=' . $this->request->get['filter_total'];
    		}

    		if (isset($this->request->get['filter_date_added'])) {
    			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
    		}

    		if (isset($this->request->get['filter_date_modified'])) {
    			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
    		}

    		if (isset($this->request->get['sort'])) {
    			$url .= '&sort=' . $this->request->get['sort'];
    		}

    		if (isset($this->request->get['order'])) {
    			$url .= '&order=' . $this->request->get['order'];
    		}

    		if (isset($this->request->get['page'])) {
    			$url .= '&page=' . $this->request->get['page'];
    		}

    		$this->redirect($this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}

    	$this->getForm();
    }

    public function update() {
    	$this->language->load('sale/order');

    	$this->document->setTitle($this->language->get('heading_title'));

    	$this->load->model('sale/order');

    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
    		$this->model_sale_order->editOrder($this->request->get['order_id'], $this->request->post);

    		$this->session->data['success'] = $this->language->get('text_success');

    		$url = '';

    		if (isset($this->request->get['filter_order_id'])) {
    			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
    		}

    		if (isset($this->request->get['filter_customer'])) {
    			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
    		}

    		if (isset($this->request->get['filter_order_status_id'])) {
    			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
    		}

    		if (isset($this->request->get['filter_total'])) {
    			$url .= '&filter_total=' . $this->request->get['filter_total'];
    		}

    		if (isset($this->request->get['filter_date_added'])) {
    			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
    		}

    		if (isset($this->request->get['filter_date_modified'])) {
    			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
    		}

    		if (isset($this->request->get['sort'])) {
    			$url .= '&sort=' . $this->request->get['sort'];
    		}

    		if (isset($this->request->get['order'])) {
    			$url .= '&order=' . $this->request->get['order'];
    		}

    		if (isset($this->request->get['page'])) {
    			$url .= '&page=' . $this->request->get['page'];
    		}

    		$this->redirect($this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}

    	$this->getForm();
    }

    public function delete() {
    	$this->language->load('sale/order');

    	$this->document->setTitle($this->language->get('heading_title'));

    	$this->load->model('sale/order');

    	if (isset($this->request->post['selected']) && ($this->validateDelete())) {
    		foreach ($this->request->post['selected'] as $order_id) {
    			$this->model_sale_order->deleteOrder($order_id);
    		}

    		$this->session->data['success'] = $this->language->get('text_success');

    		$url = '';

    		if (isset($this->request->get['filter_order_id'])) {
    			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
    		}

    		if (isset($this->request->get['filter_customer'])) {
    			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
    		}

    		if (isset($this->request->get['filter_order_status_id'])) {
    			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
    		}

    		if (isset($this->request->get['filter_total'])) {
    			$url .= '&filter_total=' . $this->request->get['filter_total'];
    		}

    		if (isset($this->request->get['filter_date_added'])) {
    			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
    		}

    		if (isset($this->request->get['filter_date_modified'])) {
    			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
    		}

    		if (isset($this->request->get['sort'])) {
    			$url .= '&sort=' . $this->request->get['sort'];
    		}

    		if (isset($this->request->get['order'])) {
    			$url .= '&order=' . $this->request->get['order'];
    		}

    		if (isset($this->request->get['page'])) {
    			$url .= '&page=' . $this->request->get['page'];
    		}

    		$this->redirect($this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}

    	$this->getList();
    }

    protected function getList() {
        $this->load->helper('spreadsheet');

    	if (isset($this->request->get['filter_order_id'])) {
    		$filter_order_id = $this->request->get['filter_order_id'];
    	} else {
    		$filter_order_id = null;
    	}

    	if (isset($this->request->get['filter_customer'])) {
    		$filter_customer = $this->request->get['filter_customer'];
    	} else {
    		$filter_customer = null;
    	}

    	if (isset($this->request->get['filter_order_status_id'])) {
    		$filter_order_status_id = $this->request->get['filter_order_status_id'];
    	} else {
    		$filter_order_status_id = null;
    	}

    	if (isset($this->request->get['filter_total'])) {
    		$filter_total = $this->request->get['filter_total'];
    	} else {
    		$filter_total = null;
    	}

    	if (isset($this->request->get['filter_date_added'])) {
    		$filter_date_added = $this->request->get['filter_date_added'];
    	} else {
    		$filter_date_added = null;
    	}

    	if (isset($this->request->get['filter_date_modified'])) {
    		$filter_date_modified = $this->request->get['filter_date_modified'];
    	} else {
    		$filter_date_modified = null;
    	}

    	if (isset($this->request->get['sort'])) {
    		$sort = $this->request->get['sort'];
    	} else {
    		$sort = 'o.order_id';
    	}

    	if (isset($this->request->get['order'])) {
    		$order = $this->request->get['order'];
    	} else {
    		$order = 'DESC';
    	}

    	if (isset($this->request->get['page'])) {
    		$page = $this->request->get['page'];
    	} else {
    		$page = 1;
    	}

    	$url = '';

    	if (isset($this->request->get['filter_order_id'])) {
    		$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
    	}

    	if (isset($this->request->get['filter_customer'])) {
    		$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
    	}

    	if (isset($this->request->get['filter_order_status_id'])) {
    		$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
    	}

    	if (isset($this->request->get['filter_total'])) {
    		$url .= '&filter_total=' . $this->request->get['filter_total'];
    	}

    	if (isset($this->request->get['filter_date_added'])) {
    		$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
    	}

    	if (isset($this->request->get['filter_date_modified'])) {
    		$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
    	}

    	if (isset($this->request->get['sort'])) {
    		$url .= '&sort=' . $this->request->get['sort'];
    	}

    	if (isset($this->request->get['order'])) {
    		$url .= '&order=' . $this->request->get['order'];
    	}

    	if (isset($this->request->get['page'])) {
    		$url .= '&page=' . $this->request->get['page'];
    	}

    	$this->data['breadcrumbs'] = array();

    	$this->data['breadcrumbs'][] = array(
    		'text'      => $this->language->get('text_home'),
    		'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
    		'separator' => false
    	);

    	$this->data['breadcrumbs'][] = array(
    		'text'      => $this->language->get('heading_title'),
    		'href'      => $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL'),
    		'separator' => ' :: '
    	);

    	$this->data['invoice'] = $this->url->link('sale/order/invoice', 'token=' . $this->session->data['token'], 'SSL');
    	$this->data['insert'] = $this->url->link('sale/order/insert', 'token=' . $this->session->data['token'], 'SSL');
    	$this->data['delete'] = $this->url->link('sale/order/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

    	$this->data['orders'] = array();

    	$data = array(
    		'filter_order_id'        => $filter_order_id,
    		'filter_customer'	     => $filter_customer,
    		'filter_order_status_id' => $filter_order_status_id,
    		'filter_total'           => $filter_total,
    		'filter_date_added'      => $filter_date_added,
    		'filter_date_modified'   => $filter_date_modified,
    		'sort'                   => $sort,
    		'order'                  => $order,
    		'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
    		'limit'                  => $this->config->get('config_admin_limit')
    	);

    	$order_total = $this->model_sale_order->getTotalOrders($data);

    	$results = $this->model_sale_order->getOrders($data);

    	foreach ($results as $result) {
    		$cdek = '';

    		if (stripos($result['shipping_code'], "cdek") !== false) {
    			$cdek = $result['cdek'];
    		}

            $cost = '';

            if ($result['shipping_cost'] > 0) {
                $cost = $result['shipping_cost'];
            }

    		$action = array();

    		$action[] = array(
    			'text' => $this->language->get('text_view'),
    			'href' => $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, 'SSL')
    		);


    		$action[] = array(
    			'text' => $this->language->get('text_waybill'),
    			'href' => $this->url->link('sale/waybill/index', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, 'SSL')
    		);



    		if (strtotime($result['date_added']) > strtotime('-' . (int)$this->config->get('config_order_edit') . ' day')) {
    			$action[] = array(
    				'text' => $this->language->get('text_edit'),
    				'href' => $this->url->link('sale/order/update', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, 'SSL')
    			);
    		}

    		$this->data['orders'][] = array(
    			'order_id'      => $result['order_id'],
    			'customer'      => $result['customer'],
    			'status'        => $result['status'],
    			'status_id'		=> $result['order_status_id'],
                'tasks'         => $result['tasks'],
                'cost'          => $cost,
    			'cdek'          => $cdek,
    			'total'         => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
    			'date_added'    => date($this->language->get('date_format_time'), strtotime($result['date_added'])),
    			'date_modified' => date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
    			'selected'      => isset($this->request->post['selected']) && in_array($result['order_id'], $this->request->post['selected']),
    			'action'        => $action
    		);
    	}

    	$this->data['heading_title'] = $this->language->get('heading_title');

    	$this->data['text_no_results'] = $this->language->get('text_no_results');
    	$this->data['text_missing'] = $this->language->get('text_missing');

    	$this->data['column_order_id'] = $this->language->get('column_order_id');
    	$this->data['column_customer'] = $this->language->get('column_customer');
    	$this->data['column_status'] = $this->language->get('column_status');
    	$this->data['column_total'] = $this->language->get('column_total');
    	$this->data['column_date_added'] = $this->language->get('column_date_added');
    	$this->data['column_date_modified'] = $this->language->get('column_date_modified');
    	$this->data['column_action'] = $this->language->get('column_action');

    	$this->data['button_invoice'] = $this->language->get('button_invoice');
    	$this->data['button_insert'] = $this->language->get('button_insert');
    	$this->data['button_delete'] = $this->language->get('button_delete');
    	$this->data['button_filter'] = $this->language->get('button_filter');

    	$this->data['token'] = $this->session->data['token'];

    	if (isset($this->error['warning'])) {
    		$this->data['error_warning'] = $this->error['warning'];
    	} else {
    		$this->data['error_warning'] = '';
    	}

    	if (isset($this->session->data['success'])) {
    		$this->data['success'] = $this->session->data['success'];

    		unset($this->session->data['success']);
    	} else {
    		$this->data['success'] = '';
    	}

    	$url = '';

    	if (isset($this->request->get['filter_order_id'])) {
    		$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
    	}

    	if (isset($this->request->get['filter_customer'])) {
    		$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
    	}

    	if (isset($this->request->get['filter_order_status_id'])) {
    		$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
    	}

    	if (isset($this->request->get['filter_total'])) {
    		$url .= '&filter_total=' . $this->request->get['filter_total'];
    	}

    	if (isset($this->request->get['filter_date_added'])) {
    		$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
    	}

    	if (isset($this->request->get['filter_date_modified'])) {
    		$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
    	}

    	if ($order == 'ASC') {
    		$url .= '&order=DESC';
    	} else {
    		$url .= '&order=ASC';
    	}

    	if (isset($this->request->get['page'])) {
    		$url .= '&page=' . $this->request->get['page'];
    	}

    	$this->data['sort_order'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.order_id' . $url, 'SSL');
    	$this->data['sort_customer'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=customer' . $url, 'SSL');
    	$this->data['sort_status'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
    	$this->data['sort_total'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.total' . $url, 'SSL');
    	$this->data['sort_date_added'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.date_added' . $url, 'SSL');
    	$this->data['sort_date_modified'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.date_modified' . $url, 'SSL');

    	$url = '';

    	if (isset($this->request->get['filter_order_id'])) {
    		$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
    	}

    	if (isset($this->request->get['filter_customer'])) {
    		$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
    	}

    	if (isset($this->request->get['filter_order_status_id'])) {
    		$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
    	}

    	if (isset($this->request->get['filter_total'])) {
    		$url .= '&filter_total=' . $this->request->get['filter_total'];
    	}

    	if (isset($this->request->get['filter_date_added'])) {
    		$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
    	}

    	if (isset($this->request->get['filter_date_modified'])) {
    		$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
    	}

    	if (isset($this->request->get['sort'])) {
    		$url .= '&sort=' . $this->request->get['sort'];
    	}

    	if (isset($this->request->get['order'])) {
    		$url .= '&order=' . $this->request->get['order'];
    	}

    	$pagination = new Pagination();
    	$pagination->total = $order_total;
    	$pagination->page = $page;
    	$pagination->limit = $this->config->get('config_admin_limit');
    	$pagination->text = $this->language->get('text_pagination');
    	$pagination->url = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

    	$this->data['pagination'] = $pagination->render();

    	$this->data['filter_order_id'] = $filter_order_id;
    	$this->data['filter_customer'] = $filter_customer;
    	$this->data['filter_order_status_id'] = $filter_order_status_id;
    	$this->data['filter_total'] = $filter_total;
    	$this->data['filter_date_added'] = $filter_date_added;
    	$this->data['filter_date_modified'] = $filter_date_modified;

    	$this->load->model('localisation/order_status');

    	$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

    	$this->data['sort'] = $sort;
    	$this->data['order'] = $order;

    	$this->template = 'sale/order_list.tpl';
    	$this->children = array(
    		'common/header',
    		'common/footer'
    	);

    	$this->response->setOutput($this->render());
    }

    public function getForm() {
    	$this->load->model('sale/customer');

        $this->document->addStyle('/catalog/view/theme/default/stylesheet/sdek.css');
        $this->document->addStyle('/catalog/view/javascript/jquery/colorbox/colorbox.css');

        $this->document->addScript('/catalog/view/javascript/cdek/cdek.js');
        $this->document->addScript('/catalog/view/javascript/jquery/colorbox/jquery.colorbox-min.js');

    	$this->data['text_no_results'] = $this->language->get('text_no_results');
    	$this->data['text_default'] = $this->language->get('text_default');
    	$this->data['text_select'] = $this->language->get('text_select');
    	$this->data['text_none'] = $this->language->get('text_none');
    	$this->data['text_wait'] = $this->language->get('text_wait');
    	$this->data['text_product'] = $this->language->get('text_product');
    	$this->data['text_voucher'] = $this->language->get('text_voucher');
    	$this->data['text_order'] = $this->language->get('text_order');

    	$this->data['entry_store'] = $this->language->get('entry_store');
    	$this->data['entry_customer'] = $this->language->get('entry_customer');
    	$this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
    	$this->data['entry_firstname'] = $this->language->get('entry_firstname');
    	$this->data['entry_lastname'] = $this->language->get('entry_lastname');
    	$this->data['entry_email'] = $this->language->get('entry_email');
    	$this->data['entry_telephone'] = $this->language->get('entry_telephone');
    	$this->data['entry_fax'] = $this->language->get('entry_fax');
    	$this->data['entry_order_status'] = $this->language->get('entry_order_status');
    	$this->data['entry_comment'] = $this->language->get('entry_comment');
    	$this->data['entry_affiliate'] = $this->language->get('entry_affiliate');
    	$this->data['entry_address'] = $this->language->get('entry_address');
    	$this->data['entry_company'] = $this->language->get('entry_company');
    	$this->data['entry_company_id'] = $this->language->get('entry_company_id');
    	$this->data['entry_tax_id'] = $this->language->get('entry_tax_id');
    	$this->data['entry_address_1'] = $this->language->get('entry_address_1');
    	$this->data['entry_address_2'] = $this->language->get('entry_address_2');
    	$this->data['entry_city'] = $this->language->get('entry_city');
    	$this->data['entry_postcode'] = $this->language->get('entry_postcode');
    	$this->data['entry_zone'] = $this->language->get('entry_zone');
    	$this->data['entry_zone_code'] = $this->language->get('entry_zone_code');
    	$this->data['entry_country'] = $this->language->get('entry_country');
    	$this->data['entry_product'] = $this->language->get('entry_product');
    	$this->data['entry_option'] = $this->language->get('entry_option');
    	$this->data['entry_quantity'] = $this->language->get('entry_quantity');
    	$this->data['entry_to_name'] = $this->language->get('entry_to_name');
    	$this->data['entry_to_email'] = $this->language->get('entry_to_email');
    	$this->data['entry_from_name'] = $this->language->get('entry_from_name');
    	$this->data['entry_from_email'] = $this->language->get('entry_from_email');
    	$this->data['entry_theme'] = $this->language->get('entry_theme');
    	$this->data['entry_message'] = $this->language->get('entry_message');
    	$this->data['entry_amount'] = $this->language->get('entry_amount');
    	$this->data['entry_shipping'] = $this->language->get('entry_shipping');
    	$this->data['entry_payment'] = $this->language->get('entry_payment');
    	$this->data['entry_voucher'] = $this->language->get('entry_voucher');
    	$this->data['entry_coupon'] = $this->language->get('entry_coupon');
    	$this->data['entry_reward'] = $this->language->get('entry_reward');

    	$this->data['column_product'] = $this->language->get('column_product');
    	$this->data['column_model'] = $this->language->get('column_model');
    	$this->data['column_quantity'] = $this->language->get('column_quantity');
    	$this->data['column_price'] = $this->language->get('column_price');
    	$this->data['column_total'] = $this->language->get('column_total');

    	$this->data['button_save'] = $this->language->get('button_save');
    	$this->data['button_cancel'] = $this->language->get('button_cancel');
    	$this->data['button_add_product'] = $this->language->get('button_add_product');
    	$this->data['button_add_voucher'] = $this->language->get('button_add_voucher');
    	$this->data['button_update_total'] = $this->language->get('button_update_total');
    	$this->data['button_remove'] = $this->language->get('button_remove');
    	$this->data['button_upload'] = $this->language->get('button_upload');

    	$this->data['tab_order'] = $this->language->get('tab_order');
    	$this->data['tab_customer'] = $this->language->get('tab_customer');
    	$this->data['tab_payment'] = $this->language->get('tab_payment');
    	$this->data['tab_shipping'] = $this->language->get('tab_shipping');
    	$this->data['tab_product'] = $this->language->get('tab_product');
    	$this->data['tab_voucher'] = $this->language->get('tab_voucher');
    	$this->data['tab_total'] = $this->language->get('tab_total');

    	if (isset($this->error['warning'])) {
    		$this->data['error_warning'] = $this->error['warning'];
    	} else {
    		$this->data['error_warning'] = '';
    	}

        if (isset($this->error['stock'])) {
            $this->data['error_stock'] = $this->error['stock'];
        } else {
            $this->data['error_stock'] = '';
        }

    	if (isset($this->error['firstname'])) {
    		$this->data['error_firstname'] = $this->error['firstname'];
    	} else {
    		$this->data['error_firstname'] = '';
    	}

    	if (isset($this->error['lastname'])) {
    		$this->data['error_lastname'] = $this->error['lastname'];
    	} else {
    		$this->data['error_lastname'] = '';
    	}

    	if (isset($this->error['email'])) {
    		$this->data['error_email'] = $this->error['email'];
    	} else {
    		$this->data['error_email'] = '';
    	}

    	if (isset($this->error['telephone'])) {
    		$this->data['error_telephone'] = $this->error['telephone'];
    	} else {
    		$this->data['error_telephone'] = '';
    	}

    	if (isset($this->error['payment_firstname'])) {
    		$this->data['error_payment_firstname'] = $this->error['payment_firstname'];
    	} else {
    		$this->data['error_payment_firstname'] = '';
    	}

    	if (isset($this->error['payment_lastname'])) {
    		$this->data['error_payment_lastname'] = $this->error['payment_lastname'];
    	} else {
    		$this->data['error_payment_lastname'] = '';
    	}

    	if (isset($this->error['payment_address_1'])) {
    		$this->data['error_payment_address_1'] = $this->error['payment_address_1'];
    	} else {
    		$this->data['error_payment_address_1'] = '';
    	}

    	if (isset($this->error['payment_city'])) {
    		$this->data['error_payment_city'] = $this->error['payment_city'];
    	} else {
    		$this->data['error_payment_city'] = '';
    	}

    	if (isset($this->error['payment_postcode'])) {
    		$this->data['error_payment_postcode'] = $this->error['payment_postcode'];
    	} else {
    		$this->data['error_payment_postcode'] = '';
    	}

    	if (isset($this->error['payment_tax_id'])) {
    		$this->data['error_payment_tax_id'] = $this->error['payment_tax_id'];
    	} else {
    		$this->data['error_payment_tax_id'] = '';
    	}

    	if (isset($this->error['payment_country'])) {
    		$this->data['error_payment_country'] = $this->error['payment_country'];
    	} else {
    		$this->data['error_payment_country'] = '';
    	}

    	if (isset($this->error['payment_zone'])) {
    		$this->data['error_payment_zone'] = $this->error['payment_zone'];
    	} else {
    		$this->data['error_payment_zone'] = '';
    	}

    	if (isset($this->error['payment_method'])) {
    		$this->data['error_payment_method'] = $this->error['payment_method'];
    	} else {
    		$this->data['error_payment_method'] = '';
    	}

    	if (isset($this->error['shipping_firstname'])) {
    		$this->data['error_shipping_firstname'] = $this->error['shipping_firstname'];
    	} else {
    		$this->data['error_shipping_firstname'] = '';
    	}

    	if (isset($this->error['shipping_lastname'])) {
    		$this->data['error_shipping_lastname'] = $this->error['shipping_lastname'];
    	} else {
    		$this->data['error_shipping_lastname'] = '';
    	}

    	if (isset($this->error['shipping_address_1'])) {
    		$this->data['error_shipping_address_1'] = $this->error['shipping_address_1'];
    	} else {
    		$this->data['error_shipping_address_1'] = '';
    	}

    	if (isset($this->error['shipping_city'])) {
    		$this->data['error_shipping_city'] = $this->error['shipping_city'];
    	} else {
    		$this->data['error_shipping_city'] = '';
    	}

    	if (isset($this->error['shipping_postcode'])) {
    		$this->data['error_shipping_postcode'] = $this->error['shipping_postcode'];
    	} else {
    		$this->data['error_shipping_postcode'] = '';
    	}

    	if (isset($this->error['shipping_country'])) {
    		$this->data['error_shipping_country'] = $this->error['shipping_country'];
    	} else {
    		$this->data['error_shipping_country'] = '';
    	}

    	if (isset($this->error['shipping_zone'])) {
    		$this->data['error_shipping_zone'] = $this->error['shipping_zone'];
    	} else {
    		$this->data['error_shipping_zone'] = '';
    	}

    	if (isset($this->error['shipping_method'])) {
    		$this->data['error_shipping_method'] = $this->error['shipping_method'];
    	} else {
    		$this->data['error_shipping_method'] = '';
    	}

    	$url = '';

    	if (isset($this->request->get['filter_order_id'])) {
    		$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
    	}

    	if (isset($this->request->get['filter_customer'])) {
    		$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
    	}

    	if (isset($this->request->get['filter_order_status_id'])) {
    		$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
    	}

    	if (isset($this->request->get['filter_total'])) {
    		$url .= '&filter_total=' . $this->request->get['filter_total'];
    	}

    	if (isset($this->request->get['filter_date_added'])) {
    		$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
    	}

    	if (isset($this->request->get['filter_date_modified'])) {
    		$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
    	}

    	if (isset($this->request->get['sort'])) {
    		$url .= '&sort=' . $this->request->get['sort'];
    	}

    	if (isset($this->request->get['order'])) {
    		$url .= '&order=' . $this->request->get['order'];
    	}

    	if (isset($this->request->get['page'])) {
    		$url .= '&page=' . $this->request->get['page'];
    	}

    	$this->data['breadcrumbs'] = array();

    	$this->data['breadcrumbs'][] = array(
    		'text'      => $this->language->get('text_home'),
    		'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
    		'separator' => false
    	);

    	$this->data['breadcrumbs'][] = array(
    		'text'      => $this->language->get('heading_title'),
    		'href'      => $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL'),
    		'separator' => ' :: '
    	);

    	if (!isset($this->request->get['order_id'])) {
    		$this->data['action'] = $this->url->link('sale/order/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
    	} else {
    		$this->data['action'] = $this->url->link('sale/order/update', 'token=' . $this->session->data['token'] . '&order_id=' . $this->request->get['order_id'] . $url, 'SSL');
    	}

    	$this->data['cancel'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL');

    	if (isset($this->request->get['order_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
    		$order_info = $this->model_sale_order->getOrder($this->request->get['order_id']);
    	}

    	$this->data['token'] = $this->session->data['token'];

    	if (isset($this->request->get['order_id'])) {
    		$order_id = $this->data['order_id'] = $this->request->get['order_id'];
    	} else {
    		$order_id = $this->data['order_id'] = 0;
    	}

    	if (isset($this->request->post['store_id'])) {
    		$this->data['store_id'] = $this->request->post['store_id'];
    	} elseif (!empty($order_info)) {
    		$this->data['store_id'] = $order_info['store_id'];
    	} else {
    		$this->data['store_id'] = '';
    	}

    	$this->load->model('setting/store');

    	$this->data['stores'] = $this->model_setting_store->getStores();

    	if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
    		$this->data['store_url'] = HTTPS_CATALOG;
    	} else {
    		$this->data['store_url'] = HTTP_CATALOG;
    	}

    	if (isset($this->request->post['customer'])) {
    		$this->data['customer'] = $this->request->post['customer'];
    	} elseif (!empty($order_info)) {
    		$this->data['customer'] = $order_info['customer'];
    	} else {
    		$this->data['customer'] = '';
    	}

    	if (isset($this->request->post['customer_id'])) {
    		$this->data['customer_id'] = $this->request->post['customer_id'];
    	} elseif (!empty($order_info)) {
    		$this->data['customer_id'] = $order_info['customer_id'];
    	} else {
    		$this->data['customer_id'] = '';
    	}

    	if (isset($this->request->post['customer_group_id'])) {
    		$this->data['customer_group_id'] = $this->request->post['customer_group_id'];
    	} elseif (!empty($order_info)) {
    		$this->data['customer_group_id'] = $order_info['customer_group_id'];
    	} else {
    		$this->data['customer_group_id'] = '';
    	}

    	$this->load->model('sale/customer_group');

    	$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();

    	if (isset($this->request->post['firstname'])) {
    		$this->data['firstname'] = $this->request->post['firstname'];
    	} elseif (!empty($order_info)) {
    		$this->data['firstname'] = $order_info['firstname'];
    	} else {
    		$this->data['firstname'] = '';
    	}

    	if (isset($this->request->post['lastname'])) {
    		$this->data['lastname'] = $this->request->post['lastname'];
    	} elseif (!empty($order_info)) {
    		$this->data['lastname'] = $order_info['lastname'];
    	} else {
    		$this->data['lastname'] = '';
    	}

    	if (isset($this->request->post['email'])) {
    		$this->data['email'] = $this->request->post['email'];
    	} elseif (!empty($order_info)) {
    		$this->data['email'] = $order_info['email'];
    	} else {
    		$this->data['email'] = '';
    	}

    	if (isset($this->request->post['telephone'])) {
    		$this->data['telephone'] = $this->request->post['telephone'];
    	} elseif (!empty($order_info)) {
    		$this->data['telephone'] = $order_info['telephone'];
    	} else {
    		$this->data['telephone'] = '';
    	}

    	if (isset($this->request->post['fax'])) {
    		$this->data['fax'] = $this->request->post['fax'];
    	} elseif (!empty($order_info)) {
    		$this->data['fax'] = $order_info['fax'];
    	} else {
    		$this->data['fax'] = '';
    	}

    	if (isset($this->request->post['affiliate_id'])) {
    		$this->data['affiliate_id'] = $this->request->post['affiliate_id'];
    	} elseif (!empty($order_info)) {
    		$this->data['affiliate_id'] = $order_info['affiliate_id'];
    	} else {
    		$this->data['affiliate_id'] = '';
    	}

    	if (isset($this->request->post['affiliate'])) {
    		$this->data['affiliate'] = $this->request->post['affiliate'];
    	} elseif (!empty($order_info)) {
    		$this->data['affiliate'] = ($order_info['affiliate_id'] ? $order_info['affiliate_firstname'] . ' ' . $order_info['affiliate_lastname'] : '');
    	} else {
    		$this->data['affiliate'] = '';
    	}

    	if (isset($this->request->post['order_status_id'])) {
    		$this->data['order_status_id'] = $this->request->post['order_status_id'];
    	} elseif (!empty($order_info)) {
    		$this->data['order_status_id'] = $order_info['order_status_id'];
    	} else {
    		$this->data['order_status_id'] = '';
    	}

    	$this->load->model('localisation/order_status');

    	$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

    	if (isset($this->request->post['comment'])) {
    		$this->data['comment'] = $this->request->post['comment'];
    	} elseif (!empty($order_info)) {
    		$this->data['comment'] = $order_info['comment'];
    	} else {
    		$this->data['comment'] = '';
    	}

    	$this->load->model('sale/customer');

        $custom_warehouse_tasks = ''; // Задачи склада
        $custom_manager_tasks = ''; // Задачи менеджеру
        $custom_special_comments = ''; // Особые комментарии

        $customer_custom = $this->db->query("SELECT `data` FROM `simple_custom_data` WHERE customer_id = '{$order_info['customer_id']}' AND object_type = '2' AND object_id = '{$order_info['customer_id']}'")->row;

        if (isset($customer_custom['data'])) {
            $customer_custom = unserialize($customer_custom['data']);

            if (!empty($customer_custom['custom_warehouse_tasks'])) {
                $custom_warehouse_tasks = $customer_custom['custom_warehouse_tasks']['value'];
            }

            if (!empty($customer_custom['custom_manager_tasks'])) {
                $custom_manager_tasks = $customer_custom['custom_manager_tasks']['value'];
            }

            if (!empty($customer_custom['custom_special_comments'])) {
                $custom_special_comments = $customer_custom['custom_special_comments']['value'];
            }
        }

        $this->data['custom_warehouse_tasks'] = $custom_warehouse_tasks;
        $this->data['custom_manager_tasks'] = $custom_manager_tasks;
        $this->data['custom_special_comments'] = $custom_special_comments;

    	if (isset($this->request->post['customer_id'])) {
    		$this->data['addresses'] = $this->model_sale_customer->getAddresses($this->request->post['customer_id']);
    	} elseif (!empty($order_info)) {
    		$this->data['addresses'] = $this->model_sale_customer->getAddresses($order_info['customer_id']);
    	} else {
    		$this->data['addresses'] = array();
    	}

    	if (isset($this->request->post['payment_firstname'])) {
    		$this->data['payment_firstname'] = $this->request->post['payment_firstname'];
    	} elseif (!empty($order_info)) {
    		$this->data['payment_firstname'] = $order_info['payment_firstname'];
    	} else {
    		$this->data['payment_firstname'] = '';
    	}

    	if (isset($this->request->post['payment_lastname'])) {
    		$this->data['payment_lastname'] = $this->request->post['payment_lastname'];
    	} elseif (!empty($order_info)) {
    		$this->data['payment_lastname'] = $order_info['payment_lastname'];
    	} else {
    		$this->data['payment_lastname'] = '';
    	}

    	if (isset($this->request->post['payment_company'])) {
    		$this->data['payment_company'] = $this->request->post['payment_company'];
    	} elseif (!empty($order_info)) {
    		$this->data['payment_company'] = $order_info['payment_company'];
    	} else {
    		$this->data['payment_company'] = '';
    	}

    	if (isset($this->request->post['payment_company_id'])) {
    		$this->data['payment_company_id'] = $this->request->post['payment_company_id'];
    	} elseif (!empty($order_info)) {
    		$this->data['payment_company_id'] = $order_info['payment_company_id'];
    	} else {
    		$this->data['payment_company_id'] = '';
    	}

    	if (isset($this->request->post['payment_tax_id'])) {
    		$this->data['payment_tax_id'] = $this->request->post['payment_tax_id'];
    	} elseif (!empty($order_info)) {
    		$this->data['payment_tax_id'] = $order_info['payment_tax_id'];
    	} else {
    		$this->data['payment_tax_id'] = '';
    	}

    	if (isset($this->request->post['payment_address_1'])) {
    		$this->data['payment_address_1'] = $this->request->post['payment_address_1'];
    	} elseif (!empty($order_info)) {
    		$this->data['payment_address_1'] = $order_info['payment_address_1'];
    	} else {
    		$this->data['payment_address_1'] = '';
    	}

    	if (isset($this->request->post['payment_address_2'])) {
    		$this->data['payment_address_2'] = $this->request->post['payment_address_2'];
    	} elseif (!empty($order_info)) {
    		$this->data['payment_address_2'] = $order_info['payment_address_2'];
    	} else {
    		$this->data['payment_address_2'] = '';
    	}

    	if (isset($this->request->post['payment_city'])) {
    		$this->data['payment_city'] = $this->request->post['payment_city'];
    	} elseif (!empty($order_info)) {
    		$this->data['payment_city'] = $order_info['payment_city'];
    	} else {
    		$this->data['payment_city'] = '';
    	}

    	if (isset($this->request->post['payment_postcode'])) {
    		$this->data['payment_postcode'] = $this->request->post['payment_postcode'];
    	} elseif (!empty($order_info)) {
    		$this->data['payment_postcode'] = $order_info['payment_postcode'];
    	} else {
    		$this->data['payment_postcode'] = '';
    	}

    	if (isset($this->request->post['payment_country_id'])) {
    		$this->data['payment_country_id'] = $this->request->post['payment_country_id'];
    	} elseif (!empty($order_info)) {
    		$this->data['payment_country_id'] = $order_info['payment_country_id'];
    	} else {
    		$this->data['payment_country_id'] = '';
    	}

    	if (isset($this->request->post['payment_zone_id'])) {
    		$this->data['payment_zone_id'] = $this->request->post['payment_zone_id'];
    	} elseif (!empty($order_info)) {
    		$this->data['payment_zone_id'] = $order_info['payment_zone_id'];
    	} else {
    		$this->data['payment_zone_id'] = '';
    	}

    	if (isset($this->request->post['payment_method'])) {
    		$this->data['payment_method'] = $this->request->post['payment_method'];
    	} elseif (!empty($order_info)) {
    		$this->data['payment_method'] = $order_info['payment_method'];
    	} else {
    		$this->data['payment_method'] = '';
    	}

    	if (isset($this->request->post['payment_code'])) {
    		$this->data['payment_code'] = $this->request->post['payment_code'];
    	} elseif (!empty($order_info)) {
    		$this->data['payment_code'] = $order_info['payment_code'];
    	} else {
    		$this->data['payment_code'] = '';
    	}

    	if (isset($this->request->post['shipping_firstname'])) {
    		$this->data['shipping_firstname'] = $this->request->post['shipping_firstname'];
    	} elseif (!empty($order_info)) {
    		$this->data['shipping_firstname'] = $order_info['shipping_firstname'];
    	} else {
    		$this->data['shipping_firstname'] = '';
    	}

    	if (isset($this->request->post['shipping_lastname'])) {
    		$this->data['shipping_lastname'] = $this->request->post['shipping_lastname'];
    	} elseif (!empty($order_info)) {
    		$this->data['shipping_lastname'] = $order_info['shipping_lastname'];
    	} else {
    		$this->data['shipping_lastname'] = '';
    	}

    	if (isset($this->request->post['shipping_company'])) {
    		$this->data['shipping_company'] = $this->request->post['shipping_company'];
    	} elseif (!empty($order_info)) {
    		$this->data['shipping_company'] = $order_info['shipping_company'];
    	} else {
    		$this->data['shipping_company'] = '';
    	}

    	if (isset($this->request->post['shipping_address_1'])) {
    		$this->data['shipping_address_1'] = $this->request->post['shipping_address_1'];
    	} elseif (!empty($order_info)) {
    		$this->data['shipping_address_1'] = $order_info['shipping_address_1'];
    	} else {
    		$this->data['shipping_address_1'] = '';
    	}

    	if (isset($this->request->post['shipping_address_2'])) {
    		$this->data['shipping_address_2'] = $this->request->post['shipping_address_2'];
    	} elseif (!empty($order_info)) {
    		$this->data['shipping_address_2'] = $order_info['shipping_address_2'];
    	} else {
    		$this->data['shipping_address_2'] = '';
    	}

    	if (isset($this->request->post['shipping_city'])) {
    		$this->data['shipping_city'] = $this->request->post['shipping_city'];
    	} elseif (!empty($order_info)) {
    		$this->data['shipping_city'] = $order_info['shipping_city'];
    	} else {
    		$this->data['shipping_city'] = '';
    	}

    	if (isset($this->request->post['shipping_postcode'])) {
    		$this->data['shipping_postcode'] = $this->request->post['shipping_postcode'];
    	} elseif (!empty($order_info)) {
    		$this->data['shipping_postcode'] = $order_info['shipping_postcode'];
    	} else {
    		$this->data['shipping_postcode'] = '';
    	}

    	if (isset($this->request->post['shipping_country_id'])) {
    		$this->data['shipping_country_id'] = $this->request->post['shipping_country_id'];
    	} elseif (!empty($order_info)) {
    		$this->data['shipping_country_id'] = $order_info['shipping_country_id'];
    	} else {
    		$this->data['shipping_country_id'] = '';
    	}

    	if (isset($this->request->post['shipping_zone_id'])) {
    		$this->data['shipping_zone_id'] = $this->request->post['shipping_zone_id'];
    	} elseif (!empty($order_info)) {
    		$this->data['shipping_zone_id'] = $order_info['shipping_zone_id'];
    	} else {
    		$this->data['shipping_zone_id'] = '';
    	}

    	$this->load->model('localisation/country');

    	$this->data['countries'] = $this->model_localisation_country->getCountries();

    	if (isset($this->request->post['shipping_method'])) {
    		$this->data['shipping_method'] = $this->request->post['shipping_method'];
    	} elseif (!empty($order_info)) {
    		$this->data['shipping_method'] = $order_info['shipping_method'];
    	} else {
    		$this->data['shipping_method'] = '';
    	}

    	if (isset($this->request->post['shipping_code'])) {
    		$this->data['shipping_code'] = $this->request->post['shipping_code'];
    	} elseif (!empty($order_info)) {
    		$this->data['shipping_code'] = $order_info['shipping_code'];
    	} else {
    		$this->data['shipping_code'] = '';
    	}

    	if (isset($this->request->post['shipping_pvz'])) {
    		$this->data['shipping_pvz'] = $this->request->post['shipping_pvz'];
    	} elseif (!empty($order_info)) {
    		$this->data['shipping_pvz'] = $order_info['shipping_pvz'];
    	} else {
    		$this->data['shipping_pvz'] = '';
    	}

        // added
        if (isset($this->request->post['shipping_cdek_cost'])) {
            $this->data['shipping_cdek_cost'] = $this->request->post['shipping_cdek_cost'];
        } elseif (!empty($order_info)) {
            $this->data['shipping_cdek_cost'] = $order_info['shipping_cdek_cost'];
        } else {
            $this->data['shipping_cdek_cost'] = 0.00;
        }
        //

        $current_order_products = [];

    	if (isset($this->request->post['order_product'])) {
            $order_products = $this->model_sale_order->getOrderProducts($this->request->get['order_id']);

            if (!empty($order_products)) {
                foreach ($order_products as $order_product) {
                    $current_order_products[$order_product['product_id'] . ($order_product['model'] ?: '')] = $order_product['quantity'];
                }
            }

    		$order_products = $this->request->post['order_product'];
    	} elseif (isset($this->request->get['order_id'])) {
    		$order_products = $this->model_sale_order->getOrderProducts($this->request->get['order_id']);
    	} else {
    		$order_products = array();
    	}

    	$this->load->model('catalog/product');

    	$this->document->addScript('view/javascript/jquery/ajaxupload.js');

    	$this->data['order_products'] = array();

    	foreach ($order_products as $order_product) {
            $stock = true; // товар есть в наличии
            $db_quantity = 0; // количество товара в базе

            $product_info = $this->model_catalog_product->getProduct($order_product['product_id']);

            if ($product_info) {
                $db_quantity = $product_quantity = (int)$product_info['quantity']; // количество товара в базе
                $order_product_quantity = (int)$order_product['quantity'];

                if (isset($this->request->post['order_product'])) {
                    $db_quantity = $db_quantity - $order_product_quantity;

                    if (!empty($current_order_products[$product_info['product_id'] . ($product_info['model'] ?: '')])) {
                        $current_order_product_quantity = (int)$current_order_products[$product_info['product_id'] . ($product_info['model'] ?: '')];

                        $db_quantity = $db_quantity + $current_order_product_quantity;
                    }
                }

                if ($db_quantity < 0) {
                    $stock = false;
                }
            }

    		if (isset($order_product['order_option'])) {
                $order_options = $order_product['order_option'];
    		} elseif (isset($this->request->get['order_id'])) {
                $order_options = $this->model_sale_order->getOrderOptions($this->request->get['order_id'], $order_product['order_product_id']);
    		} else {
                $order_options = array();
    		}

    		if (!empty($order_options)) {
                foreach ($order_options as $order_option) {
                    $order_option_value = $this->model_catalog_product->getProductOptionValue($order_option);

                    $db_quantity = $option_value_quantity = (int)$order_option_value['quantity'];

                    if (isset($this->request->post['order_product'])) {
                        $db_quantity = $db_quantity - $order_product_quantity;

                        if (!empty($current_order_products[$order_product['product_id'] . ($order_option_value['ob_sku'] ?: '')])) {
                            $current_order_product_quantity = (int)$current_order_products[$order_product['product_id'] . ($order_option_value['ob_sku'] ?: '')]; // количество товара в корзине

                            $db_quantity = $db_quantity + $current_order_product_quantity;
                        }
                    }

                    if ($db_quantity < 0) {
                        $stock = false;
                    }
                }
            }

    		if (isset($order_product['order_download'])) {
    			$order_download = $order_product['order_download'];
    		} elseif (isset($this->request->get['order_id'])) {
    			$order_download = $this->model_sale_order->getOrderDownloads($this->request->get['order_id'], $order_product['order_product_id']);
    		} else {
    			$order_download = array();
    		}

            $subtracted_products = '';

            $order_subtracted_products = unserialize($order_product['products']); // массив товаров, у которых списано количество

            if (!empty($order_subtracted_products)) {
                foreach ($order_subtracted_products as $product_id => $qty) {
                    $subtracted_products .= '<br>' . $product_id . ' - ' . $qty;
                }
            }

            $this->data['order_products'][] = array(
                'order_product_id'    => $order_product['order_product_id'],
                'product_id'          => $order_product['product_id'],
                'name'                => $order_product['name'],
                'model'               => $order_product['model'],
                'option'              => $order_options,
                'download'            => $order_download,
                'quantity'            => $order_product['quantity'],
                'products'            => $order_product['products'],
                'stock'               => $stock,
                'db_quantity'         => $db_quantity,
                'subtracted_products' => $subtracted_products,
                'price'               => $order_product['price'],
                'total'               => $order_product['total'],
                'tax'                 => $order_product['tax'],
                'reward'              => $order_product['reward']
            );
    	}

    	if (isset($this->request->post['order_voucher'])) {
    		$this->data['order_vouchers'] = $this->request->post['order_voucher'];
    	} elseif (isset($this->request->get['order_id'])) {
    		$this->data['order_vouchers'] = $this->model_sale_order->getOrderVouchers($this->request->get['order_id']);
    	} else {
    		$this->data['order_vouchers'] = array();
    	}

    	$this->load->model('sale/voucher_theme');

    	$this->data['voucher_themes'] = $this->model_sale_voucher_theme->getVoucherThemes();

    	if (isset($this->request->post['order_total'])) {
    		$this->data['order_totals'] = $this->request->post['order_total'];
    	} elseif (isset($this->request->get['order_id'])) {
    		$this->data['order_totals'] = $this->model_sale_order->getOrderTotals($this->request->get['order_id']);
    	} else {
    		$this->data['order_totals'] = array();
    	}

    	$this->data['heading_title'] = 'Заказ №' . $this->data['order_id'];
    	if (!empty($order_info['date_added'])) {
    		$this->data['heading_title'] .= ' от ' . $order_info['date_added'];
    	}

    	$this->template = 'sale/order_form.tpl';
    	$this->children = array(
    		'common/header',
    		'common/footer'
    	);

    	$this->response->setOutput($this->render());
    }

    protected function validateForm() {
    	if (!$this->user->hasPermission('modify', 'sale/order')) {
    		$this->error['warning'] = $this->language->get('error_permission');
    	}

    	if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
    		$this->error['firstname'] = $this->language->get('error_firstname');
    	}

    	if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 32)) {
    		$this->error['lastname'] = $this->language->get('error_lastname');
    	}

    	if ((utf8_strlen($this->request->post['email']) > 96) || (!preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email']))) {
    		$this->error['email'] = $this->language->get('error_email');
    	}

    	if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
    		$this->error['telephone'] = $this->language->get('error_telephone');
    	}

    	if ((utf8_strlen($this->request->post['payment_firstname']) < 1) || (utf8_strlen($this->request->post['payment_firstname']) > 32)) {
    		$this->error['payment_firstname'] = $this->language->get('error_firstname');
    	}

    	if ((utf8_strlen($this->request->post['payment_lastname']) < 1) || (utf8_strlen($this->request->post['payment_lastname']) > 32)) {
    		$this->error['payment_lastname'] = $this->language->get('error_lastname');
    	}

    	if ((utf8_strlen($this->request->post['payment_address_1']) < 3) || (utf8_strlen($this->request->post['payment_address_1']) > 128)) {
    		$this->error['payment_address_1'] = $this->language->get('error_address_1');
    	}

    	if ((utf8_strlen($this->request->post['payment_city']) < 3) || (utf8_strlen($this->request->post['payment_city']) > 128)) {
    		$this->error['payment_city'] = $this->language->get('error_city');
    	}

    	$this->load->model('localisation/country');

    	$country_info = $this->model_localisation_country->getCountry($this->request->post['payment_country_id']);

    	if ($country_info) {
    		if ($country_info['postcode_required'] && (utf8_strlen($this->request->post['payment_postcode']) < 2) || (utf8_strlen($this->request->post['payment_postcode']) > 10)) {
    			$this->error['payment_postcode'] = $this->language->get('error_postcode');
    		}

			// VAT Validation
    		$this->load->helper('vat');

    		if ($this->config->get('config_vat') && $this->request->post['payment_tax_id'] && (vat_validation($country_info['iso_code_2'], $this->request->post['payment_tax_id']) == 'invalid')) {
    			$this->error['payment_tax_id'] = $this->language->get('error_vat');
    		}
    	}

    	if ($this->request->post['payment_country_id'] == '') {
    		$this->error['payment_country'] = $this->language->get('error_country');
    	}

    	if (!isset($this->request->post['payment_zone_id']) || $this->request->post['payment_zone_id'] == '') {
    		$this->error['payment_zone'] = $this->language->get('error_zone');
    	}

    	if (!isset($this->request->post['payment_method']) || $this->request->post['payment_method'] == '') {
    		$this->error['payment_method'] = $this->language->get('error_payment');
    	}

		// Check if any products require shipping
    	$shipping = false;
        $stock = true; // все товары есть на складе

        $current_order_products = [];

        $order_products = $this->model_sale_order->getOrderProducts($this->request->get['order_id']);

        if (!empty($order_products)) {
            foreach ($order_products as $order_product) {
                $current_order_products[$order_product['product_id'] . ($order_product['model'] ?: '')] = $order_product['quantity'];
            }
        }

    	if (isset($this->request->post['order_product'])) {
    		$this->load->model('catalog/product');

    		foreach ($this->request->post['order_product'] as $i => $order_product) {
    			$product_info = $this->model_catalog_product->getProduct($order_product['product_id']);

                if ($product_info) {
                    if ($product_info['shipping']) {
                        $shipping = true;
                    }

                    $db_quantity = (int)$product_info['quantity']; // количество товара в базе
                    $order_product_quantity = (int)$order_product['quantity']; // количество товара в заказе после изменения заказа

                    // Stock
                    if (!empty($current_order_products[$product_info['product_id'] . ($product_info['model'] ?: '')])) {
                        $current_order_product_quantity = (int)$current_order_products[$product_info['product_id'] . ($product_info['model'] ?: '')];
                    } else {
                        $current_order_product_quantity = 0; // количество товара, которое уже было в заказе
                    }

                    if (($db_quantity < 0) || ($db_quantity + $current_order_product_quantity < $order_product_quantity)) {
                        $stock = false;
                    }

                    if (!empty($order_product['order_option'])) {
                        $product_options = $this->model_catalog_product->getProductOptions($order_product['product_id']);

                        if (!empty($product_options)) {
                            $stock = $this->model_sale_order->getOrderOptionStock($order_product, $current_order_products);
                        }
                    }

                    if (!$stock) {
                        $this->error['stock'] = $this->language->get('error_stock');
                    }
                }
    		}
    	}

    	if ($shipping) {
    		if ((utf8_strlen($this->request->post['shipping_firstname']) < 1) || (utf8_strlen($this->request->post['shipping_firstname']) > 32)) {
    			$this->error['shipping_firstname'] = $this->language->get('error_firstname');
    		}

    		if ((utf8_strlen($this->request->post['shipping_lastname']) < 1) || (utf8_strlen($this->request->post['shipping_lastname']) > 32)) {
    			$this->error['shipping_lastname'] = $this->language->get('error_lastname');
    		}

    		if ((utf8_strlen($this->request->post['shipping_address_1']) < 3) || (utf8_strlen($this->request->post['shipping_address_1']) > 128)) {
    			$this->error['shipping_address_1'] = $this->language->get('error_address_1');
    		}

    		if ((utf8_strlen($this->request->post['shipping_city']) < 3) || (utf8_strlen($this->request->post['shipping_city']) > 128)) {
    			$this->error['shipping_city'] = $this->language->get('error_city');
    		}

    		$this->load->model('localisation/country');

    		$country_info = $this->model_localisation_country->getCountry($this->request->post['shipping_country_id']);

    		if ($country_info && $country_info['postcode_required'] && (utf8_strlen($this->request->post['shipping_postcode']) < 2) || (utf8_strlen($this->request->post['shipping_postcode']) > 10)) {
    			$this->error['shipping_postcode'] = $this->language->get('error_postcode');
    		}

    		if ($this->request->post['shipping_country_id'] == '') {
    			$this->error['shipping_country'] = $this->language->get('error_country');
    		}

    		if (!isset($this->request->post['shipping_zone_id']) || $this->request->post['shipping_zone_id'] == '') {
    			$this->error['shipping_zone'] = $this->language->get('error_zone');
    		}

    		if (!$this->request->post['shipping_method']) {
    			$this->error['shipping_method'] = $this->language->get('error_shipping');
    		}
    	}

    	if ($this->error && !isset($this->error['warning'])) {
    		$this->error['warning'] = $this->language->get('error_warning');
    	}

    	if (!$this->error) {
    		return true;
    	} else {
    		return false;
    	}
    }

    protected function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'sale/order')) {
    		$this->error['warning'] = $this->language->get('error_permission');
    	}

    	if (!$this->error) {
    		return true;
    	} else {
    		return false;
    	}
    }

    public function country() {
    	$json = array();

    	$this->load->model('localisation/country');

    	$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);

    	if ($country_info) {
    		$this->load->model('localisation/zone');

    		$json = array(
    			'country_id'        => $country_info['country_id'],
    			'name'              => $country_info['name'],
    			'iso_code_2'        => $country_info['iso_code_2'],
    			'iso_code_3'        => $country_info['iso_code_3'],
    			'address_format'    => $country_info['address_format'],
    			'postcode_required' => $country_info['postcode_required'],
    			'zone'              => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
    			'status'            => $country_info['status']
    		);
    	}

    	$this->response->setOutput(json_encode($json));
    }

    public function info() {
    	$this->load->model('sale/order');

    	if (isset($this->request->get['order_id'])) {
    		$order_id = $this->request->get['order_id'];
    	} else {
    		$order_id = 0;
    	}

    	$order_info = $this->model_sale_order->getOrder($order_id);

    	if ($order_info) {
    		$this->language->load('sale/order');

    		$this->document->setTitle($this->language->get('heading_title'));

    		$this->data['heading_title'] = $this->language->get('heading_title');

    		$this->data['text_name'] = $this->language->get('text_name');
    		$this->data['text_order_id'] = $this->language->get('text_order_id');
    		$this->data['text_invoice_no'] = $this->language->get('text_invoice_no');
    		$this->data['text_invoice_date'] = $this->language->get('text_invoice_date');
    		$this->data['text_store_name'] = $this->language->get('text_store_name');
    		$this->data['text_store_url'] = $this->language->get('text_store_url');
    		$this->data['text_customer'] = $this->language->get('text_customer');
    		$this->data['text_customer_group'] = $this->language->get('text_customer_group');
    		$this->data['text_email'] = $this->language->get('text_email');
    		$this->data['text_telephone'] = $this->language->get('text_telephone');
    		$this->data['text_fax'] = $this->language->get('text_fax');
    		$this->data['text_total'] = $this->language->get('text_total');
    		$this->data['text_reward'] = $this->language->get('text_reward');
    		$this->data['text_order_status'] = $this->language->get('text_order_status');
    		$this->data['text_comment'] = $this->language->get('text_comment');
    		$this->data['text_affiliate'] = $this->language->get('text_affiliate');
    		$this->data['text_commission'] = $this->language->get('text_commission');
    		$this->data['text_ip'] = $this->language->get('text_ip');
    		$this->data['text_forwarded_ip'] = $this->language->get('text_forwarded_ip');
    		$this->data['text_user_agent'] = $this->language->get('text_user_agent');
    		$this->data['text_accept_language'] = $this->language->get('text_accept_language');
    		$this->data['text_date_added'] = $this->language->get('text_date_added');
    		$this->data['text_date_modified'] = $this->language->get('text_date_modified');
    		$this->data['text_firstname'] = $this->language->get('text_firstname');
    		$this->data['text_lastname'] = $this->language->get('text_lastname');
    		$this->data['text_company'] = $this->language->get('text_company');
    		$this->data['text_company_id'] = $this->language->get('text_company_id');
    		$this->data['text_tax_id'] = $this->language->get('text_tax_id');
    		$this->data['text_address_1'] = $this->language->get('text_address_1');
    		$this->data['text_address_2'] = $this->language->get('text_address_2');
    		$this->data['text_city'] = $this->language->get('text_city');
    		$this->data['text_postcode'] = $this->language->get('text_postcode');
    		$this->data['text_zone'] = $this->language->get('text_zone');
    		$this->data['text_zone_code'] = $this->language->get('text_zone_code');
    		$this->data['text_country'] = $this->language->get('text_country');
    		$this->data['text_shipping_method'] = $this->language->get('text_shipping_method');
    		$this->data['text_payment_method'] = $this->language->get('text_payment_method');
    		$this->data['text_download'] = $this->language->get('text_download');
    		$this->data['text_wait'] = $this->language->get('text_wait');
    		$this->data['text_generate'] = $this->language->get('text_generate');
    		$this->data['text_reward_add'] = $this->language->get('text_reward_add');
    		$this->data['text_reward_remove'] = $this->language->get('text_reward_remove');
    		$this->data['text_commission_add'] = $this->language->get('text_commission_add');
    		$this->data['text_commission_remove'] = $this->language->get('text_commission_remove');
    		$this->data['text_credit_add'] = $this->language->get('text_credit_add');
    		$this->data['text_credit_remove'] = $this->language->get('text_credit_remove');
    		$this->data['text_country_match'] = $this->language->get('text_country_match');
    		$this->data['text_country_code'] = $this->language->get('text_country_code');
    		$this->data['text_high_risk_country'] = $this->language->get('text_high_risk_country');
    		$this->data['text_distance'] = $this->language->get('text_distance');
    		$this->data['text_ip_region'] = $this->language->get('text_ip_region');
    		$this->data['text_ip_city'] = $this->language->get('text_ip_city');
    		$this->data['text_ip_latitude'] = $this->language->get('text_ip_latitude');
    		$this->data['text_ip_longitude'] = $this->language->get('text_ip_longitude');
    		$this->data['text_ip_isp'] = $this->language->get('text_ip_isp');
    		$this->data['text_ip_org'] = $this->language->get('text_ip_org');
    		$this->data['text_ip_asnum'] = $this->language->get('text_ip_asnum');
    		$this->data['text_ip_user_type'] = $this->language->get('text_ip_user_type');
    		$this->data['text_ip_country_confidence'] = $this->language->get('text_ip_country_confidence');
    		$this->data['text_ip_region_confidence'] = $this->language->get('text_ip_region_confidence');
    		$this->data['text_ip_city_confidence'] = $this->language->get('text_ip_city_confidence');
    		$this->data['text_ip_postal_confidence'] = $this->language->get('text_ip_postal_confidence');
    		$this->data['text_ip_postal_code'] = $this->language->get('text_ip_postal_code');
    		$this->data['text_ip_accuracy_radius'] = $this->language->get('text_ip_accuracy_radius');
    		$this->data['text_ip_net_speed_cell'] = $this->language->get('text_ip_net_speed_cell');
    		$this->data['text_ip_metro_code'] = $this->language->get('text_ip_metro_code');
    		$this->data['text_ip_area_code'] = $this->language->get('text_ip_area_code');
    		$this->data['text_ip_time_zone'] = $this->language->get('text_ip_time_zone');
    		$this->data['text_ip_region_name'] = $this->language->get('text_ip_region_name');
    		$this->data['text_ip_domain'] = $this->language->get('text_ip_domain');
    		$this->data['text_ip_country_name'] = $this->language->get('text_ip_country_name');
    		$this->data['text_ip_continent_code'] = $this->language->get('text_ip_continent_code');
    		$this->data['text_ip_corporate_proxy'] = $this->language->get('text_ip_corporate_proxy');
    		$this->data['text_anonymous_proxy'] = $this->language->get('text_anonymous_proxy');
    		$this->data['text_proxy_score'] = $this->language->get('text_proxy_score');
    		$this->data['text_is_trans_proxy'] = $this->language->get('text_is_trans_proxy');
    		$this->data['text_free_mail'] = $this->language->get('text_free_mail');
    		$this->data['text_carder_email'] = $this->language->get('text_carder_email');
    		$this->data['text_high_risk_username'] = $this->language->get('text_high_risk_username');
    		$this->data['text_high_risk_password'] = $this->language->get('text_high_risk_password');
    		$this->data['text_bin_match'] = $this->language->get('text_bin_match');
    		$this->data['text_bin_country'] = $this->language->get('text_bin_country');
    		$this->data['text_bin_name_match'] = $this->language->get('text_bin_name_match');
    		$this->data['text_bin_name'] = $this->language->get('text_bin_name');
    		$this->data['text_bin_phone_match'] = $this->language->get('text_bin_phone_match');
    		$this->data['text_bin_phone'] = $this->language->get('text_bin_phone');
    		$this->data['text_customer_phone_in_billing_location'] = $this->language->get('text_customer_phone_in_billing_location');
    		$this->data['text_ship_forward'] = $this->language->get('text_ship_forward');
    		$this->data['text_city_postal_match'] = $this->language->get('text_city_postal_match');
    		$this->data['text_ship_city_postal_match'] = $this->language->get('text_ship_city_postal_match');
    		$this->data['text_score'] = $this->language->get('text_score');
    		$this->data['text_explanation'] = $this->language->get('text_explanation');
    		$this->data['text_risk_score'] = $this->language->get('text_risk_score');
    		$this->data['text_queries_remaining'] = $this->language->get('text_queries_remaining');
    		$this->data['text_maxmind_id'] = $this->language->get('text_maxmind_id');
    		$this->data['text_error'] = $this->language->get('text_error');

    		$this->data['column_product'] = $this->language->get('column_product');
    		$this->data['column_model'] = $this->language->get('column_model');
    		$this->data['column_quantity'] = $this->language->get('column_quantity');
    		$this->data['column_price'] = $this->language->get('column_price');
    		$this->data['column_total'] = $this->language->get('column_total');
    		$this->data['column_download'] = $this->language->get('column_download');
    		$this->data['column_filename'] = $this->language->get('column_filename');
    		$this->data['column_remaining'] = $this->language->get('column_remaining');

    		$this->data['entry_order_status'] = $this->language->get('entry_order_status');
    		$this->data['entry_notify'] = $this->language->get('entry_notify');
    		$this->data['entry_comment'] = $this->language->get('entry_comment');

    		$this->data['button_invoice'] = $this->language->get('button_invoice');
    		$this->data['button_cancel'] = $this->language->get('button_cancel');
    		$this->data['button_add_history'] = $this->language->get('button_add_history');

    		$this->data['tab_order'] = $this->language->get('tab_order');
    		$this->data['tab_payment'] = $this->language->get('tab_payment');
    		$this->data['tab_shipping'] = $this->language->get('tab_shipping');
    		$this->data['tab_product'] = $this->language->get('tab_product');
    		$this->data['tab_history'] = $this->language->get('tab_history');
    		$this->data['tab_fraud'] = $this->language->get('tab_fraud');

    		$this->data['token'] = $this->session->data['token'];

    		$url = '';

    		if (isset($this->request->get['filter_order_id'])) {
    			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
    		}

    		if (isset($this->request->get['filter_customer'])) {
    			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
    		}

    		if (isset($this->request->get['filter_order_status_id'])) {
    			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
    		}

    		if (isset($this->request->get['filter_total'])) {
    			$url .= '&filter_total=' . $this->request->get['filter_total'];
    		}

    		if (isset($this->request->get['filter_date_added'])) {
    			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
    		}

    		if (isset($this->request->get['filter_date_modified'])) {
    			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
    		}

    		if (isset($this->request->get['sort'])) {
    			$url .= '&sort=' . $this->request->get['sort'];
    		}

    		if (isset($this->request->get['order'])) {
    			$url .= '&order=' . $this->request->get['order'];
    		}

    		if (isset($this->request->get['page'])) {
    			$url .= '&page=' . $this->request->get['page'];
    		}

    		$this->data['breadcrumbs'] = array();

    		$this->data['breadcrumbs'][] = array(
    			'text'      => $this->language->get('text_home'),
    			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
    			'separator' => false
    		);

    		$this->data['breadcrumbs'][] = array(
    			'text'      => $this->language->get('heading_title'),
    			'href'      => $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL'),
    			'separator' => ' :: '
    		);

    		$this->data['invoice'] = $this->url->link('sale/order/invoice', 'token=' . $this->session->data['token'] . '&order_id=' . (int)$this->request->get['order_id'], 'SSL');
    		$this->data['cancel'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL');

    		$this->data['order_id'] = $this->request->get['order_id'];

    		if ($order_info['invoice_no']) {
    			$this->data['invoice_no'] = $order_info['invoice_prefix'] . $order_info['invoice_no'];
    		} else {
    			$this->data['invoice_no'] = '';
    		}

    		$this->data['store_name'] = $order_info['store_name'];
    		$this->data['store_url'] = $order_info['store_url'];
    		$this->data['firstname'] = $order_info['firstname'];
    		$this->data['lastname'] = $order_info['lastname'];

    		if ($order_info['customer_id']) {
    			$this->data['customer'] = $this->url->link('sale/customer/update', 'token=' . $this->session->data['token'] . '&customer_id=' . $order_info['customer_id'], 'SSL');
    		} else {
    			$this->data['customer'] = '';
    		}

    		$this->load->model('sale/customer_group');

    		$customer_group_info = $this->model_sale_customer_group->getCustomerGroup($order_info['customer_group_id']);

    		if ($customer_group_info) {
    			$this->data['customer_group'] = $customer_group_info['name'];
    		} else {
    			$this->data['customer_group'] = '';
    		}

    		$this->data['email'] = $order_info['email'];
    		$this->data['telephone'] = $order_info['telephone'];
    		$this->data['fax'] = $order_info['fax'];
    		$this->data['comment'] = nl2br($order_info['comment']);
    		$this->data['shipping_method'] = $order_info['shipping_method'];
    		$this->data['payment_method'] = $order_info['payment_method'];
    		$this->data['total'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value']);

    		if ($order_info['total'] < 0) {
    			$this->data['credit'] = $order_info['total'];
    		} else {
    			$this->data['credit'] = 0;
    		}

    		$this->load->model('sale/customer');

    		$this->data['credit_total'] = $this->model_sale_customer->getTotalTransactionsByOrderId($this->request->get['order_id']);

    		$this->data['reward'] = $order_info['reward'];

    		$this->data['reward_total'] = $this->model_sale_customer->getTotalCustomerRewardsByOrderId($this->request->get['order_id']);

    		$this->data['affiliate_firstname'] = $order_info['affiliate_firstname'];
    		$this->data['affiliate_lastname'] = $order_info['affiliate_lastname'];

    		if ($order_info['affiliate_id']) {
    			$this->data['affiliate'] = $this->url->link('sale/affiliate/update', 'token=' . $this->session->data['token'] . '&affiliate_id=' . $order_info['affiliate_id'], 'SSL');
    		} else {
    			$this->data['affiliate'] = '';
    		}

    		$this->data['commission'] = $this->currency->format($order_info['commission'], $order_info['currency_code'], $order_info['currency_value']);

    		$this->load->model('sale/affiliate');

    		$this->data['commission_total'] = $this->model_sale_affiliate->getTotalTransactionsByOrderId($this->request->get['order_id']);

    		$this->load->model('localisation/order_status');

    		$order_status_info = $this->model_localisation_order_status->getOrderStatus($order_info['order_status_id']);

    		if ($order_status_info) {
    			$this->data['order_status'] = $order_status_info['name'];
    		} else {
    			$this->data['order_status'] = '';
    		}

    		$this->data['ip'] = $order_info['ip'];
    		$this->data['forwarded_ip'] = $order_info['forwarded_ip'];
    		$this->data['user_agent'] = $order_info['user_agent'];
    		$this->data['accept_language'] = $order_info['accept_language'];
    		$this->data['date_added'] = date($this->language->get('date_format_short'), strtotime($order_info['date_added']));
    		$this->data['date_modified'] = date($this->language->get('date_format_short'), strtotime($order_info['date_modified']));
    		$this->data['payment_firstname'] = $order_info['payment_firstname'];
    		$this->data['payment_lastname'] = $order_info['payment_lastname'];
    		$this->data['payment_company'] = $order_info['payment_company'];
    		$this->data['payment_company_id'] = $order_info['payment_company_id'];
    		$this->data['payment_tax_id'] = $order_info['payment_tax_id'];
    		$this->data['payment_address_1'] = $order_info['payment_address_1'];
    		$this->data['payment_address_2'] = $order_info['payment_address_2'];
    		$this->data['payment_city'] = $order_info['payment_city'];
    		$this->data['payment_postcode'] = $order_info['payment_postcode'];
    		$this->data['payment_zone'] = $order_info['payment_zone'];
    		$this->data['payment_zone_code'] = $order_info['payment_zone_code'];
    		$this->data['payment_country'] = $order_info['payment_country'];
    		$this->data['shipping_firstname'] = $order_info['shipping_firstname'];
    		$this->data['shipping_lastname'] = $order_info['shipping_lastname'];
    		$this->data['shipping_company'] = $order_info['shipping_company'];
    		$this->data['shipping_address_1'] = $order_info['shipping_address_1'];
    		$this->data['shipping_address_2'] = $order_info['shipping_address_2'];
    		$this->data['shipping_city'] = $order_info['shipping_city'];
    		$this->data['shipping_postcode'] = $order_info['shipping_postcode'];
    		$this->data['shipping_zone'] = $order_info['shipping_zone'];
    		$this->data['shipping_zone_code'] = $order_info['shipping_zone_code'];
    		$this->data['shipping_country'] = $order_info['shipping_country'];

    		$this->data['products'] = array();

    		$products = $this->model_sale_order->getOrderProducts($this->request->get['order_id']);

    		foreach ($products as $product) {
    			$option_data = array();

    			$options = $this->model_sale_order->getOrderOptions($this->request->get['order_id'], $product['order_product_id']);

    			foreach ($options as $option) {
    				if ($option['type'] != 'file') {
    					$option_data[] = array(
    						'name'  => $option['name'],
    						'value' => $option['value'],
    						'type'  => $option['type']
    					);
    				} else {
    					$option_data[] = array(
    						'name'  => $option['name'],
    						'value' => utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.')),
    						'type'  => $option['type'],
    						'href'  => $this->url->link('sale/order/download', 'token=' . $this->session->data['token'] . '&order_id=' . $this->request->get['order_id'] . '&order_option_id=' . $option['order_option_id'], 'SSL')
    					);
    				}
    			}

    			$this->data['products'][] = array(
    				'order_product_id' => $product['order_product_id'],
    				'product_id'       => $product['product_id'],
    				'name'    	 	   => $product['name'],
    				'model'    		   => $product['model'],
    				'option'   		   => $option_data,
    				'quantity'		   => $product['quantity'],
    				'price'    		   => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
    				'total'    		   => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
    				'href'     		   => $this->url->link('catalog/product/update', 'token=' . $this->session->data['token'] . '&product_id=' . $product['product_id'], 'SSL')
    			);
    		}

    		$this->data['vouchers'] = array();

    		$vouchers = $this->model_sale_order->getOrderVouchers($this->request->get['order_id']);

    		foreach ($vouchers as $voucher) {
    			$this->data['vouchers'][] = array(
    				'description' => $voucher['description'],
    				'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']),
    				'href'        => $this->url->link('sale/voucher/update', 'token=' . $this->session->data['token'] . '&voucher_id=' . $voucher['voucher_id'], 'SSL')
    			);
    		}

    		$this->data['totals'] = $this->model_sale_order->getOrderTotals($this->request->get['order_id']);

    		$this->data['downloads'] = array();

    		foreach ($products as $product) {
    			$results = $this->model_sale_order->getOrderDownloads($this->request->get['order_id'], $product['order_product_id']);

    			foreach ($results as $result) {
    				$this->data['downloads'][] = array(
    					'name'      => $result['name'],
    					'filename'  => $result['mask'],
    					'remaining' => $result['remaining']
    				);
    			}
    		}

    		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

    		$this->data['order_status_id'] = $order_info['order_status_id'];

			// Fraud
    		$this->load->model('sale/fraud');

    		$fraud_info = $this->model_sale_fraud->getFraud($order_info['order_id']);

    		if ($fraud_info) {
    			$this->data['country_match'] = $fraud_info['country_match'];

    			if ($fraud_info['country_code']) {
    				$this->data['country_code'] = $fraud_info['country_code'];
    			} else {
    				$this->data['country_code'] = '';
    			}

    			$this->data['high_risk_country'] = $fraud_info['high_risk_country'];
    			$this->data['distance'] = $fraud_info['distance'];

    			if ($fraud_info['ip_region']) {
    				$this->data['ip_region'] = $fraud_info['ip_region'];
    			} else {
    				$this->data['ip_region'] = '';
    			}

    			if ($fraud_info['ip_city']) {
    				$this->data['ip_city'] = $fraud_info['ip_city'];
    			} else {
    				$this->data['ip_city'] = '';
    			}

    			$this->data['ip_latitude'] = $fraud_info['ip_latitude'];
    			$this->data['ip_longitude'] = $fraud_info['ip_longitude'];

    			if ($fraud_info['ip_isp']) {
    				$this->data['ip_isp'] = $fraud_info['ip_isp'];
    			} else {
    				$this->data['ip_isp'] = '';
    			}

    			if ($fraud_info['ip_org']) {
    				$this->data['ip_org'] = $fraud_info['ip_org'];
    			} else {
    				$this->data['ip_org'] = '';
    			}

    			$this->data['ip_asnum'] = $fraud_info['ip_asnum'];

    			if ($fraud_info['ip_user_type']) {
    				$this->data['ip_user_type'] = $fraud_info['ip_user_type'];
    			} else {
    				$this->data['ip_user_type'] = '';
    			}

    			if ($fraud_info['ip_country_confidence']) {
    				$this->data['ip_country_confidence'] = $fraud_info['ip_country_confidence'];
    			} else {
    				$this->data['ip_country_confidence'] = '';
    			}

    			if ($fraud_info['ip_region_confidence']) {
    				$this->data['ip_region_confidence'] = $fraud_info['ip_region_confidence'];
    			} else {
    				$this->data['ip_region_confidence'] = '';
    			}

    			if ($fraud_info['ip_city_confidence']) {
    				$this->data['ip_city_confidence'] = $fraud_info['ip_city_confidence'];
    			} else {
    				$this->data['ip_city_confidence'] = '';
    			}

    			if ($fraud_info['ip_postal_confidence']) {
    				$this->data['ip_postal_confidence'] = $fraud_info['ip_postal_confidence'];
    			} else {
    				$this->data['ip_postal_confidence'] = '';
    			}

    			if ($fraud_info['ip_postal_code']) {
    				$this->data['ip_postal_code'] = $fraud_info['ip_postal_code'];
    			} else {
    				$this->data['ip_postal_code'] = '';
    			}

    			$this->data['ip_accuracy_radius'] = $fraud_info['ip_accuracy_radius'];

    			if ($fraud_info['ip_net_speed_cell']) {
    				$this->data['ip_net_speed_cell'] = $fraud_info['ip_net_speed_cell'];
    			} else {
    				$this->data['ip_net_speed_cell'] = '';
    			}

    			$this->data['ip_metro_code'] = $fraud_info['ip_metro_code'];
    			$this->data['ip_area_code'] = $fraud_info['ip_area_code'];

    			if ($fraud_info['ip_time_zone']) {
    				$this->data['ip_time_zone'] = $fraud_info['ip_time_zone'];
    			} else {
    				$this->data['ip_time_zone'] = '';
    			}

    			if ($fraud_info['ip_region_name']) {
    				$this->data['ip_region_name'] = $fraud_info['ip_region_name'];
    			} else {
    				$this->data['ip_region_name'] = '';
    			}

    			if ($fraud_info['ip_domain']) {
    				$this->data['ip_domain'] = $fraud_info['ip_domain'];
    			} else {
    				$this->data['ip_domain'] = '';
    			}

    			if ($fraud_info['ip_country_name']) {
    				$this->data['ip_country_name'] = $fraud_info['ip_country_name'];
    			} else {
    				$this->data['ip_country_name'] = '';
    			}

    			if ($fraud_info['ip_continent_code']) {
    				$this->data['ip_continent_code'] = $fraud_info['ip_continent_code'];
    			} else {
    				$this->data['ip_continent_code'] = '';
    			}

    			if ($fraud_info['ip_corporate_proxy']) {
    				$this->data['ip_corporate_proxy'] = $fraud_info['ip_corporate_proxy'];
    			} else {
    				$this->data['ip_corporate_proxy'] = '';
    			}

    			$this->data['anonymous_proxy'] = $fraud_info['anonymous_proxy'];
    			$this->data['proxy_score'] = $fraud_info['proxy_score'];

    			if ($fraud_info['is_trans_proxy']) {
    				$this->data['is_trans_proxy'] = $fraud_info['is_trans_proxy'];
    			} else {
    				$this->data['is_trans_proxy'] = '';
    			}

    			$this->data['free_mail'] = $fraud_info['free_mail'];
    			$this->data['carder_email'] = $fraud_info['carder_email'];

    			if ($fraud_info['high_risk_username']) {
    				$this->data['high_risk_username'] = $fraud_info['high_risk_username'];
    			} else {
    				$this->data['high_risk_username'] = '';
    			}

    			if ($fraud_info['high_risk_password']) {
    				$this->data['high_risk_password'] = $fraud_info['high_risk_password'];
    			} else {
    				$this->data['high_risk_password'] = '';
    			}

    			$this->data['bin_match'] = $fraud_info['bin_match'];

    			if ($fraud_info['bin_country']) {
    				$this->data['bin_country'] = $fraud_info['bin_country'];
    			} else {
    				$this->data['bin_country'] = '';
    			}

    			$this->data['bin_name_match'] = $fraud_info['bin_name_match'];

    			if ($fraud_info['bin_name']) {
    				$this->data['bin_name'] = $fraud_info['bin_name'];
    			} else {
    				$this->data['bin_name'] = '';
    			}

    			$this->data['bin_phone_match'] = $fraud_info['bin_phone_match'];

    			if ($fraud_info['bin_phone']) {
    				$this->data['bin_phone'] = $fraud_info['bin_phone'];
    			} else {
    				$this->data['bin_phone'] = '';
    			}

    			if ($fraud_info['customer_phone_in_billing_location']) {
    				$this->data['customer_phone_in_billing_location'] = $fraud_info['customer_phone_in_billing_location'];
    			} else {
    				$this->data['customer_phone_in_billing_location'] = '';
    			}

    			$this->data['ship_forward'] = $fraud_info['ship_forward'];

    			if ($fraud_info['city_postal_match']) {
    				$this->data['city_postal_match'] = $fraud_info['city_postal_match'];
    			} else {
    				$this->data['city_postal_match'] = '';
    			}

    			if ($fraud_info['ship_city_postal_match']) {
    				$this->data['ship_city_postal_match'] = $fraud_info['ship_city_postal_match'];
    			} else {
    				$this->data['ship_city_postal_match'] = '';
    			}

    			$this->data['score'] = $fraud_info['score'];
    			$this->data['explanation'] = $fraud_info['explanation'];
    			$this->data['risk_score'] = $fraud_info['risk_score'];
    			$this->data['queries_remaining'] = $fraud_info['queries_remaining'];
    			$this->data['maxmind_id'] = $fraud_info['maxmind_id'];
    			$this->data['error'] = $fraud_info['error'];
    		} else {
    			$this->data['maxmind_id'] = '';
    		}

    		if($this->hasAction('payment/' . $order_info['payment_code'] . '/orderAction') == true){
    			$this->data['payment_action'] = $this->getChild('payment/' . $order_info['payment_code'] . '/orderAction');
    		}else{
    			$this->data['payment_action'] = '';
    		}

    		$this->template = 'sale/order_info.tpl';
    		$this->children = array(
    			'common/header',
    			'common/footer'
    		);

    		$this->response->setOutput($this->render());
    	} else {
    		$this->language->load('error/not_found');

    		$this->document->setTitle($this->language->get('heading_title'));

    		$this->data['heading_title'] = $this->language->get('heading_title');

    		$this->data['text_not_found'] = $this->language->get('text_not_found');

    		$this->data['breadcrumbs'] = array();

    		$this->data['breadcrumbs'][] = array(
    			'text'      => $this->language->get('text_home'),
    			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
    			'separator' => false
    		);

    		$this->data['breadcrumbs'][] = array(
    			'text'      => $this->language->get('heading_title'),
    			'href'      => $this->url->link('error/not_found', 'token=' . $this->session->data['token'], 'SSL'),
    			'separator' => ' :: '
    		);

    		$this->template = 'error/not_found.tpl';
    		$this->children = array(
    			'common/header',
    			'common/footer'
    		);

    		$this->response->setOutput($this->render());
    	}
    }

    public function ustatus() {
        $this->language->load('sale/order');

        if ($this->user->hasPermission('modify', 'sale/order')) {
            $this->load->model('sale/order');

            $this->model_sale_order->updateStatus($this->request->get['order_id'], $this->request->get['status']);
        }

        $json['success'] = date("j.m.Y");

        $this->response->setOutput(json_encode($json));
    }

    public function createInvoiceNo() {
    	$this->language->load('sale/order');

    	$json = array();

    	if (!$this->user->hasPermission('modify', 'sale/order')) {
    		$json['error'] = $this->language->get('error_permission');
    	} elseif (isset($this->request->get['order_id'])) {
    		$this->load->model('sale/order');

    		$invoice_no = $this->model_sale_order->createInvoiceNo($this->request->get['order_id']);

    		if ($invoice_no) {
    			$json['invoice_no'] = $invoice_no;
    		} else {
    			$json['error'] = $this->language->get('error_action');
    		}
    	}

    	$this->response->setOutput(json_encode($json));
    }

    public function addCredit() {
    	$this->language->load('sale/order');

    	$json = array();

    	if (!$this->user->hasPermission('modify', 'sale/order')) {
    		$json['error'] = $this->language->get('error_permission');
    	} elseif (isset($this->request->get['order_id'])) {
    		$this->load->model('sale/order');

    		$order_info = $this->model_sale_order->getOrder($this->request->get['order_id']);

    		if ($order_info && $order_info['customer_id']) {
    			$this->load->model('sale/customer');

    			$credit_total = $this->model_sale_customer->getTotalTransactionsByOrderId($this->request->get['order_id']);

    			if (!$credit_total) {
    				$this->model_sale_customer->addTransaction($order_info['customer_id'], $this->language->get('text_order_id') . ' #' . $this->request->get['order_id'], $order_info['total'], $this->request->get['order_id']);

    				$json['success'] = $this->language->get('text_credit_added');
    			} else {
    				$json['error'] = $this->language->get('error_action');
    			}
    		}
    	}

    	$this->response->setOutput(json_encode($json));
    }

    public function removeCredit() {
    	$this->language->load('sale/order');

    	$json = array();

    	if (!$this->user->hasPermission('modify', 'sale/order')) {
    		$json['error'] = $this->language->get('error_permission');
    	} elseif (isset($this->request->get['order_id'])) {
    		$this->load->model('sale/order');

    		$order_info = $this->model_sale_order->getOrder($this->request->get['order_id']);

    		if ($order_info && $order_info['customer_id']) {
    			$this->load->model('sale/customer');

    			$this->model_sale_customer->deleteTransaction($this->request->get['order_id']);

    			$json['success'] = $this->language->get('text_credit_removed');
    		} else {
    			$json['error'] = $this->language->get('error_action');
    		}
    	}

    	$this->response->setOutput(json_encode($json));
    }

    public function addReward() {
    	$this->language->load('sale/order');

    	$json = array();

    	if (!$this->user->hasPermission('modify', 'sale/order')) {
    		$json['error'] = $this->language->get('error_permission');
    	} elseif (isset($this->request->get['order_id'])) {
    		$this->load->model('sale/order');

    		$order_info = $this->model_sale_order->getOrder($this->request->get['order_id']);

    		if ($order_info && $order_info['customer_id']) {
    			$this->load->model('sale/customer');

    			$reward_total = $this->model_sale_customer->getTotalCustomerRewardsByOrderId($this->request->get['order_id']);

    			if (!$reward_total) {
    				$this->model_sale_customer->addReward($order_info['customer_id'], $this->language->get('text_order_id') . ' #' . $this->request->get['order_id'], $order_info['reward'], $this->request->get['order_id']);

    				$json['success'] = $this->language->get('text_reward_added');
    			} else {
    				$json['error'] = $this->language->get('error_action');
    			}
    		} else {
    			$json['error'] = $this->language->get('error_action');
    		}
    	}

    	$this->response->setOutput(json_encode($json));
    }

    public function removeReward() {
    	$this->language->load('sale/order');

    	$json = array();

    	if (!$this->user->hasPermission('modify', 'sale/order')) {
    		$json['error'] = $this->language->get('error_permission');
    	} elseif (isset($this->request->get['order_id'])) {
    		$this->load->model('sale/order');

    		$order_info = $this->model_sale_order->getOrder($this->request->get['order_id']);

    		if ($order_info && $order_info['customer_id']) {
    			$this->load->model('sale/customer');

    			$this->model_sale_customer->deleteReward($this->request->get['order_id']);

    			$json['success'] = $this->language->get('text_reward_removed');
    		} else {
    			$json['error'] = $this->language->get('error_action');
    		}
    	}

    	$this->response->setOutput(json_encode($json));
    }

    public function addCommission() {
    	$this->language->load('sale/order');

    	$json = array();

    	if (!$this->user->hasPermission('modify', 'sale/order')) {
    		$json['error'] = $this->language->get('error_permission');
    	} elseif (isset($this->request->get['order_id'])) {
    		$this->load->model('sale/order');

    		$order_info = $this->model_sale_order->getOrder($this->request->get['order_id']);

    		if ($order_info && $order_info['affiliate_id']) {
    			$this->load->model('sale/affiliate');

    			$affiliate_total = $this->model_sale_affiliate->getTotalTransactionsByOrderId($this->request->get['order_id']);

    			if (!$affiliate_total) {
    				$this->model_sale_affiliate->addTransaction($order_info['affiliate_id'], $this->language->get('text_order_id') . ' #' . $this->request->get['order_id'], $order_info['commission'], $this->request->get['order_id']);

    				$json['success'] = $this->language->get('text_commission_added');
    			} else {
    				$json['error'] = $this->language->get('error_action');
    			}
    		} else {
    			$json['error'] = $this->language->get('error_action');
    		}
    	}

    	$this->response->setOutput(json_encode($json));
    }

    public function removeCommission() {
    	$this->language->load('sale/order');

    	$json = array();

    	if (!$this->user->hasPermission('modify', 'sale/order')) {
    		$json['error'] = $this->language->get('error_permission');
    	} elseif (isset($this->request->get['order_id'])) {
    		$this->load->model('sale/order');

    		$order_info = $this->model_sale_order->getOrder($this->request->get['order_id']);

    		if ($order_info && $order_info['affiliate_id']) {
    			$this->load->model('sale/affiliate');

    			$this->model_sale_affiliate->deleteTransaction($this->request->get['order_id']);

    			$json['success'] = $this->language->get('text_commission_removed');
    		} else {
    			$json['error'] = $this->language->get('error_action');
    		}
    	}

    	$this->response->setOutput(json_encode($json));
    }

    public function history() {
    	$this->language->load('sale/order');

    	$this->data['error'] = '';
    	$this->data['success'] = '';

    	$this->load->model('sale/order');

    	if ($this->request->server['REQUEST_METHOD'] == 'POST') {
    		if (!$this->user->hasPermission('modify', 'sale/order')) {
    			$this->data['error'] = $this->language->get('error_permission');
    		}

    		if (!$this->data['error']) {
    			$this->model_sale_order->addOrderHistory($this->request->get['order_id'], $this->request->post);

    			$this->data['success'] = $this->language->get('text_success');
    		}
    	}

    	$this->data['text_no_results'] = $this->language->get('text_no_results');

    	$this->data['column_date_added'] = $this->language->get('column_date_added');
    	$this->data['column_status'] = $this->language->get('column_status');
    	$this->data['column_notify'] = $this->language->get('column_notify');
    	$this->data['column_comment'] = $this->language->get('column_comment');

    	if (isset($this->request->get['page'])) {
    		$page = $this->request->get['page'];
    	} else {
    		$page = 1;
    	}

    	$this->data['histories'] = array();

    	$results = $this->model_sale_order->getOrderHistories($this->request->get['order_id'], ($page - 1) * 10, 10);

    	foreach ($results as $result) {
    		$this->data['histories'][] = array(
    			'notify'     => $result['notify'] ? $this->language->get('text_yes') : $this->language->get('text_no'),
    			'status'     => $result['status'],
    			'comment'    => nl2br($result['comment']),
    			'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
    		);
    	}

    	$history_total = $this->model_sale_order->getTotalOrderHistories($this->request->get['order_id']);

    	$pagination = new Pagination();
    	$pagination->total = $history_total;
    	$pagination->page = $page;
    	$pagination->limit = 10;
    	$pagination->text = $this->language->get('text_pagination');
    	$pagination->url = $this->url->link('sale/order/history', 'token=' . $this->session->data['token'] . '&order_id=' . $this->request->get['order_id'] . '&page={page}', 'SSL');

    	$this->data['pagination'] = $pagination->render();

    	$this->template = 'sale/order_history.tpl';

    	$this->response->setOutput($this->render());
    }

    public function download() {
    	$this->load->model('sale/order');

    	if (isset($this->request->get['order_option_id'])) {
    		$order_option_id = $this->request->get['order_option_id'];
    	} else {
    		$order_option_id = 0;
    	}

    	$option_info = $this->model_sale_order->getOrderOption($this->request->get['order_id'], $order_option_id);

    	if ($option_info && $option_info['type'] == 'file') {
    		$file = DIR_DOWNLOAD . $option_info['value'];
    		$mask = basename(utf8_substr($option_info['value'], 0, utf8_strrpos($option_info['value'], '.')));

    		if (!headers_sent()) {
    			if (file_exists($file)) {
    				header('Content-Type: application/octet-stream');
    				header('Content-Description: File Transfer');
    				header('Content-Disposition: attachment; filename="' . ($mask ? $mask : basename($file)) . '"');
    				header('Content-Transfer-Encoding: binary');
    				header('Expires: 0');
    				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    				header('Pragma: public');
    				header('Content-Length: ' . filesize($file));

    				readfile($file, 'rb');
    				exit;
    			} else {
    				exit('Error: Could not find file ' . $file . '!');
    			}
    		} else {
    			exit('Error: Headers already sent out!');
    		}
    	} else {
    		$this->language->load('error/not_found');

    		$this->document->setTitle($this->language->get('heading_title'));

    		$this->data['heading_title'] = $this->language->get('heading_title');

    		$this->data['text_not_found'] = $this->language->get('text_not_found');

    		$this->data['breadcrumbs'] = array();

    		$this->data['breadcrumbs'][] = array(
    			'text'      => $this->language->get('text_home'),
    			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
    			'separator' => false
    		);

    		$this->data['breadcrumbs'][] = array(
    			'text'      => $this->language->get('heading_title'),
    			'href'      => $this->url->link('error/not_found', 'token=' . $this->session->data['token'], 'SSL'),
    			'separator' => ' :: '
    		);

    		$this->template = 'error/not_found.tpl';
    		$this->children = array(
    			'common/header',
    			'common/footer'
    		);

    		$this->response->setOutput($this->render());
    	}
    }

    public function upload() {
    	$this->language->load('sale/order');

    	$json = array();

    	if ($this->request->server['REQUEST_METHOD'] == 'POST') {
    		if (!empty($this->request->files['file']['name'])) {
    			$filename = html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8');

    			if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 128)) {
    				$json['error'] = $this->language->get('error_filename');
    			}

				// Allowed file extension types
    			$allowed = array();

    			$filetypes = explode("\n", $this->config->get('config_file_extension_allowed'));

    			foreach ($filetypes as $filetype) {
    				$allowed[] = trim($filetype);
    			}

    			if (!in_array(substr(strrchr($filename, '.'), 1), $allowed)) {
    				$json['error'] = $this->language->get('error_filetype');
    			}

				// Allowed file mime types
    			$allowed = array();

    			$filetypes = explode("\n", $this->config->get('config_file_mime_allowed'));

    			foreach ($filetypes as $filetype) {
    				$allowed[] = trim($filetype);
    			}

    			if (!in_array($this->request->files['file']['type'], $allowed)) {
    				$json['error'] = $this->language->get('error_filetype');
    			}

				// Check to see if any PHP files are trying to be uploaded
    			$content = file_get_contents($this->request->files['file']['tmp_name']);

    			if (preg_match('/\<\?/i', $content)) {
    				$json['error'] = $this->language->get('error_filetype');
    			}

    			if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
    				$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
    			}
    		} else {
    			$json['error'] = $this->language->get('error_upload');
    		}

    		if (!isset($json['error'])) {
    			if (is_uploaded_file($this->request->files['file']['tmp_name']) && file_exists($this->request->files['file']['tmp_name'])) {
    				$file = basename($filename) . '.' . md5(mt_rand());

    				$json['file'] = $file;

    				move_uploaded_file($this->request->files['file']['tmp_name'], DIR_DOWNLOAD . $file);
    			}

    			$json['success'] = $this->language->get('text_upload');
    		}
    	}

    	$this->response->setOutput(json_encode($json));
    }

    public function invoice() {
        $this->language->load('sale/order');
        $this->load->helper('spreadsheet');

        $this->data['title'] = $this->language->get('heading_title');

        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $this->data['base'] = HTTPS_SERVER;
        } else {
            $this->data['base'] = HTTP_SERVER;
        }

        $this->data['direction'] = $this->language->get('direction');
        $this->data['language'] = $this->language->get('code');

        $this->data['text_invoice'] = $this->language->get('text_invoice');

        $this->data['text_order_id'] = $this->language->get('text_order_id');
        $this->data['text_invoice_no'] = $this->language->get('text_invoice_no');
        $this->data['text_invoice_date'] = $this->language->get('text_invoice_date');
        $this->data['text_date_added'] = $this->language->get('text_date_added');
        $this->data['text_telephone'] = $this->language->get('text_telephone');
        $this->data['text_fax'] = $this->language->get('text_fax');
        $this->data['text_to'] = $this->language->get('text_to');
        $this->data['text_company_id'] = $this->language->get('text_company_id');
        $this->data['text_tax_id'] = $this->language->get('text_tax_id');
        $this->data['text_ship_to'] = $this->language->get('text_ship_to');
        $this->data['text_payment_method'] = $this->language->get('text_payment_method');
        $this->data['text_shipping_method'] = $this->language->get('text_shipping_method');

        $this->data['column_product'] = $this->language->get('column_product');
        $this->data['column_model'] = $this->language->get('column_model');
        $this->data['column_quantity'] = $this->language->get('column_quantity');
        $this->data['column_price'] = $this->language->get('column_price');
        $this->data['column_total'] = $this->language->get('column_total');
        $this->data['column_comment'] = $this->language->get('column_comment');

        $this->load->model('sale/order');
        $this->load->model('tool/image');
        $this->load->model('setting/setting');

        $this->data['orders'] = array();

        $orders = array();

        if (isset($this->request->post['selected'])) {
            $orders = $this->request->post['selected'];
        } elseif (isset($this->request->get['order_id'])) {
            $orders[] = $this->request->get['order_id'];
        }

        if (!empty($orders)) {
            foreach ($orders as $order_id) {
                $order_info = $this->model_sale_order->getOrder($order_id);

                if ($order_info) {
                    $store_info = $this->model_setting_setting->getSetting('config', $order_info['store_id']);

                    if ($store_info) {
                        $store_address = $store_info['config_address'];
                        $store_email = $store_info['config_email'];
                        $store_telephone = $store_info['config_telephone'];
                        $store_fax = $store_info['config_fax'];
                    } else {
                        $store_address = $this->config->get('config_address');
                        $store_email = $this->config->get('config_email');
                        $store_telephone = $this->config->get('config_telephone');
                        $store_fax = $this->config->get('config_fax');
                    }

                    if ($order_info['invoice_no']) {
                        $invoice_no = $order_info['invoice_prefix'] . $order_info['invoice_no'];
                    } else {
                        $invoice_no = '';
                    }

                    $customer_type = '';

                    $middlename = '';

                    $inn = '';
                    $kpp = '';
                    $okpo = '';
                    $company_telefon = '';
                    $custom_company = '';

                    if (!$order_info['customer_id']) {
                        $customer_custom = $this->db->query("SELECT `data` FROM `simple_custom_data` WHERE customer_id = '0' AND object_type = '1' AND object_id = '{$order_info['order_id']}'")->row;
                    } else {
                        $customer_custom = $this->db->query("SELECT `data` FROM `simple_custom_data` WHERE customer_id = '{$order_info['customer_id']}' AND object_type = '1' AND object_id = '{$order_info['order_id']}'")->row;
                    }

                    if (isset($customer_custom['data'])) {
                        $customer_custom = unserialize($customer_custom['data']);

                        $customer_type = isset($customer_custom['custom_customer_type']) ? "{$customer_custom['custom_customer_type']['text']}": '';
                        $middlename = isset($customer_custom['custom_middlename']) ? "{$customer_custom['custom_middlename']['value']}": '';

                        if ($customer_type == 'ip') {
                            $inn = !empty($customer_custom['custom_inn']) ? "ИНН {$customer_custom['custom_inn']['value']}" : '';
                            $kpp = !empty($customer_custom['custom_kpp']) ? "КПП {$customer_custom['custom_kpp']['value']}" : '';
                            $okpo = !empty($customer_custom['custom_okpo']) ? "{$customer_custom['custom_okpo']['value']}" : '';
                            $company_telefon = !empty($customer_custom['custom_company_telefon']) ? "{$customer_custom['custom_company_telefon']['value']}" : '';
                            $custom_company = !empty($customer_custom['custom_company']) ? "{$customer_custom['custom_company']['value']}" : '';
                        } elseif ($customer_type == 'legal') {
                            $inn = !empty($customer_custom['custom_legal_inn']) ? "ИНН {$customer_custom['custom_legal_inn']['value']}" : '';
                            $kpp = !empty($customer_custom['custom_legal_kpp']) ? "КПП {$customer_custom['custom_legal_kpp']['value']}" : '';
                            $okpo = !empty($customer_custom['custom_legal_okpo']) ? "{$customer_custom['custom_legal_okpo']['value']}" : '';
                            $company_telefon = !empty($customer_custom['custom_legal_company_telefon']) ? "{$customer_custom['custom_legal_company_telefon']['value']}" : '';
                            $custom_company = !empty($customer_custom['custom_legal_company']) ? "{$customer_custom['custom_legal_company']['value']}" : '';
                        }
                    }

                    $tasks = '';

                    if ($order_info['customer_id']) {
                        $customer_tasks = $this->db->query("SELECT `data` FROM `simple_custom_data` WHERE customer_id = '{$order_info['customer_id']}' AND object_type = '2'")->row;
                    }

                    if (isset($customer_tasks['data'])) {
                        $customer_tasks = unserialize($customer_tasks['data']);

                        $tasksIds = [
                            'custom_warehouse_tasks',
                            'custom_manager_tasks',
                            'custom_special_comments',
                        ];

                        foreach ($customer_tasks as $id => $customerTask) {
                            if (in_array($id, $tasksIds) && !empty($customerTask['value'])) {
                                $tasks[$id] = [
                                    'label' => $customerTask['label'],
                                    'value' => $customerTask['value'],
                                ];
                            }
                        }
                    }

                    if ($order_info['shipping_address_format']) {
                        $format = $order_info['shipping_address_format'];
                    } else {
                        $format = '{lastname} {firstname}' . "\n" . '{postcode}' . "\n" . '{zone}' . "\n" . '{city}' . "\n" . '{address_1}' . "\n" . '{address_2}';
                    }

                    $find = [
                        '{customer_type}',
                        '{patronymic}',
                        '{inn}',
                        '{kpp}',
                        '{custom_company}',
						
                        '{firstname}',
                        '{lastname}',
                        '{company}',
                        '{address_1}',
                        '{address_2}',
                        '{city}',
                        '{postcode}',
                        '{zone}',
                        '{zone_code}',
                        '{country}'
                    ];

                    $replace = array(
                        'customer_type'  => $customer_type,
                        'patronymic'     => $middlename,

                        'inn'            => $inn,
                        'kpp'            => $kpp,
                        'custom_company' => $custom_company,
						
                        'firstname' => $order_info['shipping_firstname'],
                        'lastname'  => $order_info['shipping_lastname'],
                        'company'   => $order_info['shipping_company'],
                        'address_1' => $order_info['shipping_address_1'],
                        'address_2' => $order_info['shipping_address_2'],
                        'city'      => $order_info['shipping_city'],
                        'postcode'  => $order_info['shipping_postcode'],
                        'zone'      => $order_info['shipping_zone'],
                        'zone_code' => $order_info['shipping_zone_code'],
                        'country'   => $order_info['shipping_country']
                    );
					
                    if (strlen($replace['custom_company'])) {
                        $format = '{custom_company}' . "\n" . '{postcode}' . "\n" . '{zone}' . "\n" . '{city}' . "\n" . '{address_1}' . "\n" . '{address_2}';
                    }
						
                    $shipping_address = str_replace(array("\r\n", "\r", "\n"), ', ', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), ' ,', trim(str_replace($find, $replace, $format))));

                    $find = [
                        '{customer_type}',
                        '{patronymic}',

                        '{inn}',
                        '{kpp}',
                        '{custom_company}',

                        '{firstname}',
                        '{lastname}',
                        '{company}',
                        '{address_1}',
                        '{address_2}',
                        '{city}',
                        '{postcode}',
                        '{zone}',
                        '{zone_code}',
                        '{country}'
                    ];

                    $replace = [
                        'customer_type'  => $customer_type,
                        'patronymic'     => $middlename,

                        'inn'            => $inn,
                        'kpp'            => $kpp,
                        'custom_company' => $custom_company,

                        'firstname'      => $order_info['payment_firstname'],
                        'lastname'       => $order_info['payment_lastname'],
                        'company'        => $order_info['payment_company'],
                        'address_1'      => $order_info['payment_address_1'],
                        'address_2'      => $order_info['payment_address_2'],
                        'city'           => $order_info['payment_city'],
                        'postcode'       => $order_info['payment_postcode'],
                        'zone'           => $order_info['payment_zone'],
                        'zone_code'      => $order_info['payment_zone_code'],
                        'country'        => $order_info['payment_country']
                    ];

                    if ($order_info['payment_address_format']) {
                        $format = $order_info['payment_address_format'];
                    } else {
                        if (strlen($custom_company)) {
                            $format = '{custom_company}'."\n".'{inn}'."\n".'{kpp}'."\n".'{postcode}'."\n".'{zone}'."\n".'{city}'."\n".'{address_1}'."\n".'{address_2}';
                        } else {
                            $format = '{customer_type} {lastname} {firstname} {patronymic}' . "\n" . '{inn}' . "\n" . '{kpp}' . "\n" . '{company}' . "\n" . '{postcode}' . "\n" . '{zone}' . "\n" . '{city}' . "\n" . '{address_1}' . "\n" . '{address_2}';
                        }
                    }

                    $payment_address = str_replace(array("\r\n", "\r", "\n"), ', ', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), ', ', trim(str_replace($find, $replace, $format))));

                    $product_data = array();

                    $imagewidth = 50;
                    $imageheight = 50;

                    $products = $this->model_sale_order->getOrderProducts($order_id);

                    foreach ($products as $product) {
                        $report_name = $this->model_sale_order->getReportName($product['product_id']);

                        $image = $this->model_sale_order->getProductImage($product['product_id']);

                        $option_data = array();

                        $options = $this->model_sale_order->getOrderOptions($order_id, $product['order_product_id']);

                        foreach ($options as $option) {
                            if ($option['type'] != 'file') {
                                $value = $option['value'];
                            } else {
                                $value = utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.'));
                            }

                            $option_data[] = array(
                                'name'  => $option['name'],
                                'value' => $value
                            );

                            $kod = $this->model_sale_order->getOrderOptionKod($order_id, $option['order_option_id']);
                            $color = $this->model_sale_order->getOrderOptionColor($order_id, $option['order_option_id']);

                            $option_image = $this->model_sale_order->getProducOptiontImage($option['product_option_value_id']);
                            if ($option_image) {
                                $image = $option_image;
                            }
                        }

                        $weight = $this->model_sale_order->getProductWeight($product['product_id']);

                        if ($image) {
                            $thumb = $this->model_tool_image->resize($image, $imagewidth, $imageheight);
                        } else {
                            $thumb = false;
                        }

                        if (!$thumb) {
                            $thumb = $this->model_tool_image->resize('no_image.jpg', $imagewidth, $imageheight);
                        }

                        $product_data[] = array(
                            'name'        => $product['name'],
                            'model'       => $product['model'],
                            'thumb'       => $thumb,
                            'option'      => $option_data,
                            'quantity'    => $product['quantity'],
                            'report_name' => $report_name,
                            'weight'      => $weight,
                            'price'       => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
                            'total'       => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value'])
                        );
                    }

                    $voucher_data = array();

                    $vouchers = $this->model_sale_order->getOrderVouchers($order_id);

                    foreach ($vouchers as $voucher) {
                        $voucher_data[] = array(
                            'description' => $voucher['description'],
                            'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value'])
                        );
                    }

                    $total_data = $this->model_sale_order->getOrderTotals($order_id);

                    $telephone = $order_info['telephone'];

                    if ($company_telefon) {
                        $telephone = $company_telefon;
                    }

                    $this->data['orders'][] = array(
                        'order_id'           => $order_id,
                        'invoice_no'         => $invoice_no,
                        'okpo'               => $okpo,
                        'company_telefon'    => $company_telefon,
                        'date_added'         => date($this->language->get('date_format_time'), strtotime($order_info['date_added'])),
                        'store_name'         => $order_info['store_name'],
                        'store_url'          => rtrim($order_info['store_url'], '/'),
                        'store_address'      => nl2br($store_address),
                        'store_email'        => $store_email,
                        'store_telephone'    => $store_telephone,
                        'store_fax'          => $store_fax,
                        'email'              => $order_info['email'],
                        'telephone'          => $telephone,
                        'shipping_address'   => $shipping_address,
                        'shipping_code'      => $order_info['shipping_code'],
                        'shipping_method'    => $order_info['shipping_method'],
                        'payment_address'    => $payment_address,
                        'payment_company_id' => $order_info['payment_company_id'],
                        'payment_tax_id'     => $order_info['payment_tax_id'],
                        'payment_method'     => $order_info['payment_method'],
                        'product'            => $product_data,
                        'voucher'            => $voucher_data,
                        'total'              => $total_data,
                        'tasks'              => $tasks,
                        'comment'            => nl2br($order_info['comment'])
                    );
                }
            }

            $orders_data = $this->data['orders'];

            $doctype = '';

            if (isset($this->request->get['doctype'])) {
                $doctype = $this->request->get['doctype'];
                $this->template = 'sale/documents/order_' . $doctype . '.tpl';

                if ($doctype == 'invoice' || $doctype == 'torg12') {
                    include_once DIR_SYSTEM . 'library/invoice/ControllerWaybill.php';

                    $waybill = new ControllerWaybill($this->registry);

                    $waybill->invoice($orders);
                } else {
                    $this->response->setOutput($this->render());
                }
            } else {
                $this->template = 'sale/order_invoice.tpl';

                if (isset($this->request->get['excel']) || isset($this->request->get['excel7'])) {
                    $order_ids = array();
                    foreach ($orders_data as $order) {
                        $order_ids[] = $order['order_id'];
                    }

                    $order_ids = implode("_", $order_ids);

                    $spreadsheet = $this->make_spreadsheet($orders_data, true);

                    ob_start();
                    $writer = new Xlsx($spreadsheet);
                    $writer->save('php://output');
                    $excelOutput = ob_get_clean();

                    $this->response->addheader('Cache-Control: public');// needed for internet explorer
                    $this->response->addheader('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    $this->response->addheader('Content-Transfer-Encoding: binary');
                    $this->response->addheader('Content-Disposition: attachment; filename=Заказ_' . $order_ids . '.xlsx');

                    if (function_exists('mb_strlen')) {
                        header("Content-Length:" . mb_strlen($excelOutput, '8bit'));
                    } else {
                        header("Content-Length:" . strlen($excelOutput));
                    }

                    $this->response->setOutput($excelOutput);
                } else {
                    $this->response->setOutput($this->render());
                }
            }
        } else {
            $this->response->setOutput('Не выбран заказ!');
        }
    }

    /**
     * Создаёт таблицу Excel xlsx
     * @param $orders array Массив заказов
     * @param $grid bool отображать сетку
     *
     * @return Spreadsheet
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function make_spreadsheet($orders, $grid = false) {
    	$order_ids = array();
    	foreach ($orders as $order) {
    		$order_ids[] = $order['order_id'];
    	}
    	$order_ids = implode(", ", $order_ids);

    	$date = '';
    	if (count($orders) == 1) {
    		$order = current($orders);
    		$date = ' от ' . $order['date_added'] . 'г.';
    	}

    	$font8 = [
    		'font' => [
    			'name' => 'Arial',
    			'bold' => false,
    			'size' => 8,
    		],
    		'alignment' => [
    			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    		],
    	];

    	$font9 = [
    		'font' => [
    			'name' => 'Arial',
    			'bold' => false,
    			'size' => 9,
    		],
    		'alignment' => [
    			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
    		],
    	];

    	$font9b = [
    		'font' => [
    			'name' => 'Arial',
    			'bold' => true,
    			'size' => 9,
    		],
    		'alignment' => [
    			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
    		],
    	];

    	$font10 = [
    		'font' => [
    			'name' => 'Arial',
    			'bold' => false,
    			'size' => 10,
    		],
    		'alignment' => [
    			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
    		],
    	];

    	$border_thin = [
    		'borders' => [
    			'outline' => [
    				'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    			],
    		],
    	];

    	$spreadsheet = new Spreadsheet();
    	$spreadsheet->setActiveSheetIndex(0);
    	$sheet = $spreadsheet->getActiveSheet();

    	$spreadsheet->getDefaultStyle()->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
    	$spreadsheet->getDefaultStyle()->getFont()->setSize(10)->setName('Arial');

    	$spreadsheet->getProperties()
    	->setCreator("admin")
    	->setLastModifiedBy("admin")
    	->setTitle("Заказ № {$order_ids}")
    	->setSubject("Заказ № {$order_ids}")
    	->setDescription(
    		"Заказ № {$order_ids}{$date}"
    	)
    	->setKeywords("office 2007 openxml php")
    	->setCategory("Заказ");
    	$sheet->getStyle('B1:AL50')->getAlignment()->setIndent(1);

    	$sheet->getPageMargins()->setTop(0.1);
    	$sheet->getPageMargins()->setRight(0);
    	$sheet->getPageMargins()->setLeft(0.1);
    	$sheet->getPageMargins()->setBottom(0);

    	$sheet->getPageSetup()->setHorizontalCentered(true);
    	$sheet->getPageSetup()->setVerticalCentered(false);

    	$sheet->getPageSetup()->setFitToWidth(1);
    	$sheet->getPageSetup()->setFitToHeight(0);
    	$sheet->getPageSetup()->setOrientation('portrait');

    	$sheet->setShowGridlines($grid);

    	for ($r = 1;$r < 40;$r++) {
    		$sheet->getColumnDimensionByColumn($r)->setWidth(3.5);
    	}

    	/* задаём ширину колонок */
    	$sheet->getColumnDimension("A")->setWidth(1);
    	$sheet->getColumnDimension("AM")->setWidth(1);

    	$r = 1;

    	foreach ($orders as $order) {

    		$sheet->mergeCells("A$r:AM$r");$sheet->getRowDimension($r)->setRowHeight(6); $r++;

            $sheet->mergeCells("B$r:AL$r"); // 2
            $sheet->getStyle("B$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B$r:AL$r")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle("B$r:AL$r")->applyFromArray($font8);
            $sheet->getStyle("B$r:AL$r")->getAlignment()->setWrapText(true);
            $sheet->getRowDimension($r)->setRowHeight(32);
            $sheet->setCellValue("B$r", 'Внимание! Оплата данного счета означает согласие с условиями поставки товара. Уведомление об оплате обязательно, в противном случае не гарантируется наличие товара на складе. Товар отпускается по факту прихода денег на р/с Поставщика, самовывозом, при наличии доверенности и паспорта.');
            $r++;

            $sheet->mergeCells("A$r:AM$r");$sheet->getRowDimension($r)->setRowHeight(6); $r++;

            $sheet->getStyle("B$r:AL".($r+6))->applyFromArray($font10); // 4
            $sheet->mergeCells("B$r:S".($r+1));
            $sheet->setCellValue("B$r", 'СБЕРБАНК РОССИИ ПАО Г. МОСКВА');
            $sheet->getStyle("B$r:S".($r+2))->applyFromArray($border_thin);
            $sheet->mergeCells("T$r:V$r");
            $sheet->setCellValue("T$r", 'БИК');
            $sheet->getStyle("T$r:V$r")->applyFromArray($border_thin);
            $sheet->mergeCells("W$r:AL$r");
            $sheet->setCellValue("W$r", '044525225');
            $sheet->getStyle("W$r:AL".($r+2))->applyFromArray($border_thin);
            $r++;

            $sheet->mergeCells("T$r:V".($r+1));
            $sheet->setCellValue("T$r", 'Сч. №');
            $sheet->getStyle("T$r:V".($r+1))->applyFromArray($border_thin);
            $sheet->mergeCells("W$r:AL".($r+1));
            $sheet->setCellValue("W$r", '30101810400000000225');
            $r++;


            $sheet->mergeCells("B$r:S$r"); // 6
            $sheet->getStyle("B$r:S$r")->applyFromArray($font8);
            $sheet->getStyle("B$r:S$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet->setCellValue("B$r", 'Банк получателя');
            $r++;

            $sheet->mergeCells("B$r:D$r");
            $sheet->setCellValue("B$r", 'ИНН');
            $sheet->mergeCells("E$r:J$r");
            $sheet->setCellValueExplicit("E$r", '502919620199', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->getStyle("B$r:J$r")->applyFromArray($border_thin);
            $sheet->mergeCells("K$r:M$r");
            $sheet->setCellValue("K$r", 'КПП');
            $sheet->mergeCells("N$r:S$r");
            $sheet->setCellValue("N$r", ' ');
            $sheet->getStyle("K$r:S$r")->applyFromArray($border_thin);
            $sheet->mergeCells("T$r:V".($r+3));
            $sheet->setCellValue("T$r", 'Сч. №');
            $sheet->getStyle("T$r:V".($r+3))->applyFromArray($border_thin);
            $sheet->mergeCells("W$r:AL".($r+3));
            $sheet->setCellValue("W$r", '40802810140000117404');
            $sheet->getStyle("W$r:AL".($r+3))->applyFromArray($border_thin);
            $r++;

            $sheet->mergeCells("B$r:S".($r+1)); // 8
            $sheet->getStyle("B$r:S$r")->getAlignment()->setWrapText(true);
            $sheet->setCellValue("B$r", 'Индивидуальный предприниматель Подоляко Александр Валерьевич');
            $sheet->getStyle("B$r:S".($r+2))->applyFromArray($border_thin);
            $r++;

            $r++;

            $sheet->mergeCells("B$r:S$r"); // 10
            $sheet->getStyle("B$r:S$r")->applyFromArray($font8);
            $sheet->getStyle("B$r:S$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet->setCellValue("B$r", 'Получатель');
            $r++;

            $sheet->mergeCells("A$r:AM$r");$sheet->getRowDimension($r)->setRowHeight(6); $r++;

            $sheet->getStyle("B$r:AL".($r+10))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

            $date = strtotime($order['date_added']); // 12
            setlocale(LC_ALL, 'ru_RU.UTF-8');
            $sheet->mergeCells("B$r:AL$r");
            $sheet->getStyle("B$r:AL$r")->getFont()->setSize(14)->setBold(true);
            $sheet->getRowDimension($r)->setRowHeight(24);
            $sheet->getStyle("B$r:AL$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("B$r:AL$r")->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
            $sheet->setCellValue("B$r", 'Счет-заказ № ' . $order['order_id'] . ' от ' . strftime('%d %B %Y', $date) . ' г.');
            $r++;

            $sheet->mergeCells("A$r:AM$r");$sheet->getRowDimension($r)->setRowHeight(6); $r++;

            $sheet->getStyle("B$r:G$r")->applyFromArray($font9);
            $sheet->getRowDimension($r)->setRowHeight(30);
            $sheet->mergeCells("B$r:G$r"); // 14
            $sheet->setCellValue("B$r", 'Поставщик');
            $sheet->getStyle("H$r:AL$r")->applyFromArray($font9b);
            $sheet->mergeCells("H$r:AL$r");
            $sheet->getStyle("H$r:AL$r")->getAlignment()->setWrapText(true);
            $sheet->setCellValue("H$r", 'Индивидуальный предприниматель Подоляко Александр Валерьевич, ИНН 502919620199, Московская обл., Мытищи, ул.Колпакова, дом № 40, корпус 3, кв.66, тел.: +7 (985) 092-92-91');
            $r++;

            $sheet->mergeCells("A$r:AM$r");$sheet->getRowDimension($r)->setRowHeight(6); $r++;

            $sheet->getStyle("B$r:G$r")->applyFromArray($font9);
            $sheet->getRowDimension($r)->setRowHeight(30);
            $sheet->mergeCells("B$r:G$r"); // 16
            $sheet->setCellValue("B$r", 'Грузоотправитель');
            $sheet->getStyle("H$r:AL$r")->applyFromArray($font9b);
            $sheet->mergeCells("H$r:AL$r");
            $sheet->getStyle("H$r:AL$r")->getAlignment()->setWrapText(true);
            $sheet->setCellValue("H$r", 'Индивидуальный предприниматель Подоляко Александр Валерьевич, ИНН 502919620199, Московская обл., Мытищи, ул.Колпакова, дом № 40, корпус 3, кв.66, тел.: +7 (985) 092-92-91');
            $r++;

            $sheet->mergeCells("A$r:AM$r");$sheet->getRowDimension($r)->setRowHeight(6); $r++;

            $sheet->getStyle("B$r:G$r")->applyFromArray($font9);
            $sheet->getRowDimension($r)->setRowHeight(30);
            $sheet->mergeCells("B$r:G$r"); // 18
            $sheet->setCellValue("B$r", 'Покупатель:');
            $sheet->getStyle("H$r:AL$r")->applyFromArray($font9b);
            $sheet->mergeCells("H$r:AL$r");
            $sheet->getStyle("H$r:AL$r")->getAlignment()->setWrapText(true);
            $sheet->setCellValue("H$r", html_entity_decode($order['payment_address'] . ', тел.: ' . $order['telephone']));
            $r++;

            $sheet->mergeCells("A$r:AM$r");$sheet->getRowDimension($r)->setRowHeight(6); $r++;

            $sheet->getStyle("B$r:G$r")->applyFromArray($font9);
            $sheet->getRowDimension($r)->setRowHeight(30);
            $sheet->mergeCells("B$r:G$r"); // 20
            $sheet->setCellValue("B$r", 'Грузополучатель:');
            $sheet->getStyle("H$r:AL$r")->applyFromArray($font9b);
            $sheet->mergeCells("H$r:AL$r");
            $sheet->getStyle("H$r:AL$r")->getAlignment()->setWrapText(true);
            $sheet->setCellValue("H$r", html_entity_decode($order['payment_address'] . ', тел.: ' . $order['telephone']));
            $r++;

            $sheet->mergeCells("A$r:AM$r");$sheet->getRowDimension($r)->setRowHeight(6); $r++;

            $sheet->getStyle("B$r:AL$r")->applyFromArray($font10);
            $sheet->getStyle("B$r:AL$r")->getFont()->setBold(true);
            $sheet->mergeCells("B$r:C$r"); // 22
            $sheet->setCellValue("B$r", '№:');
            $sheet->getStyle("B$r:C$r")->applyFromArray($border_thin);
            $sheet->mergeCells("D$r:G$r");
            $sheet->setCellValue("D$r", 'Артикул');
            $sheet->getStyle("D$r:G$r")->applyFromArray($border_thin);
            $sheet->mergeCells("H$r:X$r");
            $sheet->setCellValue("H$r", 'Товары (работы, услуги)');
            $sheet->getStyle("H$r:X$r")->applyFromArray($border_thin);
            $sheet->mergeCells("Y$r:AA$r");
            $sheet->setCellValue("Y$r", 'Кол-во');
            $sheet->getStyle("Y$r:AA$r")->applyFromArray($border_thin);
            $sheet->mergeCells("AB$r:AC$r");
            $sheet->setCellValue("AB$r", 'Ед.');
            $sheet->getStyle("AB$r:AC$r")->applyFromArray($border_thin);
            $sheet->mergeCells("AD$r:AG$r");
            $sheet->setCellValue("AD$r", 'Цена');
            $sheet->getStyle("AD$r:AG$r")->applyFromArray($border_thin);
            $sheet->mergeCells("AH$r:AL$r");
            $sheet->setCellValue("AH$r", 'Сумма');
            $sheet->getStyle("AH$r:AL$r")->applyFromArray($border_thin);
            $sheet->getStyle("B$r:AL$r")->getAlignment()->setIndent(0);
            $sheet->getStyle("B$r:AL$r")->getAlignment()->setWrapText(true);
            $sheet->getStyle("B$r:AL$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER_CONTINUOUS);
            $r++;

            $i   = 0;
            $sum = 0.00;
            foreach ($order['product'] as $product) {
            	$i++;
            	$clean_total = (float)str_replace(',', '', $product['total']);
            	$sum += $clean_total;

            	$pname = html_entity_decode($product['report_name']);

            	$s['height'] = 14 + 6 * intval(strlen($pname) / 55);
            	foreach ($product['option'] as $option)
            		$pname .= ' ' . $option['value'];

            	$product['price'] = str_replace(",", "", $product['price']);

            	$sheet->getStyle("B$r:S$r")->applyFromArray($font8);
            	$sheet->getRowDimension($r)->setRowHeight(30);

            	$sheet->mergeCells("B$r:C$r");
            	$sheet->getStyle("B$r:C$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER_CONTINUOUS);
            	$sheet->setCellValue("B$r", $i);
            	$sheet->getStyle("B$r:C$r")->applyFromArray($border_thin);

            	$sheet->mergeCells("D$r:G$r");
            	$sheet->setCellValue("D$r", $product['model']);
            	$sheet->getStyle("D$r:G$r")->applyFromArray($border_thin);

            	$sheet->mergeCells("H$r:X$r");
            	$sheet->getStyle("H$r:X$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            	$sheet->getStyle("H$r:AL$r")->getAlignment()->setWrapText(true);
            	$sheet->setCellValue("H$r", $pname);
            	$sheet->getStyle("H$r:X$r")->applyFromArray($border_thin);

            	$sheet->mergeCells("Y$r:AA$r");
            	$sheet->getStyle("Y$r:AA$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER_CONTINUOUS);
            	$sheet->setCellValue("Y$r", $product['quantity']);
            	$sheet->getStyle("Y$r:AA$r")->applyFromArray($border_thin);

            	$sheet->mergeCells("AB$r:AC$r");
            	$sheet->getStyle("AB$r:AC$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER_CONTINUOUS);
            	$sheet->setCellValue("AB$r", 'шт');
            	$sheet->getStyle("AB$r:AC$r")->applyFromArray($border_thin);

            	$sheet->mergeCells("AD$r:AG$r");
            	$sheet->getStyle("AD$r:AG$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            	$sheet->setCellValue("AD$r", number_format($product['price'], 2, ",", " "));
            	$sheet->getStyle("AD$r:AG$r")->applyFromArray($border_thin);

            	$sheet->mergeCells("AH$r:AL$r");
            	$sheet->getStyle("AH$r:AL$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            	$sheet->setCellValue("AH$r", number_format($clean_total, 2, ",", " "));
            	$sheet->getStyle("AH$r:AL$r")->applyFromArray($border_thin);

            	$r++;
            }

            $sheet->mergeCells("A$r:AM$r");$sheet->getRowDimension($r)->setRowHeight(6); $r++;

            $sheet->getStyle("B$r:AL$r")->getFont()->setBold(true);
            $sheet->mergeCells("B$r:AG$r");
            $sheet->setCellValue("B$r", 'Итого:');
            $sheet->getStyle("B$r:AG$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->mergeCells("AH$r:AL$r");
            $sheet->getStyle("AH$r:AL$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->setCellValue("AH$r", number_format($sum, 2, ",", " "));
            $r++;

            $sheet->getStyle("B$r:AL$r")->getFont()->setBold(true);
            $sheet->mergeCells("B$r:AG$r");
            $sheet->setCellValue("B$r", 'Без налога (НДС)');
            $sheet->getStyle("B$r:AG$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->mergeCells("AH$r:AL$r");
            $sheet->setCellValue("AH$r", ' ');
            $r++;

            if ($order['shipping_code'] == 'customer_group.customer_group1' || $order['shipping_code'] == 'customer_group.customer_group2' || $order['shipping_code'] == 'customer_group.customer_group5' || $order['shipping_code'] == 'customer_group.customer_group6') {
            	$sheet->getStyle("B$r:AL$r")->getFont()->setBold(true);
            	$sheet->mergeCells("B$r:AG$r");
            	$sheet->setCellValue("B$r", $order['shipping_method'] . ':');
            	$sheet->getStyle("B$r:AG$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            	$sheet->mergeCells("AH$r:AL$r");
            	$sheet->getStyle("AH$r:AL$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            	$sheet->setCellValue("AH$r", number_format($order['shipping_cost'], 2, ",", " "));
            	$sum += $order['shipping_cost'];
            	$r++;
            }

            $sheet->getStyle("B$r:AL$r")->getFont()->setBold(true);
            $sheet->mergeCells("B$r:AG$r");
            $sheet->setCellValue("B$r", 'Всего к оплате:');
            $sheet->getStyle("B$r:AG$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->mergeCells("AH$r:AL$r");
            $sheet->getStyle("AH$r:AL$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->setCellValue("AH$r", number_format($sum, 2, ",", " "));
            $r++;

            $sheet->mergeCells("B$r:AL$r");
            $sheet->setCellValue("B$r", "Всего наименований ".count($order['product']).", на сумму ". number_format($order['free_all_sum'], 2, ',', ' ') ." руб.");
            $r++;

            $sheet->mergeCells("B$r:AL$r");
            $sheet->getStyle("B$r:AL$r")->getFont()->setBold(true);
            $sheet->setCellValue("B$r", $order['total_2_str']);
            $r++;

            $sheet->mergeCells("B$r:AL$r");
            $sheet->setCellValue("B$r", '');
            $sheet->getRowDimension($r)->setRowHeight(6);
            $sheet->getStyle("B$r:AL$r")->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
            $r++;

            $sheet->mergeCells("A$r:AM$r");$sheet->getRowDimension($r)->setRowHeight(6); $r++;

            $sheet->getStyle("AC$r:AL$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B$r:AL$r")->getFont()->setBold(true);
            $sheet->mergeCells("B$r:F$r");
            $sheet->setCellValue("B$r", 'ИП');
            $sheet->mergeCells("AC$r:AL$r");
            $sheet->setCellValue("AC$r", 'Подоляко А. В.');
            $r++;

            $sheet->getStyle("B$r:AL$r")->applyFromArray($font8);
            $sheet->mergeCells("H$r:P$r");
            $sheet->setCellValue("H$r", 'должность');
            $sheet->getStyle("H$r:P$r")->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->mergeCells("R$r:AA$r");
            $sheet->setCellValue("R$r", 'подпись');
            $sheet->getStyle("R$r:AA$r")->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->mergeCells("AC$r:AL$r");
            $sheet->setCellValue("AC$r", 'расшифровка подписи');
            $sheet->getStyle("AC$r:AL$r")->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $r++;

            $sheet->mergeCells("A$r:AM$r");$sheet->getRowDimension($r)->setRowHeight(6); $r++;

            $sheet->getStyle("AC$r:AL$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B$r:AL$r")->getFont()->setBold(true);
            $sheet->mergeCells("B$r:L$r");
            $sheet->setCellValue("B$r", 'Главный (старший) бухгалтер');
            $sheet->mergeCells("AC$r:AL$r");
            $sheet->setCellValue("AC$r", 'Подоляко А. В.');
            $r++;

            $sheet->getStyle("B$r:AL$r")->applyFromArray($font8);
            $sheet->mergeCells("H$r:P$r");
            $sheet->setCellValue("H$r", ' ');
            $sheet->mergeCells("R$r:AA$r");
            $sheet->setCellValue("R$r", 'подпись');
            $sheet->getStyle("R$r:AA$r")->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->mergeCells("AC$r:AL$r");
            $sheet->setCellValue("AC$r", 'расшифровка подписи');
            $sheet->getStyle("AC$r:AL$r")->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $r++;

            $sheet->mergeCells("A$r:AM$r");$sheet->getRowDimension($r)->setRowHeight(6); $r++;

            $sheet->getStyle("AC$r:AL$r")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B$r:AL$r")->getFont()->setBold(true);
            $sheet->mergeCells("B$r:L$r");
            $sheet->setCellValue("B$r", 'Ответственный');
            $sheet->mergeCells("AC$r:AL$r");
            $sheet->setCellValue("AC$r", 'Подоляко А. В.');
            $r++;

            $sheet->getStyle("B$r:AL$r")->applyFromArray($font8);
            $sheet->mergeCells("H$r:P$r");
            $sheet->setCellValue("H$r", ' ');
            $sheet->mergeCells("R$r:AA$r");
            $sheet->setCellValue("R$r", 'подпись');
            $sheet->getStyle("R$r:AA$r")->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->mergeCells("AC$r:AL$r");
            $sheet->setCellValue("AC$r", 'расшифровка подписи');
            $sheet->getStyle("AC$r:AL$r")->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $r++;

            $sheet->setBreak("A$r", \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::BREAK_ROW);
          }

          return $spreadsheet;
        }

    public function make_xlsx_invoice($order) {
        	$writer = new XLSXWriter();
        	$sheet = 'Sheet1';
        	$col_widths = array_fill(0, 39, 2.9);
        	$col_widths[0] = 1;
        	$col_widths[38] = 1;
        	$writer->writeSheetHeader($sheet, $rowdata = array(""=>""), $col_options = array('widths'=>$col_widths), $row_options = array('height'=>1) );

        	$writer->writeSheetRow($sheet, $rowdata = array("","Внимание! Оплата данного счета означает согласие с условиями поставки товара. Уведомление об оплате\nобязательно, в противном случае не гарантируется наличие товара на складе. Товар отпускается по факту\nприхода денег на р/с Поставщика, самовывозом, при наличии доверенности и паспорта."), $row_options = array('height'=>36,'halign'=>'center','valign'=>'center','font-size'=>8,'wrap_text'=>true) );

        	$writer->writeSheetRow($sheet, $rowdata = array(""), $row_options = array('height'=>11) );

        	$r = array_fill(0, 39, "");
        	$r[1] = "СБЕРБАНК РОССИИ ПАО Г. МОСКВА";
        	$r[19] = "БИК";
        	$r[22] = "044525225";
        	$s = array_fill(0,39,array('font-size'=>10,'valign'=>'top', 'border'=>'top', 'border-style'=>'thin'));
        	$s['height'] = 14;
        	$s[0]['border'] = '';
        	$s[1]['border'] = 'left,top';
        	$s[19]['border'] = 'left,top';
        	$s[21]['border'] = 'right,top';
        	$s[38]['border'] = 'left';
        	$writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s );
        	$writer->markMergedCell($sheet, $start_row=3, $start_col=1, $end_row=4, $end_col=18);
        	$writer->markMergedCell($sheet, $start_row=3, $start_col=19, $end_row=3, $end_col=21);
        	$writer->markMergedCell($sheet, $start_row=3, $start_col=22, $end_row=3, $end_col=37);

        	$f = array_fill(0,39,"string");
        	$writer->updateFormat($sheet, $f);
        	$r = array_fill(0, 39, "");
        	$r[19] = "Сч. №";
        	$r[22] = "30101810400000000225";
        	$s = array_fill(0,39,array('font-size'=>10, 'valign'=>'top', 'border-style'=>'thin'));
        	$s['height'] = 14;
        	$s[1]['border'] = 'left';
        	$s[19]['border'] = 'left,top';
        	$s[20]['border'] = 'top';
        	$s[21]['border'] = 'right,top';
        	$s[38]['border'] = 'left';
        	$writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s );
        	$writer->markMergedCell($sheet, $start_row=4, $start_col=19, $end_row=5, $end_col=21);
        	$writer->markMergedCell($sheet, $start_row=4, $start_col=22, $end_row=5, $end_col=37);

        	$r = array_fill(0, 39, "");
        	$r[1] = "Банк получателя";
        	$s = array_fill(0,39,array('font-size'=>8, 'valign'=>'top', 'border-style'=>'thin','border'=>'bottom'));
        	$s['height'] = 10;
        	$s[0]['border'] = '';
        	$s[1]['border'] = 'left,bottom';
        	$s[19]['border'] = 'left,bottom';
        	$s[20]['border'] = 'bottom';
        	$s[21]['border'] = 'right,bottom';
        	$s[38]['border'] = 'left';
        	$writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s );
        	$writer->markMergedCell($sheet, $start_row=5, $start_col=1, $end_row=5, $end_col=18);

        	$r = array_fill(0, 39, "");
        	$r[1] = "ИНН";
        	$r[3] = "502919620199";
        	$r[10] = "КПП";
        	$r[19] = "Сч. №";
        	$r[22] = "40802810140000117404";
        	$s = array_fill(0,39,array('font-size'=>10, 'valign'=>'top', 'border-style'=>'thin'));
        	$s['height'] = 12;
        	$s[1]['border'] = 'left';
        	$s[10]['border'] = 'left';
        	$s[18]['border'] = 'right,bottom';
        	$s[19]['border'] = 'left';
        	$s[22]['border'] = 'left';
        	$s[37]['border'] = 'right';
        	$s[38]['border'] = 'left';
        	$writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s );
        	$writer->markMergedCell($sheet, $start_row=6, $start_col=1, $end_row=6, $end_col=2);
        	$writer->markMergedCell($sheet, $start_row=6, $start_col=3, $end_row=6, $end_col=9);
        	$writer->markMergedCell($sheet, $start_row=6, $start_col=10, $end_row=6, $end_col=12);
        	$writer->markMergedCell($sheet, $start_row=6, $start_col=13, $end_row=6, $end_col=18);
        	$writer->markMergedCell($sheet, $start_row=6, $start_col=19, $end_row=9, $end_col=21);
        	$writer->markMergedCell($sheet, $start_row=6, $start_col=22, $end_row=9, $end_col=37);

        	$r = array_fill(0, 39, "");
        	$r[1] = "Индивидуальный предприниматель Подоляко Александр Валерьевич";
        	$s = array_fill(0,39,array('font-size'=>10, 'valign'=>'top', 'border-style'=>'thin','wrap_text'=>true));
        	$s['height'] = 10;
        	$s[1]['border'] = 'left,top';
        	for ($i = 2; $i <= 18; $i++)
        		$s[$i]['border'] = 'top';
        	$s[19]['border'] = 'left';
        	$s[18]['border'] = 'right';
        	$s[22]['border'] = 'left';
        	$s[38]['border'] = 'left';
        	$writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s );
        	$writer->markMergedCell($sheet, $start_row=7, $start_col=1, $end_row=8, $end_col=18);

        	$s = array_fill(0,39,array('border-style'=>'thin'));
        	$s['height'] = 15;
        	$s[0]['border'] = 'right';
        	$s[1]['border'] = 'left';
        	$s[18]['border'] = 'right';
        	$s[19]['border'] = 'left';
        	$s[22]['border'] = 'left';
        	$s[37]['border'] = 'right';
        	$s[38]['border'] = 'left';
        	$writer->writeSheetRow($sheet,$rowdata = array_fill(0,39,""), $row_options = $s);

        	$r = array_fill(0, 39, "");
        	$r[1] = "Получатель";
        	$s = array_fill(0,39,array('font-size'=>8,'border-style'=>'thin','border'=>'bottom'));
        	$s['height'] = 10;
        	$s[0]['border'] = '';
        	$s[1]['border'] = 'left,bottom';
        	$s[18]['border'] = 'right,bottom';
        	$s[19]['border'] = 'left,bottom';
        	$s[22]['border'] = 'left,bottom';
        	$s[38]['border'] = 'left';
        	$writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s );
        	$writer->markMergedCell($sheet, $start_row=9, $start_col=1, $end_row=9, $end_col=18);

        	$writer->writeSheetRow($sheet, $rowdata = array(""), $row_options = array('height'=>11) );

        	$date = strtotime($order['date_added']);
        	setlocale(LC_ALL, 'ru_RU.UTF-8');

        	$s = array_fill(0, 39, array('valign'=>'center','font-size'=>14,'font-style'=>'bold','border'=>'bottom','border-style'=>'medium'));
        	$s['height'] = 36;
        	$s[0] = array();
        	$s[38] = array();
        	$writer->writeSheetRow($sheet, $rowdata = array("","Заказ № ".$order['order_id']." от ".strftime('%d %B %Y', $date)." г."), $row_options = $s );
        	$writer->markMergedCell($sheet, $start_row=11, $start_col=1, $end_row=11, $end_col=37);

        	$r = array_fill(0, 39, "");
        	$s = array_fill(0,39,array('border'=>'top','border-style'=>'medium'));
        	$s[0] = array();
        	$s[38] = array();
        	$s['height'] = 11;
        	$writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s );

        	$r = array_fill(0, 39, "");
        	$r[1] = "Поставщик:";
        	$r[7] = "Индивидуальный предприниматель Подоляко Александр Валерьевич, ИНН 502919620199, Московская обл., Мытищи, ул.Колпакова, дом № 40, корпус 3, кв.66, тел.: +7 (985) 092-92-91";
        	$s = array_fill(0, 39, array());
        	$s['height'] = 28;
        	$s[1] =  array('valign'=>'center','font-size'=>9);
        	$s[7] =  array('font-style'=>'bold','valign'=>'center','wrap_text'=>true,'font-size'=>9);
        	$writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s );
        	$writer->markMergedCell($sheet, $start_row=13, $start_col=1, $end_row=13, $end_col=6);
        	$writer->markMergedCell($sheet, $start_row=13, $start_col=7, $end_row=13, $end_col=37);

        	$writer->writeSheetRow($sheet, $rowdata = array(""), $row_options = array('height'=>11) );

        	$r = array_fill(0, 39, "");
        	$r[1] = "Грузоотправитель:";
        	$r[7] = "Индивидуальный предприниматель Подоляко Александр Валерьевич, ИНН 502919620199, Московская обл., Мытищи, ул.Колпакова, дом № 40, корпус 3, кв.66, тел.: +7 (985) 092-92-91";
        	$s = array_fill(0, 39, array());
        	$s['height'] = 28;
        	$s[1] =  array('valign'=>'center','font-size'=>9);
        	$s[7] =  array('font-style'=>'bold','valign'=>'center','wrap_text'=>true,'font-size'=>9);
        	$writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s );
        	$writer->markMergedCell($sheet, $start_row=15, $start_col=1, $end_row=15, $end_col=6);
        	$writer->markMergedCell($sheet, $start_row=15, $start_col=7, $end_row=15, $end_col=37);

        	$writer->writeSheetRow($sheet, $rowdata = array(""), $row_options = array('height'=>11) );


        	$r = array_fill(0, 39, "");
        	$r[1] = "Покупатель:";
        	$r[7] = html_entity_decode($order['payment_address'] . ', тел.: ' . $order['telephone']) ;
        	$writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s );
        	$writer->markMergedCell($sheet, $start_row=17, $start_col=1, $end_row=17, $end_col=6);
        	$writer->markMergedCell($sheet, $start_row=17, $start_col=7, $end_row=17, $end_col=37);

        	$writer->writeSheetRow($sheet, $rowdata = array(""), $row_options = array('height'=>11) );

        	$r = array_fill(0, 39, "");
        	$r[1] = "Грузополучатель:";
        	$r[7] = html_entity_decode($order['payment_address'] . ', тел.: ' . $order['telephone']) ;
        	$writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s );
        	$writer->markMergedCell($sheet, $start_row=19, $start_col=1, $end_row=19, $end_col=6);
        	$writer->markMergedCell($sheet, $start_row=19, $start_col=7, $end_row=19, $end_col=37);

        	$writer->writeSheetRow($sheet, $rowdata = array(""), $row_options = array('height'=>11) );

		// table products header

        	$r = array_fill(0, 39, "");
        	$r[1] = "№";
        	$r[3] = "Артикул";
        	$r[7] = "Товары (работы, услуги)";
        	$r[24] = "Кол-во";
        	$r[27] = "Ед.";
        	$r[29] = "Цена";
        	$r[33] = "Сумма";
        	$s = array_fill(0, 39, array('halign'=>'center','font-size'=>10,'font-style'=>'bold', 'border'=>'top,bottom', 'border-style'=>'thin'));
        	$s[0]['border'] = 'right';
        	$s[1]['border'] = 'left,top,bottom';
        	$s[3]['border'] = 'left,top,bottom';
        	$s[7]['border'] = 'left,top,bottom';
        	$s[24]['border'] = 'left,top,bottom';
        	$s[27]['border'] = 'left,top,bottom';
        	$s[29]['border'] = 'left,top,bottom';
        	$s[33]['border'] = 'left,top,bottom';
        	$s[38]['border'] = 'left';
		//$s['height'] = 14;

        	$writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s );
        	$writer->markMergedCell($sheet, $start_row=21, $start_col=1, $end_row=21, $end_col=2);
        	$writer->markMergedCell($sheet, $start_row=21, $start_col=3, $end_row=21, $end_col=6);
        	$writer->markMergedCell($sheet, $start_row=21, $start_col=7, $end_row=21, $end_col=23);
        	$writer->markMergedCell($sheet, $start_row=21, $start_col=24, $end_row=21, $end_col=26);
        	$writer->markMergedCell($sheet, $start_row=21, $start_col=27, $end_row=21, $end_col=28);
        	$writer->markMergedCell($sheet, $start_row=21, $start_col=29, $end_row=21, $end_col=32);
        	$writer->markMergedCell($sheet, $start_row=21, $start_col=33, $end_row=21, $end_col=37);

		// table products content

        	$f = array_fill(0,39,"string");
        	$f[24] = "0";
        	$f[29] = "#,##0.00";
        	$f[33] = "#,##0.00";
        	$writer->updateFormat($sheet, $f);

        	$s = array_fill(0, 39, array('font-size'=>8, 'border'=>'top,bottom', 'border-style'=>'thin','valign'=>'top'));
		//$s['height'] = 14;
        	$s[0]['border'] = 'right';
        	$s[1]['border'] = 'left,top,bottom';
        	$s[1]['halign'] = 'center';
        	$s[3]['border'] = 'left,top,bottom';
        	$s[7]['border'] = 'left,top,bottom';
        	$s[7]['wrap_text'] = true;
        	$s[24]['border'] = 'left,top,bottom';
        	$s[27]['border'] = 'left,top,bottom';
        	$s[29]['border'] = 'left,top,bottom';
        	$s[29]['halign'] = 'right';
        	$s[33]['border'] = 'left,top,bottom';
        	$s[33]['halign'] = 'right';
        	$s[38]['border'] = 'left';

        	$i = 0;
        	$sum  = 0.00;
        	foreach ( $order['product'] as $product ){
        		$i++;
        		$clean_total = (float) str_replace( ',', '', $product['total'] );
        		$sum += $clean_total;

        		$r = array_fill(0, 39, "");
        		$r[1] = $i;
        		$r[3] = $product['model'];
        		$pname = html_entity_decode($product['name']);
        		$s['height'] = 14 + 6*intval(strlen($pname) / 55);
        		foreach ( $product['option'] as $option )
        			$pname .= ' '.$option['value'];
        		$r[7] = $pname;
        		$r[24] = $product['quantity'];
        		$r[27] = "шт";
        		$product['price'] = str_replace(",", "", $product['price']);
        		$r[29] = $product['price'];
        		$r[33] = $clean_total;

        		$writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s );
        		$writer->markMergedCell($sheet, $start_row=21 + $i, $start_col=1, $end_row=21 + $i, $end_col=2);
        		$writer->markMergedCell($sheet, $start_row=21 + $i, $start_col=3, $end_row=21 + $i, $end_col=6);
        		$writer->markMergedCell($sheet, $start_row=21 + $i, $start_col=7, $end_row=21 + $i, $end_col=23);
        		$writer->markMergedCell($sheet, $start_row=21 + $i, $start_col=24, $end_row=21 + $i, $end_col=26);
        		$writer->markMergedCell($sheet, $start_row=21 + $i, $start_col=27, $end_row=21 + $i, $end_col=28);
        		$writer->markMergedCell($sheet, $start_row=21 + $i, $start_col=29, $end_row=21 + $i, $end_col=32);
        		$writer->markMergedCell($sheet, $start_row=21 + $i, $start_col=33, $end_row=21 + $i, $end_col=37);
        	}
        	$table_end = 21 + count($order['product']);

        	$writer->writeSheetRow($sheet, $rowdata = array(""), $row_options = array('height'=>8) );

        	$f[29] = "string";
        	$writer->updateFormat($sheet, $f);

        	$r     = array_fill(0, 39, "");
        	$r[29] = "Итого:";
        	$r[33] = $sum;
        	$writer->writeSheetRow($sheet, $rowdata = $r, $row_options = array('height' => 14, 'font-size' => 10, 'valign' => 'top', 'halign' => 'right', 'font-style' => 'bold'));
        	$writer->markMergedCell($sheet, $start_row = $table_end + 2, $start_col = 29, $end_row = $table_end + 2, $end_col = 32);
        	$writer->markMergedCell($sheet, $start_row = $table_end + 2, $start_col = 33, $end_row = $table_end + 2, $end_col = 37);

        	$r     = array_fill(0, 39, "");
        	$r[27] = "Без налога (НДС)";
        	$writer->writeSheetRow($sheet, $rowdata = $r, $row_options = array('height' => 14, 'font-size' => 10, 'valign' => 'top', 'halign' => 'right', 'font-style' => 'bold'));
        	$writer->markMergedCell($sheet, $start_row = $table_end + 3, $start_col = 27, $end_row = $table_end + 3, $end_col = 32);
        	$writer->markMergedCell($sheet, $start_row = $table_end + 3, $start_col = 33, $end_row = $table_end + 3, $end_col = 37);

        	$r     = array_fill(0, 39, "");
        	$r[27] = "Всего к оплате:";
        	$r[33] = $sum;
        	$writer->writeSheetRow($sheet, $rowdata = $r, $row_options = array('height' => 14, 'font-size' => 10, 'valign' => 'top', 'halign' => 'right', 'font-style' => 'bold'));
        	$writer->markMergedCell($sheet, $start_row = $table_end + 4, $start_col = 27, $end_row = $table_end + 4, $end_col = 32);
        	$writer->markMergedCell($sheet, $start_row = $table_end + 4, $start_col = 33, $end_row = $table_end + 4, $end_col = 37);

        	$writer->writeSheetRow($sheet, $rowdata = array("","Всего наименований ".count($order['product']).", на сумму ". number_format($order['free_all_sum'], 2, ',', ' ') ." руб."), $row_options = array('height'=>14,'valign'=>'center','font-size'=>10) );
        	$writer->markMergedCell($sheet, $start_row=$table_end + 5, $start_col=1, $end_row=$table_end + 5, $end_col=37);

        	$writer->writeSheetRow($sheet, $rowdata = array("",$order['total_2_str']), $row_options =  array('height'=>14,'valign'=>'center','font-size'=>10, 'font-style'=>'bold') );
        	$writer->markMergedCell($sheet, $start_row=$table_end + 6, $start_col=1, $end_row=$table_end + 6, $end_col=37);

        	$writer->writeSheetRow($sheet, $rowdata = array("", ""), $row_options =  array('height'=>6 ));
        	$s = array_fill(0, 39,  array('border'=>'top','border-style'=>'medium' ));
        	$s['height'] = 6;
        	$s[0] = array();
        	$s[38] = array();
        	$writer->writeSheetRow($sheet, $rowdata = array_fill(0, 39,""), $row_options =$s);

        	$writer->writeSheetRow($sheet,$rowdata = array(), $row_options =  array('height'=>15) );

        	$r = array_fill(0, 39, "");
        	$r[1] = "ИП";
        	$r[28] = "Подоляко А. В.";
        	$s = array_fill(0, 39,  array('border-style'=>'thin'));
        	for ($i = 7; $i <= 15; $i++)
        		$s[$i]['border'] = 'bottom';
        	for ($i = 17; $i <= 26; $i++)
        		$s[$i]['border'] = 'bottom';
        	for ($i = 28; $i <= 37; $i++)
        		$s[$i]['border'] = 'bottom';
        	$s['height'] = 14;
        	$s[1] =  array('font-style'=>'bold','font-size'=>9);
        	$s[28] =  array('font-style'=>'bold','font-size'=>10,'halign'=>'center');
        	$writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s );
        	$writer->markMergedCell($sheet, $start_row=$table_end + 10, $start_col=28, $end_row=$table_end + 10, $end_col=37);
        	$writer->markMergedCell($sheet, $start_row=$table_end + 10, $start_col=7, $end_row=$table_end + 10, $end_col=15);
        	$writer->markMergedCell($sheet, $start_row=$table_end + 10, $start_col=1, $end_row=$table_end + 10, $end_col=5);

        	$r = array_fill(0, 39, "");
        	$r[7] = "должность";
        	$r[17] = "подпись";
        	$r[28] = "расшифровка подписи";
        	$s = array_fill(0, 39,  array('border-style'=>'thin'));
        	$s['height'] = 14;
        	$s[7] = array('border'=>'top','border-style'=>'thin','font-size'=>8,'halign'=>'center','valign'=>'bottom');

        	$s[17] =  array('border'=>'top','border-style'=>'thin','font-size'=>8,'halign'=>'center','valign'=>'bottom');
        	$s[28] =  array('border'=>'top','border-style'=>'thin','font-size'=>8,'halign'=>'center','valign'=>'bottom');

        	$writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s );
        	$writer->markMergedCell($sheet, $start_row=$table_end + 11, $start_col=7, $end_row=$table_end + 11, $end_col=15);
        	$writer->markMergedCell($sheet, $start_row=$table_end + 11, $start_col=17, $end_row=$table_end + 11, $end_col=26);
        	$writer->markMergedCell($sheet, $start_row=$table_end + 11, $start_col=28, $end_row=$table_end + 11, $end_col=37);

        	$writer->writeSheetRow($sheet,$rowdata = array(), $row_options =  array('height'=>14) );

        	$r = array_fill(0, 39, "");
        	$r[1] = "Главный (старший) бухгалтер";
        	$r[28] = "Подоляко А. В.";
        	$s = array_fill(0, 39, array('border-style'=>'thin'));
        	$s['height'] = 14;
        	for ($i = 17; $i <= 26; $i++)
        		$s[$i]['border'] = 'bottom';
        	for ($i = 28; $i <= 37; $i++)
        		$s[$i]['border'] = 'bottom';
        	$s[1] =  array('font-style'=>'bold','font-size'=>9);
        	$s[28] = array('font-style'=>'bold','font-size'=>10,'halign'=>'center');
        	$writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s );
        	$writer->markMergedCell($sheet, $start_row=$table_end + 13, $start_col=1, $end_row=$table_end + 13, $end_col=10);
        	$writer->markMergedCell($sheet, $start_row=$table_end + 13, $start_col=28, $end_row=$table_end + 13, $end_col=37);

        	$r = array_fill(0, 39, "");
        	$r[17] = "подпись";
        	$r[28] = "расшифровка подписи";
        	$s = array_fill(0, 39, array());
        	$s['height'] = 14;
        	$s[17] = array('border'=>'top','border-style'=>'thin','font-size'=>8,'halign'=>'center','valign'=>'bottom');
        	$s[28] = array('border'=>'top','border-style'=>'thin','font-size'=>8,'halign'=>'center','valign'=>'bottom');
        	$writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s );
        	$writer->markMergedCell($sheet, $start_row=$table_end + 14, $start_col=17, $end_row=$table_end + 14, $end_col=26);
        	$writer->markMergedCell($sheet, $start_row=$table_end + 14, $start_col=28, $end_row=$table_end + 14, $end_col=37);

        	$writer->writeSheetRow($sheet,$rowdata = array(), $row_options =  array('height'=>14) );

        	$r = array_fill(0, 39, "");
        	$r[1] = "Ответственный";
        	$r[28] = "Подоляко А. В.";
        	$s = array_fill(0, 39, array());
        	$s['height'] = 14;
        	for ($i = 17; $i <= 26; $i++)
        		$s[$i]['border'] = 'bottom';
        	for ($i = 28; $i <= 37; $i++)
        		$s[$i]['border'] = 'bottom';
        	$s[1] = array('font-style'=>'bold','font-size'=>9);
        	$s[28] = array('font-style'=>'bold','font-size'=>10,'halign'=>'center');
        	$writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s );
        	$writer->markMergedCell($sheet, $start_row=$table_end + 16, $start_col=1, $end_row=$table_end + 16, $end_col=5);
        	$writer->markMergedCell($sheet, $start_row=$table_end + 16, $start_col=28, $end_row=$table_end + 16, $end_col=37);

        	$r = array_fill(0, 39, "");
        	$r[17] = "подпись";
        	$r[28] = "расшифровка подписи";
        	$s = array_fill(0, 39, array());
        	$s['height'] = 14;
        	$s[17] =  array('border'=>'top','border-style'=>'thin','font-size'=>8,'halign'=>'center','valign'=>'bottom');
        	$s[28] =  array('border'=>'top','border-style'=>'thin','font-size'=>8,'halign'=>'center','valign'=>'bottom');
        	$writer->writeSheetRow($sheet, $rowdata = $r, $row_options = $s );
        	$writer->markMergedCell($sheet, $start_row=$table_end + 17, $start_col=17, $end_row=$table_end + 17, $end_col=26);
        	$writer->markMergedCell($sheet, $start_row=$table_end + 17, $start_col=28, $end_row=$table_end + 17, $end_col=37);


		// done

        	$writer->markMergedCell($sheet, $start_row=0, $start_col=0, $end_row=0, $end_col=38);
        	$writer->markMergedCell($sheet, $start_row=1, $start_col=1, $end_row=1, $end_col=37);

        	return $writer->writeToString();
        }
}
?>