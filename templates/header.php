<?php

require_once realpath(__DIR__ . '/../vendor/autoload.php');
Session::start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SysNetHacking Store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../assets/css/plugins.css"/>
    <link rel="stylesheet" type="text/css" media="screen" href="../assets/css/main.css"/>
    <link rel="shortcut icon" type="image/x-icon" href="../assets/image/favicon.ico">
    <script src="<?= JQUERY_URL ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
            integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn"
            crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js?render=<?= SITE_KEY ?>"></script>
    <?php
    if ($_SERVER['PHP_SELF'] === '/login/index.php') {
        echo "
    <script>
        grecaptcha.ready(function () {
            grecaptcha.execute('" . SITE_KEY . "', { action: 'submit' }).then(function (token) {
                const recaptchaResponse1 = document.getElementById('recaptchaResponse1');
                recaptchaResponse1.value = token;
                const recaptchaResponse2 = document.getElementById('recaptchaResponse2');
                recaptchaResponse2.value = token;
            });
        });
    </script>";
    }
    ?>
</head>

<body>
<div class="site-wrapper" id="top">
    <div class="site-header d-none d-lg-block">
        <div class="header-middle pt--10 pb--10">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 ">
                        <a href="/" class="site-brand">
                            <img src="../assets/image/logo.png" alt="">
                        </a>
                    </div>
                    <div class="col-lg-6">
                        <div class="main-navigation flex-lg-right">
                            <ul class="main-menu menu-right ">
                                <li class="menu-item">
                                    <a href="/">Home</a>
                                </li>
                                <?php
                                if (Session::is_user_logged_in()) {
                                    echo '<li class="menu-item has-children">
                                    <a href="javascript:void(0)">' . $_SESSION['first_name'] . ' <i
                                                class="fas fa-chevron-down dropdown-arrow"></i></a>
                                    <ul class="sub-menu">
                                        <li><a href="/personal_account">My account</a></li>
                                        <li><a href="/login/sign_out.php">Sign out</a></li>
                                    </ul>
                                </li>';
                                } else {
                                    echo '<li class="menu-item">
                                    <a href="/login">Log in / Sign up</a>
                                </li>';
                                }
                                ?>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom pb--10">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="header-search-block">
                            <input type="text" placeholder="Search for a title">
                            <button>Search</button>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="main-navigation flex-lg-right">
                            <div class="cart-widget">
                                <div class="cart-block">
                                    <div class="cart-total">
                                        <span class="text-item">
												Shopping Cart
											</span>
                                    </div>
                                    <div class="cart-dropdown-block">

                                        <div class=" single-cart-block ">
                                            <div class="btn-block">
                                                <a href="/login/cart.php?view" class="btn">View Cart <i
                                                            class="fas fa-chevron-right"></i></a>
                                                <a href="/login/checkout.php?start" class="btn btn--primary">Check Out <i
                                                            class="fas fa-chevron-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="site-mobile-menu">
        <header class="mobile-header d-block d-lg-none pt--10 pb-md--10">
            <div class="container">
                <div class="row align-items-sm-end align-items-center">
                    <div class="col-md-4 col-7">
                        <a href="/" class="site-brand">
                            <img src="../assets/image/logo.png" alt="">
                        </a>
                    </div>
                    <div class="col-md-5 order-3 order-md-2">
                        <div class="header-top-widget">
                            <form>
                                <input type="text" autocomplete="off" placeholder="Search Here">
                                <button class="search-btn"><i class="ion-ios-search-strong"></i></button>
                                <div class="result"></div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-3 col-5  order-md-3 text-right">
                        <div class="mobile-header-btns header-top-widget">
                            <ul class="header-links">
                                <li class="sin-link">
                                    <a href="/login/cart.php?view" class="cart-link link-icon"><i class="ion-bag"></i></a>
                                </li>
                                <li class="sin-link">
                                    <a href="javascript:" class="link-icon hamburgur-icon off-canvas-btn"><i
                                                class="ion-navicon"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!--Off Canvas Navigation Start-->
        <aside class="off-canvas-wrapper">
            <div class="btn-close-off-canvas">
                <i class="ion-android-close"></i>
            </div>
            <div class="off-canvas-inner">
                <!-- search box start -->
                <div class="search-box offcanvas">
                    <form>
                        <input type="text" placeholder="Search Here">
                        <button class="search-btn"><i class="ion-ios-search-strong"></i></button>
                    </form>
                </div>
                <!-- search box end -->
                <!-- mobile menu start -->
                <div class="mobile-navigation">
                    <!-- mobile menu navigation start -->
                    <nav class="off-canvas-nav">
                        <ul class="mobile-menu main-mobile-menu">
                            <li class="menu-item">
                                <a href="/">Home</a>
                            </li>
                            <?php
                            if (Session::is_user_logged_in()) {
                                echo '<li class="menu-item has-children">
                                <a href="javascript:void(0)">' . $_SESSION['first_name'] . '</a>
                                <ul class="sub-menu">
                                    <li><a href="/personal_account">My account</a></li>
                                    <li><a href="/login/sign_out.php">Sign out</a></li>
                                </ul>
                            </li>';
                            } else {
                                echo '<li class="menu-item">
                                    <a href="/login">Log in / Sign up</a>
                                </li>';
                            }
                            ?>
                        </ul>
                    </nav>
                    <!-- mobile menu navigation end -->
                </div>
                <!-- mobile menu end -->

                <div class="off-canvas-bottom">
                    <div class="contact-list mb--10">
                        <a href="" class="sin-contact"><i class="fas fa-mobile-alt"></i>(12345) 78790220</a>
                        <a href="" class="sin-contact"><i class="fas fa-envelope"></i>examle@handart.com</a>
                    </div>
                    <div class="off-canvas-social">
                        <a href="#" class="single-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="single-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="single-icon"><i class="fas fa-rss"></i></a>
                        <a href="#" class="single-icon"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="single-icon"><i class="fab fa-google-plus-g"></i></a>
                        <a href="#" class="single-icon"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </aside>
        <!--Off Canvas Navigation End-->
    </div>
    <div class="sticky-init fixed-header common-sticky">
        <div class="container d-none d-lg-block">
            <div class="row align-items-center">
                <div class="col-lg-4">
                    <a href="/" class="site-brand">
                        <img src="../assets/image/logo.png" alt="">
                    </a>
                </div>
                <div class="col-lg-8">
                    <div class="main-navigation flex-lg-right">
                        <ul class="main-menu menu-right ">
                            <li class="menu-item">
                                <a href="/">Home</a>
                            </li>
                            <?php
                            if (Session::is_user_logged_in()) {
                                echo '<li class="menu-item has-children">
                                    <a href="javascript:void(0)">' . $_SESSION['first_name'] . ' <i
                                                class="fas fa-chevron-down dropdown-arrow"></i></a>
                                    <ul class="sub-menu">
                                        <li><a href="/personal_account">My account</a></li>
                                        <li><a href="/login/sign_out.php">Sign out</a></li>
                                    </ul>
                                </li>';
                            } else {
                                echo '<li class="menu-item">
                                    <a href="/login">Log in / Sign up</a>
                                </li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
