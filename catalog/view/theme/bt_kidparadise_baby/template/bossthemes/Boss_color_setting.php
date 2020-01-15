<?php
$b_Color_Data = $this->config->get('b_Color_Data');
$objXML = simplexml_load_file("config_xml/color_setting.xml");
?>
<style type="text/css">
    /************* Header Setting Colors ****************/
    <?php
    foreach ($objXML->children() as $child) {
        foreach($child->children() as $childOFchild){
            foreach($childOFchild->children() as $childOF){
                if($childOF->name){
                    $name = ''.$childOF->name.'';
                    $class = ''.$childOF->class.'';
                    $style = ''.$childOF->style.'';

                    $pieces = explode("_", $name);
                    $pre = $pieces[0];

                    $pre_bg_image = $pre.'_bg_image';
                    $pre_bg_image_position = $pre.'_bg_image_position';
                    $pre_upload_bg_image = $pre.'_upload_bg_image';

                    echo $class.'{';

                    if($childOFchild->getName()=='background') {

                        if(isset($b_Color_Data[$name]) && $b_Color_Data[$name]){
                            echo $style.': #'.$b_Color_Data[$name].';';
                        }

                        if(isset($b_Color_Data[$pre_bg_image]) && $b_Color_Data[$pre_bg_image]==$pre_upload_bg_image) {
                            echo 'background-image: url("image/'.$b_Color_Data[$pre_upload_bg_image].'");';
                        } else {
                            if(isset($b_Color_Data[$pre_bg_image]) && $b_Color_Data[$pre_bg_image]=='default') {} else {
                                if(isset($b_Color_Data[$pre_bg_image])) {
                                    echo 'background-image: url("image/data/background/'.$b_Color_Data[$pre_bg_image].'");';
                                }
                            }
                        }

                        if (isset($b_Color_Data[$pre_bg_image_position])) {
                            echo 'background-position: '.$b_Color_Data[$pre_bg_image_position].';';
                        }
                        if (isset($b_Color_Data[$pre_bg_image_position])) {
                            echo 'background-repeat: '.$b_Color_Data[$pre_bg_image_position].';';
                        }

                    } else {
                        if(isset($b_Color_Data[$name]) && $b_Color_Data[$name]){
                            echo $style.': #'.$b_Color_Data[$name].';';
                        }
                    }

                    echo "}\n";
                }
            }
        }
    } ?>
</style>