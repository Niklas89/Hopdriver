

<html>

<head>
	<meta content="text/html;charset=UTF-8" http-equiv="content-type">
	<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css">
	<link href="css/jquery.tagit.css" rel="stylesheet" type="text/css">	
</head>

<body>


                                        <?php ?>

	<!--<p>This geotag demo uses the <strong>jQuery tag-it</strong> control and <strong>Google's AutocompleteService API</strong>.</p>
			https://github.com/aehlke/tag-it
			http://stackoverflow.com/questions/21749924/jquery-tag-it-allow-tags-only-from-autocomplete-source
			http://crosscuttingconcerns.com/Autocomplete-multi-select-of-Geographical-Places
			http://stackoverflow.com/questions/3314567/how-to-get-form-input-array-into-php-array
			http://php.net/manual/en/faq.html.php
			http://php.net/manual/fr/function.array.php
			Thank you for this wonderful plugin! How do you put each tag into a PHP variable to insert it into a database? Each tag would be inserted into an array like his:
$tags= array( 'Paris,France', 'Ontario, Canada', 'Springfield, IL; United States');
And we would have to separete them by category. Tags that are cities are stored inside a "city" array and those that are regions in a "region" array and countries in a "country" array. 
$tags= array (
    "city"  => array("Paris, France", "London, UK", "New York, United States"),
    "region" => array("Ile-de-France, France", "Normandie, France", "Skåne, Sweden"),
    "country"   => array("France", "United States", "Germany", "Belgium", "Sweden")
);
Do you how know how this could be made?
		-->

	<form action="indexphp.php" method="post">
	<ul id="courseLocation">
	</ul>
	

	<input type="submit" id="submit-button" name="tag"  value="Submit" />
	
<!-- Google "php make an array from input values"-->
	<ul id="result-list">
		<?php

// http://api.jquery.com/jquery.post/
	// http://www.kodingmadesimple.com/2014/12/how-to-insert-json-data-into-mysql-php.html
	// http://stackoverflow.com/questions/8893574/php-php-input-vs-post
	// http://stackoverflow.com/questions/18866571/receive-json-post-with-php
	// https://www.zulius.com/how-to/send-multidimensional-arrays-php-with-jquery-ajax/
	// http://www.developpez.net/forums/d1566479/webmasters-developpement-web/javascript-ajax-typescript-dart/ajax/autocomplete-tags-google-places-json-ajax-php/#post8519397
	// http://textextjs.com/manual/examples/autocomplete-with-tags.html


                          if(!empty($_POST['tags'])) {

                              foreach($_POST['tags'] as $tag) {

                                        // GET CITY, DEPARTEMENT, REGION OR COUNTRY FROM ADDRESS OR CITY OR COUNTRY OR WHATEVER  $url = "http://maps.google.com/maps/api/geocode/json?address=$address&components=country:FR&language=fr";//
                                            $address = str_replace(" ", "+", "$tag");
                                            $url = "http://maps.google.com/maps/api/geocode/json?address=$address&components&language=fr";
                                            $result = file_get_contents("$url");
                                            $json = json_decode($result);
                                            foreach ($json->results as $result) {
                                                foreach($result->address_components as $addressPart) {
                                                  if((in_array('locality', $addressPart->types)) && (in_array('political', $addressPart->types)))
                                                  $city = $addressPart->long_name;
                                                    else if((in_array('administrative_area_level_2', $addressPart->types)) && (in_array('political', $addressPart->types)))
                                                  $dept = $addressPart->long_name;
                                                    else if((in_array('administrative_area_level_1', $addressPart->types)) && (in_array('political', $addressPart->types)))
                                                  $state = $addressPart->short_name;
                                                    else if((in_array('country', $addressPart->types)) && (in_array('political', $addressPart->types)))
                                                  $country = $addressPart->short_name;
                                                }
                                            }

                                            if((!empty($city)) && (!empty($dept)) && (!empty($state)) && (!empty($country))) {
                                                $address = $city.'(city), '.$dept.'(dept), '.$state.'(state), '.$country.'(country)'; 
                                                echo $address;
                                                $city = '';
                                                $dept = '';
                                                $state = '';
                                                $country = '';
                                                 }
                                            else if((!empty($city)) && (!empty($state)) && (!empty($country)) && (empty($dept))) {
                                                $address = $city.'(city), '.$state.'(state), '.$country.'(country)'; 
                                                echo $address; 
                                                $city = '';
                                                $state = '';
                                                $country = '';
                                            }
                                            else if((!empty($city)) && (!empty($dept)) && (!empty($country)) && (empty($state))) {
                                                $address = $city.'(city), '.$dept.'(dept), '.$country.'(country)'; 
                                                echo $address; 
                                                $city = '';
                                                $dept = '';
                                                $country = '';
                                            }
                                            else if((!empty($city)) && (!empty($dept)) && (empty($state)) && (empty($country))) {
                                                $address = $city.'(city), '.$dept.'(dept)'; 
                                                echo $address; 
                                                $city = '';
                                                $dept = '';

                                            }
                                            else if((!empty($city)) && (!empty($state)) && (empty($dept)) && (empty($country))) {
                                                $address = $city.'(city), '.$state.'(state)'; 
                                                echo $address; 
                                                $city = '';
                                                $state = '';

                                            }
                                            else if((!empty($city)) && (!empty($country)) && (empty($dept)) && (empty($state))) {
                                                $address = $city.'(city), '.$country.'(country)'; 
                                                echo $address; 
                                                $city = '';
                                                $country = '';

                                            }
                                            else if((!empty($dept)) &&(!empty($state)) && (!empty($country)) && (empty($city))) {
                                                $address = $dept.'(dept), '.$state.'(state), '.$country.'(country)'; 
                                                echo $address;
                                                $dept = '';
                                                $state = '';
                                                $country = '';
                                            }
                                            else if((!empty($dept)) && (!empty($state)) && (empty($ci)) && (empty($coun))) {
                                                $address = $dept.'(dept), '.$state.'(state)'; 
                                                echo $address;
                                                $dept = '';
                                                $state = '';
                                            }
                                            else if((!empty($dept)) && (!empty($country)) && (empty($city)) && (empty($state))) {
                                                $address = $dept.'(dept), '.$country.'(country)'; 
                                                echo $address;
                                                $dept = '';
                                                $country = '';
                                            }
                                            else if((!empty($state)) && (!empty($country)) && (empty($city)) && (empty($dept))) {
                                                $address = $state.'(state), '.$country.'(country)'; 
                                                echo $address;
                                                $state = '';
                                                $country = '';
                                            }
                                            else if(!empty($country) && (empty($city)) && (empty($dept)) && (empty($state))) {
                                                $address = $country.'(country)'; 
                                                echo $address;
                                                $country = '';
                                             }
                                                echo '<br />';
                                                
                                        
                              }
                          }



?>

	</ul>
	</form>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/tag-it.min.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=places&language=fr"></script>	
	<script type="text/javascript"><!-- http://maps.googleapis.com/maps/api/js?libraries=places&region=FR&language=fr -->
		$(document).ready(function() {
			$("#courseLocation").tagit({
				allowSpaces: true,
				autocomplete: {
					delay: 0,
					minLength: 2,
					source: function(request, response) {
						var callback = function (predictions, status) {
							if (status != google.maps.places.PlacesServiceStatus.OK) {
								return;
							}					
							var data = $.map(predictions, function(item) {
								return item.description;
							});
							response(data);
						}		
						var service = new google.maps.places.AutocompleteService();
						service.getQueryPredictions({ input: request.term }, callback);
					}
				}
			});
		});
	</script>
</body>

</html>