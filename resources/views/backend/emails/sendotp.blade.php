<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP for Password Change</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #333;
        }
        .content {
            padding: 10px 20px;
            color: #555;
            font-size: 16px;
            line-height: 1.6;
        }
        .otp-code {
            display: block;
            font-size: 24px;
            color: #333;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            color: #aaa;
            font-size: 12px;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Password Change Request</h1>
        </div>
        <div class="content">
            <p>Hello,</p>
            <p>We received a request to change the password for your account. To confirm this action, please use the following OTP (One-Time Password):</p>
            <div class="otp-code">{{ $otp }}</div>
            <p>If you did not request a password change, please ignore this email or contact our support team immediately.</p>
        </div>
        <div class="footer">
            <p>&copy; ©2024 Code Logic Technologies Pvt. Ltd.   All rights reserved</p>
        </div>
    </div>
</body>
</html>
