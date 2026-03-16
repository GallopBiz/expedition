@extends('layouts.app')

@push('styles')
<style>
  /* Equal width for inspection history columns */
  .history-row.hr-insp {
    display: flex;
    align-items: stretch;
  }

  .history-row.hr-insp>.hr-date,
  .history-row.hr-insp>.hr-label,
  .history-row.hr-insp>.hr-sub,
  .history-row.hr-insp>.hr-user,
  .history-row.hr-insp>.hr-files,
  .history-row.hr-insp>.status-pill,
  .history-row.hr-insp>.hr-actions {
    flex: 1 1 0;
    min-width: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    padding: 0 6px;
  }

  .history-row.hr-insp>.hr-actions {
    justify-content: flex-end;
  }

  .history-row.hr-insp>.hr-date {
    justify-content: flex-start;
  }

  .history-row.hr-insp>.hr-label {
    justify-content: flex-start;
  }

  .history-row.hr-insp>.hr-sub {
    justify-content: flex-start;
  }

  .history-row.hr-insp>.hr-user {
    justify-content: flex-start;
  }

  .history-row.hr-insp>.hr-files {
    justify-content: flex-start;
  }

  .history-row.hr-insp>.status-pill {
    justify-content: center;
  }

  /* Responsive adjustments */
  @media (max-width: 900px) {

    .history-row.hr-insp>div,
    .history-row.hr-insp>span {
      flex: 1 1 0 !important;
      min-width: 0 !important;
    }
  }
</style>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,400&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
  *,
  *::before,
  *::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }

  :root {
    --bg: #f4f6fb;
    --surface: #ffffff;
    --surface2: #f0f3fa;
    --border: #e2e7f3;
    --border2: #cdd4e8;
    --text: #0d1526;
    --text2: #4a5578;
    --text3: #8e9ab8;
    --blue: #2a5be8;
    --blue-lt: #eaf0ff;
    --blue-dk: #1a3fb8;
    --teal: #0d9e8a;
    --teal-lt: #e6f8f5;
    --amber: #d97706;
    --amber-lt: #fef9ec;
    --red: #ef4444;
    --red-lt: #fef2f2;
    --green: #10b981;
    --green-lt: #ecfdf5;
    --radius: 14px;
    --shadow: 0 2px 16px rgba(13, 21, 38, .08), 0 1px 3px rgba(13, 21, 38, .04);
  }

  .pi-wrap {
    font-family: 'DM Sans', sans-serif;
    background: var(--bg);
    color: var(--text);
    padding: 32px;
    min-height: 100vh;
  }

  /* ── PAGE HEADER ── */
  .page-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 12px;
  }

  .page-header-left h1 {
    font-size: 20px;
    font-weight: 600;
    letter-spacing: -.4px;
  }

  .page-header-left p {
    font-size: 13px;
    color: var(--text3);
    margin-top: 3px;
  }

  .wp-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: var(--blue-lt);
    border: 1px solid #c5d5fb;
    border-radius: 8px;
    padding: 6px 14px;
    font-size: 12.5px;
    font-weight: 600;
    color: var(--blue);
    font-family: 'DM Mono', monospace;
    white-space: nowrap;
    align-self: flex-start;
    margin-top: 2px;
  }

  /* ── TAB BAR ── */
  .tab-bar {
    display: flex;
    gap: 0;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 6px;
    margin-bottom: 20px;
    box-shadow: var(--shadow);
  }

  .tab-btn {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px 16px;
    border-radius: 10px;
    border: none;
    background: none;
    font-family: 'DM Sans', sans-serif;
    font-size: 13.5px;
    font-weight: 500;
    color: var(--text3);
    cursor: pointer;
    transition: background .15s, color .15s;
    white-space: nowrap;
  }

  .tab-btn:hover {
    background: var(--surface2);
    color: var(--text2);
  }

  .tab-btn.active-blue {
    background: var(--blue-lt);
    color: var(--blue);
    font-weight: 600;
  }

  .tab-btn.active-teal {
    background: var(--teal-lt);
    color: var(--teal);
    font-weight: 600;
  }

  .tab-btn.active-amber {
    background: var(--amber-lt);
    color: var(--amber);
    font-weight: 600;
  }

  .tab-count {
    font-size: 11px;
    font-weight: 700;
    padding: 1px 7px;
    border-radius: 20px;
    margin-left: 2px;
  }

  .count-blue {
    background: var(--blue-lt);
    color: var(--blue);
  }

  .count-teal {
    background: var(--teal-lt);
    color: var(--teal);
  }

  .count-amber {
    background: var(--amber-lt);
    color: var(--amber);
  }

  /* ── TAB PANELS ── */
  .tab-panel {
    display: none;
  }

  .tab-panel.active {
    display: block;
    animation: fadeIn .2s ease;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(4px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* ── SPLIT LAYOUT ── */
  .split-layout {
    display: grid;
    grid-template-columns: 400px 1fr;
    gap: 20px;
    align-items: start;
  }

  /* ── FORM CARD ── */
  .form-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
    position: sticky;
    top: 20px;
  }

  .form-card-head {
    padding: 16px 20px;
    border-bottom: 1px solid var(--border);
    background: var(--surface2);
    display: flex;
    align-items: center;
    gap: 10px;
    position: relative;
  }

  .form-card-head::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
  }

  .head-blue::before {
    background: var(--blue);
  }

  .head-teal::before {
    background: var(--teal);
  }

  .head-amber::before {
    background: var(--amber);
  }

  .head-icon {
    width: 32px;
    height: 32px;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .hi-blue {
    background: var(--blue-lt);
    color: var(--blue);
  }

  .hi-teal {
    background: var(--teal-lt);
    color: var(--teal);
  }

  .hi-amber {
    background: var(--amber-lt);
    color: var(--amber);
  }

  .head-title {
    font-size: 14px;
    font-weight: 600;
    color: var(--text);
  }

  .head-sub {
    font-size: 11.5px;
    color: var(--text3);
    margin-top: 1px;
  }

  .form-body {
    padding: 20px;
  }

  .form-group {
    display: flex;
    flex-direction: column;
    gap: 5px;
    margin-bottom: 16px;
  }

  .form-group:last-child {
    margin-bottom: 0;
  }

  .f-label {
    font-size: 11.5px;
    font-weight: 600;
    color: var(--text2);
    letter-spacing: .04em;
    text-transform: uppercase;
  }

  .f-label .req {
    color: var(--blue);
    margin-left: 2px;
  }

  .f-input,
  .f-select {
    font-family: 'DM Sans', sans-serif;
    font-size: 13.5px;
    color: var(--text);
    background: var(--surface2);
    border: 1.5px solid var(--border);
    border-radius: 9px;
    padding: 9px 12px;
    outline: none;
    transition: border-color .18s, box-shadow .18s, background .18s;
    width: 100%;
  }

  .f-input[type="date"] {
    font-family: 'DM Mono', monospace;
    font-size: 12.5px;
  }

  .f-input::placeholder {
    color: var(--text3);
  }

  .f-input:focus,
  .f-select:focus {
    background: #fff;
  }

  .focus-blue:focus {
    border-color: var(--blue);
    box-shadow: 0 0 0 3px rgba(42, 91, 232, .1);
  }

  .focus-teal:focus {
    border-color: var(--teal);
    box-shadow: 0 0 0 3px rgba(13, 158, 138, .1);
  }

  .focus-amber:focus {
    border-color: var(--amber);
    box-shadow: 0 0 0 3px rgba(217, 119, 6, .1);
  }

  .f-input.is-invalid {
    border-color: var(--red);
  }

  .f-select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%238e9ab8' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    padding-right: 34px;
    cursor: pointer;
  }

  /* Upload zone */
  .upload-zone {
    position: relative;
    border: 2px dashed var(--border2);
    border-radius: 10px;
    padding: 20px 16px;
    text-align: center;
    background: var(--surface2);
    cursor: pointer;
    transition: border-color .2s, background .2s;
  }

  .upload-zone:hover,
  .upload-zone.drag {
    background: var(--blue-lt);
    border-color: var(--blue);
  }

  .upload-zone.teal:hover,
  .upload-zone.teal.drag {
    background: var(--teal-lt);
    border-color: var(--teal);
  }

  .upload-zone.amber:hover,
  .upload-zone.amber.drag {
    background: var(--amber-lt);
    border-color: var(--amber);
  }

  .upload-zone input[type="file"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    width: 100%;
    height: 100%;
    border: none;
    padding: 0;
  }

  .uz-icon {
    width: 36px;
    height: 36px;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 8px;
  }

  .uzi-blue {
    background: var(--blue-lt);
    color: var(--blue);
  }

  .uzi-teal {
    background: var(--teal-lt);
    color: var(--teal);
  }

  .uzi-amber {
    background: var(--amber-lt);
    color: var(--amber);
  }

  .uz-text {
    font-size: 13px;
    font-weight: 500;
    color: var(--text2);
  }

  .uz-text b.c-blue {
    color: var(--blue);
  }

  .uz-text b.c-teal {
    color: var(--teal);
  }

  .uz-text b.c-amber {
    color: var(--amber);
  }

  .uz-hint {
    font-size: 11px;
    color: var(--text3);
    margin-top: 3px;
  }

  /* File list */
  .file-list {
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin-top: 10px;
  }

  .file-item {
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 7px 10px;
    animation: slideIn .18s ease;
  }

  @keyframes slideIn {
    from {
      opacity: 0;
      transform: translateX(-5px);
    }

    to {
      opacity: 1;
      transform: translateX(0);
    }
  }

  .fti {
    width: 26px;
    height: 26px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 9px;
    font-weight: 700;
    font-family: 'DM Mono', monospace;
    flex-shrink: 0;
  }

  .fti-pdf {
    background: #fef2f2;
    color: #ef4444;
  }

  .fti-doc {
    background: #eaf0ff;
    color: #2a5be8;
  }

  .fti-img {
    background: #f0fdf4;
    color: #16a34a;
  }

  .fti-def {
    background: var(--surface2);
    color: var(--text3);
  }

  .fi-info {
    flex: 1;
    min-width: 0;
  }

  .fi-name {
    font-size: 12.5px;
    font-weight: 500;
    color: var(--text);
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  .fi-size {
    font-size: 11px;
    color: var(--text3);
    font-family: 'DM Mono', monospace;
  }

  .fi-rm {
    background: none;
    border: none;
    cursor: pointer;
    color: var(--text3);
    padding: 3px;
    border-radius: 4px;
    display: flex;
    align-items: center;
    transition: color .12s, background .12s;
    flex-shrink: 0;
  }

  .fi-rm:hover {
    color: #ef4444;
    background: #fef2f2;
  }

  /* Form footer */
  .form-footer {
    display: flex;
    gap: 8px;
    padding: 14px 20px;
    border-top: 1px solid var(--border);
    background: var(--surface2);
  }

  .form-footer .f-info {
    font-size: 11.5px;
    color: var(--text3);
    display: flex;
    align-items: center;
    gap: 5px;
    margin-right: auto;
  }

  /* Buttons */
  .btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 500;
    padding: 8px 16px;
    border-radius: 9px;
    border: none;
    cursor: pointer;
    transition: all .14s;
    white-space: nowrap;
    text-decoration: none;
  }

  .btn:active {
    transform: scale(.97);
  }

  .btn-blue {
    background: var(--blue);
    color: #fff;
  }

  .btn-teal {
    background: var(--teal);
    color: #fff;
  }

  .btn-amber {
    background: var(--amber);
    color: #fff;
  }

  .btn-blue:hover {
    background: var(--blue-dk);
  }

  .btn-teal:hover {
    filter: brightness(.91);
  }

  .btn-amber:hover {
    filter: brightness(.91);
  }

  .btn-ghost {
    background: var(--surface);
    border: 1.5px solid var(--border2);
    color: var(--text2);
  }

  .btn-ghost:hover {
    background: var(--surface2);
  }

  .btn-full {
    width: 100%;
    justify-content: center;
  }

  /* History card */
  .history-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
  }

  .history-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 20px;
    border-bottom: 1px solid var(--border);
    background: var(--surface2);
  }

  .history-head h3 {
    font-size: 13px;
    font-weight: 600;
    color: var(--text2);
  }

  .h-count {
    font-size: 11.5px;
    font-weight: 600;
    padding: 2px 9px;
    border-radius: 20px;
    background: var(--surface);
    border: 1px solid var(--border);
    color: var(--text3);
  }

  .history-list {
    display: flex;
    flex-direction: column;
  }

  .history-row {
    display: grid;
    align-items: center;
    gap: 12px;
    padding: 14px 20px;
    border-bottom: 1px solid var(--border);
    transition: background .12s;
    cursor: default;
  }

  .history-row:last-child {
    border-bottom: none;
  }

  .history-row:hover {
    background: #fafbff;
  }

  .hr-insp {
    grid-template-columns: 90px 1fr 1fr 100px auto auto auto;
  }

  .hr-dates {
    grid-template-columns: 90px 90px 90px 100px 1fr auto;
  }

  .hr-date {
    font-family: 'DM Mono', monospace;
    font-size: 12px;
    color: var(--text);
    white-space: nowrap;
  }

  .hr-label {
    font-size: 13px;
    font-weight: 500;
    color: var(--text);
  }

  .hr-sub {
    font-size: 12.5px;
    color: var(--text3);
  }

  .hr-user {
    font-size: 12.5px;
    color: var(--text2);
    white-space: nowrap;
  }

  .hr-files {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
  }

  .file-chip {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    padding: 2px 8px;
    border-radius: 5px;
    border: 1px solid var(--border);
    background: var(--surface2);
    color: var(--text2);
    font-family: 'DM Mono', monospace;
    cursor: pointer;
    transition: border-color .14s, color .14s;
    text-decoration: none;
    white-space: nowrap;
  }

  .file-chip:hover {
    border-color: var(--blue);
    color: var(--blue);
  }

  .status-pill {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    font-weight: 600;
    padding: 3px 9px;
    border-radius: 20px;
    white-space: nowrap;
  }

  .sp-done {
    background: #ecfdf5;
    color: #059669;
  }

  .sp-pending {
    background: var(--amber-lt);
    color: var(--amber);
  }

  .hr-actions {
    display: flex;
    gap: 5px;
  }

  .row-btn {
    background: none;
    border: 1px solid var(--border);
    border-radius: 6px;
    padding: 4px 10px;
    font-size: 11.5px;
    color: var(--text3);
    cursor: pointer;
    transition: all .12s;
    font-family: 'DM Sans', sans-serif;
  }

  .row-btn:hover {
    background: var(--blue-lt);
    border-color: var(--blue);
    color: var(--blue);
  }

  .row-btn.del:hover {
    background: var(--red-lt);
    border-color: var(--red);
    color: var(--red);
  }

  .history-thead {
    display: grid;
    align-items: center;
    gap: 12px;
    padding: 9px 20px;
    background: var(--surface2);
    border-bottom: 1px solid var(--border);
  }

  .ht-insp {
    grid-template-columns: 90px 1fr 1fr 100px auto auto auto;
  }

  .ht-dates {
    grid-template-columns: 90px 90px 90px 100px 1fr auto;
  }

  .th-col {
    font-size: 10.5px;
    font-weight: 700;
    color: var(--text3);
    text-transform: uppercase;
    letter-spacing: .06em;
    white-space: nowrap;
  }

  .empty-state {
    padding: 36px 20px;
    text-align: center;
    color: var(--text3);
    font-size: 13.5px;
  }

  /* Flash messages */
  .flash {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 14px;
    border-radius: 9px;
    font-size: 13px;
    margin-bottom: 18px;
    border: 1px solid transparent;
  }

  .flash-ok {
    background: var(--green-lt);
    color: #065f46;
    border-color: #a7f3d0;
  }

  .flash-err {
    background: var(--red-lt);
    color: #991b1b;
    border-color: #fca5a5;
  }

  @media (max-width: 960px) {
    .split-layout {
      grid-template-columns: 1fr;
    }

    .form-card {
      position: static;
    }
  }

  @media (max-width: 640px) {
    .pi-wrap {
      padding: 14px;
    }

    .tab-btn span.tab-label {
      display: none;
    }

    .tab-btn {
      padding: 10px;
      flex: none;
    }

    .tab-bar {
      justify-content: center;
      gap: 6px;
    }

    .hr-insp,
    .hr-dates {
      grid-template-columns: 1fr;
    }

    .ht-insp,
    .ht-dates {
      display: none;
    }
  }
</style>
@endpush

@section('content')
<div class="pi-wrap">

  {{-- Flash messages --}}
  @if(session('success'))
  <div class="flash flash-ok">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
      <path d="M20 6L9 17l-5-5" />
    </svg>
    {{ session('success') }}
  </div>
  @endif
  @if(session('error'))
  <div class="flash flash-err">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
      <circle cx="12" cy="12" r="10" />
      <line x1="12" y1="8" x2="12" y2="12" />
      <line x1="12" y1="16" x2="12.01" y2="16" />
    </svg>
    {{ session('error') }}
  </div>
  @endif

  {{-- Page Header --}}
  <div class="page-header">
    <div class="page-header-left">
      <h1>Planning &amp; Inspection</h1>
      <p>Manage inspections, material plans, and fabrication milestones.</p>
    </div>
    <div class="wp-pill">
      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
        <rect x="3" y="3" width="18" height="18" rx="2" />
        <path d="M9 9h6M9 13h6M9 17h4" />
      </svg>
      WP #{{ $workPackage ? $workPackage->work_package_no : '---' }} — {{ $workPackage ? $workPackage->workpackage_name : 'Select Work Package' }}
    </div>
  </div>

  {{-- Tab Bar --}}
  {{-- Determine active tab: default to 'insp', or from session after form submit --}}
  @php $activeTab = session('active_tab', 'insp'); @endphp

  <div class="tab-bar" role="tablist">
    <button class="tab-btn {{ $activeTab === 'insp' ? 'active-blue' : '' }}" id="tab-insp" onclick="switchTab('insp')" role="tab" aria-selected="{{ $activeTab === 'insp' ? 'true' : 'false' }}">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M9 11l3 3L22 4" />
        <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11" />
      </svg>
      <span class="tab-label">Inspection</span>
      <span class="tab-count count-blue">{{ $inspections->count() ?? 0 }}</span>
    </button>
    <button class="tab-btn {{ $activeTab === 'mat' ? 'active-teal' : '' }}" id="tab-mat" onclick="switchTab('mat')" role="tab" aria-selected="{{ $activeTab === 'mat' ? 'true' : 'false' }}">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="2" y="3" width="20" height="14" rx="2" />
        <path d="M8 21h8M12 17v4" />
      </svg>
      <span class="tab-label">Material Planning</span>
      <span class="tab-count count-teal">{{ $materialPlans->count() ?? 0 }}</span>
    </button>
    <button class="tab-btn {{ $activeTab === 'fab' ? 'active-amber' : '' }}" id="tab-fab" onclick="switchTab('fab')" role="tab" aria-selected="{{ $activeTab === 'fab' ? 'true' : 'false' }}">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z" />
      </svg>
      <span class="tab-label">Fabrication Planning</span>
      <span class="tab-count count-amber">{{ $fabricationPlans->count() ?? 0 }}</span>
    </button>
  </div>

  {{-- PANEL 1: INSPECTION --}}
  <div class="tab-panel {{ $activeTab === 'insp' ? 'active' : '' }}" id="panel-insp">
    <div class="split-layout">
      {{-- Inspection form visible to all roles --}}
      <div class="form-card">
        <div class="form-card-head head-blue">
          <div class="head-icon hi-blue">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M9 11l3 3L22 4" />
              <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11" />
            </svg>
          </div>
          <div>
            <div class="head-title">New Inspection</div>
            <div class="head-sub">Manager &amp; Expeditor</div>
          </div>
        </div>
        <form method="POST" enctype="multipart/form-data"
          action="{{ route('calendar.inspection.save', ['work_package_id' => request('work_package_id')]) }}">
          @csrf
          <input type="hidden" name="context_id" value="{{ request('context_id') }}">
          <div class="form-body">

            <div class="form-group">
              <label class="f-label">Date <span class="req">*</span></label>
              <input type="date" class="f-input focus-blue @error('inspection_date') is-invalid @enderror"
                name="inspection_date" value="{{ old('inspection_date') }}">
              @error('inspection_date')<span style="font-size:11.5px;color:var(--red)">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
              <label class="f-label">Inspection For <span class="req">*</span></label>
              <input type="text" class="f-input focus-blue @error('inspection_for') is-invalid @enderror" name="inspection_for" value="{{ old('inspection_for') }}" placeholder="Enter inspection purpose">
              @error('inspection_for')<span style="font-size:11.5px;color:var(--red)">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
              <label class="f-label">Location <span class="req">*</span></label>
              <input type="text" class="f-input focus-blue @error('inspection_location') is-invalid @enderror"
                name="inspection_location"
                placeholder="e.g. Supplier Factory, Munich"
                value="{{ old('inspection_location') }}">
              @error('inspection_location')<span style="font-size:11.5px;color:var(--red)">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
              <label class="f-label">Files <span style="color:var(--text3);font-weight:400;text-transform:none;letter-spacing:0">PDF, DOC, JPG, PNG</span></label>
              <div class="upload-zone" id="uz-insp"
                ondragover="onDragOver(event,'uz-insp')" ondragleave="onDragLeave('uz-insp')"
                ondrop="onDrop(event,'uz-insp','fi-insp','fl-insp')">
                <input type="file" id="fi-insp" name="inspection_file[]" multiple
                  accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                  onchange="handleFiles('fi-insp','fl-insp')">
                <div class="uz-icon uzi-blue">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" />
                    <polyline points="17 8 12 3 7 8" />
                    <line x1="12" y1="3" x2="12" y2="15" />
                  </svg>
                </div>
                <div class="uz-text"><b class="c-blue">Click to upload</b> or drag &amp; drop</div>
                <div class="uz-hint">Max 10MB each</div>
              </div>
              <div class="file-list" id="fl-insp"></div>
            </div>

          </div>
          <div class="form-footer">
            <span class="f-info">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" y1="8" x2="12" y2="12" />
                <line x1="12" y1="16" x2="12.01" y2="16" />
              </svg>
              {{ Auth::user()->name }}
            </span>
            <button type="reset" class="btn btn-ghost" onclick="document.getElementById('fl-insp').innerHTML=''">Clear</button>
            <button type="submit" class="btn btn-blue btn-full">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z" />
                <polyline points="17 21 17 13 7 13 7 21" />
                <polyline points="7 3 7 8 15 8" />
              </svg>
              Save Inspection
            </button>
          </div>
        </form>
      </div>

      {{-- History --}}
      <div class="history-card">
        <div class="history-head">
          <h3>Previous Inspections</h3>
          <span class="h-count">{{ $inspections->count() ?? 0 }} records</span>
        </div>

        @if(isset($inspections) && $inspections->count())
        <table class="insp-table" style="width:100%;border-collapse:collapse; font-size:13px;">
          <thead>
            <tr>
              <th style="padding:8px;border-bottom:1px solid #e2e7f3;text-align:left;">Date</th>
              <th style="padding:8px;border-bottom:1px solid #e2e7f3;text-align:left;">Inspection For</th>
              <th style="padding:8px;border-bottom:1px solid #e2e7f3;text-align:left;">Location</th>
              <th style="padding:8px;border-bottom:1px solid #e2e7f3;text-align:left;">By</th>
              <th style="padding:8px;border-bottom:1px solid #e2e7f3;text-align:left;">Files</th>
              <th style="padding:8px;border-bottom:1px solid #e2e7f3;text-align:left;">Status</th>
              <th style="padding:8px;border-bottom:1px solid #e2e7f3;text-align:left;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach($inspections as $insp)
            <tr>
              <td style="padding:8px;border-bottom:1px solid #e2e7f3;">{{ \Carbon\Carbon::parse($insp->inspection_date)->format('d M Y') }}</td>
              <td style="padding:8px;border-bottom:1px solid #e2e7f3;">{{ $insp->inspection_for_label ?? $insp->inspection_for }}</td>
              <td style="padding:8px;border-bottom:1px solid #e2e7f3;">{{ $insp->inspection_location }}</td>
              <td style="padding:8px;border-bottom:1px solid #e2e7f3;">{{ $insp->user->name ?? '—' }}</td>
              <td style="padding:8px;border-bottom:1px solid #e2e7f3;">
                @if(!empty($insp->files))
                @foreach($insp->files as $file)
                @php
                $filepath = is_array($file) ? $file['path'] : $file;
                $filename = is_array($file) ? ($file['name'] ?? basename($file['path'])) : basename($file);
                $ext = is_array($file) ? ($file['ext'] ?? pathinfo($file['path'], PATHINFO_EXTENSION)) : pathinfo($file, PATHINFO_EXTENSION);
                $icon = '📄';
                if (in_array($ext, ['pdf'])) $icon = '🗎';
                elseif (in_array($ext, ['doc','docx'])) $icon = '📝';
                elseif (in_array($ext, ['jpg','jpeg','png'])) $icon = '🖼️';
                @endphp
                <a class="file-chip" href="{{ asset('storage/'.$filepath) }}" download>
                  <span>{{ $icon }}</span> {{ $filename }}
                </a>
                @if(in_array(strtolower($ext), ['jpg','jpeg','png','gif']))
                  <br>
                  <img src="{{ asset('storage/'.$filepath) }}" alt="Image" style="width:85px;height:85px;object-fit:cover;margin:8px 0 8px 8px;border:1px solid #eee;border-radius:6px;display:inline-block;vertical-align:middle;" />
                @endif
                <br>
                @endforeach
                @else
                <span style="color:var(--text3);font-size:12px;">No files</span>
                @endif
              </td>
              <td style="padding:8px;border-bottom:1px solid #e2e7f3;">
                @php $isPast = \Carbon\Carbon::parse($insp->inspection_date)->isPast(); @endphp
                <span class="status-pill {{ $isPast ? 'sp-done' : 'sp-pending' }}">
                  {{ $isPast ? '✓ Done' : '⏳ Upcoming' }}
                </span>
              </td>
              <td style="padding:8px;border-bottom:1px solid #e2e7f3;">
                <form method="POST" action="{{ route('calendar.inspection.delete', $insp->id) }}" style="display:inline" onsubmit="return confirm('Delete this inspection?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="row-btn del">Delete</button>
                </form>
                <a href="{{ route('calendar.inspection.print', $insp->id) }}" class="row-btn print" target="_blank" style="margin-left:6px;">
                  Print Report
                </a>
                {{-- <a href="{{ route('calendar.inspection.pdf', $insp->id) }}" class="row-btn pdf" target="_blank" style="margin-left:6px;background:#3b82f6;color:#fff;">
                  Download PDF
                </a> --}}
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @else
        <div class="empty-state">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="opacity:.3">
            <path d="M9 11l3 3L22 4" />
            <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11" />
          </svg>
          No inspection records yet.
        </div>
        @endif
      </div>

    </div>
  </div>

  {{-- PANEL 2: MATERIAL PLANNING --}}
  <div class="tab-panel {{ $activeTab === 'mat' ? 'active' : '' }}" id="panel-mat">
    <div class="split-layout">

      <div class="form-card">
        <div class="form-card-head head-teal">
          <div class="head-icon hi-teal">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="2" y="3" width="20" height="14" rx="2" />
              <path d="M8 21h8M12 17v4" />
            </svg>
          </div>
          <div>
            <div class="head-title">New Material Plan</div>
            <div class="head-sub">Supplier portal</div>
          </div>
        </div>
        <form method="POST" enctype="multipart/form-data"
          action="{{ route('calendar.material.save', ['work_package_id' => request('work_package_id')]) }}">
          @csrf
          <input type="hidden" name="context_id" value="{{ request('context_id') }}">
          <div class="form-body">



            <div class="form-group">
              <label class="f-label">First Handover Date <span class="req">*</span></label>
              <input type="date" class="f-input focus-teal @error('first_handover_date') is-invalid @enderror"
                name="first_handover_date" value="{{ old('first_handover_date') }}">
              @error('first_handover_date')<span style="font-size:11.5px;color:var(--red)">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
              <label class="f-label">Last Date <span class="req">*</span></label>
              <input type="date" class="f-input focus-teal @error('last_date') is-invalid @enderror"
                name="last_date" value="{{ old('last_date') }}">
              @error('last_date')<span style="font-size:11.5px;color:var(--red)">{{ $message }}</span>@enderror
            </div>

            <!-- Comment Box for Material Plan (moved here) -->
            <div class="form-group">
              <label class="f-label">Comment</label>
              <textarea class="f-input focus-teal @error('material_comment') is-invalid @enderror" name="material_comment" rows="3" placeholder="Add any comments here...">{{ old('material_comment') }}</textarea>
              @error('material_comment')<span style="font-size:11.5px;color:var(--red)">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
              <label class="f-label">Files <span style="color:var(--text3);font-weight:400;text-transform:none;letter-spacing:0">PDF, DOC, JPG, PNG</span></label>
              <div class="upload-zone teal" id="uz-mat"
                ondragover="onDragOver(event,'uz-mat')" ondragleave="onDragLeave('uz-mat')"
                ondrop="onDrop(event,'uz-mat','fi-mat','fl-mat')">
                <input type="file" id="fi-mat" name="material_files[]" multiple
                  accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                  onchange="handleFiles('fi-mat','fl-mat')">
                <div class="uz-icon uzi-teal">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" />
                    <polyline points="17 8 12 3 7 8" />
                    <line x1="12" y1="3" x2="12" y2="15" />
                  </svg>
                </div>
                <div class="uz-text"><b class="c-teal">Click to upload</b> or drag &amp; drop</div>
                <div class="uz-hint">Max 10MB each</div>
              </div>
              <div class="file-list" id="fl-mat"></div>
            </div>

          </div>
          <div class="form-footer">
            <span class="f-info">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" y1="8" x2="12" y2="12" />
                <line x1="12" y1="16" x2="12.01" y2="16" />
              </svg>
              WP #{{ $selectedWp->work_package_no ?? '---' }}
            </span>
            <button type="reset" class="btn btn-ghost" onclick="document.getElementById('fl-mat').innerHTML=''">Clear</button>
            <button type="submit" class="btn btn-teal btn-full">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z" />
                <polyline points="17 21 17 13 7 13 7 21" />
                <polyline points="7 3 7 8 15 8" />
              </svg>
              Save Material Plan
            </button>
          </div>
        </form>
      </div>

      <div class="history-card">
        <div class="history-head">
          <h3>Material Plan History</h3>
          <span class="h-count">{{ $materialPlans->count() ?? 0 }} records</span>
        </div>

        @if(isset($materialPlans) && $materialPlans->count())
        <table style="width:100%;border-collapse:collapse; font-size:13px;">
          <thead>
            <tr>
              <th style="padding:8px;border-bottom:1px solid #e2e7f3;text-align:left;">1st Handover</th>
              <th style="padding:8px;border-bottom:1px solid #e2e7f3;text-align:left;">Last Date</th>
              <th style="padding:8px;border-bottom:1px solid #e2e7f3;text-align:left;">By</th>
              <th style="padding:8px;border-bottom:1px solid #e2e7f3;text-align:left;">Files</th>
              <th style="padding:8px;border-bottom:1px solid #e2e7f3;text-align:left;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach($materialPlans as $plan)
            <tr>
              <td style="padding:8px;border-bottom:1px solid #e2e7f3;">{{ \Carbon\Carbon::parse($plan->contract_date)->format('d M Y') }}</td>
              <td style="padding:8px;border-bottom:1px solid #e2e7f3;">{{ \Carbon\Carbon::parse($plan->first_handover_date)->format('d M Y') }}</td>
              <td style="padding:8px;border-bottom:1px solid #e2e7f3;">{{ \Carbon\Carbon::parse($plan->last_date)->format('d M Y') }}</td>
              <td style="padding:8px;border-bottom:1px solid #e2e7f3;">{{ $plan->user->name ?? '—' }}</td>
              <td style="padding:8px;border-bottom:1px solid #e2e7f3;">
                @forelse($plan->files ?? [] as $file)
                @php
                $filepath = is_array($file) ? $file['path'] : $file;
                $filename = is_array($file) ? ($file['name'] ?? basename($file['path'])) : basename($file);
                $ext = is_array($file) ? ($file['ext'] ?? pathinfo($file['path'], PATHINFO_EXTENSION)) : pathinfo($file, PATHINFO_EXTENSION);
                $icon = '📄';
                if (in_array($ext, ['pdf'])) $icon = '🗎';
                elseif (in_array($ext, ['doc','docx'])) $icon = '📝';
                elseif (in_array($ext, ['jpg','jpeg','png'])) $icon = '🖼️';
                @endphp
                <a class="file-chip" href="{{ asset('storage/'.$filepath) }}" target="_blank">{{ $icon }} {{ $filename }}</a>
                @if(in_array(strtolower($ext), ['jpg','jpeg','png','gif']))
                  <br>
                  <img src="{{ asset('storage/'.$filepath) }}" alt="Image" style="width:85px;height:85px;object-fit:cover;margin:8px 0 8px 8px;border:1px solid #eee;border-radius:6px;display:inline-block;vertical-align:middle;" />
                @endif
                @empty
                <span style="color:var(--text3);font-size:12px;">No files</span>
                @endforelse
              </td>
              <td style="padding:8px;border-bottom:1px solid #e2e7f3;">
                <form method="POST" action="{{ route('calendar.material.delete', $plan->id) }}" style="display:inline" onsubmit="return confirm('Delete this plan?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="row-btn del">Delete</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @else
        <div class="empty-state">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="opacity:.3">
            <rect x="2" y="3" width="20" height="14" rx="2" />
            <path d="M8 21h8M12 17v4" />
          </svg>
          No material plans yet.
        </div>
        @endif
      </div>

    </div>
  </div>

  {{-- PANEL 3: FABRICATION PLANNING --}}
  <div class="tab-panel {{ $activeTab === 'fab' ? 'active' : '' }}" id="panel-fab">
    <div class="split-layout">

      <div class="form-card">
        <div class="form-card-head head-amber">
          <div class="head-icon hi-amber">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z" />
            </svg>
          </div>
          <div>
            <div class="head-title">New Fabrication Plan</div>
            <div class="head-sub">Supplier / Expeditor</div>
          </div>
        </div>
        <form method="POST" enctype="multipart/form-data"
          action="{{ route('calendar.fabrication.save', ['work_package_id' => request('work_package_id')]) }}">
          @csrf
          <input type="hidden" name="context_id" value="{{ request('context_id') }}">
          <div class="form-body">

            <!-- Comment Box for Fabrication Plan -->

            <div class="form-group">
              <label class="f-label">First Handover Date <span class="req">*</span></label>
              <input type="date" class="f-input focus-amber @error('fabrication_first_handover_date') is-invalid @enderror"
                name="fabrication_first_handover_date" value="{{ old('fabrication_first_handover_date') }}">
              @error('fabrication_first_handover_date')<span style="font-size:11.5px;color:var(--red)">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
              <label class="f-label">Last Update <span class="req">*</span></label>
              <input type="date" class="f-input focus-amber @error('fabrication_last_update') is-invalid @enderror"
                name="fabrication_last_update" value="{{ old('fabrication_last_update') }}">
              @error('fabrication_last_update')<span style="font-size:11.5px;color:var(--red)">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
              <!-- Comment Box for Fabrication Plan (moved here) -->
              <div class="form-group">
                <label class="f-label">Comment</label>
                <textarea class="f-input focus-amber @error('fabrication_comment') is-invalid @enderror" name="fabrication_comment" rows="3" placeholder="Add any comments here...">{{ old('fabrication_comment') }}</textarea>
                @error('fabrication_comment')<span style="font-size:11.5px;color:var(--red)">{{ $message }}</span>@enderror
              </div>

              <label class="f-label">Files <span style="color:var(--text3);font-weight:400;text-transform:none;letter-spacing:0">PDF, DOC, JPG, PNG</span></label>
              <div class="upload-zone amber" id="uz-fab"
                ondragover="onDragOver(event,'uz-fab')" ondragleave="onDragLeave('uz-fab')"
                ondrop="onDrop(event,'uz-fab','fi-fab','fl-fab')">
                <input type="file" id="fi-fab" name="fabrication_files[]" multiple
                  accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                  onchange="handleFiles('fi-fab','fl-fab')">
                <div class="uz-icon uzi-amber">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" />
                    <polyline points="17 8 12 3 7 8" />
                    <line x1="12" y1="3" x2="12" y2="15" />
                  </svg>
                </div>
                <div class="uz-text"><b class="c-amber">Click to upload</b> or drag &amp; drop</div>
                <div class="uz-hint">Max 10MB each</div>
              </div>
              <div class="file-list" id="fl-fab"></div>
            </div>

          </div>
          <div class="form-footer">
            <span class="f-info">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" y1="8" x2="12" y2="12" />
                <line x1="12" y1="16" x2="12.01" y2="16" />
              </svg>
              WP #{{ $selectedWp->work_package_no ?? '---' }}
            </span>
            <button type="reset" class="btn btn-ghost" onclick="document.getElementById('fl-fab').innerHTML=''">Clear</button>
            <button type="submit" class="btn btn-amber btn-full">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z" />
                <polyline points="17 21 17 13 7 13 7 21" />
                <polyline points="7 3 7 8 15 8" />
              </svg>
              Save Fabrication Plan
            </button>
          </div>
        </form>
      </div>

      <div class="history-card">
        <div class="history-head">
          <h3>Fabrication Plan History</h3>
          <span class="h-count">{{ $fabricationPlans->count() ?? 0 }} records</span>
        </div>

        @if(isset($fabricationPlans) && $fabricationPlans->count())
        <table style="width:100%;border-collapse:collapse; font-size:13px;">
          <thead>
            <tr>
              <th style="padding:8px;border-bottom:1px solid #e2e7f3;text-align:left;">1st Handover</th>
              <th style="padding:8px;border-bottom:1px solid #e2e7f3;text-align:left;">Last Update</th>
              <th style="padding:8px;border-bottom:1px solid #e2e7f3;text-align:left;">By</th>
              <th style="padding:8px;border-bottom:1px solid #e2e7f3;text-align:left;">Files</th>
              <th style="padding:8px;border-bottom:1px solid #e2e7f3;text-align:left;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach($fabricationPlans as $plan)
            <tr>
              <td style="padding:8px;border-bottom:1px solid #e2e7f3;">{{ \Carbon\Carbon::parse($plan->fabrication_contract_date)->format('d M Y') }}</td>
              <td style="padding:8px;border-bottom:1px solid #e2e7f3;">{{ \Carbon\Carbon::parse($plan->fabrication_first_handover_date)->format('d M Y') }}</td>
              <td style="padding:8px;border-bottom:1px solid #e2e7f3;">{{ \Carbon\Carbon::parse($plan->fabrication_last_update)->format('d M Y') }}</td>
              <td style="padding:8px;border-bottom:1px solid #e2e7f3;">{{ $plan->user->name ?? '—' }}</td>
              <td style="padding:8px;border-bottom:1px solid #e2e7f3;">
                @forelse($plan->files ?? [] as $file)
                @php
                $filepath = is_array($file) ? $file['path'] : $file;
                $filename = is_array($file) ? ($file['name'] ?? basename($file['path'])) : basename($file);
                $ext = is_array($file) ? ($file['ext'] ?? pathinfo($file['path'], PATHINFO_EXTENSION)) : pathinfo($file, PATHINFO_EXTENSION);
                $icon = '📄';
                if (in_array($ext, ['pdf'])) $icon = '🗎';
                elseif (in_array($ext, ['doc','docx'])) $icon = '📝';
                elseif (in_array($ext, ['jpg','jpeg','png'])) $icon = '🖼️';
                @endphp
                <a class="file-chip" href="{{ asset('storage/'.$filepath) }}" target="_blank">{{ $icon }} {{ $filename }}</a>
                @if(in_array(strtolower($ext), ['jpg','jpeg','png','gif']))
                  <br>
                  <img src="{{ asset('storage/'.$filepath) }}" alt="Image" style="width:85px;height:85px;object-fit:cover;margin:8px 0 8px 8px;border:1px solid #eee;border-radius:6px;display:inline-block;vertical-align:middle;" />
                @endif
                <br>
                @empty
                <span style="color:var(--text3);font-size:12px;">No files</span>
                @endforelse
              </td>
              <td style="padding:8px;border-bottom:1px solid #e2e7f3;">
                <form method="POST" action="{{ route('calendar.fabrication.delete', $plan->id) }}" style="display:inline" onsubmit="return confirm('Delete this plan?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="row-btn del">Delete</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @else
        <div class="empty-state">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="opacity:.3">
            <path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z" />
          </svg>
          No fabrication plans yet.
        </div>
        @endif
      </div>

    </div>
  </div>

</div>{{-- .pi-wrap --}}
@endsection

@push('scripts')
<script>
  /* ── TAB SWITCHING ── */
  const tabs = {
    insp: {
      btn: 'tab-insp',
      panel: 'panel-insp',
      active: 'active-blue'
    },
    mat: {
      btn: 'tab-mat',
      panel: 'panel-mat',
      active: 'active-teal'
    },
    fab: {
      btn: 'tab-fab',
      panel: 'panel-fab',
      active: 'active-amber'
    },
  };

  function switchTab(key) {
    Object.entries(tabs).forEach(([k, t]) => {
      const btn = document.getElementById(t.btn);
      const panel = document.getElementById(t.panel);
      if (k === key) {
        btn.classList.add(t.active);
        panel.classList.add('active');
      } else {
        btn.classList.remove(t.active);
        panel.classList.remove('active');
      }
    });
  }

  /* ── FILE UPLOAD ── */
  function handleFiles(inputId, listId) {
    const files = Array.from(document.getElementById(inputId).files);
    const list = document.getElementById(listId);
    files.forEach(file => {
      if (file.size > 10485760) {
        alert(file.name + ' exceeds 10MB.');
        return;
      }
      const ext = file.name.split('.').pop().toLowerCase();
      const icon = ext === 'pdf' ? ['fti-pdf', 'PDF'] : ['doc', 'docx'].includes(ext) ? ['fti-doc', 'DOC'] : ['jpg', 'jpeg', 'png'].includes(ext) ? ['fti-img', 'IMG'] : ['fti-def', ext.toUpperCase().slice(0, 4)];
      const size = file.size < 1048576 ?
        (file.size / 1024).toFixed(1) + ' KB' :
        (file.size / 1048576).toFixed(1) + ' MB';
      const el = document.createElement('div');
      el.className = 'file-item';
      el.innerHTML =
        '<div class="fti ' + icon[0] + '">' + icon[1] + '</div>' +
        '<div class="fi-info">' +
        '<div class="fi-name">' + file.name.replace(/</g, '&lt;') + '</div>' +
        '<div class="fi-size">' + size + '</div>' +
        '</div>' +
        '<button type="button" class="fi-rm">' +
        '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">' +
        '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>' +
        '</svg>' +
        '</button>';
      el.querySelector('.fi-rm').onclick = () => el.remove();
      list.appendChild(el);
    });
  }

  /* ── DRAG & DROP ── */
  function onDragOver(e, id) {
    e.preventDefault();
    document.getElementById(id).classList.add('drag');
  }

  function onDragLeave(id) {
    document.getElementById(id).classList.remove('drag');
  }

  function onDrop(e, zoneId, inputId, listId) {
    e.preventDefault();
    document.getElementById(zoneId).classList.remove('drag');
    const dt = new DataTransfer();
    Array.from(e.dataTransfer.files).forEach(f => dt.items.add(f));
    document.getElementById(inputId).files = dt.files;
    handleFiles(inputId, listId);
  }

  /* ── TOAST ── */
  function showToast(msg) {
    const t = document.createElement('div');
    t.textContent = '✓  ' + msg;
    Object.assign(t.style, {
      position: 'fixed',
      bottom: '24px',
      right: '24px',
      background: '#0d1526',
      color: '#fff',
      padding: '11px 18px',
      borderRadius: '9px',
      fontSize: '13px',
      fontFamily: "'DM Sans',sans-serif",
      boxShadow: '0 8px 24px rgba(0,0,0,.18)',
      zIndex: '9999',
      opacity: '0',
      transition: 'opacity .2s, transform .2s',
      transform: 'translateY(8px)',
    });
    document.body.appendChild(t);
    requestAnimationFrame(() => {
      t.style.opacity = '1';
      t.style.transform = 'translateY(0)';
    });
    setTimeout(() => {
      t.style.opacity = '0';
      t.style.transform = 'translateY(8px)';
      setTimeout(() => t.remove(), 250);
    }, 3000);
  }

  /* ── Show toast on session success ── */
  @if(session('success'))
  showToast('{{ session('
    success ') }}');
  @endif
</script>
@endpush