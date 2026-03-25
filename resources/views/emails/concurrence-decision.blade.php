<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family:'Segoe UI',Arial,sans-serif;background:#f4f4f4;margin:0;padding:0; }
        .wrapper { max-width:560px;margin:40px auto;background:#fff;border-radius:8px;overflow:hidden; }
        .header { padding:20px 32px; }
        .header h1 { color:#fff;margin:0;font-size:17px;font-weight:600; }
        .header span { color:#c8a951; }
        .stripe { height:4px;background:linear-gradient(to right,#bb0000 0 33.3%,#111 33.3% 66.6%,#006b3f 66.6% 100%); }
        .body { padding:28px 32px; }
        .status-badge { display:inline-block;padding:6px 16px;border-radius:20px;font-size:13px;font-weight:600;margin-bottom:16px; }
        table { width:100%;border-collapse:collapse;margin:16px 0; }
        th { background:#f8f9fa;padding:8px 12px;text-align:left;font-size:12px;color:#6c757d;font-weight:500; }
        td { padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151; }
        .comments { background:#fff8e1;border-left:4px solid #c8a951;border-radius:4px;padding:14px 16px;margin:20px 0;font-size:13px;color:#78620a; }
        .btn { display:inline-block;background:#1a3a6b;color:#fff;padding:10px 24px;border-radius:6px;text-decoration:none;font-weight:600;font-size:14px;margin:8px 0; }
        .footer { background:#f8f9fa;padding:14px 32px;border-top:1px solid #eee; }
        .footer p { color:#999;font-size:12px;margin:0;line-height:1.6; }
    </style>
</head>
<body>
<div class="wrapper">
    @php
        $bgColor = match($step->action) {
            'concurred'     => '#006b3f',
            'not_concurred' => '#bb0000',
            'returned'      => '#c8a951',
            default         => '#1a3a6b',
        };
        $statusLabel = match($step->action) {
            'concurred'     => '✓ Concurred',
            'not_concurred' => '✗ Not Concurred',
            'returned'      => '↩ Returned for Revision',
            default         => ucfirst($step->action),
        };
    @endphp

    <div class="header" style="background:{{ $bgColor }};">
        <h1>Flow<span>Desk</span> — Application Update</h1>
    </div>
    <div class="stripe"></div>
    <div class="body">
        <p style="font-size:15px;color:#374151;">Dear {{ $applicant->first_name }},</p>

        <span class="status-badge" style="background:{{ $bgColor }}1a;color:{{ $bgColor }};">
            {{ $statusLabel }}
        </span>

        <p style="font-size:14px;color:#4a4a4a;line-height:1.7;">
            Your travel application has been reviewed by
            <strong>{{ $step->approver->full_name }}</strong>
            ({{ $step->approver->role?->label }}).
        </p>

        <table>
            <tr><th>Field</th><th>Details</th></tr>
            <tr><td>Reference</td><td><strong>{{ $app->reference_number }}</strong></td></tr>
            <tr><td>Travel Type</td><td>{{ $app->getTravelTypeLabel() }}</td></tr>
            <tr>
                <td>Destination</td>
                <td>{{ $app->country?->name ?? ($app->county?->name . ' County') }}</td>
            </tr>
            <tr>
                <td>Dates</td>
                <td>{{ $app->departure_date->format('d M Y') }} → {{ $app->return_date->format('d M Y') }}</td>
            </tr>
            <tr><td>Decision</td><td><strong>{{ $statusLabel }}</strong></td></tr>
            <tr><td>Decided by</td><td>{{ $step->approver->full_name }}</td></tr>
            <tr><td>Date</td><td>{{ $step->acted_at?->format('d M Y, H:i') }}</td></tr>
        </table>

        @if($step->comments)
        <div class="comments">
            <strong>Comments from {{ $step->approver->first_name }}:</strong><br>
            {{ $step->comments }}
        </div>
        @endif

        @if($step->action === 'concurred')
        <p style="font-size:13px;color:#374151;background:#e8f5ee;padding:12px 16px;border-radius:6px;border-left:4px solid #006b3f;">
            <strong>Next steps:</strong> A clearance letter has been generated for your travel.
            You can download it from your application page.
            After your trip, you will be required to upload post-trip documents within 7 working days.
        </p>
        @elseif($step->action === 'returned')
        <p style="font-size:13px;color:#374151;background:#fff8e1;padding:12px 16px;border-radius:6px;border-left:4px solid #c8a951;">
            <strong>Next steps:</strong> Please review the comments above, make the necessary changes,
            and resubmit your application from the FlowDesk portal.
        </p>
        @elseif($step->action === 'not_concurred')
        <p style="font-size:13px;color:#374151;background:#ffebee;padding:12px 16px;border-radius:6px;border-left:4px solid #bb0000;">
            Your application has been declined. If you have questions, please speak directly
            with your supervisor or contact HR.
        </p>
        @endif

        <p style="text-align:center;margin-top:20px;">
            <a href="{{ route('travel.show', $app->id) }}" class="btn">View Application</a>
        </p>
    </div>
    <div class="footer">
        <p>FlowDesk — Travel Information Management System<br>
        Government of Kenya — State Department of ICT</p>
    </div>
</div>
</body>
</html>
