<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Consolidated Inspection Report</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f2f4f9; color: #0d1526; padding: 32px; min-height: 100vh; }
        .sheet{background:#fff;border:1px solid #e2e7f3;border-radius:14px;max-width:900px;margin:0 auto;overflow:hidden}
        .title-block{padding:22px 32px 18px;border-bottom:1px solid #e2e7f3;}
        .tb-label{font-size:12px;font-weight:700;letter-spacing:.09em;text-transform:uppercase;color:#8e9ab8;margin-bottom:5px}
        .tb-wp{background:#eaf0ff;color:#2a5be8;padding:8px 18px;border-radius:8px;font-weight:700;display:inline-block;margin-top:6px;font-size:16px;box-shadow:0 1px 3px #0001;}
        .inspections-table{width:100%;border-collapse:collapse;margin-top:24px;}
        .inspections-table th, .inspections-table td{border:1px solid #e2e7f3;padding:8px 10px;font-size:13px;}
        .inspections-table th{background:#f0f3fa;color:#2a5be8;font-weight:700;}
        .inspections-table td{background:#fff;}
        .section-title{font-size:15px;font-weight:700;color:#2a5be8;margin:24px 0 10px 0;}
    </style>
</head>
<body>
<div class="sheet">
    <div class="title-block">
        <div class="tb-label">Work Package</div>
        <div class="tb-wp">WP #{{ $context->work_package_no ?? '-' }} — {{ $context->workpackage_name ?? '-' }}</div>
    </div>
    <div class="section-title">Inspections for this Work Package</div>
    <table class="inspections-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Type</th>
                <th>Location</th>
                <th>Inspector</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
        @foreach($inspections as $i => $inspection)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ \Carbon\Carbon::parse($inspection->inspection_date)->format('d M Y') }}</td>
                <td>{{ $inspection->inspection_for }}</td>
                <td>{{ $inspection->inspection_location }}</td>
                <td>{{ $inspection->user->name ?? '-' }}</td>
                <td>{{ $inspection->remarks ?? '-' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
