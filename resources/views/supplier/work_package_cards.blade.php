@extends('layouts.app')

@section('content')
<main>
  <div class="card-grid">
    @foreach($expeditingForms as $form)
      @if(auth()->user()->role === 'Supplier' && ($form->supplier == (auth()->user()->company_name ?? auth()->user()->name)))
        <div class="card">
          <div class="card-head">
            <p class="card-title">
              {{ $form->workpackage_name ?? '' }} - {{ $form->work_package_no ?? $form->po_number ?? '' }}
            </p>
          </div>
          <div class="card-owner">
            <span class="owner-name">{{ $form->supplier }}</span>
            <span style="color: #357ab7; font-size: 1em; margin-left: 0.5em;">{{ $form->supplier_email ?? $form->email ?? null }}</span>
          </div>
          <hr class="card-divider">
          <div class="card-actions">
            <span class="badge-delivered {{ $form->delivered == 1 ? 'badge-delivered-yes' : 'badge-delivered-no' }}">
              Delivered {{ $form->delivered == 1 ? 'Yes' : 'No' }}
            </span>
            <a href="{{ route('supplier.expedition_v2', ['context_id' => $form->context_id ?? $form->id, 'edit' => 1]) }}" class="action-btn btn-view" target="_blank">View</a>
          </div>
        </div>
      @endif
    @endforeach
  </div>
</main>
@endsection
