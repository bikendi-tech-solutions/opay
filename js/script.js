
/*
#
#
#BEGINNING OF POPUP
#
#
*/





function popup(userOptions = {}){

    const $popup = $(`
                
        <div id="popup" class="d-flex align-items-center justify-content-center rounded d-none ">
            <!--PopUp-->
                <div class="row position-relative" >
                    <div class="col-12 top-image d-flex justify-content-center d-none">
                        <span class="d-flex justify-content-center align-items-center">
                            
                        </span>
                    </div>


                    
                    <div class="col-12 win d-flex justify-content-start" style="min-height:50px;">
                        <i class="fa-solid text-muted close-popup d-none fa-xmark "></i>
                    </div>

                    
                    <div class="col-12 px-2 py-4 d-flex flex-column align-items-center ">
                        <span class="pop-up-topic mb-2"></span>
                        <hr style="width:70%;">
                        <span class="pop-up-message text-center"></span>
                    </div>
                    <div class="col-12 mb-4 d-flex justify-content-center cta-div align-items-center">
                        <div class="row popup-cta">
                        </div>
                    </div>

                    <div class="col-12 close-popupdiv text-center">

                        <i class="fa-regular close-popup fa-circle-xmark cursor-pointer"></i>

                    </div>
                </div>
        <script>
                jQuery(".close-popup").on("click",function(){
                    closepopup();
                });
        </script>

        </div>


    `);

    jQuery("#main-page").append($popup);

    const defaultOptions = {
        type: 'plain',
        icon: {
            show:false,
            icon: '',
            type: '',
            color: 'white',
            bgcolor: 'green'
        },
        image: {
            show:true,
            image: '',
            type: 'notification'
        },
        button:{
        },
        topic: '',
        message: ''
    };

    /* 
    ### ICON ###
    

    */

    const options = { ...defaultOptions, ...userOptions };

    var ctatext;
    var ctalink;
    var totalcta = "";

    if("button" in options){
        if(options.button.hasOwnProperty("close")){

            ctatext = options.button.close;
            ctalink = "#";
            if(ctalink == ''){
                ctalink = '#';
            }
            totalcta += `
                    <div class="col close-popup d-flex justify-content-center my-1 align-items-center" onclick="closepopup()">
                                <a href="${ctalink}" class="btn">${ctatext}</a>
                    </div>
            `;
        }

        const btns = options["button"];
        for(var key in btns){
            if(btns.hasOwnProperty(key) ){

                
                ctatext = key;
                ctalink = btns[key];
                if(key == "close"){
                    continue;
                }

                if(ctalink == ''){
                    ctalink = '#';
                }else{
                    ctalink = ctalink.replace(/&amp;/g, "&");
                }
                totalcta += `
                            <div class="col d-flex justify-content-center my-1 align-items-center" >
                                    <a href="${ctalink}" class="btn">${ctatext}</a>
                        </div>
                `;
            }
        }

        jQuery(".popup-cta").append(totalcta);
    }

    if("icon" in options){
        const icon = options["icon"];
        const iconType = icon["type"];
        


        if(iconType == "info"){
            options.icon.icon = '<i class="fa-solid fa-circle-info"></i>';
            options.icon.bgcolor = '#0d6efd';
        }
        else if(iconType == "warning"){
            options.icon.icon  = '<i class="fa-solid fa-triangle-exclamation"></i>';
            options.icon.bgcolor = '#ffc107';

        }
        else if(iconType == "success"){
            options.icon.icon = '<i class="fa-solid fa-circle-check"></i>';
            options.icon.bgcolor = '#198754';

        }
        else if(iconType == "notification"){
            options.icon.icon = '<i class="fa-solid fa-bullhorn"></i>';
            options.icon.bgcolor = '#198754';

        }
        else if(iconType == "danger" || iconType == "error" ){
            options.icon.icon = '<i class="fa-regular fa-circle-xmark"></i>';
            options.icon.bgcolor = '#dc3545';

        }


        jQuery("#popup .top-image span").css({"color":options.icon.color});
        jQuery("#popup .top-image span").css({"background-color":options.icon.bgcolor});
        jQuery("#popup .top-image span").html(options.icon.icon);
 
        if(options.icon.show){
         jQuery("#popup .top-image").removeClass("d-none");
        }
    }


        const image = options["image"];
        const imageType = image["type"];
        if(imageType == "crypto"){
            options.image.image = imageUrls.crypto;
        }
        else if(imageType == "giftcard"){
            options.image.image = imageUrls.giftcard;
        }
        else if(options.image.image != ""){

        }
        else {
            options.image.image = imageUrls.notification;

        }
       // jQuery("#popup .pop-up-icon").addClass(iconType);

       var imageUrl = options.image.image;

       jQuery("#popup .col-12.win.d-flex.justify-content-start").css({"background":`url(${imageUrl})`});




    


            jQuery("#popup .pop-up-topic").html(options["topic"]);
            jQuery("#popup .pop-up-message").html(options["message"]);

            jQuery("#popup").removeClass("d-none");



    

}






/*
#
#
#END OF POPUP
#
#
*/

