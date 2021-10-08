
                <div class="col-md-3">
                    <aside class="user-profile-sidebar">
                        <div class="user-profile-avatar text-center">


                            <?php 
                             $req = $bdd->prepare('SELECT * FROM driver_photo WHERE driverid = :id_users');
                              $req->execute(array(
                                'id_users'=>$id_users
                              ));
                              $data = $req->fetch();
                              if($req->rowCount()>0)
                              {
                                   ?> <img src="<?php echo $data['up_filename']; ?>" alt="<?php echo $data['up_description']; ?>" title="<?php echo $data['up_title']; ?>" /> <?php
                              }
                              

                              elseif($req->rowCount()==0) // check if row where there is this email doesn't exist
                                {
                                   ?> <img src="../img/300x300.png" alt="Image Alternative text" title="AMaze" />Photo <?php

                                }


                                    ?>
                            
                            <h5><?php echo $driverfirst_name; ?> <?php echo $driverlast_name; ?></h5>
                            <p><?php echo _("Driver Partner"); ?></p>
                        </div>
                        <ul class="list user-profile-nav">
                            <li><a href="profile.php"><i class="fa fa-user"></i><?php echo _('Profile'); ?></a>
                            </li>
                            <li><a href="transfers.php"><i class="fa fa-calendar"></i><?php echo _('Transfers'); ?></a>
                            </li>
                            <li><a href="disposals.php"><i class="fa fa-calendar"></i><?php echo _('Disposals'); ?></a>
                            </li>
                            <!--<li><a href="booking-history.php"><i class="fa fa-clock-o"></i><?php echo _('Booking History'); ?></a>
                            </li>-->
                            <li><a href="profile-settings.php"><i class="fa fa-cog"></i><?php echo _('Settings'); ?></a>
                            </li>
                            <li><a href="price-settings.php"><i class="fa fa-euro"></i><?php echo _('Price'); ?></a>
                            </li>
                            <li><a href="vehicle-settings.php"><i class="fa fa-car"></i><?php echo _('Vehicles'); ?></a>
                            </li>
                            <li><a href="payment-settings.php"><i class="fa fa-credit-card"></i><?php echo _('Payment'); ?></a>
                            </li>
                            <li><a href="support.php"><i class="fa fa-question-circle"></i><?php echo _("Driver Support"); ?></a>
                            </li>
                            <li><a href="logout.php"><i class="fa fa-power-off"></i><?php echo _('Logout'); ?></a>
                            </li>
                        </ul>
                    </aside>
                </div>