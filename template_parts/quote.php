<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quote Form</title>
    <!-- Include jQuery for AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
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
                                        <option value="">I Would Like to Discuss *</option>
                                        <option value="1">It's About Mutual Fund Investment</option>
                                        <option value="2">Bank Loan Interest</option>
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
    <!-- Quote Section End -->

    <!-- JavaScript for AJAX Form Submission -->
    <script>
    var isloading = false;
    $(document).ready(function() {
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
                        alert("Your requiest is received sucessfully.");
                        // You can redirect or perform additional actions here
                    } else {
                        // alert("Data insertion failed. Please try again.");
                    }
                }
            });
        });
    });
    </script>
</body>
</html>
