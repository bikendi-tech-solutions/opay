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

if(!is_user_logged_in()){
    die("Please Logged In");
}
elseif(!isset($_POST)){
    die("No Post Data");
}

$id = get_current_user_id();
//for
$for = trim($_POST["for"]);
$oldvalue = trim($_POST["oldvalue"]);
$value = trim($_POST["value"]);
$password = trim($_POST["password"]);

if(empty($for) || empty($oldvalue) || empty($value) || empty($password)){
    die("All Fields Required!*");
}

$user = get_user_by('ID', $id);


if($for !== "forgot-password" && $for !== "forgot-pin"  && $for !== "username"){
    $hashed_password = $user->user_pass;
    if (!wp_check_password($password, $hashed_password, $user->ID)) {
        die("Password Doesn't Match");
    } 

}


$code = rand(1111,9999);
switch($for){
    case"email":

        //Get Email Reset Code
        $code =  vp_getuser($id,"email_reset_code",true);
        $code_for =  vp_getuser($id,"email_reset_code_for",true);

        if($code == "false" || empty($code) || $code == "0"){
            die("Please Click On get Code To Receive A Code");
        }elseif($oldvalue != $code){
            die("Incorrect Code ");
        }
        elseif($value != $code_for){
            die("Code Not For This Email");
        }

        $current_email = $user->user_email;
        if(!is_email($value)){
            die("Invalid Email");
        }

        if(email_exists($value) || $current_email == $value){
            die("Email Already Exist");
        }
        

        global $wpdb;
        $table_name = $wpdb->prefix.'users';
        $user_data = $wpdb->update( $table_name, array('user_email'=>$value), array('id'=>$id));


        vp_updateuser($id,"email_reset_code",rand(000,888));

        die("100");

    break;
    case"password":

        wp_set_password($value,$id);


        die("100");

    break;
    case"forgot-password":
        $code =  vp_getuser($id,"password_reset_code",true);

        if($code != $oldvalue){
            die("Password reset code incorrect");
        }
        wp_set_password($password,$id);


        vp_updateuser($id,"password_reset_code",rand(000,888));

        die("100");

    break;
    case"forgot-pin":
        $code =  vp_getuser($id,"pin_reset_code",true);

        if($code != $oldvalue){
            die("Pin reset code incorrect");
        }
        elseif(!preg_match("/^\d{4}$/",$value)){
            die("Pin must be 4 digits");
        }
        vp_updateuser($id,"vp_pin", $value);


        vp_updateuser($id,"pin_reset_code",rand(000,888));

        die("100");

    break;
    case"pin":

        $user_pin = vp_getuser($id, "vp_pin",true);

        if($oldvalue == $value){
            die("You can't use same old password");
        }
        elseif($user_pin == $value){
            die("You can't use same old password");
        }
        elseif(!preg_match("/^\d{4}$/",$value)){
            die("Pin must be 4 digits");
        }

        vp_updateuser($id,"vp_pin", $value);

        die("100");

    break;
    case"username":
        $code =  vp_getuser($id,"username_reset_code",true);

        if($code != $oldvalue){
            die("Fullname reset code incorrect");
        }
        elseif(!preg_match("/^\w{3,}\s{1}\w{3,}$/",$value)){
            die("Your fullname should be as: Fullname Lastname and your names must be at least 3 characters");
        }

        $explode = explode(" ",$value);

        vp_updateuser($id,"first_name",$explode[0]);
        vp_updateuser($id,"last_name",$explode[1]);

       // vp_updateuser($id,"vp_pin", $value);

       vp_updateuser($id,"username_reset_code",rand(000,888));

        die("100");
    break;
    default:
        die("Not Determined");
    break;

}