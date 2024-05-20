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
include_once(__DIR__."/index.html");
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
            
            include_once(__DIR__."/index.html");
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
                echo "<div class='container'>";
                include_once(__DIR__."/bvn.php");
                echo "</div>";
            }
        break;

        case"pricing":
            echo "<div class='container p-2'>";
            echo "<div class='mt-3 mx-2 p-2'>";
            include_once(__DIR__."/sections/pricing.php");
            echo "</div>";
            echo "</div>";
        break;
        case"message":
            if(vp_option_array($option_array,"resell") == "yes"){
            echo "<div class='container p-2'>";
            echo "<div class='mt-3 mx-2 p-2'>";
            include_once(__DIR__."/sections/messages.php");
            echo "</div>";
            echo "</div>";
            }
        break;
        case"withdraw":
            if(vp_option_array($option_array,"resell") == "yejs"){
            echo "<div class='container p-2'>";
            echo "<div class='mt-3 mx-2 p-2'>";
            include_once(__DIR__."/sections/withdraw-referral.php");
            echo "</div>";
            echo "</div>";
            }
        break;
        case"referral-details":
            if(vp_option_array($option_array,"resell") == "yes"){
            echo "<div class='container p-2'>";
            echo "<div class='mt-3 mx-2 p-2'>";
            include_once(__DIR__."/sections/ref-info.html");
            echo "</div>";
            echo "</div>";
            }
        break;
        case"referrals":
            if(vp_option_array($option_array,"resell") == "yes"){
            echo "<div class='container p-2'>";
            echo "<div class='mt-3 mx-2 p-2'>";
            include_once(__DIR__."/sections/withdraw-referral.php");
            echo "</div>";
            echo "</div>";
            }
        break;
        case"transfer":
            if(vp_option_array($option_array,"resell") == "yejs"){
            echo "<div class='container p-2'>";
            echo "<div class='mt-3 mx-2 p-2'>";
            include_once(__DIR__."/sections/transfer.php");
            echo "</div>";
            echo "</div>";
            }
        break;

        case"upgrade":
            echo "<div class='container p-2'>";
            echo "<div class='mt-3 mx-2 p-2'>";
            include_once(__DIR__."/sections/upgrade.php");
            echo "</div>";
            echo "</div>";
        break;
        case"developer":
            if(vp_option_array($option_array,"resell") == "yes"){
            echo "<div class='container p-2'>";
            echo "<div class='mt-3 mx-2 p-2'>";
            include_once(__DIR__."/sections/developer.php");
            echo "</div>";
            echo "</div>";
            }
        break;
        case"stats":
            if(vp_option_array($option_array,"resell") == "yes"){
            echo "<div class='container p-2'>";
            echo "<div class='mt-3 mx-2 p-2'>";
            include_once(__DIR__."/sections/statistics.php");
            echo "</div>";
            echo "</div>";
            }
        break;
        case"history":
            echo "<div class='container p-2'>";
            echo "<div class='mt-3 mx-2 p-2'>";
            include_once(__DIR__."/sections/history.php");
            echo "</div>";
            echo "</div>";
            
        break;
        case"customize":
            if(vp_option_array($option_array,"resell") == "yes" && current_user_can("administrator")){
            echo "<div class='container p-2 loginit'>";
            echo "<div class='mt-3 mx-2 p-2'>";
            include_once(__DIR__."/customizer.php");
            echo "</div>";
            echo "</div>";
            }
        break;
        default:
      
	    echo "<link rel=\"stylesheet\" href=\"".plugins_url('msorg_template')."/msorg_template/form.css?v=1\" media=\"all\">";
	
        echo "<div class='container'>";
        do_action("template_user_feature");
        echo "</div>";
        break;
    }

}

}



//BOTTOM
include_once(__DIR__."/bottom.html");
?>