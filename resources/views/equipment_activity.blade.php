@extends('layouts.app')
@section('content')
<div class="container mx-auto py-8">
    <h2 class="text-2xl font-bold mb-2 text-[#01426a]">Equipment Activity</h2>
    <nav class="text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
        <ol class="list-reset flex">
            <li><a href="/dashboard" class="hover:underline text-[#01426a]">Dashboard</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-700">Equipment Activity</li>
        </ol>
    </nav>
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
