<?php

require_once realpath(__DIR__ . '/../vendor/autoload.php');

if (Session::is_user_logged_in()) {
    Redirector::redirect_to_personal_account();
} else {
    if ((!isset($_GET['token']) || empty($_GET['token'])) ||
        (!isset($_GET['selector']) || empty($_GET['selector'])))
    {
        Redirector::redirect_to_homepage();
    } else {

        $token = $_GET['token'];
        $selector = $_GET['selector'];
        $ip_port = Utils::get_ip_and_port();

        $dao = new Dao();

        if ($dao->verify_activation_token($selector, $token, $ip_port)) {

            Redirector::redirect_to_login_after(5);

            require_once realpath(TEMPLATES_DIR . '/header.php');

            echo
            '<section class="breadcrumb-section">
        <h2 class="sr-only">Site Breadcrumb</h2>
        <div class="container">
            <div class="breadcrumb-contents">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/login">Login</a></li>
                        <li class="breadcrumb-item active">Activate account</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>


    <main class="page-section inner-page-sec-padding-bottom" style="padding-bottom: 250px">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xs-12 col-lg-12 mb--30 mb-lg--0">
                    <h1><strong>Account activated</strong></h1>
                    <br>
                    <h4>Your e-mail has been verified. You may now log in using your credentials.</h4>
                    <br>
                    <h5>If you are not redirected within 5 seconds, 
                    <strong><a href="/login" style="color: #62ab00 !important">click here</a></strong>.</h5>
                </div>
            </div>
        </div>
    </main>
</div>';

            require_once realpath(TEMPLATES_DIR . '/footer.php');
            exit;

        } else {

            require_once realpath(TEMPLATES_DIR . '/header.php');

            ?>

            <section class="breadcrumb-section">
                <h2 class="sr-only">Site Breadcrumb</h2>
                <div class="container">
                    <div class="breadcrumb-contents">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item"><a href="/login">Login</a></li>
                                <li class="breadcrumb-item active">Activate account</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </section>

            <main class="page-section inner-page-sec-padding-bottom" style="padding-bottom: 280px">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-xs-12 col-lg-12 mb--30 mb-lg--0">
                            <h1><strong>Invalid token</strong></h1>
                            <br><h4>It appears that the token is not valid. To receive a new one, sign up again.<br>
                                <strong>
                                    <a href="/login" style="color: #62ab00 !important">Click here</a>
                                </strong>
                                to return to the sign up page.
                            </h4>
                        </div>
                    </div>
                </div>
            </main>

            </div>

            <?php

            require_once realpath(TEMPLATES_DIR . '/footer.php');
        }
    }
}

