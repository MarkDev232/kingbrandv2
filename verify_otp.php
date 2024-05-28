<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entered_otp = $_POST['otp'];

    if ($entered_otp == $_SESSION['otp']) {
        // OTP is correct
        $mobile = $_SESSION['mobile'];
        $new_password = generate_new_password();

        // Update new password in the database
        require 'database.php';
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE mobile = ?");
        $stmt->execute([password_hash($new_password, PASSWORD_DEFAULT), $mobile]);

        // Send new password via SMS
        send_sms($mobile, "Your new password is $new_password");

        echo "Your new password has been sent to your mobile number.";
        // Unset the session variables
        unset($_SESSION['otp']);
        unset($_SESSION['mobile']);
    } else {
        echo "Invalid OTP. Please try again.";
    }
}

function generate_new_password() {
    return bin2hex(random_bytes(4)); // Generate a random 8-character password
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
}
?>
