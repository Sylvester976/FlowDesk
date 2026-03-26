@include('emails._header')
<p style="color:#374151;font-size:15px;margin:0 0 12px;">Hello {{ $user->first_name }},</p>
<p style="color:#4a4a4a;font-size:14px;line-height:1.7;margin:0 0 16px;">
    Use the code below to complete your FlowDesk sign in. This code is valid for <strong>5 minutes</strong> and can only be used once.
</p>
<div style="background:#e9f2ff;border:2px solid #004085;border-radius:10px;text-align:center;padding:28px;margin:20px 0;">
    <div style="font-size:2.8rem;font-weight:700;letter-spacing:.3em;color:#004085;font-family:monospace;">{{ $code }}</div>
    <div style="font-size:13px;color:#6c757d;margin-top:8px;">Expires in 5 minutes</div>
</div>
<div style="background:#fff8e1;border-left:4px solid #c8a951;border-radius:4px;padding:12px 16px;">
    <p style="color:#78620a;font-size:13px;margin:0;"><strong>Did not request this?</strong> Someone may have your password. Contact your system administrator immediately.</p>
</div>
<p style="font-size:13px;color:#9ca3af;margin:20px 0 0;">This is an automated message. Do not reply to this email.</p>
@include('emails._footer')
