$(document).ready(function($){
    $(".accordion-body a").click(function(e){
        e.preventDefault();
        $("#program").val( $(this).text() );
        $('html, body').animate({
            scrollTop: $(".su-form-area").offset().top
        });    
    });

    $(".iframe-poster").click(function(){
        $("#iframeVideo")[0].src += "&autoplay=1";
        $(this).hide();
    });
})

