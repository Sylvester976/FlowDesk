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
@include('emails._header')
<p style="color:#374151;font-size:15px;margin:0 0 12px;">Dear {{ $applicant->first_name }},</p>
<div style="display:inline-block;padding:6px 16px;border-radius:20px;font-size:13px;font-weight:600;margin-bottom:16px;background:{{ $bgColor }}1a;color:{{ $bgColor }};">{{ $statusLabel }}</div>
<p style="color:#4a4a4a;font-size:14px;line-height:1.7;margin:0 0 16px;">
    Your travel application has been reviewed by <strong>{{ $step->approver->full_name }}</strong> ({{ $step->approver->role?->label }}).
</p>
<table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;margin:16px 0;">
    <tr>
        <th style="background:#e9f2ff;padding:8px 12px;text-align:left;font-size:13px;color:#004085;">Field</th>
        <th style="background:#e9f2ff;padding:8px 12px;text-align:left;font-size:13px;color:#004085;">Details</th>
    </tr>
    <tr><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">Reference</td><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;"><strong>{{ $app->reference_number }}</strong></td></tr>
    <tr><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">Travel Type</td><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">{{ $app->getTravelTypeLabel() }}</td></tr>
    <tr><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">Destination</td><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">{{ $app->country?->name ?? ($app->county?->name . ' County') }}</td></tr>
    <tr><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">Dates</td><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">{{ $app->departure_date->format('d M Y') }} → {{ $app->return_date->format('d M Y') }}</td></tr>
    <tr><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#374151;">Decision</td><td style="padding:10px 12px;border-bottom:1px solid #f0f0f0;font-size:14px;"><strong>{{ $statusLabel }}</strong></td></tr>
    <tr><td style="padding:10px 12px;font-size:14px;color:#374151;">Date</td><td style="padding:10px 12px;font-size:14px;color:#374151;">{{ $step->acted_at?->format('d M Y, H:i') }}</td></tr>
</table>
@if($step->comments)
<div style="background:#fff8e1;border-left:4px solid #c8a951;border-radius:4px;padding:14px 16px;margin:20px 0;font-size:13px;color:#78620a;">
    <strong>Comments from {{ $step->approver->first_name }}:</strong><br>{{ $step->comments }}
</div>
@endif
@if($step->action === 'concurred')
<div style="background:#e8f5ee;border-left:4px solid #006b3f;border-radius:4px;padding:12px 16px;margin:16px 0;font-size:13px;color:#374151;">
    <strong>Next steps:</strong> A clearance letter has been generated. Download it from your application page. Upload post-trip documents within 7 working days of return.
</div>
@elseif($step->action === 'returned')
<div style="background:#fff8e1;border-left:4px solid #c8a951;border-radius:4px;padding:12px 16px;margin:16px 0;font-size:13px;color:#374151;">
    <strong>Next steps:</strong> Review the comments above, make the necessary changes, and resubmit from the FlowDesk portal.
</div>
@elseif($step->action === 'not_concurred')
<div style="background:#ffebee;border-left:4px solid #bb0000;border-radius:4px;padding:12px 16px;margin:16px 0;font-size:13px;color:#374151;">
    Your application has been declined. If you have questions, speak with your supervisor or contact HR.
</div>
@endif
<p style="text-align:center;margin:20px 0;">
    <a href="{{ route('travel.show', $app->id) }}" style="display:inline-block;background:#1a3a6b;color:#fff;padding:10px 24px;border-radius:6px;text-decoration:none;font-weight:600;font-size:14px;">View Application</a>
</p>
@include('emails._footer')
