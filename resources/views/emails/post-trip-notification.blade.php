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
        }

        td {
            padding: 10px 12px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            color: #374151;
        }

        .action-box {
            background: #e8f0fb;
            border-left: 4px solid #1a3a6b;
            border-radius: 4px;
            padding: 14px 16px;
            margin: 20px 0;
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

        .report-box {
            background: #f8f9fa;
            border-radius: 6px;
            padding: 14px 16px;
            margin: 12px 0;
            font-size: 13px;
            color: #374151;
            line-height: 1.7;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header"><h1>Flow<span>Desk</span> — Post-Trip Documents</h1></div>
    <div class="stripe"></div>
    <div class="body">
        <p style="font-size:15px;color:#374151;">Dear {{ $supervisor->first_name }},</p>
        <p style="font-size:14px;color:#4a4a4a;line-height:1.7;">
            <strong>{{ $applicant->full_name }}</strong> has submitted post-trip documents
            for application <strong>{{ $app->reference_number }}</strong>.
            Please review and close the application.
        </p>

        <table>
            <tr>
                <th>Field</th>
                <th>Details</th>
            </tr>
            <tr>
                <td>Reference</td>
                <td><strong>{{ $app->reference_number }}</strong></td>
            </tr>
            <tr>
                <td>Applicant</td>
                <td>{{ $applicant->full_name }}</td>
            </tr>
            <tr>
                <td>Destination</td>
                <td>{{ $app->country?->name ?? ($app->county?->name . ' County') }}</td>
            </tr>
            <tr>
                <td>Travel Dates</td>
                <td>{{ $app->departure_date->format('d M Y') }} → {{ $app->return_date->format('d M Y') }}</td>
            </tr>
            @if($upload->actual_cost)
                <tr>
                    <td>Actual Cost</td>
                    <td>KES {{ number_format($upload->actual_cost, 2) }}</td>
                </tr>
            @endif
            <tr>
                <td>Submitted</td>
                <td>{{ $upload->submitted_at?->format('d M Y, H:i') }}</td>
            </tr>
        </table>

        @if($upload->report_summary)
            <p style="font-size:13px;color:#6c757d;margin-bottom:4px;font-weight:500;">Report Summary:</p>
            <div class="report-box">{{ $upload->report_summary }}</div>
        @endif

        <div class="action-box">
            <p style="font-size:13px;color:#1a3a6b;margin:0;">
                <strong>Action Required:</strong> Please log in to FlowDesk to review the uploaded
                documents and close this application.
            </p>
        </div>

        <p style="text-align:center;">
            <a href="{{ url('/travel/post-trip-review') }}" class="btn">Review Post-Trip Documents</a>
        </p>
    </div>
    <div class="footer">
        <p>FlowDesk — Travel Information Management System<br>
            Government of Kenya — State Department of ICT</p>
    </div>
</div>
</body>
</html>
