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
header("Content-type: text/css");
global $option_array;

$option_array = json_decode(get_option("vp_options"),true);
// Define your variables
/*
$majorp = "#00b875";
$minorp = "#e1f5ea";
$majors = "#818181";
$minors = "#f8f8fa";*/

$majorp = vp_option_array($option_array,"opay_major_primary");

if(empty($majorp) || $majorp == "false" || $majorp == "0"){
    $majorp = "#00b875";
    $minorp = "#e1f5ea";
    $majors = "#818181";
    $minors = "#f8f8fa";
}else{

    $majorp = vp_option_array($option_array,"opay_major_primary");
    $minorp = vp_option_array($option_array,"opay_minor_primary");
    $majors = vp_option_array($option_array,"opay_major_secondary");
    $minors = vp_option_array($option_array,"opay_minor_secondary");

}


// Output CSS with variables
?>

:root {
    --major-primary-color: <?php echo $majorp;?>;     /*Thick green*/
    --minor-primary-color: <?php echo $minorp;?>;     /*Light green*/
    --major-secondary-color: <?php echo $majors;?>;     /*Darker Black*/
    --minor-secondary-color: <?php echo $minors;?>;  /*Light black like white FAINTED*/
    --border-color: #a7a5a5;
    
}

/* REMOVED
#05b476
--popover-major-color: #000000;
*/