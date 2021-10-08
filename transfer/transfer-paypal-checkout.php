                    <h3><?php echo _("Booking"); ?></h3>
                    <form name="_xclick" id="transfercheckout" action="transfer-payment-unregistered.php" method="post">
                            <div class="gap gap-small"></div>

                            <?php if(empty($_SESSION['id'])) { ?>
                            <div class="tabbable">
                                <ul class="nav nav-tabs" id="myTab">
                                    <li class="active"><a href="#tab-1" data-toggle="tab"><?php echo _("Login"); ?></a>
                                    </li>
                                    <li><a href="#tab-2" data-toggle="tab"><?php echo _("New Customer"); ?></a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="tab-1">
                                        <div class="row">
                                        <div class="gap gap-small"></div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label><?php echo _("E-mail"); ?></label>
                                                    <input class="form-control" name="email_login" id="email" type="text" placeholder="<?php _('name@email.com'); ?>" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label><?php echo _("Password"); ?></label>
                                                    <input class="form-control" type="password" name="pass_login" placeholder="********" />
                                                </div>
                                            </div>
                                        </div> <!-- end row login -->
                                    </div> <!-- end tab login -->

                                    <div class="tab-pane fade" id="tab-2">
                                        <div class="gap gap-small"></div>
                                        <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label><?php echo _("First Name"); ?></label>
                                                        <input name="first_name" id="first_name" class="form-control" type="text" placeholder="<?php echo _('First Name'); ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label><?php echo _("Last Name"); ?></label>
                                                        <input name="last_name" id="last_name" class="form-control" type="text" placeholder="<?php echo _('Last Name'); ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label><?php echo _("E-mail"); ?></label>
                                                        <input class="form-control" name="email" id="email" type="text" placeholder="<?php echo _('name@email.com'); ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label><?php echo _("Password"); ?></label>
                                                        <input class="form-control" type="password" name="pass" placeholder="<?php echo _('At least 6 characters'); ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label><?php echo _("Phone Number (with country code)"); ?></label>
                                                        <input name="night_phone_c" id="night_phone_c" class="form-control" type="text" placeholder="+33" />
                                                    </div>
                                                </div>
                                            </div>
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="registration" value="accepted" class="i-check" type="checkbox" /><?php echo _("I Agree To"); ?><a class="btn btn-link" href="../terms.php" target="_blank" title="<?php echo _('Terms'); ?>"><?php echo _("Terms and Conditions"); ?></a>
                                                    </label>
                                                </div>
                                        </div> <!-- end tab register -->

                                    </div> <!-- end tab content -->
                                </div> <!-- end tabbable -->
                            <?php } else {

                                $sth = $bdd->prepare("SELECT * FROM clients WHERE id = :clientid");
                                $sth->execute(array(':clientid' => $clientid));
                                $result = $sth->fetch(PDO::FETCH_OBJ);
                                $sth->closeCursor();
                                $email_login = $result->email;
                                $pass_login = md5($result->pass);

                                ?>
                                <input name="email_login" id="first_name" type="hidden" value="<?php echo $email_login; ?>" />
                                <input name="pass_login" id="last_name" type="hidden" value="<?php echo $pass_login; ?>" />
                                <?php } ?>




                        <div class="gap gap-small"></div>
                        <div class="gap gap-small"></div>



                        <h4><?php echo _("Transfer details"); ?></h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?php echo _("Flight or Train Number (optional)"); ?></label>
                                    <input name="custom" id="custom" class="form-control" type="text" placeholder="AF120" />
                                </div>
                            </div>
                            <!-- <div class="col-md-4">
                                <div class="form-group">
                                    <label>Promo Code (optional)</label>
                                    <input name="promo" id="promo" class="form-control" type="text" />
                                </div>
                            </div> -->

                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label><?php echo _("Other comments (optional)"); ?></label>
                                    <textarea rows="2" cols="50" name="comments" id="comments" class="form-control" type="textarea" placeholder="<?php echo _('Mention services or options you would like to have. Like child seats or meeting spots.'); ?>" /></textarea>
                                </div>
                            </div>
                        </div>
                        <!--<div class="checkbox">
                            <label>
                                <input class="i-check" type="checkbox" checked/>Create Traveler account <small>(password will be send to your e-mail)</small>
                            </label>
                        </div>-->

                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <!-- <img class="pp-img" src="../img/paypal.png" alt="Make payments with PayPal - it's fast, free and secure!" title="PayPal" />
                            <p>Important: You will be redirected to PayPal's website to securely complete your payment.</p>

                            <input type="hidden" name="cmd" value="_xclick">  -->
                            <input type="hidden" name="pickupdate" id="pickupdate" value="<?php echo $pickupdate; ?>">
                            <input type="hidden" name="pickuptime" id="pickuptime" value="<?php echo $pickuptime; ?>">
                            <input type="hidden" name="destination" id="destination" value="<?php echo $destination; ?>">
                            <input type="hidden" name="origin" id="origin" value="<?php echo $origin; ?>">
                            <!-- <input type="hidden" name="business" id="business" value="n">
                            <input type="hidden" name="currency_code" value="EUR">
                            <INPUT type="hidden" name="charset" value="utf-8">
                            <input name="cancel_return" type="hidden" value="http://hopdriver.com" />
                            <input name="no_note" type="hidden" value="1" />
                            <input name="bn" type="hidden" value="PP-BuyNowBF" />
                            <input type="hidden" name="notify_url" value="http://www.hopdriver.com/transfer/transfer-ipn-listener.php">  -->
                            <input type="hidden" name="item_name" id="item_name" value="<?php echo $item_name; ?>">
                            <input type="hidden" name="return" value="<?php echo $return; ?>">
                            <input type="hidden" name="services" id="services" value="<?php echo $services; ?>" />
                            <input type="hidden" name="vehicle" value="<?php echo $vehicle; ?>" />
                            <input type="hidden" name="seats" id="seats" value="<?php echo $seats; ?>" />
                            <input type="hidden" name="luggage" value="<?php echo $luggage; ?>" />
                            <input type="hidden" name="vehicles" value="<?php echo $vehicles; ?>" />
                            <input type="hidden" name="chauffeursid" value="<?php echo $chauffeursid; ?>" />
                            <?php if (!empty($returndate) && !empty($returntime)) { ?>
                        <input type="hidden" name="amount" value="<?php echo $totalprice; ?>">
                        <input type="hidden" name="totalprice" value="<?php echo $totalprice; ?>"> <!-- juste pour pas que fasse mess derreur-->
                            <input type="hidden" name="returndate" id="returndate" value="<?php echo $returndate; ?>">
                            <input type="hidden" name="returntime" id="returntime" value="<?php echo $returntime; ?>">
                        <?php } else {  ?>
                        <input type="hidden" name="amount" id="amount" value="<?php echo $price; ?>">
                        <?php } ?>

                            <button class="btn btn-primary" type="submit" name="booknow"><?php echo _("Book now"); ?></button>

                            <!--<form name="_xclick" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
                            <input type="hidden" name="item_name_1" value="Registration(Large)" />
                            <input type="hidden" name="amount_1" value='15' />
                            <input type="hidden" name="quantity_1" value="1" />
                            <input type='hidden' name='item_number' value='' />
                            <input type="hidden" name="shipping_1" value='0.00' />
                            <input type="image" src="http://domain.com/images/paypal_checkout_EN.png"
                                 name="submit" class="wp_cart_checkout_button"
                                 alt="Make payments with PayPal - it\'s fast, free and secure!" />
                            <input type="hidden" name="return" value="http://voklee.com" />
                            <input type="hidden" name="business" value="n" />
                            <input type="hidden" name="currency_code" value="EUR" />

                            <input type="hidden" name="custom" value="referrer=1234&size=L">
                            <input type="hidden" name="cmd" value="_cart" />
                            <input type="hidden" name="upload" value="1" />
                            <input type="hidden" name="rm" value="2" />
                            <input type="hidden" name="mrb" value="ABC2343FGBM234" />-->
                            </form>
