<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family:'Segoe UI',Arial,sans-serif;background:#f4f4f4;margin:0;padding:0; }
        .wrapper { max-width:480px;margin:40px auto;background:#fff;border-radius:8px;overflow:hidden; }
        .header { background:#1a3a6b;padding:20px 32px; }
        .header h1 { color:#fff;margin:0;font-size:17px;font-weight:600; }
        .header span { color:#c8a951; }
        .stripe { height:4px;background:linear-gradient(to right,#bb0000 0 33.3%,#111 33.3% 66.6%,#006b3f 66.6% 100%); }
        .body { padding:32px; }
        .otp-box { background:#f0f4ff;border:2px solid #1a3a6b;border-radius:10px;
            text-align:center;padding:24px;margin:24px 0; }
        .otp-code { font-size:2.4rem;font-weight:700;letter-spacing:.25em;
            color:#1a3a6b;font-family:monospace; }
        .otp-note { font-size:.78rem;color:#6c757d;margin-top:8px; }
        .warning { background:#fff8e1;border-left:4px solid #c8a951;border-radius:4px;
            padding:12px 16px;font-size:.82rem;color:#78620a;margin-top:16px; }
        .footer { background:#f8f9fa;padding:14px 32px;border-top:1px solid #eee; }
        .footer p { color:#999;font-size:12px;margin:0;line-height:1.6; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header"><h1>Flow<span>Desk</span> — Password Reset</h1></div>
    <div class="stripe"></div>
    <div class="body">
        <p style="font-size:15px;color:#374151;">Dear {{ $user->first_name }},</p>
        <p style="font-size:14px;color:#4a4a4a;line-height:1.7;">
            We received a request to reset your FlowDesk password.
            Use the code below to complete the reset:
        </p>

        <div class="otp-box">
            <div class="otp-code">{{ $code }}</div>
            <div class="otp-note">Expires in 15 minutes</div>
        </div>

        <div class="warning">
            <strong>Did not request this?</strong> Ignore this email — your password will not change.
            If you are concerned, contact the ICT Help Desk immediately.
        </div>
    </div>
    <div class="footer">
        <p>FlowDesk — Travel Information Management System<br>
        Government of Kenya — State Department of ICT</p>
    </div>
</div>
</body>
</html>
