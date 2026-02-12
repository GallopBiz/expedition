@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-12 p-8 bg-white rounded-xl shadow">
    <h1 class="text-2xl font-bold mb-4 text-green-800">Supplier Expediting Form</h1>
    <div class="mb-6">
        <div class="mb-2"><span class="font-semibold">Work Package:</span> {{ $expeditingForm->work_package }}</div>
        <div class="mb-2"><span class="font-semibold">Supplier:</span> {{ $expeditingForm->supplier }}</div>
        <div class="mb-2"><span class="font-semibold">Workstream/Building:</span> {{ $expeditingForm->workstream_building }}</div>
        <div class="mb-2"><span class="font-semibold">Expediting Contact:</span> {{ $expeditingForm->expediting_contact }}</div>
        <div class="mb-2"><span class="font-semibold">Submitted At:</span> {{ $expeditingForm->created_at->format('d.m.Y') }}</div>
        <!-- Add more fields as needed -->
    </div>
    <div class="mt-8">
        <div class="text-gray-700">If you have questions, please contact your expeditor.</div>
    </div>
</div>
@endsection
