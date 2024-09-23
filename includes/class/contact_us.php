<?php 
/* functions without return */
function contact_us()
{
	$db = new db2();
    $action = $_GET['action'];
    switch ($action) {
        case 'submit':
            parse_str($_POST['form_data'], $form);
                        
            $MESSAGE = 'Hi Admin, <br/><br/>';
            $MESSAGE .= 'You got an user query from investor_insight. User details and Message are noted bellow: <br/><br/>';
            $MESSAGE .= 'Name : '.$form['con_name'].'<br/>';
            $MESSAGE .= 'Email : '.$form['con_email'].'<br/>';
            if(isset($form['con_subject']) && $form['con_subject'] != ''):
                $MESSAGE .= 'Subject : '.$form['con_subject'].'<br/>';
            endif;
            $MESSAGE .= 'Message : <br/>'.$form['con_message'].'<br/><br/>';
            $MESSAGE .= 'Regards';

            email(SITE_ADMIN_EMAIL, 'Contact Us Form | Investor Insight', $MESSAGE);
            break;
    }
	$data_n["html_head"] = '<script>
    function initMap() {
        // Create a map object and specify the DOM element for display.
        var map = new google.maps.Map(document.getElementById(\'google_map\'), {
            center: { lat: 24.8607, lng: 67.0011 }, // Replace with your desired coordinates
            zoom: 15, // Adjust the zoom level as needed
        });

        // You can add markers or other map elements here if needed.
    }
    </script>';
	$temp = '
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
    <!-- Map Section End -->';
	
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
    $temp .= wrap_form($main_data, 'Get In Touch', 'Contact Us');
    $temp .= '<p style="text-align: center;">Thank you for considering Investor Insight for your financial needs. We look forward to assisting you with our comprehensive range of services.<br> To get in touch with us, please find our contact details below:</p>

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
        <p style="text-align: center;" >Reach out to our team of financial experts to discuss your specific requirements, schedule a consultation, or inquire about our services.<br> We are here to support your financial success and provide tailored solutions to suit your unique needs. Let us illuminate your financial future.</p>
    </section>';
	$heading = "Contact us";
	$data_n["html_title"] = $heading;
	$data_n["html_heading"] = $heading;
	$data_n["html_text"] = $temp;
	return $data_n;
}
?>