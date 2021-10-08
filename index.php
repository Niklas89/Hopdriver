<?php
session_start();
if (!isset($_SESSION['lang']) || !isset($_GET['lang'])) {
    $langue = explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
    $langue = strtolower(substr(chop($langue[0]),0,2));
    if($langue == 'fr') { header("Location: //imagidev.com/work/hopdriver/?lang=fr_FR"); }
    /*if($langue == 'en') { header("Location: //imagidev.com/work/hopdriver/?lang=en_US"); }
    else { header("Location: //imagidev.com/work/hopdriver/?lang=en_US"); }*/
}
if(isset( $_SESSION['id'])){ $clientid = $_SESSION['id']; }
if(isset( $_GET['lang'])){ $_SESSION['lang'] = $_GET["lang"]; }
if(isset($_SESSION['lang'])){ $lang = $_SESSION["lang"]; }





date_default_timezone_set('Europe/Madrid');
      $current_time = date('H:i');

require "localization.php";

?>

<!-- <a href="<?php echo $_SERVER['PHP_SELF']; ?>?lang=fr_FR"> -->

<!DOCTYPE HTML>
<html>

<head>
    <title>HopDriver - Le comparateur de prix de VTC et Taxis</title>


    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta name="keywords" content="<?php echo _('airport transfers, HopDriver, disposal services'); ?>" />
    <meta name="description" content="HopDriver - Comparer le prix d'un chauffeur privé VTC, taxi pour tous vos trajets.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- GOOGLE FONTS -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300,100,500,700' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600' rel='stylesheet' type='text/css'>
    <!-- /GOOGLE FONTS -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/mystyles.css">


</head>

<body>
    <div class="global-wrap">


        <?php include 'header_index.php'; ?>

        <!-- TOP AREA -->
        <div class="top-area show-onload">
            <div class="bg-holder full">
                 <div class="bg-mask"></div>
                <div class="bg-img" style="background-image:url(img/2048x1365.png);"></div>
                <video class="bg-video hidden-sm hidden-xs" preload="auto" autoplay="true" loop="loop" muted="muted" poster="img/video-bg.jpg">
                    <source src="media/loop.webm" type="video/webm" />
                    <source src="media/loop.mp4" type="video/mp4" />
                </video>



                <div class="bg-content">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-5 col-md-offset-7">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-front full-height">
                    <div class="container rel full-height">
                        <div class="search-tabs search-tabs-bg search-tabs-bottom">
                            <div class="tabbable">
                                <ul class="nav nav-tabs" id="myTab">
                                    <li class="active"><a href="#tab-1" data-toggle="tab"><i class="fa fa-taxi"></i> <span ><?php echo _("Transfer"); ?></span></a>
                                            </li>
                                            <li><a href="#tab-2" data-toggle="tab"><i class="fa fa-car"></i> <span ><?php echo _("Hourly"); ?></span></a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade in active" id="tab-1">
                                                <h2><!--Post & pick the best driver--></h2>

                                                    <div class="tabbable">
                                                        <ul class="nav nav-pills nav-sm nav-no-br mb10" id="flightChooseTab">
                                                            <li class="active"><a href="#flight-search-1" data-toggle="tab"><?php echo _("One Way"); ?></a>
                                                            </li>
                                                            <li><a href="#flight-search-2" data-toggle="tab"><?php echo _("Round Trip"); ?></a>
                                                            </li>
                                                        </ul>

                                                        <div class="tab-content">

                                                            <div class="tab-pane fade in active" id="flight-search-1">
                                                                <form action="transfer/transfer-services.php" method="post">
                                                                <div class="row">
                                                                <div class="col-md-8">
                                                                    <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-map-marker input-icon"></i>
                                                                            <label class="labelindex"><?php echo _("From"); ?></label>
                                                                            <input class="typeahead form-control" placeholder="City, Airport, Zip Code" type="text" name="origin" id="autocompleteoneway" onclick="initialized()" onFocus="geolocate()" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-map-marker input-icon"></i>
                                                                            <label class="labelindex"><?php echo _("To"); ?></label>
                                                                            <input class="typeahead form-control" placeholder="City, Airport, Zip Code" type="text"  name="destination" onclick="initialize2()" id="autocompleteonewayy" onFocus="geolocate()" />
                                                                        </div>
                                                                    </div>
                                                                    </div> <!-- end col-md-8 -->
                                                                </div> <!-- end row -->
                                                                <div class="col-md-4">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                                                            <label class="labelindex"><?php echo _("Pick-up Date"); ?></label>
                                                                            <input class="date-pick form-control" name="start" data-date-format="d M yyyy" type="text" />
                                                                        </div>
                                                                    </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-clock-o input-icon input-icon-highlight"></i>
                                                                                <label class="labelindex"><?php echo _("Pick-up Time"); ?></label>
                                                                                <input class="time-pick form-control" name="pickuptime" value="<?php echo $current_time; ?>" type="text" />
                                                                            </div>
                                                                    <button class="btn btn-primary btn-lg" type="submit"  name="transfer-services"><?php echo _("Get Price"); ?></button>
                                                                        </div>

                                                                </div> <!-- end row -->
                                                            </div><!-- end col-md-4 -->
                                                            </div> <!-- end row -->
                                                                </form>
                                                            </div> <!-- end panel search 1 -->



                                                            <div class="tab-pane fade" id="flight-search-2">
                                                                <form action="transfer/transfer-services.php" method="post">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-map-marker input-icon"></i>
                                                                            <label class="labelindex"><?php echo _("From"); ?></label>
                                                                            <input class="typeahead form-control" placeholder="City, Airport, Zip Code" type="text" name="origin" id="autocomplete" onclick="initializer()" onFocus="geolocate()" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-map-marker input-icon"></i>
                                                                            <label class="labelindex"><?php echo _("To"); ?></label>
                                                                            <input class="typeahead form-control" placeholder="City, Airport, Zip Code" type="text"  name="destination" id="autocompletee" onclick="initialize()" onFocus="geolocate()"  />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="input-daterange" data-date-format="d M yyyy">
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                                                                <label class="labelindex"><?php echo _("Pick-up Date"); ?></label>
                                                                                <input class="form-control" name="start" type="text" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-clock-o input-icon input-icon-highlight"></i>
                                                                                <label class="labelindex"><?php echo _("Pick-up Time"); ?></label>
                                                                                <input class="time-pick form-control" name="pickuptime" value="<?php echo $current_time; ?>" type="text" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                                                                <label class="labelindex"><?php echo _("Return Date"); ?></label>
                                                                                <input class="form-control" name="end" type="text" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-clock-o input-icon input-icon-highlight"></i>
                                                                                <label class="labelindex"><?php echo _("Return Time"); ?></label>
                                                                                <input class="time-pick form-control" name="returntime" value="<?php echo $current_time; ?>" type="text" />
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                        <button class="btn btn-primary btn-lg" type="submit"  name="transfer-services"><?php echo _("Get Price"); ?></button>
                                                                    </form>
                                                                </div> <!-- end date format -->
                                                            </div> <!-- end panel search 2 -->


                                                        </div> <!-- end tab-content -->
                                                    </div> <!-- end tabbable -->
                                            </div> <!-- end tab-1 -->


                                            <div class="tab-pane fade" id="tab-2">
                                               <!-- <h2>Hourly disposal</h2> -->
                                                <form action="disposal/disposal-cars.php" method="post">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-map-marker input-icon"></i>
                                                                <label class="labelindex"><?php echo _("Start Location"); ?></label>
                                                                <input class="typeahead form-control" placeholder="City, Airport, Zip Code" type="text" name="pick_up_loc" id="autocompletedisposal" onclick="initializedis()" onFocus="geolocate()" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-map-marker input-icon"></i>
                                                                <label class="labelindex"><?php echo _("End Location"); ?></label>
                                                                <input class="typeahead form-control" placeholder="City, Airport, Zip Code" type="text" name="drop_off_loc" id="autocompletedisposall" onclick="initializedisp()" onFocus="geolocate()" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="input-daterange" data-date-format="d M yyyy">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                                                    <label class="labelindex"><?php echo _("Start Date"); ?></label>
                                                                    <input class="form-control" name="start" type="text" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-clock-o input-icon input-icon-highlight"></i>
                                                                    <label class="labelindex"><?php echo _("Start Time"); ?></label>
                                                                    <input class="time-pick form-control" value="<?php echo $current_time; ?>" name="pickuptime" type="text" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                                                    <label class="labelindex"><?php echo _("Last Day Pick-Up Date"); ?></label>
                                                                    <input class="form-control" name="end" type="text" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-clock-o input-icon input-icon-highlight"></i>
                                                                    <label class="labelindex"><?php echo _("Last Day Pick-Up Time"); ?></label>
                                                                    <input class="time-pick form-control" value="<?php echo $current_time; ?>" name="dropofftime" type="text" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group form-group-lg form-group-select-plus">
                                                                    <label class="labelindex"><?php echo _("Hours / day"); ?></label>
                                                                    <div class="btn-group btn-group-select-num hidden" data-toggle="buttons">
                                                                        <label class="btn btn-primary active">
                                                                            <input type="radio" name="options" />1</label>
                                                                        <label class="btn btn-primary">
                                                                            <input type="radio" name="options" />2</label>
                                                                        <label class="btn btn-primary">
                                                                            <input type="radio" name="options" />3</label>
                                                                        <label class="btn btn-primary">
                                                                            <input type="radio" name="options"  />4</label>
                                                                        <label class="btn btn-primary">
                                                                            <input type="radio" name="options" />5</label>
                                                                        <label class="btn btn-primary">
                                                                            <input type="radio" name="options" />6</label>
                                                                        <label class="btn btn-primary">
                                                                            <input type="radio" name="options"  />7</label>
                                                                        <label class="btn btn-primary">
                                                                            <input type="radio" name="options" />8</label>
                                                                        <label class="btn btn-primary">
                                                                            <input type="radio" name="options" />8+</label>
                                                                    </div>
                                                                    <select name="hoursday" class="form-control" >
                                                                        <option>1</option>
                                                                        <option >2</option>
                                                                        <option >3</option>
                                                                        <option >4</option>
                                                                        <option >5</option>
                                                                        <option >6</option>
                                                                        <option >7</option>
                                                                        <option >8</option>
                                                                        <option >9</option>
                                                                        <option >10</option>
                                                                        <option >11</option>
                                                                        <option >12</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary btn-lg" type="submit" name="disposal-cars"><?php echo _("Get Price"); ?></button>
                                                </form>
                                            </div>
                                            <!--<div class="tab-pane fade" id="tab-3">
                                                <h2>Courier Service</h2>
                                                <form>
                                                    <div class="tabbable">

                                                        <div class="tab-content">

                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-map-marker input-icon"></i>
                                                                            <label>From</label>
                                                                            <input class="typeahead form-control" placeholder="City, Airport, Zip Code" type="text" id="autocompletecourier" onFocus="geolocate()" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-map-marker input-icon"></i>
                                                                            <label>To</label>
                                                                            <input class="typeahead form-control" placeholder="City, Airport, Zip Code" type="text" id="autocompletecourierr" onFocus="geolocate()" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                                                            <label>Pick up Date</label>
                                                                            <input class="date-pick form-control" data-date-format="d M yyyy" type="text" />
                                                                        </div>
                                                                    </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-clock-o input-icon input-icon-highlight"></i>
                                                                                <label>Pick-up Time</label>
                                                                                <input class="time-pick form-control" value="<?php echo $current_time; ?>" type="text" />
                                                                            </div>
                                                                        </div>

                                                                </div>

                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary btn-lg" type="submit">Confirm</button>
                                                </form>
                                            </div>
                                            <div class="tab-pane fade" id="tab-4">
                                                <h2>Coach Transfer</h2>
                                               <form>
                                                    <div class="tabbable">
                                                        <ul class="nav nav-pills nav-sm nav-no-br mb10" id="flightChooseTab">
                                                            <li class="active"><a href="#coach-search-1" data-toggle="tab">Round Trip</a>
                                                            </li>
                                                            <li><a href="#coach-search-2" data-toggle="tab">One Way</a>
                                                            </li>
                                                        </ul>
                                                        <div class="tab-content">
                                                            <div class="tab-pane fade in active" id="coach-search-1">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-map-marker input-icon"></i>
                                                                            <label>From</label>
                                                                            <input class="typeahead form-control" placeholder="City, Airport, Zip Code" type="text" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-map-marker input-icon"></i>
                                                                            <label>To</label>
                                                                            <input class="typeahead form-control" placeholder="City, Airport, Zip Code" type="text" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="input-daterange" data-date-format="d M yyyy">
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                                                                <label>Pick-up Date</label>
                                                                                <input class="form-control" name="start" type="text" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-clock-o input-icon input-icon-highlight"></i>
                                                                                <label>Pick-up Time</label>
                                                                                <input class="time-pick form-control" value="<?php echo $current_time; ?>" type="text" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                                                                <label>Return Date</label>
                                                                                <input class="form-control" name="end" type="text" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-clock-o input-icon input-icon-highlight"></i>
                                                                                <label>Return Time</label>
                                                                                <input class="time-pick form-control" value="<?php echo $current_time; ?>" type="text" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group form-group-lg form-group-select-plus">
                                                                                <label>Passengers</label>
                                                                                <div class="btn-group btn-group-select-num" data-toggle="buttons">
                                                                                <label class="btn btn-primary active">
                                                                                    <input type="radio" name="options" />15</label>
                                                                                <label class="btn btn-primary">
                                                                                    <input type="radio" name="options" />25</label>
                                                                                <label class="btn btn-primary">
                                                                                    <input type="radio" name="options" />35</label>
                                                                                <label class="btn btn-primary">
                                                                                    <input type="radio" name="options" />35+</label>
                                                                            </div>
                                                                            <select class="form-control hidden">
                                                                                <option>15</option>
                                                                                <option>25</option>
                                                                                <option>35</option>
                                                                                <option selected="selected">45</option>
                                                                                <option>55</option>
                                                                                <option>65</option>
                                                                                <option>75</option>
                                                                                <option>85</option>
                                                                                <option>95</option>
                                                                                <option>105</option>
                                                                                <option>115</option>
                                                                                <option>125</option>
                                                                                <option>135</option>
                                                                                <option>145</option>
                                                                                <option>165</option>
                                                                                <option>200</option>
                                                                                <option>250</option>
                                                                                <option>300</option>
                                                                                <option>350</option>
                                                                            </select>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade" id="coach-search-2">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-map-marker input-icon"></i>
                                                                            <label>From</label>
                                                                            <input class="typeahead form-control" placeholder="City, Airport, Zip Code" type="text" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-map-marker input-icon"></i>
                                                                            <label>To</label>
                                                                            <input class="typeahead form-control" placeholder="City, Airport, Zip Code" type="text" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                                                            <label>Pick up Date</label>
                                                                            <input class="date-pick form-control" data-date-format="d M yyyy" type="text" />
                                                                        </div>
                                                                    </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-clock-o input-icon input-icon-highlight"></i>
                                                                                <label>Pick-up Time</label>
                                                                                <input class="time-pick form-control" value="<?php echo $current_time; ?>" type="text" />
                                                                            </div>
                                                                        </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group form-group-lg form-group-select-plus">
                                                                            <label>Passengers</label>
                                                                            <div class="btn-group btn-group-select-num" data-toggle="buttons">
                                                                                <label class="btn btn-primary active">
                                                                                    <input type="radio" name="options" />15</label>
                                                                                <label class="btn btn-primary">
                                                                                    <input type="radio" name="options" />25</label>
                                                                                <label class="btn btn-primary">
                                                                                    <input type="radio" name="options" />35</label>
                                                                                <label class="btn btn-primary">
                                                                                    <input type="radio" name="options" />35+</label>
                                                                            </div>
                                                                            <select class="form-control hidden">
                                                                                <option>15</option>
                                                                                <option>25</option>
                                                                                <option>35</option>
                                                                                <option selected="selected">45</option>
                                                                                <option>55</option>
                                                                                <option>65</option>
                                                                                <option>75</option>
                                                                                <option>85</option>
                                                                                <option>95</option>
                                                                                <option>105</option>
                                                                                <option>115</option>
                                                                                <option>125</option>
                                                                                <option>135</option>
                                                                                <option>145</option>
                                                                                <option>165</option>
                                                                                <option>200</option>
                                                                                <option>250</option>
                                                                                <option>300</option>
                                                                                <option>350</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary btn-lg" type="submit">Confirm</button>
                                                </form>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END TOP AREA  -->
<!--
        <div class="gap"></div>


        <div class="container">
            <div class="row row-wrap" data-gutter="60">
                <div class="col-md-4">
                    <div class="thumb">
                        <header class="thumb-header"><i class="fa fa-briefcase box-icon-md round box-icon-black animate-icon-top-to-bottom"></i>
                        </header>
                        <div class="thumb-caption">
                            <h5 class="thumb-title"><a class="text-darken" href="#"><?php echo _('Exclusive Pick-Up'); ?></a></h5>
                            <p class="thumb-desc"><?php echo _("You are free to pay your chosen driver on-site and after the ride. You'll be in direct communication with the driver and you can set up a meeting point together."); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="thumb">
                        <header class="thumb-header"><i class="fa fa-thumbs-o-up box-icon-md round box-icon-black animate-icon-top-to-bottom"></i>
                        </header>
                        <div class="thumb-caption">
                            <h5 class="thumb-title"><a class="text-darken" href="#"><?php echo _("Best Transport Agent"); ?></a></h5>
                            <p class="thumb-desc"><?php echo _("Every driver on this platform is independent and offers his own exclusive services throughout every city in Europe. Stay assured that your needs won't by any chance be avoided."); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="thumb">
                        <header class="thumb-header"><i class="fa fa-lock box-icon-md round box-icon-black animate-icon-top-to-bottom"></i>
                        </header>
                        <div class="thumb-caption">
                            <h5 class="thumb-title"><a class="text-darken" href="#"><?php echo _("Trust & Safety"); ?></a></h5>
                            <p class="thumb-desc"><?php echo _("All drivers take you safely and privileged to wherever your address/hotel is located. Every driver has his own compamy and license."); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="gap gap-small"></div>-->
        </div>
        <div class="bg-holder">
            <div class="bg-mask"></div>
            <div class="bg-parallax" style="background-image:url(img/cars/luxuryclass.jpg);"></div>
            <div class="bg-content">
                <div class="container">
                    <div class="gap gap-big text-center text-white">
                        <h2 class="text-uc mb20"><?php echo _("Pay the driver on-site"); ?></h2>
                        <ul class="icon-list list-inline-block mb0 last-minute-rating">
                            <li><i class="fa fa-star"></i>
                            </li>
                            <li><i class="fa fa-star"></i>
                            </li>
                            <li><i class="fa fa-star"></i>
                            </li>
                            <li><i class="fa fa-star"></i>
                            </li>
                            <li><i class="fa fa-star"></i>
                            </li>
                        </ul>
                        <h5 class="last-minute-title"><?php echo _("Charles de Gaulle airport - Paris city"); ?></h5>
                        <p class="last-minute-date"><?php echo _("Starting at"); ?></p>
                        <p class="mb20"><b>35 €</b> / <?php echo _("way"); ?></p><!--<a class="btn btn-lg btn-white btn-ghost" href="transfer/transfer-services.php"><?php echo _("Book Now"); ?> <i class="fa fa-angle-right"></i></a>-->
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="gap"></div>
            <h2 class="text-center"><?php echo _("These are your choices"); ?></h2>
            <div class="gap">
                <div class="row row-wrap">
                    <div class="col-md-3">
                        <div class="thumb">
                            <header class="thumb-header">
                                <span class="hover-img curved">
                                    <img src="img/cars/top-services/economy.jpg" alt="Economy class" title="Economy class" /><i class="fa fa-plus box-icon-white box-icon-border hover-icon-top-right round"></i>
                                </span>
                            </header>
                            <div class="thumb-caption">
                                <h4 class="thumb-title"><?php echo _("Economy Van"); ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="thumb">
                            <header class="thumb-header">
                                <span class="hover-img curved">
                                    <img src="img/cars/top-services/businesscar.jpg" alt="<?php echo _('Business class'); ?>" title="<?php echo _('Business class'); ?>" /><i class="fa fa-plus box-icon-white box-icon-border hover-icon-top-right round"></i>
                                </span>
                            </header>
                            <div class="thumb-caption">
                                <h4 class="thumb-title"><?php echo _("Business Sedan"); ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="thumb">
                            <header class="thumb-header">
                                <span class="hover-img curved">
                                    <img src="img/cars/top-services/businessvan.jpg" alt="Business class" title="<?php echo _("Business class"); ?>" /><i class="fa fa-plus box-icon-white box-icon-border hover-icon-top-right round"></i>
                                </span>
                            </header>
                            <div class="thumb-caption">
                                <h4 class="thumb-title"><?php echo _("Business Van"); ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="thumb">
                            <header class="thumb-header">
                                <span class="hover-img curved">
                                    <img src="img/cars/top-services/luxury.jpg" alt="<?php echo _('Luxury class'); ?>" title="<?php echo _('Luxury class'); ?>" /><i class="fa fa-plus box-icon-white box-icon-border hover-icon-top-right round"></i>
                                </span>
                            </header>
                            <div class="thumb-caption">
                                <h4 class="thumb-title"><?php echo _("Luxury Sedan"); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>



        <?php include 'footer.php'; ?>


    <script src="js/modernizr.js"></script>
    <script src="//maps.googleapis.com/maps/api/js?key=AIzi6HVg&libraries=places&language=en"></script>
    <!-- <script src="//maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&language=en"></script> -->
    <script src="calcul-itineraire/autocomplete.js"></script>
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/slimmenu.js"></script>
        <script src="js/bootstrap-datepicker.js"></script>
        <script src="js/bootstrap-timepicker.js"></script>
        <script src="js/nicescroll.js"></script>
        <script src="js/dropit.js"></script>
        <script src="js/ionrangeslider.js"></script>
        <script src="js/icheck.js"></script>
        <script src="js/fotorama.js"></script>
        <script src="js/typeahead.js"></script>
        <script src="js/card-payment.js"></script>
        <script src="js/magnific.js"></script>
        <script src="js/owl-carousel.js"></script>
        <script src="js/fitvids.js"></script>
        <script src="js/tweet.js"></script>
        <script src="js/countdown.js"></script>
        <script src="js/gridrotator.js"></script>
        <script src="js/custom.js"></script>
    </div>
</body>

</html>
