<?php
    
    define('PATH', realpath('.'));
    define('SUBFOLDER', false);
    define('URL', 'https://seudominioaqui');
    define('DINAMICLISANCE', 'Tara-baap-proffesor');
    
    ini_set('display_errors', 1);
    date_default_timezone_set('America/Sao_Paulo');
    
    return [
      'db' => [
        'name'    =>  'seudatabaseaqui',
        'host'    =>  'localhost',
        'user'    =>  'seudatabaseaqui',
        'pass'    =>  'senhadodatabase',
        'charset' =>  'utf8mb4' 
      ]
    ];
    