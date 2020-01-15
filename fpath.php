<?php 
$find="exit";

echo findString('/home/kidrulit/public_html' ,$find);

function findString($path,$find){
    $return='';
    ob_start();
    if ($handle = opendir($path)) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != "..") {
                if(is_dir($path.'/'.$file)){
                    $sub=findString($path.'/'.$file,$find);
                    if(isset($sub)){
                        echo $sub.PHP_EOL;
                    }
                }else{
                    $ext=substr(strtolower($file),-3);
                    if($ext=='php'){
                        $filesource=file_get_contents($path.'/'.$file);
                        $pos = strpos($filesource, $find);
                        if ($pos === false) {
                            continue;
                        } else {
                            echo "The string '$find' was found in the file '$path/$file and exists at position $pos<br />";
                        }
                    }else{
                        continue;
                    }
                }
            }
        }
        closedir($handle);
    }
    $return = ob_get_contents();
    ob_end_clean();
    return $return;
}
?>