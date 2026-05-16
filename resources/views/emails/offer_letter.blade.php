<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Offer Letter</title>
</head>
<body>
    <table width="100%" cellpadding="0" cellspacing="0" style="font-family: Arial, sans-serif; background-color: #f5f6fa; padding: 20px;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                
                <!-- Header -->
                <tr>
                    <td style="background-color: #0d6efd; color: #ffffff; text-align: center; padding: 20px;">
                        <h2 style="margin: 0; font-size: 24px;">Welcome to Our Company!</h2>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding: 30px;">
                        <h3 style="color: #333333; margin-top: 0;">Hello {{ $employee->first_name }},</h3>

                        <p style="color: #555555; font-size: 16px; line-height: 1.5;">
                            Congratulations! We are excited to have you on board. Please find your <strong>Offer Letter</strong> attached with this email.
                        </p>

                        <p style="color: #555555; font-size: 16px; line-height: 1.5;">
                            Kindly review the document and let us know if you have any questions.
                        </p>

                        <p style="color: #555555; font-size: 16px; line-height: 1.5; margin-bottom: 0;">
                            Best Regards,<br>
                            <strong>HR Team</strong>
                        </p>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background-color: #f1f3f6; text-align: center; padding: 15px; font-size: 12px; color: #888888;">
                        &copy; {{ date('Y') }} Your Company Name. All rights reserved.
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
</body>
</html>