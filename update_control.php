<?php

require __DIR__.'/lib/autoload.php';
require __DIR__.'/system/abab1214b922f20db86eff2116a12249.php';

    $version =  file_get_contents("https://update.glycon.org/update.php?last_version=1");

    if(isset($version)):
              $dosya = fopen('system/include/updateSettings.php', 'w');
            fwrite($dosya, '<?php
$updateDetails = array(
    "current"    =>  "GLYCON-SMM-V1.9",
    "last"       =>  "'.$version.'"
);');
            fclose($dosya);
    endif;