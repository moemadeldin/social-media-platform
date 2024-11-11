<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fc;
            color: #333;
        }

        .email-wrapper {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .email-header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 24px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .email-body {
            padding: 30px;
            text-align: center;
            font-size: 16px;
            color: #555;
        }

        .otp-container {
            margin: 20px 0;
            background-color: #f7f7f7;
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
            font-size: 30px;
            font-weight: bold;
            color: #333;
            background-color: #e8f5e9;
        }

        .footer {
            background-color: #f4f4f4;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #999;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        .footer a {
            color: #4CAF50;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="email-wrapper">
        <div class="email-header">
            OTP Verification Code
        </div>

        <div class="email-body">
            <p>Hi there!</p>
            <p>We received a request to verify your identity. Here is your OTP code:</p>

            <div class="otp-container">
                {{ $otp }}
            </div>

            <p>This code is valid for 10 minutes. If you didn't request this, please ignore this email.</p>
        </div>

        <div class="footer">
            <p>Thank you for using our service!</p>
            <p>If you need help, visit <a href="https://support.yoursite.com">Support</a>.</p>
        </div>
    </div>

</body>

</html>
