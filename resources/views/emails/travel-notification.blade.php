@include('emails._header')
<p style="color:#374151;font-size:15px;margin:0 0 12px;">Dear {{ $recipient->first_name }},</p>
<p style="color:#4a4a4a;font-size:14px;line-height:1.7;margin:0 0 16px;">
    {{ $applicant->full_name }} ({{ $applicant->role?->label }}) has submitted a travel application.
</p>
<div style="display:inline-block;background:#e9f2ff;color:#004085;padding:4px 12px;border-radius:20px;font-size:13px;font-weight:600;margin-bottom:16px;">
    Ref: {{ $app->reference_number }}
</div>
<table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;margin:16px 0;">
    <tr>
        <th style="background:#e9f2ff;padding:8px 12px;text-align:left;font-size:13px;color:#004085;">Field</th>
        <th style="background:#e9f2ff;padding:8px 12px;text-align:left;font-size:13px;color:#004085;">Details</th>
    </tr>
    <tr><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">Travel Type</td><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">{{ $app->getTravelTypeLabel() }}</td></tr>
    <tr><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">Applicant</td><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">{{ $applicant->full_name }}</td></tr>
    <tr><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">Destination</td><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">@if($app->country){{ $app->country->name }}@endif @if($app->county){{ $app->county->name }} County@endif @if($app->destination_details)— {{ $app->destination_details }}@endif</td></tr>
    <tr><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">Dates</td><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">{{ $app->departure_date->format('d M Y') }} → {{ $app->return_date->format('d M Y') }}</td></tr>
    <tr><td style="padding:10px 12px;font-size:14px;color:#374151;">Purpose</td><td style="padding:10px 12px;font-size:14px;color:#374151;">{{ Str::limit($app->purpose, 200) }}</td></tr>
</table>
@if($isConcurrer)
<div style="background:#e9f2ff;border-left:4px solid #004085;border-radius:4px;padding:14px 16px;margin:20px 0;">
    <p style="color:#004085;font-size:13px;margin:0;"><strong>Action Required:</strong> As the supervising officer, you are required to review and concur or decline this application. Please log in to FlowDesk to take action.</p>
</div>
<p style="text-align:center;margin:20px 0;">
    <a href="{{ url('/travel/concurrence') }}" style="display:inline-block;background:#1a3a6b;color:#fff;padding:10px 24px;border-radius:6px;text-decoration:none;font-weight:600;font-size:14px;">Review Application</a>
</p>
@else
<p style="font-size:13px;color:#6c757d;margin:16px 0 0;">This is an information notification only. No action is required from you.</p>
@endif
@include('emails._footer')
