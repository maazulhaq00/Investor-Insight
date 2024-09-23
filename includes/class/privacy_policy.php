<?php
// Include any necessary functions or database connection code here.

// Define the about_us function
function privacy_policy() {
    // Create an array to hold the data for the page
    $data_n = [];
    $data_n["html_head"] = '';  // You can set the HTML head content here if needed.
    $data_n["html_title"] = 'Privacy Policy'; // Set the title
    $data_n["html_heading"] = 'Privacy Policy'; // Set the heading

    // Custom HTML content for the "privacy policy" section
    $data_n["html_text"] = '
    <p>At Investor Insight, we are committed to protecting the privacy and confidentiality of our clients, visitors, and users of our website. This Privacy Policy outlines how we collect, use, disclose, and safeguard your personal information. By accessing our website and using our services, you consent to the practices described in this policy.<br>

Information Collection and Use:<br>
1.1 Personal Information: We may collect personal information such as your name, contact details, email address, and other relevant data when you voluntarily provide it to us through our contact forms, email inquiries, or when you sign up for our services.<br>

1.2 Usage Information: We gather non-personal information, including but not limited to, IP addresses, browser types, device identifiers, and website usage patterns. This information is collected automatically and helps us improve our website and services.<br>

How We Use Your Information:<br>
2.1 Service Delivery: We use your personal information to provide the services you have requested, including fund accounting, bookkeeping, taxation, financial analysis, and other financial services.<br>

2.2 Communication: We may use your contact information to communicate with you about our services, updates, newsletters, or important information related to your engagement with us.<br>

2.3 Website Improvement: The non-personal information collected helps us understand how visitors use our website, allowing us to enhance user experience and optimize our website\'s performance.<br>

Information Sharing and Disclosure:<br>
3.1 Third-Party Service Providers: We may share your personal information with trusted third-party service providers who assist us in delivering our services. These providers are bound by confidentiality agreements and are not allowed to use your information for any other purpose.<br>

3.2 Legal Requirements: We may disclose your personal information if required by law, court order, or to protect our rights, privacy, safety, or property.<br>

Security Measures:<br>
4.1 Data Security: We implement industry-standard security measures to protect your personal information from unauthorized access, disclosure, alteration, or destruction. However, no data transmission over the internet or electronic storage can be guaranteed 100% secure, so we cannot guarantee absolute security.<br>

Your Choices and Rights:<br>
5.1 Access and Correction: You may request access to, review, and correct your personal information in our possession.

5.2 Opt-Out: You have the right to opt-out of receiving promotional communications from us. You can do so by following the unsubscribe instructions provided in our emails or by contacting us directly.<br>

Third-Party Links:<br>
Our website may contain links to third-party websites. Please note that we are not responsible for the privacy practices or content of such sites. We recommend reviewing the privacy policies of those websites before providing any personal information.<br>

Changes to this Policy:<br>
We may update this Privacy Policy periodically to reflect changes in our information practices. We will notify you of any significant updates through our website or other appropriate means.<br>

For any questions or concerns about this Privacy Policy or our data practices, please contact us using the provided contact information on our website.<p>
    ';
    // echo json_encode($data_n);die;
    return $data_n;
}