<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .email-header {
            text-align: center;
            padding-bottom: 20px;
        }
        .email-header h1 {
            color: #007BFF;
            margin: 0;
        }
        .email-content {
            margin: 20px 0;
        }
        .email-content p {
            margin: 10px 0;
        }
        .email-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
        .button {
            display: inline-block;
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>{{ config('app.name') }}</h1>
        </div>

        <div class="email-content">
            <p>Hi {{ $emailData['invoice']->name }},</p>
            <p>We have generated an invoice for you based on the details below:</p>

            <p><strong>Name:</strong> {{ $emailData['invoice']->name }}</p>
            <p><strong>Email:</strong> {{ $emailData['invoice']->email }}</p>
            <p><strong>Description:</strong> {{ $emailData['invoice']->description }}</p>
            <p><strong>Price:</strong> ${{ number_format($emailData['invoice']->price, 2) }}</p>

            <p>To complete your payment, please click the button below:</p>
            <p>
                <a href="{{ $emailData['url'] }}" class="button">Pay Now</a>
            </p>
        </div>

        <div class="email-footer">
            <p>Thank you for choosing {{ config('app.name')  }}!</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name')  }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
