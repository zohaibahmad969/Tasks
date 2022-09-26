jQuery(document).ready(function ($) {

    $(".left-section .tab").click(function () {
        var crnt = $(this);
        $(".left-section .tab").removeClass("active");
        crnt.addClass("active");
        var crnt_tab_content = crnt.attr("data-tab");
        $("app-maps-design, app-maps-details, app-maps-format").css("display", "none");
        $(crnt_tab_content).fadeIn();
    });


    $("#map_title_larger_text").val($(".za-map-title").html());
    $("#map_title_smaller_text").html($(".za-map-coordinates").text());

    $("#map_title_larger_text").keyup(function(){
        $(".za-map-title").html( $(this).val() );
    });

    $("#map_title_smaller_text").keyup(function(){
        $(".za-map-coordinates").html( $(this).val() );
    });

    $("#za_map_title_checkbox").change(function() {
        if(this.checked) {
            $(".za-map-title-checkbox-element, .za-map-details").css("display","block");
        }else{
            $(".za-map-title-checkbox-element, .za-map-details").css("display","none");
        }
    });
    $("#za_script_font_checkbox").change(function() {
        if(this.checked) {
            $(".za-map-details .za-map-title").css("letter-spacing","2px");
        }else{
            $(".za-map-details .za-map-title").css("letter-spacing","inherit");
        }
    });


});


$(document).on("click",".app-grid-style .selector",function () {
    var crnt = $(this);
    var crnt_style = crnt.attr("data-mapStyle");
    $(".app-grid-style .selector").removeClass("active");
    crnt.addClass("active");
    if(crnt_style == "square"){
        $(".za-map-setting").css("height",$(".za-map-setting").css("width"));
        $(".za-map-setting").css("border-radius","0");
        $(".za-map-setting").css("overflow","auto");
    }else if(crnt_style == "circle"){
        $(".za-map-setting").css("height",$(".za-map-setting").css("width"));
        $(".za-map-setting").css("width",$(".za-map-setting").css("height"));
        $(".za-map-setting").css("border-radius","50%");
        $(".za-map-setting").css("overflow","hidden");
    }

});
$(document).on("click",".app-grid-product-type .selector",function () {
    var crnt = $(this);
    var crnt_productType = crnt.attr("data-productType");

    $(".app-grid-product-type .selector").removeClass("active");
    crnt.addClass("active");

    $(".info-box").removeClass("visible");
    $("#"+crnt_productType+"_info").addClass("visible");

    if(crnt_productType == "printed"){
        $(".za-map-wrap").removeClass("za-map-wrap-framed");
        $(".za-map-wrap").attr("style","");
    }else if(crnt_productType == "framed"){
        $(".za-map-wrap").addClass("za-map-wrap-framed");
        $(".za-map-wrap").attr("style","");
    }else if(crnt_productType == "streched"){
        $(".za-map-wrap").removeClass("za-map-wrap-framed");
        $(".za-map-wrap").attr("style","");
    }else if(crnt_productType == "digital"){
        $(".za-map-wrap").removeClass("za-map-wrap-framed");
        $(".za-map-wrap").css("transform","scale(1.1)");
    }


    // Showing relative Price boxes
    var crnt_orientation = $(".app-grid-orientation .selector.active").attr("data-orientation");
    $(".price-boxes-holder").removeClass("za-price-box-visible");
    $("#"+crnt_productType+"_"+crnt_orientation+"_prices").addClass("za-price-box-visible");

    // updating price
    update_product_price();

});
$(document).on("click",".app-grid-orientation .selector",function () {
    var crnt = $(this);
    var crnt_orientation = crnt.attr("data-orientation");
    $(".app-grid-orientation .selector").removeClass("active");
    crnt.addClass("active");
    if(crnt_orientation == "portrait"){
        $(".za-map-setting").css("width","527px");
        $(".za-map-setting").css("height","427px");
    }else if(crnt_orientation == "square"){
        $(".za-map-setting").css("width","527px");
        $(".za-map-setting").css("height","527px");
    }else if(crnt_orientation == "landscape"){
        $(".za-map-setting").css("width","540px");
        $(".za-map-setting").css("height","385px");
    }

    // Showing relative Price boxes
    var crnt_productType = $(".app-grid-product-type .selector.active").attr("data-productType");
    $(".price-boxes-holder").removeClass("za-price-box-visible");
    $("#"+crnt_productType+"_"+crnt_orientation+"_prices").addClass("za-price-box-visible");

    // updating price
    update_product_price();

});

$(document).on("click",".price-selector .selector",function () {
    var crnt = $(this);
    var crnt_price = crnt.attr("data-orientation");
    crnt.parents(".price-boxes-holder").find(".price-selector .selector").removeClass("active");
    crnt.addClass("active");
    
    // updating price
    update_product_price();

});

function update_product_price(){
    var crnt_productType = $(".app-grid-product-type .selector.active").attr("data-productType");
    var crnt_orientation = $(".app-grid-orientation .selector.active").attr("data-orientation");
    $(".price-indicator #za_product_price").html($("."+crnt_productType+"_"+crnt_orientation+"_prices.za-price-box-visible .price-selector .selector.active .za-price").html());
}

$(document).on("click",".zme-add-to-cart",function(){

    if($("#pac-input").val() == "" ){

        alert("Please enter some place");
        
        $(".left-section .tab").removeClass("active");
        $(".app-details-tab").addClass("active")
        $("app-maps-design, app-maps-details, app-maps-format").css("display", "none");
        $("app-maps-details").fadeIn();

    }else{
		$(".zme-add-to-cart").text("adding");
        html2canvas($("#zaCustomMap"), {
            onrendered: function(canvas) {
                theCanvas = canvas;
                var zmeImage = theCanvas.toDataURL('image/jpeg', .90);

                jQuery.ajax({
                            url: '/wp-admin/admin-ajax.php',
                            type: 'post',
                            data: { 
                                'action': 'zmeaddtocart',
                                'zme_image': zmeImage,
                                'zme_title': $("#map_title_larger_text").val(),
                                'zme_sub_title': $("#map_title_smaller_text").val(),
                                'zme_product_type': $(".app-grid-product-type .selector.active").attr("data-producttype"),
                                'zme_size': $(".price-boxes-holder.za-price-box-visible .selector.active .size").text(),
                                'zme_price': $(".add-to-cart-area .price-indicator #za_product_price").text(),
                            },
                            success: function( response ) {
								console.log("product added to cart.");
                                window.location.href = '/cart';
                            },
                            error: function (error) {
                                console.log(error);
                            }
                        });

            }
            
        });

    }

});


window['minimal_styles'] = [
    {featureType: "administrative",elementType: "all", stylers: [{ hue: "#fffff" }, { lightness: -50 }, { saturation: -10 }]}, 
    {featureType: "landscape",elementType: "all",stylers: [{ hue: "#fffff" },{ lightness: 100 },{ saturation: -100 }]}, 
    {featureType: "poi",elementType: "all",stylers: [{ hue: "#fffff" },{ lightness: 70 },{ saturation: -100 }]}, 
    {featureType: "road", elementType: "all",stylers: [{ hue: "#b18571" },{ lightness: -50 },{ saturation: -500 }]}, 
    {featureType: "transit",elementType: "all",stylers: [{ hue: "#fffff" },{ lightness: 70 },{ saturation: -100 }]}, 
    {featureType: "water",elementType: "all",stylers: [{ hue: "#fffff" },{ lightness: 500 },{ saturation: 100 }]}
];
window['beachglass_styles'] = [
    {featureType: "administrative",elementType: "all", stylers: [{ hue: "#fffff" }, { lightness: -50 }, { saturation: -10 }]}, 
    {featureType: "landscape",elementType: "all",stylers: [{ hue: "#fffff" },{ lightness: 50 },{ saturation: -100 }]}, 
    {featureType: "poi",elementType: "all",stylers: [{ hue: "#fffff" },{ lightness: 70 },{ saturation: -100 }]}, 
    {featureType: "road", elementType: "all",stylers: [{ hue: "#b18571" },{ lightness: -50 },{ saturation: -500 }]}, 
    {featureType: "transit",elementType: "all",stylers: [{ hue: "#fffff" },{ lightness: 70 },{ saturation: -100 }]}, 
    {featureType: "water", elementType: "all",stylers: [{ lightness: 500 }]}, 
];
window['carbon_styles'] = [
    {featureType: "administrative",elementType: "all", stylers: [{ hue: "#e28743" }, { lightness: -50 }, { saturation: -10 }]}, 
    {featureType: "landscape",elementType: "all",stylers: [{ hue: "#e28743" },{ lightness: -70 },{ saturation: -400 }]}, 
    {featureType: "poi",elementType: "all",stylers: [{ hue: "#e28743" },{ lightness: 70 },{ saturation: -100 }]}, 
    {featureType: "road", elementType: "all",stylers: [{ hue: "#e28743" },{ lightness: 70 },{ saturation: -500 }]}, 
    {featureType: "transit",elementType: "all",stylers: [{ hue: "#e28743" },{ lightness: 70 },{ saturation: -100 }]}, 
    {featureType: "water",elementType: "all",stylers: [{ hue: "#e28743" },{ lightness: -70 },{ saturation: -400 }]}
];

window['black_styles'] = [
    {featureType: "administrative",elementType: "all", stylers: [{ hue: "red" }, { lightness: 0 }, { saturation: -100 }]}, 
    {featureType: "landscape",elementType: "all",stylers: [{ hue: "#FFC0CB" },{ lightness: -90 },{ saturation: -200 }]}, 
    {featureType: "poi",elementType: "all",stylers: [{ hue: "#FFC0CB" },{ lightness: 70 },{ saturation: -100 }]}, 
    {featureType: "road", elementType: "all",stylers: [{ hue: "#FFC0CB" },{ lightness: 70 },{ saturation: -100 }]}, 
    {featureType: "transit",elementType: "all",stylers: [{ hue: "#FFC0CB" },{ lightness: 70 },{ saturation: -100 }]}, 
    {featureType: "water",elementType: "all",stylers: [{ hue: "#00FFFF" },{ lightness: -90 },{ saturation: -200 }]}
];
window['vintage_styles'] = [
    {featureType: "administrative",elementType: "all", stylers: [{ hue: "#e2dcd6" }, { lightness: 10 }, { saturation: -10 }]}, 
    {featureType: "landscape",elementType: "all",stylers: [{ hue: "#e2dcd6" },{ lightness: 70 },{ saturation: 100 }]}, 
    {featureType: "poi",elementType: "all",stylers: [{ hue: "#e2dcd6" },{ lightness: 70 },{ saturation: -100 }]}, 
    {featureType: "road", elementType: "all",stylers: [{ hue: "#b18571" },{ lightness: -70 },{ saturation: -500 }]}, 
    {featureType: "transit",elementType: "all",stylers: [{ hue: "#e2dcd6" },{ lightness: 70 },{ saturation: -100 }]}, 
    {featureType: "water",elementType: "all",stylers: [{ hue: "#e2dcd6" },{ lightness: 70 },{ saturation: 100 }]}
];
window['atlas_styles'] = [
    {featureType: "administrative",elementType: "all", stylers: [{ hue: "#e2dcd6" }, { lightness: 10 }, { saturation: -10 }]}, 
    {featureType: "road", elementType: "all",stylers: [{ hue: "#b18571" },{ lightness: -50 },{ saturation: -500 }]}, 
];

window['classic_styles'] = [
    {featureType: "administrative",elementType: "all", stylers: [{ hue: "#f0e1d2" }, { lightness: 10 }, { saturation: -10 }]}, 
    {featureType: "landscape",elementType: "all",stylers: [{ hue: "#f0e1d2" },{ lightness: 30 },{ saturation: 100 }]}, 
    {featureType: "poi",elementType: "all",stylers: [{ hue: "#f0e1d2" },{ lightness: 70 },{ saturation: -100 }]}, 
    {featureType: "road", elementType: "all",stylers: [{ hue: "#b18571" },{ lightness: -50 },{ saturation: -500 }]}, 
    {featureType: "transit",elementType: "all",stylers: [{ hue: "#f0e1d2" },{ lightness: 70 },{ saturation: -100 }]}, 
    {featureType: "water",elementType: "all",stylers: [{ hue: "#f0e1d2" },{ lightness: 30 },{ saturation: 100 }]}
];
window['pink_styles'] = [
    {featureType: "administrative",elementType: "all", stylers: [{ hue: "blue" }, { lightness: 10 }, { saturation: -10 }]}, 
    {featureType: "landscape",elementType: "all",stylers: [{ hue: "#000000" },{ lightness: 30 },{ saturation: 100 }]}, 
    {featureType: "poi",elementType: "all",stylers: [{ hue: "#FFC0CB" },{ lightness: 70 },{ saturation: -100 }]}, 
    {featureType: "road", elementType: "all",stylers: [{ hue: "#FFC0CB" },{ lightness: 10 },{ saturation: 0 }]}, 
    {featureType: "transit",elementType: "all",stylers: [{ hue: "#FFC0CB" },{ lightness: 70 },{ saturation: -100 }]}, 
    {featureType: "water",elementType: "all",stylers: [{ hue: "#000000" },{ lightness: 30 },{ saturation: -100 }]}
];
window['green_styles'] = [
    {featureType: "administrative",elementType: "all", stylers: [{ hue: "#abceb9" }, { lightness: 0 }, { saturation: -10 }]}, 
    {featureType: "landscape",elementType: "all",stylers: [{ hue: "#abceb9" },{ lightness: 30 },{ saturation: 100 }]}, 
    {featureType: "poi",elementType: "all",stylers: [{ hue: "#abceb9" },{ lightness: 70 },{ saturation: -100 }]}, 
    {featureType: "road", elementType: "all",stylers: [{ hue: "#abceb9" },{ lightness: 70 },{ saturation: -500 }]}, 
    {featureType: "transit",elementType: "all",stylers: [{ hue: "#abceb9" },{ lightness: 70 },{ saturation: -100 }]}, 
    {featureType: "water",elementType: "all",stylers: [{ hue: "#abceb9" },{ lightness: 30 },{ saturation: 100 }]}
];
window['intense_styles'] = [
    {featureType: "administrative",elementType: "all", stylers: [{ hue: "#e65d5d" }, { lightness: 0 }, { saturation: -10 }]}, 
    {featureType: "landscape",elementType: "all",stylers: [{ hue: "#e65d5d" },{ lightness: -20 },{ saturation: 100 }]}, 
    {featureType: "poi",elementType: "all",stylers: [{ hue: "#e65d5d" },{ lightness: 70 },{ saturation: -100 }]}, 
    {featureType: "road", elementType: "all",stylers: [{ hue: "#e65d5d" },{ lightness: 70 },{ saturation: -500 }]}, 
    {featureType: "transit",elementType: "all",stylers: [{ hue: "#e65d5d" },{ lightness: 70 },{ saturation: -100 }]}, 
    {featureType: "water",elementType: "all",stylers: [{ hue: "#e65d5d" },{ lightness: -20 },{ saturation: 100 }]}
];



$(document).on("click", ".app-color-scheme .selector", function () {
    $(".app-color-scheme .selector").removeClass("active");
    $(this).addClass("active");
    var color_style = $(this).attr("data-color");
    initialize(window[color_style]);
});

// Map Script Code
var overlay;

testOverlay.prototype = new google.maps.OverlayView();


function initialize(styles) {
    var map = new google.maps.Map(document.getElementById("map-canvas"), {
        zoom: 5,
        center: {
            lat: 35.76168,
            lng: 100.19179
        },
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        disableDefaultUI: true, // a way to quickly hide all controls
        mapTypeControl: false,
        scaleControl: true,
        zoomControl: true,
        styles: styles,
        draggableCursor: "crosshair"
    });

    map.addListener("click", (event) => {
        map.setCenter(event.latLng);
        console.log(event.latLng.toString());
    });


    var input = (document.getElementById("pac-input"));

    var searchBox = new google.maps.places.SearchBox((input));

    google.maps.event.addListener(searchBox, "places_changed", function () {
        var places = searchBox.getPlaces();
        if (places.length == 0) {
            return;
        }
        map.setCenter(places[0].geometry.location);
        map.setZoom(14);

        document.getElementById("map_title_larger_text").value = document.getElementById("pac-input").value;
        document.getElementsByClassName("za-map-title")[0].innerHTML = document.getElementById("pac-input").value;

        document.getElementById('map_title_smaller_text').value = places[0].geometry.location.lat().toFixed(4)+'°N / '+places[0].geometry.location.lng().toFixed(4)+'°W';
        document.getElementsByClassName("za-map-coordinates")[0].innerHTML = document.getElementById('map_title_smaller_text').value;
    });
}

function testOverlay(map) {
    this.map_ = map;
    this.div_ = null;
    this.setMap(map);
}

testOverlay.prototype.onAdd = function () {
    var div = document.createElement("div");
    this.div_ = div;
    div.style.borderStyle = "none";
    div.style.borderWidth = "0px";
    div.style.position = "absolute";
    div.style.left = -window.innerWidth / 2 + "px";
    div.style.top = -window.innerHeight / 2 + "px";
    div.width = window.innerWidth;
    div.height = window.innerHeight;

    const canvas = document.createElement("canvas");
    canvas.style.position = "absolute";
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    div.appendChild(canvas);

    const panes = this.getPanes();
    panes.overlayLayer.appendChild(div);

    var ctx = canvas.getContext("2d");
    this.drawLine(ctx, 0, "rgba(0, 0, 0, 0.2)");
    this.drawLine(ctx, 90, "rgba(0, 0, 0, 0.2)");
    this.drawLine(ctx, 37.5, "rgba(255, 0, 0, 0.4)");
    this.drawLine(ctx, 67.5, "rgba(255, 0, 0, 0.4)");
};

testOverlay.prototype.drawLine = function (ctx, degrees, style) {
    // 0 north, growing clockwise
    const w = window.innerWidth / 2;
    const h = window.innerHeight / 2;
    const radians = ((90 - degrees) * Math.PI) / 180;
    const hlen = Math.min(w, h);
    const x = Math.cos(radians) * hlen;
    const y = -Math.sin(radians) * hlen;
    ctx.beginPath();
    ctx.strokeStyle = style;
    ctx.moveTo(w - x, h - y);
    ctx.lineTo(w + x, h + y);
    ctx.stroke();
};

testOverlay.prototype.onRemove = function () {
    this.div_.parentNode.removeChild(this.div_);
    this.div_ = null;
};



google.maps.event.addDomListener(window, "load", initialize(window['atlas_styles']));