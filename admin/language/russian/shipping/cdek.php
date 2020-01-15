<?php
// Heading
$_['heading_title']						= 'Доставка транспортной компанией «СДЭК»';

// Text
$_['text_shipping']						= 'Доставка';
$_['text_success']						= 'Настройки модуля обновлены!';
$_['text_date_current']					= 'Текущая дата';
$_['text_date_append']					= 'Добавить';
$_['text_day']							= 'дней';
$_['text_loading']						= 'Выполняется загрузка';
$_['text_store_default']				= 'Основной магазин';
$_['text_drag']							= 'Перетащите, чтобы изменить приоритет';
$_['text_help_auth']					= 'Авторизация позволяет учитывать персональные тарифы и скидки, если они есть у интернет магазина (персональные тарифы и скидки возможны только при заключении договора со СДЭК).<br /><br /><em style="color: red;">Внимание:</em> Учетная запись для интеграции не совпадает с учетной записью доступа в Личный Кабинет на сайте СДЭК. Данные для интеграции интернет-магазина и транспортной компании СДЭК можно получить только по запросу. Все подробно описано на <a target="_blank" href="http://cdek.ru/faq/">сайте</a> компании разделе «Как начать интеграцию?».';
$_['text_geo_zone']						= 'Географическая зона';
$_['text_tariff']						= 'Выберите тариф:';
$_['text_help_im']						= '*** - Тарифы только для интернет-магазинов';
$_['text_first']						= 'Вывести первый адрес, остальные игнорировать';
$_['text_merge']						= 'Вывести все в одном тарифе';
$_['text_split']						= 'Разбить тариф на несколько с указанием конкретного адреса самовывоза для каждого тарифа';
$_['text_single']						= 'Наиболее приоритетный тариф';
$_['text_more']							= 'Все доступные тарифы';
$_['text_more_attention']				= '<strong>ВНИМАНИЕ!</strong> При большом количестве выбранных тарифов работа модуля может занять немного больше времени. Это связано с особенностями обмена.';
$_['text_view_type_attention']          = '<strong>ВНИМАНИЕ!</strong> Функция будет работать только при выполнении инструкции из файла readme.txt.';
$_['text_volume_attention']             = '<strong>ВНИМАНИЕ!</strong> Объем переводится в объемный вес из расчета 1м<sup>3</sup> = 200 кг.';
$_['text_from']							= 'от';
$_['text_fixed']						= 'фиксированное значение';
$_['text_percent_source_product']		= '% от стоимости товаров';
$_['text_percent_shipping']				= '% от стоимости доставки';
$_['text_percent_source_cod']			= '% от наложенного платежа';
$_['text_discount_help']				= 'Скидки / Наценки на стоимость доставки в зависимости от суммы заказа.';
$_['text_show_all']						= 'Показать все';
$_['text_short_length']					= 'Д';
$_['text_short_width']					= 'Ш';
$_['text_short_height']					= 'В';
$_['text_size_type_volume']				= 'объем';
$_['text_size_type_size']				= 'габариты';
$_['text_mode_order']					= 'Для всего заказа';
$_['text_mode_product_all']				= 'Вместо значения товара';
$_['text_mode_product_optional']		= 'Если значение не заполнено';
$_['text_weight_fixed']					= 'Килограмм';
$_['text_weight_all']					= '% от веса заказа';
$_['text_all_tariff']					= 'Все тарифы';
$_['text_weight']                       = 'Ограничения по весу';
$_['text_tariff_auth']                  = '<strong>ВНИМАНИЕ!</strong> Для работы тарифа требуется учетная запись СДЭК.';
$_['text_view_type_default']                = 'Без группировки';
$_['text_view_type_group']                = 'С группировкой';
$_['text_view_type_map']                = 'На карте';
$_['text_rounding_type_round']          = 'По умолчанию';
$_['text_rounding_type_floor']          = 'В меньшю сторону';
$_['text_rounding_type_ceil']           = 'В большую сторону';

// Entry
$_['entry_title']						= 'Заголовок:';
$_['entry_description']					= 'Описание:';
$_['entry_log']							= 'Режим отладки:<span class="help">Все ошибки в работе модуля или расчета доставки будут записаны в лог <br />(Система → Журнал ошибок).</span>';
$_['entry_period']						= 'Показывать сроки доставки:';
$_['entry_delivery_data']				= 'Показывать дату планируемой доставки:';
$_['entry_empty_address']				= 'Доставка с пустым адресом:<span class="help">Показывать тарифы с доставкой до двери (дверь-дверь, склад-дверь) если пользователь не заполнил адрес</span>';
$_['entry_show_pvz']					= 'Показывать адреса ПВЗ:<span class="help">Только для режимов доставки дверь-склад и склад-склад.</span>';
$_['entry_pvz_more_one']				= 'Если несколько ПВЗ:<span class="help">Действие в случае если в городе-получателе есть несколько ПВЗ.</span>';
$_['entry_cache_on_delivery']			= 'Учитывать ограничение наложенного платежа:';
$_['entry_work_mode']					= 'Вывод результатов:<span class="help">Вывод результатов формируется на основании списка выбранных тарифов</span>';
$_['entry_min_weight']					= 'Минимальный вес заказа:<span class="help">Значение указывается в килограммах</span>';
$_['entry_max_weight']					= 'Максимальный вес заказа:<span class="help">Значение указывается в килограммах</span>';
$_['entry_min_total']					= 'Минимальная сумма заказа:<span class="help">Ниже этого значения доставка не выводится. Оставить поле пустым, чтобы не учитывать</span>';
$_['entry_max_total']					= 'Максимальная сумма заказа:<span class="help">Выше этого значения доставка не выводится. Оставить поле пустым, чтобы не учитывать</span>';
$_['entry_city_from']					= 'Город отправления:';
$_['entry_length_class']				= 'Сантиметры:<span class="help">Единица измерения длины для сантиметров</span>';
$_['entry_weight_class']				= 'Килограммы:<span class="help">Единица измерения веса для килограммов</span>';
$_['entry_login']						= 'Логин:';
$_['entry_password']					= 'Пароль:';
$_['entry_cost']						= 'Стоимость:';
$_['entry_tax_class']					= 'Налоговый класс:';
$_['entry_geo_zone']					= 'Географическая зона:';
$_['entry_customer_group']				= 'Группа покупателей:';
$_['entry_status']						= 'Статус:';
$_['entry_sort_order']					= 'Порядок сортировки:';
$_['entry_default_size']				= 'Размеры по умолчанию';
$_['entry_volume']						= 'Объем';
$_['entry_size']						= 'Размеры отправления<span class="help">Указывается в сантиметрах</span>';
$_['entry_store']						= 'Магазины:';
$_['entry_additional_weight']			= 'Дополнительный вес:<span class="help">Значение указывается в килограммах и будет добавлен к суммарному весу</span>';
$_['entry_date_execute']				= 'Планируемая дата оправки заказа:';
$_['entry_weight_limit']				= 'Учитывать ограничение по весу для выдачи в ПВЗ:';
$_['entry_use_region']					= 'Запретить учет региона для выбранных стран:<span class="help">Если название ригиона, области, штата, провинции и т.д. не совпадает с таковым в базе СДЭК, то доставка не будет расчитана. При выключенной опции точность определения снижается.</span>';
$_['entry_check_ip']			        = 'Определять города по IP:<span class="help">Будет использовано в случае если по полю «Город» определить город не удалось</span>';
$_['entry_default_size_type']			= 'Задать значение через';
$_['entry_default_size_work_mode']		= 'Использовать размеры';
$_['entry_default_weight_use']			= 'Вес по умолчанию';
$_['entry_default_weight_work_mode']	= 'Использовать вес';
$_['entry_default_weight']				= 'Значение';
$_['entry_packing_min_weight']			= 'Минимальный вес упаковки:';
$_['entry_packing_additional_weight']	= 'Дополнительный вес:<span class="help">Значение будет добавлен к суммарному весу заказа</span>';
$_['entry_city_ignore']					= 'Список городов для которых выводить модуль не нужно:<span class="help">Значения вписываются через запятую</span>';
$_['entry_pvz_ignore']					= 'Список кодов ПВЗ / Почтоматов которых выводить не нужно:<span class="help">Значения вписываются через запятую</span>';
$_['entry_empty']						= 'Выводить всегда:';
$_['entry_empty_cost']					= 'Стоимость:<span class="help">По умолчанию: 0</span>';
$_['entry_more_days']					= 'Увеличить срок доставки:';
$_['entry_insurance']                   = 'Учитывать страховку<span class="help">0,75 % от стоимости товаров</span>';
$_['entry_hide_pvz']                    = 'Исключить код ПВЗ из кода тарифа<span class="help">Внимание! В случае отключения в интеграторе станет недоступно автоматическое определение ПВЗ</span>';
$_['entry_view_type']                   = 'Вариант отображения:';
$_['entry_rounding']                    = 'Округлять стоимость до целого числа:';
$_['entry_rounding_type']               = 'Тип округления:';

// Column
$_['column_tariff']						= 'Тариф';
$_['column_mode']						= 'Режим доставки';
$_['column_title']						= 'Заголовок<span class="help">Будет использовано вместо названия метода</span>';
$_['column_geo_zone']					= 'Географическая зона<span class="help">Если географическая зона не выбрана,<br /> то тариф будет доступен для всех регионов</span>';
$_['column_markup']						= 'Наценка';
$_['column_total']						= 'Сумма <span class="required">*</span><span class="help">Сумма, начиная с которой правило действительно</span>';
$_['column_tax_class']					= 'Налоговый класс';
$_['column_customer_group']				= 'Группа покупателей';
$_['column_discount_type']				= 'Тип скидки';
$_['column_discount_value']				= 'Значение';
$_['column_limit']						= 'Ограничения';
$_['column_empty']						= 'Показывать заглушку';

// Tab
$_['tab_auth']							= 'Авторизация';
$_['tab_tariff']						= 'Тарифы';
$_['tab_additional']					= 'Дополнительно';
$_['tab_package']						= 'Дополнительный вес';
$_['tab_discount']						= 'Скидки / Наценки';
$_['tab_empty']							= 'Заглушка';

// Button
$_['button_apply']						= 'Применить';
$_['button_add_discount']				= 'Добавить скидку';

// Error
$_['error_permission']					= 'У Вас нет прав для управления этим модулем!';
$_['error_warning']						= 'Внимательно проверьте форму на ошибки!';
$_['error_cdek_city_from']				= 'Необходимо выбрать город отправления!';
$_['error_tariff_list']					= 'Необходимо выбрать один или несколько тарифов!';
$_['error_curl']						= 'Для работы модуля трубуется расширение CURL!';
$_['error_numeric']						= 'Значение должно быть числом!';
$_['error_positive_numeric']			= 'Значение должно быть больше нуля!';
$_['error_positive_numeric2']			= 'Значение не должно быть меньше нуля!';
$_['error_tariff_item_exists']			= 'Тариф дублируется для географических зон: %s!';
$_['error_discount_exists']				= 'Скидка от указанной суммы уже установлена!';
$_['error_empty']						= 'Значение не заполнено!';
?>