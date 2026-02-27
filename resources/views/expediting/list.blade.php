{{-- resources/views/work-packages/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Work Packages')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
    --bg:#f0f2f8;
    --surface:#fff;
    --surface2:#f5f6fa;
    --border:#e0e4ef;
    --accent:#4f7cff;
    --accent2:#7c5cfc;
    --green:#12b981;
    --red:#ef4444;
    --text:#1a1f36;
    --muted:#8b92aa;
    --hover:#f0f4ff;
    --selected:#e8eeff;
}

body { font-family: Inter, sans-serif; background: var(--bg); color: var(--text); }

.wp-page { padding: 28px 32px; }
.wp-title { font-size: 20px; font-weight: 600; margin-bottom: 20px; }

.wp-stats { display: flex; gap: 14px; margin-bottom: 22px; flex-wrap: wrap; }
.stat-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 16px 22px;
    flex: 1;
    min-width: 130px;
}
.stat-card .val { font-size: 26px; font-weight: 700; }
.stat-card .lbl { font-size: 12px; color: var(--muted); }
.stat-card.accent .val { color: var(--accent); }
.stat-card.green .val { color: var(--green); }
.stat-card.red .val { color: var(--red); }

.wp-toolbar {
    display: flex;
    gap: 10px;
    margin-bottom: 18px;
    flex-wrap: wrap;
    align-items: center;
}

.search-wrap { position: relative; flex: 1; max-width: 340px; }
.search-wrap input {
    width: 100%;
    padding: 9px 12px 9px 36px;
    border-radius: 10px;
    border: 1px solid var(--border);
    background: var(--surface2);
}

.wp-select {
    padding: 9px 12px;
    border-radius: 10px;
    border: 1px solid var(--border);
    background: var(--surface2);
}

.wp-btn {
    padding: 9px 16px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    font-size: 13px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.wp-btn-primary {
    background: linear-gradient(135deg, var(--accent), var(--accent2));
    color: #fff;
}

.wp-btn-ghost {
    background: var(--surface2);
    border: 1px solid var(--border);
}

.table-wrap {
    background: var(--surface);
    border-radius: 16px;
    border: 1px solid var(--border);
    overflow: hidden;
}

table { width: 100%; border-collapse: collapse; }
thead { background: var(--surface2); }
th, td { padding: 14px 16px; font-size: 13px; white-space: nowrap; }
tbody tr { border-bottom: 1px solid var(--border); }
tbody tr:hover { background: var(--hover); }

.td-id { color: var(--accent); font-weight: 600; }
.td-po { font-family: monospace; color: var(--muted); }

.empty-state {
    padding: 40px;
    text-align: center;
    color: var(--muted);
}
</style>
@endpush

@section('content')
<div class="wp-page">

    <h1 class="wp-title">Work Packages</h1>

    <div class="wp-stats">
        <div class="stat-card accent">
            <div class="val">{{ $stats['total'] ?? $workPackages->count() }}</div>
            <div class="lbl">Total</div>
        </div>
        <div class="stat-card green">
            <div class="val">{{ $stats['on_time'] ?? $workPackages->where('on_time', true)->count() }}</div>
            <div class="lbl">On Time</div>
        </div>
        <div class="stat-card red">
            <div class="val">{{ $stats['delayed'] ?? $workPackages->where('on_time', false)->count() }}</div>
            <div class="lbl">Delayed</div>
        </div>
    </div>

    <div class="wp-toolbar">
        <div class="search-wrap">
            <input id="wpSearch" type="text" placeholder="Search…" oninput="wpFilter()">
        </div>

        <select id="wpStatusFilter" class="wp-select" onchange="wpFilter()">
            <option value="">All Status</option>
            <option value="on-time">On Time</option>
            <option value="delayed">Delayed</option>
        </select>

        <a href="{{ route('work-packages.create') }}" class="wp-btn wp-btn-primary">
            Add Work Package
        </a>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>PO</th>
                <th>Ordered</th>
                <th>Design</th>
                <th>Manufacturing</th>
                <th>FAT</th>
            </tr>
            </thead>
            <tbody>
            @forelse($workPackages as $wp)
                <tr>
                    <td class="td-id">{{ $wp->id }}</td>
                    <td>{{ $wp->name }}</td>
                    <td class="td-po">{{ $wp->po }}</td>
                    <td>{{ optional($wp->ordered)->format('d.m.Y') ?? '—' }}</td>
                    <td>@include('work-packages._ring', ['pct' => $wp->design])</td>
                    <td>@include('work-packages._ring', ['pct' => $wp->manufacturing])</td>
                    <td>@include('work-packages._ring', ['pct' => $wp->fat])</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="empty-state">No work packages found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection