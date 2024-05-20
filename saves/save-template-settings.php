<?php
if(!defined('ABSPATH')){
    $pagePath = explode('/wp-content/', dirname(__FILE__));
    include_once(str_replace('wp-content/' , '', $pagePath[0] . '/wp-load.php'));
}
if(WP_DEBUG == false){
error_reporting(0);	
}
include_once(ABSPATH."wp-load.php");
include_once(ABSPATH .'wp-content/plugins/vtupress/functions.php');
include_once(ABSPATH .'wp-content/plugins/vtupress/foradmin.php');

global $option_array;

$option_array = json_decode(get_option("vp_options"),true);

if(isset($_POST)){

    foreach($_POST as $this_template_settings => $value){
        if(preg_match("/opay_/",$this_template_settings)){
            vp_updateoption($this_template_settings,$value);
        }
    }

    die("100");
}
