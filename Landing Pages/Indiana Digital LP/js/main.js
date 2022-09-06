$(document).ready(function(){
    $(".za-select-multiple .za-select-label").click(function(){
        var curnt = $(this);
        curnt.parents(".za-select-multiple").find(".za-select-options").toggleClass('za-select-multiple-show');
    }); 
    $(".za-select-all-option input").click(function(){
        var curnt = $(this);
        if( ( curnt.parents(".za-select-multiple").hasClass("shown") ) ){
            curnt.parents(".za-select-multiple").find(".za-select-option input").prop( "checked", false );
        }else{
            curnt.parents(".za-select-multiple").find(".za-select-option input").prop( "checked", true );
        }
        curnt.parents(".za-select-multiple").toggleClass("shown");
    })
});