
document.addEventListener("DOMContentLoaded",function(){


        var opayBalHidden = Cookies.get('opayBalHidden');

        if(opayBalHidden == "yes"){
            jQuery(".toggle-bal-visible").removeClass("fa-eye");
            jQuery(".toggle-bal-visible").addClass("fa-eye-slash");
            jQuery(".amount-currency").hide();
            jQuery(".opay-main-2nd .amount").text("*****");
        }else{
            jQuery(".toggle-bal-visible").addClass("fa-eye");
            jQuery(".toggle-bal-visible").removeClass("fa-eye-slash");
            jQuery(".amount-currency").show();
            jQuery(".opay-main-2nd .amount").text(user_balance);
        }
        //console.log(username); 

    var user_balance = jQuery(".opay-main-2nd .amount").text();

    jQuery(".toggle-bal-visible").on("click",function(){
        if(jQuery(this).hasClass("fa-eye") == true){
            jQuery(this).removeClass("fa-eye");
            jQuery(this).addClass("fa-eye-slash");
            jQuery(".amount-currency").hide();
            jQuery(".opay-main-2nd .amount").text("*****");
            Cookies.set('opayBalHidden', 'yes', { expires: 365 });
           
        }else{
            jQuery(this).addClass("fa-eye");
            jQuery(this).removeClass("fa-eye-slash");
            jQuery(".amount-currency").show();
            jQuery(".opay-main-2nd .amount").text(user_balance);
            Cookies.set('opayBalHidden', 'no', { expires: 365 });

        }
    });



});