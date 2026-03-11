
@extends('layouts.app')

@push('styles')
  {{-- Optionally reuse calendar_update styles if needed --}}
@endpush

@section('content')
<div class="pi-wrap">
  <div class="split-layout">
    <div class="form-card">
      <div class="form-card-head head-blue">
        <div class="head-icon hi-blue">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M9 11l3 3L22 4" />
            <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11" />
          </svg>
        </div>
        <div>
          <div class="head-title">Edit Inspection</div>
          <div class="head-sub">Manager &amp; Expeditor</div>
        </div>
      </div>
      <form method="POST" enctype="multipart/form-data" action="{{ route('calendar.inspection.save', ['work_package_id' => request('work_package_id')]) }}">
        @csrf
        <div class="form-body">
          <div class="form-group">
            <label class="f-label">Date <span class="req">*</span></label>
            <input type="date" class="f-input focus-blue @error('inspection_date') is-invalid @enderror" name="inspection_date" value="{{ old('inspection_date', $inspection->inspection_date) }}">
            @error('inspection_date')<span style="font-size:11.5px;color:var(--red)">{{ $message }}</span>@enderror
          </div>
          <div class="form-group">
            <label class="f-label">Inspection For <span class="req">*</span></label>
            <select class="f-select focus-blue @error('inspection_for') is-invalid @enderror" name="inspection_for">
              <option value="">Select purpose…</option>
              <option value="design" {{ (old('inspection_for', $inspection->inspection_for) == 'design') ? 'selected' : '' }}>Design Review</option>
              <option value="manufacturing" {{ (old('inspection_for', $inspection->inspection_for) == 'manufacturing') ? 'selected' : '' }}>Manufacturing Check</option>
            </select>
            @error('inspection_for')<span style="font-size:11.5px;color:var(--red)">{{ $message }}</span>@enderror
          </div>
          <div class="form-group">
            <label class="f-label">Location <span class="req">*</span></label>
            <input type="text" class="f-input focus-blue @error('inspection_location') is-invalid @enderror" name="inspection_location" value="{{ old('inspection_location', $inspection->inspection_location) }}">
            @error('inspection_location')<span style="font-size:11.5px;color:var(--red)">{{ $message }}</span>@enderror
          </div>
          <div class="form-group">
            <label class="f-label">Files</label>
            <input type="file" name="inspection_file[]" multiple>
            @if($inspection->files)
              <ul>
                @foreach($inspection->files as $file)
                  <li><a href="{{ asset('storage/' . $file) }}" target="_blank">{{ basename($file) }}</a></li>
                @endforeach
              </ul>
            @endif
          </div>
        </div>
        <div class="form-footer">
          <button type="submit" class="btn btn-blue btn-full">Save</button>
        </div>
      </form>
    </div>
    {{-- Optionally add history or other panels here --}}
  </div>
</div>
@endsection
