@include('emails._header')
<p style="color:#374151;font-size:15px;margin:0 0 12px;">Dear {{ $supervisor->first_name }},</p>
<p style="color:#4a4a4a;font-size:14px;line-height:1.7;margin:0 0 16px;">
    <strong>{{ $applicant->full_name }}</strong> has submitted post-trip documents for application <strong>{{ $app->reference_number }}</strong>. Please review and close the application.
</p>
<table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;margin:16px 0;">
    <tr>
        <th style="background:#e9f2ff;padding:8px 12px;text-align:left;font-size:13px;color:#004085;">Field</th>
        <th style="background:#e9f2ff;padding:8px 12px;text-align:left;font-size:13px;color:#004085;">Details</th>
    </tr>
    <tr><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">Reference</td><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;"><strong>{{ $app->reference_number }}</strong></td></tr>
    <tr><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">Applicant</td><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">{{ $applicant->full_name }}</td></tr>
    <tr><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">Destination</td><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">{{ $app->country?->name ?? ($app->county?->name . ' County') }}</td></tr>
    <tr><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">Travel Dates</td><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">{{ $app->departure_date->format('d M Y') }} → {{ $app->return_date->format('d M Y') }}</td></tr>
    @if($upload->actual_cost)
    <tr><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">Actual Cost</td><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">KES {{ number_format($upload->actual_cost, 2) }}</td></tr>
    @endif
    <tr><td style="padding:10px 12px;font-size:14px;color:#374151;">Submitted</td><td style="padding:10px 12px;font-size:14px;color:#374151;">{{ $upload->submitted_at?->format('d M Y, H:i') }}</td></tr>
</table>
@if($upload->report_summary)
<p style="font-size:13px;color:#6c757d;margin:16px 0 4px;font-weight:500;">Report Summary:</p>
<div style="background:#f8f9fa;border-radius:6px;padding:14px 16px;font-size:13px;color:#374151;line-height:1.7;">{{ $upload->report_summary }}</div>
@endif
<div style="background:#e9f2ff;border-left:4px solid #004085;border-radius:4px;padding:14px 16px;margin:20px 0;">
    <p style="font-size:13px;color:#004085;margin:0;"><strong>Action Required:</strong> Please log in to FlowDesk to review the uploaded documents and close this application.</p>
</div>
<p style="text-align:center;margin:20px 0;">
    <a href="{{ url('/travel/post-trip-review') }}" style="display:inline-block;background:#1a3a6b;color:#fff;padding:10px 24px;border-radius:6px;text-decoration:none;font-weight:600;font-size:14px;">Review Post-Trip Documents</a>
</p>
@include('emails._footer')
