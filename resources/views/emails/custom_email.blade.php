<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $subjectLine }}</title>
</head>
<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
<table width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" role="presentation" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; margin: 20px auto;">

                {{-- Header --}}
                <tr>
                    <td class="header" style="text-align: center; padding: 20px 0; background-color: #e9f2ff;">
                        <a href="{{ config('app.url') }}" style="display: inline-block; text-decoration: none;">
                            <img src="https://geoclock.onrender.com/static/images/logo2.png"
                                 alt="MOCIDE Logo"
                                 style="display: block; margin: 0 auto; max-height: 80px;">
                        </a>
                        <h1 style="margin: 10px 0 0; font-size: 20px; color: #004085; font-family: Arial, sans-serif; text-align: center;">
                            State Department of ICT and Digital Economy
                        </h1>
                    </td>
                </tr>

                {{-- Body --}}
                <tr>
                    <td style="padding: 20px;">
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background-color: #ffffff; border: 1px solid #dee2e6; border-radius: 8px;">
                            <tr>
                                <td style="padding: 20px;">
                                    {!! $messageContent !!}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                {{-- Footer --}}
                <tr>
                    <td>
                        <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <td class="content-cell" align="center" style="font-size: 12px; color: #6b7280; padding: 20px;">
                                    <p style="margin: 0;">
                                        <strong>State Department of ICT and Digital Economy</strong><br>
                                        P.O BOX 30025-00100 Nairobi, Kenya<br>
                                        Tel: +254-020-4920000 /1 OR +254-020-920030 | Email: info@information.go.ke
                                    </p>
                                    <p style="margin-top: 10px;">
                                        &copy; {{ date('Y') }} State Department of ICT and Digital Economy. All rights reserved.
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
</body>
</html>
