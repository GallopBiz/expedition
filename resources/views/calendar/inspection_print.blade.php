<!DOCTYPE html>
<html>
<head>
    <title>Inspection Report</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f2f4f9; color: #0d1526; padding: 32px; min-height: 100vh; }
        .sheet{background:#fff;border:1px solid #e2e7f3;border-radius:14px;max-width:820px;margin:0 auto;overflow:hidden}
        .rh{display:flex;align-items:flex-start;justify-content:space-between;padding:28px 32px 24px;border-bottom:3px solid #0d1526;gap:20px}
        .rh-company{font-size:17px;font-weight:700;letter-spacing:-.3px;color:#0d1526}
        .rh-company-sub{font-size:12px;color:#8e9ab8;margin-top:2px}
        .rh-doc-type{font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#8e9ab8;margin-bottom:4px}
        .rh-ref{font-family:monospace;font-size:15px;font-weight:700;color:#2a5be8}
        .rh-date{font-size:11.5px;color:#8e9ab8;margin-top:3px;font-family:monospace}
        .title-block{padding:22px 32px 18px;border-bottom:1px solid #e2e7f3;display:flex;align-items:center;justify-content:space-between;gap:16px}
        .tb-label{font-size:10.5px;font-weight:700;letter-spacing:.09em;text-transform:uppercase;color:#8e9ab8;margin-bottom:5px}
        .tb-title{font-size:20px;font-weight:700;letter-spacing:-.4px;color:#0d1526}
        .tb-wp{font-size:12.5px;color:#8e9ab8;margin-top:3px;font-family:monospace}
        .status-badge{display:inline-flex;align-items:center;gap:6px;font-size:12px;font-weight:700;padding:6px 14px;border-radius:20px;white-space:nowrap;flex-shrink:0}
        .sb-done{background:#ecfdf5;color:#059669}
        .sb-up{background:#eaf0ff;color:#2a5be8}
        .sb-dot{width:7px;height:7px;border-radius:50%;background:currentColor}
        .meta-band{display:grid;grid-template-columns:repeat(4,1fr);border-bottom:1px solid #e2e7f3}
        .mb-item{padding:16px 20px;border-right:1px solid #e2e7f3}
        .mb-item:last-child{border-right:none}
        .mb-lbl{font-size:10px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#8e9ab8;margin-bottom:5px}
        .mb-val{font-size:13.5px;font-weight:600;color:#0d1526}
        .mb-val.mono{font-family:monospace;font-size:12.5px}
        .rpt-body{padding:28px 32px;display:flex;flex-direction:column;gap:26px}
        .sec-head{display:flex;align-items:center;gap:10px;margin-bottom:14px}
        .sec-line{flex:1;height:1px;background:#e2e7f3}
        .sec-lbl{font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#8e9ab8;white-space:nowrap}
        .fgrid{display:grid;grid-template-columns:1fr 1fr;gap:14px 24px}
        .field{}
        .f-lbl{font-size:10.5px;font-weight:600;color:#8e9ab8;text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px}
        .f-val{font-size:13.5px;color:#0d1526;font-weight:500}
        .f-val.mono{font-family:monospace;font-size:12.5px;font-weight:400}
        .f-val.muted{color:#8e9ab8;font-weight:400;font-style:italic}
        .notes-box{background:#f0f3fa;border:1px solid #e2e7f3;border-left:3px solid #2a5be8;border-radius:0 9px 9px 0;padding:14px 16px;font-size:13.5px;color:#4a5578;line-height:1.65}
        .files-row{display:flex;flex-wrap:wrap;gap:8px}
        .fc{display:inline-flex;align-items:center;gap:7px;padding:7px 12px;border-radius:8px;border:1px solid #e2e7f3;background:#f0f3fa;color:#4a5578;font-size:12px;font-family:monospace;cursor:default}
        .fi{width:24px;height:24px;border-radius:5px;display:flex;align-items:center;justify-content:center;font-size:8.5px;font-weight:700;flex-shrink:0}
        .fi-pdf{background:#fef2f2;color:#ef4444}
        .fi-doc{background:#eaf0ff;color:#2a5be8}
        .fi-img{background:#f0fdf4;color:#16a34a}
        .pdf-btn { display: inline-block; margin-bottom: 20px; margin-left: 10px; padding: 8px 18px; background: #3b82f6; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 1em; text-decoration: none; }
        .pdf-btn:hover { background: #1a3fb8; }
    </style>
</head>
<body>
    <button class="print-btn" onclick="window.print()">Print</button>
    <a href="{{ route('calendar.inspection.pdf', $inspection->id) }}" class="pdf-btn" target="_blank">Download PDF</a>
    <div class="sheet">
        <div class="rh">
            <div class="rh-left">
                <div class="rh-company">{{ $user->company_name ?? 'Inspection Company' }}</div>
                <div class="rh-company-sub">{{ $user->company_address ?? '—' }}</div>
            </div>
            <div class="rh-right">
                <div class="rh-doc-type">Inspection Report</div>
                <div class="rh-ref">INS-{{ str_pad($inspection->id, 4, '0', STR_PAD_LEFT) }}</div>
                <div class="rh-date">Issued: {{ \Carbon\Carbon::parse($inspection->inspection_date)->format('d M Y') }}</div>
            </div>
        </div>
        <div class="title-block">
            <div class="tb-left">
                <div class="tb-label">Inspection Type</div>
                <div class="tb-title" style="background:#fef9ec;color:#d97706;padding:7px 16px;border-radius:8px;font-weight:700;display:inline-block;margin-bottom:7px;font-size:18px;box-shadow:0 1px 3px #0001;">
                    {{ $inspection->inspection_for }}
                </div>
                <div class="tb-wp" style="background:#eaf0ff;color:#2a5be8;padding:6px 14px;border-radius:8px;font-weight:700;display:inline-block;margin-top:6px;font-size:14px;box-shadow:0 1px 3px #0001;">
                    WP #{{ $context->work_package_no ?? '-' }} — {{ $context->workpackage_name ?? '-' }}
                </div>
            </div>
            <div>
                @php $isPast = \Carbon\Carbon::parse($inspection->inspection_date)->isPast(); @endphp
                <span class="status-badge {{ $isPast ? 'sb-done' : 'sb-up' }}"><span class="sb-dot"></span>{{ $isPast ? 'Completed' : 'Upcoming' }}</span>
            </div>
        </div>
        <div class="meta-band">
            <div class="mb-item">
                <div class="mb-lbl">Inspection Date</div>
                <div class="mb-val mono">{{ \Carbon\Carbon::parse($inspection->inspection_date)->format('d M Y') }}</div>
            </div>
            <div class="mb-item">
                <div class="mb-lbl">Location</div>
                <div class="mb-val">{{ $inspection->inspection_location }}</div>
            </div>
            <div class="mb-item">
                <div class="mb-lbl">Inspector</div>
                <div class="mb-val">{{ $user->name ?? '-' }}</div>
            </div>
            <div class="mb-item">
                <div class="mb-lbl">Reference No.</div>
                <div class="mb-val mono">INS-{{ str_pad($inspection->id, 4, '0', STR_PAD_LEFT) }}</div>
            </div>
        </div>
        <div class="rpt-body">
            <div class="sec">
                <div class="sec-head">
                    <span class="sec-lbl">Inspection Details</span>
                    <div class="sec-line"></div>
                </div>
                <div class="fgrid">
                    <div class="field">
                        <div class="f-lbl">Supplier / Vendor</div>
                        <div class="f-val">{{ $context->supplier ?? '-' }}</div>
                    </div>
                    <div class="field">
                        <div class="f-lbl">Scope of Inspection</div>
                        <div class="f-val">{{ $context->scope_of_inspection ?? '-' }}</div>
                    </div>
                </div>
            </div>
            <div class="sec">
                <div class="sec-head">
                    <span class="sec-lbl">Findings & Remarks</span>
                    <div class="sec-line"></div>
                </div>
                <div class="notes-box">{{ $inspection->remarks ?? '—' }}</div>
            </div>
            <div class="sec">
                <div class="sec-head">
                    <span class="sec-lbl">Attached Documents</span>
                    <div class="sec-line"></div>
                </div>
                <div class="files-row">
                    @if(is_array($inspection->files) && count($inspection->files))
                        @foreach($inspection->files as $file)
                            @php $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)); @endphp
                            @if(in_array($ext, ['jpg','jpeg','png','gif']))
                                <img src="{{ asset('storage/' . $file['path']) }}" style="max-width:220px;max-height:160px;margin:8px 8px 8px 0;border:1px solid #eee;border-radius:6px;" alt="Image" />
                            @endif
                        @endforeach
                    @else
                        <span style="font-size:13px;color:#8e9ab8;font-style:italic">No documents attached yet.</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>
