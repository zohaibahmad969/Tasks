<?php

function show_quotes_fn(){

	
	for ($i=0; $i < 5; $i++) { 
	
		$url='https://api.kanye.rest/';	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL,$url);
		$result=curl_exec($ch);
		curl_close($ch);
		$result = json_decode($result, true);
		
		foreach ($result as $key => $value) {
			echo $key . ' - ' . $value . '<br>';
		}
	}

}
add_shortcode( 'show_quotes' , 'show_quotes_fn');