<?php

if (!empty($_POST["drop_off_date"]) && !empty($_POST["drop_off_time"]) ) {




                  $clientid = $_SESSION['id'];

                  date_default_timezone_set('Europe/Madrid');
                $coldate = date('Y-m-d H:i:s');
                if (!empty($first_name)) { $first_name = $first_name; } else { $first_name = $_POST['first_name']; }
                if (!empty($last_name)) { $last_name = $last_name; } else { $last_name = $_POST['last_name']; }
                if (!empty($email)) { $email = $email; } else { $email = $_POST['email']; }
                if (!empty($phone)) { $phone = $phone; } else { $phone = $_POST['night_phone_c']; }
                $flightnumber = $_POST['custom'];
                $service = $_POST['item_name'];

                if (isset($_POST["vehicle"])) { $vehicle = $_POST['vehicle']; } else { $vehicle = " "; }
                $price = $_POST['amount'];
                $pick_up_loc = $_POST['pick_up_loc'];
                $drop_off_loc = $_POST['drop_off_loc'];
                $pickupdate = $_POST['pickupdate'];
                $pickuptime = $_POST['pickuptime'];
                $hoursday = $_POST['hoursday'];
                $drop_off_date = $_POST['drop_off_date'];
                $drop_off_time = $_POST['drop_off_time'];
                $driverid = $_POST['chauffeursid'];
                /*$return = $_POST['return'];
                if (!empty($_POST["promo"])) {
                  $promo = $_POST['promo'];
                  if ($promo == "vok34Prom") { $price = $price*0.85; }
                }  else { $promo = ""; }*/
                if (!empty($_POST["comments"])) { $comments = $_POST['comments']; } else { $comments = ""; }

                $req = $bdd->prepare('INSERT INTO disposal_booking (coldate,first_name,last_name,pickupdate,pickuptime,flightnumber,email,phone,service,pick_up_loc,drop_off_loc,drop_off_date,drop_off_time,price,hoursday,comments,driverid,clientid,vehicle)
                    VALUES (:coldate,:first_name,:last_name,:pickupdate,:pickuptime,:flightnumber,:email,:phone,:service,:pick_up_loc,:drop_off_loc,:drop_off_date,:drop_off_time,:price,:hoursday,:comments,:driverid,:clientid,:vehicle)');
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
                    'pick_up_loc'=>$pick_up_loc,
                    'drop_off_loc'=>$drop_off_loc,
                    'drop_off_date'=>$drop_off_date,
                    'drop_off_time'=>$drop_off_time,
                    'price'=>$price,
                    'hoursday'=>$hoursday,
                    /*'promo'=>$promo,*/
                    'comments'=>$comments,
                    'driverid'=>$driverid,
                    'clientid'=>$clientid,
                    'vehicle'=>$vehicle,

                  ));
                  $last_id = $bdd->lastInsertId();
                  $req->closeCursor();

                                    $last_id = urlencode($last_id);

                                    $driverid = urlencode($driverid);

                                    $email_subject = _('Your Disposal on').' '.$pickupdate;



                                      require_once('../PHPMailer_5.2.4/class.phpmailer.php');
                                //include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

                                $mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

                                $mail->IsSMTP(); // telling the class to use SMTP

                                try {
                                  $mailmessage = file_get_contents('new_disposal_'.$lang.'.html');
                                  $mailmessage = str_replace('%first_name%', $first_name, $mailmessage);  // http://www.xeweb.net/2009/12/31/sending-emails-the-right-way-using-phpmailer-and-email-templates/
                                  $mailmessage = str_replace('%last_name%', $last_name, $mailmessage);
                                  $mailmessage = str_replace('%pickupdate%', $pickupdate, $mailmessage);
                                  $mailmessage = str_replace('%pickuptime%', $pickuptime, $mailmessage);
                                  $mailmessage = str_replace('%flightnumber%', $flightnumber, $mailmessage);
                                  $mailmessage = str_replace('%pick_up_loc%', $pick_up_loc, $mailmessage);
                                  $mailmessage = str_replace('%drop_off_loc%', $drop_off_loc, $mailmessage);
                                  $mailmessage = str_replace('%drop_off_date%', $drop_off_date, $mailmessage);
                                  $mailmessage = str_replace('%drop_off_time%', $drop_off_time, $mailmessage);
                                  $mailmessage = str_replace('%hoursday%', $hoursday, $mailmessage);
                                  $mailmessage = str_replace('%phone%', $phone, $mailmessage);
                                  $mailmessage = str_replace('%service%', $service, $mailmessage);
                                  $mailmessage = str_replace('%comments%', $comments, $mailmessage);
                                  $mailmessage = str_replace('%price%', $price, $mailmessage);
                                  $mailmessage = str_replace('%vehicle%', $vehicle, $mailmessage);

                                  $mail->Host       = "ssl://in.mailjet.com"; // SMTP server
                                  $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
                                  $mail->SMTPAuth   = true;                  // enable SMTP authentication
                                  $mail->Host       = "ssl://in.mailjet.com"; // sets the SMTP server
                                  $mail->Port       = 443;                    // set the SMTP port for the GMAIL server
                                  $mail->Username   = "780189761272038a"; // SMTP account username
                                  $mail->Password   = "0a10a8affe8dc1";        // SMTP account password
                                  $mail->AddAddress($email);
                                  $mail->SetFrom('contact@imagidev.com', 'HopDriver');
                                  $mail->AddReplyTo('contact@imagidev.com', 'HopDriver');
                                  $mail->Subject = $email_subject;
                                  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
                                  $mail->MsgHTML($mailmessage);
                                  $mail->CharSet="UTF-8";

                                  // $mail->AddAttachment('images/phpmailer.gif');      // attachment
                                  // $mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
                                  $mail->Send();

                                } catch (phpmailerException $e) {
                                  echo $e->errorMessage(); //Pretty error messages from PHPMailer
                                } catch (Exception $e) {
                                  echo $e->getMessage(); //Boring error messages from anything else!
                                }


                                //////// mail envoyé à tous les chauffeurs (selectionner juste le chauffeur choisie: '".$chauffeursid."' = id) ////////////////////////////////////////////////////////////////////////////////////////////////////

                                /*$driversend = $bdd->query("SELECT email,first_name FROM chauffeurs WHERE '".$pick_up_loc."' LIKE CONCAT('%', country, '%')");
                                 $driversend->setFetchMode(PDO::FETCH_OBJ);
                                  while($result = $driversend->fetch()) {*/



                                    /*  NOT FUNCTIONABLE ANYMORE ON IMAGIDEV.COM

                                    $sth = $bdd->prepare("SELECT email FROM chauffeurs WHERE id = :driverid");
                                    $sth->execute(array(':driverid' => $driverid));
                                    $result = $sth->fetch(PDO::FETCH_OBJ);
                                    $sth->closeCursor();
                                    $driveremail = $result->email;
                                    $driverfirst_name = $result->first_name;

                                    $email_subject_driver = _('Transfer on').' '.$pickupdate.' '. _('at').' '.$pickuptime.' '.$price.'€';


                                $mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

                                $mail->IsSMTP(); // telling the class to use SMTP

                                try {
                                  $mailmessage = file_get_contents('driver_new_disposal_'.$lang.'.html');
                                  $mailmessage = str_replace('%first_name%', $first_name, $mailmessage);  // http://www.xeweb.net/2009/12/31/sending-emails-the-right-way-using-phpmailer-and-email-templates/
                                  $mailmessage = str_replace('%last_name%', $last_name, $mailmessage);
                                  $mailmessage = str_replace('%drivername%', $driverfirst_name, $mailmessage);
                                  $mailmessage = str_replace('%pickupdate%', $pickupdate, $mailmessage);
                                  $mailmessage = str_replace('%pickuptime%', $pickuptime, $mailmessage);
                                  $mailmessage = str_replace('%flightnumber%', $flightnumber, $mailmessage);
                                  $mailmessage = str_replace('%pick_up_loc%', $pick_up_loc, $mailmessage);
                                  $mailmessage = str_replace('%drop_off_loc%', $drop_off_loc, $mailmessage);
                                  $mailmessage = str_replace('%drop_off_date%', $drop_off_date, $mailmessage);
                                  $mailmessage = str_replace('%drop_off_time%', $drop_off_time, $mailmessage);
                                  $mailmessage = str_replace('%hoursday%', $hoursday, $mailmessage);
                                  $mailmessage = str_replace('%phone%', $phone, $mailmessage);
                                  $mailmessage = str_replace('%service%', $service, $mailmessage);
                                  $mailmessage = str_replace('%comments%', $comments, $mailmessage);
                                  $mailmessage = str_replace('%vehicle%', $vehicle, $mailmessage);
                                  $mailmessage = str_replace('%price%', $price, $mailmessage);
                                  $mailmessage = str_replace('%last_id%', $last_id, $mailmessage);
                                  $mailmessage = str_replace('%driverid%', $driverid, $mailmessage);

                                  $mail->Host       = "ssl://in.mailjet.com"; // SMTP server
                                  $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
                                  $mail->SMTPAuth   = true;                  // enable SMTP authentication
                                  $mail->Host       = "ssl://in.mailjet.com"; // sets the SMTP server
                                  $mail->Port       = 443;                    // set the SMTP port for the GMAIL server
                                  $mail->Username   = "78018272038a"; // SMTP account username
                                  $mail->Password   = "0a10affe8dc1";        // SMTP account password

                                  $mail->AddAddress($driveremail);
                                  $mail->AddAddress('drivers@imagidev.com');

                                  $mail->SetFrom('drivers@imagidev.com', 'HopDriver Drivers');
                                  $mail->AddReplyTo('drivers@imagidev.com', 'HopDriver Drivers');
                                  $mail->Subject = $email_subject_driver;
                                  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
                                  $mail->MsgHTML($mailmessage);
                                  $mail->CharSet="UTF-8";

                                  // $mail->AddAttachment('images/phpmailer.gif');      // attachment
                                  // $mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
                                  $mail->Send();

                                } catch (phpmailerException $e) {
                                  echo $e->errorMessage(); //Pretty error messages from PHPMailer
                                } catch (Exception $e) {
                                  echo $e->getMessage(); //Boring error messages from anything else!
                                }


                                 NOT FUNCTIONABLE ANYMORE ON IMAGIDEV.COM*/




                              //} // end while
                                  // $driversend->closeCursor();

                  header('Location: disposal-booked.php');




             } /* end if drop off date and drop off time */
