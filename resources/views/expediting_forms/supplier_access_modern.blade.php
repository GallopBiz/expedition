@extends('layouts.app')
@section('content')

<!-- Supplier Expedition Form - Modern UI -->
<div class="supplier-expedition-modern">
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
  <style>
    /* --- Modern CSS from your HTML sample goes here --- */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root { --navy: #1e2433; --navy-light: #252d3d; --indigo: #4f6ef7; --indigo-light: #6b84fa; --indigo-dim: #e8ecff; --green: #22c97a; --red: #f0525a; --amber: #f5a623; --gray-50: #f8f9fc; --gray-100: #f0f2f7; --gray-200: #e2e6f0; --gray-300: #c8cedd; --gray-500: #7c87a0; --gray-700: #3d4663; --gray-900: #1a2033; --white: #ffffff; --shadow-sm: 0 1px 3px rgba(0,0,0,0.07); --shadow: 0 4px 16px rgba(0,0,0,0.08); --shadow-lg: 0 8px 32px rgba(0,0,0,0.12); --radius: 12px; --radius-sm: 8px; }
    body { font-family: 'DM Sans', sans-serif; background: var(--gray-50); color: var(--gray-900); min-height: 100vh; }
    .navbar { position: fixed; top: 0; left: 0; right: 0; height: 60px; z-index: 100; background: var(--white); border-bottom: 1px solid var(--gray-200); display: flex; align-items: center; gap: 16px; padding: 0 24px; box-shadow: var(--shadow-sm); }
    .navbar-brand { font-weight: 700; font-size: 18px; color: var(--indigo); display: flex; align-items: center; gap: 8px; }
    .navbar-brand .dot { width: 8px; height: 8px; background: var(--indigo); border-radius: 50%; }
    .navbar-right { margin-left: auto; display: flex; align-items: center; gap: 12px; }
    .avatar { width: 34px; height: 34px; border-radius: 50%; background: linear-gradient(135deg,#4f6ef7,#a78bfa); display: flex; align-items: center; justify-content: center; color: white; font-size: 13px; font-weight: 600; }
    .nav-icon { width: 36px; height: 36px; border-radius: var(--radius-sm); background: var(--gray-100); display: flex; align-items: center; justify-content: center; color: var(--gray-500); cursor: pointer; font-size: 16px; }
    .layout { display: flex; padding-top: 60px; min-height: 100vh; }
    .main { flex: 1; padding: 28px 28px 60px; max-width: 1200px; margin: 0 auto; width: 100%; }
    .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
    .page-title { font-size: 22px; font-weight: 700; color: var(--gray-900); }
    .page-subtitle { font-size: 13px; color: var(--gray-500); margin-top: 2px; }
    .form-layout { display: flex; gap: 22px; align-items: flex-start; }
    .form-col { flex: 1; display: flex; flex-direction: column; gap: 16px; min-width: 0; }
    .preview-col { width: 290px; position: sticky; top: 82px; flex-shrink: 0; display: flex; flex-direction: column; gap: 14px; }
    .card { background: var(--white); border-radius: var(--radius); box-shadow: var(--shadow-sm); border: 1px solid var(--gray-200); padding: 20px; }
    .card-title { font-size: 13.5px; font-weight: 600; color: var(--gray-700); margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px solid var(--gray-100); display: flex; align-items: center; gap: 8px; }
    .card-title .badge { font-size: 10px; font-weight: 600; padding: 2px 7px; border-radius: 20px; background: var(--indigo-dim); color: var(--indigo); }
    .form-grid { display: grid; gap: 14px; }
    .col-2 { grid-template-columns: 1fr 1fr; }
    .span-2 { grid-column: 1 / -1; }
    .field label { display: block; font-size: 12px; font-weight: 600; color: var(--gray-500); margin-bottom: 5px; letter-spacing: .02em; }
    .field input, .field select, .field textarea { width: 100%; background: var(--gray-50); border: 1.5px solid var(--gray-200); border-radius: var(--radius-sm); padding: 9px 12px; font-family: inherit; font-size: 13.5px; color: var(--gray-900); outline: none; transition: all .15s; appearance: none; }
    .field input:focus, .field select:focus, .field textarea:focus { border-color: var(--indigo); background: #fff; box-shadow: 0 0 0 3px rgba(79,110,247,.1); }
    .field input.filled { border-color: var(--green); background: #f0fdf8; }
    .field textarea { resize: none; line-height: 1.6; }
    .field .hint { font-size: 11px; color: var(--gray-500); margin-top: 4px; }
    .form-actions { display: flex; gap: 10px; align-items: center; padding-top: 4px; }
    .btn { padding: 11px 22px; border-radius: var(--radius-sm); font-size: 13.5px; font-weight: 600; font-family: inherit; cursor: pointer; transition: all .15s; border: none; }
    .btn-primary { background: var(--indigo); color: white; }
    .btn-primary:hover { background: #3d5ce8; box-shadow: 0 4px 16px rgba(79,110,247,.4); }
    .btn-secondary { background: var(--gray-100); color: var(--gray-700); }
    .btn-secondary:hover { background: var(--gray-200); }
    .btn-ghost { background: transparent; color: var(--red); border: 1.5px solid var(--gray-200); }
    .btn-ghost:hover { border-color: var(--red); background: #fff0f1; }
    .preview-card { background: var(--white); border-radius: var(--radius); box-shadow: var(--shadow-sm); border: 1px solid var(--gray-200); padding: 18px; }
    .preview-header { display: flex; align-items: center; gap: 8px; margin-bottom: 14px; font-size: 13px; font-weight: 700; color: var(--gray-700); }
    .pulse { width: 8px; height: 8px; border-radius: 50%; background: var(--green); animation: pulse 2s infinite; }
    @keyframes pulse { 0%,100% { opacity:1; transform: scale(1); } 50% { opacity:.6; transform: scale(.85); } }
    .preview-row { display: flex; justify-content: space-between; align-items: baseline; padding: 8px 0; border-bottom: 1px solid var(--gray-100); gap: 8px; }
    .preview-row:last-child { border-bottom: none; }
    .preview-label { font-size: 11.5px; color: var(--gray-500); font-weight: 500; white-space: nowrap; }
    .preview-val { font-size: 12.5px; font-weight: 600; color: var(--gray-800); text-align: right; max-width: 160px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .preview-val.green { color: var(--green); }
    .preview-val.red { color: var(--red); }
    .preview-val.empty { color: var(--gray-300); font-weight: 400; font-style: italic; }
    .preview-desc { font-size: 12px; color: var(--gray-700); line-height: 1.6; margin-top: 6px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
  </style>
  <nav class="navbar">
    <div class="navbar-brand"><div class="dot"></div> Supplier Panel</div>
    <div style="display:flex;gap:6px;margin-left:32px">
      <span style="font-size:12px;color:var(--gray-500)">Expediting</span>
      <span style="color:var(--gray-300)">/</span>
      <span style="font-size:12px;color:var(--gray-700);font-weight:600">Supplier Form</span>
    </div>
    <div class="navbar-right">
      <div class="nav-icon">🔔</div>
      <div class="nav-icon">⚙️</div>
      <div class="avatar">{{ strtoupper(substr(Auth::user()->name,0,2)) }}</div>
    </div>
  </nav>
  <div class="layout">
    <main class="main">
      <div class="page-header">
        <div>
          <div class="page-title">Supplier Expediting Form</div>
          <div class="page-subtitle">Fill in all details — preview updates live on the right →</div>
        </div>
      </div>
      @if(session('success'))
        <div class="mb-4 p-2 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
      @endif
      @if($errors->any())
        <div class="mb-4 p-2 bg-red-100 text-red-800 rounded">
          <ul class="list-disc pl-5">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      <div class="parent-card-group grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($parentGroups as $parentName => $children)
          @php $context = $parentContexts[$parentName] ?? null; @endphp
          <div class="parent-card card p-6 relative">
            <div class="font-semibold text-lg mb-2">Parent Work Package: {{ $parentName }}</div>
            @if($context)
              <div class="mb-2 text-sm text-gray-700">
                <strong>PO Number:</strong> {{ $context->po_number ?? '-' }}<br>
                <strong>Order Date:</strong> {{ $context->order_date ?? '-' }}<br>
                <strong>Incoterms:</strong> {{ $context->incoterms ?? '-' }}<br>
                <strong>Contract Manager:</strong> {{ $context->exyte_procurement_contract_manager ?? '-' }}<br>
                <strong>Customer Contact:</strong> {{ $context->customer_procurement_contact ?? '-' }}<br>
                <strong>Kickoff Status:</strong> {{ $context->kickoff_status ?? '-' }}<br>
              </div>
            @endif
            <button class="btn btn-primary mt-2" onclick="openModal('modal-{{ md5($parentName) }}')">View Details</button>
            <!-- Modal -->
            <div id="modal-{{ md5($parentName) }}" class="modal fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
              <div class="modal-content bg-white rounded-lg shadow-lg p-6 w-full max-w-5xl relative" style="min-width:1200px;">
                <button class="absolute top-2 right-2 text-gray-500 hover:text-gray-700" onclick="closeModal('modal-{{ md5($parentName) }}')">&times;</button>
                <div class="font-semibold text-lg mb-4">Child Work Packages for: {{ $parentName }}</div>
                <div class="space-y-4 max-h-[60vh] overflow-y-auto">
                  @foreach($children as $child)
                    <div class="child-card card p-4">
                      <div class="mb-2 text-sm text-gray-800">
                        <span class="font-semibold">Child Work Package:</span> {{ $child->work_package }}
                        <span class="ml-2 text-xs text-gray-500">({{ $child->material_desc ?? $child->equipment_type_tag_number ?? '' }})</span>
                      </div>
                      <form method="POST" action="{{ route('supplier.expedition_modern.submit') }}" class="space-y-2">
                        @csrf
                        <input type="hidden" name="id" value="{{ $child->id }}">
                        <div class="grid grid-cols-4 gap-4 items-end" style="align-items: stretch;">
                          <div class="field" style="grid-column: 1 / 2; width:100%;">
                            <label>Quantity</label>
                            <input type="number" name="quantity" value="{{ $child->quantity }}" class="filled">
                          </div>
                          <div class="field" style="grid-column: 2 / 3; width:100%;">
                            <label>Value</label>
                            <input type="text" name="value" value="{{ $child->value ?? '' }}">
                          </div>
                          <div class="field" style="grid-column: 1 / 2; width:100%;">
                            <label>Planned Delivery</label>
                            <input type="date" name="planned_delivery" value="{{ $child->planned_delivery ?? '' }}">
                          </div>
                          <div class="field" style="grid-column: 2 / 3; width:100%;">
                            <label>Forecast Delivery</label>
                            <input type="date" name="forecast_delivery" value="{{ $child->forecast_delivery_to_site ?? '' }}">
                          </div>
                          <div class="field" style="grid-column: 1 / 2; width:100%;">
                            <label>Actual Delivery</label>
                            <input type="date" name="actual_delivery" value="{{ $child->actual_delivery_to_site_supplier ?? '' }}">
                          </div>
                          <div class="field col-span-2" style="grid-column: 1 / 3; width:100%;">
                            <label>Remarks</label>
                            <textarea name="comments" rows="2">{{ $child->comments }}</textarea>
                          </div>
                          <div class="field" style="grid-column: 3 / 4; width:100%;">
                            <label>Design Status (%)</label>
                            <input type="number" name="design_status" value="{{ $child->design_status ?? '' }}" min="0" max="100" class="filled">
                            <div class="progress-bar bg-gray-200 rounded h-2 mt-1">
                              <div class="bg-blue-500 h-2 rounded" style="width: {{ $child->design_status ?? 0 }}%"></div>
                            </div>
                          </div>
                          <div class="field" style="grid-column: 4 / 5; width:100%;">
                            <label>Material Status (%)</label>
                            <input type="number" name="material_status" value="{{ $child->material_status ?? '' }}" min="0" max="100" class="filled">
                            <div class="progress-bar bg-gray-200 rounded h-2 mt-1">
                              <div class="bg-purple-500 h-2 rounded" style="width: {{ $child->material_status ?? 0 }}%"></div>
                            </div>
                          </div>
                          <div class="field" style="grid-column: 3 / 4; width:100%;">
                            <label>FAT Status (%)</label>
                            <input type="number" name="fat_status" value="{{ $child->fat_status ?? '' }}" min="0" max="100" class="filled">
                            <div class="progress-bar bg-gray-200 rounded h-2 mt-1">
                              <div class="bg-green-500 h-2 rounded" style="width: {{ $child->fat_status ?? 0 }}%"></div>
                            </div>
                          </div>
                          <div class="field" style="grid-column: 4 / 5; width:100%;">
                            <label>Fabrication Status (%)</label>
                            <input type="number" name="fabrication_status" value="{{ $child->fabrication_status ?? '' }}" min="0" max="100" class="filled">
                            <div class="progress-bar bg-gray-200 rounded h-2 mt-1">
                              <div class="bg-yellow-500 h-2 rounded" style="width: {{ $child->fabrication_status ?? 0 }}%"></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-actions">
                          <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                      </form>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
      <script>
        function openModal(id) {
          document.getElementById(id).classList.remove('hidden');
          document.body.classList.add('overflow-hidden');
        }
        function closeModal(id) {
          document.getElementById(id).classList.add('hidden');
          document.body.classList.remove('overflow-hidden');
        }
      </script>
    </main>
  </div>
  <script>
    // JS for live preview and field sync
    function sync(input, previewId) {
      const el = document.getElementById(previewId);
      if (input.value.trim()) {
        el.textContent = input.value;
        el.classList.remove('empty');
        input.classList.add('filled');
      } else {
        el.textContent = '—';
        el.classList.add('empty');
        input.classList.remove('filled');
      }
    }
    function check() {}
    // On page load, sync all fields with preview
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('.form-col input, .form-col textarea').forEach(function(input) {
        if (input.value) {
          const previewId = 'p_' + input.name.replace(/_/g, '');
          if (document.getElementById(previewId)) {
            sync(input, previewId);
          }
        }
      });
    });
  </script>
</div>
@endsection
