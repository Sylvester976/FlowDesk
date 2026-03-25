<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your FlowDesk Login Code</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .wrapper {
            max-width: 520px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
        }

        .header {
            background: #1a1f37;
            padding: 28px 36px;
        }

        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 20px;
            font-weight: 600;
            letter-spacing: .02em;
        }

        .header span {
            color: #4e73df;
        }

        .body {
            padding: 36px;
        }

        .body p {
            color: #4a4a4a;
            font-size: 15px;
            line-height: 1.7;
            margin: 0 0 16px;
        }

        .code-box {
            background: #f0f4ff;
            border: 2px dashed #4e73df;
            border-radius: 8px;
            text-align: center;
            padding: 24px;
            margin: 24px 0;
        }

        .code {
            font-size: 42px;
            font-weight: 700;
            letter-spacing: 12px;
            color: #1a1f37;
            font-family: 'Courier New', monospace;
        }

        .expires {
            font-size: 13px;
            color: #888;
            margin-top: 8px;
        }

        .warning {
            background: #fff8e1;
            border-left: 4px solid #f59e0b;
            border-radius: 4px;
            padding: 12px 16px;
            margin-top: 20px;
        }

        .warning p {
            color: #78620a;
            font-size: 13px;
            margin: 0;
        }

        .footer {
            background: #f8f9fa;
            padding: 20px 36px;
            border-top: 1px solid #eee;
        }

        .footer p {
            color: #999;
            font-size: 12px;
            margin: 0;
            line-height: 1.6;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <h1>Flow<span>Desk</span></h1>
    </div>
    <div class="body">
        <p>Hello <?php echo e($user->first_name); ?>,</p>
        <p>Use the code below to complete your sign in. This code is valid for <strong>5 minutes</strong> and can only
            be used once.</p>
        <div class="code-box">
            <div class="code"><?php echo e($code); ?></div>
            <div class="expires">Expires in 5 minutes</div>
        </div>
        <div class="warning">
            <p><strong>Did not request this?</strong> Someone may have your password. Please contact your system
                administrator immediately.</p>
        </div>
        <p style="margin-top:20px;">This is an automated message. Do not reply to this email.</p>
    </div>
    <div class="footer">
        <p>FlowDesk &mdash; Travel Information Management System<br>
            This email was sent to <?php echo e($user->email); ?></p>
    </div>
</div>
</body>
</html>
<?php /**PATH D:\Myprojects\FlowDesk\resources\views/emails/otp.blade.php ENDPATH**/ ?>