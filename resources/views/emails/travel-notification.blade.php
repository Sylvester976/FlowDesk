<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .wrapper {
            max-width: 560px;
            margin: 40px auto;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        .header {
            background: #1a3a6b;
            padding: 20px 32px;
        }

        .header h1 {
            color: #fff;
            margin: 0;
            font-size: 17px;
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
            padding: 28px 32px;
        }

        .ref {
            display: inline-block;
            background: #e8f0fb;
            color: #1a3a6b;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 16px 0;
        }

        th {
            background: #f8f9fa;
            padding: 8px 12px;
            text-align: left;
            font-size: 12px;
            color: #6c757d;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        td {
            padding: 10px 12px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            color: #374151;
        }

        .action-box {
            background: #e8f5ee;
            border-left: 4px solid #006b3f;
            border-radius: 4px;
            padding: 14px 16px;
            margin: 20px 0;
        }

        .action-box p {
            color: #085041;
            font-size: 13px;
            margin: 0;
        }

        .btn {
            display: inline-block;
            background: #1a3a6b;
            color: #fff;
            padding: 10px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            margin: 8px 0;
        }

        .footer {
            background: #f8f9fa;
            padding: 14px 32px;
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
    <div class="header"><h1>Flow<span>Desk</span> — Travel Notification</h1></div>
    <div class="stripe"></div>
    <div class="body">
        <p style="font-size:15px;color:#374151;">Dear {{ $recipient->first_name }},</p>
        <p style="font-size:14px;color:#4a4a4a;line-height:1.7;">
            {{ $applicant->full_name }} ({{ $applicant->role?->label }}) has submitted a travel application.
        </p>

        <span class="ref">Ref: {{ $app->reference_number }}</span>

        <table>
            <tr>
                <th>Field</th>
                <th>Details</th>
            </tr>
            <tr>
                <td>Travel Type</td>
                <td>{{ $app->getTravelTypeLabel() }}</td>
            </tr>
            <tr>
                <td>Applicant</td>
                <td>{{ $applicant->full_name }}</td>
            </tr>
            <tr>
                <td>Destination</td>
                <td>
                    @if($app->country)
                        {{ $app->country->name }}
                    @endif
                    @if($app->county)
                        {{ $app->county->name }} County
                    @endif
                    @if($app->destination_details)
                        — {{ $app->destination_details }}
                    @endif
                </td>
            </tr>
            <tr>
                <td>Dates</td>
                <td>{{ $app->departure_date->format('d M Y') }} → {{ $app->return_date->format('d M Y') }}</td>
            </tr>
            <tr>
                <td>Purpose</td>
                <td>{{ Str::limit($app->purpose, 200) }}</td>
            </tr>
        </table>

        @if($isConcurrer)
            <div class="action-box">
                <p><strong>Action Required:</strong> As the supervising officer, you are required to
                    review and concur or decline this application. Please log in to FlowDesk to take action.</p>
            </div>
            <p style="text-align:center;">
                <a href="{{ url('/travel/concurrence') }}" class="btn">Review Application</a>
            </p>
        @else
            <p style="font-size:13px;color:#6c757d;">This is an information notification only. No action is required
                from you.</p>
        @endif
    </div>
    <div class="footer">
        <p>FlowDesk — Travel Information Management System<br>
            Government of Kenya — State Department of ICT</p>
    </div>
</div>
</body>
</html>
