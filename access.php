<?php
//error_reporting(0);
if(!defined('ABSPATH')){
    $pagePath = explode('/wp-content/', dirname(__FILE__));
    include_once(str_replace('wp-content/' , '', $pagePath[0] . '/wp-load.php'));
}
include_once(ABSPATH."wp-load.php");
include_once(ABSPATH .'wp-content/plugins/vtupress/functions.php');
//error_reporting(0);
$site_name = get_option("blogname");
include_once(__DIR__."/top.html");


if(!isset($_GET)){
    include_once(ABSPATH."wp-content/plugins/opay/login.html");
}
elseif(isset($_GET["reset_password"])){
    include_once(ABSPATH."wp-content/plugins/opay/forgot-password.html");
}
elseif(isset($_GET["activate"])){
    include_once(ABSPATH."wp-content/plugins/opay/activate.php");
}
elseif(isset($_GET["register"]) || isset($_GET["ref"])){
include_once(ABSPATH."wp-content/plugins/opay/register.html");
}
else{
    include_once(ABSPATH."wp-content/plugins/opay/login.html");
}

include_once(__DIR__."/bottom.html");

?>