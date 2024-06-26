/* Javascript */

jQuery(document).ready(function($) {
    
    $(".za-services-tabs .e-loop-item").click(function(){
        // Get the element by its class
        var $element = $(this);

        // Extract the classes as an array
        var classesArray = $element.attr('class').split(' ');

        // Find the class that starts with 'e-loop-item-'
        var targetClass = classesArray.find(function(cls) {
            return cls.startsWith('e-loop-item-');
        });

        // Log the target class
        console.log(targetClass);  // Output: e-loop-item-362

        // Use the target class for further processing if needed
        if (targetClass) {
            // Example: Add a new class
            
            $(".za-services-tabs .e-loop-item .elementor-heading-title").css("color","var( --e-global-color-primary )");
            $(".za-services-tabs ."+targetClass +" .elementor-heading-title").css("color","black")
            
            $(".za-services-tabs-content .e-loop-item").hide();
            $(".za-services-tabs-content ."+targetClass).show();
        }
    })
});
