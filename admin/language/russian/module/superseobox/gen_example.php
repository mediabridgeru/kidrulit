<?php $_['gen_tab_content_name_descrip']='ГЕНЕРАТОР ОПИСАНИЙ';
$_['gen_tab_content_exapmle_descrip']='<div class="">   
<p>    <span>Пример: для генерации описаний товаров для категории "Телефоны" выберите эту категорию в поле "Генерировать описание для" и задайте следующий шаблон:</span>    
<pre>"!pn новый революционный смартфон от !bn (!bd(1)), с ним Вы всегда будете ярче." 
</pre>-  получим (в качестве примера возьмем "iPhone 4s"):    <pre>"iPhone 4s новый революционный смартфон от  Apple (Apple разработала iPod и iTunes, Mак- ноутбуки и ПК,OS X операционную систему, и революционный iPhone и iPad.), с ним Вы всегда будете ярче."</pre>   </p>   <span>Используемые параметры:</span>   <dl class="dl-horizontal">    <dt><span class="label label-info">!pn</span></dt>    <dd><span class="span3">Наименование товара(ов)</span> <span class="span3">"iPhone 4s"</span></dd> <dt><span class="label label-info">!bn</span></dt> <dd><span class="span3">Наименование производителя(ей)</span>    <span class="span3">"Apple"</span></dd>    <dt><span class="label label-info">!bd(1)</span></dt>    <dd><span class="span3">Описание производителя(ей) (1-первое предложение из описания производителя)</span> <span class="span3">"Apple разработала iPod и iTunes, Mак- ноутбуки и ПК,OS X операционную систему, и революционный iPhone и iPad."</span></dd> </dl> <p class="colorFC580B"> 1.<img class="pull-right" src="view/stylesheet/superseobox/images/helper/descrip_prod_select.jpg">Вы можете написать индивидуальный SEO шаблон для каждой категории, для этого выберите категорию в поле "Генерировать описание для", после этого Вы сможете написать шаблон для товаров только для выбранной категории. После этого Вы можете нажать "Генерировать описание" (шаблон будет автоматически сохранен), после чего описания будут сгенерированы.</br><span class="clearfix"></span> 2.Кнопка "Очистить все" и "Очистить" используются для удаления описаний созданных SEO генератором.</br></br> 3.Для мультиязычных сайтов необходимо задавать  шаблон для каждого языка.   </p>   </div>';  

$_['gen_tab_content_name_tags']  = 'ГЕНЕРАЦИЯ ТЕГОВ';  
$_['gen_tab_content_exapmle_tags']  =            '<div class="">       <p>        <span>Пример: для генерации тегов для товаров мы напишем следующий шаблон:</span>        <pre>"!cn,!pn,!pb,!wt(,# купить в)" </pre>- и получим ("MacBook Air" - пример наименования товара):        <pre>"Планшеты,Ноутбуки,Планшеты и Ноутбуки,MacBook,Air,MacBook Air,Apple,купить в Городе1,купить в городе2,купить в Городе3,..."</pre>       </p>       <span>Используемые параметры:</span>       <dl class="dl-horizontal">        <dt><span class="label label-info">!cn</span></dt>        <dd><span class="span3">Наименование категории</span>"Планшеты,Ноутбуки,Планшеты и Ноутбуки"</dd>        <dt><span class="label label-info">!pn</span></dt>        <dd><span class="span3">Наименование товара</span>"MacBook,Air,MacBook Air"</dd>        <dt><span class="label label-info">!pb</span></dt>        <dd><span class="span3">Производитель</span>"Apple"</dd>        <dt><span class="label label-info">!wt</span></dt>        <dd><span class="span3">Города Вашей страны</span>"купить в Городе1,купить в Городе2,купить в Городе3, купить в ГородеХ"</dd>       </dl>       <p class="colorFC580B">       1. В поле для шаблона Вы можете написать свой собственный шаблон для генерации SEO-текста. Для этого Вы можете просто нажать на этом поле и после этого выбрать параметры во всплывающем окне или написать любой текст. После этого вы можете нажать "Генерировать" (шаблон автоматически сохраняется) и сгенерировать теги.</br></br>       2. Кнопка "Очистить все" и "Очистить" используются для удаления тегов со страниц.</br></br>       3. Для мультиязычных сайтов необходимо задавать  шаблон для каждого языка или же нажать "Копировать" и Ваш шаблон будет скопирован для всех языков.</br></br>       4. Внимание: в шаблонах тегов можно использовать только пунктуацию запятой. Один тег - это слово, несколько слов, параметр или комбинацию слов и параметров, которые находятся между двумя запятыми.       </p>       </div>'; 

$_['gen_tab_content_name_m_descrip'] = 'ГЕНЕРАТОР МЕТА-ОПИСАНИЙ'; 
 $_['gen_tab_content_exapmle_m_descrip'] =       '<div class="">       <p>        <span>Пример: для генерации Мета-Описаний для категорий мы напишем следующий шаблон:</span>        <pre>"Самые лучшие !cn, а особенно !ep(3). !cd(2) (!sn)" </pre>- который сгенерирует Мета-Описание следующего вида (категория для примера - "Ноутбуки"):        <pre>"Самые лучшие Ноутбуки, а особенно MacBook, HP LP3065, Sony Vaio. Первое предложение из описания категории Ноутбуки. Второе предложение из описания категории Ноутбуки. (www.mysite.com)"</pre>       </p>       <span>Используемые параметры:</span>       <dl class="dl-horizontal">        <dt><span class="label label-info">!cn</span></dt>        <dd><span class="span3">Наименование категории</span>        <span class="span3">"Ноутбуки"</span></dd>        <dt><span class="label label-info">!ep(3)</span></dt>        <dd><span class="span3">Примеры товаров из категории Ноутбуки (3 - количество товаров-примеров)</span>        <span class="span3">"MacBook,HP LP3065,Sony Vaio"</span></dd>        <dt><span class="label label-info">!cd(2)</span></dt>        <dd><span class="span3">Описание категории (2 - два первых предложения)</span>         <span class="span3">"Два первых предложения категории Ноутбуки"</span></dd>        <dt><span class="label label-info">!sn</span></dt>        <dd><span class="span3">Имя сайта</span>         <span class="span3">"www.mysite.com"</span></dd>       </dl>       <p class="colorFC580B">       1. В поле для шаблона Вы можете написать свой собственный шаблон для генерации Мета-Описания. Для этого Вы можете просто нажать на этом поле и после этого выбрать параметры во всплывающем окне или написать любой текст. После этого вы можете нажать "Генерировать" (шаблон автоматически сохраняется) и  сгенерировать Мета-Описания.</br></br>       2. Кнопка "Очистить все" и "Очистить" используются для удаления Мета-Описания.</br></br>       3. Для мультиязычных сайтов необходимо задавать  шаблон для каждого языка.</br></br>       4. Вы можете просмотреть  Мета-Описания в вверху кода страницы : <pre>&lt;meta name="description" content=" ***Тут сгенерированный SEO МЕТА Description*** " /&gt;</pre>       </p>       </div>';  
 
 $_['gen_tab_content_name_m_keywords']  = 'ГЕНЕРАТОР МЕТА-КЛЮЧЕЙ';  
 $_['gen_tab_content_exapmle_m_keywords']  =            '<div class="">       <p>        <span>Например, для генрации Мета-ключей для товаров мы зададим шаблон:</span>        <pre>"купить !pn, !cn, !pb,  !pm, !pu " </pre>- который сгенерирует такие ключи (товар для примера "Samsung Galaxy Tab 10.1"):        <pre>"купить Samsung Galaxy Tab 10.1, Планшеты, Samsung, Tab 10.1 4s, 036000291452"</pre>       </p>       <span>Используемые параметры:</span>       <dl class="dl-horizontal">        <dt><span class="label label-info">!pn</span></dt>        <dd><span class="span3">Наименование товара</span>"Samsung Galaxy Tab 10.1"</dd>        <dt><span class="label label-info">!cn</span></dt>        <dd><span class="span3">Категория</span>"Планшеты"</dd>        <dt><span class="label label-info">!pb</span></dt>        <dd><span class="span3">Производитель</span>"Samsung"</dd>        <dt><span class="label label-info">!pm</span></dt>        <dd><span class="span3">Модель</span>"Tab 10.1"</dd>        <dt><span class="label label-info">!pu</span></dt>        <dd><span class="span3">UPC товара</span>"036000291452"</dd>       </dl>       <p class="colorFC580B">         1. В поле для шаблона Вы можете написать свой собственный шаблон для генерации Мета-ключей. Для этого Вы можете просто нажать на этом поле и после этого выбрать параметры во всплывающем окне или написать любой текст. После этого вы можете нажать "Генерировать" (шаблон автоматически сохраняется) и  сгенерировать Мета-ключи.</br></br>       2. Кнопка "Очистить все" и "Очистить" используются для удаления Мета-ключей.</br></br>       3. Для мультиязычных сайтов необходимо задавать  шаблон для каждого языка.</br></br>       4. Вы можете просмотреть  Мета-ключи вверху кода страницы : <pre>&lt;meta name="keywords" content=" ***Тут SEO МЕТА-Ключи*** "/&gt; </pre>       </p>       </div>';

 $_['gen_tab_content_name_titles']  = 'ГЕНЕРАТОР ЗАГОЛОВКОВ'; 
 $_['gen_tab_content_exapmle_titles']  =            '<div class="">       <p>        <span>Например, для генерации Заголовков для производителей напишем такой шаблон:</span>        <pre>"!tp и более товаров производителя !bn (!ep(5#,)) Вы сможете найти на сайте !sn" </pre>- получим (производитель для примера "HTC"):        <pre>"50 и более товаров производителя HT (HTC One,HTC Touch HD,HTC BoomBass,HTC Mini+,HTC Desire 200) Вы сможете найти на сайте www.mysite.com"</pre>       </p>       <span>Используемые параметры:</span>       <dl class="dl-horizontal">        <dt><span class="label label-info">!tp</span></dt>        <dd><span class="span3">Общее количество товаров производителя </span>        <span class="span3">"50"</span></dd>        <dt><span class="label label-info">!bn</span></dt>        <dd><span class="span3">Производитель</span>        <span class="span3">"HTC"</span></dd>        <dt><span class="label label-info">!ep(5#,)</span></dt>        <dd><span class="span3">Примеры товаров производителя HTC("5" - количество примеров, "," - пунктуация между примерами)</span>        <span class="span3">"HTC One,  HTC Touch HD, HTC BoomBass, HTC Mini+, HTC Desire 200"</span></dd>        <dt><span class="label label-info">!sn</span></dt>        <dd><span class="span3">Название сайта</span>         <span class="span3">"www.mysite.com"</span></dd>       </dl>       <p class="colorFC580B">       
 1. В поле для шаблона Вы можете написать свой собственный шаблон для генерации Мета-заголовков. Для этого Вы можете просто нажать на этом поле и после этого выбрать параметры во всплывающем окне или написать любой текст. После этого вы можете нажать "Генерировать" (шаблон автоматически сохраняется) и  сгенерировать Мета-заголовки.</br></br>       2. Кнопка "Очистить все" и "Очистить" используются для удаления Мета-заголовков.</br></br>       3. Для мультиязычных сайтов необходимо задавать  шаблон для каждого языка.</br></br>
  4. Вы можете просмотреть Мета-Заголовок в браузере при наведении на вкладку страницы  </p>       </div>';

 $_['gen_tab_content_name_images']  = 'ГЕНЕРАТОР ИМЕН ФАЙЛОВ КАРТИНОК';  
 $_['gen_tab_content_exapmle_images'] =       '<div class="">       <p>        <span>Например, для генерации имен файлов для товаров зададим шаблон:</span>        <pre>"!cn-!pn" </pre>-  получим имя файла (пример товара "Iphone 4s", категория - Телефоны):        <pre>".../Телефоны-iphone4s-233.jpg"</pre>       </p>       <span>Используемые параметры:</span>       <dl class="dl-horizontal">        <dt><span class="label label-info">!cn</span></dt>        <dd><span class="span3">Категория</span>"Телефоны"</dd>        <dt><span class="label label-info">!pn</span></dt>        <dd><span class="span3">Наименование товара</span>"Iphone 4s"</dd>        <dt><span class="label label-info"></span></dt>        <dd><span class="span3">ID товара (вставляется автоматически)</span>"233"</dd>       </dl>       <p class="colorFC580B">      1. В поле для шаблона Вы можете написать свой собственный шаблон для генерации имен файлов. Для этого Вы можете просто нажать на этом поле и после этого выбрать параметры во всплывающем окне или написать любой текст. После этого вы можете нажать "Генерировать" (шаблон автоматически сохраняется) и  сгенерировать имена файлов.</br></br>       </br>       2. ВНИМАНИЕ: если у Вас есть модули использующие картинки (товаров, категорий, производителей) напрямую, то после генерации нужно перенастроить модули.</br></br>       3. Так же во всплывающем окне Вы можете нажать "Предпросмотр" и просмотреть несколько примеров.       </p>       </div>';

 $_['gen_tab_content_name_alt_image']  = 'ГЕНЕРАТОР МЕТА-ТЕГА ALT ДЛЯ КАРТИНОК';
 $_['gen_tab_content_exapmle_alt_image'] =       '<div class="">       <p>        <span>Например, для генерации alt-тега для картинок используем шаблон:</span>        <pre>"Купить !cn-!pn" </pre>- и получим (в качестве примера возьмем "Samsung Galaxy Tab 10.1") при наведении на картинку:        <pre>"Купить Планшеты-Samsung Galaxy Tab 10.1"</pre>       </p>       <span>Используемые параметры:</span>       <dl class="dl-horizontal">        <dt><span class="label label-info">!pn</span></dt>        <dd><span class="span3">Наименование товара</span>"Samsung Galaxy Tab 10.1"</dd>        <dt><span class="label label-info">!cn</span></dt>        <dd><span class="span3">Категория</span>"Планшеты"</dd>       </dl>       <p class="colorFC580B">       
 1. В поле для шаблона Вы можете написать свой собственный шаблон для генерации alt-текста. Для этого Вы можете просто нажать на этом поле и после этого выбрать параметры во всплывающем окне или написать любой текст. После этого вы можете нажать "Генерировать" (шаблон автоматически сохраняется) и  сгенерировать alt-текст</br></br>       2. Кнопка "Очистить все" и "Очистить" используются для удаления Мета-заголовков.</br></br>       3. Для мультиязычных сайтов необходимо задавать  шаблон для каждого языка.   </br></br>    4. Вы можете просмотреть alt-текст: <pre>&lt;img src="http://site.com/image.jpg" alt="Купить Планшеты-Samsung Galaxy Tab 10.1" /&gt;</pre>       </p>       </div>';

 $_['gen_tab_content_name_title_image']  = 'ГЕНЕРАТОР МЕТА-ЗАГОЛОВКОВ КАРТИНОК';
 $_['gen_tab_content_exapmle_title_image'] =       '<div class="">       <p>        <span>Например, для генерации текста мета-заголовков картинок для товаров используем шаблон:</span>        <pre>"!cn-!pn" </pre>-  получим (для пример возьмем товар "Samsung Galaxy Tab 10.1"):        <pre>"Планшеты-Samsung Galaxy Tab 10.1"</pre>       </p>       <span>Используемые параметры:</span>       <dl class="dl-horizontal">        <dt><span class="label label-info">!pn</span></dt>        <dd><span class="span3">Наименование товара</span>"Samsung Galaxy Tab 10.1"</dd>        <dt><span class="label label-info">!cn</span></dt>        <dd><span class="span3">Категория</span>"Планшеты"</dd>       </dl>       <p class="colorFC580B">      

 1. В поле для шаблона Вы можете написать свой собственный шаблон для генерации мета-заголовков картинок. Для этого Вы можете просто нажать на этом поле и после этого выбрать параметры во всплывающем окне или написать любой текст. После этого вы можете нажать "Генерировать" (шаблон автоматически сохраняется) и  сгенерировать мета-заголовки картинок</br></br>       2. Кнопка "Очистить все" и "Очистить" используются для удаления Мета-заголовков.</br></br>       3. Для мультиязычных сайтов необходимо задавать  шаблон для каждого языка.   </br></br> 
  4. Вы можете просмотреть мета-заголовки картинок: <pre>&lt;img src="http://site.com/image.jpg" title="Планшеты-Samsung Galaxy Tab 10.1" /&gt;</pre>       </p>       </div>';

 $_['gen_tab_content_name_urls']  = 'ГЕНЕРАТОР SEO ССЫЛОК';
 $_['gen_tab_content_exapmle_urls'] =   '<div class="">   <p>    <span>SEO генератор преобразует не-SEO ссылки в SEO для страниц КППИ (Категорий, Товаров, Производителей, Информационных страниц). Например, из:</span>    <pre>www.mysite.com/index.php?route=product/product&path=20&product_id=40</pre> в <pre>www.mysite.com/descktops/iphone</pre>   </p>   <p class="colorFC580B">    1. В поле для шаблона Вы можете написать свой собственный шаблон для генерации SEO ссылок. Для этого Вы можете просто нажать на этом поле и после этого выбрать параметры во всплывающем окне или написать любой текст. После этого вы можете нажать "Генерировать" (шаблон автоматически сохраняется) и  сгенерировать SEO ссылки</br>    2. Если оставить поля пустыми, то ссылки будет сгенерированы на основание названий товаров, категорий, производителей, инфо страниц</p>   <p>    <span>Генератор стандартных страниц (Главная, личный кабинет, контакты, корзина и т.д.) преобразует не-SEO в SEO ссылки. Например, из:</span>    <pre>www.mysite.com/index.php?route=common/home</pre> в <pre>www.mysite.com</pre>   </p>   <p>    Вы можете установить расширение для ссылок (по умолчанию: .html).</br> Если у Вас в магазине несколько языков, то плагин добавить код языка после домена. Например, язык по умолчанию французский:: <pre>mysite.com/en/about-us.html  mysite.com/propos-de-nous.html</pre> Для языка по умолчанию не будет добавлен код.   </p>   <div class="warning">   Если у Вас уже есть SEO ссылки, то Вы должны использовать генератор в режиме "Только для пустых"   </div>   <p class="alert">    Если у Вас нет файла .htaccess в корневой директории сайта, то после использование генератора SEO ссылок, найдите файл paladin.htaccess и переименуйте в .htaccess    </p>   </div>';

 $_['gen_tab_content_name_related_prod']  = 'ГЕНЕРАТОР ПОХОЖИХ ТОВАРОВ';
 $_['gen_tab_content_exapmle_related_prod'] =       '<div class="">       <p>       1. Здесь Вы можете генерировать похожие товары для каждого товара. Можно изменить количество отображаемых похожих товаров, после чего можно приступить к генерации.</br></br>       2. Так же во всплывающем окне Вы можете нажать "Предпросмотр" и просмотреть какие похожие товары будут сгенерированы.</br></br>       3. После нажатия на "Очистить все" будут удалены похожие товары созданные этим модулем.       </p>       </div>';

 $_['gen_tab_content_name_reviews']   = 'ГЕНЕРАТОР ОТЗЫВОВ ДЛЯ ТОВАРОВ';
 $_['gen_tab_content_exapmle_reviews']  =       '<div class="">       <p>      Здесь Вы можете легко сгенерировать отзывы для товаров. Гибкий настройки дают возможность задать интервал времени, процент отзывов, диапазон оценок и многое другое, смотрите ниже:       </p>       <dl class="dl-horizontal">        <dt>Own templates:</dt>        <dd>Вы можете задать свои шаблоны текста. Просто нажмите на "Добавить/Редактировать/Удалить шаблоны для отзывов" внизу страницы.</br>        В шаблонах Вы можете использовать макроподстановки: </br>       <span class="label label-info">!pn</span> - Наименование товара, </br>       <span class="label label-info">!pm</span> - модель, </br>       <span class="label label-info">!pd</span> - описание товара, </br>       <span class="label label-info">!cn</span> - категория, </br>       <span class="label label-info">!cd</span> - описание категории </br>       Каждая макроподстановка будет заменена соответствующими данными. Например: <pre>Этот !pn великолепен. Хочу сказать, что это лучший телефон, который у меня был</pre> после генерации отзывов текст будет выглядеть так       <pre>Этот HTC One великолепен. Хочу сказать, что это лучший телефон, который у меня был</pre>       </dd>       </dl>       <dl class="dl-horizontal">        <dt>Own names:</dt>        <dd>Вы можете задать имена пользователей для отзывов, просто нажмите "Добавить/Редактировать/Удалить имена
" внизу страницы.</dd>       </dl>       <p class="colorFC580B">Кнопка "Очистить"T удаляет отзывы созданные этим модулем.</p>';

 $_['gen_tab_content_name_seo_h1']  = 'ГЕНЕРАТОР H1 тега/заголовка';
 $_['gen_tab_content_exapmle_seo_h1']  =            '<div class="">       <p>        <span>Например, для генерации H1 для товаров укажем шаблон:</span>        <pre>"pn! - pm! от !sn" </pre>- то в итоге будет (в качестве примера возьмем "Samsung Galaxy Tab 10.1"):        <pre>"Samsung Galaxy Tab 10.1 - 4s от mysite.com"</pre>       </p>       <span>Используемые параметры:</span>       <dl class="dl-horizontal">        <dt><span class="label label-info">!pn</span></dt>        <dd><span class="span3">Наименование товара</span>"Samsung Galaxy Tab 10.1"</dd>        <dt><span class="label label-info">!pm</span></dt>        <dd><span class="span3">Модель</span>"4s"</dd>        <dt><span class="label label-info">!sn</span></dt>        <dd><span class="span3">Название сайта</span>"mysite.com"</dd>       </dl>       <p class="colorFC580B">     
1. В поле для шаблона Вы можете написать свой собственный шаблон для генерации H1. Для этого Вы можете просто нажать на этом поле и после этого выбрать параметры во всплывающем окне или написать любой текст. После этого вы можете нажать "Генерировать" (шаблон автоматически сохраняется) и  сгенерировать H1</br></br>       2. Кнопка "Очистить все" и "Очистить" используются для удаления H1.</br></br>       3. Для мультиязычных сайтов необходимо задавать  шаблон для каждого языка.
 </br></br>       </p>       </div>';  
 
 $_['gen_tab_content_name_seo_h2']   = 'ГЕНЕРАТОР H2 тега/заголовка';
 $_['gen_tab_content_exapmle_seo_h2']  =            '<div class="">       <p>        <span>Например, для генерации H2 для товаров укажем шаблон:</span>        <pre>"pn! - pm! от !sn" </pre>- то в итоге будет (в качестве примера возьмем "Samsung Galaxy Tab 10.1"):        <pre>"Samsung Galaxy Tab 10.1 - 4s от mysite.com"</pre>       </p>       <span>Используемые параметры:</span>       <dl class="dl-horizontal">        <dt><span class="label label-info">!pn</span></dt>        <dd><span class="span3">Наименование товара</span>"Samsung Galaxy Tab 10.1"</dd>        <dt><span class="label label-info">!pm</span></dt>        <dd><span class="span3">Модель</span>"4s"</dd>        <dt><span class="label label-info">!sn</span></dt>        <dd><span class="span3">Название сайта</span>"mysite.com"</dd>       </dl>       <p class="colorFC580B">     
1. В поле для шаблона Вы можете написать свой собственный шаблон для генерации H2. Для этого Вы можете просто нажать на этом поле и после этого выбрать параметры во всплывающем окне или написать любой текст. После этого вы можете нажать "Генерировать" (шаблон автоматически сохраняется) и  сгенерировать H2</br></br>       2. Кнопка "Очистить все" и "Очистить" используются для удаления H2.</br></br>       3. Для мультиязычных сайтов необходимо задавать  шаблон для каждого языка.
 </br></br>       </p>       </div>';
 
 $_['gen_tab_content_name_seo_h3']   = 'ГЕНЕРАТОР H3 тега/заголовка';
 $_['gen_tab_content_exapmle_seo_h3']  =            '<div class="">       <p>        <span>Например, для генерации H3 для товаров укажем шаблон:</span>        <pre>"pn! - pm! от !sn" </pre>- то в итоге будет (в качестве примера возьмем "Samsung Galaxy Tab 10.1"):        <pre>"Samsung Galaxy Tab 10.1 - 4s от mysite.com"</pre>       </p>       <span>Используемые параметры:</span>       <dl class="dl-horizontal">        <dt><span class="label label-info">!pn</span></dt>        <dd><span class="span3">Наименование товара</span>"Samsung Galaxy Tab 10.1"</dd>        <dt><span class="label label-info">!pm</span></dt>        <dd><span class="span3">Модель</span>"4s"</dd>        <dt><span class="label label-info">!sn</span></dt>        <dd><span class="span3">Название сайта</span>"mysite.com"</dd>       </dl>       <p class="colorFC580B">     
1. В поле для шаблона Вы можете написать свой собственный шаблон для генерации H3. Для этого Вы можете просто нажать на этом поле и после этого выбрать параметры во всплывающем окне или написать любой текст. После этого вы можете нажать "Генерировать" (шаблон автоматически сохраняется) и  сгенерировать H3</br></br>       2. Кнопка "Очистить все" и "Очистить" используются для удаления H3.</br></br>       3. Для мультиязычных сайтов необходимо задавать  шаблон для каждого языка.
 </br></br>       </p>       </div>';
 ?>
