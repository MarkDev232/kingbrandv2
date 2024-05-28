<?php
session_start();
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mobile = $_POST['mobile'];
    
    // Check if mobile number exists in the database
    $query = "SELECT * FROM user_table WHERE user_con_num = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $mobile);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $otp = rand(100000, 999999); // Generate a 6-digit OTP
        $_SESSION['otp'] = $otp;
        $_SESSION['mobile'] = $mobile;

        // Send OTP via SMS (assume send_sms is a function to send SMS)
        echo "Debug: OTP generated: $otp"; // Debug statement
        
        $sms_sent = send_sms($mobile, "Your OTP is $otp");
        if($sms_sent) {
            echo "OTP has been sent to your mobile number.";
            // Redirect to OTP verification page
            header('Location: verify_otp_form.php');
            exit();
        } else {
            echo "Failed to send OTP. Please try again later.";
        }
    } else {
        echo "Mobile number not found.";
    }
}

function send_sms($mobile, $message) {
    // Code to send SMS using an SMS gateway API
    // Example: using Twilio API
    /*
    $sid = 'your_account_sid';
    $token = 'your_auth_token';
    $client = new Twilio\Rest\Client($sid, $token);
    $client->messages->create(
        $mobile,
        [
            'from' => 'your_twilio_number',
            'body' => $message
        ]
    );
    */
    // For debugging purposes, assume the SMS is always sent successfully
    echo "Debug: Sending SMS to $mobile: $message"; // Debug statement
    return true; // Return true to simulate successful sending of SMS
}
?>
