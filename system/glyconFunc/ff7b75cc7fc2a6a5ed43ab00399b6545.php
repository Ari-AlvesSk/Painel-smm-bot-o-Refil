<?php

function controller($controllerName){
  $controllerName = strtolower($controllerName);
  return PATH.'/controller/panel/'.$controllerName.'.php';
}

function view($viewName){
  $viewName = strtolower($viewName);
  return PATH.'/themes/panel/'.$viewName;
}

function route($index){
  global $route;
  if( isset($route[$index]) ){
    return $route[$index];
  }else{
    return false;
  }
}

function site_url($url = false){
  return URL.'/'.$url;
}

function GetIP(){
  if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
  $ip = getenv("HTTP_CLIENT_IP");
  else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
  $ip = getenv("HTTP_X_FORWARDED_FOR");
  else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
  $ip = getenv("REMOTE_ADDR");
  else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
  $ip = $_SERVER['REMOTE_ADDR'];
  else
  $ip = "unknown";
  return($ip);
}


function themeExtras($which){
  global $conn;
  $theme =  $conn->prepare("SELECT * FROM themes WHERE theme_dirname=:dir ");
  $theme-> execute(array('dir'=>THEME));
  $theme =  $theme->fetch(PDO::FETCH_ASSOC);

  return json_decode($theme["theme_extras"],true);

}

$stylesheet = themeExtras('stylesheets');