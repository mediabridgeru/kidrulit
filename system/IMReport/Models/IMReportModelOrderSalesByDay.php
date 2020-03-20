<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

require_once 'IMReportAbstractModel.php';

// 2.4.0
class IMReportModelOrderSalesByDay extends IMReportAbstractModel
{
	public function getResult($settings)
	{
		$default_name = $this->db->escape($this->getLangVal('default_name'));

		// Пустые даты запрещены вместо них текущая дата
		$start_date = DateTime::createFromFormat('d.m.Y', $settings['filter_date_start']);
		if (!isset($start_date) || empty($start_date)) {
			$start_date = new DateTime('NOW');
		}
		$end_date = DateTime::createFromFormat('d.m.Y', $settings['filter_date_end']);
		if (!isset($end_date) || empty($end_date)) {
			$end_date = new DateTime('NOW');
		}
		$start_date = DateTime::createFromFormat('d.m.Y', $start_date->format('d.m.Y'));
		$end_date = DateTime::createFromFormat('d.m.Y', $end_date->format('d.m.Y'));
		if ($start_date > $end_date) {
			$start_date = DateTime::createFromFormat('d.m.Y', $end_date->format('d.m.Y'));
		}
		$settings['filter_date_start'] = $start_date->format('d.m.Y');
		$settings['filter_date_end'] = $end_date->format('d.m.Y');

		$wherePart = '';

		$wherePart = $this->getWhereFilterByMetaData(
			$settings,
			array(
				'date' => array(
					'filter_date_start' => " DATE(o.date_added) >= ",
					'filter_date_end' => " DATE(o.date_added) <= ",
				),
				'cat_product' => array(
					'cat' => 'p.product_id',
				),
				'list_int' => array(
					'order_status' => ' o.order_status_id ',
					'manufact' => ' p.manufacturer_id ',
					'cust' => 'o.customer_id',
					'cust_group' => 'o.customer_group_id',
				),
			)
		);

		// Определяем нужен ли фильтр по товарам
		$need_product_join = false;
		$catFilter = $this->imhelper->getCategoryProductWhereFilter(
			$settings, 'cat', 'p.product_id', $this->isHaveMainCategory(), $wherePart
		);
		$manFilter = $this->imhelper->getWhereFilterList($settings, 'manufact', ' p.manufacturer_id ', $wherePart);
		$need_product_join = ($need_product_join || ($manFilter != '') || ($catFilter != ''));

		// Сам запрос
		$query =
			' select '
				. ' DATE(o.date_added) as date_added, '
				. ' sum(o.total ' . $this->addMCC(' * o.currency_value ') . ') as cost, '
				. ' sum(ifnull(ot_sub.value, 0) ' . $this->addMCC(' * o.currency_value ') . ') as cost_sub, '
				. ' sum(ifnull(ot_ship.value, 0) ' . $this->addMCC(' * o.currency_value ') . ') as cost_ship, '
				. ' count(*) as count  '
			. ' from ( '
					. ' select '
						.	' distinct o.order_id '
					. ' from `' . DB_PREFIX . 'order` o '
						. ' join `' . DB_PREFIX . 'order_status` os '
							. ' on o.order_status_id = os.order_status_id '
								. ' and os.language_id = ' . (int)$settings['language_id']
					. ($need_product_join
						? (
							' join `' . DB_PREFIX . 'order_product` op '
								. ' on o.order_id = op.order_id '
							. ' join `' . DB_PREFIX . 'product` p '
								. ' on op.product_id = p.product_id '
						)
						: ''
					)
					. ($wherePart == '' ? '' : ' where ' . $wherePart)
				. ' ) filter '
				. ' join `' . DB_PREFIX . 'order` o '
					. ' on filter.order_id = o.order_id '
				. ' left join `' . DB_PREFIX . 'order_total` as ot_sub '
					. ' on o.order_id = ot_sub.order_id '
						. ' and ot_sub.code = \'sub_total\' '
				. ' left join `' . DB_PREFIX . 'order_total` as ot_ship '
					. ' on o.order_id = ot_ship.order_id '
						. ' and ot_ship.code = \'shipping\' '
			. ' group by DATE(o.date_added) asc'
		;

		// 2.4.0
		$this->startSQLLog($query);

		$queryResult = $this->db->query($query);

		// 2.4.0
		$this->endSQLLog();

		// Теперь расчитываем по дням
		$searchResult = $queryResult->rows;
		$rowIndex = 0;
		$countRow = count($searchResult);
		$searchDate = null;

		$result = array();

		// Пока не прошлись по всем мясецам
		while($start_date <= $end_date)
		{
			if ($countRow > 0 && $rowIndex < $countRow)
			{
				$searchDate = new DateTime($searchResult[$rowIndex]['date_added']);
				$searchDate = DateTime::createFromFormat('d.m.Y', $searchDate->format('d.m.Y'));
				if ($searchDate == $start_date)
				{
					$result[] = array(
						'date_added' => $start_date->format('Y-m-d'),
						'count' => $searchResult[$rowIndex]['count'],
						'cost' => $searchResult[$rowIndex]['cost'],
						'cost_sub' => $searchResult[$rowIndex]['cost_sub'],
						'cost_ship' => $searchResult[$rowIndex]['cost_ship'],
						'cost_diff'
							=> round($searchResult[$rowIndex]['cost']
								- $searchResult[$rowIndex]['cost_sub']
								- $searchResult[$rowIndex]['cost_ship'],
							4),
					);
					$rowIndex++;
				}
				else
				{
					$result[] = array(
						'date_added' => $start_date->format('Y-m-d'),
						'count' => 0,
						'cost' => 0,
						'cost_sub' => 0,
						'cost_ship' => 0,
						'cost_diff' => 0,
					);
				}
			}
			else
			{
				$result[] = array(
					'date_added' => $start_date->format('Y-m-d'),
					'count' => 0,
					'cost' => 0,
					'cost_sub' => 0,
					'cost_ship' => 0,
					'cost_diff' => 0,
				);
			}

			// Переходим к следующему дню
			$start_date->add(new DateInterval('P1D'));
		}

		return $result;
	}
}
