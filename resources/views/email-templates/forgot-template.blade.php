<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Your Password</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
  <table width="100%" bgcolor="#f4f4f4" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center">
        <table width="100%" style="max-width: 600px; margin: 20px auto; background: #ffffff; padding: 20px; border-radius: 8px;">
          <tr>
            <td align="center" style="padding: 20px 0;">
              <h2 style="color: #333;">Reset Your Password</h2>
            </td>
          </tr>
          <tr>
            <td style="padding: 0 20px; color: #555; font-size: 16px;">
              <p>Hello,{{ $user->name }}</p>
              <p>You recently requested to reset your password. Click the button below to proceed:</p>
              <p style="text-align: center; margin: 30px 0;">
                <a href="{{ $actionLink }}" target="_blank"
                   style="background-color: #007BFF; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 4px; display: inline-block;">
                  Reset Password
                </a>
                <p>
                  This link valid for 15 minutes
                </p>
              </p>
              <p>If you did not request a password reset, please ignore this email.</p>
              <p>Thank you,<br>The YourApp Team</p>
            </td>
          </tr>
          <tr>
            <td align="center" style="font-size: 12px; color: #999; padding-top: 30px;">
              <p>&copy;{{ date('Y') }} Larablog. All rights reserved.</p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
