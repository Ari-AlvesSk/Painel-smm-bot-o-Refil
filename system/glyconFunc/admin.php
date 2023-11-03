<?php

function admin_controller($controllerName){
  $controllerName = strtolower($controllerName);
  return PATH.'/controller/admin/'.$controllerName.'.php';
}

function admin_view($viewName){
  $viewName = strtolower($viewName);
  return PATH.'/themes/admin/'.$viewName.'.php';
}

function servicePackageType($type){
  switch ($type) {
    case '1':
      return "Default";
      break;
    case '2':
      return "Package";
      break;
    case '3':
      return "Special comments";
      break;
    case '4':
      return "Package comments";
      break;
    default:
      return "Subscriptions";
      break;
  }
}