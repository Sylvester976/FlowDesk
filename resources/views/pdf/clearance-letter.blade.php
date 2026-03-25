<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 2cm 2.5cm; }
        body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 11pt; color: #1a1a1a; line-height: 1.6; }
        .letterhead { text-align: center; margin-bottom: 24px; border-bottom: 3px solid #1a3a6b; padding-bottom: 16px; }
        .letterhead h1 { font-size: 13pt; font-weight: bold; color: #1a3a6b; margin: 4px 0; text-transform: uppercase; }
        .letterhead p { font-size: 9.5pt; color: #555; margin: 2px 0; }
        .flag-stripe { height: 5px; background: linear-gradient(to right, #bb0000 0 33.3%, #111 33.3% 66.6%, #006b3f 66.6% 100%); margin-bottom: 12px; }
        .ref-date { display: flex; justify-content: space-between; margin-bottom: 20px; font-size: 10.5pt; }
        h2 { font-size: 12pt; text-align: center; text-decoration: underline; text-transform: uppercase; color: #1a3a6b; margin: 20px 0; }
        .intro { margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; margin: 16px 0; font-size: 10.5pt; }
        th { background: #1a3a6b; color: #fff; padding: 7px 10px; text-align: left; font-weight: 600; }
        td { padding: 7px 10px; border-bottom: 1px solid #ddd; }
        tr:nth-child(even) td { background: #f5f7fb; }
        .conditions { margin: 20px 0; }
        .conditions h3 { font-size: 11pt; color: #1a3a6b; margin-bottom: 8px; }
        .conditions ol { margin: 0; padding-left: 18px; font-size: 10.5pt; }
        .conditions li { margin-bottom: 6px; }
        .signature { margin-top: 48px; }
        .signature-line { border-top: 1px solid #333; width: 220px; margin: 40px 0 4px; }
        .official-stamp { text-align: center; margin: 20px 0; padding: 12px; border: 2px solid #1a3a6b; border-radius: 50%; width: 120px; height: 120px; display: flex; align-items: center; justify-content: center; }
        .footer { margin-top: 32px; padding-top: 10px; border-top: 1px solid #ccc; font-size: 9pt; color: #777; text-align: center; }
    </style>
</head>
<body>

<div class="flag-stripe"></div>

<div class="letterhead">
    <h1>Republic of Kenya</h1>
    <h1>State Department for Information, Communication Technology</h1>
    <h1>&amp; the Digital Economy</h1>
    <p>Ministry of ICT &amp; Digital Economy | P.O. Box 30025-00100, Nairobi, Kenya</p>
    <p>Tel: +254 20 2251990 | Website: www.ict.go.ke</p>
</div>

<div class="ref-date">
    <div>
        <strong>Ref:</strong> {{ $app->reference_number }}/CL/{{ now()->year }}
    </div>
    <div>
        <strong>Date:</strong> {{ now()->format('d F Y') }}
    </div>
</div>

<h2>Official Travel Clearance Letter</h2>

<div class="intro">
    <p>This is to certify that <strong>{{ $user->full_name }}</strong>,
    {{ $user->jobTitle?->name ?? $user->role?->label }},
    @if($user->department)
        {{ $user->department->name }},
        {{ $user->department->directorate?->name }},
    @endif
    (PF No: {{ $user->pf_number ?? 'N/A' }}),
    has been granted clearance to undertake official travel as detailed below:</p>
</div>

<table>
    <tr>
        <th colspan="2">Travel Details</th>
    </tr>
    <tr>
        <td width="40%"><strong>Reference Number</strong></td>
        <td>{{ $app->reference_number }}</td>
    </tr>
    <tr>
        <td><strong>Officer</strong></td>
        <td>{{ $user->full_name }}</td>
    </tr>
    <tr>
        <td><strong>Designation</strong></td>
        <td>{{ $user->jobTitle?->name ?? $user->role?->label }}</td>
    </tr>
    @if($user->department)
    <tr>
        <td><strong>Division / Directorate</strong></td>
        <td>{{ $user->department->name }}, {{ $user->department->directorate?->name }}</td>
    </tr>
    @endif
    <tr>
        <td><strong>Destination</strong></td>
        <td>
            {{ $app->country?->name ?? '' }}
            @if($app->destination_details) — {{ $app->destination_details }} @endif
        </td>
    </tr>
    <tr>
        <td><strong>Departure Date</strong></td>
        <td>{{ $app->departure_date->format('d F Y') }}</td>
    </tr>
    <tr>
        <td><strong>Return Date</strong></td>
        <td>{{ $app->return_date->format('d F Y') }}</td>
    </tr>
    <tr>
        <td><strong>Duration</strong></td>
        <td>{{ $app->getDurationDays() }} day(s)</td>
    </tr>
    @if($app->per_diem_days)
    <tr>
        <td><strong>Per Diem Days</strong></td>
        <td>{{ $app->per_diem_days }} day(s)</td>
    </tr>
    @endif
    @if($app->funding_source)
    <tr>
        <td><strong>Funding Source</strong></td>
        <td>{{ $app->funding_source }}</td>
    </tr>
    @endif
    <tr>
        <td><strong>Purpose</strong></td>
        <td>{{ $app->purpose }}</td>
    </tr>
</table>

<div class="conditions">
    <h3>Conditions of Clearance</h3>
    <ol>
        <li>The officer shall submit a post-trip report within <strong>7 working days</strong> of return.</li>
        <li>Original travel documents (ticket stubs, passport stamps) must be submitted to HR upon return.</li>
        <li>This clearance is valid only for the travel dates and destination specified above.</li>
        <li>Any change in travel dates or destination must be reported to the supervisor and HR immediately.</li>
        <li>The officer remains bound by the Public Service Code of Conduct during travel.</li>
    </ol>
</div>

<div class="signature">
    <p>Cleared and approved by:</p>
    <div class="signature-line"></div>
    <p>
        <strong>{{ $app->concurrenceSteps->where('action', 'concurred')->first()?->approver?->full_name }}</strong><br>
        {{ $app->concurrenceSteps->where('action', 'concurred')->first()?->approver?->role?->label }}<br>
        State Department for ICT &amp; Digital Economy<br>
        Date: {{ now()->format('d F Y') }}
    </p>
</div>

<div class="footer">
    This letter was generated electronically via FlowDesk Travel Management System.
    Reference: {{ $app->reference_number }} | Generated: {{ now()->format('d M Y H:i') }}
</div>

</body>
</html>
