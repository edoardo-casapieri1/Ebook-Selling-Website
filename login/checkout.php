<?php
require_once realpath(__DIR__ . '/../vendor/autoload.php');
Session::start();

if (isset($_GET['start'])){
    unset($_SESSION['stage']);
    if(!isset($_COOKIE['items'])){
        Redirector::redirectToErrorPage(404, "There are no items in the cart");
    }
    $_SESSION['items'] = explode(',', $_COOKIE['items']);
}

if (!isset($_SESSION['stage']) || $_SESSION['stage'] == 0) {
    // first stage of checkout: login
    include "checkout_0_login.php";

} elseif ($_SESSION['stage'] == 1){
    // second stage of checkout: payment
    include "checkout_1_payment.php";
} elseif ($_SESSION['stage'] == 2){
    // second stage of checkout: confirmation

    include "checkout_2_confirmation.php";
} else {
    //Send user back to first stage
    error_log("checkout: undefined stage ".$_SESSION['stage']." resetting to first stage.");

    unset($_SESSION['stage']);

    include "checkout_0_login.php";
}
