<?
$root = '';
$path = 'expedientes/';

function getImagesFromDir($path) {
    $images = array();
    if ( $img_dir = @opendir($path) ) {
        while ( false !== ($img_file = readdir($img_dir)) ) {
            // checks for gif, jpg, png
            if ( preg_match("/(\.gif|\.jpg|\.png)$/", $img_file) ) {
                $images[] = $img_file;
            }
        }
        closedir($img_dir);
    }
    if (count($images)==0) {
        echo "<script src='js/fireworks.js' type='text/javascript'></script>";
        $images[] = "../Gracias!!!!!!.gif";
        
    }

    return $images;
}

function getRandomFromArray($ar) {
   // mt_srand( (double)microtime() * 1000000 ); // php 4.2+ not needed
    $num = array_rand($ar);
    return $ar[$num];
}

?>