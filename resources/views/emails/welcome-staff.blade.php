<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your FlowDesk Account</title>
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
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        .header {
            background: #1a3a6b;
            padding: 24px 32px;
        }

        .header h1 {
            color: #fff;
            margin: 0;
            font-size: 18px;
            font-weight: 600;
        }

        .header span {
            color: #c8a951;
        }

        .stripe {
            height: 4px;
            background: linear-gradient(to right, #bb0000 0 33.3%, #111 33.3% 66.6%, #006b3f 66.6% 100%);
        }

        .body {
            padding: 32px;
        }

        .body p {
            color: #4a4a4a;
            font-size: 15px;
            line-height: 1.7;
            margin: 0 0 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th {
            background: #e8f0fb;
            padding: 8px 12px;
            text-align: left;
            font-size: 13px;
            color: #1a3a6b;
        }

        td {
            padding: 10px 12px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            color: #374151;
        }

        .warning {
            background: #fff8e1;
            border-left: 4px solid #c8a951;
            border-radius: 4px;
            padding: 12px 16px;
            margin: 20px 0;
        }

        .warning p {
            color: #78620a;
            font-size: 13px;
            margin: 0;
        }

        .btn {
            display: inline-block;
            background: #1a3a6b;
            color: #fff;
            padding: 12px 28px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            margin: 16px 0;
        }

        .footer {
            background: #f8f9fa;
            padding: 16px 32px;
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
    <div class="header"><h1>Flow<span>Desk</span></h1></div>
    <div class="stripe"></div>
    <div class="body">
        <p>Dear {{ $user->first_name }} {{ $user->last_name }},</p>
        <p>Your FlowDesk account has been created. Use the details below to sign in for the first time.</p>
        <table>
            <tr>
                <th>Field</th>
                <th>Details</th>
            </tr>
            <tr>
                <td><strong>Login URL</strong></td>
                <td><a href="{{ $loginUrl }}">{{ $loginUrl }}</a></td>
            </tr>
            <tr>
                <td><strong>Email</strong></td>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <td><strong>Temporary Password</strong></td>
                <td><strong>{{ $password }}</strong></td>
            </tr>
        </table>
        <div class="warning">
            <p><strong>Important:</strong> You will be required to set a new password when you first sign in. Please do
                not share this temporary password with anyone.</p>
        </div>
        <p style="text-align:center;">
            <a href="{{ $loginUrl }}" class="btn">Sign In to FlowDesk</a>
        </p>
        <p>If you did not expect this email, please contact your system administrator immediately.</p>
    </div>
    <div class="footer">
        <p>FlowDesk &mdash; Travel Information Management System<br>
            Government of Kenya &mdash; State Department of ICT</p>
    </div>
</div>
</body>
</html>
