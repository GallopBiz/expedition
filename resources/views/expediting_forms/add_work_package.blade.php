@extends('layouts.app')
@section('content')
<div class="container mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6">Add Work Package</h2>
    <div class="bg-white rounded shadow p-6">
        <form method="POST" action="#">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" for="work_package">Work Package</label>
                <input class="w-full border border-gray-300 rounded px-3 py-2" type="text" id="work_package" name="work_package" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" for="workpackage_name">Work Package Name</label>
                <input class="w-full border border-gray-300 rounded px-3 py-2" type="text" id="workpackage_name" name="workpackage_name" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" for="supplier">Supplier</label>
                <input class="w-full border border-gray-300 rounded px-3 py-2" type="text" id="supplier" name="supplier">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add</button>
        </form>
    </div>
</div>
@endsection
