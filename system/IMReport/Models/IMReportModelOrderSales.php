<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

require_once 'IMReportAbstractModel.php';

class IMReportModelOrderSales extends IMReportAbstractModel
{
	public function getResult($settings)
	{
		$default_name = $this->db->escape($this->getLangVal('default_name')); 

		$wherePart = '';
		
		// Стартовая дата
		if (!empty($settings['filter_date_start_month'])
			&& !empty($settings['filter_date_start_year'])) 
		{
			$date = date_create_from_format('d.m.Y',
				'1'
				. '.' . $settings['filter_date_start_month']
				. '.' . $settings['filter_date_start_year']
			);
			$wherePart .= " DATE(o.date_added) >= '" . $date->format('Y-m-d') . "' ";
		}

		// Конечная дата
		if (!empty($settings['filter_date_end_month'])
			&& !empty($settings['filter_date_end_year'])) 
		{
			$date = date_create_from_format('d.m.Y',
				'1'
				. '.' . $settings['filter_date_end_month']
				. '.' . $settings['filter_date_end_year']
			);
			
			$endDate = clone $date;

			$billing_count = '1';
			$billing_unit = 'm';

			$endDate->add( new \DateInterval( 'P' . $billing_count . strtoupper( $billing_unit ) ) );

			if ( intval( $endDate->format( 'n' ) ) > ( intval( $date->format( 'n' ) ) + intval( $billing_count ) ) % 12 )
			{
			    if ( intval( $date->format( 'n' ) ) + intval( $billing_count ) != 12 )
			    {
			        $endDate->modify( 'last day of -1 month' );
			    }
			}
			
			$wherePart .= (empty($wherePart) ? '' : ' and ') 
				. " DATE(o.date_added) < '" . $endDate->format('Y-m-d') . "' ";
		}

		// Фильтр по статусу
		$wherePart .= $this->imhelper->getWhereFilterList($settings, 'order_status', ' o.order_status_id ', $wherePart);

		// Фильтр по клиенту
		$wherePart .= $this->imhelper->getWhereFilterList($settings, 'cust', ' o.customer_id ', $wherePart);

		// Фильтр по группам клиентов
		$wherePart .= $this->imhelper->getWhereFilterList($settings, 'cust_group', ' o.customer_group_id ', $wherePart);

		
		// Фильтр по категории
		$need_product_join = false;
		$catFilter = $this->imhelper->getCategoryProductWhereFilter(
			$settings, 'cat', 'p.product_id', $this->isHaveMainCategory(), $wherePart
		);
		$need_product_join = ($need_product_join || ($catFilter != ''));
		$wherePart .= $catFilter;

		// Фильтр по производителю
		$manFilter = $this->imhelper->getWhereFilterList($settings, 'manufact', ' p.manufacturer_id ', $wherePart);
		$need_product_join = ($need_product_join || ($manFilter != ''));
		$wherePart .= $manFilter;

		// Сам запрос
		$query = 
			' select ' 
				. ' year(o.date_added) as year, '
				. ' month(o.date_added) as month, '
				. ' sum(o.total ' . $this->addMCC(' * o.currency_value ') . ') as cost, '
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
			. ' group by year(o.date_added) asc, month(o.date_added) asc'
		;
		
		// 2.4.0
		$this->startSQLLog($query);

		$queryResult = $this->db->query($query);

		// 2.4.0
		$this->endSQLLog();

		// Теперь расчитываем по месяцам
		$searchResult = $queryResult->rows;
		$rowIndex = 0;
		$countRow = count($searchResult);
		
		$result = array();
		
		$start_month = $settings['filter_date_start_month'];
		$start_year = $settings['filter_date_start_year'];
		$end_month = $settings['filter_date_end_month'];
		$end_year = $settings['filter_date_end_year'];
		
		// Пока не прошлись по всем мясецам
		while(($start_year * 100 + $start_month) <= ($end_year * 100 + $end_month))
		{
			if ($countRow > 0 && $rowIndex < $countRow)	
			{
				if (('' . $searchResult[$rowIndex]['year']) == ('' . $start_year)
					&& ('' . $searchResult[$rowIndex]['month']) == ('' . $start_month))
				{
					$result[] = array(
						'year' => $start_year,
						'month' => $start_month,
						'count' => $searchResult[$rowIndex]['count'],
						'cost' => $searchResult[$rowIndex]['cost']
					);	
					$rowIndex++;
				}
				else
				{
					$result[] = array(
						'year' => $start_year,
						'month' => $start_month,
						'count' => 0,
						'cost' => 0
					);	
				}
			}
			else
			{
				$result[] = array(
					'year' => $start_year,
					'month' => $start_month,
					'count' => 0,
					'cost' => 0
				);	
			}
			
			// Переходим к следующему месяцу
			$start_month++;
			if ($start_month > 12)
			{
				$start_month = 1;
				$start_year++;
			}
		}
		
		return $result;
	}
}
