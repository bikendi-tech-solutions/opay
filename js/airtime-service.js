jQuery("#dropdown-for-networks").hide();

document.addEventListener("DOMContentLoaded", function () {

    jQuery(".service-type-col:first-of-type").addClass("active");





    //jQuery(".service-type-col[for=vtu]").addClass("active");

    jQuery(".service-type-col").on("click", function () {
        jQuery(".service-type-col").each(function () {
            jQuery(this).removeClass("active");
        });

        jQuery(this).addClass("active");

    });

    function validateSubmission() {

        jQuery("#form-submit-section .second button").removeClass("active");

        var url = location.href;

        var recipient_notice = jQuery(".recipient-incorrect-notice");
        var amount_notice = jQuery(".amount-incorrect-notice");
        var recipient = jQuery(".input-recipient").val();
        var input_amount = jQuery("#form-submit-section input.input-amount").val();

        jQuery(".amount-value").text(input_amount);

        //Recipient
        if (((recipient.length != 11 && (url.indexOf("airtime") != -1 || url.indexOf("data") != -1)) || recipient.length < 9) && url.indexOf("coupon") == -1) {

            recipient_notice.text("Please input a valid number");
            jQuery("#form-submit-section .second button").addClass("inactive");
            return false;
        } else {
            recipient_notice.text("");
        }


        if (input_amount < 50 && url.indexOf("bvn") == -1) {
            amount_notice.text("Amount shouldn't be less than ₦50");
            jQuery("#form-submit-section .second button").addClass("inactive");
            return false;
        } else {
            amount_notice.text("");

        }



        jQuery("#form-submit-section .second button").removeClass("inactive");
        jQuery("#form-submit-section .second button").addClass("active");

    }

    jQuery(".buy-with-this").on("click", function () {
        jQuery(".buy-with-this").removeClass("chosen");
        jQuery(this).addClass("chosen");
        var amount = jQuery(this).attr("amount");

        jQuery(".input-amount").val(amount);

        validateSubmission();

        jQuery(".paybutton").click();
    });

    jQuery(".quant-with-this").on("click", function () {
        jQuery(".quant-with-this").removeClass("chosen");
        jQuery(this).addClass("chosen");
        var quantity = jQuery(this).attr("quantity");
        var amount = jQuery(".input-amount").val() * quantity;

        jQuery(".input-amount").val(amount);

        validateSubmission();

        jQuery(".paybutton").click();
    });


    jQuery(".networks#first-col").on("click", function () {
        if (jQuery(this).hasClass("ashownDd") == true) {
            jQuery(this).removeClass("ashownDd");
            jQuery("#drop-down-image-select + i").removeClass("fa-caret-down");
            jQuery("#drop-down-image-select + i").addClass("fa-caret-up");
            jQuery("#dropdown-for-networks").hide();
            jQuery("#dropdown-for-networks").addClass("d-none");
        } else {
            jQuery(this).addClass("ashownDd");
            jQuery("#drop-down-image-select + i").addClass("fa-caret-down");
            jQuery("#drop-down-image-select + i").removeClass("fa-caret-up");
            jQuery("#dropdown-for-networks").show();
            jQuery("#dropdown-for-networks").removeClass("d-none");
        }
    });

    jQuery(".net-choice").on("click", function () {

        var forNetwork = jQuery(this).attr("for");
        var ext = jQuery(this).attr("ext");

        jQuery(".net-choice").removeClass("active");

        jQuery(this).addClass("active");


        jQuery("#drop-down-image-select").attr("for", forNetwork);
        jQuery("#drop-down-image-select").attr("value", forNetwork);



        jQuery(".changeNetworkLogo").attr("src", networkImagesUrl + "image/" + forNetwork + "." + ext);
        jQuery(".networks#first-col").removeClass("ashownDd");
        jQuery("#drop-down-image-select + i").removeClass("fa-caret-down");
        jQuery("#drop-down-image-select + i").addClass("fa-caret-up");
        jQuery("#dropdown-for-networks").hide();
        jQuery("#dropdown-for-networks").addClass("d-none");

        makeChoice();


    });



    jQuery(".close-confirm-transaction").on("click", function () {

        jQuery("#confirm-transaction").addClass("d-none");

    });



    jQuery("#form-submit-section input.input-amount, .input-recipient").on("change", function () {
        validateSubmission();
    });

    jQuery("#form-submit-section .second button").on("click", function () {



        jQuery("#confirm-transaction").addClass("align-items-end");

        validateSubmission();

        if (jQuery(this).hasClass("active")) {
            calcit();
            jQuery("#confirm-transaction").removeClass("d-none");
            return;
        } else {
            jQuery("#confirm-transaction").addClass("d-none");
        }



    });


    var pin = "";


    jQuery(".pin_input").on("input", function () {
        //get my number
        var current_number = jQuery(this).attr("pin");
        var myVal = jQuery(this).val();
        pin = "";
        var valid = true;
        for (i = 1; i <= 4; i++) {
            var thisForVal = jQuery(".pin_" + i).val();

            pin = pin + "" + thisForVal;

            if (jQuery(".pin_input[pin=" + i + "]").val() == "") {

                jQuery(".checkout").removeClass("active");
                jQuery(".checkout").addClass("inactive");

                valid = false;
                jQuery(".pin_" + i).addClass("error");
                jQuery(".pin_" + i).focus();
                break;
            } else {
                jQuery(".pin_" + i).removeClass("error");
            }

            if (i <= 3) {
                var nextNum = i + 1;
                jQuery(".pin_input[pin=" + nextNum + "]").focus();

            }



        }

        if (valid) {
            jQuery(".checkout").removeClass("inactive");
            jQuery(".checkout").addClass("active");

        }


    });

    jQuery(".proceed_next").on("click", function () {
        var current = parseInt(jQuery(this).attr("current"));
        var next;


        if (current >= 1) {
            next = current + 1;

            jQuery(".level_" + current).addClass("d-none");
            jQuery(".level_" + next).removeClass("d-none");
        }



    });

    jQuery(".proceed_prev").on("click", function () {
        var current = parseInt(jQuery(this).attr("current"));
        var next;

        if (current > 1) {
            next = current - 1;

            jQuery(".level_" + current).addClass("d-none");
            jQuery(".level_" + next).removeClass("d-none");
        } else {
            jQuery("#confirm-transaction").addClass("d-none");
            jQuery("#transaction-response").addClass("d-none");
        }



    });

    jQuery(".checkout").on("click", function () {



        var url = location.href;
        var obj = {};

        if (url.indexOf("airtime") !== -1) {

            obj["vend"] = "vend";
            obj["vpname"] = username;
            obj["vpemail"] = useremail;
            obj["airtimechoice"] = jQuery(".service-type-col.active").attr("for");
            obj["network"] = jQuery("#drop-down-image-select").attr("value");
            obj["network_name"] = jQuery("#drop-down-image-select").attr("for").toUpperCase();
            obj["airtime_choice"] = obj["airtimechoice"].toUpperCase();
            obj["tcode"] = "cair";
            obj["datatcode"] = "";
            obj["thisnetwork"] = obj["network_name"];
            obj["uniqidvalue"] = run_code;
            obj["id"] = "VTU-" + run_code;
            obj["phone"] = jQuery(".input-recipient").val();
            obj["amount"] = jQuery("#form-submit-section input.input-amount").val();
            obj["pin"] = "";
            obj["run_code"] = run_code;
            obj["url"] = doUrl();
            obj["pin"] = pin;

        }

        else if (url.indexOf("recharge") !== -1) {
            obj["vend"] = "vend";
            obj["vpname"] = username;
            obj["vpemail"] = useremail;
            obj["tcode"] = "ccards";
            obj["uniqidvalue"] = run_code;
            obj["id"] = "VTU-" + run_code;
            obj["amount"] = jQuery(".input-amount").val();
            obj["quantity"] = jQuery(".quant-with-this.chosen").attr("quantity");
            obj["edutype"] = jQuery("#drop-down-image-select").attr("value");
            obj["domination"] = jQuery(".buy-with-this.chosen").attr("amount");
            obj["pin"] = pin;
            obj["run_code"] = run_code;
        }
        else if (url.indexOf("coupon") !== -1) {
            obj["run_coupon"] = jQuery(".input-recipient").val();
        }

        else if (url.indexOf("data") !== -1) {

            obj["vend"] = "vend";
            obj["network"] = jQuery("#drop-down-image-select").attr("value");
            obj["cplan"] = jQuery(".buy-with-this.chosen").attr("plan_id");
            obj["vpname"] = username;
            obj["network_name"] = jQuery("#drop-down-image-select").attr("for").toUpperCase();
            obj["data_plan"] = jQuery(".buy-with-this.chosen").attr("plan_name");
            obj["plan_index"] = jQuery(".buy-with-this.chosen").attr("plan_index");
            obj["data_choice"] = jQuery(".service-type-col.active").attr("for").toUpperCase();
            obj["vpemail"] = useremail;
            obj["tcode"] = "cdat";
            if (obj["network_name"] == "SMILE") {
                obj["datatcode"] = "smile";
            } else {
                obj["datatcode"] = jQuery(".service-type-col.active").attr("for");
            }
            /*obj["smile_email"] = jQuery(".smile_email").val();*/
            obj["url"] = doUrl();
            obj["uniqidvalue"] = run_code;
            obj["thatnetwork"] = obj["network_name"];
            obj["id"] = "VTU-" + run_code;
            obj["phone"] = jQuery(".input-recipient").val();
            obj["amount"] = jQuery(".buy-with-this.chosen").attr("amount");
            obj["pin"] = pin;
            obj["run_code"] = run_code;

        }
        else if (url.indexOf("cable") !== -1) {
            obj["vend"] = "vend";
            obj["cabtype"] = jQuery("#drop-down-image-select").attr("value");
            obj["ccable"] = jQuery(".buy-with-this.chosen").attr("plan_id");
            obj["plan_index"] = jQuery(".buy-with-this.chosen").attr("plan_index");
            obj["vpname"] = username;
            obj["vpemail"] = useremail;
            obj["tcode"] = "ccab";
            obj["url"] = doUrl();
            obj["uniqidvalue"] = run_code;
            obj["id"] = "VTU-" + run_code;
            obj["iuc"] = jQuery(".input-recipient").val();
            obj["amount"] = jQuery(".buy-with-this.chosen").attr("amount");
            obj["pin"] = pin;
            obj["run_code"] = run_code;
        }
        else if (url.indexOf("bill") !== -1) {

            obj["vend"] = "vend";
            obj["type"] = jQuery(".service-type-col.active").attr("bill_id");
            obj["cbill"] = jQuery(".net-choice.active").attr("disco_id");
            obj["vpname"] = username;
            obj["vpemail"] = useremail;
            obj["tcode"] = "cbill";
            obj["url"] = doUrl();
            obj["uniqidvalue"] = run_code;
            obj["id"] = "VTU-" + run_code;
            obj["meterno"] = jQuery(".input-recipient").val();
            obj["amount"] = parseInt(jQuery("#form-submit-section input.input-amount").val());
            obj["pin"] = pin;
            obj["run_code"] = run_code;
        }
        else if (url.indexOf("bet") !== -1) {
            obj["vend"] = "vend";
            obj["bet_company"] = jQuery(".net-choice.active").attr("comp_id");
            obj["customerid"] = jQuery(".input-recipient").val();
            obj["amount"] = parseInt(jQuery("#form-submit-section input.input-amount").val());
            obj["vpname"] = username;
            obj["vpemail"] = useremail;
            obj["tcode"] = "cbet";
            obj["url"] = doUrl();
            obj["uniqidvalue"] = run_code;
            obj["id"] = "VTU-" + run_code;
            obj["pin"] = pin;
            obj["run_code"] = run_code;
        }
        else if (url.indexOf("bvn") !== -1) {
            obj["vend"] = "vend";
            obj["type"] = jQuery(".net-choice.active").attr("comp_id");
            obj["value"] = jQuery(".input-recipient").val();
            obj["amount"] = parseInt(jQuery("#form-submit-section input.input-amount").val());
            obj["pin"] = pin;
            obj["run_code"] = run_code;
        }


        /*    jQuery("#confirm-transaction").addClass("d-none");
            jQuery("#transaction-response").removeClass("d-none");*/




        jQuery("#ajax-error-response.ajax-error-response").text(" ");

        setPopupHeight();
        runAirtimeTransaction(obj);




    });


    jQuery("#transaction-response .done-btn").on("click", function () {
        jQuery("#transaction-response").addClass("d-none");
        location.reload();
    });





});