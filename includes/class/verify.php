<?php
function verify()
{
    $db = new db2();
    $client_id = $_GET["id"];
    $token = $_GET["token"];
    if(!$token || !$client_id)
    {
        echo 'Invalid URL';
        exit;
    }
    
    $sql = "select * from client where otp = '$token' AND status = '0'";
    $client = $db->result($sql, 1);
    if($client)
    {
        $client_name = $client['name'];
        $email = $client['email'];
        
        $body = "<p>Dear $client_name,</p>
        <p>Congratulations! We're delighted to inform you that your registration verification was successful.</p>
        <p>You now have full access to all the features and benefits of ".SITE_NAME.". We're excited to have you as a part of our community.</p>
        <p>Should you have any questions or require assistance, don't hesitate to contact our support team at ta2899274@gmail.com. Thank you for choosing ".SITE_NAME.".</p>
        <p>Best regards,</p>
        ".SITE_NAME."<br>";
        $subject = 'Registration Verification Successful';
        $msg = email($email, $subject, $body);

        $msg = email(SITE_ADMIN_EMAIL, "New ".$subject, $body);
        $sql = "update client set
        status = '1',
        otp = '' WHERE id = ".$client["id"];
        $db->sqlq($sql);
        alert($subject);
        redirect("index.php");
    }
    else
    {
        alert('Registration Verification failed.');
        redirect("index.php");
    }
    // debug_r($client);
}
