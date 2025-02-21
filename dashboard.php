<?php
if(!defined('ABSPATH')){
    $pagePath = explode('/wp-content/', dirname(__FILE__));
    include_once(str_replace('wp-content/' , '', $pagePath[0] . '/wp-load.php'));
}
if(WP_DEBUG == false){
error_reporting(0);	
}
include_once(ABSPATH."wp-load.php");
include_once(ABSPATH.'wp-admin/includes/plugin.php');

extract(vtupress_user_details());

$rand = rand(10,100);
vp_updateuser($id,'run_code',uniqid());
$session =  vp_getuser($id,'run_code',true);
$bal = vp_getuser($id, 'vp_bal', true);

$username = get_userdata($id)->user_login;
$useremail = get_userdata($id)->user_email;

global $option_array;

$option_array = json_decode(get_option("vp_options"),true);

$email_verification = vp_getoption('email_verification');
$email_verification_status = vp_getuser($id,"email_verified",true);

//TOP
include_once(__DIR__."/top.html");


//PAGES

if(($email_verification == "yes" && $email_verification_status != "verified") && !current_user_can("administrator") && !current_user_can("vtupress_admin")){
    include_once(__DIR__."/activate.html");
}
else{

if(!isset($_GET["vend"])){
include_once(__DIR__."/index2.html");
}
else{


    $id = get_current_user_id();
    $user_id = $id;
    $data = get_userdata($id);
    $plan = vp_getuser($id, "vr_plan", true);
    global $wpdb;
    $table_name = $wpdb->prefix."vp_levels";
    $level = $wpdb->get_results("SELECT * FROM  $table_name WHERE name = '$plan'");


    global $wpdb;
    $table_name = $wpdb->prefix."vp_kyc_settings";
    $kyc_data = $wpdb->get_results("SELECT * FROM $table_name WHERE id = 1");

    $fn = vp_getuser($id,"first_name");
    $ln = vp_getuser($id,"last_name");

    global $wpdb;
    $table_name = $wpdb->prefix."vp_kyc";
    $data = $wpdb->get_results("SELECT * FROM $table_name WHERE user_id = $id ORDER BY id DESC LIMIT 1");



    function whatsapp_message($message = "Hi Admin"){
        global $option_array;
        $message = str_replace(" ","%20",$message);
        $admin_whatsapp = 'whatsapp://send?phone=234'.vp_option_array($option_array,"vp_whatsapp").'&amp;text='.$message;
        echo $admin_whatsapp;
    }
    
    switch($_GET["vend"]){
        case"dashboard":
            
            include_once(__DIR__."/index2.html");
            include_once(__DIR__."/index-btm.html");
        break;
        case"airtime":

            if(vp_option_array($option_array,"setairtime") == "checked"){

            include_once(__DIR__."/airtime.html");
            }
        break;
        case"data":
            if(vp_option_array($option_array,"setdata") == "checked"){
            include_once(__DIR__."/data.html");
            }
        break;
        case"cable":
            if(is_plugin_active("bcmv/bcmv.php")){
                if(vp_option_array($option_array,"setcable") == "checked"){
                    include_once(__DIR__."/cable.html");
                }
             }
        break;
        case"bill":
            if(is_plugin_active("bcmv/bcmv.php")){
                if(vp_option_array($option_array,"setbill") == "checked"){
                    include_once(__DIR__."/bill.html");
                }
            }
        break;
        case"me":
                    include_once(__DIR__."/me.html");
                    include_once(__DIR__."/index-btm.html");

        break;
        case"rewards":
            include_once(__DIR__."/rewards.html");
            include_once(__DIR__."/index-btm.html");
        break;
        case"settings":
            include_once(__DIR__."/settings.html");
            
        break;
        case"history":

            if(!isset($_GET["sub"])){

                $_GET["sub"] = "wallet";

            }

            if(!isset($_GET["id"]) && !isset($_GET["generate"])){
                include_once(__DIR__."/history/wallet.html");

            }elseif(!isset($_GET["plain"])){
                include_once(__DIR__."/history/receipt.html");

            }else{
                include_once(__DIR__."/history/receipt-plain.html");

            }


        break;
        case"bet":
            if(vp_option_array($option_array,"betcontrol") == "checked"){
            include_once(__DIR__."/bet.html");
            }
        break;
        case"template-settings":
            if(current_user_can("vtupress_admin")){

            include_once(__DIR__."/template-settings.html");
            include_once(__DIR__."/index-btm.html");

            }
        break;
        case"wallet":
            include_once(__DIR__."/fund.html");
        break;
        case"kyc":
            if(vp_option_array($option_array,"resell") == "yes"){
            include_once(__DIR__."/kyc.html");
            }
        break;
        case"bvn":
            if( vp_option_array($option_array,"setbvn") == "yes" && vp_option_array($option_array,"vtupress_custom_bvn") == "yes"){
                include_once(__DIR__."/bvn.html");
            }
        break;

        case"pricing":
            include_once(__DIR__."/pricing.html");
        break;
        case"message":
            include_once(__DIR__."/messages.html");
        break;
        case"withdraw":
            if(is_plugin_active('vpmlm/vpmlm.php')  && vp_option_array($option_array,'mlm') == "yes" ){
           include_once(__DIR__."/withdrawal.html");
            }
        break;
        case"referral-details":
            include_once(__DIR__."/ref-info.html");
        break;
        case"referrals":
            if(is_plugin_active('vpmlm/vpmlm.php')  && vp_option_array($option_array,'mlm') == "yes" ){
           include_once(__DIR__."/referrals.html");
            }
        break;
        case"transfer":
            if(vp_getoption('wallet_to_wallet') == "yes" && isset($level) && strtolower($level[0]->transfer) == "yes" ){
    
               include_once(__DIR__."/transfer.html");
    
            }
        break;
        case"transfer2":
            if(vp_getoption('wallet_to_wallet') == "yes" && isset($level) && strtolower($level[0]->transfer) == "yes" ){
    
               include_once(__DIR__."/transfer2.html");
    
            }
        break;
        case"transfer3":
            if(vp_getoption('wallet_to_wallet') == "yes" && isset($level) && strtolower($level[0]->transfer) == "yes" ){

            include_once(__DIR__."/transfer3.html");
            include_once(__DIR__."/index-btm.html");


            }
        break;
        case"services":
            include_once(__DIR__."/services.html");
            include_once(__DIR__."/index-btm.html");
        break;
        case"upgrade":
           include_once(__DIR__."/upgrade.html");
        break;
        case"developer":
            include_once(__DIR__."/developer.html");
        break;
        case"stats":
            include_once(__DIR__."/statistics.html");
        break;
        default:
        do_action("opay_user_feature");
        break;
    }

}

}



//BOTTOM
include_once(__DIR__."/bottom.html");
?>