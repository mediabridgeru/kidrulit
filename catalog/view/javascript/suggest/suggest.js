/**
 * Created by lyc on 05.07.15.
 */

var flag_geo = [];

(function ($) {
    //"use strict";
    function nvl(val) {
        return val || '';
    }

    function formatSuggestionValues(suggestion, $field) {

        var address = suggestion.data;
        var $where = $(this).parents(".simplecheckout-block");
//console.log(address);
        if (!$where.length) {
            $where = $(document);
        }
        var $el = $where.find($field.group_id + " input[name*='" + $field.name + "']");

        var field_array = [];
        $.each($field.parts_suggest, function (i, part) {
            switch (part) {
                case 'postcode':
                    if (address.postal_code) {
                        field_array.push(address.postal_code);
                    }
                    break;
                
                case 'region':
                    var region = [];
                    if (address.region && address.region.length > 0) {
                        region.push(address.region);
                        if ($field.type == 'input')
                            if (address.region_type && address.region_type.length > 0) {
                                region.push(address.region_type);
                            }
                    }
                    if (region) {
                        field_array.push(region.join(' '));
                    }
                    break;
                /*
                case 'area':
                    if (address.area_with_type && address.area_with_type.length > 0)
                        field_array.push(address.area_with_type);
                    break;
                */
                case 'city':
                    if (address.city && address.city.length > 0) {
                        field_array.push(address.city);
                    }
                    break;
                case 'settlement':
                    if (address.settlement_with_type && address.settlement_with_type.length > 0)
                        field_array.push(address.settlement_with_type);
                    break;
                case 'street':
                    if (address.street_with_type && address.street_with_type.length > 0)
                        field_array.push(address.street_with_type);
                    break;
                case 'house':
                    var house = [];
                    if (address.house && address.house.length > 0) {
                        if (address.house_type && address.house_type.length > 0)
                            house.push(address.house_type);
                        house.push(address.house);
                        if (address.block_type && address.block_type.length > 0)
                            house.push(address.block_type);
                        if (address.block && address.block.length > 0)
                            house.push(address.block);
                        if (address.flat_type && address.flat_type.length > 0) {
                            house.push(address.flat_type);
                            if (address.flat && address.flat.length > 0) {
                                house.push(address.flat);
                            }
                        }
                    }
                    if (house) {
                        field_array.push(house.join(' '));
                    }
                    break;
            }

        });
        var field_val = field_array.join(', ');
        var val = nvl(field_val);
        if ($field.type == 'input') {
            if (val == '' && $field.name == 'address_1') {
                val = $el.val();
            } else {
                $el.val(val);
            }
        } else {
            FullAddressSuggestions.selectField(val, $where.find("select[name*='" + $field.name + "']"));
        }
        suggestion.value = val;
        return suggestion;
    }


    var FullNameSuggestions = {


        init: function ($options) {
            var self = this;

            $.each($options.fields, function (index, $field) {
                var $el = $($field.group_id + " input[name*='" + $field.name + "']");
                $el.suggestions({
                    serviceUrl: "index.php?route=module/suggest/request&r=",
                    type: "NAME",
                    deferRequestBy: 200,
                    hint: "",
                    count: $options.tips,
                    params: {
                        // каждому полю --- соответствующая подсказка
                        parts: $field.parts
                    },

                    onSearchStart: function (params) {
                        // если пол известен на основании других полей,
                        // используем его
                        params.gender = self.isGenderKnown() ? self.gender : "UNKNOWN";
                    },

                    onSelect: function (suggestion) {
                        // определяем пол по выбранной подсказке
                        self.gender = suggestion.data.gender;
                    }
                });

            });
        },

        isGenderKnown: function () {
            return this.gender != undefined;
        }
    };

    var EmailSuggestions = {

        init: function ($options) {
            $.each($options.fields, function (index, $field) {
                var $el = $($field.group_id + " input[name*='" + $field.name + "']");
                $el.suggestions({
                    serviceUrl: "index.php?route=module/suggest/request&r=",
                    type: "EMAIL",
                    deferRequestBy: 200,
                    hint: "",
                    count: $options.tips
                });
            });
        }
    };

    var FullAddressSuggestions = {

        init: function ($options) {
            FullAddressSuggestions.$address = $options.address;
            FullAddressSuggestions.options = FullAddressSuggestions.options || [];
            FullAddressSuggestions.options[$options.group_key] = $options;
            if ($options.fields.length > 0) {

                $.each($options.fields, function (index, $field) {
                    var $el = $($field.group_id + " input[name*='" + $field.name + "']");

                    if ($el.length > 0) {
                        FullAddressSuggestions.initSuggestions($el, $options, $field);

                        if (flag_geo[$field.group_key] == (0 || undefined)) {

                            if ($el.suggestions() != undefined && $.inArray("city" || "settlement" || "postcode", $field.parts_suggest) != -1) {
                                var geoLocation = $el.suggestions().getGeoLocation();
                                if (geoLocation != undefined) {
                                    geoLocation.done(
                                        function (locationData) {
                                            FullAddressSuggestions.suggestionComplete({
                                                data: locationData,
                                                options: $options
                                            });
                                            flag_geo[$field.group_key] = "1";
                                        });
                                }
                            }
                        }
                    }
                });
            }
        },
        suggestionComplete: function (suggestion) {
            var self = FullAddressSuggestions;
            //var options_additional = self.options.fields_additional;
            if (!suggestion.data) {
                return;
            }
            var group_key = suggestion.options.group_key;
            $.each(suggestion.options.fields, function (index, $field) {
                formatSuggestionValues(suggestion, $field);

            });
        },
        initSuggestions: function ($el, $options, $field) {
            FullAddressSuggestions.options = FullAddressSuggestions.options || [];
            FullAddressSuggestions.options[$options.group_key] = [];
            FullAddressSuggestions.options[$options.group_key] = $options;
            var $suggest = $el.suggestions({
                serviceUrl: "index.php?route=module/suggest/request&r=",
                type: "ADDRESS",
                deferRequestBy: 200,
                triggerSelectOnSpace: false,
                count: $options.tips,
                geoLocation: ($options.geoLocation && (flag_geo[$field.group_key] == undefined || 0)),
                bounds: $field.parts_suggest.join('-'),
                constraints: ($field.constraint.length > 0 ? $($field.group_id + " input[name*='" + $field.constraint + "']") : false),
                onSearchStart: function (params) {
                    return params;
                },
                onSelect: function (suggest, changed) {
                    var $lastfield = FullAddressSuggestions.options[$options.group_key].fields[FullAddressSuggestions.options[$options.group_key].last_active_key];

                    $.each(FullAddressSuggestions.options[$options.group_key].fields, function (index, $fieldd) {

                        formatSuggestionValues(suggest, $fieldd);
                    });
                    suggest.data.city_type = '';
                    if ($lastfield && changed == true) {
                        var from = jQuery($($field.group_id + " input[name*='" + $lastfield.name + "']")).attr('reload');
                        if (from != undefined && from.indexOf('checkout_') == 0) {
                            var event = $options.event || window.event;

                            if (event != undefined && event.type != 'readystatechange') {

                                if (typeof simplecheckout_reload !== 'undefined' && $.isFunction(simplecheckout_reload)) {
                                    if (window.needToReload == true) {
                                        window.needToReload = false;
                                        simplecheckout_reload(from);
                                    } else {
                                        window.needToReload = true;
                                    }
                                }
                            }
                        }

                    }

                    var result = formatSuggestionValues(suggest, $field);

                    return result;
                },

                formatSelected: function (suggest) {
                    var result = formatSuggestionValues(suggest, $field);

                    return result;
                }
            });

        },


        selectField: function (address_field, $el) {

            $el.children("option").each(function () {
                if (this.text.indexOf(address_field) !== -1) {
                    $(this).attr("selected", "selected");
                }
            });
            return true;
        }

    };

    window.FullNameSuggestions = FullNameSuggestions;
    window.EmailSuggestions = EmailSuggestions;
    window.FullAddressSuggestions = FullAddressSuggestions;

})
(jQuery);