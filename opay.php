<?php
/**
 * VtuPress
 * 
 * @package Opay Template
 * @author Akor Victor
 * @copyright 2020 vtupress
 * @license GPL-3.0-or-later
 *
*Plugin Name: Opay Template
*Plugin URI: http://vtupress.com
*Description: This add Opay template into your vtu website
*Version: 1.1.2
*Author: Akor Victor
*Author URI: https://facebook.com/vtupressceo
Requires PHP: 7.4
License:      GPL3
License URI:  https://www.gnu.org/licenses/gpl.html
Domain Path:  /languages
*/
/*
{Plugin Name} is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
any later version.
 
{Plugin Name} is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with {Plugin Name}. If not, see {URI to Plugin License}.
*/
if(!defined('ABSPATH')){
    $pagePath = explode('/wp-content/', dirname(__FILE__));
    include_once(str_replace('wp-content/' , '', $pagePath[0] . '/wp-load.php'));
}
if(WP_DEBUG == false){
error_reporting(0);	
}

include_once(ABSPATH ."wp-load.php");
include_once(ABSPATH .'wp-admin/includes/plugin.php');
require_once(ABSPATH.'wp-admin/includes/upgrade.php');



require __DIR__.'/plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://github.com/bikendi-tech-solutions/opay',
	__FILE__,
	'opay'
);
//Set the branch that contains the stable release.
$myUpdateChecker->setBranch('main');

$myUpdateChecker->getVcsApi()->enableReleaseAssets();



add_action("init","opay_tmp");
function opay_tmp(){
if(is_plugin_active("vtupress/vtupress.php")){
    include_once(ABSPATH .'wp-content/plugins/vtupress/functions.php');
    
    
//ADD THIS TEMPLATE TO VTUPRESS TEMPLATE LISTs
add_action("list_vtupress_templates","add_opay_template");

function add_opay_template(){

    if(vp_getoption("vtupress_custom_opay") == "yes"){
        echo"
            <option value='opay'>Opay Template</option>
        ";
    }

}

}
}