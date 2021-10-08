 <footer id="main-footer">
            <div class="container">
                <div class="row row-wrap">
                    <div class="col-md-3">
                        <a class="logo" href="//imagidev.com/work/hopdriver/">
                            <img src="//imagidev.com/work/hopdriver/img/logo-invert.png" alt="HopDriver Logo" title="<?php echo _('Home page'); ?>" />
                        </a>
                        <p class="mb20">Your trip begins with us.</p>
                        <ul class="list list-horizontal list-space">
                            <li>
                                <a class="fa fa-facebook box-icon-normal round animate-icon-bottom-to-top" href="https://www.facebook.com/"></a>
                            </li>
                            <li>
                                <a class="fa fa-twitter box-icon-normal round animate-icon-bottom-to-top" href="https://twitter.com/"></a>
                            </li>
                            <li>
                                <a class="fa fa-google-plus box-icon-normal round animate-icon-bottom-to-top" href="#"></a>
                            </li>
                            <li>
                                <a class="fa fa-linkedin box-icon-normal round animate-icon-bottom-to-top" href="#"></a>
                            </li>
                            <li>
                                <a class="fa fa-pinterest box-icon-normal round animate-icon-bottom-to-top" href="#"></a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-md-3">
                        <h4>Newsletter</h4>
                        <div id="mc_embed_signup">
                        <form action="#"
                        method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                            <div id="mc_embed_signup_scroll">
                            <div class="mc-field-group">
                            <label for="mce-EMAIL"><?php echo _("Enter your E-mail Address"); ?></label>
                            <input  type="email" value="" name="EMAIL" id="mce-EMAIL" type="text" class="form-control">
                            <p class="mt5"><small>*<?php echo _("We Never Send Spam"); ?></small>
                            </p>
                            </div>
                             <div id="mce-responses" class="clear">
                                <div class="response" id="mce-error-response" style="display:none"></div>
                                <div class="response" id="mce-success-response" style="display:none"></div>
                            </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                            <div style="position: absolute; left: -5000px;"><input type="text" name="b_d4c14fc2" tabindex="-1" value=""></div>
                            <div class="clear"><input type="submit" value="Subscribe" name="Subscribe" id="mc-embedded-subscribe" class="btn btn-primary"></div>
                            </div>
                        </form>
                    </div>

                    </div>
                    <div class="col-md-2">
                        <ul class="list list-footer">
                           <li><a href="//imagidev.com/work/hopdriver/about.php"><?php echo _("About Us"); ?></a>
                            </li>
                            <!--<li><a href="#">Press Centre</a>
                            </li>
                            <li><a href="//imagidev.com/work/hopdriver/bestprice.php"><?php echo _("Best Price Guarantee"); ?></a>
                            </li>-->
                            <!--<li><a href="#">Privacy Policy</a>
                            </li>-->
                            <li><a href="#"><?php echo _("Terms and Conditions"); ?></a>
                            </li>
                            <li><a href="#"><?php echo _("Legal Notices"); ?></a>
                            </li>
                                    <?php
                                    if(empty($_SESSION['id']))
                                        { ?>
                            <li><a href="//imagidev.com/work/hopdriver/driver"><?php echo _("Driver Account"); ?></a>
                            </li>
                            <li><a href="//imagidev.com/work/hopdriver/client"><?php echo _("Customer Account"); ?></a>
                            </li>
                                       <?php  } else { ?>
                                    <li><a href="//imagidev.com/work/hopdriver/client/"><?php echo _("My Account"); ?></a>
                                    </li>

                                    <?php } ?>
                            <!--<li><a href="#"><?php echo _("Feedback"); ?></a>
                            </li>
                            <li><a href="#"><?php echo _("Our Clients"); ?></a>
                            </li>-->
                            <!--<li><a href="//imagidev.com/work/hopdriver/blog/?lang=fr">Blog</a></li>-->
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h4><?php echo _("Have Questions?"); ?></h4>
                        <h4 class="text-color">+33 9 77 55 52 55</h4>
                        <h4><a href="mailto:contact@email.com" class="text-color">contact@email.com</a></h4>
                        <p><?php echo _("24/7 Dedicated Customer Support"); ?></p>
                    </div>

                </div>
            </div>
        </footer>
