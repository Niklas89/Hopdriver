

<header id="main-header">
            <div class="header-top">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <a class="logo" href="http://imagidev.com/work/hopdriver/">
                                <img src="//imagidev.com/work/hopdriver/img/logo-invert.png" alt="<?php echo _('Home page'); ?>" title="HopDriver" />
                            </a>
                        </div>
                        <div class="col-md-3 col-md-offset-2">
                            <!--<form class="main-header-search">
                                <div class="form-group form-group-icon-left">
                                    <i class="fa fa-search input-icon"></i>
                                    <input type="text" class="form-control">
                                </div>
                            </form>-->
                        </div>
                        <div class="col-md-4">
                            <div class="top-user-area clearfix">
                                <ul class="top-user-area-list list list-horizontal list-border">
                                    <?php
                                    if(empty($_SESSION['id']))
                                        { ?>
                                          <li><a href="//imagidev.com/work/hopdriver/client/"><?php echo _("Client"); ?></a>
                                    </li>
                                          <li><a href="//imagidev.com/work/hopdriver/driver/"><?php echo _("Driver"); ?></a>
                                    </li>
                                       <?php  } else { ?>
                                    <li><a href="//imagidev.com/work/hopdriver/client/"><?php echo _("My Account"); ?></a>
                                    </li>
                                    <li><a href="//imagidev.com/work/hopdriver/logout.php"><?php echo _("Logout"); ?></a>
                                    </li>

                                    <?php } ?>

                                    <?php
                                    if($_SESSION['lang'] == 'fr_FR')
                                        { ?>
                                       <li><a href="//imagidev.com/work/hopdriver/?lang=en_US">English</a>
                                    </li>
                                    <?php
                                        }
                                    elseif($_SESSION['lang'] == 'en_US')
                                        { ?>
                                          <li><a href="//imagidev.com/work/hopdriver/?lang=fr_FR">Francais</a>
                                    </li>
                                       <?php  } else { ?>
                                    <li><a href="//imagidev.com/work/hopdriver/?lang=fr_FR">Francais</a>
                                    </li>

                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <!--<div class="nav">
                    <ul class="slimmenu" id="slimmenu">
                        <li><a href="//imagidev.com/work/hopdriver"><?php echo _("Home"); ?></a></li>
                        <li><a href="//imagidev.com/work/hopdriver/cities.php"><?php echo _("Cities"); ?></a>
                                </li>
                        <li class="active"><a href="//imagidev.com/work/hopdriver/contact.php"><?php echo _("Contact"); ?></a>
                                </li>
                    </ul>
                </div>-->
            </div>
        </header>
