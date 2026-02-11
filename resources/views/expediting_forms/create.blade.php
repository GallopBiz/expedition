<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Expediting Form') }}
        </h2>
    </x-slot>

    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush

    <div class="max-w-4xl mx-auto mt-10">
        <div class="bg-white p-6 rounded-lg shadow-md">
            @if(session('success'))
                <div class="mb-4 text-green-600">{{ session('success') }}</div>
            @endif
            <form method="POST" action="{{ route('expediting_forms.store') }}" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="work_package" class="block text-sm font-medium text-gray-700">Work package</label>
                        <input type="text" name="work_package" id="work_package" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm font-sans" required>
                    </div>
                    <div>
                        <label for="lli" class="block text-sm font-medium text-gray-700">LLI?</label>
                        <select name="lli" id="lli" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm font-sans">
                            <option value="">Select</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div>
                        <label for="expediting_category" class="block text-sm font-medium text-gray-700">Expediting category</label>
                        <select name="expediting_category" id="expediting_category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm font-sans" required>
                            <option value="">Select</option>
                            <option value="Low">Low</option>
                            <option value="Middle">Middle</option>
                            <option value="High">High</option>
                        </select>
                    </div>
                    <div>
                        <label for="workpackage_name" class="block text-sm font-medium text-gray-700">Workpackage name</label>
                        <input type="text" name="workpackage_name" id="workpackage_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm font-sans" required>
                    </div>
                    <div>
                        <label for="supplier-select" class="block text-sm font-medium text-gray-700">Supplier</label>
                        <select id="supplier-select" name="supplier" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm font-sans" required>
                            <option value="">Select</option>
                            @if(isset($suppliers) && count($suppliers))
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->name }}">{{ $supplier->name }} ({{ $supplier->email }})</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div>
                        <label for="order_date" class="block text-sm font-medium text-gray-700">Order Date</label>
                        <input type="date" name="order_date" id="order_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm font-sans">
                    </div>
                    <div>
                        <label for="contract_data_available_dmcs" class="block text-sm font-medium text-gray-700">Contract Data Available (DMCS)</label>
                        <select name="contract_data_available_dmcs" id="contract_data_available_dmcs" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm font-sans">
                            <option value="">Select</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div>
                        <label for="po_number" class="block text-sm font-medium text-gray-700">PO Number</label>
                        <input type="text" name="po_number" id="po_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm font-sans">
                    </div>
                    <div>
                        <label for="incoterms" class="block text-sm font-medium text-gray-700">Incoterms</label>
                        <input type="text" name="incoterms" id="incoterms" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm font-sans">
                    </div>
                    <div>
                        <label for="exyte_procurement_contract_manager" class="block text-sm font-medium text-gray-700">Exyte Procurement Contract Manager</label>
                        <input type="text" name="exyte_procurement_contract_manager" id="exyte_procurement_contract_manager" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm font-sans">
                    </div>
                    <div>
                        <label for="customer_procurement_contact" class="block text-sm font-medium text-gray-700">Customer Procurement Contact</label>
                        <input type="text" name="customer_procurement_contact" id="customer_procurement_contact" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm font-sans">
                    </div>
                    <div>
                        <label for="kickoff_status" class="block text-sm font-medium text-gray-700">Kick-off Status</label>
                        <input type="text" name="kickoff_status" id="kickoff_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm font-sans">
                    </div>
                    <div>
                        <label for="technical_workpackage_owner" class="block text-sm font-medium text-gray-700">Technical Workpackage Owner</label>
                        <input type="text" name="technical_workpackage_owner" id="technical_workpackage_owner" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm font-sans">
                    </div>
                    <div>
                        <label for="workstream_building" class="block text-sm font-medium text-gray-700">Workstream/Building</label>
                        <input type="text" name="workstream_building" id="workstream_building" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm font-sans">
                    </div>
                    <div>
                        <label for="expediting_contact" class="block text-sm font-medium text-gray-700">Expediting Contact</label>
                        <input type="text" name="expediting_contact" id="expediting_contact" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm font-sans">
                    </div>
                </div>
                <div class="mt-6 text-right">
                    <button type="submit" class="btn">Save</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.jQuery) {
                $('#supplier-select').select2({
                    width: '100%',
                    placeholder: 'Select supplier',
                    allowClear: true
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
