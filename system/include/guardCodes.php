<?php

function blockIP($value){
  $dosya = fopen (".htaccess" , 'a');
  fwrite ( $dosya , "deny from $value
" ) ;
  fclose ($dosya);
}

$gelme = array ('clients','service_api','providers', 'users', 'child_panels','pwd', 'hex', 'union', 'select', 'insert', 'update', 'drop table', 'union', 'null');
if(isset($_GET)):
    for ($i = 0; $i < sizeof ($_GET); ++$i){
        for ($j = 0; $j < sizeof ($gelme); ++$j){
            if (preg_match ('/' . strtolower($gelme[$j]) . '/', strtolower($_GET[key ($_GET)]))){
                $temp = key ($_GET);
                $_GET[$temp] = '';
                blockIP($_SERVER['REMOTE_ADDR']);
                die(header('HTTP/1.0 403 Forbidden'));
                continue;
            }
        }
    }
endif;