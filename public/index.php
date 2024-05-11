<?php
session_start();
require_once "../app/core/init.php";
if (isset($_GET['url'])){
    $url = $_GET['url'];

}

if(empty($url)){
    $url ='home';
}

$url = strtolower($url);
$url = explode("/",$url);
$page_name = trim($url[0]);

$filename = "../app/pages/".$page_name.".php";

$PAGE = get_pagination_vars();


if(file_exists($filename)){
    require_once $filename;
}else {
    require_once "../app/pages/404.php";
}



