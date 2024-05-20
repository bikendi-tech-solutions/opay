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
$for = $_POST["for"];
$value = $_POST["value"];

$code = rand(1111,9999);
switch($for){
    case"email":
        if(!is_email($value)){
            die("Invalid Email");
        }

        $current_email = get_userdata($id)->user_email;
        if(email_exists($value) || $current_email == $value){
            die("Email Already Exist");
        }

        vp_updateuser($id,"email_reset_code",$code);
        vp_updateuser($id,"email_reset_code_for",$value);
        $message =<<<EOT
            Your reset email verification code is $code 
        EOT;

        $site_name = get_option("blogname");
        $subject = "$site_name Reset Email Verification Code";
        $headers = array('Content-Type: text/html; charset=UTF-8');
        wp_mail($value,$subject,$message,$headers);
        
        die("100");
    break;
    case"password":

        vp_updateuser($id,"password_reset_code",$code);

        $email = get_userdata($id)->user_email;

        $site_name = get_option("blogname");
        $subject = "$site_name Reset Password Verification Code";
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $message =<<<EOT
        Your reset password verification code is $code 
        EOT;
        wp_mail($email,$subject,$message,$headers);

        die("100");
    break;
    case"pin":
        vp_updateuser($id,"pin_reset_code",$code);

        $email = get_userdata($id)->user_email;

        $site_name = get_option("blogname");
        $subject = "$site_name Reset Pin Verification Code";
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $message =<<<EOT
        Your reset pin verification code is $code 
        EOT;
        wp_mail($email,$subject,$message,$headers);

        die("100");
    break;
    case"username":
        vp_updateuser($id,"username_reset_code",$code);

        $email = get_userdata($id)->user_email;

        $site_name = get_option("blogname");
        $subject = "$site_name Reset Full Name Verification Code";
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $message =<<<EOT
        Your reset fullName verification code is $code 
        EOT;
        wp_mail($email,$subject,$message,$headers);

        die("100");

    break;
    default:
        die("Nothing To Do");
    break;
}