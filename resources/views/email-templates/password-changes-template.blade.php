<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Password Changed</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
      font-family: Arial, sans-serif;
    }
    .container {
      max-width: 600px;
      margin: auto;
      background: #ffffff;
      padding: 20px;
      border-radius: 8px;
    }
    h2 {
      color: #333;
    }
    .info {
      background-color: #f9f9f9;
      padding: 12px;
      border-radius: 6px;
      margin-top: 10px;
      border: 1px solid #ddd;
    }
    .label {
      font-weight: bold;
    }
    .footer {
      margin-top: 30px;
      font-size: 12px;
      color: #777;
      text-align: center;
    }
    @media (max-width: 600px) {
      .container {
        padding: 15px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Password Successfully Changed</h2>
    <p>Hello <strong>{{ $user->name }}</strong></p>
    <p>Your password has been changed successfully. Please find your updated login credentials below:</p>

    <div class="info">
      <p><span class="label">Email/Username:</span> {{ $user->email }} or {{ $user->username }}</p>
      <p><span class="label">New Password:</span> {{ $new_password }}</p>
    </div>

    <p>If you did not make this change, please contact our support team immediately.</p>

    <div class="footer">
      &copy; {{ date('Y') }} Larablog. All rights reserved.
    </div>
  </div>
</body>
</html>
