<?php include("includes/application_top2.php");
$data = get_tuple("html", page_name(), "html_name");
if(!$data["html_title"])
{
	if(function_exists(page_name()))
	{
		// eval("\$data = ".page_name()."();");
	}
	else
	{
		$data["html_title"] = ucwords(page_name());
		$data["html_heading"] = ucwords(page_name());
		$data["html_text"] = 'Website Under Consturction';
	}
}?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Investor Insight</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include('template_parts/head.php'); ?>

    <!-- JavaScript code to initialize the map -->
    <script>
    function initMap() {
        // Create a map object and specify the DOM element for display.
        var map = new google.maps.Map(document.getElementById('google_map'), {
            center: {
                lat: 24.8607,
                lng: 67.0011
            }, // Replace with your desired coordinates
            zoom: 15, // Adjust the zoom level as needed
        });

        // You can add markers or other map elements here if needed.
    }
    </script>
    <!-- Include the Google Maps JavaScript API with your API Key -->
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC6HdSMVIvampgqq0uqJQmt1rDg7aGjoqw&callback=initMap" async defer></script> -->


</head>

<body>
    <?php include('template_parts/header.php'); ?>
    <!-- Map Section Start -->
    <section class="google_map">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 noPadding">
                    <div class="map" id="google_map"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- Map Section End -->

    <?php
        $main_data = '
        <div class="col-lg-10 offset-lg-1 col-md-12">
            <div class="contact_form">
                <form method="post" action="" id="contact_form">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <input type="text" name="con_name" class="required" placeholder="Your Name *"/>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <input type="email" name="con_email" class="required" placeholder="Your Email *"/>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <input type="text" name="con_phone" class="required" placeholder="Your Phone *"/>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <select name="con_subject">
                                <option value="">I Would Like to Discuss</option>
                                <option value="Loan Management">Loan Management</option>
                                <option value="Investment Management">Investment Management</option>
                            </select>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <textarea name="con_message" class="required" placeholder="Your Message *"></textarea>
                        </div>
                        <div class="col-lg-12 col-md-12 text-center">
                            <button type="submit" name="send_message" class="fnc_btn reverses"><span>Send Message<i class="bx bx-right-arrow-alt"></i></span></button>
                            <img src="images/loader.gif" alt="" class="fn_loader"/>
                        </div>
                        <div class="col-lg-12 con_message"></div>
                    </div>
                </form>
            </div>
        </div>';
        echo wrap_form($main_data, 'Get In Touch', 'Contact Us')?>

    <p style="text-align: center;">Thank you for considering Investor Insight for your financial needs.
        We look forward to assisting you with our comprehensive range of services.<br> To get in touch with us, please
        find our contact details below:</p>

    <!-- Contact Info Section Start -->
    <section class="contact_info_section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="icon_box_03 text-center">
                        <i class="bx bxs-map"></i>
                        <h3>Our Address</h3>
                        <p>
                            KARACHI-PAKISTAN
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="icon_box_03 text-center">
                        <i class="bx bx-support"></i>
                        <h3>Our Phones</h3>
                        <p>
                            +9232-02755331
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="icon_box_03 text-center">
                        <i class="bx bx-at"></i>
                        <h3>Our Emails</h3>
                        <p>
                            ta2899274@gmail.com
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <p style="text-align: center;">Reach out to our team of financial experts to discuss your specific requirements,
            schedule a consultation, or inquire about our services.<br> We are here to support your financial success
            and provide tailored solutions to suit your unique needs. Let us illuminate your financial future.</p>
    </section>
    <!-- Contact Info Section End -->
    <?php include('template_parts/footer.php'); ?>
</body>

</html>