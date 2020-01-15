===============================================
   OPENCART 1.5.x OPTIONS BOOST
===============================================

Supported OpenCart Versions:
================
v1.5.x


HOW TO REQUEST DEVELOPER SUPPORT:
===============
Please do not use the forums or extension store comments for support.
The fastest support is achieved by contacting me at these options:
	Email: qphoria@gmail.com
	Skype: taqmobile



Demo Video:
================
http://screencast.com/t/FlHdczdUej


What does it do:
================
This contrib adds additional parameters to Product Options.
It supports Select, radio, checkbox, and image radio option types.
Options now have their own SKU, info, image, and more to come.
The product page will swap the option data for the main image with each option selected
Option info will appear under the main image
Option sku will appear in the cart and on the admin order invoice


Important Notes:
==================
1. if you upgraded your opencart from 1.4.x to 1.5.x and had Options Plus Redux installed, 
be sure to remove the "options_plus_redux.xml" file from your vqmod/xml folder
2. SEE CUSTOMZATIONS SECTION BELOW FOR ADDITIONAL MODIFICATIONS


Requirements:
==============
- You will need to have vQmod engine 2.2.2 or later installed first.
Get it from http://vQmod.com


Main features:
==============
New Parameters:
  * SKU: Individual model/sku number for each option. Persists on cart page and throughout order and invoicing.
  * Info: short misc info field about the option. Hover over the image to see text
  * Image: an image to sit next to the option. Click image to thickbox enlarge
Other Features:
  * Uses vQmod for core changes
  * Includes vQmod script to support the Import/Export Excel mod (by JNeuhoff) (read notes below)
  * Ability to add current options to multiple product(s) simultaneously.
  * Is designed to be expanded with more options in the future.
  * Added additional price prefixes aside from (+) and (-):
    (%) will price the option based off the percentage of the product price
    (*) is product price * option price
    (=) uses option price for item price instead of adding to product price. Product price is ignored
	(1) adds the option price only one time to the product, regardless of qty purchased
  * Options with specials take same discount as product
  * Options with specials show discount strike-through for checkbox and radio types, just like the main product price
  * Option image shown in cart. (see note)
  * Optional Javascript popup message on options switch
  * ~NEW~ Supports CloudZoom

Note about Option Image in cart:
===============
Options Boost supports the ability to show the option image in the cart.
If you have multiple options with images on the same product, this will always use the last selected option's image
Best results are when you have option images for one of the options like:


- Good-				- Bad -
Product A			Product A
  Color:			  Color:
    Red (image)		    	Red (image)
    Blue (image)		    Blue (image)
  Size: 			  Size: 
    Large (no-image)    	Large (image)
    Small (no-image)		Small (image)


Compatibility:
=================
  * Is Compatible with Options Price Update Redux! You can use both mods together.
  * Not compatible with "Multiple Option Qty" as they are conflicting mods
  * Likely not be compatible with most other option mods as options are very deep into the core and changes usually don't mix well.
  

How to install:
==================
1) First you must install vQmod v2.4.1 or later. You can get it from http://vQmod.com

2) Unzip and upload the included folders to the root directory of your OpenCart installation
-- No files will be overwritten. The folders are simply merged together.

3) Goto admin and edit or insert a product. On the options tab you should see the new option values

4) You should also see a "Batch Copy" box.

5) If using additional languages other than or in addition to "english" then you will need to clone:
admin/language/english/catalog/options_boost.php
to
admin/language/<YOURLANG>/catalog/options_boost.php

6) The javascript was designed off the default theme. It assumes certain bits about the product page. 
If your theme uses different element names than the default, you may need to edit this file:
catalog/view/javascript/options_boost.js
At the top there are configurable bits for the theme.

7) If you are using the Export/Import Excel tool by JNeuhoff, goto the vqmod/xml folder and
   remove the "_" at the end of the "options_boost_import_export_addon.xml_" file


How to Use:
===================
1) Edit a product and goto the options page
2) You should see the new fields for select, checkbox, radio and image radio options
3) There is also a "batch option copy" box at the bottom.
This box lets you batch copy all the options you have on the curent product to other selected product(s) at the same time
There is a checkbox that allows you to optionally delete the existing options on those products so you don't end up with duplicates.
4) If you want a javascript popup to trigger when certain options are selected, add "~~" to the beginning of your message in the info field



Customizations:
=====================
If you want to enable the Option Stock Qty next to each option value
	1. EDIT: catalog/controller/product/options_boost.inc.php
	2. REMOVE THE // in front of this line:
	//$this->data['options'][$k]['option_value'][$j]['name'] = $this->data['options'][$k]['option_value'][$j]['name'] . ' [' . $options[$k]['option_value'][$j]['quantity'] . '] ';

If you do NOT want the option image to overwrite the product image in the cart:
	1. EDIT:  vqmod/options_boost_vqmod.xml
	2. ADD "//" in front of this line:
	'image'        => $prod_image

If you want to show the sku as part of the option name on the product page:
	1. EDIT: catalog/controller/product/options_boost.inc.php
	2. REMOVE THE // IN FRONT OF:
	//$this->data['options'][$k]['option_value'][$j]['name'] = $this->data['options'][$k]['option_value'][$j]['name'] . ' [' . $options[$k]['option_value'][$j]['ob_sku'] . '] ';

If you DO NOT want options to be discounted by the same discount value as the product:
	1. EDIT: catalog/controller/product/options_boost.inc.php
	2. FIND:
		if ((float)$disc_factor) {
	3. BEFORE, ADD:
		$disc_factor = 0;
	4. EDIT: vqmod/xml/options_boost_vqmod.xml
	5. FIND:
		if ($product_special_query->num_rows) {
	6. REPLACE WITH:
		if (0) {
	
If you want to disable the options from being discounted with the main product discount
	1. EDIT: catalog/controller/product/options_boost.inc.php
	2. REMOVE THE // in front of this line:
	//$disc_factor = false;
	
	1. EDIT: vqmod/xml/options_boost_vqmod.php
	2. REMOVE THE // in front of this line:
	//$disc_factor = false;

	If using my "Options Price Update Redux" mod for price update,
	1. EDIT: vqmod/xml/options_price_update_redux.xml
	2. REMOVE THE // in front of this line:
	//$disc_factor = false;
	
If you want the option image to revert back to the main product image for options without images:
	1. EDIT:  catalog/view/javascript/options_boost.js
	2. FIND:
	var revert = false;
	3. CHANGE TO:
	var revert = true;


Troubleshooting:
=====================
If you are not seeing anything happen, then it is likely due to your theme not using the same elements as the default.
I have set it so that you can change the main DOM element in the catalog/view/javascript/options_boost.js file
By default it is set to "#image" which is the id of the main image on the product page for the stock theme that holds the options
On other themes, like shoppica for example will likely need some adjustments.


History:
========
v156.7 - 2014-May-05 - Qphoria@gmail.com
- Added support for Cloudzoom
- Added customization steps for disabling option discounts

v156.6 - 2014-Apr-25 - Qphoria@gmail.com
- Fixed double special discounting on % and * prefix

v156.5 - 2014-Jan-12 - Qphoria@gmail.com
- Changed = to respect discount amount

v156.4 - 2013-Nov-30 - Qphoria@gmail.com
- Fixes for % calculation

v156.3 - 2013-Sep-06 - Qphoria@gmail.com
- Fix for options prices not showing

v156.2 - 2013-Aug-20 - Qphoria@gmail.com
- Fixed Readme for customizations
- Fixes inc file to have correct examples

v156.1 - 2013-Jul-25 - Qphoria@gmail.com
- Minor update to support OpenCart 1.5.6

v155.10 - 2013-Jul-25 - Qphoria@gmail.com
- Fixed page redirecting on load

v155.9beta - 2013-Jul-12 - Qphoria@gmail.com
- Added support for Default Product Options compatibility

v155.8beta - 2013-Jul-3 - Qphoria@gmail.com
- Redesigned to use vQmod for product options model to hopefully improve compatibility with other mods

v155.7 - 2013-Mar-31 - Qphoria@gmail.com
- Added options discount support for all prefixes

v155.6 - 2013-Mar-17 - Qphoria@gmail.com
- Fixed bug added with last version
- Fixed issue with out of stock options still showing
- Added strike-through for radio/checkbox/image options (not select tho since it can't be done)

v155.5 - 2013-Mar-16 - Qphoria@gmail.com
- Added new "1" prefix 
- Re-Added the fix for options not showing if out of stock and subtract = 1

v155.4 - 2013-Mar-15 - Qphoria@gmail.com
- Fixed export/import mod compatibility script
- Fixed override sku always defaulting to 1 when using import

v155.3 - 2013-Feb-07 - Qphoria@gmail.com
- Fixed no_image showing if option image not added

v155.2 - 2013-Feb-01 - Qphoria@gmail.com
- Fixed issue with option price double taxing for % and * based prefixes

v155.1 - 2013-Jan-25 - Qphoria@gmail.com
- Added 1.5.5.1 support
- Added support for "Image" option type to use that option-level image as the swap image if the product-option-level image is blank
- Added discounts to options for special prices on products. Now option will discount by the same percentage as the product special
- Officially dropped the swatch image idea. Just use the built-in OpenCart "image" option type

v153.4 - 2012-Aug-01 - Qphoria@gmail.com
- Added optional checkbox to allow overriding the product model in the cart and invoice pages with option sku
- Added back switch back to default image when option has no image

v153.3 - 2012-Jul-25 - Qphoria@gmail.com
- Full Aceshop compatibility
- Added "Clear" button for option image

v153.2 - 2012-Jun-12 - Qphoria@gmail.com
- Updated js file to be noConflict compatible
- Updated xml to support new AceShop changes

v153.1 - 2012-Jun-06 - Qphoria@gmail.com
- Updated readme

v152.2 - 2012-Apr-14 - Qphoria@gmail.com
- Added Aceshop Support

v152.1 - 2012-Jan-31 - Qphoria@gmail.com
- Added support for OpenCart v1.5.2

v151.9 - 2012-Jan-31 - Qphoria@gmail.com
- Added import/export support for 1.5.1.x

v151.8 - 2012-Jan-15 - Qphoria@gmail.com
- fixed info field saving to wrong option

v151.7 - 2012-Jan-03 - Qphoria@gmail.com
- fixed calculation bug with percent
- fixed version check in vqmod script that would break 1.5.2

v151.6 - 2011-Nov-25 - Qphoria@gmail.com
- Improved script to be more theme universal

v151.5 - 2011-Nov-19 - Qphoria@gmail.com
- Fixed calculation bugs with multiply and percent

v151.4 - 2011-Oct-17 - Qphoria@gmail.com
- Fixed bug with textboxes showing "array" for the value

v151.3 - 2011-Oct-14 - Qphoria@gmail.com
- Changed script inclusion to use addScript() function

v151.2 - 2011-Oct-13 - Qphoria@gmail.com
- Added ability to popup javascript alerts on option switch
- Fixed issue with checkboxes not returning to the main image when unchecked

v151.1 - 2011-Oct-04 - Qphoria@gmail.com
- Initial Release


License:
=========
This software is not free. Please see the included license document.
Licensing is "per-owner". Multiple sites permitted if owned by Licensee.
Paid client work requires separate licensing
Please contact Qphoria@gmail.com for a quote