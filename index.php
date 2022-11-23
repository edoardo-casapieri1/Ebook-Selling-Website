
<?php

require_once realpath(__DIR__ . '/vendor/autoload.php');
require_once realpath(TEMPLATES_DIR . '/header.php');

if (!isset ($_GET['page']) ) {
    $page = 1;
}else{
    $page = $_GET['page'];
}

$maxNumberOfPages = 1;

function active($currect_page){
    global $page;
    if($currect_page == $page){
        return 'active'; //class name in css
    }
}

function move($movement){
    global $maxNumberOfPages;
    if ($movement < 1){
        $movement = 1;
    }else if ($movement > $maxNumberOfPages){
        $movement = $maxNumberOfPages;
    }
    return "http://localhost/index.php?page=".$movement;
}

?>

<script>
    $(document).ready(function(){
        $('.header-search-block input[type="text"]').on("keyup input", function(){
            var inputVal = $(this).val();
            if(inputVal.length){
                $.get("core/backend-search.php", {term: inputVal}).done(function(data){
                    // Display the returned data in browser
                    document.getElementById("ListProduct").innerHTML = "";
                    $("#ListProduct").append(data);
                    if(data === "No matches found"){
                        document.getElementById("ListProduct").innerHTML = "";
                    }
                });
            }else{
                document.getElementById("ListProduct").innerHTML = "";
                $.get("core/fillProducts.php", {page: <?php echo $page?>}).done(function(data){
                    // Display the returned data in browser
                    $("#ListProduct").append(data);
                });
            }
        });

        // Set search input value on click of result item
        $(document).on("click", ".result p", function(){
            $(this).parents(".header-search-block").find('input[type="text"]').val($(this).text());
            $(this).parent(".result").empty();
        });
    });
</script>

    <main class="inner-page-sec-padding-bottom">
        <div class="container">
            <div class="shop-product-wrap list with-pagination row space-db--30 shop-border" id="ListProduct">
                    <script>
                    $.get("core/fillProducts.php", {page: <?php echo $page?>}).done(function(data){
                        // Display the returned data in browser
                        $("#ListProduct").append(data);
                    });
                    </script>
            </div>
            <!-- Pagination Block -->
            <div class="row pt--30">
                <div class="col-md-12">
                    <div class="pagination-block">
                        <ul class="pagination-btns flex-center">
                            <?php
                                $dao = new Dao();
                                $numPages = $dao -> getNumberOfPages(12);
                                $i = 1;
                                while ($i <= $numPages) {
                                    echo '<li class="'. active($i) .'"><a class="single-btn" href="http://localhost/index.php?page='.$i. '">'. $i . '</a></li>';
                                    if ($i > $maxNumberOfPages)
                                        $maxNumberOfPages = $i;
                                    $i = $i+1;
                                }
                                echo '<li><a href="'. move($page-2).'"class="single-btn prev-btn " id="PrevButton1">|<i class="zmdi zmdi-chevron-left"></i> </a></li>';
                                echo '<li><a href="'. move($page-1).'"class="single-btn prev-btn " id="PrevButton2"><i class="zmdi zmdi-chevron-left"></i> </a></li>';
                                echo '<li><a href="'. move($page+1).'" class="single-btn next-btn"><i class="zmdi zmdi-chevron-right"></i></a></li>
                                      <li><a href="'. move($page+2).'" class="single-btn next-btn"><i class="zmdi zmdi-chevron-right"></i>|</a></li>';
                             ?>
                        </ul>
                    </div>
                </div>
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