<?php

if (!function_exists('curl_init') or !function_exists('curl_exec') or !function_exists('curl_setopt'))
    die('PHP Curl Library not found');

static $temp_lfile;


function diff_day($start = '', $end = '')
{
    $dStart = new DateTime($start);
    $dEnd  = new DateTime($end);
    $dDiff = $dStart->diff($dEnd);
    return $dDiff->days;
}

function crypt_chip($action, $string, $salt = '')
{
    if ($salt != 'RjBZOXhxL3dOc3Fqc2k1SjE3RUgxdzdlR2ZCNjVESno1V0JBa1J4TStwaDV3ZTc0Q012NSsySVczbjMrUzhSaA==') return false;
    $key    = "0|.%J.MF4AMT$(.VU1J" . $salt . "O1SbFd$|N83JG" . str_replace("www.", "", $_SERVER["SERVER_NAME"]) . ".~&/-_f?fge&";
    $output = false;
    $encrypt_method = "AES-256-CBC";
    if ($key === null)
        $secret_key = "NULL";
    else
        $secret_key = $key;
    $secret_iv = 'dOc3Fqc2k1SjE3RU';
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ($action === 'encrypt') {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if ($action === 'decrypt')
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    return $output;
}

function get_license_file_data($reload = false)
{
    global $temp_lfile;
    if ($reload || !$temp_lfile) {
        if (!file_exists(__DIR__ . DIRECTORY_SEPARATOR . "LICENSE")) {
            return false;
        }
        $checkingFileData   = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "LICENSE");
        if ($checkingFileData) {
            $checkingFileData   = crypt_chip("decrypt", $checkingFileData, "RjBZOXhxL3dOc3Fqc2k1SjE3RUgxdzdlR2ZCNjVESno1V0JBa1J4TStwaDV3ZTc0Q012NSsySVczbjMrUzhSaA==");
            if ($checkingFileData) {
                $temp_lfile = json_decode($checkingFileData, true);
                return $temp_lfile;
            }
        }
    } else return $temp_lfile;
    return false;
}

function license_run_check($licenseData = [])
{
    if ($licenseData) {
        if (isset($licenseData["next-check-time"])) {
            $now_time   = date("Y-m-d H:i:s");
            $next_time  = date("Y-m-d H:i:s", strtotime($licenseData["next-check-time"]));
            $difference = diff_day($next_time, $now_time);
            if ($difference < 2) {
                $now_time   = strtotime(date("Y-m-d H:i:s"));
                $next_time  = strtotime($next_time);
                if ($next_time > $now_time) return false;
            }
        }
    }
    return true;
}

function use_license_curl($address, &$error_msg)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $address);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $result = @curl_exec($ch);
    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        return false;
    }
    curl_close($ch);
    return $result;
}

$license_data   = get_license_file_data();
$run_check      = license_run_check($license_data);

if ($run_check) {
    $domain     = str_replace("www.", "", $_SERVER["SERVER_NAME"]);
    $directory  = __DIR__;
    if (isset($_SERVER["HTTP_CLIENT_IP"])) {
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    } else {
        $ip = $_SERVER["REMOTE_ADDR"];
    }

    $server_ip  =  $_SERVER["SERVER_ADDR"];
    $entered    =  "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
    $referer    =  isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : '';
    $address    =  "https://glyc0on.com.tr/license/checking/f4c3208d5766ce6bdd2503267abdf8cb/68?";
    $address    .= "domain=" . $domain;
    $address    .= "&server_ip=" . $server_ip;
    $address    .= "&user_ip=" . $ip;
    $address    .= "&entered_url=" . $entered;
    $address    .= "&referer_url=" . $referer;
    $address    .= "&directory=" . $directory;
    $resultErr  = false;
    $result     = use_license_curl($address, $resultErr);
    if ($result == "OK") {
        // License check succeeded.

        $checkFileData      = crypt_chip("encrypt", json_encode([
            'last-check-time' => date("Y-m-d H:i:s"),
            'next-check-time' => date("Y-m-d H:i:s", strtotime("+3 day")),
        ]), "RjBZOXhxL3dOc3Fqc2k1SjE3RUgxdzdlR2ZCNjVESno1V0JBa1J4TStwaDV3ZTc0Q012NSsySVczbjMrUzhSaA==");
        file_put_contents(__DIR__ . DIRECTORY_SEPARATOR . "LICENSE", $checkFileData);
    } else {
        $err = use_license_curl("https://glyc0on.com.tr/license/error?user_ip=" . $ip, $resultErr);
        if ($err == '') {
            $err = 'LICENSE CURL CONNECTION ERROR';
        }
        die($err);
    }
}

function glycon_check($license_key, $glycon_server, $time)
{
    $stime = time();
    if (!isset($_COOKIE["glycon"]) || $stime - (int)$_COOKIE["glycon"] > $time) {
        unset($_COOKIE["glycon"]);
        setcookie("glycon", $stime);
    }
    if ($time == 0 || !isset($_COOKIE["glycon"]) || $_COOKIE["glycon"] - $stime == 0) {
        $glycon_ch = curl_init();
        curl_setopt($glycon_ch, CURLOPT_URL, $glycon_server . "check");
        curl_setopt($glycon_ch, CURLOPT_POST, 1);
        curl_setopt($glycon_ch, CURLOPT_POSTFIELDS, http_build_query([
            "license_key" => $license_key,
            "url" => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
            "server_ip" => $_SERVER['SERVER_ADDR'],
            "user_ip" => $_SERVER['REMOTE_ADDR']
        ]));
        curl_setopt($glycon_ch, CURLOPT_RETURNTRANSFER, true);
        $glycon_result = json_decode(curl_exec($glycon_ch));
        curl_close($glycon_ch);
        if (!$glycon_result->valid) {
            unset($_COOKIE["glycon"]);
            setcookie("glycon", 0);
            echo file_get_contents($glycon_server . "page/warning");
            exit;
        }
    }
}
