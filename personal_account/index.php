<?php

require_once realpath(__DIR__ . '/../vendor/autoload.php');

if (!Session::is_user_logged_in()) {
    Redirector::redirect_to_login();
    exit();
}

require_once realpath(TEMPLATES_DIR . '/header.php');

?>

    <section class="breadcrumb-section">
        <h2 class="sr-only">Site Breadcrumb</h2>
        <div class="container">
            <div class="breadcrumb-contents">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Personal account</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    <div class="page-section inner-page-sec-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <!-- My Account Tab Menu Start -->
                        <div class="col-lg-3 col-12">
                            <div class="myaccount-tab-menu nav" role="tablist">
                                <a href="#orders" data-toggle="tab"><i class="fa fa-cart-arrow-down"></i> Orders</a>
                                <a href="#download" data-toggle="tab"><i class="fas fa-download"></i> Download</a>
                            </div>
                        </div>
                        <!-- My Account Tab Menu End -->
                        <!-- My Account Tab Content Start -->
                        <div class="col-lg-9 col-12 mt--30 mt-lg--0">
                            <div class="tab-content" id="myaccountContent">
                                <!-- Single Tab Content Start -->
                                <div class="tab-pane fade show active" id="dashboad" role="tabpanel">
                                </div>
                                <!-- Single Tab Content End -->
                                <!-- Single Tab Content Start -->
                                <div class="tab-pane fade" id="orders" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3>Orders</h3>
                                        <div class="myaccount-table table-responsive text-center">
                                            <table class="table table-bordered">
                                                <thead class="thead-light">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Cart</th>
                                                    <th>Date</th>
                                                    <th>Total</th>
                                                </tr>
                                                </thead>
                                                <tbody id="OrdersTableHistoryBody">
                                                <script>
                                                    $.get("core/fillOrdersHistory.php", {user_id: <?php echo $_SESSION['user_id']?>}).done(function(data){
                                                        // Display the returned data in browser
                                                        $("#OrdersTableHistoryBody").append(data);
                                                    });
                                                </script>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Single Tab Content End -->
                                <!-- Single Tab Content Start -->
                                <div class="tab-pane fade" id="download" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3>Downloads</h3>
                                        <div class="myaccount-table table-responsive text-center">
                                            <table class="table table-bordered">
                                                <thead class="thead-light">
                                                <tr>
                                                    <th>Ord.</th>
                                                    <th>Product</th>
                                                    <th>Date</th>
                                                    <th>Download</th>
                                                </tr>
                                                </thead>
                                                <tbody id="OrdersTableBody">
                                                <script>
                                                    $.get("core/fillOrders.php", {user_id: <?php echo $_SESSION['user_id']?>}).done(function(data){
                                                        // Display the returned data in browser
                                                        $("#OrdersTableBody").append(data);
                                                    });
                                                </script>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Single Tab Content End -->
                                <!-- Single Tab Content Start -->
                                <div class="tab-pane fade" id="payment-method" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3>Payment Method</h3>
                                        <p class="saved-message">You Can't Saved Your Payment Method yet.</p>
                                    </div>
                                </div>
                                <!-- Single Tab Content End -->
                                <!-- Single Tab Content Start -->
                                <div class="tab-pane fade" id="address-edit" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3>Billing Address</h3>
                                        <address>
                                            <p><strong>Alex Tuntuni</strong></p>
                                            <p>1355 Market St, Suite 900 <br>
                                                San Francisco, CA 94103</p>
                                            <p>Mobile: (123) 456-7890</p>
                                        </address>
                                        <a href="#" class="btn btn--primary"><i class="fa fa-edit"></i>Edit
                                            Address</a>
                                    </div>
                                </div>
                                <!-- Single Tab Content End -->
                            </div>
                        </div>
                        <!-- My Account Tab Content End -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

<?php

require_once realpath(TEMPLATES_DIR . '/footer.php');

?>