@extends('layouts.app')

@section('content')
<main>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <h3 class="text-lg font-bold mb-4 text-[#01426a]">Work Package List</h3>
          @if($forms->count())
            <div class="overflow-x-auto">
              <table class="min-w-full border">
                <thead>
                  <tr>
                    <th class="px-3 py-2 border">Work Package</th>
                    <th class="px-3 py-2 border">Work Package Name</th>
                    <th class="px-3 py-2 border">PO Number</th>
                    <th class="px-3 py-2 border">Delivered</th>
                    <th class="px-3 py-2 border">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($forms as $form)
                    <tr>
                      <td class="px-3 py-2 border">{{ $form->work_package }}</td>
                      <td class="px-3 py-2 border">{{ $form->workpackage_name }}</td>
                      <td class="px-3 py-2 border">{{ $form->po_number }}</td>
                      <td class="px-3 py-2 border">{{ $form->delivered }}</td>
                      <td class="px-3 py-2 border text-center">
                        <a href="{{ route('supplier.expedition_v2', ['context_id' => $form->context_id ?? $form->id, 'edit' => 1]) }}" class="text-blue-700 underline" target="_blank">View</a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <div class="text-gray-500">No work packages found.</div>
          @endif
        </div>
      </div>
    </div>
  </div>
</main>
@endsection
