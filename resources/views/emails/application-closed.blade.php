@include('emails._header')
<p style="color:#374151;font-size:15px;margin:0 0 12px;">Dear {{ $applicant->first_name }},</p>
<p style="color:#4a4a4a;font-size:14px;line-height:1.7;margin:0 0 16px;">
    Your post-trip documents for application <strong>{{ $app->reference_number }}</strong> have been reviewed by <strong>{{ $closedBy->full_name }}</strong> and the application has been successfully closed.
</p>
<table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;margin:16px 0;">
    <tr>
        <th style="background:#e9f2ff;padding:8px 12px;text-align:left;font-size:13px;color:#004085;">Field</th>
        <th style="background:#e9f2ff;padding:8px 12px;text-align:left;font-size:13px;color:#004085;">Details</th>
    </tr>
    <tr><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">Reference</td><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;"><strong>{{ $app->reference_number }}</strong></td></tr>
    <tr><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">Travel Type</td><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">{{ $app->getTravelTypeLabel() }}</td></tr>
    <tr><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">Destination</td><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">{{ $app->country?->name ?? ($app->county?->name . ' County') }}</td></tr>
    <tr><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">Travel Dates</td><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">{{ $app->departure_date->format('d M Y') }} → {{ $app->return_date->format('d M Y') }}</td></tr>
    <tr><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">Reviewed by</td><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">{{ $closedBy->full_name }}</td></tr>
    <tr><td style="padding:10px 12px;font-size:14px;color:#374151;">Closed on</td><td style="padding:10px 12px;font-size:14px;color:#374151;">{{ now()->format('d M Y, H:i') }}</td></tr>
</table>
<div style="background:#e8f5ee;border-left:4px solid #006b3f;border-radius:4px;padding:14px 16px;margin:20px 0;">
    <p style="font-size:13px;color:#085041;margin:0;"><strong>✓ You may now submit a new travel application.</strong> Your travel days docket has been updated accordingly.</p>
</div>
<p style="text-align:center;margin:20px 0;">
    <a href="{{ url('/travel') }}" style="display:inline-block;background:#1a3a6b;color:#fff;padding:10px 24px;border-radius:6px;text-decoration:none;font-weight:600;font-size:14px;">Go to My Applications</a>
</p>
@include('emails._footer')
