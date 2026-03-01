{{-- resources/views/work-packages/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Work Packages')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
        --bg:       #f0f2f8;
        --surface:  #ffffff;
        --surface2: #f5f6fa;
        --border:   #e0e4ef;
        --accent:   #4f7cff;
        --accent2:  #7c5cfc;
        --green:    #12b981;
        --red:      #ef4444;
        --yellow:   #f59e0b;
        --text:     #1a1f36;
        --muted:    #8b92aa;
        --hover:    #f0f4ff;
        --selected: #e8eeff;
    }
    body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }
    .wp-page { padding: 28px 32px; }
    .wp-title { font-size: 20px; font-weight: 600; letter-spacing: -0.3px; margin-bottom: 20px; color: var(--text); }
    .wp-stats { display: flex; gap: 14px; margin-bottom: 22px; flex-wrap: wrap; }
    .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: 12px; padding: 16px 22px; flex: 1; min-width: 130px; }
    .stat-card .val { font-size: 26px; font-weight: 700; color: var(--text); letter-spacing: -1px; }
    .stat-card .lbl { font-size: 12px; color: var(--muted); margin-top: 3px; }
    .stat-card.accent .val { color: var(--accent); }
    .stat-card.green  .val { color: var(--green); }
    .stat-card.red    .val { color: var(--red); }
    .wp-toolbar { display: flex; align-items: center; gap: 10px; margin-bottom: 18px; flex-wrap: wrap; }
    .search-wrap { position: relative; flex: 1; min-width: 220px; max-width: 340px; }
    .search-wrap .search-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--muted); pointer-events: none; }
    .search-wrap input { width: 100%; background: var(--surface2); border: 1px solid var(--border); border-radius: 10px; color: var(--text); font-size: 13.5px; padding: 9px 12px 9px 36px; outline: none; transition: border-color .2s, box-shadow .2s; }
    .search-wrap input::placeholder { color: var(--muted); }
    .search-wrap input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(79,124,255,.15); }
    .wp-select { background: var(--surface2); border: 1px solid var(--border); border-radius: 10px; color: var(--text); font-size: 13.5px; padding: 9px 34px 9px 12px; outline: none; cursor: pointer; appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7393' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; transition: border-color .2s; min-width: 150px; }
    .wp-select:focus { border-color: var(--accent); }
    .wp-btn { display: inline-flex; align-items: center; gap: 6px; font-size: 13.5px; font-weight: 500; padding: 9px 16px; border-radius: 10px; border: none; cursor: pointer; transition: filter .15s, transform .1s; text-decoration: none; }
    .wp-btn:active { transform: scale(.97); }
    .wp-btn-primary { background: linear-gradient(135deg, var(--accent), var(--accent2)); color: #fff; }
    .wp-btn-primary:hover { filter: brightness(1.1); }
    .wp-btn-ghost { background: var(--surface2); border: 1px solid var(--border); color: var(--text); }
    .wp-btn-ghost:hover { background: var(--hover); }
    .toolbar-spacer { flex: 1; }
    .table-wrap { background: var(--surface); border: 1px solid var(--border); border-radius: 16px; overflow: hidden; box-shadow: none; }
    .table-wrap table { width: 100%; border-collapse: collapse; }
    .table-wrap thead tr { background: var(--surface2); border-bottom: 1px solid var(--border); }
    .table-wrap thead th { padding: 13px 16px; text-align: left; font-size: 11.5px; font-weight: 600; letter-spacing: .06em; text-transform: uppercase; color: var(--muted); white-space: nowrap; cursor: pointer; user-select: none; transition: color .2s; }
    .table-wrap thead th:hover { color: var(--text); }
    .sort-icon { display: inline-flex; flex-direction: column; gap: 1px; margin-left: 5px; vertical-align: middle; opacity: .4; }
    .table-wrap tbody tr { border-bottom: 1px solid var(--border); transition: background .15s; cursor: pointer; }
    .table-wrap tbody tr:last-child { border-bottom: none; }
    .table-wrap tbody tr:hover { background: var(--hover); }
    .table-wrap tbody tr.selected { background: var(--selected); }
    .table-wrap td { padding: 14px 16px; font-size: 13.5px; color: var(--text); white-space: nowrap; }
    .td-id     { font-weight: 600; color: var(--text); font-size: 13px; }
    .td-name   { font-weight: 500; }
    .td-po     { color: var(--muted); font-size: 13px; font-family: monospace; }
    .td-date   { color: var(--muted); font-size: 12.5px; }
    .ring { position: relative; width: 38px; height: 38px; display: inline-block; }
    .ring svg { transform: rotate(-90deg); }
    .ring-bg   { fill: none; stroke: #e5e8f0; stroke-width: 3.5; }
    .ring-fill { fill: none; stroke-width: 3.5; stroke-linecap: round; }
    .ring-label { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; font-size: 9.5px; font-weight: 600; color: var(--text); }
    .badge-delivered { display: inline-flex; align-items: center; background: var(--surface2); border: 1px solid var(--border); border-radius: 6px; padding: 4px 10px; font-size: 12px; font-weight: 600; color: var(--text); }
    .status-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; }
    .status-dot.on-time  { background: var(--green); box-shadow: 0 0 6px rgba(18,185,129,.5); }
    .status-dot.delayed  { background: var(--red);   box-shadow: 0 0 6px rgba(239,68,68,.5); }
    .wp-pagination { display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-top: 1px solid var(--border); background: var(--surface2); font-size: 13px; color: var(--muted); }
    .pag-btns { display: flex; gap: 6px; }
    .pag-btn { background: var(--surface); border: 1px solid var(--border); color: var(--text); border-radius: 7px; padding: 5px 11px; font-size: 13px; cursor: pointer; transition: background .15s; text-decoration: none; display: inline-flex; align-items: center; }
    .pag-btn:hover  { background: var(--hover); }
    .pag-btn.active { background: var(--accent); border-color: var(--accent); color: #fff; }
    .pag-btn.disabled { opacity: .35; pointer-events: none; cursor: not-allowed; }
    .empty-state { text-align: center; padding: 48px 20px; color: var(--muted); font-size: 14px; }
    @media (max-width: 700px) { .wp-page { padding: 16px; } .wp-toolbar { gap: 8px; } }
</style>
@endpush

@section('content')
<div class="wp-page">

    @if(session('status'))
        <div style="margin-bottom: 18px; padding: 12px 18px; background: #e8eeff; border: 1px solid #4f7cff; color: #1a1f36; border-radius: 8px; font-size: 15px;">
            {{ session('status') }}
        </div>
    @endif
    
    <div class="wp-stats">
        <div class="stat-card accent">
            <div class="val">{{ $expeditingContexts->count() }}</div>
            <div class="lbl">Total Work Package</div>
        </div>
        <div class="stat-card green">
            <div class="val">{{ $expeditingContexts->where('on_time', true)->count() }}</div>
            <div class="lbl">On Time</div>
        </div>
        <div class="stat-card red">
            <div class="val">{{ $expeditingContexts->where('on_time', false)->count() }}</div>
            <div class="lbl">Delayed</div>
        </div>
        <div class="stat-card">
            <div class="val">{{ $expeditingContexts->where('po_number', '!=', null)->count() }}</div>
            <div class="lbl">With PO Number</div>
        </div>
        <div class="stat-card">
            <div class="val">{{ $expeditingContexts->where('po_number', null)->count() }}</div>
            <div class="lbl">Without PO</div>
        </div>
    </div>
    <div class="wp-toolbar">
        <div class="search-wrap">
            <svg class="search-icon" width="15" height="15" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
            </svg>
            <input type="text"
                   id="wpSearch"
                   placeholder="Search by ID, Name, PO…"
                   oninput="wpFilter()"
                   autocomplete="off">
        </div>
        <select class="wp-select" id="wpStatusFilter" onchange="wpFilter()">
            <option value="">All Statuses</option>
            <option value="on-time">On Time</option>
            <option value="delayed">Delayed</option>
        </select>
        <select class="wp-select" id="wpNameFilter" onchange="wpFilter()">
            <option value="">All Names</option>
            @foreach($workPackages->pluck('name')->unique()->sort() as $wpName)
                <option value="{{ $wpName }}">{{ $wpName }}</option>
            @endforeach
        </select>
        <button class="wp-btn wp-btn-ghost" onclick="wpReset()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2">
                <path d="M3 6h18M6 12h12M9 18h6"/>
            </svg>
            Reset
        </button>
        <div class="toolbar-spacer"></div>
        @php $user = Auth::user(); @endphp
        @if(!$user || $user->role !== 'Supplier')
        <a href="{{ url('/manager/expedition-v2') }}" class="wp-btn wp-btn-primary">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Add Work Package
        </a>
        @endif
    </div>
    <div class="table-wrap">
        <table id="wpTable">
            <thead>
                <tr>
                    <th>WP No.</th>
                    <th>WP Name</th>
                    <th>PO No.</th>
                    <th>Supplier</th>
                    <th>Design</th>
                    <th>Material</th>
                    <th>Fabrication</th>
                    <th>FAT</th>
                    <th>Delivered</th>
                    <th>On Time</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($workPackages as $wp)
                <tr class="wp-row"
                    data-id="{{ strtolower($wp->id) }}"
                    data-name="{{ strtolower($wp->workpackage_name) }}"
                    data-po="{{ strtolower($wp->po_number ?? '') }}"
                    data-status="{{ $wp->delivered == 1 ? 'on-time' : 'delayed' }}"
                    data-ordered="{{ optional($wp->order_date)->format('Y-m-d') ?? '' }}"
                    onclick="this.classList.toggle('selected')">
                    <td class="td-id">{{ $wp->work_package_no }}</td>
                    <td class="td-name">{{ $wp->workpackage_name }}</td>
                    <td class="td-po">{{ $wp->po_number ?? '—' }}</td>
                    <td>
                        @php
                            $supplierUser = $wp->wp_user_id ? \App\Models\User::find($wp->wp_user_id) : null;
                            $companyName = $supplierUser && $supplierUser->company_name ? $supplierUser->company_name : null;
                        @endphp
                        {{ $companyName ?? $wp->supplier ?? '—' }}
                    </td>
                    <td>@include('work-packages.ring', ['pct' => $wp->avg_design ?? 0])</td>
                    <td>@include('work-packages.ring', ['pct' => $wp->avg_material ?? 0])</td>
                    <td>@include('work-packages.ring', ['pct' => $wp->avg_fabrication ?? 0])</td>
                    <td>@include('work-packages.ring', ['pct' => $wp->avg_fat ?? 0])</td>
                    <td>
                        <span class="badge-delivered">
                            @php
                                $equipments = \App\Models\ExpeditingEquipment::where('context_id', $wp->id)->get();
                                $totalEquipment = $equipments->count();
                                $deliveredEquipment = $equipments->filter(function($eq) {
                                    $checks = $eq->checks ?? [];
                                    // Only check the third value (index 2) for Delivered
                                    return is_array($checks) && isset($checks[2]) && $checks[2] === true;
                                })->count();
                            @endphp
                            {{ $deliveredEquipment }}/{{ $totalEquipment }}
                        </span>
                    </td>
                    <td>
                        @php
                            $isDelayed = false;
                            foreach ($equipments as $eq) {
                                // If FAT Date is set and Actual Delivery Date is set and FAT Date > Actual Delivery Date, mark as delayed
                                if (!empty($eq->fatdate) && !empty($eq->actualdate)) {
                                    $fatDate = is_string($eq->fatdate) ? strtotime($eq->fatdate) : ($eq->fatdate instanceof \Carbon\Carbon ? $eq->fatdate->timestamp : null);
                                    $actualDate = is_string($eq->actualdate) ? strtotime($eq->actualdate) : ($eq->actualdate instanceof \Carbon\Carbon ? $eq->actualdate->timestamp : null);
                                    if ($fatDate && $actualDate && $fatDate > $actualDate) {
                                        $isDelayed = true;
                                        break;
                                    }
                                }
                            }
                        @endphp
                        <span class="status-dot {{ $isDelayed ? 'delayed' : 'on-time' }}"></span>
                    </td>
                    <td>
                        <button class="wp-btn wp-btn-ghost"
                                style="padding:3px 7px;font-size:12px;position:relative;"
                                onclick="event.stopPropagation(); toggleMenu(this, {{ $wp->id }})">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="1"/>
                                <circle cx="19" cy="12" r="1"/>
                                <circle cx="5"  cy="12" r="1"/>
                            </svg>
                            <div class="wp-menu" style="display:none;position:absolute;right:0;left:auto;top:28px;z-index:10;background:#fff;border:1px solid #e0e4ef;border-radius:8px;box-shadow:0 4px 16px rgba(0,0,0,0.08);min-width:140px;">
                            @php
                                $user = Auth::user();
                                $editUrl = '';
                                if ($user && $user->role === 'Manager') {
                                    $editUrl = url('/manager/expedition-v2') . '?context_id=' . $wp->id . '&edit=1';
                                } elseif ($user && $user->role === 'Expeditor') {
                                    $editUrl = url('/expeditor/expedition-v2') . '?context_id=' . $wp->id . '&edit=1';
                                } elseif ($user && $user->role === 'Supplier') {
                                    $editUrl = url('/supplier/expedition-v2') . '?context_id=' . $wp->id . '&edit=1';
                                }
                            @endphp
                            <a href="{{ $editUrl }}" class="wp-menu-item" style="display:block;padding:7px 12px;font-size:13px;color:#222;text-decoration:none;cursor:pointer;text-align:left;">Edit</a>
                                <a href="#" class="wp-menu-item" style="display:block;padding:7px 12px;font-size:13px;color:#e31717;text-decoration:none;cursor:pointer;text-align:left;" onclick="event.preventDefault(); confirmDelete({{ $wp->id }});">Delete</a>
                                <form id="delete-form-{{ $wp->id }}" action="{{ route('expediting_forms.destroy', $wp->id) }}" method="POST" style="display:none;">
// ...existing code...
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <a href="{{ route('expediting_forms.send_email', $wp->id) }}" class="wp-menu-item" style="display:block;padding:7px 12px;font-size:13px;color:#357ab7;text-decoration:none;cursor:pointer;text-align:left;" onclick="event.preventDefault(); document.getElementById('email-form-{{ $wp->id }}').submit();">Send Email</a>
                                <form id="email-form-{{ $wp->id }}" action="{{ route('expediting_forms.send_email', $wp->id) }}" method="POST" style="display:none;">
                                    @csrf
                                </form>
                            </div>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10">
                        <div class="empty-state">No work packages found.</div>
                    </td>
                </tr>
                @endforelse
            @push('scripts')
            <script>
            function confirmDelete(wpId) {
                if (confirm('Are you sure you want to delete this work package?')) {
                    document.getElementById('delete-form-' + wpId).submit();
                    setTimeout(function() {
                        window.location.href = '/expediting/list';
                    }, 500);
                }
            }
            </script>
            @endpush
            </tbody>
        </table>
        <div class="wp-pagination">
            <span id="wpPageInfo">
                {{ $workPackages->firstItem() }}–{{ $workPackages->lastItem() }}
                of {{ $workPackages->total() }}
            </span>
            <div class="pag-btns">
                @if($workPackages->onFirstPage())
                    <span class="pag-btn disabled">‹</span>
                @else
                    <a class="pag-btn" href="{{ $workPackages->previousPageUrl() }}">‹</a>
                @endif
                @foreach(range(1, $workPackages->lastPage()) as $page)
                    <a class="pag-btn {{ $page === $workPackages->currentPage() ? 'active' : '' }}"
                       href="{{ $workPackages->url($page) }}">
                        {{ $page }}
                    </a>
                @endforeach
                @if($workPackages->hasMorePages())
                    <a class="pag-btn" href="{{ $workPackages->nextPageUrl() }}">›</a>
                @else
                    <span class="pag-btn disabled">›</span>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const rows = () => Array.from(document.querySelectorAll('.wp-row'));
    let sortDir = {};
    function wpFilter() {
        const q      = document.getElementById('wpSearch').value.toLowerCase().trim();
        const status = document.getElementById('wpStatusFilter').value;
        const name   = document.getElementById('wpNameFilter').value.toLowerCase();
        let visible = 0;
        rows().forEach(tr => {
            const matchQ = !q || tr.dataset.id.includes(q)
                              || tr.dataset.name.includes(q)
                              || tr.dataset.po.includes(q);
            const matchS = !status || tr.dataset.status === status;
            const matchN = !name   || tr.dataset.name === name;
            const show   = matchQ && matchS && matchN;
            tr.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        document.getElementById('wpPageInfo').textContent =
            `1–${visible} of ${visible}`;
    }
    function wpReset() {
        document.getElementById('wpSearch').value        = '';
        document.getElementById('wpStatusFilter').value  = '';
        document.getElementById('wpNameFilter').value    = '';
        rows().forEach(tr => tr.style.display = '');
        document.getElementById('wpPageInfo').textContent =
            `1–{{ $workPackages->count() }} of {{ $workPackages->count() }}`;
    }
    function wpSort(key) {
        sortDir[key] = !sortDir[key];
        const tbody = document.querySelector('#wpTable tbody');
        const sorted = rows().sort((a, b) => {
            const va = a.dataset[key] ?? '';
            const vb = b.dataset[key] ?? '';
            return sortDir[key]
                ? va.localeCompare(vb, undefined, { numeric: true })
                : vb.localeCompare(va, undefined, { numeric: true });
        });
        sorted.forEach(tr => tbody.appendChild(tr));
    }
    let openMenuRef = null;
    function toggleMenu(btn, id) {
        // Close any open menu
        if (openMenuRef && openMenuRef !== btn) {
            openMenuRef.querySelector('.wp-menu').style.display = 'none';
        }
        const menu = btn.querySelector('.wp-menu');
        if (menu.style.display === 'block') {
            menu.style.display = 'none';
            openMenuRef = null;
        } else {
            menu.style.display = 'block';
            openMenuRef = btn;
        }
    }
    document.addEventListener('click', function(e) {
        if (openMenuRef && !openMenuRef.contains(e.target)) {
            openMenuRef.querySelector('.wp-menu').style.display = 'none';
            openMenuRef = null;
        }
    });
</script>
@endpush
