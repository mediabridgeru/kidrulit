var shPanelBar={data:{},preparePosParam:function(){var pb_pos=shPanelBar.data.pb_pos;var pb_pos_prepared={};if(pb_pos.targetLeft)pb_pos_prepared.targetLeft=0;else delete shPanelBar.data.pb_pos.targetLeft;if(pb_pos.targetRight)pb_pos_prepared.targetRight=0;else delete shPanelBar.data.pb_pos.targetRight;if(pb_pos.targetTop)pb_pos_prepared.targetTop=0;else delete shPanelBar.data.pb_pos.targetTop;if(pb_pos.targetBottom)pb_pos_prepared.targetBottom=0;else delete shPanelBar.data.pb_pos.targetBottom;if(pb_pos.centerX)pb_pos_prepared.centerX=
true;else delete shPanelBar.data.pb_pos.centerX;if(pb_pos.centerY)pb_pos_prepared.centerY=true;else delete shPanelBar.data.pb_pos.centerY;$.extend(shPanelBar.data.pb_pos,pb_pos_prepared);shPanelBar.data.pb_orig_pos=jQuery.extend(true,{},shPanelBar.data.pb_pos)},init:function(init_data){shPanelBar.data=init_data;var behavior=shPanelBar.data.pan_box.behavior;if(behavior.hide&&behavior.width_less)if($(window).width()<behavior.width_less){$("#ssb-share-bar").remove();return false}shPanelBar.checkSort();
shPanelBar.preparePosParam();if($("meta[name=pinterest]").length&&$("meta[name=pinterest]").attr("content"))shPanelBar.data.share_image=$("meta[name=pinterest]").attr("content");shPanelBar.addSocialButton();var pb_pos=shPanelBar.data.pb_pos;$("#ssb-share-bar, .ssb-shar-container, .ssb-shar-button").hover(function(){$(this).fadeTo("slow",1)},function(){$(this).fadeTo("slow",shPanelBar.data.opacity_lev)});var time=1E3;setTimeout(function(){if(pb_pos.centerX||pb_pos.direction=="horizontal"){shPanelBar.data.direction_orig=
"horizontal";shPanelBar.changeCSSSharBar("horizontal")}else{shPanelBar.data.direction_orig="vertical";shPanelBar.changeCSSSharBar("vertical")}},time);if(shPanelBar.data.share_button)shPanelBar.makeShareButton();if(shPanelBar.data.pan_box.animate)floatingMenu.add("ssb-share-bar",pb_pos);else{shPanelBar.setShareBarFixed();if(pb_pos.centerX||pb_pos.centerY)$(window).resize(function(){shPanelBar.setShareBarFixed()})}if((behavior.move_to||behavior.hide)&&behavior.width_less)shPanelBar.condition(behavior)},
makeShareButton:function(){var $ssb_share_bar=$("#ssb-share-bar");var $ssb_share_items=$("#ssb-share-bar>div");$ssb_share_bar.append('<div class="ssb-shar-button"></div>');$ssb_share_bar.append('<div class="ssb-shar-container"></div>');$ssb_share_bar.find(".ssb-shar-container").append($ssb_share_items);$(".ssb-shar-button").click(function(){shPanelBar.animateClickSharBut()});shPanelBar.changeCSSSharBut()},animateClickSharBut:function(combination){var combination=combination?combination:shPanelBar.data.combination;
var $ssb_shar_container=$(".ssb-shar-container");var css_hide={};var css_show={};var shift=58;switch(combination){case "lt":css_hide.left=0;css_show.left=shift;break;case "ltx":css_hide.top=0;css_show.top=shift;break;case "rt":css_hide.right=0;css_show.right=shift;break;case "lty":css_hide.left=0;css_show.left=shift;break;case "rty":css_hide.right=0;css_show.right=shift;break;case "lb":css_hide.left=0;css_show.left=shift;break;case "lbx":css_hide.bottom=0;css_show.bottom=shift;break;case "rb":css_hide.right=
0;css_show.right=shift;break}css_hide.opacity="toggle";css_show.opacity="toggle";if($ssb_shar_container.hasClass("pan_show")){$ssb_shar_container.removeClass("pan_show");animate(css_hide)}else{$ssb_shar_container.addClass("pan_show");animate(css_show)}function animate(css){$ssb_shar_container.animate(css,{duration:700,specialEasing:{opacity:"linear",height:"swing"}})}},changeCSSSharBut:function(combination){var combination=combination?combination:shPanelBar.data.combination;if(combination=="original")combination=
shPanelBar.data.combination=shPanelBar.data.combination_orig;else shPanelBar.data.combination=combination;var padding=5;var css={};switch(combination){case "lt":css.right="auto";css.bottom="auto";css.left=0;css.top=0;break;case "ltx":css.left=shPanelBar.data.width/2-25+0;css.top=0;css.right="auto";css.bottom="auto";case "rt":css.right=0;css.top=0;break;case "lty":css.left=0;if(shPanelBar.data.direction=="vertical")css.top=shPanelBar.data.height/2-25+0;else css.top=padding;break;case "rty":css.right=
0;if(shPanelBar.data.direction=="vertical")css.top=shPanelBar.data.height/2-25+0;else css.top=padding;break;case "lb":css.left=0;css.bottom=0;break;case "lbx":css.left=shPanelBar.data.width/2-25+padding;css.bottom=0;css.top="auto";css.right="auto";break;case "rb":css.right=0;css.bottom=0;break}shPanelBar.showQRcode();$(".ssb-shar-button").css(css)},checkSort:function(){var $ssb_share_bar=$("#ssb-share-bar");var soc_buttons=shPanelBar.data.soc_buttons.data;var qr_code=shPanelBar.data.qr_code;var seo_items=
[];$.each(soc_buttons,function(name,val){seo_items.push({"name":name.toLowerCase(),"sort":val.data.sort})});seo_items.push({"name":"ssb_qr-code","sort":qr_code.data.sort});seo_items.sort(function(a,b){var a1=a.sort,b1=b.sort;if(a1==b1)return 0;return a1>b1?1:-1});$.each(seo_items,function(i,val){var $seo_item=$ssb_share_bar.find("."+val.name);$ssb_share_bar.append($seo_item)})},condition:function(behavior){var width_less=parseInt(behavior.width_less);checkCondition();$(window).resize(function(){if($(".ssb-shar-container").hasClass("pan_show"))$(".ssb-shar-button").click();
checkCondition()});function checkCondition(){if(behavior.hide)if($(window).width()<width_less)$("#ssb-share-bar").hide();else $("#ssb-share-bar").show();else if(behavior.move_to)if($(window).width()<width_less){shPanelBar.changeCSSSharBar("horizontal");var combination="";if(!shPanelBar.data.pan_box.animate){shPanelBar.data.pb_pos.targetLeft=0;delete shPanelBar.data.pb_pos.targetRight;shPanelBar.data.pb_pos.centerX=true;delete shPanelBar.data.pb_pos.centerY;if(behavior.move_to=="top"){shPanelBar.data.pb_pos.targetTop=
0;combination="ltx"}else if(behavior.move_to=="bottom"){shPanelBar.data.pb_pos.targetBottom=0;combination="lbx"}shPanelBar.setShareBarFixed();if(shPanelBar.data.share_button)shPanelBar.changeCSSSharBut(combination);else shPanelBar.showQRcode(combination);return}floatingArray[0].targetLeft=0;floatingArray[0].targetRight=undefined;floatingArray[0].centerX=true;floatingArray[0].centerY=undefined;if(behavior.move_to=="top"){floatingArray[0].targetTop=0;floatingArray[0].targetBottom=undefined;combination=
"ltx"}else if(behavior.move_to=="bottom"){floatingArray[0].targetTop=undefined;floatingArray[0].targetBottom=0;combination="lbx"}if(shPanelBar.data.share_button)shPanelBar.changeCSSSharBut(combination);else shPanelBar.showQRcode(combination)}else{var pb_pos=shPanelBar.data.pb_pos;shPanelBar.data.direction=shPanelBar.data.direction_orig;shPanelBar.changeCSSSharBar(shPanelBar.data.direction);if(!shPanelBar.data.pan_box.animate){shPanelBar.data.pb_pos=jQuery.extend(true,{},shPanelBar.data.pb_orig_pos);
shPanelBar.setShareBarFixed();if(shPanelBar.data.share_button)shPanelBar.changeCSSSharBut("original");return}floatingArray[0].targetLeft=pb_pos.targetLeft;floatingArray[0].targetRight=pb_pos.targetRight;floatingArray[0].centerX=pb_pos.centerX;floatingArray[0].centerY=pb_pos.centerY;floatingArray[0].targetTop=pb_pos.targetTop;floatingArray[0].targetBottom=pb_pos.targetBottom;if(shPanelBar.data.share_button)shPanelBar.changeCSSSharBut("original");shPanelBar.showQRcode()}}},changeCSSSharBar:function(vector){if(vector==
"horizontal"){$("#ssb-share-bar").css("width",shPanelBar.data.width+"px");$("#ssb-share-bar").css("height","82px");$("#ssb-share-bar, #ssb-share-bar .ssb-shar-container").css("padding","5px 0");$(".sharrre").css("margin","0 5px 0 5px");$(".sharrre div.box").css("margin-bottom","0px");shPanelBar.data.direction="horizontal"}else{$("#ssb-share-bar").css("height",shPanelBar.data.height+"px");$("#ssb-share-bar").css("width","52px");$("#ssb-share-bar, #ssb-share-bar .ssb-shar-container").css("padding",
"5px");$(".sharrre").css("margin","0px");$(".sharrre div.box").css("margin-bottom","20px");shPanelBar.data.direction="vertical"}$(".sharrre div.box:last").css("margin-right","0px");$(".sharrre div.box:last").css("margin-bottom","0px")},setShareBarFixed:function(){var pb_pos=shPanelBar.data.pb_pos;var $ssb_shar_bar=$("#ssb-share-bar");$ssb_shar_bar.css("position","fixed");if(pb_pos.centerX){var shar_bar_w=$ssb_shar_bar.width();var doc_w=$(window).width();var center_x=(doc_w-shar_bar_w)/2}if(pb_pos.centerY){var shar_bar_h=
$ssb_shar_bar.height();var doc_h=$(window).height();var center_y=(doc_h-shar_bar_h)/2}var share_css={};if(pb_pos.targetLeft===0)share_css.left="0px";if(pb_pos.targetRight===0)share_css.right="0px";if(pb_pos.targetTop===0)share_css.top="0px";if(pb_pos.targetBottom===0)share_css.bottom="0px";if(center_x){share_css.left=center_x+"px";delete share_css.right}if(center_y){share_css.top=center_y+"px";delete share_css.bottom}$ssb_shar_bar.css(share_css)},addSocialButton:function(){var pb_pos=shPanelBar.data.pb_pos;
var soc_buttons=shPanelBar.data.soc_buttons;var countReader=shPanelBar.data.countReader;var count_item=0;if(soc_buttons.data.Facebook.status)addButton("facebook");if(soc_buttons.data.Google.status)addButton("google","googlePlus");if(soc_buttons.data.Linkedin.status)addButton("linkedin");if(soc_buttons.data.Twitter.status){$("#ssb-share-bar .twitter").sharrre({share:{twitter:true},enableHover:false,enableTracking:true,buttons:{twitter:{via:""}},click:function(api,options){api.simulateClick();api.openPopup("twitter")},
urlCurl:countReader});count_item++}if(soc_buttons.data.Pinterest.status){$("#ssb-share-bar .pinterest").sharrre({share:{pinterest:true},enableHover:false,enableTracking:true,buttons:{pinterest:{url:document.location.href,media:shPanelBar.data.share_image,description:shPanelBar.data.page_title,layout:"horizontal"}},click:function(api,options){api.simulateClick();api.openPopup("pinterest")},urlCurl:countReader});count_item++}if(soc_buttons.data.Odnoklassniki.status){$(".odkl-klass-stat").attr("href",
document.location.href);count_item++}function addButton(button,soc_name){if(!soc_name)soc_name=button;var share_but={};share_but[soc_name]=true;$("#ssb-share-bar ."+button).sharrre({share:share_but,enableHover:false,enableTracking:true,click:function(api,options){api.simulateClick();api.openPopup(soc_name)},urlCurl:button=="google"?"":countReader});count_item++}if(shPanelBar.data.qr_code.status){shPanelBar.showQRcode();count_item++}shPanelBar.data.height=count_item*102-20;shPanelBar.data.width=count_item*
62;if(pb_pos.centerX||pb_pos.direction=="horizontal")$("#ssb-share-bar").css("width",shPanelBar.data.width+"px");else $("#ssb-share-bar").css("height",shPanelBar.data.height+"px")},showQRcode:function(new_combination){var combination=new_combination?new_combination:shPanelBar.data.combination;var pos;if(combination=="lt"||combination=="lb"||combination=="lty")pos="w";else if(combination=="rt"||combination=="rb"||combination=="rty")pos="e";else if(combination=="ltx")pos="n";else if(combination=="lbx")pos=
"s";shPanelBar.data.qrCurrPos=pos;$("#ssb-share-bar .ssb_qr-code").tipsy({gravity:function(){return shPanelBar.data.qrCurrPos},html:true,opacity:1,live:true})}};jQuery(document).ready(function(){shPanelBar.init(shPanelBar_data)});