<?php
// Heading 
$_['heading_title']             = 'Почта России 2.0';
$_['text_shipping']             = 'Доставка';
$_['col_service_postcode']             = 'Отдельный почтовый индекс отправления для сервиса';
$_['entry_is_ignore_user_postcode_byregion'] = 'Игнорировать индекс только если он не совпадает с выбранным регионом'; 
$_['text_order_adds_weight_fix'] = 'Фиксированная надбавка 1 раз';
$_['text_order_adds_weight_perc'] = '% от веса заказа';
$_['entry_tariff_inn']             = 'Ваш ИНН (из договора с Почтой России)';
$_['entry_tariff_inn_notice']             = '<b>Только для корпоративных клиентов!</b>. Без ИНН и номер договора - при рассчете цены доставки - не будет учитываться Ваша скидка и цена доставки может быть завышена';

$_['entry_ops_address_set']             = 'Сохранять адрес ОПС в поле';
$_['entry_ops_address_set_notice']             = 'Внимание! в отличие от доставки в почтомат, при доставке в Отделение Почты России - пользователь должен указать свой адрес на который ему принесут уведомление о доставке и бросят в почтовый ящик. В оформлении заказа должно быть какое-то поле где пользователь укажет свой адрес';

$_['entry_pvz_address_set'] = 'Сохранять адрес почтомата в поле';
$_['text_address_1'] = 'Адрес (поле address_1)';
$_['text_address_2'] = 'Адрес 2 (поле address_2)';
$_['text_comment'] = 'Комментарий к заказу';
$_['text_disabled'] = 'Отключено';
$_['entry_pvz_address_set_notice'] = '';
$_['entry_pvz_address_infield'] = 'Текст адреса ПВЗ которые подставляется в поле (address_1, address_2, comment) после текста "Адрес ПВЗ:"
<br><br>
Тэги:
{address} - адрес ПВЗ, пример: "г. Москва, ул. Тверская, 12"
{postcode} - почтовый индекс
';
$_['default_pvz_address_infield'] = '{postcode}, {ops_address}';
$_['entry_pvz_showtype']             = 'Что отображать в списках ПВЗ';

$_['entry_pvz_showtype_region']      = 'Все ПВЗ региона (сначала ПВЗ выбранного пользователем города, потом ПВЗ столицы региона, потом все остальные ПВЗ региона отсортированные по алфавиту их города)';
$_['entry_pvz_showtype_capital']      = 'Сначала ПВЗ выбранного города, потом ПВЗ столицы региона';
$_['entry_pvz_showtype_city']      = 'Только ПВЗ выбранного города';

$_['entry_pvz_showtype_isnopvz']      = 'Что отображать в списках ПВЗ если пользователь не указал город или если в
указанном городе нет ПВЗ';

$_['entry_pvz_showtype_isnopvz_region']      = 'Все ПВЗ региона (сначала ПВЗ столицы региона, потом все остальные ПВЗ региона отсортированные по алфавиту их города)';

$_['entry_pvz_showtype_isnopvz_capital']      = 'ПВЗ столицы региона'; 
$_['entry_pvz_showtype_isnopvz_hide']      = 'Не отображать ПВЗ'; 
$_['text_widget_code']             = 'Код виджета:';
$_['button_add']             = 'Добавить';
$_['text_maptype']             = 'Какие ПВЗ отображать на карте:';
$_['text_maptype_notice']             = 'Чтобы подключить widget.pochta.ru используйте <a href="{REQUEST_URI}#mapwidgets">настройки ниже</a>';
$_['text_pvztype_filter_all']             = 'Все';
$_['text_pvztype_filter_rupost']             = 'Только отделения Почты России';
$_['text_pvztype_filter_noops']             = 'Только почтаматы и партнерские пункты (тариф ПосылкаОнлайн или ЕКОМ Маркетплейс)';

$_['text_pvzoption_mapwidget']             = 'Виджет Почты России:';
$_['text_pvzoption_modulemap']             = 'Карта модуля';


$_['entry_widget_pochta']             = 'Виджеты Почты России (<a href="https://widget.pochta.ru" target=_blank
										 >https://widget.pochta.ru</a>)';

$_['text_pvzrow_name_all']             = 'Все ПВЗ';
$_['text_pvzrow_name_rupost']             = 'Только отделения Почты России';
$_['text_pvzrow_name_noops']             = 'Только почтаматы и партнерские пункты (тариф ПосылкаОнлайн или ЕКОМ Маркетплейс)';

$_['text_pvzrow_name_all_payment']             = 'Все ПВЗ с приемом оплаты';
$_['text_pvzrow_name_rupost_payment']             = 'Только отделения Почты России с приемом оплаты';
$_['text_pvzrow_name_noops_payment']             = 'Только почтаматы и партнерские пункты (тариф ПосылкаОнлайн или ЕКОМ Маркетплейс) с приемом оплаты';

$_['text_mpatype_module']             = 'Карта модуля';
$_['text_mpatype_widget']             = 'Виджет Почты России';

$_['col_pvzrow_code']             = 'Карта модуля или Виджет Почты России';
$_['col_pvzrow_pvztype']             = 'Фильтр по типу ПВЗ';
$_['col_pvzrow_name']             = 'Название';
$_['col_pvzrow_payment']             = 'Фильтр по приему оплаты';
$_['text_pvzpayment_required']             = 'Только ПВЗ с возможностью оплаты заказа';
$_['text_pvzpayment_any']             = 'Все';

$_['tab_sklads']             = 'Склады';
$_['button_sklads_add']             = 'Добавить склад';
$_['col_sklads_multistore']             = 'МультиСклад';
$_['col_sklads_region']             = 'Регион отправления';
$_['col_sklads_city']             = 'Город отправления';
$_['col_sklads_postcode']             = 'Почтовые индексы отправления';
$_['entry_sklads_postcode_main']             = 'Основной почтовый индекс';
$_['entry_sklads_postcode_parcel_online']             = 'Для тарифа ПосылкаОнлайн';
$_['entry_sklads_postcode_courier_online']             = 'Для тарифа КурьерОнлайн';
$_['entry_sklads_postcode_ems_optimal']             = 'Для тарифа EMS Оптимальное';

$_['entry_ops_titleblock']             = 'Отделения/ПВЗ в названии способа доставки';
$_['text_showmap']             = 'Отображать выбор отделения/ПВЗ на карте';
$_['text_showmap_skipnopay']             = 'Не отображать отделения/ПВЗ где недоступна оплата налож.платежом';  
$_['entry_tariff_dogovor']             = 'Ваш номер договора с Почтой России';
$_['entry_tariff_dogovor_notice']             = '<b>Только для корпоративных клиентов!</b>. Без ИНН и номер договора - при рассчете цены доставки - не будет учитываться Ваша скидка и цена доставки может быть завышена'; 

$_['text_doginn_corp_error']             = 'Нужно сохранить ИНН и номер говора с Почтой России во вкладке "Синхронизация и API" => "API Почты России (tariff.pochta.ru)". Без этих данных цена доставки в оформлении заказа - может быть завышена';
$_['entry_tag_ops_block']             = 'Блок информации об отделении/ПВЗ который добавляется в конце названия способа доставки';


$_['entry_if_nosrok_calculated'] = 'Что делать если срок доставки не рассчитался?';
$_['entry_if_nosrok_calculated_hide'] = 'Не отображать срок доставки';
$_['entry_if_nosrok_calculated_capital'] = 'Рассчитывать доставку в столицу региона и добавлять заданное кол-во дней';
$_['entry_if_nosrok_calculated_notice'] = 'Цена доставки может не рассчитаться для некоторых почтовых отделений в некоторых тарифах, например EMS РТ';
		
$_['entry_if_nosrok_calculated_additional'] = 'Надбавка к сроку доставки в соответствии с настройкой выше (дней)';
$_['entry_if_nosrok_calculated_additional_notice'] = 'Если срок доставки рассчитался то надбавка не будет применяться';

$_['entry_debug_notice'] = '<b>ВНИМАНИЕ!</b> не забудьте отключить логгирование после окончание тестирования, чтобы не лог-файл не увеличивался. Если лог-файл станет слишкмо большим (больше 100 мб) - это может привести к замедлению работы сайта.'; 

$_['text_settings_notice']             = '<b>Внимание!</b> при экспорте/импорте не переносятся настройки стран и регионов (то есть при импорте они не поменяются)';

$_['text_set_split'] = 'Рассчитывать каждый товар в заказе как отдельное отправление';
$_['error_no_clienttype'] = 'Внимание! Обязательно выберите Ваш "тип клиента" в первой вкладке в настройках модуля.';

$_['text_api_unavailable'] = 'API otpravka.pochta.ru доступен только для корпоративных клиентов (то есть подписавших договор с Почтой России и получивших доступ в otpravka.pochta.ru.)
<br><br>Если Вы корпоративный клиент - выберите эту опцию в настройке "Ваш тип клиента" в первой вкладке в настройках модуля.';

$_['text_option_unavailable'] = '[НЕДОСТУПНО*****]';
$_['text_option_unavailable_notice']         = '***** - Некоторые тарифы доступны только для корпоративных клиентов (то есть подписавших договор с Почтой России и получивших доступ в otpravka.pochta.ru). Если Вы корпоративный клиент - выберите эту опцию в настройке "Ваш тип клиента" в первой вкладке в настройках модуля.';

$_['entry_mapsource_area'] = 'Отображать на карте модуля ПВЗ:';
$_['entry_mapsource_area_notice'] = 'Все метки со всей страны отображать нельзя, их около 50 тыс., карта будет тормозить. Настройка не относится к карте виджета Почта России, только к карте модуля';

$_['entry_mapsource_area_region'] = 'Все метки в регионе указанном покупателем';
$_['entry_mapsource_area_city'] = 'Только метки из населенного пункта, указанного покупателем';
$_['entry_mapsource_area_region_capital'] = 'Для столиц регионов - только метки в городе, для остальных населенных пунктов - все метки в регионе';

$_['entry_clienttype'] = 'Ваш тип клиента';
$_['entry_clienttype_common'] = 'Обычный клиент (физ.лица или юр.лица не подписавшие договор с Почтой России)';
$_['entry_clienttype_corporate'] = 'Корпоративный клиент (юр.лица подписавшие договор с Почтой России)';
$_['entry_clienttype_common_notice'] = '<div><b>Достоинства:</b><br>- Доступен тариф ПосылкаСтандарт</div>
';
$_['entry_clienttype_corporate_notice'] = '<div><b>Достоинства:</b><br>
- доступны тарифы для юр.лиц: ПосылкаОнлайн, КурьерОнлайн, EMS Оптимальное и еще несколько тарифов.
<br>
- дешевле стоит доставка по тарифам: Посылка Нестандартная, Посылка 1 класса<br>
- меньше размер комиссии за наложенный платеж 
</div>
';
$_['default_subtitle1'] = 'Обычная доставка в отделение {srok_block}';
$_['default_subtitle2'] = 'Ускоренная доставка в отделение {srok_block}';
$_['default_subtitle3'] = 'Курьерская доставка {srok_block}';
$_['tab_settings'] = 'Экспорт/Импорт настроек';
$_['entry_export'] = 'Экспорт настроек в файл';
$_['entry_import'] = 'Файл импорта настроек';
$_['button_export_settings'] = 'Экспортировать настройки модуля';
$_['button_import_settings'] = 'Импортировать настройки модуля';

$_['text_savetabs_error'] = 'Ошибка! Попробуйте сохранить настройки еще раз.';
$_['text_session_error'] = 'Ошибка! Сессия истекла, настройки не могут быть сохранены. Нужно заново авторизоваться в панели администратора';

$_['error_import_file'] = 'Ошибка! Некорректный файл настроек';
$_['error_empty_import_file'] = 'Ошибка! Не указан файл настроек';
$_['text_success_import'] = 'Настройки успешно импортированы';

$_['entry_count_pvz'] = 'Количество ПВЗ в базе данных:';
$_['entry_dop_indexes'] = 'Дополнительные индексы отправления для отдельных тарифов';
$_['entry_dop_indexes_notice'] = 'Некоторые отделения не принимают посылки для перечисленных ниже тарифов и для них приходится использовать отдельные индексы отправления';

$_['entry_dop_indexes_col_service'] = 'Тариф';
$_['entry_dop_indexes_col_postcode'] = 'Индекс отправления';
		
$_['text_nosumweight'] = 'Не суммировать вес внутри товарной позиции';
$_['text_nosumlength'] = 'Не суммировать габариты внутри товарной позиции';
$_['text_use_default_index'] = 'Использовать Основной почтовый индекс отправки';
$_['text_postcode_suggest'] = 'Подходящие индексы:';

$_['text_from_inc'] = 'от (включительно)';
$_['text_to_inc'] = 'до (включительно)';
$_['text_count_items'] = 'Количество единиц товара'; 
$_['text_count_items2'] = 'Количество единиц товара (суммируется по всем товарным позициям)'; 
$_['text_count_products2'] = 'Количество товарный позиций'; 

$_['text_correct_postcode'] = 'Доставка из этого индекса - успешно рассчитывается!';
$_['text_incorrect_postcode'] = 'ОШИБКА! Доставка из этого почтового индекса не рассчиталась';
$_['text_incorrect_postcode2'] = 'ОШИБКА! Доставка из этого почтового индекса не рассчиталась ДЛЯ ДАННОГО тарифа';
		 
$_['entry_dop_indexes_ems_optimal'] = 'EMS Оптимальное';
$_['entry_dop_indexes_parcel_online'] = 'Посылка Онлайн (в отделение)';
$_['entry_dop_indexes_parcel_online_postamat'] = 'Посылка Онлайн (в почтомат)';
$_['entry_dop_indexes_courier_online'] = 'Курьер Онлайн';
$_['entry_dop_indexes_ecom'] = 'ЕКОМ'; 
$_['entry_mapsource']             = 'Какую карту использовать';
$_['entry_mapsource_module']             = 'Карта модуля';
$_['entry_mapsource_widget']             = 'Карта виджета Почты России';
$_['entry_mapwidget_code_ecom']               = 'Код виджета (ЕКОМ)';
$_['entry_mapwidget_code_parcel']               = 'Код виджета (Посылка Нестандартная/Посылка1класса)';
$_['entry_mapwidget_code_parcel_online']               = 'Код виджета (ПосылкаОнлайн)';
$_['entry_mapwidget_code_notice']        = 'Сайт виджета: <a href="https://widget.pochta.ru/" target=_blank
>https://widget.pochta.ru/</a><br>
Инструкция по интеграции: <a href="https://ocart.ru/russianpost2/widget" target=_blank
>https://ocart.ru/russianpost2/widget</a>'; 
$_['entry_mapwidget_code_ecom_notice']        = 'Сайт виджета: <a href="https://widget.pochta.ru/" target=_blank
>https://widget.pochta.ru/</a><br>
Инструкция по интеграции: <a href="https://ocart.ru/russianpost2/widget-ecom" target=_blank
>https://ocart.ru/russianpost2/widget</a>'; 

$_['text_tags_notice']	= '<b>ВАЖНЫЕ ТЭГИ (СПРАВКА)</b> <br>которые можно добавить в названия:<br>
{srok_block} - выводит <b>срок доставки</b>.<br> 
{service_name} - выводит название тарифа<br>
остальные тэги - смотрите в настройках ниже.
';
$_['entry_buttononly_ops_block']             = 'Блок выбора отделения/ПВЗ'; 
$_['default_buttononly_ops_block']             = '<div><a href="{selectlink}" 
class="button">Выбрать на карте</a></div>';


$_['header_pvz']             = 'Настройки отображения выбора ПВЗ/отделений на карте'; 
$_['header_pvz_notice']             = 'Для тарифов Посылка, ПосылкаОнлайн, Посылка 1 класса';
$_['entry_hide_map_js']	= 'Не выводить html-тэг вызова яндекс-карты';
$_['entry_hide_map_js_notice']	= 'Включите настройку если карту выводит также какой-то другой модуль доставки (например Боксберри)';

$_['text_general_instruction']	= '[ИНСТРУКЦИЯ ПО НАСТРОЙКЕ МОДУЛЯ ПОЧТА РОССИИ]';
$_['text_tags_notice2']	= 'добавьте {srok_block} чтобы вывести срок доставки';
$_['text_tag_pvz_partners_block'] = 'Информация о <b>партнерских</b> ПВЗ который выбрал покупатель (тариф ЕКОМ)';
$_['text_tag_pvz_rupost_block'] = 'Информация о ПВЗ <b>Почты России</b> который выбрал покупатель (тариф ЕКОМ)';
$_['default_tag_pvz_rupost_block']	= 'ПВЗ: {pvz_address} (#{pvz_number}), {pvz_worktime} {cod_block}';
$_['default_tag_pvz_partners_block']	= 'ПВЗ: {pvz_address} (#{pvz_number}), {pvz_worktime} {cod_block}';

$_['text_tag_srok_date']	= 'Дата доставки';
$_['text_tag_srok_date_example']	= 'Пример: 01.02.2022';
$_['text_tag_srok_block']	= 'Блок времени доставки. Можно подставить тэги {srok} и {srok_date}';

$_['col_packs_weight'] = 'Надбавку к весу (грамм)'; 
/* start 2712 */
$_['error_permission'] = "У пользователя под которым Вы авторизованы - нет прав на редактирование модуля";
/* end 2712 */
$_['default_tag_ops_block']	= 'ОПС: {postcode}, {ops_address}';
 
$_['entry_weight_source']	= 'Источник данных о весе товара';
$_['entry_sizes_source']	= 'Источник данных о габаритах товара';
$_['entry_weight_source_cart']	= 'Сессия (system/library/cart)';
$_['entry_weight_source_product']	= 'База данных (таблица product) - [РЕКОМЕНДУЕТСЯ]';

$_['default_rpcod_ecom_title']	= 'Оплата заказа в ПВЗ (+{price})';
 
$_['entry_rpcod_ecom_title']	= '(отдельно для ECOM-доставки) Название модуля "Оплата наложенным платежом EMS Почты России" отображаемое в оформлении заказа';

$_['entry_icons_format'] = 'Как выводить иконку МЕТОДА?'; 
$_['entry_icons_format_inname'] = 'В названии как html-блок (работает для стандартного оформления заказа и Simple)';
$_['entry_icons_format_inimg'] = 'Как отдельное поле img (Работает в Simple)'; 
$_['entry_icons_format_inimage'] = 'Как отдельное поле image (Работает в Quickcheckout, Ajax checkout и используется некоторыми модулями доставки)'; 


$_['entry_pvz_sorttype']       =  'Порядок сортировки ПВЗ';
$_['entry_pvz_sorttype_abc']       =  'По алфавиту';
$_['entry_pvz_sorttype_brand']       =  'По брэнду ПВЗ ("Гермес", "Халва", "Почта России" и т.п.)';
	
$_['entry_pvz_cod']            =  'Значение блока {cod_block}
<br><br>Тэги:<br>
{cod_value} - способ(ы) оплаты';
$_['entry_pvz_cod_all']            =  'Значение блока {cod_value} если в ПВЗ доступна оплата налож.платежа и КАРТОЙ и НАЛИЧКОЙ';
$_['entry_pvz_cod_none']           =  'Значение блока {cod_value} если в ПВЗ НЕДОСТУПНА оплата налож.платежа';
$_['entry_pvz_cod_cashonly']       =  'Значение блока {cod_value} если в ПВЗ доступна оплата налож.платежа ТОЛЬКО НАЛИЧКОЙ';
$_['entry_pvz_cod_cardonly']       =  'Значение блока {cod_value} если в ПВЗ доступна оплата налож.платежа ТОЛЬКО КАРТОЙ';

$_['default_pvz_cod']       	=  '<strong>Оплата заказа</strong>: {cod_value}';
$_['default_pvz_cod_all']       	=  'картой и наличными';
$_['default_pvz_cod_none']       	=  'недоступна';
$_['default_pvz_cod_cashonly']       =  'только наличными';
$_['default_pvz_cod_cardonly']       =  'только картой';
/* start 2712 */
$_['entry_postcalc_key'] = "Ключ домена";
$_['entry_postcalc_key_notice'] = 'Ключ можно <a href="http://postcalc.ru/lk/"
target=_blank>сгенерировать в Личном Кабинете</a>.<br>
Для отладки можно использовать ключ "test"';
/* end 2712 */

$_['default_ops_selectblock'] = '<select id="{select_id}" class="form-control" 
		onchange="event.stopPropagation(); event.preventDefault(); setRPPVZFromSelect(this, 1, \'{type}\');" 
		style="margin-right: 10px; max-width: 60%; display: inline; height:34px !important;; line-height:18px !important;; margin-right: 5px !important;">
		{options}
</select><a href="{selectlink}" class="button" style="margin-top: -3px;  height:34px; line-height:18px;"
> Выбрать на карте</a>
<br>';

$_['default_ops_worktime_block'] = '<strong>Режим работы</strong>: {lines} ';

$_['default_ops_selecttitle']             = '{postcode} {address}'; 
$_['default_ops_descblock'] = '<div><strong>Почтовый индекс</strong>: {postcode}<br>	
<strong>Адрес</strong>: {address} </div>';		
			
$_['text_tag_ops_block']	= 'Информация об отделении Почты России которое выбрал покупатель 
(тарифы Посылка Онлайн, Курьер Онлайн, EMS Оптимальное)';

$_['text_ops_header']             = 'Выбор Отделения Почты России';
$_['text_ops_notice']             = 'Выбор отделения - отображается на странице оформления заказа
при выполнении следующих условий:<br>
- Выбран один из сервисов с доставкой посылок в отделения Почты России: ПосылкаОнлайн, Посылка, Посылка 1 класса<br>
- В название способа доставки добавлен тэг {ops_block}';
 
$_['entry_ops_selectblock']             = 'Блок выбора отделения/ПВЗ
<br><br>Внимание! не удаляйте тэги {select_id} и {options}';

$_['entry_ops_descblock']             = 'Описание отделения/ПВЗ
<br><br>Тэги:<br>
{address} - адрес отделения, пример: "г. Москва, ул. Тверская, 12"<br> 
{postcode} -почтовый индекс отделения<br>
{worktime_block} - Блок с информацией о времени работы.<br>
{maplink} - Ссылка открывающая модальное окно с картой ';
  
$_['entry_ops_selecttitle']         = 'Отделение/ПВЗ в выпадающем списке<br><br>Тэги:<br>{address} - адрес отделения/ПВЗ<br>{postcode} - почтовый индекс';
 
$_['entry_ops_worktime_block']             = 'Блок {worktime_block}<br><br>Тэги:<br>
{lines} - информация о времени доставки';
 

$_['entry_is_ignore_user_postcode']  = 'Игнорировать индекс указанный покупателем в оформлении заказа';


/* start 1510 */
$_['entry_russianpost2_ifnouserpostcode']	= 'Что делать при расчете цены для тарифа работающего не для всех индексов (внутри одного города)?';
$_['entry_russianpost2_ifnouserpostcode_notice']	= 'Есть три таких тарифа: Курьер Онлайн, Посылка Онлайн и EMS Оптимальное';
$_['entry_russianpost2_ifnouserpostcode_usedetected']	= 'Рассчитывать цену доставки для индекса в данном городе, где данный тариф точно работает';
$_['entry_russianpost2_ifnouserpostcode_skip']	= 'Рассчитывать цену доставки только для индекса указанного в оформлении заказа. Если индекс не указан, то не рассчитывать доставку';
/* end 1510 */

$_['entry_tariff_curl_lifetime'] = 'Максимально-допустимое время запроса к API в секундах';
$_['entry_postcalc_curl_lifetime'] = 'Максимально-допустимое время запроса к API в секундах';
$_['entry_otpravka_curl_lifetime'] = 'Максимально-допустимое время запроса к API в секундах';

$_['error_pvz_upload_notoken']             = 'Загрузка ПВЗ невозможна, потому что не указан токен otpravka.pochta.ru';
$_['error_pvz_upload']             = 'Ошибка загрузки ПВЗ';
$_['success_pvz_upload']             = 'ПВЗ успешно загружены. Кол-во ПВЗ: ';


$_['header_otprvka_pvz']             = 'ПВЗ для тарифа ПосылкаОнлайн';
$_['entry_optravka_pvz_mode']             = 'Порядок подгрузки ПВЗ';
$_['entry_otpravka_pvz_curl_lifetime']             = 'Максимально-допустимое время запроса к API _для_подгрузки_ПВЗ_ в секундах';

$_['entry_optravka_pvz_mode_each_day']		= '1 раз в день в оформлении заказа (НЕ рекомендуется)';
$_['entry_optravka_pvz_mode_each_week']		= '1 раз в неделю в оформлении заказа (приемлемо)';
$_['entry_optravka_pvz_mode_each_month']	= '1 раз в месяц в оформлении заказа (приемлемо)';
$_['entry_optravka_pvz_mode_button']		= 'Нажатием кнопки';
$_['entry_optravka_pvz_mode_cron']		= 'По CRON 1 раз в день (рекомендуется)';

$_['entry_otpravka_pvz_cron']             = 'Команда для CRON (обновление списка ПВЗ):';
$_['entry_otpravka_pvz_date']             = 'Дата последнего обновления списка ПВЗ';
$_['entry_optravka_pvz']             = 'Обновление списка ПВЗ:';
$_['button_pvz']             = 'Загрузить ПВЗ';

$_['entry_pvz_worktime_block']             = 'Блок {worktime_block}<br><br>Тэги:<br>
{lines} - строки с рабочими или нерабочими днями';

$_['entry_pvz_worktime_workline_nodinner']             = 'Строчка для рабочего дня БЕЗ ПЕРЕРЫВА<br><br>Тэги:<br>
{days} - дни недели через запятую (пример: "пн, вт, ср")<br>
{start} - начало рабочего дня (пример: "09:00")<br>
{end} - конец рабочего дня (пример: "18:00")<br>
';

$_['text_tag_pvz_block']             = 'Информация о ПВЗ который выбрал покупатель (тариф ЕКОМ)';
	

$_['entry_pvz_worktime_workline_withdinner']             = 'Строчка для рабочего дня С ПЕРЕРЫВОМ<br><br>Тэги:<br>
{days} - дни недели через запятую (пример: "пн, вт, ср")<br>
{start} - начало рабочего дня (пример: "09:00")<br>
{end} - конец рабочего дня (пример: "18:00")<br>
{dstart} - начало перерыва (пример: "13")<br>
{dend} - конец перерыва (пример: "14")
';

$_['entry_pvz_worktime_weekendline']             = 'Строчка для выходного дня<br><br>Тэги:<br>
{days} - дни недели через запятую (пример: "пн, вт, ср")';

$_['entry_pvz_selecttitle']             = 'ПВЗ в выпадающем списке
<br><br>Тэги:<br>
{address} - адрес ПВЗ, пример: "г. Москва, ул. Тверская, 12"<br>
{cod_block} - Блок с информацией о налож.платеже';
$_['default_pvz_selecttitle']             = '{address}';

$_['text_pvz_header']             = 'Настройки выбор ПВЗ на карте';
$_['text_pvz_notice']             = 'Выбор ПВЗ - отображается на странице оформления заказа';

$_['entry_map_show']             = 'В каком блоке выводить выбор ПВЗ?';
$_['entry_map_show_title']             = 'Заголовок (title) - должно работать во всех модулях оформления заказа';
$_['entry_map_show_description']             = 'Описание (description) - рекомендуется для модуля оформления заказа Simple';

$_['entry_pvz_selectblock']             = 'Блок выбора ПВЗ
<br><br>Внимание! не удаляйте тэги {select_id} и {options}';
$_['entry_pvz_descblock']             = 'Описание ПВЗ
<br><br>Тэги:<br>
{address} - адрес ПВЗ, пример: "г. Москва, ул. Тверская, 12"<br>
{brand_name} - организация ПВЗ, пример: "Билайн"<br>
{worktime_block} - Блок с информацией о времени работы.<br>
{maplink} - Ссылка открывающая модальное окно с картой <br>
{cod_block} - Блок с информацией о налож.платеже';

$_['default_tag_pvz_block']        = 'ПВЗ: {pvz_address} (#{pvz_number}), {pvz_worktime} {cod_block}';


$_['default_pvz_selectblock'] = '<select id="{select_id}"  class="form-control"
		onchange="event.stopPropagation(); event.preventDefault(); setRPPVZFromSelect(this, 1, \'{type}\');" 
		style="margin-right: 10px; max-width: 60%; display: inline; height:34px !important;; line-height:18px !important;; margin-right: 5px !important;">
		{options}
</select><a href="{selectlink}" class="btn btn-primary" style="margin-top: -3px;  height:34px; line-height:18px;"
><i class="fa fa-map"></i>&nbsp;Выбрать на карте</a>
<br>';


$_['default_pvz_worktime_block'] = '<strong>Режим работы</strong>: {lines} ';
$_['default_pvz_worktime_workline_nodinner'] = '{days} - с {start} до {end};';
$_['default_pvz_worktime_workline_withdinner'] = '{days} - с {start} до {end} (перерыв {start}-{end});';
$_['default_pvz_worktime_weekendline'] = '{days} - выходной;';


$_['default_pvz_descblock'] = '<div><strong>Адрес</strong>: {address}<br>	
<strong>Организация</strong>: {brand_name}<br>
{worktime_block}
{cod_block}</div>';



/* start 0605 */
$_['entry_russianpost2_ifnopostcode']	= 'Что делать если неизвестен индекс получателя или доставка по нему не рассчиталась';
$_['entry_russianpost2_ifnopostcode_on']	= 'Рассчитыват доставку по другому индексу данного города';
$_['entry_russianpost2_ifnopostcode_off']	= 'Не рассчитывать доставку';
/* end 0605 */
/* start 1007 */
$_['entry_is_custom_calc_function'] = 'Собственная функция калькуляции веса/габаритов';
$_['entry_is_custom_calc_function_notice'] = 'Нужно добавить файл <a 
href="https://ocart.ru/download2/russianpost2.zip" 
target=_blank>russianpost2.php</a> в папку /system/helper/';

/* end 1007 */

/* start 3005 */
$_['entry_product_replace_weight'] = 'Заменять вес ТОВАРА на значение по-умолчанию (настройка выше) ДАЖЕ если в карточке товара указан вес';
$_['entry_product_replace_size']   = 'Заменять габариты ТОВАРА на значение по-умолчанию(настройка выше) ДАЖЕ если в карточке товара указан вес';

$_['entry_order_replace_weight'] = 'Заменять вес ЗАКАЗА на значение по-умолчанию (настройка выше) ДАЖЕ если у товаров указано указано значение веса или если указан вес товара по-умолчанию';
$_['entry_order_replace_weight_notice']	= 'Эта настройка перекрывает перекрывает все остальные настройки веса';
$_['entry_order_replace_size']   = 'Заменять габариты ЗАКАЗА на значение по-умолчанию(настройка выше) ДАЖЕ если в карточке товара указан вес';
$_['entry_order_replace_size_notice']	= 'Эта настройка перекрывает перекрывает все остальные настройки габаритов';
/* start 3005 */
/* start 0605 */
$_['entry_russianpost2_ifnopostcode']	= 'Что делать если неизвестен индекс получателя или доставка по нему не рассчиталась';
$_['entry_russianpost2_ifnopostcode_on']	= 'Рассчитыват доставку по другому индексу данного города';
$_['entry_russianpost2_ifnopostcode_off']	= 'Не рассчитывать доставку';
/* end 0605 */


$_['text_split']             = ' - [НЕСКОЛЬКО ОТПРАВЛЕНИЙ] ****';
$_['button_add_sort'] = 'Сортировка';
$_['entry_sort_order_relative'] = 'Абсолютное значение задается для всех методов в настройке выше';
$_['entry_sort_order_absolute'] = 'Абсолютное значение задается в настройках методов';

$_['entry_is_no_insurance_limit']	= 'Если объявл.ценность заказа больше чем объявл.ценность сервиса доставки?';
$_['entry_is_no_insurance_limit_hide']	= 'Не отображать сервис доставки (рекомендуется)';
$_['entry_is_no_insurance_limit_show']	= 'Отображать сервис доставки и рассчитывать цену доставки для максимально-возможной объявл.ценности';
$_['entry_is_no_insurance_limit_show2']	= 'Отображать сервис доставки и рассчитывать цену доставки для ВСЕЙ объявл.ценности';
$_['entry_is_pack_limit']	= 'Если для метода доставки включено авто-определение упаковки, но ни одна упаковка не подходит по размерам';
$_['entry_is_pack_limit_nopack']	= 'Не добавлять к стоимости доставки стоимость упаковки';
$_['entry_is_pack_limit_hide']	= 'Скрывать метод доставки';

$_['text_description'] = 'Описание:'; 
$_['text_description_link'] = 'блок с описаниями'; 

/* start 0503 */
$_['text_from'] = 'от';
$_['text_to'] = 'до'; 
$_['text_set'] = 'Определить';
$_['text_customsrok_notice'] = 'Если срок доставки не указан в настройках ниже, то используются сроки доставки API delivery.pochta.ru или postcalc.ru (в зависимости от настройки "Рассчитывать срок доставки" во вкладке "Настройки")';
$_['tab_customsrok'] = 'Свои сроки доставки';
$_['text_customsrok_header'] = 'Свои сроки доставки';
$_['col_russianpost_region_name'] = 'Регион';
$_['col_avia_srok_capital'] = 'АВИА-доставка в столицу региона (дней)';
$_['col_avia_srok_region'] = 'АВИА-доставка в др.города региона (дней)';
$_['col_surface_srok_capital'] = 'Наземная доставка в столицу региона (дней)';
$_['col_surface_srok_region'] = 'Наземная доставка в др.города региона (дней)';
/* end 0503 */
/* start 1202-3 */
$_['default_rpcod_ems_title']	= 'Оплата наложенным платежом EMS Почты России (+{price})';
 
$_['entry_rpcod_ems_title']	= '(отдельно для EMS-доставки) Название модуля "Оплата наложенным платежом EMS Почты России" отображаемое в оформлении заказа';

/* end 1202-3 */

$_['text_split_parcel_foreign_service_name']         = 'Несколько посылок заграницу ****';
$_['text_insured_split_parcel_foreign_service_name'] = 'Несколько ценных посылок заграницу ****';
$_['text_split_parcel_foreign_avia_service_name']         = 'Несколько АВИАпосылок заграницу ****';
$_['text_insured_split_parcel_foreign_avia_service_name'] = 'Несколько ценных АВИАпосылок заграницу ****';


/* start 1202 */
$_['entry_cod_tariftype_ems_minvalue'] = '(отдельно для EMS-доставки) Минимальная комиссия налож.платежа';
$_['entry_cod_tariftype_ems_percent_notice'] = 'Если значение не задано то используется общий процент';
$_['entry_cod_tariftype_ems_percent'] = '(отдельно для EMS-доставки) Процент взимаемый от стоимости объявленной ценности';
/* end 1202 */

/* start 1511 */
$_['entry_from_postcode_notice'] = '<b><font color=red>Внимание!</font></b> Если Вы используете API otpravka.pochta.ru - то нужно указать индекс Вашей "точки сдачи", 
который прописан в договоре и отображается в Личном Кабинете при создании отправления';
/* end 1511 */
/* start 0510 */
$_['text_statuserror_1'] = '<b><font color=red>Не удалось проверить лицензию, обратитесь к разработчику модуля internetstartru@gmail.com</font></b>';
$_['text_statuserror_2'] = '<b><font color=red>Лицензия заблокирована, обратитесь к разработчику модуля internetstartru@gmail.com</font></b>';
$_['text_statuserror_3'] = '<b><font color=red>Аккаунт не найден, обратитесь к разработчику модуля internetstartru@gmail.com</font></b>';
$_['text_statuserror_4'] = '<b><font color=red>Аккаунт заблокирован, обратитесь к разработчику модуля internetstartru@gmail.com</font></b>';
/* end 0510 */
$_['entry_use_max_product_weight'] = 'При рассчете веса заказа использовать только вес самого тяжелого товара в корзине';
/* start 0802 */
$_['entry_calc_by_region_for_remote']	= 'Рассчитывать цену доставки по региону если неизвестен (или неправильно указан) 
город и индекс, для регионов с труднодоступными населенными пунктами';
$_['entry_calc_by_region_for_remote_notice']	= 'Регионы с труднодоступными нас.пунктами: 
Амурская обл,
Архангельская обл,
Бурятия,
Камчатский край,
Красноярский край,
Магаданская обл,
Якутия,
Томская обл,
Тюменская обл,
Хабаровский край,
Ханты-Мансийский АО,
ЯНАО<br><b><font color=red>Внимание!</font></b> если настройка включена - модуль может рассчитать заниженную (до 1500 руб) стоимость доставки. Если доставка производится в труднодоступный населенный пункт (Пример: Красноселькуп, ЯНАО)';
/* end 0802 */
/* start 0510 */
$_['text_tag_weight_kg'] = 'Вес заказа в килограммах';
$_['text_tag_weight_g'] = 'Вес заказа в граммах';
$_['text_tag_dimensions_cm'] = 'Габариты заказа в сантиметрах';

$_['text_tag_weight_kg_example'] = 'Примеры: "2", "2.5"';
$_['text_tag_weight_g_example'] = 'Примеры: "200", "2000"';
$_['text_tag_dimensions_cm_example'] = 'Пример: "10x20x30"';
/* end 0510 */
		
$_['text_add_button']             = '+';
$_['text_del_button']             = 'x';
/* start 0110 */
$_['button_add_adds'] = 'Добавить надбавку';
$_['text_select_adds'] = 'Отключено';
$_['text_order_adds_cost_total_perc'] = '% от цены заказа';
/* start 0110 */

/* start 2308 */
$_['text_tag_shipping_cost'] = 'Стоимость доставки (до применения надбавки к методам)';
$_['text_tag_shipping_cost_example'] = 'Примеры: "11000 руб.", "$3000"';
/* start 2308 */

/* start 1202 */
$_['text_split_parcel_service_name']         = 'Несколько посылок ****';
$_['text_insured_split_parcel_service_name'] = 'Несколько ценных посылок ****';
$_['text_split_notice'] = '**** Для сервиса "Несколько посылок" - если отправление не входит в одну посылку по размеру/весу, то будет рассчитана стоимость доставки несколькими посылками';
/* end 1202 */

/* start 1112 */
$_['entry_if_nosrok']             = 'Рассчитывать срок доставки:';
$_['entry_if_nosrok_postcalc']    = 'API postcalc.ru (неофициальный API)';
$_['entry_if_nosrok_none']             = 'Не определять срок доставки';
$_['entry_if_nosrok_notice']             = 'Расчет срока доставки - это дополнительная нагрузка при отображении страницы (1 лишний запрос к стороннему серверу)';

/* end 1112 */

/* start 1202 */
$_['text_split_parcel_service_name']         = 'Несколько посылок ****';
$_['text_insured_split_parcel_service_name'] = 'Несколько ценных посылок ****';
$_['text_split_notice'] = '**** Для сервиса "Несколько посылок" - если отправление не входит в одну посылку по размеру/весу, то будет рассчитана стоимость доставки несколькими посылками';
/* end 1202 */

/* start 2901 */
$_['entry_cod_tariftype_minvalue'] = 'Минимальная комиссия налож.платежа';
/* end 2901 */
/* start 2012 */
$_['entry_debug_print'] = 'Включено - выводить отладочные сообщения на экран';
$_['entry_debug_log'] = 'Включено - сохранять отладочные сообщения в журнал ошибок';
/* end 2012 */

$_['entry_api_tariff_condition'] = '';


/* start 901 */
$_['entry_okrugl'] = 'Округленение цены';
$_['entry_okrugl_no'] = 'Отключено';
$_['entry_okrugl_round'] = 'Округлять до ближайшего целого, 1.5 = 2.0';
$_['entry_okrugl_ceil'] = 'Округлять вверх до целого, 1.01 = 2.00';
$_['entry_okrugl_floor'] = 'Округлять вниз до целого, 1.9 = 1.00';
$_['entry_okrugl_10ceil'] = 'Округлять вверх до 10 руб. - 11.0 = 20.0';
/* end 901 */

/* start 20092 */
$_['text_russianpost_country_notice']	= '- Установите соответствие между странами Почты России и странами Вашего магазина
- Страны отсутствующие в списке Почты России - можно не отключать. 
Но доставка для них не будет работать.
<br><br>
ДЛЯ СПРАВКИ:<br>
- <a href="http://emspost.ru/api/rest/?method=ems.get.locations&type=countries&plain=true"
target=_blank>Список стран (и территорий) EMS Почты России</a><br>
- <a href="https://www.pochta.ru/documents/10231/17590/%D0%A2%D0%B0%D1%80%D0%B8%D1%84%D1%8B+%D0%BD%D0%B0+%D0%BF%D0%B5%D1%80%D0%B5%D1%81%D1%8B%D0%BB%D0%BA%D1%83+%D0%BC%D0%B5%D0%BB%D0%BA%D0%B8%D1%85+%D0%BF%D0%B0%D0%BA%D0%B5%D1%82%D0%BE%D0%B2+%D0%B8%D0%B7+%D0%A0%D0%BE%D1%81%D1%81%D0%B8%D0%B9%D1%81%D0%BA%D0%BE%D0%B9+%D0%A4%D0%B5%D0%B4%D0%B5%D1%80%D0%B0%D1%86%D0%B8%D0%B8+%D1%81+16+%D0%BC%D0%B0%D1%8F+2016+%D0%B3..pdf/a7d15f22-2cbc-4905-bc05-c7bd694fb64b"
target=_blank>Список стран (и территорий) Почты России</a>
<br><br>
<b>Канарские острава</b> - отсутствуют в обоих списках, доставка туда считается как в континентальную Испанию. Напротив "Canary Islands (IC)" - должно стоять "ИСПАНИЯ".
<br><b>Аландские острава</b> - Почта России считает как в отдельную территорию, а EMS Почта России как в Финляндию.
В списке ниже напротив Aaland Islands (AX) - должно быть "АЛАНДСКИЕ ОСТРОВА", а не ФИНЛЯНДИЯ. EMS Доставка - будет рассчитываться корректно.';

$_['col_russianpost_country_name2']	= 'Страна или территория в базе Почты России отсутвующая в базе магазина';
$_['col_russianpost_region_name']	= 'Регион в базе Почты России';
$_['col_russianpost_region_code']	= 'Код региона';
$_['col_russianpost_region_select']	= 'Регион в базе магазина';
$_['col_russianpost_country_name']	= 'Страна/территория в базе Почты России';
$_['col_russianpost_country_code']	= 'Код страны';
$_['col_russianpost_country_select']	= 'Страна/территория в базе магазина';
$_['text_no_defined']	= 'Не задано';
$_['text_set_country']	= 'Задать';

$_['text_skipped_notice']	= 'В списке стран магазина отсутствуют следующие ниже страны. <br>
Если Вы хотите подключить доставку в эти страны, то добавьте их в список в разделе Система -> Локализация -> Страны<br>
При добавлении используйте указанные ниже Код ISO (2). Код ISO (3) - можно указать любые.';


/* end 20092 */
/* start 2009 */
/* start 2401 */
$_['text_order_adds_cost_fix']	= 'Фиксированная надбавка 1 раз';
$_['text_order_adds_cost_fix2products']	= 'Фиксированная надбавка умноженная на кол-во товаров в заказе';
$_['text_order_adds_cost_set']	= 'Конечная цена доставки [отменяет все другие надбавки]';
/* end 2401 */
$_['text_order_adds_cost_products_perc']	= '% от цены товаров';
$_['text_order_adds_cost_delivery_perc']	= '% от цены доставки';
/* end 2009 */

/* start metka-707 */
$_['text_filter_regions_type']	= 'Логика фильтра регионов';
$_['col_filter_filterproduct_region'] = 'Фильтры по регионом, геозонам, товарам, группам покупателей';
$_['text_product_filter'] = 'Фильтры к товару:';
$_['text_filter_regions_type_include_only']	= 'Отображать ТОЛЬКО для выбранного';
$_['text_filter_regions_type_exclude']	= 'НЕ отображать для выбранного';
/* end metka-707 */
/* start metka-407 */

$_['text_services_adds'] = 'Надбавка к методу:';
$_['text_adds_method_header']	= 'Надбавки к методам';
$_['text_adds_method_header_notice']	= 'Надбавки прикрепляются во вкладке "Методы доставки"';
$_['col_adds_method_name']	= 'Название';
/* start 0310 */
$_['col_adds_method_cost']	= 'Надбавка к цене доставки (или минимально-допустимая цена)';
$_['text_order_adds_cost_minvalue'] = 'Надбавка до минимально-допустимой цены';
/* end 0310 */
$_['col_adds_method_weight']	= 'Надбавка к весу (в граммах)';
$_['col_adds_method_sizes']	= 'Надбавка к габаритам (в сантиметрах)';
$_['col_adds_method_srok']	= 'Надбавка к сроку доставки в днях';
$_['col_adds_method_status']	= 'Статус';
$_['col_adds_method_filters']	= 'Фильтр по цене доставки (рубли)';
		
/* end metka-407 */
/* start metka-2006 */

$_['entry_api_otpravka_token'] = 'Токен авторизации';
$_['entry_api_otpravka_token_notice'] = 'Токен можно скопировать по <a href="https://otpravka.pochta.ru/settings#/api-settings" target=_blank>по ссылке</a>';
$_['entry_api_otpravka_key'] = 'Ключ авторизации';
$_['entry_api_otpravka_key_notice'] = 'Ключ можно сгенерировать 
<a href="https://otpravka.pochta.ru/specification#/authorization-key" 
target=_blank>по ссылке</a>';


$_['entry_otpravka_cache_lifetime'] = 'Время жизни кэша, в днях.';
$_['entry_otpravka_cache'] = 'Кэшировать запросы к Otpravka.pochta.ru';

$_['entry_api_otpravka_name'] = 'API Почты России (otpravka.pochta.ru)';
/* start 0212 */
$_['entry_api_otpravka_info'] = 'Официальный API для корпоративных клиентов Почты России. При рассчете делает запрос на otpravka.pochta.ru. <br>Возвращает и цену доставки и сроки доставки. Для каждого тарифа нужно делать 1 запрос к API для цены доставки';
$_['entry_api_otpravka_condition'] = 'Рассчитывает доставку только для юр.лиц заключивших договор с Почтой России.<br>
Доступны все тарифы кроме Посылка Стандарт (это тариф исключительно для НЕкорпоративных клиентов).';
/* end 0212 */

/* end metka-2006 */
/* start metka-1 */
$_['button_clear_cache']          = 'Очистить кэш';
$_['text_clear_cache_success']    = 'Кэш успешно очищен';
/* end metka-1 */

$_['entry_license']              = 'Код лицензии:';
$_['entry_license_notice']              = 'После покупки модуля Вам должно было прийти письмо с лицензиями на активацию. Если Вы не получили письмо то напишите разработчику на internetstartru@gmail.com. В письме укажите домен(ы) на который нужно подключить письмо, номер заказа и сайт на котором Вы купили модуль.';
				
$_['error_license_status'] = 'Лицензия отключена';
$_['button_setlicense']      = 'Подключить лицензию';
$_['empty_license_code']      = 'Не указан код лицензии';
$_['error_license_code']      = 'Неправильный код лицензии';
$_['text_license_success']      = 'Лицензия успешно подключена!';

$_['entry_articles']	= '';
$_['text_russianpost2_cod']	= 'СТАТЬЯ: <a href="https://ocart.ru/russianpost2/cod" target="_blank">Наложенный платеж Почты России</a>';
$_['text_russianpost2_api']	= 'СТАТЬИ: <a href="https://ocart.ru/russianpost2/otpravka-pochta-ru" target="_blank">Интеграция API otpravka.pochta.ru</a>, <a href="https://ocart.ru/russianpost2/api" target="_blank">Обзор API Почты России</a>';
$_['text_russianpost2_filters_dops']	= 'СТАТЬЯ: <a href="https://ocart.ru/russianpost2/filters" target="_blank">Фильтры, Надбавки и "Отметка осторожно" в модуле Почта России 2.0</a>';
$_['text_russianpost2_method_service']	= 'СТАТЬЯ: <a href="https://ocart.ru/russianpost2/methods" target="_blank">Архитектура модуля Почта России 2.0: Методы и Сервисы</a>';

$_['text_support']	= '<b>СТАТЬИ:</b> <ul>
	<li><a href="https://ocart.ru/russianpost2/start" target="_blank">ИНСТРУКЦИЯ ПО НАСТРОЙКЕ</a></li>
	<li><a href="https://ocart.ru/russianpost2/otpravka-pochta-ru" target="_blank">Интеграция API otpravka.pochta.ru</a></li>
	<li><a href="https://ocart.ru/russianpost2/methods" target="_blank">Архитектура модуля Почта России 2.0: Методы и Сервисы</a></li>
	<li><a href="https://ocart.ru/russianpost2/filters" target="_blank">Фильтры, Надбавки и "Отметка осторожно" в модуле Почта России 2.0</a></li>
	<li><a href="https://ocart.ru/russianpost2/api" target="_blank">Обзор API Почты России</a></li>
	<li><a href="https://ocart.ru/russianpost2/cod" target="_blank">Наложенный платеж Почты России</a></li>
</ul>

<p><b>ТЕХ.ПОДДЕРЖКА:</b></p>
internetstartru@gmail.com

';


$_['tab_api']	= 'API';
$_['tab_cod']	= 'Налож.платеж';
$_['entry_module_version'] = 'Версия модуля';
$_['entry_sfp_version'] = 'Версия данных Ocart.ru';
$_['entry_update_status'] = 'Обновление модуля';
$_['text_update_status_noneed'] = '<font color=green>Обновление модуля не требуется</font>';
$_['text_update_status_need'] = 'Требуется обновление модуля <font color=red><b>если Вы используете API Ocart.ru</b></font> для рассчета тарифов. Подробнее - см. вкладку Тех.поддержка';
$_['text_update_status_needanyway'] = '<font color=red><b>Обновление модуля требуется в любом случае, даже если Вы не используете API Ocart.ru. Подробнее - см. вкладку Тех.поддержка</b></font>';

$_['entry_ems_cache_lifetime'] = 'Время жизни кэша, в днях.';
$_['entry_postcalc_cache_lifetime'] = 'Время жизни кэша, в днях.';

$_['entry_notifyme'] = 'Уведомлять о необходимости обновить модуль на e-mail';
$_['entry_notifyme_email'] = 'E-mail для уведомлений';
$_['entry_notifyme_notice'] = 'Проверка актуальности тарифов осуществляется через CRON или через оформление заказа (настройки во вкладке "Синхронизация и API" => "API модуля"). Далее происходит сопоставление версии модуля и версии тарифов. Если для данных тарифов требуется обновить модуль - то Вы получите письмо на e-mail.';



$_['entry_rpcod_title']	= 'Название модуля "Оплата налож.платежом Почты России" 
отображаемое в оформлении заказа<br><br>

ИСПОЛЬЗУЕМЫЕ ТЭГИ:<br>
<b>{price}</b> - комиссия Почты России<br>
<b>{shipping_price}</b> - цена доставки<br>
<b>{full_price}</b> - комиссия+доставка<br>';

$_['entry_rpcodtotal_title']	= 'Название модуля "Комиссия за налож.платеж Почты России" отображаемое в оформлении заказа';
$_['entry_rpcodonly_title']	= 'Название модуля "Почта России - Перенос оплаты на наложенный платеж" отображаемое в оформлении заказа';

$_['default_rpcod_title']	= 'Оплата наложенным платежом Почты России (+{price})';
$_['default_rpcodtotal_title']	= 'Комиссия за налож.платеж Почты России (+{price})';
$_['default_rpcodonly_title']	= 'Почта России - Перенос оплаты на наложенный платеж';

$_['entry_cod_tariftype_default']	= 'Стандартные';
$_['entry_cod_tariftype_set']	= 'Установить';

$_['entry_cod_tariftype']	= 'Тарифы по которым рассчитывается цена налож.платежа для покупателей';
$_['entry_cod_tariftype_percent']	= 'Процент взимаемый от стоимости объявленной ценности';
$_['entry_cod_mintotal']	= 'Минимальная сумма заказа:
<br><i>Если сумма товаров МЕНЬШЕ - то метод оплаты не появится. Чтобы отключить этот фильтр - оставьте поле пустым</i>';
$_['entry_cod_maxtotal']	= 'Максимальная сумма заказа:
<br><i>Если сумма товаров БОЛЬШЕ - то метод оплаты не появится. Чтобы отключить этот фильтр - оставьте поле пустым</i>';
		


$_['entry_cod_is_double']	= 'Умножать стоимость доставки на 2';
$_['entry_cod_is_double_notice']	= '(применяется только если выбран сценарий "(2) Покупатель оплачивает доставку сразу, в момент оформления заказа" и только для методов доставки у которых выбран флажок "Доступен налож.платеж" )';

$_['entry_cod_is_cod_included']	= 'Включать налож.платеж в цену доставки';
$_['entry_cod_is_cod_included_incost']	= 'Напрямую в стоимость доставки';
$_['entry_cod_is_cod_included_inmod']	= 'Выводить как отдельный модуль "Учитывать в заказе"';
$_['entry_cod_is_cod_included_none']	= 'Выводить как отдельный модуль но, не включать в стоимость доставки';

$_['text_cod_notice']	= '<b>ПОЯСНЕНИЯ:</b><br>
- Сумма объявленной ценности РАВНА сумме наложенного платежа.<br>
<br>- Наложенный платеж невозможен при доставке БЕЗ объявленной ценности. <b>Во вкладке "Методы доставке" отметьте флажками те методы где должен работать налож. платеж.</b> Сгруппировуйте сервисы доставки так чтобы в выбранных методах были только сервисы с объявленной ценностью<br>
<br>- Продавец получает всю сумму наложенного платежа. Комиссия за налож.платеж взимается с покупателя СВЕРХ суммы налож.платежа. Пример: цена заказа 1000 руб., на почте покупатель платит 1000 руб. + еще 120 рублей комиссии. Продавец получает 1000 руб.
<br>- Если покупатель не заберет посылку в течении 15 дней, то она будте отправлена обратно продавцу. При заборе посылки продавцом, с продавца еще раз возьмут стоимость доставки. То есть в этом случае продавец оплачивает доставку два раза. Один раз при отправлении, второй раз при получении.<br>
<br>- Чтобы застраховаться от незабора посылки, Вы можете выбрать сценарий "(2) Покупатель оплачивает доставку сразу..."<br>
В рамках этого сценария, сумма заказа будет уменьшена на 1 или 2 стоимости доставки. В оформлении заказа пользователь будет видеть следующее:<br>
Стоимость товаров: 1000 руб.<br>
Доставка: 200 руб.<br>
Перенос оплаты на наложенный платеж: -1000 руб.<br>
ИТОГО: 200 руб.<br><br>
Далее покупатель оплатит доставку (200 руб) каким-то из доступных у Вас способов оплаты (картой, электронными деньгами).<br>А затем Вы отправите покупателю посылку с наложенным платежом 1000 руб.';

$_['entry_cod_script']	= 'Сценарий налож.платежа';
$_['text_cod_script_onlyshipping']	= '(2) Покупатель оплачивает доставку сразу, в момент оформления заказа. А основную сумму заказа - в момент вручения заказа';
$_['text_cod_script_onlyshipping_notice']	= '- В Дополнения -> Оплата - Должен быть <b>отключен</b> способ оплаты "Наложенный платеж Почты России".<br>
- В Дополнения -> Учитывать в заказе - Должен быть <b>отключен</b> модуль "Комиссия за наложенный платеж"<br>
- В Дополнения -> Учитывать в заказе - Должен быть <b>включен</b> модуль "Перенос стоимости заказа на наложенный платеж"';

$_['text_cod_script_full']	= '(1) Покупатель оплатит доставку в момент вручения заказа вместе со всей остальной строимостью заказа';
$_['text_cod_script_full_notice']	= '- В Дополнения -> Оплата - Должен быть <b>включен</b> способ оплаты "Наложенный платеж Почты России".<br>
- В Дополнения -> Учитывать в заказе - Должен быть <b>включен</b> модуль "Комиссия за наложенный платеж"<br>
- В Дополнения -> Учитывать в заказе - Должен быть <b>отключен</b> модуль "Перенос стоимости заказа на наложенный платеж"';
		
$_['col_cod_name']	= 'Сценарий';
$_['col_cod_instruction']	= 'Инструкция';
		
		
$_['text_image_header'] = 'Вставка изображений';
$_['text_image_notice'] = 'Если изображения картинок отключено - то используется просто текст. А если включено - то подставляется HTML-код.<br><br>

ИСПОЛЬЗУЕМЫЕ ТЭГИ:<br>
<b>{title}</b> - текст названия метода или группы методов<br>
<b>{image_url}</b> - URL картинки<br>
<b>{width}</b> - ширина картинки (в пикселях)<br>
<b>{height}</b> - высота картинки (в пикселях)';

$_['text_show_image'] = 'Отображать';
$_['entry_method_image_html'] = 'HTML-код названия ГРУППЫ МЕТОДОВ используемый если включена картинка.';
$_['entry_submethod_image_html'] = 'HTML-код названия МЕТОДА используемый если включена картинка.';

$_['text_product_adds_notice'] = '<b>ПОЯСНЕНИЯ:</b><br>
* - Отметка "Осторожно" присваиевается независимо от типа калькулиции.
';

/* start 2901-2 */
$_['text_product_filters_notice'] = '<b>ПОЯСНЕНИЯ:</b><br>
- Фильтр срабатывает если выполняются ВСЕ заданные условия.<br>
- фильтры не применяются к товарам, в настройках которых стоит "Требуется доставка - Нет"<br>
- <font color=red><b>Внимание!</b></font> в фильтре по категориям учитываются только категории прямо связанные с товарами. Без учета связей между родительскими и дочерними категориями.
';
/* end 2901-2 */


$_['text_order_filters_notice'] = '<b>ПОЯСНЕНИЯ:</b><br>
- Фильтр срабатывает если выполняются ВСЕ заданные условия.<br>
- фильтры по товарам не применяются к товарам, в настройках которых стоит "Требуется доставка - Нет"<br><br>

* - условие по регионам срабатывает если выполняются условия хотябы в одной строке.<br>
** - условие срабатывает если все значения (длина-ширина-высота) заданы
';

/* start 112 */
$_['text_methods_notice'] = '<b>ПОЯСНЕНИЯ:</b><br>
* - срабатывает если подходит хотябы один фильтр из списка<br>
** - <b>Внимание-1!</b> В методах доставки, в которых доступен налож.платеж - все сервисы должны быть Ценными / с объявл.ценностью. Налож.платеж недоступен при доставке заграницу.<br><br>
<b>Внимание-2!</b> флажок работает только для стандартного оформления заказа. В Simple взаимосвязь методов доставки и методов оплаты нужно настраивать в настройках Simple.<br>
<br>*** - упаковки задаются во вкладке Упаковка';
/* end 112 */

$_['text_col_deliverytypes_type_key']             = 'ID';
$_['text_col_deliverytypes_type_name']             = 'Название';
$_['text_col_deliverytypes_type_name_z']             = 'Название в родительном падеже для вставки в название и описания метода доставки ({type})';
$_['text_col_deliverytypes_content']             = 'Содержимое отправления';
$_['text_col_deliverytypes_maxlength']             = 'Максимально-допустимый размер отправления (длина x ширина x высота) в миллиметрах';
$_['text_col_deliverytypes_maxweight']             = 'Максимально-допустимый вес посылок в граммах';
$_['text_col_deliverytypes_maxsum']             = 'Максимально-допустимая сумма трёх сторон отправления (длина+ширина+высота) в миллиметрах';
$_['text_col_deliverytypes_status']             = 'Статус';

$_['text_cm']             = 'см.';
$_['text_mm']             = 'мм.';
$_['text_gramm']             = 'грамм';
$_['text_no_assigned']             = '(не назначено)';
$_['text_bydefault']             = 'По-умолчанию: ';
$_['text_formula_width_by_country'] = 'определяется в зависимости от страны';
$_['text_byformula']             = 'рассчитывается по формуле';
$_['text_delivery_types_header'] = 'Типы отправлений';
$_['text_delivery_types_notice'] = '<b>ПОЯСНЕНИЯ:</b><br>
- Значение "авто" означает что значение этого поля обновляется по API.<br>';

$_['text_tarif_link'] = 'Ссылка на тарифы';
$_['text_tarif_auto'] = 'авто';
$_['text_tarif_custom'] = 'изменить';

$_['entry_sort_order'] = 'Порядок сортировки';

$_['text_general_options'] = 'Общие настройки';
$_['col_service_name'] = 'Название сервиса';
$_['col_service_name_z'] = 'Название сервиса в род.падеже (для подстановки в название через тэг {service_name_z})';
$_['col_source'] = 'API';


$_['text_tags_header'] = 'Тэги для подстановки в названия методов';
$_['col_tag_name'] = 'Тэг';
$_['col_tag_description'] = 'Описание';
$_['col_tag_field'] = 'Блок или пример значения';
$_['text_tag_service_name'] = 'Название сервиса в им.падеже';
$_['text_tag_to_country'] = 'Страна доставки в им.падеже';
$_['text_tag_to_country_example'] = 'Примеры: "Австралия", "Парагвай"';


$_['text_tag_service_name_example'] = 'Примеры: "Письмо", "Заказная бандероль 1 класса"';
$_['text_tag_service_name_z'] = 'Название сервиса в род.падеже';
$_['text_tag_service_name_z_example'] = 'Примеры: "письма", "заказной бандероли 1 класса"';

$_['text_tag_from_region'] = 'Регион отправления';
$_['text_tag_from_region_example'] = 'Примеры: "Ростовская область", "Татарстан республика"';

$_['text_tag_from_city'] = 'Город отправления';
$_['text_tag_from_city_example'] = 'Примеры: "Ростов-на-Дону", "Казань"';

$_['text_tag_to_region'] = 'Регион доставки';
$_['text_tag_to_region_example'] = 'Примеры: "Ростов-на-Дону", "Казань"';

$_['text_tag_to_city'] = 'Город доставки';
$_['text_tag_to_city_example'] = 'Примеры: "Ростов-на-Дону", "Казань"';

$_['text_tag_insurance'] = 'Объявленная ценность отправления';
$_['text_tag_commission'] = 'Блок комиссии взимаемая дополнительно Почтой России при оплате наложенным платежом';
$_['text_tag_srok'] = 'Время доставки';

			


$_['entry_postcalc_email'] = 'Почтовый адрес человека, ответственного за работу скрипта (программист или системный администратор)';
$_['entry_postcalc_cache'] = 'Кэшировать запросы к Postcalc';

$_['entry_insurance_base'] = 'Включать в объявленную ценность';
$_['entry_insurance_base_total'] = 'Всю стоимость заказа включая стоимость доставки';
$_['entry_insurance_base_products'] = 'Стоимость заказа без доставки';

$_['tab_general']             = 'Настройки';
$_['tab_delivery_types']      = 'Типы отправлений';
$_['tab_api']             	  = 'API';
$_['tab_synx']             	  = 'Синхронизация и API';
$_['tab_service']             = 'Сервисы';
$_['tab_support']             = 'Тех.поддержка';
/* start 20092 */
$_['tab_regions']             = 'Регионы и страны';
/* end 20092 */
$_['tab_methods']             = 'Методы доставки';
$_['tab_filters']             = 'Фильтры';
$_['tab_geozones']             = 'Географические зоны';
/* start 2801 */
$_['tab_customs']             = 'Свои сервисы';
$_['tab_adds']             = 'Надбавки';
$_['text_customs_notice']             = 'Вы можете создать собственный сервис с нужной ценой доставки<br>
Созданные сервисы появятся во вкладе "Методы доставки" в выпадающих списках сервисов';
$_['col_customs_name']             = 'Название сервиса';
$_['col_customs_price']             = 'Цена';
$_['col_customs_type']             = 'Тип надбавки';
$_['col_customs_status']             = 'Статус';
$_['text_customs_type_single']             = 'Фиксированная цена';
$_['text_customs_type_bycount']             = 'Умножать указанную цену на кол-во товаров';
$_['text_free_service']             = 'Бесплатная доставка';
$_['button_customs_add']             = 'Добавить сервис';
/* end 2801 */

$_['err_not_rub']				= 'Не найдена валюта Рубль (RUB) в разделе: Система => Локализация => Валюты.';
$_['err_not_gramm'] = 'Не найдена единца веса Грамм. Добавьте ее в разделе Система -> Локализация -> Единицы веса (в поле Unit ("Сокращение") должно быть значение "г" или "g").';
$_['err_not_cm'] = 'Не найдена единца веса Сантиметр. Добавьте ее в разделе Система -> Локализация -> Единицы Длины (в поле Unit ("Сокращение") должно быть значение "см" или "cm").';

$_['entry_product_adds_type']	= 'Калькуляция надбавок к товару * ';
$_['entry_order_adds_type']	= 'Калькуляция надбавок к заказу';
$_['text_adds_type_all']	= 'Берутся все подходящие надбавки и суммируются';
$_['text_adds_type_one']	= 'Берётся только одна подходящая надбавка самая верхняя в списке';
$_['text_adds_type_byfilter']	= 'СМЕШАННЫЙ вариант: суммируются все надбавки у которых не указан фильтр и берется только одна надбавка из тех у которых указан фильтр';

$_['default_tag_insurance_block'] = 'с объявленной ценностью {insurance}';
$_['default_tag_commission_block'] = 'дополнительно при вручении посылки Вы заплатите: {commission}';
$_['default_tag_srok_block'] = ', срок доставки: {srok} дн.';

$_['entry_tax_class'] = 'Налоговый класс';
$_['text_none'] = 'Нет';

$_['entry_is_nds'] = 'Включать НДС в стоимость доставки';

$_['text_tag_country_block'] = 'Блок страны доставки (блок отображается только при доставке заграницу)';

$_['default_tag_country_block'] = 'Страна доставки: {to_country}';

$_['text_tag_insurance_block'] = 'Блок сумма объявл.ценности. Отображается только если отправка осуществляется с объявл.ценностью';

$_['text_tag_insurance'] = 'Сумма объявл.ценности в валюте оформления заказа';
$_['text_tag_insurance_example'] = 'Примеры: "1500 руб.", "$2300"';
$_['text_tag_commission'] = 'Комиссия взимаемая дополнительно Почтой России при оплате наложенным платежом';
$_['text_tag_commission_block'] = 'Блок комиссии за наложенный платеж. Отображается только если доставка осуществляется с наложенным платежом.';
$_['text_tag_commission_example'] = 'Примеры: "11000 руб.", "$3000"';
$_['text_tag_srok'] = 'Время доставки в днях';
$_['text_tag_srok_example'] = 'Примеры: "1-5", "10"';

$_['default_title'] = 'Почта России';
$_['text_success'] = 'Настройки сохранены';
$_['text_services'] = 'Сервисы:';
$_['text_services_sorttype'] = 'Способ выбора сервиса:';
$_['text_services_sorttype_minprice'] = 'Наименьшая цена';
$_['text_services_sorttype_minsrok'] = 'Наименьшее время доставки';
$_['text_services_sorttype_order'] = 'По порядку добавления';
$_['entry_version'] = 'Версия модуля:';
$_['entry_status'] = 'Статус:';
$_['entry_debug']	= 'Режим отладки:';

$_['text_filters_product_header'] = 'Фильтры к товару';
$_['text_filters_order_header'] = 'Фильтры к заказу';

$_['text_filters_product'] = 'Фильтры к товару';
$_['text_filters_order'] = 'Фильтры к заказу';
$_['text_geozone'] = 'Геозона: ';
/* start 0711 */
$_['text_customer_group'] = 'Разрешенные группы клиентов:'; 
$_['col_filter_filterproduct'] = 'Фильтры по товарам и группам покупателей';
/* end 0711 */

$_['col_adds_srok'] = 'Надбавку ко времени доставки (дн.)';
$_['col_adds_service'] = 'Сервис';
$_['text_select_region_geozone'] = 'Выберите';
$_['col_text_region_geozone'] = 'Регион или геозона';
$_['col_adds_cost'] = 'Надбавка к цене доставки';
$_['col_filter_sizes'] = 'Цена / Вес / Габариты / Количество';
$_['text_count_products'] = 'Кол-во товаров в заказе';
$_['col_method_filter'] = 'Фильтр *';
$_['text_no_filter'] = 'Без фильтра';

$_['text_nodelete_filter_product'] = 'Нельзя удалить фильтр %s потому что он используется в надбавках (%d) и/или фильтрах (%d)';
$_['text_nodelete_filter_order'] = 'Нельзя удалить фильтр %s потому что он используется в надбавках (%d) и/или  методах (%d)';

$_['text_less'] = 'Меньше или равно';
$_['text_more'] = 'Больше или равно';

$_['text_product_price'] = 'Цена товара';
$_['text_product_weight'] = 'Вес товара (грамм)';
$_['text_product_sizes'] = 'Габариты товара (см.)';

$_['text_select_filter'] = '';
$_['text_adds_order_header'] = 'Надбавки к заказу';
$_['button_add_filter'] = 'Добавить фильтер';

$_['text_all_product'] = 'ВСЕ товары в заказе (у которых стоит "Требуется доставка - Да") подпадают под фильтр';
$_['text_one_product'] = 'ХОТЯБЫ один товар (у которого стоит "Требуется доставка - Да") в заказе подпадает под фильтр';
$_['text_except_product'] = 'НИ ОДИН товар (у которого стоит "Требуется доставка - Да") в заказе НЕ подпадает под фильтр';

$_['text_product_length'] = 'Длина';
$_['text_product_width']  = 'Ширина';
$_['text_product_height'] = 'Высота';
$_['button_del_region']  = 'Удалить регион';
$_['button_add_region']  = 'Добавить регион';
$_['text_select_region']  = 'Выберите регион';
$_['button_add_adds']  = 'Добавить надбавку';
$_['col_adds_weight']  = 'Надбавка к весу (грамм)';
$_['col_adds_sizes']  = 'Надбавка к габаритам (см.)';

$_['col_adds_filter']  = 'Фильтр';
$_['col_adds_price']  = 'Надбавка к цене';
$_['col_adds_weight_sizes']  = 'Надбавка к весу и габаритам';
$_['col_adds_caution']  = 'Присваивать отметку "Осторожно"';
$_['col_adds_status']  = 'Статус';
$_['col_adds_sort_order']  = 'Порядок сортировки';

$_['text_adds_product_header']  = 'Надбавки к товару';

$_['col_text_region']  = 'Регион';
$_['col_text_city']  = 'Города (через запятую или точку с запятой), <br>чтобы выбрать все города - оставьте поле пустым';

$_['col_filter_geozone']  = 'Географическая зона';
$_['col_filter_region'] = 'Регионы и города *';

$_['text_order_price'] = 'Цена ТОВАРОВ в заказе';
$_['text_order_weight'] = 'Вес заказа включая надбавки к товарам если они заданы, но без надбавок к заказу';
$_['text_order_sizes'] = 'Размер заказа включая надбавки к товарам если они заданы, но без надбавок к заказу **';

$_['text_method_group'] = 'ГРУППА:';
$_['button_groupmethod_add'] = 'Добавить группу методов';
$_['button_del_service'] = 'Удалить сервис';
$_['col_method_geozone'] = 'Географическая зона';
$_['text_all_zones'] = 'Все геозоны';

$_['col_method_code'] = 'Код';
$_['col_method_title'] = 'Название';
$_['col_method_status'] = 'Статус';
$_['col_method_image'] = 'Изображение';
$_['col_method_sort_order'] = 'Порядок / Налож.платеж';

$_['col_submethod_code'] = 'Код';
$_['col_submmethod_image'] = 'Изображение';
$_['col_submmethod_title'] = 'Название';
$_['col_submmethod_sort_order'] = 'Порядок';
$_['col_submmethod_status'] = 'Статус';
$_['text_submethods'] = 'Методы доставки';

$_['text_is_show_cod'] = 'Доступен налож.платеж **';
$_['entry_method_title'] = 'Название'; 
$_['button_remove'] = 'Удалить';
$_['button_method_add'] = 'Добавить метод';
$_['button_cancel'] = 'Возврат';
$_['button_add_service'] = 'Добавить сервис';
$_['text_none_code'] = 'Нельзя добавить больше 10 методов';
$_['text_add_service'] = 'Выберите сервис';
$_['text_rub'] = 'руб.';
 		
$_['text_search_sub'] = 'Включает подстроку ( % ... % )';
$_['text_search_sub_noright'] = 'Строка начинается с: ( ... % )';
$_['text_search_sub_noleft'] = 'Строка оканчивается на: ( % ... )';
$_['text_search_strict'] = 'Точное совпадение';
$_['entry_ems_cache'] = 'Кэшировать запросы к API EMS';
$_['entry_manufacturer'] = 'Производитель';
$_['entry_category'] = 'Категория';
$_['button_filter_add'] = 'Добавить фильтр';
$_['col_filter_filtername'] = 'Название фильтра';
$_['col_filter_name'] = 'По названию товара / модели';
$_['col_filter_category'] = 'По категории';
$_['col_filter_manufacturer'] = 'По производителю';
$_['col_filter_sort_order'] = 'Статус / Порядок сортировки';
$_['col_filter_geo'] = 'Геозона';

$_['text_status'] = 'Статус:';

$_['text_sort_order'] = 'Порядок сортировки:';

$_['text_productname_header'] = 'Название товара:';
$_['text_productmodel_header'] = 'Модель:';

/* start synx */
$_['entry_synx_condition']			= 'Когда срабатывает загрузка для настроек "1 раз в день", "1 раз в неделю", "1 раз в месяц"';

$_['success_synx'] = 'Данные загружены!';
$_['entry_synx_notice']				= 'У DPD есть два запроса по API которые могут работать ОЧЕНЬ долго. Как следствие - они могут <b>вешать сайт в момент оформления заказа.</b>
<br><br><b>Назначение этих запросов:</b><br>
- Запрос списка городов куда доступна доставка наложенным платежом.<br>
- Запрос списка терминалов (Пунктов Выдачи Заказов)<br><br>
К счастью эти запросы можно выполнять время от времени, а не каждый раз при оформлении заказа.<br><br>

Идеальный вариант настроек - поставить выполнение запроса в CRON хостинга, если у Вас есть такая возможность.';

$_['entry_synx_mode'] = 'Режим обновления';

$_['entry_synx_mode_each_day']		= '1 раз в день в оформлении заказа (НЕ рекомендуется)';
$_['entry_synx_mode_each_week']		= '1 раз в неделю в оформлении заказа (приемлемо)';
$_['entry_synx_mode_each_month']	= '1 раз в месяц в оформлении заказа (приемлемо)';
$_['entry_synx_mode_by_button']		= 'Нажатием кнопки';
$_['entry_synx_mode_by_cron']		= 'По CRON 1 раз в день (рекомендуется)';
	
$_['entry_synx_type']				= 'Тип';
$_['entry_synx_date']				= 'Дата последнего обновления';
$_['entry_synx_cron']				= 'Запрос в CRON';

$_['button_synx']				= 'Загрузить';

/* end synx */

$_['button_save_go'] = 'Сохранить и выйти';
$_['button_save_stay'] = 'Сохранить и остаться';

$_['col_option_name'] = 'Опция';
$_['col_option_status'] = 'Включено';
$_['col_option_ismethod'] = 'Сделать отдельным сервисом *** ';
$_['col_option_cost'] = 'Надбавка к цене заказа (НДС включен)';
$_['col_option_condition'] = 'Ограничения';
$_['col_option_comment'] = 'Комментарий';
$_['text_service_notice'] = '*** Если флажок включен - то опция отобразится как отдельный метод во вкладке "Методы доставки" в выпадающих списках';

$_['success_upload']		= 'Данные успешно загружены';
$_['error_upload']			= 'Ошибка при обновлении данных. Попробуйте загрузить данные еще раз. Если не поможет - обратитесь к разработчику';


$_['entry_api_status'] = 'Статус:';
$_['entry_api_info'] = 'Информация:';
$_['entry_api_condition'] = 'Ограничения:';
$_['entry_api_synx_status'] = 'Синхронизация данных';
$_['entry_api_synx_mode'] = 'Порядок подгрузки данных';
$_['entry_api_sort_order'] = 'Порядок сортировки';
$_['entry_api_cron'] = 'Задача для CRON';

$_['entry_upload'] = 'Статус тарифов';
$_['button_update_tarif'] = 'Загрузить данные модуля';
$_['text_update_tarif_no'] = '<font color=red>Требуется обновить данные модуля</font>';
$_['text_update_tarif_yes']  = '<font color=green>Используются актуальные данные модуля</font>';

$_['text_data_notice'] = '<b>Данные модуля включают:</b><br>
- Список стран в которые доступна доставка<br>
- Список регионов и городов с почтовыми индексами, которые могут использоваться если индекс неизвестен.<br>
- Список опций доступных для разных сервисов Почты России<br>
- Список стандартных упаковок Почты России<br>
- Список всех отделений Почты России<br><br>

<b>Список ПВЗ</b> подгружаются по API otpravka.pochta.ru - отдельной кнопкой.<br>
ПВЗ расположены в магазинах, торговых центрах и т.п. доставка в них доступна только по тарифу ПосылкаОнлайн.
';

$_['entry_if_nosrok_tariff'] = 'API delivery.pochta.ru (официальный API)';

$_['entry_api_tariff_name'] = 'API Почты России (tariff.pochta.ru)';
/* start 0212 */
$_['entry_api_tariff_info'] = 'Официальный API Почты России tariff.pochta.ru . По-умолчанию рассчитывает доставку по тарифам для НЕкорпоративных клиентов. Но может рассчитывать по тарифам для корпоративных клиентов, если во вкладке "Сервисы" включить опцию "орпоративный клиент Почты России" в тарифах Посылка и Посылка 1 класса.  ';
/* end 0212 */

$_['entry_api_sfp_condition'] = 'Рассчитывает все сервисы.';
$_['entry_tariff_cache_lifetime'] = 'Время жизни кэша, в днях';
$_['entry_tariff_cache'] = 'Кэшировать запросы к tariff.pochta.ru';

$_['tab_packs'] = 'Упаковка';
$_['text_russianpost2_packs'] = 'Упаковочные материалы Почты России:<br>
<a href="https://www.pochta.ru/support/post-rules/package-materials"
>https://www.pochta.ru/support/post-rules/package-materials</a><br><br><b>Внимание!</b><br>
- Стоимость упаковки закладывается в цену только если стоит флажок во вкладке "Методы доставки"<br>
- При добавлении упаковки выбирается <b>самая дешевая</b> упаковка из тех, у которых: <br>
-- в правой колонке <b>стоит статус Включено</b><br>
-- подходят по объему';


$_['text_custom_packs_header'] = 'Собственные упаковки';
$_['text_russianpost_packs_header'] = 'Стандартные упаковки Почты России';

$_['col_packs_name'] = 'Название';
$_['col_packs_sizes'] = 'Размеры (см)';
$_['col_packs_price'] = 'Цена (включая НДС)';
$_['col_packs_status'] = 'Статус';
$_['button_custom_pack_add'] = 'Добавить собственную упаковку';

/* start 1606 */
$_['text_autoselect'] = 'Самая дешевая подходящая по габаритам';
$_['text_is_pack'] = 'Упаковка (добавляется к стоимости доставки) ***';
/* 1606 112 */
/* end 112 */

$_['entry_api_sfp_name'] = 'API модуля';
$_['entry_api_sfp_info'] = 'Подкачивает тарифы в базу данных. При рассчете стоимости доставки в оформлении заказа использует данные из базы данных и НЕ делает запрос на сторонний сайт.';
$_['entry_api_sfp_condition'] = 'Не рассчитывает доставку EMS';

$_['entry_api_postcalc_name'] = 'API Postcalc';


$_['entry_api_postcalc_info'] = 'Неофициальный API postcalc.ru. Достоинство этого API в том что одним запросом он возвращает цену доставки для всех тарифов. Не нужно делать отдельный запрос к API для каждого тарифа. Это <b>частично-платный API</b>, есть лимит бесплатных запросов в день. Для использования API нужно зарегистрироваться на <a href="http://postcalc.ru/lk/" target=_blank>http://postcalc.ru/lk/</a>';


$_['entry_api_postcalc_condition'] = 'Не рассчитывает: ПосылкаСтандарт. Сроки доставки могут быть неточными.';
/* end 0212 */

$_['entry_api_ems_name'] = 'API EMS Почты России';
$_['entry_api_ems_info'] = 'При рассчете делает запрос на emspost.ru';
$_['entry_api_ems_condition'] = 'Рассчитывает только стоимость EMS доставки.';

$_['entry_api_russianpost_name'] = 'API Почты России';
$_['entry_api_russianpost_info'] = 'Порядок рассчете делает запрос на otpravka.pochta.ru';
$_['entry_api_russianpost_condition'] = 'Рассчитывает все тарифы';

// ------

$_['entry_printpost_api_status'] = 'Определять город/регион по индексу с помощью API сайта print-post.com, если известен индекс и неизвестен город/регион';

$_['col_adds_name'] = 'Название';


/* start 20092 */
$_['tab_regions']             = 'Регионы и страны';
/* end 20092 */
$_['text_russianpost_regions_notice']	= '- Установите соответствие между регионами Почты России и регионами Вашего магазина<br>
- Отключите несуществующие на данный момент регионы (например: Таймырский Долгано-ненецкий автономный округ, Агинский бурятский автономный округ и т.п.) в разделе Система => Локализация => Регионы';
$_['col_russianpost_region_name']	= 'Регион Почты России';
$_['col_russianpost_region_code']	= 'Код региона';
$_['col_russianpost_region_select']	= 'Регион магазина';

// ----------
$_['text_default_weight_type_order']		= 'На весь заказ';
$_['text_default_weight_type_product']		= 'На каждый товар в заказе';

$_['text_default_city'] = 'Москва';
$_['entry_from_region'] = 'Регион отправки';
$_['entry_from_city'] = 'Город отправки';
$_['entry_from_postcode'] = 'Основной Почтовый индекс отправления';
$_['entry_product_nullweight'] = 'Если в настройках заказанного товара не указан вес';
$_['entry_order_nullweight'] = 'Если у всех товаров в заказе нулевой вес и не задано присвоение веса товара по-умолчанию (настройки выше)';

$_['text_product_nullweight_setnull'] = 'Оставлять вес товара нулевым';
$_['text_product_nullweight_setdefault'] = 'Присваивать товару вес по-умолчанию (устанавливается в настройке ниже)';

$_['text_nullweight_hide'] = 'Не отображать в оформлении заказа метод доставки';
$_['text_nullweight_show'] = 'Рассчитывать стоимость доставки для веса по-умолчанию (устанавливается в настройке ниже)';
$_['entry_product_default_weight'] = 'Вес товара по-умолчанию (в граммах)';
$_['entry_order_default_weight'] = 'Вес заказа по-умолчанию (в граммах)';



$_['entry_product_nullsize'] = 'Если в настройках заказанного товара не указаны габариты';
$_['entry_order_nullsize'] = 'Если у всех товаров в заказе нулевые габариты и не задано присвоение габаритов товара по-умолчанию (настройки выше)';

$_['text_product_nullsize_setnull'] = 'Оставлять габариты товара нулевыми';
$_['text_product_nullsize_setdefault'] = 'Присваивать товару габариты по-умолчанию (устанавливается в настройке ниже)';
$_['text_order_nullsize_setdefault'] = 'Присваивать заказу габариты по-умолчанию (устанавливается в настройке ниже)';

$_['text_nullsize_hide'] = 'Не отображать в оформлении заказа метод доставки';
$_['text_nullsize_show'] = 'Рассчитывать стоимость доставки для веса по-умолчанию (устанавливается в настройке ниже)';
$_['entry_product_default_size'] = 'Габариты товара по-умолчанию (в сантиметрах)';
$_['entry_order_default_size'] = 'Габариты заказа по-умолчанию (в сантиметрах)';


$_['entry_ifnocountry'] = 'Если при оформлении заказа не указана страна доставки';
$_['entry_ifnoregion'] = 'Если при оформлении заказа не указан регион доставки и отключено или не срабатало определение города по индексу через API print-post.com';
$_['entry_default_region'] = 'Регион доставки по-умолчанию';
$_['entry_ifnocity'] = 'Если при оформлении заказа не указан город доставки и отключено или не срабатало определение города по индексу через API print-post.com';
$_['text_use_default_city'] = 'Использовать город доставки по-умолчанию (указывается в настройке ниже)';
$_['text_hide_method'] = 'Не отображать метод доставки';
$_['text_use_default_region'] = 'Использовать регион доставки по-умолчанию';
$_['text_use_default_country'] = 'Считать что страна доставки - Россия';
$_['entry_default_city'] = 'Город доставки по-умолчанию';
		

?>