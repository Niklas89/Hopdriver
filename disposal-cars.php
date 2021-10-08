<!DOCTYPE HTML>
<html>

<head>
    <title>Cars results</title>


    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta name="keywords" content="" />
    <meta name="description" content="">
    <meta name="author" content="Niklas">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- GOOGLE FONTS -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600' rel='stylesheet' type='text/css'>
    <!-- /GOOGLE FONTS -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/mystyles.css">
    <script src="js/modernizr.js"></script>


</head>

<body>

    <!-- FACEBOOK WIDGET -->
    <div id="fb-root"></div>
    <script>
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <!-- /FACEBOOK WIDGET -->
    <div class="global-wrap">

        <?php include 'header.php'; ?>


        <div class="container">
            <ul class="breadcrumb">
                <li><a href="index.html">Home</a>
                </li>
                <li><a href="#">France</a>
                </li>
                <li><a href="#">Paris</a>
                </li>
                <li class="active">Paris Transfer</li>
            </ul>
            <div class="mfp-with-anim mfp-hide mfp-dialog mfp-search-dialog" id="search-dialog">
                <h3>Search for Car</h3>
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-map-marker input-icon input-icon-highlight"></i>
                                <label>Pick-up From</label>
                                <input class="typeahead form-control" placeholder="City, Airport or U.S. Zip Code" type="text" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-map-marker input-icon input-icon-highlight"></i>
                                <label>Drop-off To</label>
                                <input class="typeahead form-control" placeholder="City, Airport or U.S. Zip Code" value="Same as Pick-up" type="text" />
                            </div>
                        </div>
                    </div>
                    <div class="input-daterange" data-date-format="MM d, D">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                    <label>Pick-up Date</label>
                                    <input class="form-control" name="start" type="text" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-clock-o input-icon input-icon-highlight"></i>
                                    <label>Drop-off Time</label>
                                    <input class="time-pick form-control" value="12:00 AM" type="text" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                    <label>Drop-off Date</label>
                                    <input class="form-control" name="end" type="text" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-clock-o input-icon input-icon-highlight"></i>
                                    <label>Pick-up Time</label>
                                    <input class="time-pick form-control" value="12:00 AM" type="text" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-lg" type="submit">Search for Flights</button>
                </form>
            </div>
            <h3 class="booking-title">Transfer Services in Paris on Nov 16<small><a class="popup-text" href="#search-dialog" data-effect="mfp-zoom-out">Change search</a></small></h3>
            <div class="row">
                <div class="col-md-3">
                    <div class="booking-item-dates-change mb30">
                        <form class="input-daterange" data-date-format="MM, d">
                            <div class="form-group form-group-icon-left"><i class="fa fa-map-marker input-icon input-icon-hightlight"></i>
                                <label>Pick Up Location</label>
                                <input class="typeahead form-control" value="USA, New York" placeholder="City or Airport" type="text" />
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Check in</label>
                                        <input class="form-control" name="start" type="text" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Time</label>
                                        <input class="time-pick form-control" value="12:00 AM" type="text" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-icon-left"><i class="fa fa-map-marker input-icon input-icon-hightlight"></i>
                                <label>Drop Off Location</label>
                                <input class="typeahead form-control" value="Same as Pickup" placeholder="City or Airport" type="text" />
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Check out</label>
                                        <input class="form-control" name="end" type="text" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Time</label>
                                        <input class="time-pick form-control" value="12:00 AM" type="text" />
                                    </div>
                                </div>
                            </div>
                            <input class="btn btn-primary" type="submit" value="Update Search" />
                        </form>
                    </div>

                </div>
                <div class="col-md-9">
                    <div class="nav-drop booking-sort">
                        <h5 class="booking-sort-title">Select Transfer Service</h5>

                    </div>
                    <ul class="booking-list">
                        <li>
                            <a class="booking-item" href="#">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="booking-item-car-img">
                                            <img src="img/cars/mbeclass.png" alt="Mercedes Benz E Class" title="Image Title" />
                                            <p class="booking-item-car-title">Mercedes Benz E Class</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <ul class="booking-item-features booking-item-features-sign clearfix">
                                                    <li rel="tooltip" data-placement="top" title="Passengers"><i class="fa fa-male"></i><span class="booking-item-feature-sign">x 3</span>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Baggage Quantity"><i class="fa fa-briefcase"></i><span class="booking-item-feature-sign">x 3</span>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="FM Radio"><i class="im im-fm"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Stereo CD/MP3"><i class="im im-stereo"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Air Conditioning"><i class="im im-air"></i>
                                                    </li>
                                                </ul>
                                                <ul class="booking-item-features booking-item-features-small clearfix">
                                                    <li rel="tooltip" data-placement="top" title="Phone Charger"><i class="fa fa-bolt"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Bottle of Water"><i class="fa fa-glass"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4">
                                                <ul class="booking-item-features booking-item-features-dark">
                                                    <li rel="tooltip" data-placement="top" title="Shuttle Bus to Car"><i class="im im-bus"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Meet and Greet"><i class="im im-meet"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Terminal Pickup"><i class="fa fa-plane"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Car with Driver"><i class="im im-driver"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3"><span class="booking-item-price">80€</span><span>/way</span>
                                        <p class="booking-item-flight-class">Business</p><span class="btn btn-primary">Select</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                             <a class="booking-item" href="#">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="booking-item-car-img">
                                            <img src="img/cars/peugeot508.png" alt="Image Alternative text" title="Image Title" />
                                            <p class="booking-item-car-title">Peugeot 508</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <ul class="booking-item-features booking-item-features-sign clearfix">
                                                    <li rel="tooltip" data-placement="top" title="Passengers"><i class="fa fa-male"></i><span class="booking-item-feature-sign">x 3</span>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Baggage Quantity"><i class="fa fa-briefcase"></i><span class="booking-item-feature-sign">x 3</span>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="FM Radio"><i class="im im-fm"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Stereo CD/MP3"><i class="im im-stereo"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Air Conditioning"><i class="im im-air"></i>
                                                    </li>
                                                </ul>
                                                <ul class="booking-item-features booking-item-features-small clearfix">
                                                    <li rel="tooltip" data-placement="top" title="Phone Charger"><i class="fa fa-bolt"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Bottle of Water"><i class="fa fa-glass"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4">
                                                <ul class="booking-item-features booking-item-features-dark">
                                                    <li rel="tooltip" data-placement="top" title="Shuttle Bus to Car"><i class="im im-bus"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Meet and Greet"><i class="im im-meet"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Terminal Pickup"><i class="fa fa-plane"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Car with Driver"><i class="im im-driver"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3"><span class="booking-item-price">$60</span><span>/way</span>
                                        <p class="booking-item-flight-class">Economy</p><span class="btn btn-primary">Select</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="booking-item" href="#">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="booking-item-car-img">
                                            <img src="img/cars/mbsclass.png" alt="Mercedes Benz S Class" title="Image Title" />
                                            <p class="booking-item-car-title">Mercedes Benz S Class</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <ul class="booking-item-features booking-item-features-sign clearfix">
                                                    <li rel="tooltip" data-placement="top" title="Passengers"><i class="fa fa-male"></i><span class="booking-item-feature-sign">x 3</span>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Baggage Quantity"><i class="fa fa-briefcase"></i><span class="booking-item-feature-sign">x 3</span>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="FM Radio"><i class="im im-fm"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Stereo CD/MP3"><i class="im im-stereo"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Air Conditioning"><i class="im im-air"></i>
                                                    </li>
                                                </ul>
                                                <ul class="booking-item-features booking-item-features-small clearfix">
                                                    <li rel="tooltip" data-placement="top" title="Phone Charger"><i class="fa fa-bolt"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Bottle of Water"><i class="fa fa-glass"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Wifi"><i class="fa fa-signal"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4">
                                                <ul class="booking-item-features booking-item-features-dark">
                                                    <li rel="tooltip" data-placement="top" title="Shuttle Bus to Car"><i class="im im-bus"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Meet and Greet"><i class="im im-meet"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Terminal Pickup"><i class="fa fa-plane"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Car with Driver"><i class="im im-driver"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3"><span class="booking-item-price">$110</span><span>/way</span>
                                        <p class="booking-item-flight-class">Luxury</p><span class="btn btn-primary">Select</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>

                            <a class="booking-item" href="#">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="booking-item-car-img">
                                            <img src="img/cars/caravelle.png" alt="Image Alternative text" title="Image Title" />
                                            <p class="booking-item-car-title">Volkswagen Caravelle</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <ul class="booking-item-features booking-item-features-sign clearfix">
                                                    <li rel="tooltip" data-placement="top" title="Passengers"><i class="fa fa-male"></i><span class="booking-item-feature-sign">x 7</span>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Baggage Quantity"><i class="fa fa-briefcase"></i><span class="booking-item-feature-sign">x 7</span>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="FM Radio"><i class="im im-fm"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Stereo CD/MP3"><i class="im im-stereo"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Air Conditioning"><i class="im im-air"></i>
                                                    </li>
                                                </ul>
                                                <ul class="booking-item-features booking-item-features-small clearfix">
                                                    <li rel="tooltip" data-placement="top" title="Phone Charger"><i class="fa fa-bolt"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Bottle of Water"><i class="fa fa-glass"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4">
                                                <ul class="booking-item-features booking-item-features-dark">
                                                    <li rel="tooltip" data-placement="top" title="Shuttle Bus to Car"><i class="im im-bus"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Meet and Greet"><i class="im im-meet"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Terminal Pickup"><i class="fa fa-plane"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Car with Driver"><i class="im im-driver"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3"><span class="booking-item-price">$80</span><span>/day</span>
                                        <p class="booking-item-flight-class">Economy</p><span class="btn btn-primary">Select</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="booking-item" href="#">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="booking-item-car-img">
                                            <img src="img/cars/renaultclio.jpg" alt="Voklee cab" title="Image Title" />
                                            <p class="booking-item-car-title">Clio Renault</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <ul class="booking-item-features booking-item-features-sign clearfix">
                                                    <li rel="tooltip" data-placement="top" title="Passengers"><i class="fa fa-male"></i><span class="booking-item-feature-sign">x 2</span>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Baggage Quantity"><i class="fa fa-briefcase"></i><span class="booking-item-feature-sign">x 1</span>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="FM Radio"><i class="im im-fm"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Stereo CD/MP3"><i class="im im-stereo"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Air Conditioning"><i class="im im-air"></i>
                                                    </li>
                                                </ul>
                                                <ul class="booking-item-features booking-item-features-small clearfix">
                                                    <li rel="tooltip" data-placement="top" title="Phone Charger"><i class="fa fa-bolt"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Bottle of Water"><i class="fa fa-glass"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4">
                                                <ul class="booking-item-features booking-item-features-dark">
                                                    <li rel="tooltip" data-placement="top" title="Shuttle Bus to Car"><i class="im im-bus"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Meet and Greet"><i class="im im-meet"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Terminal Pickup"><i class="fa fa-plane"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Car with Driver"><i class="im im-driver"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3"><span class="booking-item-price">45€</span><span>/way</span>
                                        <p class="booking-item-flight-class">Voklee cab</p><span class="btn btn-primary">Select</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="booking-item" href="#">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="booking-item-car-img">
                                            <img src="img/cars/mbviano.png" alt="Business" title="Business" />
                                            <p class="booking-item-car-title">Mercedes Benz Viano</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <ul class="booking-item-features booking-item-features-sign clearfix">
                                                    <li rel="tooltip" data-placement="top" title="Passengers"><i class="fa fa-male"></i><span class="booking-item-feature-sign">x 7</span>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Baggage Quantity"><i class="fa fa-briefcase"></i><span class="booking-item-feature-sign">x 7</span>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="FM Radio"><i class="im im-fm"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Stereo CD/MP3"><i class="im im-stereo"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Air Conditioning"><i class="im im-air"></i>
                                                    </li>
                                                </ul>
                                                <ul class="booking-item-features booking-item-features-small clearfix">
                                                    <li rel="tooltip" data-placement="top" title="Phone Charger"><i class="fa fa-bolt"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Bottle of Water"><i class="fa fa-glass"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Wifi"><i class="fa fa-signal"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4">
                                                <ul class="booking-item-features booking-item-features-dark">
                                                    <li rel="tooltip" data-placement="top" title="Shuttle Bus to Car"><i class="im im-bus"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Meet and Greet"><i class="im im-meet"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Terminal Pickup"><i class="fa fa-plane"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Car with Driver"><i class="im im-driver"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3"><span class="booking-item-price">110€</span><span>/way</span>
                                        <p class="booking-item-flight-class">Business</p><span class="btn btn-primary">Select</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                        </li>
                    </ul>

            </div>
            <div class="gap"></div>
        </div>



        <footer id="main-footer">
            <div class="container">
                <div class="row row-wrap">
                    <div class="col-md-3">
                        <a class="logo" href="index.html">
                            <img src="img/logo-invert.png" alt="Image Alternative text" title="Image Title" />
                        </a>
                        <p class="mb20">Booking, reviews and advices on hotels, resorts, flights, vacation rentals, travel packages, and lots more!</p>
                        <ul class="list list-horizontal list-space">
                            <li>
                                <a class="fa fa-facebook box-icon-normal round animate-icon-bottom-to-top" href="#"></a>
                            </li>
                            <li>
                                <a class="fa fa-twitter box-icon-normal round animate-icon-bottom-to-top" href="#"></a>
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
                        <form>
                            <label>Enter your E-mail Address</label>
                            <input type="text" class="form-control">
                            <p class="mt5"><small>*We Never Send Spam</small>
                            </p>
                            <input type="submit" class="btn btn-primary" value="Subscribe">
                        </form>
                    </div>
                    <div class="col-md-2">
                        <ul class="list list-footer">
                            <li><a href="#">About US</a>
                            </li>
                            <li><a href="#">Press Centre</a>
                            </li>
                            <li><a href="#">Best Price Guarantee</a>
                            </li>
                            <li><a href="#">Travel News</a>
                            </li>
                            <li><a href="#">Jobs</a>
                            </li>
                            <li><a href="#">Privacy Policy</a>
                            </li>
                            <li><a href="#">Terms of Use</a>
                            </li>
                            <li><a href="#">Feedback</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h4>Have Questions?</h4>
                        <h4 class="text-color">+1-202-555-0173</h4>
                        <h4><a href="#" class="text-color">support@imagidev.com</a></h4>
                        <p>24/7 Dedicated Customer Support</p>
                    </div>

                </div>
            </div>
        </footer>

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
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
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
