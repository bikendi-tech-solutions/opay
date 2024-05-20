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


if(!isset($_POST["for"])){
    die("To Do What");
}
elseif(!isset($_POST["email"])){
    die("Email Required");
}
elseif(empty($_POST["email"])){
    die("Enter a valid email");
}

$email = trim($_POST["email"]);

if(!is_email($email)){
    die("Enter a valid email");
}

if(!email_exists($email)){
    die("Email does not exist");
}

$user = get_user_by('email',$email);

if(!$user){
    die("Can't fetch user");
}


$id = $user->ID;

$for = $_POST["for"];

if($for == "password"){
    $code = rand(1111,9999);

        vp_updateuser($id,"password_reset_code",$code);


        $site_name = get_option("blogname");
        $subject = "$site_name Reset Password Verification Code";
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $message =<<<EOT
        Your reset password verification code is $code
        <br>
        -Please ignore if a reset wasn't initaited by you!
        EOT;
        wp_mail($email,$subject,$message,$headers);

        die("100");

}
elseif($for == "reset-password"){

    if(!isset($_POST["code"])){
        die("Reset Code Required");
    }
    elseif(!isset($_POST["password"])){
        die("Password Key Requires");
    }
    elseif(empty($_POST["password"])){
        die("Password Can't Be Empty");
    }

    $code = trim($_POST["code"]);
    $password = trim($_POST["password"]);

    $original_code = vp_getuser($id,"password_reset_code");

    if($original_code == "false" || $original_code == "0" || empty($original_code)){
        die("Invalid Code: Click Get Code To Reset");
    }
    elseif($code != $original_code){
        die("Invalid Code: Check and Re-enter code");
    }
    elseif(strlen($password) < 8){
        die("Password Must Be At Least 6 Characters");
    }
    elseif(strlen($password) > 32){
        die("Password Must Be Less Than 32 Characters");
    }


    $code = rand(1111,9999);

    vp_updateuser($id,"password_reset_code",$code);

    wp_set_password($password,$id);

die("100");
}
elseif($for == "activate"){
    if(!is_user_logged_in()){
        die("Please Login");
    }

$id = get_current_user_id();
$userdata = get_userdata($id);
$email = $userdata->user_email;

$email_verification_status =  vp_getuser($id,"email_verified",true);

if($email_verification_status == "verified"){
    die("Account with this email is already verified");
}

$code = rand(1111,9999);

vp_updateuser($id,"email_verified",$code);


$site_name = get_option("blogname");
$subject = "$site_name Account Verification Code";
$headers = array('Content-Type: text/html; charset=UTF-8');
$message =<<<EOT
Your Account verification code is $code
<br>
-Please ignore if a reset wasn't initaited by you!
EOT;
wp_mail($email,$subject,$message,$headers);

die("100");


}
elseif($for == "activate-account"){

    if(!is_user_logged_in()){
        die("Please Login");
    }

    if(!isset($_POST["code"])){
        die("Code Required");
    }

    $code = trim($_POST["code"]);

    $id = get_current_user_id();
    $userdata = get_userdata($id);
    $email = $userdata->user_email;

    $email_verification_status =  vp_getuser($id,"email_verified",true);

    if($email_verification_status == "verified"){
        die("Account with this email is already verified");
    }

    if($email_verification_status == $code){
        vp_updateuser($id,"email_verified","verified");
        die("100");
    }else{
        die("Code Mismatch");
    }

}
else{
    die("Nothing to do");
}