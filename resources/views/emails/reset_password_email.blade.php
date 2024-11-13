<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to Our Platform</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f1f1f1;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            max-width: 200px;
        }

        .message {
            padding: 20px;
            background-color: #ffffff;
        }

        .message p {
            margin-bottom: 10px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">



        <div style="max-width: 600px; margin: 0 auto; padding: 20px; font-family: Arial, sans-serif;">
            <h2>Password Reset</h2>
            <p>Hello,  {{$emailData['email']}}</p>
            <p>We received a request to reset your password. Please click the link below to reset your password:</p>
            <a href="{{config('app.frontAppUrl')}}/reset-password?token={{$emailData['token']}}"
            style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none;">
            Reset Password
            </a>
            <p>If you did not request a password reset, please ignore this email.</p>
            <p>Thank you,</p>
            <p>Geniuses Platform</p>
        </div>


    </div>
</body>

</html>
