<?php if($hiden) {
		//setting
        //ajax
        if($clear_sl = !$ajax_filter) {
            $clear_sl = true;
        }
        //css
		$css_through = 'text_through';
        $css_hide_text = 'hidis';
        $css_curs_point = 'curs_point';
        $css_scrl_text = 'scropis';
        $css_bloc_slid = 'slid';
        $cls_no_src = 'no_src';
        //animal-speed
        $animal_blok = 1000;
        /*arrow*/
        $icon_visi = '<span class="strel_hid_fa"><i class="'.$icon_awesome['title_filter']['icon_visi'].'" aria-hidden="true"></i></span>';
        $icon_hidi = '<span class="strel_hid_fa"><i class="'.$icon_awesome['title_filter']['icon_hidi'].'" aria-hidden="true"></i></span>';
        $shabl_title = '<span class="title_p_f">%s</span> %s';
        $cls_hiden1 = 'fa-caret-right';
        $cls_visit1 = 'fa-caret-down';
        $unfoldi_hid = '<span class="strel_hid_fa"><i class="fa '.$cls_hiden1.'" aria-hidden="true"></i></span>';
        $unfoldi_vis = '<span class="strel_hid_fa"><i class="fa '.$cls_visit1.'" aria-hidden="true"></i></span>';
        $displ_unfoldi = '<div class="displ"><span class="unfoldi">'.$legend_more.$unfoldi_hid.'</span></div>';
        /*end arrow*/
		/*others*/
		$position_hide = $position_set;
        $a_rel_nf = 'rel="nofollow"';
        $txt_nofollow = ($noindex_rel) ? $a_rel_nf : null;
        $arr_pz = array('qnts','nows','psp');
        //links
        $link_js = 'onclick="javascript:location=\'%s\'"';
        if($ajax_filter) {$link_js = '';}
        $link_html = 'href="%s"';
        $suff = '_html';
        if($url_js) {$suff = '_js';}
        $href_link_del = ${'link'.$suff};
        $href_link = ${'link'.$suff};
        /*fix_no_displ_attib_id*/
        $req_uri = $_SERVER['REQUEST_URI'];
        if(strpos($req_uri, '?') !== false) {
            $str_uri = strstr($req_uri, '?', true);
        }
        else {
            $str_uri = $req_uri;
        }
        $str_uri = urldecode($str_uri);
        $displ_param_1 = array(54);
        $displ_param_2 = array(55);
		$displ_param_3 = array(57);
        $no_displ_attib_id = array_merge($displ_param_1, $displ_param_2, $displ_param_3);
        $arr_attrib_url = array(
            'brend' => array(
                'adamex---adameks' => $displ_param_1
                ,'bebe-mobile---bebi-mobay' => $displ_param_2
				,'peg-perego-peg-perego' => $displ_param_3
                )
        );
        foreach($arr_attrib_url as $url_name => $vals) {
            if(strpos($str_uri, $url_name) !== false) {
                foreach($vals as $url_text => $val_id) {
                    if(is_array($val_id) && (strpos($str_uri, $url_text) !== false)) {
                        $no_displ_attib_id = array_diff($no_displ_attib_id, $val_id);
                    }
                }
            }
        }
        /*end fix_no_displ_attib_id*/
?>
<?php echo $start_bloc; ?>
<!--/**
 * <?php echo $versi_module.'; '.$cntr.' sec: '.$sec; ?>
 **/-->
  <div id="name_filter"><div id="head_filter" class="blok"><?php echo $name_filter; ?><span class="arrow_n_f"><span class="strel_fa_mob"><i class="<?php echo $icon_awesome['head_filter']['icon_visi']; ?>" aria-hidden="true"></i></span></span></div></div>
  <div id="ajx_bloc_filter"></div>
    <div id="filter_vier">
    <?php foreach($view_posit as $view_get => $view_val) {
            if(($view_get == 'chc') && $view_chc && $get_url_action) { // choice ?>
                <div id="action_get" class="block_fv <?php echo $view_get; ?>">
                    <div class="tec_vibor block_param">
                        <div class="blok title_filter"><?php echo $legend_choice; ?>
                            <span class="text_dia"><a <?php echo $a_rel_nf; ?> href="<?php echo $clear_filter; ?>"> <?php echo $legend_clears; ?></a></span>
                            <!-- div class="clears"></div -->
                        </div>
                        <?php if(!$mini_sel) { ?>
                            <?php foreach($get_url_action as $acti_gets) {
                                    foreach($acti_gets as $acti_get) { ?>
                                    <div class="onli_param_get">
                                    <span class="imt_p ligend_get"><?php echo $acti_get[key($acti_get)]['legend']; ?></span>
                                    <?php foreach($acti_get as $action_get) { $action_get_text = $action_get['text']; ?>
                                        <span class="botton_fv <?php echo $cls_btn; ?>"><a <?php echo $a_rel_nf; ?> class="checkg actionis" href="<?php echo $action_get['del']; ?>" title="<?php echo $legend_remove_position; ?> <?php echo $action_get_text; ?>"><?php echo $action_get_text; ?><span class="delis">&times;</span></a></span>
                                    <?php } ?>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            <?php  // / choice ?>
        <?php } elseif(in_array($view_get, $arr_pz)) { // qnts,nows,psp ?>
            <?php $main_id = 1; $param_id = 0; $pz = 'view_'.$view_get; if(!empty(${$pz})) {
                    $name_text = ${'legend_'.$view_get};
                    $rel_nf = (isset($canonic_view[$view_get])) ? $a_rel_nf : null;
                    $href_link1 = $href_link;
                    if($noindex_rel_nopp) {
                        $rel_nf =  $a_rel_nf;
                        if(${$pz}['blok_noindex']) {
                            $rel_nf = null;
                            $href_link1 = $link_html;
                        }
                    }
                    ?>
            <div class="block_fv <?php echo $view_get; ?> qnp">
                <div class="block_param">
                    <div class="onli_param blok title_filter qnp link_fv">
                    <?php $total_all = null; if($flag_count[$view_get]) {$total_all = sprintf($forms_total, ${$pz}['total_css'], ${$pz}['total']);}
                        $text_through = 'actionis';
                        if(${$pz}['action']) { if(${$pz}['total'] == 0) {$text_through = $css_through;}
                                $href = sprintf($href_link_del, ${$pz}['del_href']); ?>
                        <div class="<?php echo $text_through; ?>"><label><input type="hidden" name="<?php echo $view_get; ?>[<?php echo $main_id; ?>]" value="<?php echo $param_id; ?>" /><a <?php echo $rel_nf; ?> class="checka actionis" <?php echo $href; ?> title="<?php echo $legend_remove_position; ?>"><span class="text_param"><?php echo $name_text.$total_all; ?></span></a></label></div>
                        <?php } elseif(${$pz}['total'] == 0) { ?>
                        <div class="text_through"><label><span class="imt_a checkb curs_def"><span class="text_param"><?php echo $name_text.$total_all; ?></span></span></label></div>
                        <?php } else { $href = sprintf($href_link1, ${$pz}['href']); ?>
                        <div class=""><label><input type="hidden" name="<?php echo $view_get; ?>[<?php echo $main_id; ?>]" value="<?php echo $param_id; ?>" /><a <?php echo $rel_nf; ?> class="checkb" <?php echo $href; ?>><span class="text_param"><?php echo $name_text.$total_all; ?></span></a></label></div>
                    <?php } ?>
                    </div>
                </div>
            </div>
            <?php } // / qnts,nows,psp  ?>
        <?php } elseif($view_get == 'prs') { // prices ?>
            <?php if($view_prs || $slider_status) {
                    $main_id = 1;
                    //position
                    $strelka = null;
                    $css_hide = null;
                    $text_curs = null;
                    if($null_position_prs) {
                        $strelka = ($action_prs) ? $icon_hidi : $icon_visi;
                        $css_hide = ' '.$css_hide_text;
                        $text_curs = $css_curs_point;
                    }
                    $text_title = $legend_price;
                    $es_sl = false; $act_sl = null;
                    if($action_prs) { $es_sl = true; $act_sl = ' actionis'; $css_hide = null; }
            ?>
            <div class="block_fv <?php echo $view_get; ?>">
                <div class="block_param">
                    <?php if($text_title) { ?>
                    <div class="blok title_filter <?php echo $text_curs; ?>"><?php echo sprintf($shabl_title, $text_title, $strelka); ?></div>
                    <?php } ?>
                    <div class="onli_param blok slid<?php echo $css_hide; ?><?php if(!$slider_status) echo ' link_fv'; ?>">
            <?php if($slider_status) { // slider_price ?>
                        <div class="slider_attrib">
                            <div class="block_sl input_blok">
                                <table class="width_100_pr input_slider">
                                    <tr>
                                        <td><input name="prs[min]" id="left_count" class="form-control" type="text" value=""/></td>
                                        <td class="symbol_sld"><?php if(!$del_symbol) { ?>
                                        <span><?php echo $symbol; ?></span>
                                        <?php } ?></td>
                                        <td><input name="prs[max]" id="right_count" class="form-control" type="text" value=""/></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="block_sl shkala">
                                <input class="attrb_sl" type="text" id="price_slider" value="" />
                                <input type="hidden" name="<?php echo $view_get; ?>[<?php echo $main_id; ?>]" value="" /><span class="slidez<?php echo $act_sl; ?>"></span>
                            </div>
                            <div class="block_sl height_prim">
                                <table class="width_100_pr">
                                    <tr>
                                        <td id="cler_prs"><?php if($es_sl && $clear_sl) { ?><span class="text_clears"><a class="clear_slider" href="<?php echo $base_prs['del_href']; ?>"><?php echo $legend_clears; ?></a></span><?php } ?></td>
                                        <?php if(!$ajax_filter) { ?>
                                        <td><div id="prim_prs" class="button_slider">
                                        <span id="button_price<?php echo $base_prs['bloc_slider']; ?>" class="botton_fv bot_filt <?php echo $cls_btn; ?> <?php echo $base_prs['bloc_slider']; ?>"><?php echo $legend_apply; ?></span>
                                        </div></td>
                                        <?php } ?>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <script>
                            $(document).ready(function() {
                                var $cler_sl = $('#cler_prs')
                                    <?php if(!$ajax_filter) { ?>
                                    ,$button_sld = $('#button_price')
                                    <?php } ?>
                                    ,razdelit = '<?php echo $delit_param; ?>'
                                    ,c_price = ''
                                    ,get_main_bloc = '<?php echo $view_get.'['.$main_id.']'; ?>'
                                    ,flag_es_sl = <?php echo ($es_sl) ? 'true' : 'false'; ?>
                                    ,$rangeSld = $("#price_slider")
                                    ,$from = $("#left_count")
                                    ,$to = $("#right_count")
                                    ,clear_slider = false
                                    ,range_sld
                                    <?php foreach($base_prs['arr_view'] as $v) {
                                        echo ','.$v.' = '.$base_prs[$v];
                                    } ?>
                                    ,disable = <?php echo $base_prs['disable']; ?>
                                    ,input_values_separator = razdelit
                                    ,step = '<?php echo $base_prs['step']; ?>'
                                    ,symbol = '<?php echo $symbol; ?>'
                                    ,grid = <?php echo $base_prs['grid']; ?>;
                                
                                $from.attr('value', from);
                                $to.attr('value', to);
                                var updateValues = function () {
                                    if(isNaN(from)) {
                                        from = min;
                                    }
                                    if(isNaN(to)) {
                                        to = max;
                                    }
                                    $from.prop("value", from);
                                    $to.prop("value", to);
                                };
                                
                                $rangeSld.ionRangeSlider({
                                    type: 'double'
                                    ,hide_min_max: true
                                    ,hide_from_to: true
                                    //,hide_from_to: false
                                    ,input_values_separator: input_values_separator
                                    ,keyboard: true
                                    ,force_edges: true
                                    ,disable: disable
                                    ,from: from
                                    ,to: to
                                    ,min: min
                                    ,max: max
                                    ,step: step
                                    ,grid: grid
                                    //,grid_num: 5
                                    //,grid_snap: true
                                    //,prefix: symbol
                                    //,postfix: symbol
                                    //,values: values
                                    //,prettify_enabled: false
                                    <?php if($ajax_filter) { ?>
                                    ,onStart: function() {
                                        var temp_param = corectPrice('-', '');
                                        $rangeSld.next('input').attr('value', temp_param);
                                    }
                                    ,onFinish: function() {
                                        var temp_param = corectPrice('-', '');
                                        getDataPoles($rangeSld, $cler_sl, temp_param, get_main_bloc, clear_slider);
                                    }
                                    ,onUpdate: function() {
                                        var temp_param = corectPrice('-', '');
                                        getDataPoles($rangeSld, $cler_sl, temp_param, get_main_bloc, clear_slider);
                                    }
                                    <?php } ?>
                                    ,onChange: function (data) {
                                        from = data.from;
                                        to = data.to;
                                        updateValues();
                                    }
                                });
                                
                                <?php if($ajax_filter) { ?>
                                $cler_sl.on('click', 'a', function(e) {
                                    e.preventDefault();
                                    var slider = $rangeSld.data("ionRangeSlider");
                                    slider.reset();
                                    $from.val(slider.old_from);
                                    $to.val(slider.old_to);
                                    $cler_sl.empty();
                                    $rangeSld.next('input').attr('value', '').next('.slidez').removeClass('actionis');
                                    actionGet();
                                });
                                <?php } ?>
                                
                                range_sld = $rangeSld.data("ionRangeSlider");
                                var updateRange = function () {
                                    range_sld.update({
                                        from: from,
                                        to: to
                                    });
                                };
                                $from.on("change", function () {
                                    from = +$(this).prop("value");
                                    if (from < min) {
                                        from = min;
                                    }
                                    if (from > to) {
                                        from = to;
                                    }
                                    updateValues();
                                    updateRange();
                                });
                                $to.on("change", function () {
                                    to = +$(this).prop("value");
                                    if (to > max) {
                                        to = max;
                                    }
                                    if (to < from) {
                                        to = from;
                                    }
                                    updateValues();
                                    updateRange();
                                });

                                function corectPrice(razdelit, c_price) {
                                    var curs_tax = <?php echo $base_prs['tec_curs_tax']; ?>;
                                    var decimal_tec = <?php echo $decimal_tec; ?>;
                                    var correct_curs = 0;
                                    if(decimal_tec == 0) {
                                        if(curs_tax != 1) {
                                            decimal_tec = 2;
                                        }
                                        if(curs_tax < 1) {
                                            correct_curs = 0.0499;
                                        }
                                    }
                                    var shz = /\./g;
                                    var val_attrbs = $rangeSld.val();
                                    var all_min_max_prs = '';
                                    var arr_atrb = val_attrbs.split('-');
                                    if((arr_atrb[0] !== undefined) && (arr_atrb[1] !== undefined)) {
                                        var pr_min = arr_atrb[0];
                                        var pr_max = arr_atrb[1];
                                        if(pr_min === pr_max) {
                                            all_min_max_prs = ((pr_min / curs_tax - correct_curs).toFixed(decimal_tec));
                                        }
                                        else {
                                            var pr_min_tax = ((pr_min / curs_tax - correct_curs).toFixed(decimal_tec));
                                            var pr_max_tax = ((pr_max / curs_tax + correct_curs).toFixed(decimal_tec));
                                            all_min_max_prs = pr_min_tax + razdelit + pr_max_tax;
                                        }
                                        if(c_price) {
                                            all_min_max_prs = all_min_max_prs.replace(shz, c_price);
                                        }
                                    }
                                    return all_min_max_prs;
                                }
                                <?php if(!$ajax_filter) { ?>
                                    <?php if($base_prs['seo_url']) { ?>
                                    razdelit = '<?php echo $separators[1]; ?>';
                                    c_price = '<?php echo $cent_delit; ?>';
                                    <?php } ?>
                                    $button_sld.on('click', function() {
                                        var all_min_max_prs = corectPrice(razdelit, c_price);
                                        if(all_min_max_prs) {
                                            var shabl = '<?php echo $base_prs['shabl']; ?>';
                                            var slidery_u = '<?php echo $base_prs['href']; ?>'.replace(shabl, all_min_max_prs);
                                            otpravUrl(corrUrl(slidery_u));
                                        }
                                    });
                                <?php } ?>
                            });
                        </script>
            <?php } else { // end slider_price, start link price
                    $rel_nf = ($null_position_prs) ? $txt_nofollow : null;
                    foreach($view_prs as $val) {
                        $name_text = $val['text'];
                        $total_all = null;
                        $href_link1 = $href_link;
                        if($noindex_rel_nopp) {
                            $rel_nf =  $a_rel_nf;
                            if($val['blok_noindex']) {
                                $rel_nf = null;
                                $href_link1 = $link_html;
                            }
                        }
                        if($flag_count[$view_get]) {$total_all = sprintf($forms_total, $val['total_css'], $val['total']);}
                        $param_id = $val['start'].'-'.$val['end']; ?>
                        <?php if($val['temp_action']) { // && ($val['total'] == 0) ?>
                        <div class="link_price text_through">
                            <label><span class="checka curs_def imt_a"><span class="text_param"><?php echo $name_text.$total_all; ?></span></span></label>
                        </div>
                        <?php } elseif($val['total'] == 0) { ?>
                        <div class="link_price text_through">
                            <label><span class="checkb curs_def imt_a"><span class="text_param"><?php echo $name_text.$total_all; ?></span></span></label>
                        </div>
                        <?php } else {
                                if($val['action']) {
                                    $text_through = 'actionis'; if($val['total'] == 0) {$text_through = $css_through;}
                                    $href = sprintf($href_link_del, $val['del_href']);
                                    $link_a = $rel_nf.' '.$href.' class="checka actionis" title="'.$legend_remove_position.'"';
                                    
                                } else {
                                    $text_through = '';
                                    $href = sprintf($href_link1, $val['href']);
                                    $link_a = $rel_nf.' '.$href.' class="checkb"';
                                } ?>
                        <div class="link_price <?php echo $text_through; ?>">
                            <label><input type="hidden" name="<?php echo $view_get; ?>[<?php echo $main_id; ?>]" value="<?php echo $param_id; ?>" /><a <?php echo $link_a; ?>><span class="text_param"><?php echo $name_text.$total_all; ?></span></a></label>
                        </div>
                        <?php } ?>
                <?php } ?>
        <?php } ?>
                    </div>
                </div>
            </div>
            <?php } // / prices ?>
        <?php } elseif($view_get == 'attrb') { //attributes ?>
            <?php if(!empty($view_attrb)) { ?> 
            <div class="block_fv <?php echo $view_get; ?>">
                <?php if($fix_attrtool['fix_attrtool']) { ?>
                <style type="text/css"> .qtip {max-width: <?php echo $fix_attrtool['attrtool_maxwidth'].'px'; ?>;}</style>
                <?php } ?>
                <?php if(!empty($legend_attr)) { ?>
                    <div class="blok head_group"><?php echo $legend_attr; ?></div>
                <?php }
                    foreach($view_attrb as $k_id_group => $attributes) {
                        if($attributes['group_view']) { ?>
                        <div class="blok head_group group_attrb"><?php echo $attributes['group_view']; ?></div>
                        <?php }
                        foreach($attributes['data'] as $attribute) {
                            $main_id = $attribute['main_id'];
                            /*fix_no_displ_attib_id*/
                            if(in_array($main_id, $no_displ_attib_id)) continue;
                            /*end fix_no_displ_attib_id*/
                            $strelka = null;
                            $css_hide = null;
                            $text_curs = null;
                            $css_bloc = null;
                            
                            $flag_slider = $attribute['slider'];
                            $flag_botton = $attribute['button'];
                            $flag_select = $attribute['select'];
                            $flag_radio = $attribute['radio'];
                            if(!$flag_slider && $count_not_dislay && ($attribute['count_param'] < $count_not_dislay)) continue;
                            $dislay_fv = ' link_fv'; 
                            if($flag_botton) {
                                $dislay_fv = ' img_fv';
                            }
                            elseif($flag_radio) {
                                $dislay_fv = ' radio_fv';
                            }
                            elseif($flag_select) {
                                $del_href = null; 
                                if($attributes['action'][$main_id]) {
                                    $del_href = $attributes['action'][$main_id];
                                }
                                elseif($attributes['action_gr']) {
                                    $del_href = $attributes['action_gr'];
                                }
                                if($del_href && !$ajax_filter) {
                                    $dislay_fv = ' select_fv act_sel';
                                }
                                else {
                                    $dislay_fv = ' select_fv';
                                }
                            }
                            $position_hide = ($null_position = $attribute['null_position']) ? 0 : $position_set;
                            if($attributes['flag_group']) {
                                $id_attrb = 'gr_attrb_'.$k_id_group;
                            }
                            else {
                                $id_attrb = 'attrb_'.$main_id;
                            }
                            if($null_position) {
                                $text_curs = $css_curs_point;
                                $strelka = $icon_visi;
                                $css_hide = ' '.$css_hide_text;
                                //bloc_hide
                                if($attributes['action_gr'] || $attributes['action'][$main_id]) {
                                    $css_hide = null;
                                    $strelka = $icon_hidi;
                                }
                                //end bloc_hide
                                if(!$css_hide) {
                                    $position_hide = $position_set;
                                }
                            }
                            if($flag_slider) {
                                $css_bloc = $css_bloc_slid;
                                if(isset($slider_attr[$main_id])) {
                                    $base_sl = $slider_attr[$main_id];
                                    $in_sl = 'attrb_sl_'.$main_id; $bt_sl = 'bt_sl_'.$main_id; $cler_sl = 'cler_sl_'.$main_id;
                                    $es_sl = false;
                                    $act_sl = null;
                                    if($base_sl['del_href']) {
                                        $css_hide = null;
										$es_sl = true;
                                        $act_sl = ' actionis';
                                        if($null_position) {$strelka = $icon_hidi;}
                                    }
                                }
                            }
                            $text_title = $attribute['name']; ?>
                    <div class="block_param">
                        <div id="<?php echo $id_attrb; ?>" class="blok title_filter <?php echo $text_curs; ?>"><?php echo sprintf($shabl_title, $text_title, $strelka); ?></div>
                        <?php $es_next = false; $count_text = $attribute['count_param']; $css_scrl = ($scroll_item && !$css_bloc && ($count_text > $blok_item)) ? ' '.$css_scrl_text : null; ?>
                        <div class="onli_param blok <?php echo $css_bloc, $css_hide, $css_scrl, $dislay_fv; ?>">
                    <?php if($flag_select) { ?>
                        <select class="form-control"<?php echo (!$ajax_filter) ? ' onchange="location=this.value;"' : null ?>>
                            <option disabled="disabled" selected="selected" style="display:none;">- - -</option>
                            <?php $tec_main_id = null; $tec_param_id = null; 
                                foreach($attribute['param'] as $val) {
                                    $main_id = $val['main_id'];
                                    $name_text = $val['text'];
                                    $param_id = $val['param_id'];
                                    $total_all = null; if($flag_count[$view_get]) { $total_all = ' ('.$val['total'].')'; }
                                ?>
                            <?php if($val['total'] == 0) { ?>
                            <option disabled="disabled"><?php echo $name_text.$total_all; ?></option>
                            <?php } else {
                                    if($val['action']) {
                                        $total_all = null;
                                        $text_through = 'selected="selected"';
                                        $link_a = '';
                                        $tec_main_id = $main_id;
                                        $tec_param_id = $param_id;
                                    } else {
                                        $text_through = '';
                                        $link_a = $val['href'];
                                    }
                                    if($ajax_filter) { ?>
                            <option <?php echo $text_through; ?> value="<?php echo $link_a; ?>" nam_val="<?php echo $view_get; ?>[<?php echo $main_id; ?>]_<?php echo $param_id; ?>"><?php echo $name_text.$total_all; ?></option>
                                <?php } else { ?>
                            <option <?php echo $text_through; ?> value="<?php echo $link_a; ?>"><?php echo $name_text.$total_all; ?></option>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                        </select>
                        <?php if($ajax_filter) { ?>
                        <input type="hidden" name="<?php echo $view_get; ?>[<?php echo $tec_main_id; ?>]" value="<?php echo $tec_param_id; ?>" /><span class="selectz <?php echo ($del_href) ? 'actionis' : '' ?>"></span>
                        <?php } ?>
                        <?php if(!$ajax_filter && $del_href) { ?>
                        <div class="button_slider">
                            <span class="text_clears"><a class="clear_slider" href="<?php echo $del_href; ?>"><?php echo $legend_clears; ?></a></span>
                        </div>
                        <?php } ?>
                    <?php } elseif($flag_slider) { ?>
                        <div class="slider_attrib">
                            <?php if($input_slider_attrb) { ?>
                            <div class="input_blok">
                                <table class="width_100_pr input_slider">
                                    <tr>
                                        <td><input id="<?php echo $in_sl.'_from'; ?>" class="form-control text_input" type="text" value=""/></td>
                                        <td class="width_10pr"></td>
                                        <td><input id="<?php echo $in_sl.'_to'; ?>" class="form-control text_input" type="text" value=""/></td>
                                    </tr>
                                </table>
                            </div>
                            <?php } ?>
                            <div class="shkala<?php echo ($input_slider_attrb) ? '' : '1'; ?>">
                                <input class="attrb_sl" type="text" id="<?php echo $in_sl; ?>" value="" />
                                <input type="hidden" name="<?php echo $view_get; ?>[<?php echo $main_id; ?>]" value="<?php echo $base_sl['val_get']; ?>" /><span class="slidez<?php echo $act_sl; ?>"></span>
                            </div>
                            <div class="height_prim">
                                <table class="width_100_pr">
                                    <tr>
                                        <td id="<?php echo $cler_sl; ?>"><?php if($es_sl && $clear_sl) { ?><span class="text_clears"><a class="clear_slider" href="<?php echo $base_sl['del_href']; ?>"><?php echo $legend_clears; ?></a></span><?php } ?></td>
                                        <?php if(!$ajax_filter) { ?>
                                        <td><div class="button_slider">
                                        <span id="<?php echo $bt_sl; ?><?php echo $base_sl['bloc_slider']; ?>" class="botton_fv bot_filt <?php echo $cls_btn; ?> <?php echo $base_sl['bloc_slider']; ?>"><?php echo $legend_apply; ?></span>
                                        </div></td>
                                        <?php } ?>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <script>
                            $(document).ready(function() {
                                var $cler_sl = $('#<?php echo $cler_sl; ?>')
                                    <?php if(!$ajax_filter) { ?>
                                    ,$button_sld = $('#<?php echo $bt_sl; ?>')
                                    <?php } ?>
                                    ,legend_clears = '<?php echo $legend_clears; ?>'
                                    ,get_main_bloc = '<?php echo $view_get.'['.$main_id.']'; ?>'
                                    ,clear_slider = false
                                    ,$rangeSld = $("#<?php echo $in_sl; ?>")
                                    ,disable = <?php echo $base_sl['disable']; ?>
                                    ,separ = '<?php echo $base_sl['separ']; ?>'
                                    ,from = <?php echo $base_sl['from']; ?>
                                    ,to = <?php echo $base_sl['to']; ?>
                                    ,min = <?php echo $base_sl['min']; ?>
                                    ,max = <?php echo $base_sl['max']; ?>
                                    ,step = <?php echo $base_sl['step']; ?>
                                    ,grid = <?php echo $base_sl['grid']; ?>
                                    ,val_attrbs;
                                
                                $rangeSld.ionRangeSlider({
                                    type: 'double'
                                    ,hide_min_max: true
                        			,hide_from_to: <?php echo ($input_slider_attrb) ? 'true' : 'false'; ?>
                                    ,input_values_separator: separ
                                    ,keyboard: true
                                    ,force_edges: true
                                    ,disable: disable
                                    ,from: from
                                    ,to: to
                                    ,min: min
                                    ,max: max
                                    ,step: step
                                    ,extra_classes: 'sld_attr <?php echo $bt_sl; ?>'
                                    ,grid: grid
                                    ,grid_snap: true
                                    //,grid_margin: false
                                    //,grid_num: 5
                                    //,prefix: "$"
                                    //,postfix: ""
                                    //,values: ""
                                    //,prettify_enabled: false
                                    <?php if($ajax_filter) { ?>
                                    ,onFinish: function(data) {
                                        val_attrbs = getMinMax('<?php echo $in_sl; ?>', separ, true);
                                        getDataPoles($rangeSld, $cler_sl, val_attrbs, get_main_bloc, clear_slider);
                                    }
                                        <?php if($input_slider_attrb) { ?>
                                    ,onUpdate: function() {
                                        val_attrbs = getMinMax('<?php echo $in_sl; ?>', separ, true);
                                        getDataPoles($rangeSld, $cler_sl, val_attrbs, get_main_bloc, clear_slider);
                                    }
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if($input_slider_attrb) { ?>
                                    ,onChange: function (data) {
                                        from = data.from;
                                        to = data.to;
                                        updateValues();
                                    }
                                    <?php } ?>
                                });
                                <?php if($ajax_filter) { ?>
                                $cler_sl.on('click', 'a', function(e) {
                                    e.preventDefault();
                                    var slider = $rangeSld.data("ionRangeSlider");
                                    slider.reset();
                                    $cler_sl.empty();
                                    $rangeSld.next('input').attr('value', '').next('.slidez').removeClass('actionis');
                                    actionGet();
                                });
                                <?php } else { ?>
                                $button_sld.on('click', function() {
                                    var shabl = '<?php echo $shabl.$main_id ?>';
                                    val_attrbs = getMinMax('<?php echo $in_sl; ?>', separ, false);
                                    <?php if($base_sl['seo_url']) { ?>
                                    var shz = /\./g;
                                    val_attrbs = val_attrbs.replace(shz, '<?php echo $cent_delit; ?>');
                                    <?php } ?>
                                    var slidery_u = '<?php echo $base_sl['href']; ?>'.replace(shabl, val_attrbs);
                                    otpravUrl(corrUrl(slidery_u));
                                });
                                <?php } ?>
                                <?php if($input_slider_attrb) { ?>
                                var $from = $("#<?php echo $in_sl.'_from'; ?>")
                                    ,$to = $("#<?php echo $in_sl.'_to'; ?>");
                                $from.attr('value', from);$to.attr('value', to);
                                var updateValues = function () {
                                    if(isNaN(from)) {from = min;}
                                    if(isNaN(to)) {to = max;}
                                    $from.prop("value", from);
                                    $to.prop("value", to);
                                };
                                var updateRange = function () {
                                    $rangeSld.data("ionRangeSlider").update({from: from,to: to});
                                };
                                $from.on("change", function () {
                                    from = +$(this).prop("value");
                                    if (from < min) {from = min;}
                                    if (from > to) {from = to;}
                                    updateValues();
                                    updateRange();
                                });
                                $to.on("change", function () {
                                    to = +$(this).prop("value");
                                    if (to > max) {to = max;}
                                    if (to < from) { to = from;}
                                    updateValues();
                                    updateRange();
                                });
                                <?php } ?>
                            });
                        </script>
                <?php } else {  // end slider_attrib
                        $i=0;
                        foreach($attribute['param'] as $val) {
                            $main_id = $val['main_id'];
                            $name_text = $val['text'];
                            $param_id = $val['param_id'];
                            $rel_nf = ($null_position) ? $txt_nofollow : null;
                            $href_link1 = $href_link;
                            if($noindex_rel_nopp) {
                                $rel_nf =  $a_rel_nf;
                                if($val['blok_noindex']) {
                                    $rel_nf = null;
                                    $href_link1 = $link_html;
                                }
                            }
                            if($val['button']) { ?>
                        <div class="botton_opts">
                            <?php if($val['total'] == 0) { ?>
                            <label><span class="botton_fv <?php echo $cls_btn; ?> css_disabled"><?php echo $name_text; ?></span></label>
                            <?php } else {
                                    if($val['action']) {
                                        $actionis = 'actionis';
                                        $href = sprintf($href_link_del, $val['del_href']);
                                        $link_a = $rel_nf.' '.$href.' class="actionis"';
                                        $title = 'data-toggle="tooltip" title="'.$legend_remove_position.'"';
                                    } else {
                                        $actionis = '';
                                        $href = sprintf($href_link1, $val['href']);
                                        $link_a = $rel_nf.' '.$href;
                                        $title = '';
                                    } ?>
                            <label <?php echo $title; ?>><input type="hidden" name="<?php echo $view_get; ?>[<?php echo $main_id; ?>]" value="<?php echo $param_id; ?>" /><a <?php echo $link_a; ?>><span class="botton_fv <?php echo $cls_btn; ?> <?php echo $actionis; ?>"><?php echo $name_text; ?></span></a></label>
                            <?php } ?>
                        </div>
                    <?php } else {
                            $total_all = null; if($flag_count[$view_get]) { $total_all = sprintf($forms_total, $val['total_css'], $val['total']); }
                            $view_next = null;
                            if(!$css_hide) {
                                $view_next = ($i === $position_hide) ? $displ_unfoldi : null;
                                if($view_next) {
                                    $es_next = true;
                                }
                            }
                            if($view_next) { echo $view_next; ?>
                        <div class="skrit <?php echo $css_hide_text; ?>"><?php } ?>
                            <?php if($val['total'] == 0) { ?>
							<div class="text_through row_blok">
								<label><span class="checkb curs_def imt_a"><span class="text_param"><?php echo $name_text.$total_all; ?></span></span></label>
							</div>
                            <?php } else {
                                if($val['action']) {
                                    $text_through = 'actionis'; if($val['total'] == 0) {$text_through = $css_through;}
                                    $href = sprintf($href_link_del, $val['del_href']);
                                    $link_a = $rel_nf.' '.$href.' class="checka actionis"';
                                } else {
                                    $text_through = '';
                                    $href = sprintf($href_link1, $val['href']);
                                    $link_a = $rel_nf.' '.$href.' class="checkb"';
                                } ?>
                            <div class="<?php echo $text_through; ?> row_blok">
                                <label><input type="hidden" name="<?php echo $view_get; ?>[<?php echo $main_id; ?>]" value="<?php echo $param_id; ?>" /><a <?php echo $link_a; ?>><span class="text_param"><?php echo $name_text.$total_all; ?></span></a></label>
                            </div>
                        <?php } ?>
                        <?php if($es_next && ($i === ($count_text-1))) { ?>
                        </div><?php } ?>
                    <?php } ?>
                    <?php $i++; ?>  
                <?php }
                     } ?>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
            <?php if($fix_attrtool['fix_attrtool']) { ?>
            <script type="text/javascript"><!--
            $(document).ready(function () {
                $('.attrtool').qtip({
                    hide: { event: 'unfocus mouseleave', fixed: true, delay: 300 },
                	style: {
                        classes: '<?php echo $fix_attrtool['attrtool_style'] ?>',
                		tip: {
                            corner: true
                			}
                		},
                	show: {
                		solo: true
                		},
                	position: {
                        my: 'bottom left',
                        at: 'top center',
                		viewport: true,
                		adjust: {
                            x: 0, y: 0,
                			method: 'flip flip'
                		}
                    }
            	});
            });
            //--></script>
            <?php } ?>
            </div>
            <?php } // end attributes ?>           
        <?php } elseif($view_get == 'optv') { //options ?>
            <?php if(!empty($view_optv)) { ?>
            <div class="block_fv <?php echo $view_get; ?>">
                <?php if(!empty($legend_option)) { ?>
                    <div class="blok head_group"><?php echo $legend_option; ?></div>
                <?php } ?>
            <?php foreach($view_optv as $option) { if($count_not_dislay && ($option['count_param'] < $count_not_dislay)) continue; ?>
                <div class="block_param">
                    <?php
                        $main_id = $option['main_id'];
                        $position_hide = ($null_position = $option['null_position']) ? 0 : $position_set;
                        //position
                        $strelka = null;
                        $css_hide = null;
                        $text_curs = null;
                        $rel_nf = ($null_position) ? $txt_nofollow : null;
                        if($null_position) {
                            $text_curs = $css_curs_point;
                            $strelka = $icon_visi;
                            $css_hide = ' '.$css_hide_text;
                            //bloc_hide
                            if($option['action']) {
                                $css_hide = null;
                                $strelka = $icon_hidi;
                            }
                            //end bloc_hide
                            if(!$css_hide) {
                                $position_hide = $position_set;
                            }
                        }
                        $flag_image = $option['flag_image'];
                        $blok_img = ($flag_image) ? ' blok_img' : '';
                        $dislay_fv = ($flag_image || $view_button_opt) ? ' img_fv' : ' link_fv';
                        $text_title = $option['name'];
                    ?>
                    <div class="blok title_filter <?php echo $text_curs; ?>"><?php echo sprintf($shabl_title, $text_title, $strelka); ?></div>
                    <?php $es_next = false; $count_text = $option['count_param']; $css_scrl = ($scroll_item && ($count_text > $blok_item)) ? ' '.$css_scrl_text : null; ?>
                    <div class="onli_param blok<?php echo $css_hide, $css_scrl, $dislay_fv, $blok_img; ?>">
                    <?php $i = 0; 
                        foreach($option['param'] as $val) {
                            $param_id = $val['param_id'];
                            $name_text = $val['text'];
                            $href_link1 = $href_link;
                            if($noindex_rel_nopp) {
                                $rel_nf =  $a_rel_nf;
                                if($val['blok_noindex']) {
                                    $rel_nf = null;
                                    $href_link1 = $link_html;
                                }
                            }
                            if($flag_image) {
                                $src_img = $val['image']; $src_null = ($src_img) ? null : $cls_no_src; ?>
                        <div class="botton_opts <?php echo $src_null; ?>">
                            <?php if($val['total'] == 0) { ?>
                            <label><span class="curs_def"><img class="img_param_null" alt="<?php echo $name_text; ?>" src="<?php echo $src_img;?>"/></span></label>
                            <?php } else {
                                    if($val['action']) {
                                        $actionis = 'actionis';
                                        $href = sprintf($href_link_del, $val['del_href']);
                                        $link_a = $rel_nf.' '.$href.' class="actionis"';
                                        $title = 'data-toggle="tooltip" title="'.$legend_remove_position.'"';
                                    } else {
                                        $actionis = '';
                                        $href = sprintf($href_link1, $val['href']);
                                        $link_a = $rel_nf.' '.$href;
                                        $title = 'data-toggle="tooltip" title="'.$name_text.'"';
                                    } ?>
                            <label <?php echo $title; ?>><input type="hidden" name="<?php echo $view_get; ?>[<?php echo $main_id; ?>]" value="<?php echo $param_id; ?>" /><a <?php echo $link_a; ?>><img class="img_param <?php echo $actionis; ?>" alt="<?php echo $name_text; ?>" src="<?php echo $src_img;?>"/></a></label>
                            <?php } ?>
                        </div>
                    <?php } elseif($view_button_opt) { ?>
                        <div class="botton_opts">
                            <?php if($val['total'] == 0) { ?>
                            <label><span class="botton_fv <?php echo $cls_btn; ?> css_disabled"><?php echo $name_text; ?></span></label>
                            <?php } else {
                                    if($val['action']) {
                                        $actionis = 'actionis';
                                        $href = sprintf($href_link_del, $val['del_href']);
                                        $link_a = $rel_nf.' '.$href.' class="actionis"';
                                        $title = 'data-toggle="tooltip" title="'.$legend_remove_position.'"';
                                    } else {
                                        $actionis = '';
                                        $href = sprintf($href_link1, $val['href']);
                                        $link_a = $rel_nf.' '.$href;
                                        $title = '';
                                    } ?>
                            <label <?php echo $title; ?>><input type="hidden" name="<?php echo $view_get; ?>[<?php echo $main_id; ?>]" value="<?php echo $param_id; ?>" /><a <?php echo $link_a; ?>><span class="botton_fv <?php echo $cls_btn; ?> <?php echo $actionis; ?>"><?php echo $name_text; ?></span></a></label>
                            <?php } ?>
                        </div>
                    <?php } else {
                            $total_all = null; 
                            if($flag_count[$view_get]) {$total_all = sprintf($forms_total, $val['total_css'], $val['total']);}
                            $view_next = null;
                            if(!$css_hide) {
                                $view_next = ($i === $position_hide) ? $displ_unfoldi : null;
                                if($view_next) {
                                    $es_next = true;
                                }
                            }
                            if($view_next) { echo $view_next; ?>
                        <div class="skrit <?php echo $css_hide_text; ?>"><?php } ?>
                        <?php if($val['total'] == 0) { ?>
                        <div class="text_through row_blok">
                            <label><span class="checkb curs_def imt_a"><span class="text_param"><?php echo $name_text.$total_all; ?></span></span></label>
                        </div>
                        <?php } else {
                                if($val['action']) {
                                    $text_through = 'actionis'; if($val['total'] == 0) {$text_through = $css_through;}
                                    $href = sprintf($href_link_del, $val['del_href']);
                                    $link_a = $rel_nf.' '.$href.' class="checka actionis"';
                                } else {
                                    $text_through = '';
                                    $href = sprintf($href_link1, $val['href']);
                                    $link_a = $rel_nf.' '.$href.' class="checkb"';
                                } ?>
                        <div class="<?php echo $text_through; ?> row_blok">
                            <label><input type="hidden" name="<?php echo $view_get; ?>[<?php echo $main_id; ?>]" value="<?php echo $param_id; ?>" /><a <?php echo $link_a; ?>><span class="text_param"><?php echo $name_text.$total_all; ?></span></a></label>
                        </div>
                        <?php } ?>
                        <?php if($es_next && ($i === ($count_text-1))) { ?>
                        </div><?php } ?>
                    <?php } ?>  
                    <?php $i++; ?>
                <?php } ?>
                </div>
                </div>
            <?php } ?>
            </div>
            <?php } // end options ?>
        <?php } elseif($view_get == 'manufs') { // brands ?>
            <?php if(!empty($view_manufs)) { ?>
            <div class="block_fv <?php echo $view_get; ?>">
                <div class="block_param">
                    <?php 
                        $main_id = 1;
						$strelka = null;
                        $css_hide = null;
                        $text_curs = null;
						$position_hide = ($null_position_manufs) ? 0 : $position_set;
                        $rel_nf = ($null_position_manufs) ? $txt_nofollow : null;
                        if($null_position_manufs) {
                            $text_curs = $css_curs_point;
                            $strelka = $icon_visi;
                            $css_hide = ' '.$css_hide_text;
                            //bloc_hide
                            if($manuf_action) {
                                $css_hide = null;
                                $strelka = $icon_hidi;
                            }
                            //end bloc_hide
                            if(!$css_hide) {
                                $position_hide = $position_set;
                            }
                        }
                        if(!empty($legend_manuf)) { $text_title = $legend_manuf; ?>
                    <div class="blok title_filter <?php echo $text_curs; ?>"><?php echo sprintf($shabl_title, $text_title, $strelka); ?></div>
                    <?php }
                        $es_next = false; $count_text = $manuf_count_param; $css_scrl = ($scroll_item && ($count_text > $blok_item)) ? ' '.$css_scrl_text : null;
                        $dislay_fv = ' link_fv'; if($view_img_manufs) { $dislay_fv = ' img_fv blok_img';}
                        ?>
                    <div class="onli_param blok<?php echo $css_hide, $css_scrl, $dislay_fv; ?>">
                <?php $i = 0;
                    foreach($view_manufs as $val) {
                        $param_id = $val['param_id'];
                        $name_text = $val['text'];
                        $href_link1 = $href_link;
                        if($noindex_rel_nopp) {
                            $rel_nf =  $a_rel_nf;
                            if($val['blok_noindex']) {
                                $rel_nf = null;
                                $href_link1 = $link_html;
                            }
                        }
                        if($view_img_manufs) {
                            $src_img = $val['image']; $src_null = ($src_img) ? null : $cls_no_src; ?>
                        <div class="botton_opts <?php echo $src_null; ?>">
                            <?php if($val['total'] == 0) { ?>
                            <label><span class="curs_def"><img class="img_param_null" alt="<?php echo $name_text; ?>" src="<?php echo $src_img;?>"/></span></label>
                            <?php } else {
                                    if($val['action']) {
                                        $actionis = 'actionis';
                                        $href = sprintf($href_link_del, $val['del_href']);
                                        $link_a = $rel_nf.' '.$href.' class="actionis"';
                                        $title = 'data-toggle="tooltip" title="'.$legend_remove_position.'"';
                                    } else {
                                        $actionis = '';
                                        $href = sprintf($href_link1, $val['href']);
                                        $link_a = $rel_nf.' '.$href;
                                        $title = 'data-toggle="tooltip" title="'.$name_text.'"';
                                    } ?>
                            <label <?php echo $title; ?>><input type="hidden" name="<?php echo $view_get; ?>[<?php echo $main_id; ?>]" value="<?php echo $param_id; ?>" /><a <?php echo $link_a; ?>><img class="img_param <?php echo $actionis; ?>" alt="<?php echo $name_text; ?>" src="<?php echo $src_img;?>"/></a></label>
                            <?php } ?>
                        </div>
                    <?php } else {
                            $total_all = null; if($flag_count[$view_get]) { $total_all = sprintf($forms_total, $val['total_css'], $val['total']); }
                            $view_next = null;
                            if(!$css_hide) {
                                $view_next = ($i === $position_hide) ? $displ_unfoldi : null;
                                if($view_next) {
                                    $es_next = true;
                                }
                            }
                            if($view_next) { echo $view_next; ?>
                        <div class="skrit <?php echo $css_hide_text; ?>"><?php } ?>
                        <?php if($val['total'] == 0) { ?>
                        <div class="text_through row_blok">
                            <label><span class="checkb curs_def imt_a"><span class="text_param"><?php echo $name_text.$total_all; ?></span></span></label>
                        </div>
                        <?php } else {
                            if($val['action']) {
                                $text_through = 'actionis'; if($val['total'] == 0) {$text_through = $css_through;}
                                $href = sprintf($href_link_del, $val['del_href']);
                                $link_a = $rel_nf.' '.$href.' class="checka actionis"';
                            } else {
                                $text_through = '';
                                $href = sprintf($href_link1, $val['href']);
                                $link_a = $rel_nf.' '.$href.' class="checkb"';
                            } ?>
                        <div class="<?php echo $text_through; ?> row_blok">
                            <label><input type="hidden" name="<?php echo $view_get; ?>[<?php echo $main_id; ?>]" value="<?php echo $param_id; ?>" /><a <?php echo $link_a; ?>><span class="text_param"><?php echo $name_text.$total_all; ?></span></a></label>
                        </div>
                        <?php } ?>
                        <?php if($es_next && ($i === ($count_text-1))) { ?>
                        </div><?php } ?>
                    <?php } ?>
                        <?php $i++; ?>
                <?php } ?>
                    </div>
                </div>
            </div>
            <?php } ?>
        <?php } // end brands ?>
    <?php } // end foreach view_posit ?>
        </div><!-- / filter_vier -->
        <!-- div class="clears"></div -->
        <?php if($ajax_filter && !is_null($ajx_total_prod)) { ?>
        <div id="bloc_primenit"><div class="bloc_aj_all"><span class="aj_blc aj_bloc_txt"><?php echo $legend_aj_bloc_txt; ?></span><span class="aj_blc ajx_total_prod"><?php echo $ajx_total_prod; ?></span><span id="primenit_js"><span class="aj_blc aj_bloc_btn"><?php echo $legend_aj_bloc_btn; ?></span></span><span id="clear_vibor" class="aj_blc aj_blc_del"><i class="fa fa-trash-o"></i></span></div></div>
        <?php } ?>
<script>
    function corrUrl(url) {
        var shza = /&amp;/g;
        return url.replace(shza, '&');
    }
    function otpravUrl(url_adr) {
        location.assign(url_adr);
    }
    function yesMobil() {
        var oj = {};
        var f_v_w = $("#filter_vier").width();
        var of_left = $("#filter_vier").offset().left;
        var margin_2 = (of_left * 2);
        var of_f_v_w = (f_v_w + of_left);
        var all_width = $(document.body).width();
        //all_width = (all_width - margin_2);
        oj["f_v_w"] = f_v_w;
        oj["of_f_v_w"] = of_f_v_w;
        oj["all_width"] = (all_width - margin_2);
        oj["flag_mobil"] = false;
        if((f_v_w + f_v_w/2) > all_width) {
            oj["flag_mobil"] = true;
        }
        return oj;
    }
    function getMinMax(elem, separ, flag_seo) {
        var val_attrbs = $("#"+elem).val();
        var arr_atrb = val_attrbs.split(separ);
        if((arr_atrb[0] !== undefined) && (arr_atrb[1] !== undefined)) {
            if(arr_atrb[0] === arr_atrb[1]) {
                val_attrbs = arr_atrb[0];
            }
            else if(flag_seo) {
                val_attrbs = arr_atrb[0]+'-'+arr_atrb[1];
            }
        }
        return val_attrbs;
    }
    $('.displ').on('click', function() {
        var bloc_text = $(this).closest('.onli_param');
        var bloc_text_null = bloc_text.find('.skrit');
        var bloc_displ = bloc_text.find('.unfoldi');
        <?php if($animal_blok) { ?>
        bloc_text_null.slideToggle('<?php echo $animal_blok; ?>');
        <?php } else { ?>
        bloc_text_null.toggleClass('<?php echo $css_hide_text; ?>');
        <?php } ?>
        if(bloc_displ.text() == '<?php echo $legend_more; ?>') {
            bloc_displ.html('<?php echo $legend_hide.$unfoldi_vis; ?>');
        }
        else {
            bloc_displ.html('<?php echo $legend_more.$unfoldi_hid; ?>');
        }
    });
    $('.title_filter<?php echo '.'.$css_curs_point; ?>').on('click', function() {
        var bloc_text = $(this);
        <?php if($animal_blok) { ?>
        bloc_text.next('.onli_param').slideToggle('<?php echo $animal_blok; ?>');
        <?php } else { ?>
        bloc_text.next('.onli_param').toggleClass('<?php echo $css_hide_text; ?>');
        <?php } ?>
        bloc_text.find('.fa').toggleClass("<?php echo $icon_awesome['title_filter']['icon_visi']; ?> <?php echo $icon_awesome['title_filter']['icon_hidi']; ?>");
    });

    $(document).ready(function() {
        $('#name_filter').on('click', function() {
            var blok_fv = $('#filter_vier');
            <?php if($animal_blok) { ?>
            blok_fv.slideToggle('<?php echo $animal_blok; ?>');
            <?php } else { ?>
            blok_fv.toggle();
            <?php } ?>
            $('#name_filter .fa').toggleClass("<?php echo $icon_awesome['head_filter']['icon_visi']; ?> <?php echo $icon_awesome['head_filter']['icon_hidi']; ?>");
        });
        //scroll
        <?php if($scrollis) { ?>
        var n_ses = 'scrollis';
        var scrollis = sessionStorage.getItem(n_ses);
        if(scrollis) {
            window.scrollTo(0, scrollis);
            sessionStorage.removeItem(n_ses);
        }
        $('.block_fv a').click(sesScroll);
        $('.button_slider').click(sesScroll);
        $('#filter_vier select').click(sesScroll);
        <?php  if($ajax_filter) { ?>
        var oj = yesMobil();
        if(!oj.flag_mobil) {
            $('#primenit_js').click(sesScroll);
            $('#clear_vibor').click(sesScroll);
        }
        <?php }  ?>
        function sesScroll() {
            sessionStorage.setItem(n_ses, (window.scrollY) ? window.scrollY 
              : document.documentElement.scrollTop ? document.documentElement.scrollTop 
              : document.body.scrollTop
            );
        }
        <?php } ?>
        //end scroll
    });
</script>
<?php if($ajax_filter) { ?>
<script>
    <?php if($ajax_bloc_absolut) { ?>
    $(document).mouseup(function(e) {
        var bp = $("#bloc_primenit");
        var bpf = $("#filter_vier");
        if((bpf.has(e.target).length != 1) && (bp.has(e.target).length === 0)) {
            bp.hide();
            /**/
            /*
            setTimeout(function(){
                primenit_js();
            },5000);
            */
            /**/
        }
    });
    <?php } ?>
    var legend_clears = '<?php echo $legend_clears; ?>';
    var versi_put = '<?php echo $versi_put; ?>';

    function getDataPoles(rangeSld, cler_sl, temp_param, nam, flag_es_sl) {
        rangeSld.next('input').attr('value', temp_param).next('.slidez').addClass('actionis');
        if(flag_es_sl) {
            cler_sl.html('<span class="text_clears"><a class="clear_slider">'+legend_clears+'</a></span>');
        }
        onliParamGet(cler_sl, nam, true);
    }
    function blocFilter(flag) {
        var $abf = $('#ajx_bloc_filter');
        if(flag) {
            $abf.css({"z-index":"10","width":"100%","height":"100%","position":"absolute","background":"rgba(0, 0, 0, 0.1)"});
        }
        else {
            $abf.attr('style', '');
        }
    }
    function ajs_filter(param, dtype, file, coord_y, coord_x) {
        $.ajax({
            type: 'GET'
            ,url: 'index.php?route='+versi_put+file
            //,async: true
            ,dataType: dtype
            //,cache: false
            ,data: param
            ,beforeSend: function(){
                blocFilter(true);
            }
            ,success: function(data) {
                if(file == 'ajax_filter') {
                    if(data) {
                        var temp_action_get = $('#action_get').html();
                        var $bfv = $('#block_filter_vier');
                        $bfv.html(data);
                        $('#filter_vier').css({"display":"block"});
                        if(temp_action_get == undefined) {
                          $('#action_get').remove();
                        }
                        else {
                            $('#action_get').html(temp_action_get);
                        }
                        <?php if($ajax_bloc_absolut) { ?>
                        if(coord_y) {
                            $('#bloc_primenit').css({"display":"inline-block","position":"absolute"}).offset(coord_y);
                            if(coord_x) {
                                $('#bloc_primenit').css(coord_x);
                            }
                        }
                        <?php } ?>
                    }
                }
                else if(file == 'ajax_url') {
                    if(data.result) {
                        otpravUrl(corrUrl(data.result));
                    }
                }
            }
            ,complete: function(){
                blocFilter(false);
            }
        });
    }

    function getParamFilt(router, bloc, clear_filter) {
        var obj_param = {};
        if(clear_filter) {
            router = true;
        }
        else {
            $("#block_filter_vier .actionis").prev("input").each(function () {
                var nam = this.name;
                var v = this.value;
                if(bloc) {
                    if(nam == bloc) {
                        obj_param['-'+nam] = v;
                    }
                }
                if(nam in obj_param) {
                    obj_param[nam] = obj_param[nam] + '-' + v;
                }
                else {
                    obj_param[nam] = v;
                }
    	    });
        }
        if(router) {
            <?php foreach($get_route as $key => $val) { ?>
            obj_param['<?php echo $key; ?>'] = '<?php echo $val ?>';
            <?php } ?>
        }
        return obj_param;
    }
    $(".onli_param.img_fv").on('click', "a:not(.curs_def)", function(e) {
        e.preventDefault();
        var $param = $(this);
        $param.toggleClass("actionis");
        var nam = $param.prev().attr('name');
        onliParamGet($param, nam, false);
    });
    $(".onli_param.link_fv").on('click', "a:not(.curs_def):not(.clear_slider)", function(e) {
        e.preventDefault();
        var $param = $(this);
        $param.toggleClass("checka actionis").toggleClass("checkb");
        var nam = $param.prev().attr('name');
        onliParamGet($param, nam, false);
    });
    $(".onli_param.radio_fv").on('click', "a:not(.curs_def):not(.clear_slider)", function(e) {
        e.preventDefault();
        var $param = $(this);
        $param.closest(".onli_param").find("a.actionis").removeClass("checka actionis").addClass("checkb");
        $param.toggleClass("checka actionis").toggleClass("checkb");
        var nam = $param.prev().attr('name');
        onliParamGet($param, nam, false);
    });
    $(document).ready(function(){
        $(".select_fv select").change(function() {
            var $dat_sel = $(this)
            var get_value = $dat_sel.children(":selected").attr("nam_val");
            var arr_data = get_value.split('_');
            if(arr_data.length == 2) {
                var name = arr_data[0];
                var value = arr_data[1];
                $dat_sel.next('input').attr('name', name).attr('value', value).next('.selectz').addClass('actionis');
                var nam = $dat_sel.next('input').attr('name');
                onliParamGet($dat_sel, nam, false);
            }
        });
    })
    $("#primenit_js").on('click', function() {
        primenit_js();
    });
    function primenit_js() {
        var total_tovar = <?php echo ($ajx_total_prod) ? $ajx_total_prod : '0'; ?>;
        if(total_tovar) {
            var obj_param = {};
            obj_param = getParamFilt(true, '', false);
            ajs_filter(obj_param, 'json', 'ajax_url', '', '');
        }
    }        
    $('#clear_vibor').on('click', function() {
        actionGet();
    });
    function onliParamGet(elem, nam, flag_sl) {
        var of_top = elem.offset().top;
        //,"left":0
        var oj_top = {"top":of_top};
        var oj_l_r = positBottom(flag_sl);
        var param = getParamFilt(true, nam, false);
        ajs_filter(param, 'html', 'ajax_filter', oj_top, oj_l_r);
    }
    function actionGet() {
        var url_start = clearGet();
        if(url_start) {
            otpravUrl(url_start);
        }
        else {
            var param = getParamFilt(true, '', true);
            ajs_filter(param, 'html', 'ajax_filter', '', '');
        }
    }
    function positBottom(flag_sl) {
        var oj = yesMobil();
        var f_v_w = oj["f_v_w"];
        <?php if($ajax_corect_gorizont) { ?>
        f_v_w = f_v_w + <?php echo $ajax_corect_gorizont; ?>;
        <?php } ?>
        var of_f_v_w = oj["of_f_v_w"];
        var all_width = oj["all_width"];
        var flag_mobil = oj["flag_mobil"];
        var posit = "left";
        var correct = 12;
        var corr_mob = 3;
        var val_posit = (f_v_w+correct);
        var oj_l_r = {};
        if(flag_mobil) {
            posit = "left";
            val_posit = correct;
        }
        else if((of_f_v_w - all_width) > 1) {
            posit = "right";
        }
        if(flag_mobil) {
            if(flag_sl) {
                oj_l_r["margin-top"] = "-140px";
            }
            else {
                oj_l_r["margin-top"] = "-"+(val_posit*corr_mob)+"px";
            }
            oj_l_r["margin-left"] = (f_v_w / corr_mob);
        }
        else {
            oj_l_r[posit] = val_posit+"px";
        }
        return oj_l_r;
    }
    function clearGet() {
        var url_start = corrUrl('<?php echo $href_start; ?>');
        var url_real = window.location.href;
        if(url_real != url_start) {
            return url_start;
        }
        else {
            return false;
        }
    }
</script>
<?php } ?>
<?php echo $end_bloc; ?>
<?php } ?>