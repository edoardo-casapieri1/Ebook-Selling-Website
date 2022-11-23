<?php
require_once realpath(__DIR__ . '/../vendor/autoload.php');

$set = false;
if (!isset($_COOKIE['items'])) {
    $items = array();
} else {
    $items = explode(',', $_COOKIE['items']);
    $set = true;
}

$change = false;

if (isset($_GET['add']) && is_numeric($_GET['add'])) {
    // Adding a new item to the cart
    $book_id = $_GET['add'];
    if (!in_array($book_id, $items)) {
        array_push($items, $book_id);
        $change = true;
    }
}

if (isset($_GET['remove']) && is_numeric($_GET['remove'])) {
    // Removing a new item from the cart
    $book_id = $_GET['remove'];
    $index = array_search($book_id, $items);
    if ($index !== false) {
        unset($items[$index]);
        $change = true;
    }
}
$dao = new Dao();
// Create a prepared statement based on the number of books I need
$cart = $dao -> get_books($items);
$cart_total = 0;

if ($change) {
    setcookie("items", implode(',', $items), time() + 3600 * 24 * 7);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Your current cart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../assets/css/plugins.css"/>
    <link rel="stylesheet" type="text/css" media="screen" href="../assets/css/main.css"/>
    <link rel="shortcut icon" type="image/x-icon" href="../assets/image/favicon.ico">
    <script src="<?= JQUERY_URL ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
            integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn"
            crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js?render=<?= SITE_KEY ?>"></script>
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
                            <div class=" single-cart-block ">
                                <div class="btn-block">
                                    <a href="checkout.php?start" class="btn btn--primary">Check Out <i
                                                class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom pb--10">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4">
                        <div class="main-navigation flex-lg-right">
                            <div class="cart-widget">
                                <div class="cart-block">
                                    <div class="cart-total">
                                        <span class="text-item">
												Your current Shopping Cart
											</span>
                                        <span class="price">
                                                <?php
												if (!empty($cart)) {
                                                    foreach ($cart as $c) {
                                                        $cart_total += $c->getPrice();
                                                    }
                                                    echo number_format((float)$cart_total, 2, '.', '') . ' €';
												}
												else echo '0';
												?>
												<i class="fas fa-chevron-down"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    if (isset($_GET['notice']) && $_GET['notice']== "removed_items")
    echo '<div class="alert alert-danger" role="alert">You already owned some items. They have been removed from your cart.</div>';
    ?>
    <main class="inner-page-sec-padding-bottom">
        <div class="container">
            <div class="shop-product-wrap list with-pagination row space-db--30 shop-border" id="ListProduct">
                <?php
                    if (!empty($cart)) {
                        foreach ($cart as $c) {
                            //echo '<div>' . $product->getId() . '</div>'
                            echo '
                    <div class="col-lg-4 col-sm-6">
                        <div class="product-card card-style-list">
                            <div class="product-list-content">
                                <div class="product-card--body">
                                    <div class="product-header">
                                        <a class="author">' . $c->getAuthor() . '
                                        </a>
                                        <h3><a tabindex="0">' . $c->getTitle() . '</a></h3>
                                    </div>
                                    <article>
                                        <h2 class="sr-only">Card List Article</h2>
                                        <p>' . $c->getDescription() . '</p>
                                    </article>
                                    <div class="price-block">
                                        <span class="price">' . number_format((float)$c->getPrice(), 2, '.', '') . ' €</span>
                                    </div>
                                    <div class="btn-block">
                                        <a href="cart.php?remove=' . $c->getID() . '" class="btn btn-outlined">Remove From Cart</a>
                                    </div>
                                    ';
                            echo '
                                </div>
                            </div>
                        </div>
                    </div>';
                        }
                    }?>
            </div>
            <!-- Modal -->
            <div class="modal fade modal-quick-view" id="quickModal" tabindex="-1" role="dialog"
                 aria-labelledby="quickModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <button type="button" class="close modal-close-btn ml-auto" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="product-details-modal">
                            <div class="row">
                                <div class="col-lg-5">
                                    <!-- Product Details Slider Big Image-->
                                    <div class="product-details-slider sb-slick-slider arrow-type-two"
                                         data-slick-setting='{
              "slidesToShow": 1,
              "arrows": false,
              "fade": true,
              "draggable": false,
              "swipe": false,
              "asNavFor": ".product-slider-nav"
              }'>
                                        <div class="single-slide">
                                            <img src="assets/image/products/product-details-1.jpg" alt="">
                                        </div>
                                        <div class="single-slide">
                                            <img src="assets/image/products/product-details-2.jpg" alt="">
                                        </div>
                                        <div class="single-slide">
                                            <img src="assets/image/products/product-details-3.jpg" alt="">
                                        </div>
                                        <div class="single-slide">
                                            <img src="assets/image/products/product-details-4.jpg" alt="">
                                        </div>
                                        <div class="single-slide">
                                            <img src="assets/image/products/product-details-5.jpg" alt="">
                                        </div>
                                    </div>
                                    <!-- Product Details Slider Nav -->
                                    <div class="mt--30 product-slider-nav sb-slick-slider arrow-type-two"
                                         data-slick-setting='{
            "infinite":true,
              "autoplay": true,
              "autoplaySpeed": 8000,
              "slidesToShow": 4,
              "arrows": true,
              "prevArrow":{"buttonClass": "slick-prev","iconClass":"fa fa-chevron-left"},
              "nextArrow":{"buttonClass": "slick-next","iconClass":"fa fa-chevron-right"},
              "asNavFor": ".product-details-slider",
              "focusOnSelect": true
              }'>
                                        <div class="single-slide">
                                            <img src="assets/image/products/product-details-1.jpg" alt="">
                                        </div>
                                        <div class="single-slide">
                                            <img src="assets/image/products/product-details-2.jpg" alt="">
                                        </div>
                                        <div class="single-slide">
                                            <img src="assets/image/products/product-details-3.jpg" alt="">
                                        </div>
                                        <div class="single-slide">
                                            <img src="assets/image/products/product-details-4.jpg" alt="">
                                        </div>
                                        <div class="single-slide">
                                            <img src="assets/image/products/product-details-5.jpg" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-7 mt--30 mt-lg--30">
                                    <div class="product-details-info pl-lg--30 ">
                                        <p class="tag-block">Tags: <a href="#">Movado</a>, <a href="#">Omega</a></p>
                                        <h3 class="product-title">Beats EP Wired On-Ear Headphone-Black</h3>
                                        <ul class="list-unstyled">
                                            <li>Ex Tax: <span class="list-value"> £60.24</span></li>
                                            <li>Brands: <a href="#" class="list-value font-weight-bold"> Canon</a>
                                            </li>
                                            <li>Product Code: <span class="list-value"> model1</span></li>
                                            <li>Reward Points: <span class="list-value"> 200</span></li>
                                            <li>Availability: <span class="list-value"> In Stock</span></li>
                                        </ul>
                                        <div class="price-block">
                                            <span class="price-new">£73.79</span>
                                            <del class="price-old">£91.86</del>
                                        </div>
                                        <div class="rating-widget">
                                            <div class="rating-block">
                                                <span class="fas fa-star star_on"></span>
                                                <span class="fas fa-star star_on"></span>
                                                <span class="fas fa-star star_on"></span>
                                                <span class="fas fa-star star_on"></span>
                                                <span class="fas fa-star "></span>
                                            </div>
                                            <div class="review-widget">
                                                <a href="">(1 Reviews)</a> <span>|</span>
                                                <a href="">Write a review</a>
                                            </div>
                                        </div>
                                        <article class="product-details-article">
                                            <h4 class="sr-only">Product Summery</h4>
                                            <p>Long printed dress with thin adjustable straps. V-neckline and wiring
                                                under the Dust with ruffles at the bottom
                                                of the
                                                dress.</p>
                                        </article>
                                        <div class="add-to-cart-row">
                                            <div class="count-input-block">
                                                <span class="widget-label">Qty</span>
                                                <input type="number" class="form-control text-center" value="1">
                                            </div>
                                        </div>
                                        <div class="compare-wishlist-row">
                                            <a href="" class="add-link"><i class="fas fa-heart"></i>Add to Wish
                                                List</a>
                                            <a href="" class="add-link"><i class="fas fa-random"></i>Add to
                                                Compare</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="widget-social-share">
                                <span class="widget-label">Share:</span>
                                <div class="modal-social-share">
                                    <a href="#" class="single-icon"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#" class="single-icon"><i class="fab fa-twitter"></i></a>
                                    <a href="#" class="single-icon"><i class="fab fa-youtube"></i></a>
                                    <a href="#" class="single-icon"><i class="fab fa-google-plus-g"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<?php

require_once realpath(TEMPLATES_DIR . '/footer.php');

?>


