<!doctype html>
<html>
<head>
<title>Google Maps Directions API</title>
</head>
<body>

	<h2>Directions from &ldquo;Guildford, Surrey&rdquo; to &ldquo;Embankment, London&rdquo;</h2>

	<?php
	// Our parameters
	$params = array(
		'origin'		=> 'Guildford, Surrey',
		'destination'	=> 'Embankment, London',
		'sensor'		=> 'true',
		'units'			=> 'imperial'
	);
	
	// Join parameters into URL string
	foreach($params as $var => $val){
   		$params_string .= '&' . $var . '=' . urlencode($val);  
	}
	
	// Request URL
	$url = "http://maps.googleapis.com/maps/api/directions/json?".ltrim($params_string, '&');
	
	// Make our API request
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$return = curl_exec($curl);
	curl_close($curl);
	
	// Parse the JSON response
	$directions = json_decode($return);
	
	// Show the total distance
	print('<p><strong>Total distance:</strong> ' . $directions->routes[0]->legs[0]->distance->text . '</p>');
	
	// Loop through each step
	print('<ol>');
	foreach($directions->routes[0]->legs[0]->steps as $step) {
		print('<li>'.$step->html_instructions.'</li>');
	}
	print('</ol>');
	?>
    
</body>
</html>