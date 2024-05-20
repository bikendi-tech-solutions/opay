
jQuery(document).ready(function(){
    jQuery(".select-history span.categories, .select-history span.status, .select-history span.limit").on("click",function(){
       // alert("yo");
       var dclass;
       var dfor;

            if(jQuery(this).hasClass("categories")){
                dclass = "span.categories";
                dfor = "categories";
            }
            else if(jQuery(this).hasClass("limit")){
                dfor = "limit";
                dclass = "span.limit";
            }
            else{
                dfor = "status";
                dclass = "span.status";
            }


        if(jQuery(dclass+ " i").hasClass("fa-angle-down") == true){
            jQuery("div."+dfor+"-dropdown").removeClass("d-none");
            jQuery(dclass+ " i").removeClass("fa-angle-down");
            jQuery(dclass+ " i").addClass("fa-angle-up");
           
        }else{
            jQuery("div."+dfor+"-dropdown").addClass("d-none");
            jQuery(dclass+ " i").addClass("fa-angle-down");
            jQuery(dclass+ " i").removeClass("fa-angle-up");
        }
});


var url = location.href;


//#### FOR CATEGORIES

let pattern = url.match(/vend=history&sub=(\w+)/);
if(pattern){
let matches = pattern[1];

let clas = "."+matches+"-cat";

if(jQuery(clas).length !== undefined){
    jQuery(clas).addClass("active");
    jQuery("span.categories span.text").text(matches.charAt(0).toUpperCase() + matches.slice(1).toLowerCase());

}else{
    jQuery(".wallet-cat").addClass("active");
    jQuery("span.categories span.text").text("Wallet");

}


}else{
    jQuery(".wallet-cat").addClass("active");
    jQuery("span.categories span.text").text("Wallet");
}


//#### FOR STATUS

pattern = url.match(/&for=(\w+)/);
if(pattern){
matches = pattern[1];

clas = "."+matches+"-cat";

if(jQuery(clas).length !== undefined){
    jQuery(clas).addClass("active");

}else{
    jQuery(".all-cat").addClass("active");

}

}else{
    jQuery(".all-cat").addClass("active");
}


//#### FOR LIMIT

pattern = url.match(/&limit=(\d+)/);
if(pattern){
matches = pattern[1];

clas = matches;

if(jQuery(clas).length !== undefined){
    jQuery("[for="+clas+"]").addClass("active");
    jQuery("span.limit span.text").text(clas);


}else{
    jQuery("[for=10]").addClass("active");
    jQuery("span.limit span.text").text("10");


}

}else{
    jQuery("[for=10]").addClass("active");
    jQuery("span.limit span.text").text("10");
    

}



    
});