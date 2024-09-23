<?php
function quote()
{
    $temp = '
    <!-- Quote Section Start -->
    <section class="quote_section" id="request_quote_section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h5 class="sub_title lights">Get a Quote</h5>
                    <h2 class="sec_title lights">Request a Free Quote Today</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="quote_form">
                        <form id="quoteForm" method="post" action="#">
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <input type="text" name="q_fname" placeholder="First Name *" required />
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <input type="text" name="q_lname" placeholder="Last Name *" required />
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <input type="email" name="q_email" placeholder="Your Email *" required />
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <input type="tel" name="q_phone" placeholder="Your Phone *" required />
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <select name="q_type" required>
                                        <option value="">I Would Like to Discuss *</option>';
                                    $services = $_SESSION['data_service'];
                                    foreach ($services as $a) {
                                        extract($a);
                                        $name2 = strtolower(str_replace(' ', '_', $name));
                                        $temp .= '<option value="'.$name.'">'.$name.'</option>';
                                    }
                                    $temp .= '
                                    </select>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <button type="submit" name="q_submit"><span>Request a Quote<i class="bx bx-right-arrow-alt"></i></span></button>
                                    <div class="form_note text-right">
                                        Join Now! With <span>50% Discount</span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="client_slider owl-carousel">
                        <div class="cs_item">
                            <a href="#">
                            </a>
                        </div>
                        <div class="cs_item">
                            <a href="#">
                            </a>
                        </div>
                        <div class="cs_item">
                            <a href="#">
                            </a>
                        </div>
                        <div class="cs_item">
                            <a href="#">
                            </a>
                        </div>
                        <div class="cs_item">
                            <a href="#">
                            </a>
                        </div>
                        <div class="cs_item">
                            <a href="#">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Quote Section End -->';
    return $temp;
}
function insert_quote()
{
    $db = new db2();
    // Get form data from the AJAX request
    $fname = $_POST["q_fname"];
    $lname = $_POST["q_lname"];
    $email = $_POST["q_email"];
    $phone = $_POST["q_phone"];
    $type = $_POST["q_type"];
    
    $body = "
    First Name: $fname <br>
    Last Name: $lname <br>
    Email: $email <br>
    Phone: $phone <br>
    Type: $type <br>
    ";
    // debug_r($body);
    email(SITE_ADMIN_EMAIL, "Request for Quote - ".SITE_NAME, $body);

    // Insert data into the database
    $sql = "INSERT INTO quote_requests (`name`, email, phone, `type`) 
            VALUES ('$fname $lname', '$email', '$phone', '$type')";
    $db->sqlq($sql);
    echo 'success';die;
}