
jQuery(document).ready(function ($) {
    $("body").prepend('<style>.dialog-type-lightbox{display:none!important;}.za-lightbox-nav-btns{position: fixed;width: 100%;height: 100%;display: flex;align-items: center;justify-content: space-between;padding: 3%;font-size: 40px;}</style>');
    
    $("body").append('\
        <div class="za-lightbox">\
            <div class="za-lightbox-inner">\
                <div class="zalightbox-close-btn za-lightbox-action-link"><i class="eicon-close" role="button" aria-label="Share" aria-expanded="false" tabindex="0"><span></span></i></div>\
                <img src="" class="za-lightbox-image">\
                <div class="za-lightbox-nav-btns">\
                <i class="eicon-arrow-left za-lightbox-action-link za-lightbox-prev-btn" role="button" aria-label="Share" aria-expanded="false" tabindex="0"><span></span></i>\
                <i class="eicon-arrow-right za-lightbox-action-link za-lightbox-next-btn" role="button" aria-label="Share" aria-expanded="false" tabindex="0"><span></span></i>\
                </div>\
            </div>\
        </div>\
    ');

    $(".oxi-image-hover > a").click(function(e){
        e.preventDefault();
        var crnt = $(this);
        $(".oxi-image-hover > a").removeClass("za-active-lightbox-img");
        crnt.addClass("za-active-lightbox-img");
        let image = crnt.attr("href");
        $(".za-lightbox-image").attr("src",image);
        $(".za-lightbox").fadeIn();
    });

    $(document).on("click", ".zalightbox-close-btn",function(){
        $(".za-lightbox").fadeOut();
    });

    $(document).on("click", ".za-lightbox-prev-btn",function(){
        var crnt_image_element = $(".za-active-lightbox-img");
        let new_image = $(".za-active-lightbox-img").parents(".oxi-image-hover-style").prev(".oxi-image-hover-style").find("a").attr("href");
        if(new_image !== undefined){
            crnt_image_element.parents(".oxi-image-hover-style").prev(".oxi-image-hover-style").find("a").addClass("za-active-lightbox-img");
            crnt_image_element.removeClass("za-active-lightbox-img")
            $(".za-lightbox-image").attr("src",new_image);
        }
    });

    $(document).on("click", ".za-lightbox-next-btn",function(){
        debugger
        var crnt_image_element = $(".za-active-lightbox-img");
        let new_image = $(".za-active-lightbox-img").parents(".oxi-image-hover-style").next(".oxi-image-hover-style").find("a").attr("href");
        if(new_image !== undefined){
            crnt_image_element.parents(".oxi-image-hover-style").next(".oxi-image-hover-style").find("a").addClass("za-active-lightbox-img");
            crnt_image_element.removeClass("za-active-lightbox-img")
            $(".za-lightbox-image").attr("src",new_image);
        }
    });
});


// Css code

// .za-lightbox{
//     position: fixed;
//     top: 0;
//     left: 0;
//     width: 100%;
//     height: 100%;
//     z-index: 99999;
//     background: rgba(0,0,0,0.7);
//     padding: 3%;
//   }
//   .za-lightbox-inner{
//     display: flex;
//     justify-content: center;
//     align-items: center;
//     height: 100%;
//   }
//   .zalightbox-close-btn{
//     font-size: 40px;
//     color: white;
//     position: absolute;
//     right: 3%;
//     top: 30px;
//   }
//   .za-lightbox-image{
//     max-width: 800px;
//     width: 100%;
//     margin: auto;
//   }
//   .za-lightbox-nav-btns {
//     width: 100%;
//     position: absolute;
//     height: 100%;
//     display: flex;
//     align-items: center;
//     justify-content: space-between;
//     padding: 3%;
//     font-size: 40px;
//     top: 0;
//     color: white;
//   }