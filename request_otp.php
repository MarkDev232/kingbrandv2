<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request OTP</title>
</head>
<body>
    <form action="send_otp.php" method="POST">
        <label for="mobile">Enter your registered mobile number:</label>
        <input type="text" id="mobile" name="mobile" required>
        <button type="submit">Request OTP</button>
    </form>
</body>
</html>
