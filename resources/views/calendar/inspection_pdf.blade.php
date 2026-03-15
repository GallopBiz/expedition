<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inspection Report PDF</title>
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        :root{
          --tx:#0d1526;--tx2:#4a5578;--tx3:#8e9ab8;
          --bdr:#e2e7f3;--bdr2:#cdd4e8;
          --surf:#fff;--surf2:#f0f3fa;
          --blue:#2a5be8;--blue-lt:#eaf0ff;
          --green:#059669;--green-lt:#ecfdf5;
          --amber:#d97706;--amber-lt:#fef9ec;
          --red:#ef4444;--red-lt:#fef2f2;
        }
        body{font-family:'DejaVu Sans',Arial,sans-serif;background:#f2f4f9;color:var(--tx);padding:32px;min-height:100vh}
        .sheet{background:var(--surf);border:1px solid var(--bdr);border-radius:14px;max-width:820px;margin:0 auto;overflow:hidden}
        .rh{display:flex;align-items:flex-start;justify-content:space-between;padding:28px 32px 24px;border-bottom:3px solid var(--tx);gap:20px}
        .rh-company{font-size:17px;font-weight:700;letter-spacing:-.3px;color:var(--tx)}
        .rh-company-sub{font-size:12px;color:var(--tx3);margin-top:2px}
        .rh-doc-type{font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--tx3);margin-bottom:4px}
        .rh-ref{font-family:'DejaVu Sans Mono',monospace;font-size:15px;font-weight:700;color:var(--blue)}
        .rh-date{font-size:11.5px;color:var(--tx3);margin-top:3px;font-family:'DejaVu Sans Mono',monospace}
        .title-block{padding:22px 32px 18px;border-bottom:1px solid var(--bdr);display:flex;align-items:center;justify-content:space-between;gap:16px}
        .tb-label{font-size:10.5px;font-weight:700;letter-spacing:.09em;text-transform:uppercase;color:var(--tx3);margin-bottom:5px}
        .tb-title{font-size:20px;font-weight:700;letter-spacing:-.4px;color:var(--tx)}
        .tb-wp{font-size:12.5px;color:var(--tx3);margin-top:3px;font-family:'DejaVu Sans Mono',monospace}
        .status-badge{display:inline-flex;align-items:center;gap:6px;font-size:12px;font-weight:700;padding:6px 14px;border-radius:20px;white-space:nowrap;flex-shrink:0}
        .sb-done{background:var(--green-lt);color:var(--green)}
        .sb-up{background:var(--blue-lt);color:var(--blue)}
        .sb-dot{width:7px;height:7px;border-radius:50%;background:currentColor}
        .meta-band{display:grid;grid-template-columns:repeat(4,1fr);border-bottom:1px solid var(--bdr)}
        .mb-item{padding:16px 20px;border-right:1px solid var(--bdr)}
        .mb-item:last-child{border-right:none}
        .mb-lbl{font-size:10px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--tx3);margin-bottom:5px}
        .mb-val{font-size:13.5px;font-weight:600;color:var(--tx)}
        .mb-val.mono{font-family:'DejaVu Sans Mono',monospace;font-size:12.5px}
        .rpt-body{padding:28px 32px;display:flex;flex-direction:column;gap:26px}
        .sec-head{display:flex;align-items:center;gap:10px;margin-bottom:14px}
        .sec-line{flex:1;height:1px;background:var(--bdr)}
        .sec-lbl{font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--tx3);white-space:nowrap}
        .fgrid{display:grid;grid-template-columns:1fr 1fr;gap:14px 24px}
        .field{}
        .f-lbl{font-size:10.5px;font-weight:600;color:var(--tx3);text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px}
        .f-val{font-size:13.5px;color:var(--tx);font-weight:500}
        .f-val.mono{font-family:'DejaVu Sans Mono',monospace;font-size:12.5px;font-weight:400}
        .f-val.muted{color:var(--tx3);font-weight:400;font-style:italic}
        .notes-box{background:var(--surf2);border:1px solid var(--bdr);border-left:3px solid var(--blue);border-radius:0 9px 9px 0;padding:14px 16px;font-size:13.5px;color:var(--tx2);line-height:1.65}
        .files-row{display:flex;flex-wrap:wrap;gap:8px}
        .fc{display:inline-flex;align-items:center;gap:7px;padding:7px 12px;border-radius:8px;border:1px solid var(--bdr);background:var(--surf2);color:var(--tx2);font-size:12px;font-family:'DejaVu Sans Mono',monospace;cursor:default}
        .fi{width:24px;height:24px;border-radius:5px;display:flex;align-items:center;justify-content:center;font-size:8.5px;font-weight:700;flex-shrink:0}
        .fi-pdf{background:#fef2f2;color:#ef4444}
        .fi-doc{background:#eaf0ff;color:#2a5be8}
        .fi-img{background:#f0fdf4;color:#16a34a}
        @media print {
          .pdf-action-bar { display: none !important; }
        }
        .pdf-download-btn { display: none; }
    </style>
</head>
<body>

<div class="sheet">
    <!-- Report header / letterhead -->
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
    <!-- Title block -->
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
    <!-- Meta band -->
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
    <!-- Body -->
    <div class="rpt-body">
        <!-- Section: Inspection details -->
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
        <!-- Section: Related Equipment Details -->
        <div class="sec">
            <div class="sec-head">
                <span class="sec-lbl">Related Equipment</span>
                <div class="sec-line"></div>
            </div>
            @if(isset($equipments) && count($equipments))
                <table style="width:100%;border-collapse:collapse;margin-bottom:10px;">
                    <thead>
                        <tr style="background:#f0f3fa;">
                            <th style="border:1px solid #e2e7f3;padding:6px 8px;font-size:12px;text-align:left;">Name</th>
                            <th style="border:1px solid #e2e7f3;padding:6px 8px;font-size:12px;text-align:left;">Design</th>
                            <th style="border:1px solid #e2e7f3;padding:6px 8px;font-size:12px;text-align:left;">Material</th>
                            <th style="border:1px solid #e2e7f3;padding:6px 8px;font-size:12px;text-align:left;">Status</th>
                            <th style="border:1px solid #e2e7f3;padding:6px 8px;font-size:12px;text-align:left;">Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($equipments as $equipment)
                        <tr>
                            <td style="border:1px solid #e2e7f3;padding:6px 8px;font-size:12px;">{{ $equipment->name }}</td>
                            <td style="border:1px solid #e2e7f3;padding:6px 8px;font-size:12px;">{{ $equipment->design }}</td>
                            <td style="border:1px solid #e2e7f3;padding:6px 8px;font-size:12px;">{{ $equipment->material }}</td>
                            <td style="border:1px solid #e2e7f3;padding:6px 8px;font-size:12px;">{{ $equipment->status }}</td>
                            <td style="border:1px solid #e2e7f3;padding:6px 8px;font-size:12px;">{{ $equipment->qty }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <span style="font-size:13px;color:var(--tx3);font-style:italic">No related equipment found for this work package.</span>
            @endif
        </div>
        <!-- Section: Findings / Notes -->
        <div class="sec">
            <div class="sec-head">
                <span class="sec-lbl">Findings & Remarks</span>
                <div class="sec-line"></div>
            </div>
            <div class="notes-box">{{ $inspection->remarks ?? '—' }}</div>
        </div>
        <!-- Section: Attached files -->
        <div class="sec">
            <div class="sec-head">
                <span class="sec-lbl">Attached Documents</span>
                <div class="sec-line"></div>
            </div>
            <div class="files-row">
                @if(is_array($inspection->files) && count($inspection->files))
                    @foreach($inspection->files as $file)
                        @php $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)); @endphp
                        <div class="fc">
                            <div class="fi {{ in_array($ext, ['jpg','jpeg','png','gif']) ? 'fi-img' : ($ext === 'pdf' ? 'fi-pdf' : 'fi-doc') }}">{{ strtoupper(substr($ext,0,3)) }}</div>
                            {{ $file['name'] }}
                        </div>
                        @if(in_array($ext, ['jpg','jpeg','png','gif']))
                            <img src="{{ public_path('storage/' . $file['path']) }}" style="max-width:180px;max-height:120px;margin:8px 0 8px 8px;border:1px solid #eee;border-radius:6px;" alt="Image" />
                        @endif
                    @endforeach
                @else
                    <span style="font-size:13px;color:var(--tx3);font-style:italic">No documents attached yet.</span>
                @endif
            </div>
        </div>
    </div>
</div>
</div>
<div class="pdf-action-bar" style="width:100%;display:flex;justify-content:center;align-items:center;margin:32px 0 0 0;gap:10px;">
    <button id="print-btn" type="button" style="display:inline-flex;align-items:center;justify-content:center;height:28px;padding:0 16px;background:#059669;color:#fff;border:none;border-radius:4px;cursor:pointer;font-size:1em;box-shadow:0 1px 3px #0001;transition:background 0.2s; font-weight:500;line-height:1.2;">Print</button>
    <a href="{{ route('calendar.inspection.pdf', $inspection->id) }}?download=1" class="pdf-download-btn" style="display:inline-flex;align-items:center;justify-content:center;height:28px;padding:0 16px;background:#3b82f6;color:#fff;border:none;border-radius:4px;cursor:pointer;font-size:1em;text-decoration:none;box-shadow:0 1px 3px #0001;transition:background 0.2s; font-weight:500;line-height:1.2;">Download</a>
</div>
<script>
(function() {
  var btn = document.getElementById('print-btn');
  if (btn) {
    btn.onclick = function(e) {
      e.preventDefault();
      setTimeout(function() { window.print(); }, 100);
      return false;
    };
  }
})();
</script>
</body>
</html>
