@extends('layouts.app')

@section('content')
<main>
  <div class="mb-4 flex items-center">
    <a href="{{ url('/expediting-forms/create') }}" class="inline-flex items-center px-2 py-1 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-full shadow transition text-xs font-semibold">
      <svg xmlns='http://www.w3.org/2000/svg' class='h-4 w-4 mr-1' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 19l-7-7 7-7' /></svg>
      Back
    </a>
  </div>
  <!-- main content continues below -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  :root {
    --green:       #3cb546;
    --green-light: #e8f7e9;
    --green-dark:  #2a9132;
    --gray-card:   #6c757d;
    --yellow:      #e8a317;
    --yellow-bg:   #fdf3e3;
    --text-dark:   #1a1a2e;
    --text-mid:    #555;
    --text-soft:   #9aa3af;
    --border:      #e4e8ec;
    --bg-page:     #f4f6f8;
    --white:       #ffffff;
    --shadow-hover:0 6px 24px rgba(60,181,70,.15);
    --circle-track: #e8ecf0;
    --circle-green: #3cb546;
    --circle-size:  38px;
    --circle-stroke: 3.2;
  }
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: 'DM Sans', sans-serif; background: var(--bg-page); color: var(--text-dark); min-height: 100vh; }
  main { max-width: 1270px; margin: 0 auto; }
  .card-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.1rem; }
  @media (max-width: 960px) { .card-grid { grid-template-columns: repeat(2,1fr); } }
  @media (max-width: 520px) { .card-grid { grid-template-columns: 1fr; } }
  .card {
    background: var(--white);
    border: 1.5px solid var(--border);
    border-radius: 12px;
    padding: 1rem 1rem .85rem;
    display: flex;
    flex-direction: column;
    gap: .65rem;
    position: relative;
    transition: box-shadow .2s, transform .2s;
    animation: fadeUp .35s ease both;
    height: 100%;
    min-height: 260px;
  }
  .card:hover { box-shadow: var(--shadow-hover); transform: translateY(-2px); }
  @keyframes fadeUp { from { opacity: 0; transform: translateY(12px); } to   { opacity: 1; transform: translateY(0); } }
  .card-head { display: flex; align-items: flex-start; justify-content: space-between; gap: .5rem; }
  .card-title { font-size: .9rem; font-weight: 700; color: var(--text-dark); line-height: 1.35; flex: 1; }
  .card-owner { display: flex; align-items: center; gap: .4rem; font-size: .76rem; }
  .owner-name { font-weight: 600; color: #b53cb1; }
  .interview-type { color: var(--text-soft); }
  .card-divider { border: none; border-top: 1px solid var(--border); margin: .1rem 0; }
  .circles-row { display: flex; align-items: center; justify-content: space-between; gap: .25rem; }
  .circle-item { display: flex; flex-direction: column; align-items: center; gap: .28rem; flex: 1; }
  .circle-svg { width: var(--circle-size); height: var(--circle-size); transform: rotate(-90deg); }
  .circle-track { fill: none; stroke: var(--circle-track); stroke-width: var(--circle-stroke); }
  .circle-fill { fill: none; stroke: #00b5e2; stroke-width: var(--circle-stroke); stroke-linecap: round; transition: stroke-dashoffset .8s cubic-bezier(.4,0,.2,1); }
  .circle-wrap { position: relative; width: var(--circle-size); height: var(--circle-size); }
  .circle-wrap svg { position: absolute; top: 0; left: 0; }
  .circle-pct { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; font-size: .58rem; font-weight: 700; color: var(--text-dark); line-height: 1; }
  .delivered-wrap { display: flex; flex-direction: column; align-items: center; gap: .28rem; flex: 1; }
  .delivered-fraction { width: var(--circle-size); height: var(--circle-size); display: flex; align-items: center; justify-content: center; background: #f7f8fa; border-radius: 50%; border: 2px solid var(--border); font-size: .65rem; font-weight: 700; color: var(--text-dark); line-height: 1; }
  .circle-label { font-size: .6rem; font-weight: 500; color: var(--text-soft); text-align: center; text-transform: uppercase; letter-spacing: .03em; white-space: nowrap; }
  .card-actions {
    display: flex;
    align-items: center;
    gap: .5rem;
    margin-top: auto;
    min-height: 48px;
  }
  .badge-delivered {
    border-radius: 16px;
    padding: .12rem .4rem;
    font-size: .6rem;
    font-weight: 600;
    border: 1.5px solid #b3c9db;
    white-space: nowrap;
    background: #e6eef4;
    color: #01426a;
  }
  .badge-delivered-yes {
    background: #e8f7e9;
    color: #3cb546;
    border: 1.5px solid #3cb546;
  }
  .badge-delivered-no {
    background: #ffeaea;
    color: #e31717;
    border: 1.5px solid #e31717;
  }
  .badge-category {
    border-radius: 16px;
    padding: .10rem .35rem;
    font-size: .58rem;
    font-weight: 600;
    margin-bottom: 0.3rem;
    display: inline-block;
    white-space: nowrap;
  }
  .badge-category-low {
    background: #e8f7e9;
    color: #3cb546;
    border: 1.5px solid #3cb546;
  }
  .badge-category-medium {
    background: #fffbe6;
    color: #e8a317;
    border: 1.5px solid #e8a317;
  }
  .badge-category-high {
    background: #ffeaea;
    color: #e31717;
    border: 1.5px solid #e31717;
  }
  .action-btn {
    margin-left: auto;
    border: none;
    border-radius: 8px;
    padding: .32rem .9rem;
    font-family: inherit;
    font-size: .78rem;
    font-weight: 600;
    cursor: pointer;
    transition: all .15s;
    background: #01426a;
    color: #fff;
  }
  .btn-view { background: #01426a; color: #fff; }
  .btn-view:hover { background: #003a54; }
</style>
<style>
  @php
    $user = Auth::user();
  @endphp
  @if($user && $user->role === 'Supplier')
  .email-btn, .email-btn-onetime, .email-form, #emailConfirmModal {
    display: none !important;
  }
  @endif
</style>
<main>
  <div class="card-filters" style="display:flex;flex-wrap:wrap;gap:1rem;margin-bottom:2rem;align-items:center;justify-content:center;background:#f7f8fa;border-radius:12px;padding:1.2rem 1rem;box-shadow:0 2px 8px rgba(60,181,70,.07);">
    <form method="GET" action="" style="display:flex;flex-wrap:wrap;gap:1.2rem;align-items:center;width:100%;justify-content:center;">
      <div style="display:flex;flex-direction:column;min-width:160px;">
        <label for="supplier_name" style="font-size:.92rem;font-weight:600;margin-bottom:.3em;color:#01426a;">Supplier Name</label>
        <input type="text" name="supplier_name" id="supplier_name" value="{{ request('supplier_name') }}" style="padding:.45em .9em;border-radius:8px;border:1.5px solid #b3c9db;background:#fff;min-width:120px;font-size:.98rem;">
      </div>
      <div style="display:flex;flex-direction:column;min-width:160px;">
        <label for="expediting_category" style="font-size:.92rem;font-weight:600;margin-bottom:.3em;color:#01426a;">Expediting Category</label>
        <select name="expediting_category" id="expediting_category" style="padding:.45em .9em;border-radius:8px;border:1.5px solid #b3c9db;background:#fff;min-width:120px;font-size:.98rem;">
          <option value="">All</option>
          <option value="Low" {{ request('expediting_category')=='Low'?'selected':'' }}>Low</option>
          <option value="Medium" {{ request('expediting_category')=='Medium'?'selected':'' }}>Medium</option>
          <option value="High" {{ request('expediting_category')=='High'?'selected':'' }}>High</option>
        </select>
      </div>
      <div style="display:flex;flex-direction:column;min-width:160px;">
        <label for="delivered" style="font-size:.92rem;font-weight:600;margin-bottom:.3em;color:#01426a;">Delivered</label>
        <select name="delivered" id="delivered" style="padding:.45em .9em;border-radius:8px;border:1.5px solid #b3c9db;background:#fff;min-width:120px;font-size:.98rem;">
          <option value="">All</option>
          <option value="Yes" {{ request('delivered')=='Yes'?'selected':'' }}>Yes</option>
          <option value="No" {{ request('delivered')=='No'?'selected':'' }}>No</option>
        </select>
      </div>
      <div style="flex:1;min-width:220px;display:flex;flex-direction:column;">
        <label for="search" style="font-size:.92rem;font-weight:600;margin-bottom:.3em;color:#01426a;">Search</label>
        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Work Package Name/Number, Equipment Type/Tag" style="padding:.45em .9em;border-radius:8px;border:1.5px solid #b3c9db;background:#fff;width:100%;font-size:.98rem;">
      </div>
      <button type="submit" style="padding:.6em 2em;border-radius:8px;background:#01426a;color:#fff;font-weight:600;border:none;font-size:1.05rem;box-shadow:0 2px 8px rgba(60,181,70,.07);margin-top:0;">Filter/Search</button>
      <a href="{{ url()->current() }}" style="padding:.6em 2em;border-radius:8px;background:#b3c9db;color:#01426a;font-weight:600;border:none;font-size:1.05rem;box-shadow:0 2px 8px rgba(60,181,70,.07);text-decoration:none;display:inline-block;margin-top:0;">Reset</a>
    </form>
    <a href="{{ route('workpackage.export.all') }}" class="action-btn btn-view" style="background:#3cb546;margin-left:20px;">Export All Work Packages</a>
  </div>
  <div class="card-grid">
    @foreach($expeditingForms as $form)
    <div class="card">
      <div style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
          @php
            $cat = strtolower($form->expediting_category ?? '');
          @endphp
          @if($cat === 'low')
            <span class="badge-category badge-category-low">Expediting Category: Low</span>
          @elseif($cat === 'medium' || $cat === 'middle')
            <span class="badge-category badge-category-medium">Expediting Category: Medium</span>
          @elseif($cat === 'high')
            <span class="badge-category badge-category-high">Expediting Category: High</span>
          @endif
        </div>
        <div style="margin-left: auto; text-align: right;">
          <span style="font-size: .65rem; font-weight: 700; color: var(--text-dark);">Kick Off: {{ ($form->kickoff_status ?? 0) == 1 ? 'Yes' : 'No' }}</span>
        </div>
      </div>
      <div class="card-head">
        <p class="card-title">
          {{ $form->workpackage_name ?? '' }} - {{ $form->work_package_no ?? $form->po_number ?? '' }}
        </p>
      </div>
      <div class="card-owner" style="display: flex; align-items: center; gap: .4rem; font-size: .76rem;">
        <span class="owner-name">
          @php
            $supplier = $form->supplier ?? 'N/A';
            $supplier = ucfirst(strtolower($supplier));
            $supplierEmail = $form->supplier_email ?? $form->email ?? null;
          @endphp
          {{ $supplier }}
        </span>
        @if($supplierEmail)
          <span style="color: #357ab7; font-size: 1em; margin-left: 0.5em;">{{ $supplierEmail }}</span>
        @endif
        <div style="margin-left:auto;display:flex;align-items:center;gap:8px;">
          @if($supplierEmail)
            <form action="{{ route('expediting_forms.send_email', $form->id) }}" method="POST" class="inline email-form">
              @csrf
              <button type="button" class="email-btn" title="Email to Supplier" style="background:none;border:none;padding:0;display:flex;align-items:center;color:#01426a;cursor:pointer;font-size:1.1em;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383-4.708 2.825L15 11.118V5.383zM14.803 12 10.082 8.647l-1.403.842a.5.5 0 0 1-.52 0l-1.403-.842L1.197 12A1 1 0 0 0 2 13h12a1 1 0 0 0 .803-1zM1 11.118l4.708-2.91L1 5.383v5.735z"/>
                </svg>
              </button>
            </form>
            <!-- New email icon for one-time supplier form submission -->
                  <button type="button" class="email-btn-onetime" title="Send One-Time Supplier Link" style="background:none;border:none;padding:0;display:flex;align-items:center;color:#3cb546;cursor:pointer;font-size:1.1em;" onclick="confirmOneTimeSupplierEmail(this, {{ $form->context_id ?? $form->id }})">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                <path d="M2 2h12v12H2V2zm1 1v10h10V3H3zm2 2h6v6H5V5zm1 1v4h4V6H6z"/>
              </svg>
            </button>
          @push('scripts')
          <script>
          function confirmOneTimeSupplierEmail(btn, contextId) {
            if (confirm('Send one-time supplier form link by email?')) {
              fetch('/expediting-equipment/send-supplier-email', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ context_id: contextId })
              })
              .then(response => response.json())
              .then(data => {
                if (data.success) {
                  alert('Supplier email sent successfully!');
                } else {
                  alert('Error: ' + (data.error || 'Failed to send email.'));
                }
              })
              .catch(() => {
                alert('Failed to send email.');
              });
            }
          }
          </script>
          @endpush
          @endif
        </div>
      </div>
      <!-- Email Confirmation Modal (shared for all cards) -->
      <div id="emailConfirmModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-sm text-center border-t-8 border-green-600 relative animate-fade-in">
          <div class="flex flex-col items-center mb-4">
            <div id="emailConfirmText" class="text-gray-900 font-bold text-lg mb-1"></div>
            <div class="text-gray-600 text-base mb-4">Are you sure you want to send this expediting form link to the supplier?</div>
          </div>
          <div class="flex justify-center gap-4 mt-2">
            <button id="emailConfirmYes" class="px-6 py-2 rounded-lg bg-gradient-to-r from-green-500 to-green-700 text-white font-semibold shadow hover:from-green-600 hover:to-green-800 transition">Yes, Send Email</button>
            <button id="emailConfirmNo" class="px-6 py-2 rounded-lg bg-gray-200 text-gray-800 font-semibold shadow hover:bg-gray-300 transition">Cancel</button>
          </div>
          <button id="emailConfirmClose" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-2xl leading-none">&times;</button>
        </div>
      </div>
      <script>
      document.addEventListener('DOMContentLoaded', function () {
        let emailModal = document.getElementById('emailConfirmModal');
        let emailConfirmText = document.getElementById('emailConfirmText');
        let emailYesBtn = document.getElementById('emailConfirmYes');
        let emailNoBtn = document.getElementById('emailConfirmNo');
        let emailFormToSubmit = null;
        document.querySelectorAll('.email-btn').forEach(function(btn) {
          btn.addEventListener('click', function(e) {
            e.preventDefault();
            emailFormToSubmit = btn.closest('form');
            let supplierEmail = emailFormToSubmit.closest('.card-owner').querySelector('span[style*="color: #357ab7"]').textContent;
            emailConfirmText.innerHTML = '<span class="text-green-700">Send email to <b>' + supplierEmail + '</b>?';
            emailModal.classList.remove('hidden');
          });
        });
        function closeEmailModal() {
          emailModal.classList.add('hidden');
          emailFormToSubmit = null;
        }
        emailYesBtn.addEventListener('click', function() {
          if (emailFormToSubmit) emailFormToSubmit.submit();
          closeEmailModal();
        });
        emailNoBtn.addEventListener('click', closeEmailModal);
        document.getElementById('emailConfirmClose').addEventListener('click', closeEmailModal);
        window.addEventListener('keydown', function(e) {
          if (!emailModal.classList.contains('hidden') && (e.key === 'Escape' || e.keyCode === 27)) {
            closeEmailModal();
          }
        });
      });
      </script>
      @if(!empty($form->equipment_type_tag_number))
      <div style="font-size: .75rem; color: var(--text-mid); margin-bottom: 0.2rem;">
        Equipment Type / Tag Number: <strong>{{ $form->equipment_type_tag_number }}</strong>
      </div>
      @endif
      <hr class="card-divider">
     
      <div class="circles-row">
        <div class="circle-item">
          <div class="circle-wrap" data-pct="{{ $form->avg_design ?? 0 }}">
            <svg class="circle-svg" viewBox="0 0 38 38"><circle class="circle-track" cx="19" cy="19" r="15.5"/><circle class="circle-fill" cx="19" cy="19" r="15.5" stroke-dasharray="97.4 97.4" stroke-dashoffset="97.4"/></svg>
            <span class="circle-pct">{{ $form->avg_design ?? 0 }}%</span>
          </div>
          <span class="circle-label">Design</span>
        </div>
        <div class="circle-item">
          <div class="circle-wrap" data-pct="{{ $form->avg_material ?? 0 }}">
            <svg class="circle-svg" viewBox="0 0 38 38"><circle class="circle-track" cx="19" cy="19" r="15.5"/><circle class="circle-fill" cx="19" cy="19" r="15.5" stroke-dasharray="97.4 97.4" stroke-dashoffset="97.4"/></svg>
            <span class="circle-pct">{{ $form->avg_material ?? 0 }}%</span>
          </div>
          <span class="circle-label">Material</span>
        </div>
        <div class="circle-item">
          <div class="circle-wrap" data-pct="{{ $form->avg_fabrication ?? 0 }}">
            <svg class="circle-svg" viewBox="0 0 38 38"><circle class="circle-track" cx="19" cy="19" r="15.5"/><circle class="circle-fill" cx="19" cy="19" r="15.5" stroke-dasharray="97.4 97.4" stroke-dashoffset="97.4"/></svg>
            <span class="circle-pct">{{ $form->avg_fabrication ?? 0 }}%</span>
          </div>
          <span class="circle-label">Fabrication</span>
        </div>
        <div class="circle-item">
          <div class="circle-wrap" data-pct="{{ $form->avg_fat ?? 0 }}">
            <svg class="circle-svg" viewBox="0 0 38 38"><circle class="circle-track" cx="19" cy="19" r="15.5"/><circle class="circle-fill" cx="19" cy="19" r="15.5" stroke-dasharray="97.4 97.4" stroke-dashoffset="97.4"/></svg>
            <span class="circle-pct">{{ $form->avg_fat ?? 0 }}%</span>
          </div>
          <span class="circle-label">FAT</span>
        </div>
        <div class="circle-item">
          <div class="circle-wrap" data-pct="{{ $form->total_equipment ? round(($form->delivered_equipment / max($form->total_equipment,1)) * 100) : 0 }}">
            <svg class="circle-svg" viewBox="0 0 38 38"><circle class="circle-track" cx="19" cy="19" r="15.5"/><circle class="circle-fill" cx="19" cy="19" r="15.5" stroke-dasharray="97.4 97.4" stroke-dashoffset="97.4"/></svg>
            <span class="circle-pct">{{ $form->delivered_equipment ?? 0 }}/{{ $form->total_equipment ?? 0 }}</span>
          </div>
          <span class="circle-label">Delivered</span>
        </div>
      </div>
      <div class="card-actions">
        @php
          $delivered = $form->delivered;
          $isDelivered = ($delivered == 1);
        @endphp
        <span class="badge-delivered {{ $isDelivered ? 'badge-delivered-yes' : 'badge-delivered-no' }}">
          Delivered {{ $isDelivered ? 'Yes' : 'No' }}
        </span>
        <!-- Hide Manage button and add View button -->
        <!-- <a href="{{ route('expediting_forms.edit', $form->id) }}" class="action-btn btn-view">Manage</a> -->
        @php
          $user = Auth::user();
          $viewUrl = '';
          if ($user && $user->role === 'Manager') {
            $viewUrl = route('manager.expedition_v2', ['context_id' => $form->context_id ?? $form->id, 'edit' => 1]);
          } elseif ($user && $user->role === 'Expeditor') {
            $viewUrl = route('expeditor.expedition_v2', ['context_id' => $form->context_id ?? $form->id, 'edit' => 1]);
          } else {
            $viewUrl = route('supplier.expedition_v2', ['context_id' => $form->context_id ?? $form->id, 'edit' => 1]);
          }
        @endphp
        <a href="{{ $viewUrl }}" class="action-btn btn-view" target="_blank">View</a>
        <a href="{{ route('workpackage.export', ['context_id' => $form->context_id ?? $form->id]) }}" class="action-btn btn-view" style="background:#3cb546;" target="_blank">Export</a>
      </div>
    </div>
    @endforeach
  </div>
  @if($expeditingForms->hasMorePages())
    <div style="text-align:center; margin-top:2rem;">
      <a href="{{ $expeditingForms->nextPageUrl() }}" class="action-btn btn-view" style="display:inline-block; min-width:160px;">Load More</a>
    </div>
  @endif
</main>
<script>
  // Animate circles on load
  const CIRCUM = 97.39;
  document.querySelectorAll('.circle-wrap[data-pct]').forEach(wrap => {
    const pct  = parseFloat(wrap.dataset.pct) || 0;
    const fill = wrap.querySelector('.circle-fill');
    const offset = CIRCUM - (pct / 100) * CIRCUM;
    requestAnimationFrame(() => {
      setTimeout(() => { fill.style.strokeDashoffset = offset; }, 80);
    });
  });
</script>
@endsection
