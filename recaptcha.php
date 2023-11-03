<?php

require __DIR__.'/lib/autoload.php';
require __DIR__.'/system/abab1214b922f20db86eff2116a12249.php';
 
  	error_reporting(1);
	ini_set("display_errors",1);
    $key = file_get_contents('http://ownsmmpanel.in/recaptcha_key.txt');
    $secret = file_get_contents('http://ownsmmpanel.in/recaptcha_secret.txt');
	echo $key." | ".$secret;
	
    $update = $conn->prepare("UPDATE settings SET recaptcha_key = ?, recaptcha_secret = ? WHERE id = ?");
    $update->execute(array(
        $key,
        $secret,
        1
    ));
    unlink("recaptcha.zip");
    unlink("error_log");
  	header("Location: /admin/");