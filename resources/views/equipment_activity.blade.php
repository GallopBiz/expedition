@extends('layouts.app')
@section('content')
<div class="container mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6 text-[#01426a]">Equipment Activity</h2>
    <div class="bg-white shadow rounded-lg p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg text-xs">
                <thead>
                    <tr class="bg-gray-100 text-[#01426a]">
                        <th class="py-2 px-4 border-b text-center">User</th>
                        <th class="py-2 px-4 border-b text-center">Equipment</th>
                        <th class="py-2 px-4 border-b text-center">Field Changed</th>
                        <th class="py-2 px-4 border-b text-center">Old Value</th>
                        <th class="py-2 px-4 border-b text-center">New Value</th>
                        <th class="py-2 px-4 border-b text-center">Changed At</th>
                        <th class="py-2 px-4 border-b text-center">IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activities as $activity)
                        <tr>
                            <td class="py-2 px-4 border-b text-center">{{ $activity->changed_by }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $activity->equipment->name ?? '-' }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $activity->field_changed }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $activity->old_value }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $activity->new_value }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $activity->changed_at }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $activity->ip_address ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4 flex justify-center">
                {{ $activities->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
