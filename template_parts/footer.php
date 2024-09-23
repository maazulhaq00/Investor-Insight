<!-- Footer Start -->
<footer class="footer_01">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-3 col-xl-4">
                        <div class="widget">
                            <div class="about_widget">
                                <div class="aw_logo">
                                    <a href="#"><img src="<?php echo BASE_URL; ?>images/footer.png" alt="" /></a>
                                </div>
                                <p>
                                Investor Insight, based in Dubai, UAE, offers expert financial solutions, including Fund Accounting, Property Level Accounting, Taxation Services, and more. With a seasoned team of ACCAs and M. Coms, we tailor personalized strategies for clients in Private Equity, Real Estate, Hedge Funds, and more. Our commitment to excellence and transparency illuminates the path to your financial prosperity.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-xl-2">
                        <div class="widget">
                            <h3 class="widget-title">Help Center</h3>
                            <ul>
                                <li><a href="contact_us.php">Contact Us</a></li>
                                <li><a href="privacy_policy.php">Privacy Policy</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-xl-2">
                        <div class="widget">
                            <h3 class="widget-title">Our Services</h3>
                            <?=service_list(); ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-xl-4 pdl95">
                        <div class="widget subscribe_widgets">
                            <h3 class="widget-title">Stay Updated</h3>
                            <div class="subscribe_content">
                                <p>
                                    Enter your email address into our subscribe form to keep yourself updating with our newslatter.
                                </p>
                                <form action="subscription.php" method="post">
                                    <!-- <input type="name" placeholder="Your Name *" name="s_email" required/> -->
                                    <input type="email" placeholder="Your Email *" name="email" required/>
                                    <button type="submit" name="s_submit"><i class="bx bx-right-arrow-alt"></i></button>
                                </form>
                                <div class="form_note text-right">Get all <span>updates and offers</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Footer End -->

        <!-- Copyright Section Start -->
        <section class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="copbar"></div>
                        <p class="copies">
                        <?php echo date("Y") ?> &copy; <a href="#">Web Development</a> by TrafficBuilder.biz. All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Copyright Section End -->
        
        <!-- Back To Top Start -->
        <a href="#" id="backtotop"><i class="bx bxs-arrow-to-top"></i></a>
        <!-- Back To Top End -->


        <!-- Include All JS -->
        <script src="<?=BASE_URL?>js/jquery.js"></script>
        <script src="<?=BASE_URL?>js/jquery-ui.js"></script>
        <script src="<?=BASE_URL?>js/bootstrap.min.js"></script>
        <script src="<?=BASE_URL?>js/owl.carousel.min.js"></script>
        <script src="<?=BASE_URL?>js/jquery.shuffle.min.js"></script>
        <?php 
        $page_name = page_name();
        // debug_r($page_name);
        if($page_name == "contact_us") {
            echo '<script src="https://maps.google.com/maps/api/js?key=AIzaSyC6HdSMVIvampgqq0uqJQmt1rDg7aGjoqw&callback=initMap"></script>
            <script src="'.BASE_URL.'js/gmaps.js"></script>';
        }
        echo '<script src="'.BASE_URL.'js/jquery.plugin.min.js"></script>';
        if($page_name == 'index') {
            echo '<script src="'.BASE_URL.'js/jquery.countdown.min.js"></script>';
        }
        ?>
        <script src="<?=BASE_URL?>js/jquery.appear.js"></script>
        <script src="<?=BASE_URL?>js/lightcase.js"></script>

        <script src="<?=BASE_URL?>js/jquery.themepunch.tools.min.js"></script>
        <script src="<?=BASE_URL?>js/jquery.themepunch.revolution.min.js"></script>

        <!-- Rev slider Add on Start -->
        <script src="<?=BASE_URL?>js/extensions/revolution.extension.actions.min.js"></script>
        <script src="<?=BASE_URL?>js/extensions/revolution.extension.carousel.min.js"></script>
        <script src="<?=BASE_URL?>js/extensions/revolution.extension.kenburn.min.js"></script>
        <script src="<?=BASE_URL?>js/extensions/revolution.extension.layeranimation.min.js"></script>
        <script src="<?=BASE_URL?>js/extensions/revolution.extension.migration.min.js"></script>
        <script src="<?=BASE_URL?>js/extensions/revolution.extension.navigation.min.js"></script>
        <script src="<?=BASE_URL?>js/extensions/revolution.extension.parallax.min.js"></script>
        <script src="<?=BASE_URL?>js/extensions/revolution.extension.slideanims.min.js"></script>
        <script src="<?=BASE_URL?>js/extensions/revolution.extension.video.min.js"></script>
        <!-- Rev slider Add on End -->

        <script src="<?=BASE_URL?>js/theme.js"></script>
        <!-- JavaScript for AJAX Form Submission -->
        <script>
        var isloading = false;
        $(document).ready(function() {
            if($("#quoteForm").length > 0)
            $("#quoteForm").submit(function(event) {
                if(isloading) return;
                event.preventDefault(); // Prevent the default form submission
                
                // Serialize the form data
                var formData = $(this).serialize();
                isloading = true;
                // Send an AJAX request to insert_quote.php
                $.ajax({
                    type: "POST",
                    url: "insert_quote.php", // Path to your PHP script
                    data: formData,
                    success: function(response) {
                        isloading = false;
                        // debugger;
                        if (response === "success") {
                            alert("We've received your quote request. Our team will review and get back to you shortly. Thank you!");
                            location.reload();
                            // You can redirect or perform additional actions here
                        } else {
                            alert("Your request has been send successfully.");
                        }
                    }
                });
            });
        });
        </script>