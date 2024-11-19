<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Service</title>
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
        }
        .content p {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }
        .user-info {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            color: #333;
        }
        .user-info h2 {
            font-size: 18px;
            margin-top: 0;
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
            <h1>Welcome to Our Service, {{ $name }}!</h1>
        </div>
        <div class="content">
            <p>Dear {{ $name }},</p>
            <p>Thank you for joining us! We’re thrilled to have you on board. Here’s a quick summary of your account details:</p>
            <div class="user-info">
                <h2>Your Account Information</h2>
                <p><strong>Email:</strong> {{ $email }}</p>
                <p><strong>Password:</strong> {{ $password }}</p>
            </div>
            <p>We recommend keeping this information secure. Feel free to reach out if you have any questions. Welcome once again!</p>
        </div>
        <div class="footer">
            <p>&copy;©2024 Code Logic Technologies Pvt. Ltd.   All rights reserved</p>
        </div>
    </div>
</body>
</html>
