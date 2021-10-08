<?php

  include 'config.php';

// inspect IPN validation result and act accordingly

if (strcmp ($res, "VERIFIED") == 0) {

// STEP 1: read POST data

// Reading POSTed data directly from $_POST causes serialization issues with array data in the POST.
// Instead, read raw POST data from the input stream. 
$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$myPost = array();
foreach ($raw_post_array as $keyval) {
  $keyval = explode ('=', $keyval);
  if (count($keyval) == 2)
     $myPost[$keyval[0]] = urldecode($keyval[1]);
}
// read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
$req = 'cmd=_notify-validate';
if(function_exists('get_magic_quotes_gpc')) {
   $get_magic_quotes_exists = true;
} 
foreach ($myPost as $key => $value) {        
   if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) { 
        $value = urlencode(stripslashes($value)); 
   } else {
        $value = urlencode($value);
   }
   $req .= "&$key=$value";
}

 
// Step 2: POST IPN data back to PayPal to validate

$ch = curl_init('https://www.paypal.com/cgi-bin/webscr');
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

// In wamp-like environments that do not come bundled with root authority certificates,
// please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set 
// the directory path of the certificate as shown below:
// curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
if( !($res = curl_exec($ch)) ) {
    // error_log("Got " . curl_error($ch) . " when processing IPN data");
    curl_close($ch);
    exit;
}
curl_close($ch);

    // assign posted variables to local variables
    $item_name = $_POST['item_name'];
    $item_number = $_POST['item_number'];
    $payment_status = $_POST['payment_status'];
    $payment_amount = $_POST['mc_gross'];
    $payment_currency = $_POST['mc_currency'];
    $txn_id = $_POST['txn_id'];
    $receiver_email = $_POST['receiver_email'];
    $payer_email = $_POST['payer_email'];

    // IPN message values depend upon the type of notification sent.
    // To loop through the &_POST array and print the NV pairs to the screen:
    foreach($_POST as $key => $value) {
      echo $key." = ". $value."<br>";
    }

    date_default_timezone_set('Europe/Madrid');
    $coldate = date('Y-m-d H:i:s');
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email']; 
    $phone = $_POST['night_phone_c'];   
    $flightnumber = $_POST['custom'];    
    $service = $_POST['item_name'];     
    $price = $_POST['amount'];     
    $origin = $_POST['origin'];     
    $destination = $_POST['destination'];     
    $pickupdate = $_POST['pickupdate'];     
    $pickuptime = $_POST['pickuptime'];     
    $returndate = $_POST['returndate'];     
    $returntime = $_POST['returntime'];

    $req = $bdd->prepare('INSERT INTO transfers_booking (coldate,first_name,last_name,pickupdate,pickuptime,flightnumber,email,phone,service,origin,destination,returndate,returntime,price) 
        VALUES (:coldate,:first_name,:last_name,:pickupdate,:pickuptime,:flightnumber,:email,:phone,:service,:origin,:destination,:returndate,:returntime,:price)');
      $req->execute(array(
        'coldate'=>$coldate,
        'first_name'=>$first_name,
        'last_name'=>$last_name,
        'pickupdate'=>$pickupdate,
        'pickuptime'=>$pickuptime,
        'flightnumber'=>$flightnumber,
        'email'=>$email,
        'phone'=>$phone,
        'service'=>$service,
        'origin'=>$origin,
        'destination'=>$destination,
        'returndate'=>$returndate,
        'returntime'=>$returntime,
        'price'=>$price,
        
      ));
      $req->closeCursor()

    } else if (strcmp ($res, "INVALID") == 0) {
    // IPN invalid, log for manual investigation
    echo "The response from IPN was: <b>" .$res ."</b>";
}
?>