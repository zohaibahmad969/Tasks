<?php
// ********************************************************************** ACF MAP API KEY (for admin area)
function my_acf_init() {
	acf_update_setting('google_api_key', 'AIzaSyCQmi3F5fElrNJPdJa_Cg9LALsag59lO0g');
}
add_action('acf/init', 'my_acf_init');



function rdsn_map_code() {
?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCQmi3F5fElrNJPdJa_Cg9LALsag59lO0g"></script>
<script type="text/javascript">
(function($) {

// Render a Google Map onto the selected jQuery element

function new_map( $el ) {	
	// var
	var $markers = $el.find('.marker');
	// vars
	var args = {
		zoom		: 16,
		center		: new google.maps.LatLng(0, 0),
		mapTypeId	: google.maps.MapTypeId.ROADMAP,
		mapTypeControl: false
	};
	// create map	        	
	var map = new google.maps.Map( $el[0], args);		
	// add a markers reference
	map.markers = [];	
	// add markers
	$markers.each(function(){		
    	add_marker( $(this), map );		
	});	
	// center map
	center_map( map );	
	// return
	return map;	
}

// add a marker to the selected Google Map
function add_marker( $marker, map ) {
	// var
	var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );
	// create marker	
	/*var pinIcon = new google.maps.MarkerImage(
		'<?php //echo get_template_directory_uri(); ?>/assets/img/map-icon.png',
		null, // size is determined at runtime
		null, // origin is 0,0
		new google.maps.Point(14, 44), //null, anchor is bottom center of the scaled image
		new google.maps.Size(28, 44)
	);*/
	var marker = new MarkerWithLabel({
	   position		: latlng,
       map			: map,
	   <?php
		$map_marker = get_field('google_map_label');
		//if ($map_marker):
			echo 'labelAnchor : new google.maps.Point(50,50),';
			echo 'labelClass : "map-label",';
			echo 'labelContent : "<div>'.$map_marker.'</div>",';
		//else:
			//echo 'icon : pinIcon,';
		//endif;
		?>
	});
	 
	 
	/*map.set("styles", [
	  {
		elementType: "geometry",
		stylers: [
		  {
			color: "#777777"  //
		  }
		]
	  },
	  {
		elementType: "geometry.fill",
		stylers: [
		  {
			color: "#4B4C4E"  // 001328
		  }
		]
	  },
	  {
		elementType: "labels.icon",
		stylers: [
		  {
			visibility: "off"
		  }
		]
	  },
	  {
		elementType: "labels.text.fill",
		stylers: [
		  {
			color: "#757575"
		  }
		]
	  },
	  {
		elementType: "labels.text.stroke",
		stylers: [
		  {
			color: "#444444"
		  }
		]
	  },
	  {
		featureType: "administrative",
		elementType: "geometry",
		stylers: [
		  {
			color: "#757575"
		  }
		]
	  },
	  {
		featureType: "administrative.country",
		elementType: "labels.text.fill",
		stylers: [
		  {
			color: "#9e9e9e"
		  }
		]
	  },
	  {
		featureType: "administrative.land_parcel",
		stylers: [
		  {
			visibility: "off"
		  }
		]
	  },
	  {
		featureType: "administrative.locality",
		elementType: "labels.text.fill",
		stylers: [
		  {
			color: "#bdbdbd"
		  }
		]
	  },
	  {
		featureType: "poi",
		elementType: "labels.text.fill",
		stylers: [
		  {
			color: "#757575"
		  }
		]
	  },
	  {
		featureType: "poi.park",
		elementType: "geometry",
		stylers: [
		  {
			color: "#505500"
		  }
		]
	  },
	  {
		featureType: "poi.park",
		elementType: "labels.text.fill",
		stylers: [
		  {
			color: "#777777"
		  }
		]
	  },
	  {
		featureType: "poi.park",
		elementType: "labels.text.stroke",
		stylers: [
		  {
			color: "#505500"
		  }
		]
	  },
	  {
		featureType: "road",
		elementType: "geometry.fill",
		stylers: [
		  {
			color: "#777777"  //2c2c2c
		  }
		]
	  },
	  {
		featureType: "road",
		elementType: "labels.text.fill",
		stylers: [
		  {
			color: "#CCCCCC"
		  }
		]
	  },
	  {
		featureType: "road.arterial",
		elementType: "geometry",
		stylers: [
		  {
			color: "#777777"
		  }
		]
	  },
	  {
		featureType: "road.highway",
		elementType: "geometry",
		stylers: [
		  {
			color: "#777777"
		  }
		]
	  },
	  {
		featureType: "road.highway.controlled_access",
		elementType: "geometry",
		stylers: [
		  {
			color: "#4e4e4e"
		  }
		]
	  },
	  {
		featureType: "road.local",
		elementType: "labels.text.fill",
		stylers: [
		  {
			color: "#999999"
		  }
		]
	  },
	  {
		featureType: "transit",
		elementType: "labels.text.fill",
		stylers: [
		  {
			color: "#757575"
		  }
		]
	  },
	  {
		featureType: "water",
		elementType: "geometry",
		stylers: [
		  {
			color: "#5E8796"
		  }
		]
	  },
	  {
		featureType: "water",
		elementType: "labels.text.fill",
		stylers: [
		  {
			color: "#3d3d3d"
		  }
		]
	  }
	]);*/
	  

	// add to array
	map.markers.push( marker );
	// if marker contains HTML, add it to an infoWindow
	if( $marker.html() )
	{
		// create info window
		var infowindow = new google.maps.InfoWindow({
			content		: $marker.html()
		});
		// show info window when marker is clicked
		google.maps.event.addListener(marker, 'click', function() {
			infowindow.open( map, marker );
		});
	}
}

// center the map, showing all markers attached to this map
function center_map( map ) {
	// vars
	var bounds = new google.maps.LatLngBounds();
	// loop through all markers and create bounds
	$.each( map.markers, function( i, marker ){
		var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );
		bounds.extend( latlng );
	});
	// only 1 marker?
	if( map.markers.length == 1 )
	{
		// set center of map
	    map.setCenter( bounds.getCenter() );
	    map.setZoom( 16 );
	}
	else
	{
		// fit to bounds
		map.fitBounds( bounds );
	}
}

// render each map when the document is ready (page has loaded)
// global var
var map = null;

$(document).ready(function(){
	$('.acf-map').each(function(){
		// create map
		map = new_map( $(this) );
	});
});

})(jQuery);
</script>

<?php
}


// ********************************************************************** ACF MAP - MULTIPLE CUSTOM MARKERS
function rdsn_map() {
$location = get_field('google_map');
if(!empty($location)):
rdsn_map_code();
	echo '<div class="acf-map border-box">';
		echo '<div class="marker" data-lat="'.$location['lat'].'" data-lng="'.$location['lng'].'"></div>';
	echo '</div>';
endif;	
echo '<script type="text/javascript" src="'.get_template_directory_uri().'/assets/js/markerwithlabel.js"></script>';
}


?>