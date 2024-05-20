
document.addEventListener("DOMContentLoaded",function(){


    var user_balance = jQuery(".opay-main-2nd .amount").text();

    jQuery(".toggle-bal-visible").on("click",function(){
        if(jQuery(this).hasClass("fa-eye") == true){
            jQuery(this).removeClass("fa-eye");
            jQuery(this).addClass("fa-eye-slash");
            jQuery(".amount-currency").hide();
            jQuery(".opay-main-2nd .amount").text("*****");
           
        }else{
            jQuery(this).addClass("fa-eye");
            jQuery(this).removeClass("fa-eye-slash");
            jQuery(".amount-currency").show();
            jQuery(".opay-main-2nd .amount").text(user_balance);

        }
    });



});