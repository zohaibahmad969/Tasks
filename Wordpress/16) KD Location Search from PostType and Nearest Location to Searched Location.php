First PHP code for ajax functions for getting locations posts
Then Script code for search functionality


<?php

// Locations Page Code

add_action('wp_ajax_get_locations_page_data', 'get_locations_page_data');
add_action('wp_ajax_nopriv_get_locations_page_data', 'get_locations_page_data');

function get_locations_page_data() {


    // Sanitize input values
    $postcodeSearch = sanitize_text_field($_GET['search']);
    $citySearch = sanitize_text_field($_GET['city']);
    $view = sanitize_text_field($_GET['view']);
    $post_per_page = 10;
   
   
    if($view === 'View List' ){
        $post_per_page = -1;
    }
    
    // Initialize common arguments
    $args = array(
        'post_type' => 'location',
        'posts_per_page' => $post_per_page,
        'orderby' => 'title',
        'order' => 'ASC',
    );
    

    // Initialize the tax_query array
    $tax_query = array();

    if (!empty($citySearch)) {
        $tax_query[] = array(
            'taxonomy' => 'area_zones',
            'field' => 'slug',
            'terms' => array($citySearch),
        );
    }

    if (!empty($postcodeSearch)) {
        $tax_query[] = array(
            'taxonomy' => 'area',
            'field' => 'slug',
            'terms' => array($postcodeSearch),
        );
    }

    // Check if there are any tax queries
    if (!empty($tax_query)) {
        // Set the relation based on whether both or either parameter is provided
        $args['tax_query']['relation'] = (count($tax_query) > 1) ? 'AND' : 'OR';
        $args['tax_query'] = $tax_query;
    }

    $location_query = new WP_Query($args);
    
    // Start output buffering
    ob_start();
    
    $mapLocationsData = array();

    // Check if there are posts
    if ($location_query->have_posts()) {
        if ($view === 'View List') {
            // Output for the list view
            echo '<div class="view-list">';
            echo '<div class="row loc-row list-locations-data">';
            while ($location_query->have_posts()) {
                $location_query->the_post();
                
                $mapLocationsData[] = array(
                    'name' => strtolower(str_replace(' ', '-', get_the_title())),
                    'lat' => get_field('latitude', get_the_ID()),
                    'lng' => get_field('longitude', get_the_ID()),
                    'description' => get_the_title(), 
                );
                
                // Output your HTML content for list view here
                get_template_part('template-parts/list', 'content'); // Replace with your template part's location
            }
            echo '</div>';
            echo '</div>';
        } else {
            
            
            // Output for the map view
            echo '<div class="view-map">';
            echo '<div class="row">';
            echo '<div class="posts-order col-12 col-md-3">';
            echo '<div class="row loc-row">';
            while ($location_query->have_posts()) {
                $location_query->the_post();
                
                $mapLocationsData[] = array(
                    'id'   => 'location_' . get_the_ID(),
                    'name' => strtolower(str_replace(' ', '-', get_the_title())),
                    'lat' => get_field('latitude', get_the_ID()),
                    'lng' => get_field('longitude', get_the_ID()),
                    'description' => get_the_title(), 
                );
                
                // Output your HTML content for map view here
                get_template_part('template-parts/map', 'content'); // Replace with your template part's location
            }
            echo '</div>';
            echo '</div>';
            echo '<div class="map-only col-12 col-md-9">';
            echo '<div id="locationsMap" class="locations-map"></div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        wp_reset_postdata(); // Restore the global post data
    } else {
        if ($view === 'View List') {
            // Output for the list view
            echo '<div class="view-list">';
            echo '<div class="row loc-row list-locations-data">';
            // echo "No locations found.";
            echo '</div>';
            echo '</div>';
        } else {
            // Output for the map view
            echo '<div class="view-map">';
            echo '<div class="row">';
            echo '<div class="posts-order col-12 col-md-3">';
            echo '<div class="row loc-row list-locations-data">';
            // echo "No locations found.";
            echo '</div>';
            echo '</div>';
            echo '<div class="map-only col-12 col-md-9">';
            echo '<div id="locationsMap" class="locations-map"></div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        
    }
    
    // Get the buffered output
    $html_output = ob_get_clean();

    $response = array(
        'html_content' => $html_output,
        'map_location_data' => $mapLocationsData
    );
    
    // Encode the array as JSON
    echo json_encode($response);
    
   wp_die();
}




// Nearest Locations Boxes html code

add_action('wp_ajax_get_nearest_locations_boxes_for_map_view', 'get_nearest_locations_boxes_for_map_view');
add_action('wp_ajax_nopriv_get_nearest_locations_boxes_for_map_view', 'get_nearest_locations_boxes_for_map_view');

function get_nearest_locations_boxes_for_map_view() {


      // Get the location IDs from the AJAX request
      $location_ids = $_GET['location_ids'];
    
      // Query posts by the provided location IDs
      $args = array(
        'post_type' => 'location', // Change this to your custom post type if needed
        'post_status' => 'publish',
        'posts_per_page' => -1, // To fetch all posts
        'post__in' => $location_ids,
        'orderby' => 'post__in',
        'order' => 'ASC',
      );
    
      $location_query = new WP_Query($args);
        
    // Start output buffering
    ob_start();
    
      // Output posts
      if ($location_query->have_posts()) :
        while ($location_query->have_posts()) :
          $location_query->the_post();
          $mapLocationsData[] = array(
            'id'   => 'location_' . get_the_ID(),
            'name' => strtolower(str_replace(' ', '-', get_the_title())),
            'lat' => get_field('latitude', get_the_ID()),
            'lng' => get_field('longitude', get_the_ID()),
            'description' => get_the_title(), 
           );
          // Output your HTML content for each post here
          get_template_part('template-parts/map', 'content'); // Replace with your template part's location
        endwhile;
        wp_reset_postdata();
      else :
        echo 'No posts found';
      endif;
      
      // Get the buffered output
    $html_output = ob_get_clean();
    
    $response = array(
        'html_content' => $html_output,
        'map_location_data' => $mapLocationsData
    );
    
    // Encode the array as JSON
    echo json_encode($response);
    
      die(); // Always end with die() in an AJAX action

    
}


add_action('wp_ajax_get_locations_posttype_data', 'get_locations_posttype_data'); // For logged-in users
add_action('wp_ajax_nopriv_get_locations_posttype_data', 'get_locations_posttype_data'); // For non-logged-in users
function get_locations_posttype_data() {
    
    $searched_postalcode = $_GET['search'];
    
    $locations = array();
    
    $args = array(
        'post_type' => 'location',
        'posts_per_page' => -1, // Retrieve all posts of the 'location' custom post type
        'tax_query' => array(
            array(
                'taxonomy' => 'area', 
                'field'    => 'slug',
                'terms'    => $searched_postalcode, 
                'operator' => 'NOT IN', 
            ),
        ),
    );

    $location_query = new WP_Query($args);

    if ($location_query->have_posts()) {
        while ($location_query->have_posts()) {
            $location_query->the_post();

            $location = array(
                'id'   => get_the_ID(),
                'name' => get_the_title(), // Replace with your ACF field name for the name
                'lat'  => get_field('latitude'), // Replace with your ACF field name for latitude
                'lng'  => get_field('longitude'), // Replace with your ACF field name for longitude
            );

            $locations[] = $location;
        }
    }

    wp_reset_postdata();

    echo json_encode($locations);
    wp_die();
}

?>

<script>
  jQuery(document).ready(function ($) {
    
      // Get Locations on Page Load
      get_locations_data("", "", "View Map");
      
      // Clear the search field on AreaZone Change
      $("form#location-form-list .city-box").change(function(){
          $("form#location-form-list .search-box").val('');
      })
    
      // Location Search Form Submission
      $("#location-form-list").submit(function (e) {
        e.preventDefault();
    
        $("#locations_data").html(
          '<div class="text-center"><img src="/wp-content/uploads/2024/05/03-05-45-320_512.webp" width="300px"></div>'
        );
    
        let crnt = $(this);
        let searchValue = crnt.find(".search-box").val();
        let cityValue = crnt.find(".city-box").val();
        let viewValue = "View Map";
    
        // If search is via Postal Code then reset area
        if (searchValue !== "") {
          crnt.find(".city-box").val("");
          cityValue = "";
        }
    
        // Call the AJAX function with the form values
        get_locations_data(searchValue, cityValue, "View Map");
      });
    });
    
    function get_locations_data(searchValue, cityValue, viewValue) {
      jQuery.ajax({
        type: "GET",
        url: website_js_data.ajax_url,
        data: {
          action: "get_locations_page_data",
          search: searchValue,
          city: cityValue,
          view: viewValue,
        },
        success: function (response) {
          // Handle the AJAX response here
    
          response = JSON.parse(response);
          var locationsHTMLMain = response.html_content;
          var locationDataMain = response.map_location_data;
    
          if (viewValue === "View Map") {
            // Get nearest locations if postal code is searched
            if (searchValue !== "") {
              jQuery.ajax({
                type: "GET",
                url: website_js_data.ajax_url,
                data: {
                  action: "get_locations_posttype_data",
                  search: searchValue,
                },
                success: async function (response) {
                  // Handle the AJAX response here
                  const locations = JSON.parse(response);
    
                  getNearestLocations(locations, searchValue)
                    .then(function (result) {
                      jQuery("#locations_data").html(locationsHTMLMain);
                      jQuery(".view-map .posts-order > .row").append(
                        result.nearestLocationsHtmlData
                      );
    
                      let locationData = locationDataMain.concat(
                        result.nearestLocationsData
                      );
                      console.log(locationData);
                      showLocationsOnMap(locationData);
                    })
                    .catch(function (error) {
                      // Handle errors here
                      console.error(error);
                    });
                },
              });
            } else {
              // Search by AreaZone
              jQuery("#locations_data").html(locationsHTMLMain);
              showLocationsOnMap(locationDataMain);
            }
          } else if (viewValue === "View List") {
            // View List
          }
        },
      });
    }
    
    async function getNearestLocations(locations, searchValue) {
      try {
        const apiKey = "AIzaSyCBjAy-5XEyzfzmvWMVBHlR7pZ3PLp38Bk"; // Replace with your Google Maps API key
    
        // Get Coordinates
        const url = `https://maps.googleapis.com/maps/api/geocode/json?address=${searchValue}&key=${apiKey}`;
        const mapsresponse = await fetch(url);
        const mapsresponsedata = await mapsresponse.json();
        if (
          mapsresponsedata.status === "OK" &&
          mapsresponsedata.results.length > 0
        ) {
          const location = mapsresponsedata.results[0].geometry.location;
          userLocation = { lat: location.lat, lng: location.lng };
        }
        if (userLocation) {
          // Calculate distances and find nearest locations
          var nearestLocations = locations.map((location) => {
            const earthRadius = 6371; // Radius of the Earth in kilometers
            const dLat = (location.lat - userLocation.lat) * (Math.PI / 180);
            const dLon = (location.lng - userLocation.lng) * (Math.PI / 180);
            const a =
              Math.sin(dLat / 2) * Math.sin(dLat / 2) +
              Math.cos(userLocation.lat * (Math.PI / 180)) *
                Math.cos(location.lat * (Math.PI / 180)) *
                Math.sin(dLon / 2) *
                Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            const distance = earthRadius * c;
            return { id: location.id, name: location.name, distance };
          });
    
          // Sort by distance
          nearestLocations.sort((a, b) => a.distance - b.distance);
    
          nearestLocations = nearestLocations.slice(0, 5);
    
          // Display the nearest locations
          const infos = nearestLocations.map(
            (location) =>
              `${location.name}, Distance: ${location.distance.toFixed(2)} km\n`
          );
          console.log(infos.join(""));
    
          const nearestLocationIds = nearestLocations.map(
            (location) => location.id
          );
    
          return new Promise(function (resolve, reject) {
            jQuery.ajax({
              type: "GET",
              url: website_js_data.ajax_url,
              data: {
                action: "get_nearest_locations_boxes_for_map_view",
                location_ids: nearestLocationIds,
              },
              success: function (response) {
                response = JSON.parse(response);
    
                const nearestLocationsHtmlData = response.html_content;
                const nearestLocationsData = response.map_location_data;
    
                // Resolve the Promise with an object containing both data
                resolve({
                  nearestLocationsHtmlData: nearestLocationsHtmlData,
                  nearestLocationsData: nearestLocationsData,
                });
              },
              error: function (xhr, status, error) {
                reject(error); // You can handle errors here
              },
            });
          });
        } else {
          console.log("Error fetching user location.");
        }
      } catch (error) {
        console.error("Error:", error);
      }
    }
    
    function showLocationsOnMap(locationData) {
      var markers = [];
      var infowindow = new google.maps.InfoWindow();
      var bounds = new google.maps.LatLngBounds();
      var map = new google.maps.Map(document.getElementById("locationsMap"), {
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        disableDefaultUI: true,
        zoomControl: true,
        streetViewControl: false,
        mapTypeControl: false,
      });
    
      // Showing all locations on Map
    
      for (var i = 0; i < locationData.length; i++) {
        var location = locationData[i];
        var marker = new google.maps.Marker({
          position: new google.maps.LatLng(location.lat, location.lng),
          map: map,
        });
        markers.push(marker);
        bounds.extend(marker.position);
    
        google.maps.event.addListener(
          marker,
          "click",
          (function (marker, i) {
            return function () {
              infowindow.setContent(locationData[i].description);
              infowindow.open(map, marker);
            };
          })(marker, i)
        );
      }
    
      map.fitBounds(bounds);
    
      var listener = google.maps.event.addListener(map, "idle", function () {
        google.maps.event.removeListener(listener);
    
        // Call a function to show/hide location cards based on marker visibility
        var visibleBounds = map.getBounds();
    
        for (var i = 0; i < markers.length; i++) {
          var marker = markers[i];
          var location = locationData[i];
          var card = document.getElementById(location.id);
    
          card.style.display = "none"; // Hide all cards by default
    
          if (visibleBounds.contains(marker.getPosition())) {
            card.style.display = "block"; // Show the card if the marker is visible
          }
        }
      });
    
      google.maps.event.addListener(map, "bounds_changed", function () {
        visibleBounds = map.getBounds();
    
        for (var i = 0; i < markers.length; i++) {
          var marker = markers[i];
          var location = locationData[i];
          var card = document.getElementById(location.id);
    
          card.style.display = "none"; // Hide all cards by default
    
          if (visibleBounds.contains(marker.getPosition())) {
            card.style.display = "block"; // Show the card if the marker is visible
          }
        }
      });
    }
</script>
