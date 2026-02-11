<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Expediting Form') }}
        </h2>
    </x-slot>

    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        .locked-field {
            background-color: #e6eef4 !important;
            position: relative;
        }
        .locked-icon {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #01426a;
            pointer-events: none;
            font-size: 1rem;
        }
        .locked-wrapper {
            position: relative;
        }
        /* Match select2 to Tailwind input styles */
        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            min-height: 2.25rem;
            padding: 0.25rem 0.75rem;
            font-size: 0.875rem;
            font-family: inherit;
            box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .select2-container--default .select2-selection--single:focus,
        .select2-container--default .select2-selection--single.select2-selection--focus {
            border-color: #6366f1;
            outline: none;
            box-shadow: 0 0 0 2px #c7d2fe;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #374151;
            line-height: 2.25rem;
            padding-left: 0;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 2.25rem;
            right: 0.75rem;
        }
    </style>
    @endpush

    <div class="w-full px-2 md:px-8 mt-6 font-sans">
        <div class="bg-gradient-to-br from-[#e6eef4] to-white p-4 md:p-8 rounded-2xl shadow-2xl w-full border border-[#01426a22]">
            <form method="POST" action="{{ route('expediting_forms.store') }}" class="space-y-8 w-full">
                @csrf
                <div class="mb-6">
                    <h3 class="text-lg md:text-2xl font-bold text-[#01426a] mb-2 tracking-wide">Context Information</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 w-full">
    <div>
        <label for="work_package" class="block text-sm font-medium text-gray-700">Work package</label>
        <input type="text" name="work_package" id="work_package" value="{{ old('work_package') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none text-sm font-sans" required>
        @error('work_package')
            <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <label for="lli" class="block text-sm font-medium text-gray-700">LLI?</label>
        <div class="locked-wrapper">
            <select name="lli" id="lli" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none text-sm font-sans">
                <option value="">Select</option>
                <option value="1" @if(old('lli')==='1') selected @endif>Yes</option>
                <option value="0" @if(old('lli')==='0') selected @endif>No</option>
            </select>
        </div>
        @error('lli')
            <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <label for="expediting_category" class="block text-sm font-medium text-gray-700">Expediting category</label>
        <div class="locked-wrapper">
            <select name="expediting_category" id="expediting_category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none text-sm font-sans" required>
                <option value="">Select</option>
                <option value="Low" @if(old('expediting_category')==='Low') selected @endif>Low</option>
                <option value="Middle" @if(old('expediting_category')==='Middle') selected @endif>Middle</option>
                <option value="High" @if(old('expediting_category')==='High') selected @endif>High</option>
            </select>
        </div>
        @error('expediting_category')
            <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <label for="workpackage_name" class="block text-sm font-medium text-gray-700">Workpackage name</label>
        <input type="text" name="workpackage_name" id="workpackage_name" value="{{ old('workpackage_name') }}" list="workpackage_name_list" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none text-sm font-sans" required>
        <datalist id="workpackage_name_list">
            @foreach($workpackageNames as $name)
                @if($name)
                    <option value="{{ $name }}">
                @endif
            @endforeach
        </datalist>
        @error('workpackage_name')
            <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <label for="supplier-select" class="block text-sm font-medium text-gray-700">Supplier</label>
        <select id="supplier-select" name="supplier" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none text-sm font-sans" required>
            <option value="">Select</option>
            @if(isset($suppliers) && count($suppliers))
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->name }}" @if(old('supplier')===$supplier->name) selected @endif>{{ $supplier->name }} ({{ $supplier->email }})</option>
                @endforeach
            @endif
        </select>
        @error('supplier')
            <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <label for="order_date" class="block text-sm font-medium text-gray-700">Order Date</label>
        <div class="locked-wrapper">
            <input type="date" name="order_date" id="order_date" value="{{ old('order_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none text-sm font-sans">
        </div>
        @error('order_date')
            <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <label for="contract_data_available_dmcs" class="block text-sm font-medium text-gray-700">Contract Data Available (DMCS)</label>
        <div class="locked-wrapper">
            <select name="contract_data_available_dmcs" id="contract_data_available_dmcs" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none text-sm font-sans">
                <option value="">Select</option>
                <option value="1" @if(old('contract_data_available_dmcs')==='1') selected @endif>Yes</option>
                <option value="0" @if(old('contract_data_available_dmcs')==='0') selected @endif>No</option>
            </select>
        </div>
        @error('contract_data_available_dmcs')
            <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <label for="po_number" class="block text-sm font-medium text-gray-700">PO Number</label>
        <input type="text" name="po_number" id="po_number" value="{{ old('po_number') }}" list="po_number_list" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none text-sm font-sans">
        <datalist id="po_number_list">
            @foreach($poNumbers as $po)
                @if($po)
                    <option value="{{ $po }}">
                @endif
            @endforeach
        </datalist>
        @error('po_number')
            <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <label for="incoterms" class="block text-sm font-medium text-gray-700">Incoterms</label>
        <div class="locked-wrapper">
            <select name="incoterms" id="incoterms" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none text-sm font-sans">
                <option value="">Select</option>
                <option value="DAP" @if(old('incoterms')==='DAP') selected @endif>DAP</option>
                <option value="Not Available" @if(old('incoterms')==='Not Available') selected @endif>Not Available</option>
            </select>
        </div>
        @error('incoterms')
            <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <label for="exyte_procurement_contract_manager" class="block text-sm font-medium text-gray-700">Exyte Procurement Contract Manager</label>
        <div class="locked-wrapper">
            <select name="exyte_procurement_contract_manager" id="exyte_procurement_contract_manager" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none text-sm font-sans">
                <option value="">Select</option>
                @if(isset($expeditors) && count($expeditors))
                    @foreach($expeditors as $expeditor)
                        <option value="{{ $expeditor->name }}" @if(old('exyte_procurement_contract_manager')===$expeditor->name) selected @endif>{{ $expeditor->name }} ({{ $expeditor->email }})</option>
                    @endforeach
                @endif
            </select>
        </div>
        @error('exyte_procurement_contract_manager')
            <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <label for="customer_procurement_contact" class="block text-sm font-medium text-gray-700">Customer Procurement Contact</label>
        <input type="text" name="customer_procurement_contact" id="customer_procurement_contact" value="{{ old('customer_procurement_contact') }}" list="customer_procurement_contact_list" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none text-sm font-sans">
        <datalist id="customer_procurement_contact_list">
            @foreach($customerContacts as $contact)
                @if($contact)
                    <option value="{{ $contact }}">
                @endif
            @endforeach
        </datalist>
        @error('customer_procurement_contact')
            <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <label for="kickoff_status" class="block text-sm font-medium text-gray-700">Kick-off Status</label>
        <div class="locked-wrapper">
            <select name="kickoff_status" id="kickoff_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none text-sm font-sans">
                <option value="">Select</option>
                <option value="Yes" @if(old('kickoff_status')==='Yes') selected @endif>Yes</option>
                <option value="No" @if(old('kickoff_status')==='No') selected @endif>No</option>
                <option value="Other" @if(old('kickoff_status')==='Other') selected @endif>Other</option>
            </select>
        </div>
        @error('kickoff_status')
            <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <label for="technical_workpackage_owner" class="block text-sm font-medium text-gray-700">Technical Workpackage Owner</label>
        <input type="text" name="technical_workpackage_owner" id="technical_workpackage_owner" value="{{ old('technical_workpackage_owner') }}" list="technical_workpackage_owner_list" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none text-sm font-sans">
        <datalist id="technical_workpackage_owner_list">
            @foreach($technicalOwners as $owner)
                @if($owner)
                    <option value="{{ $owner }}">
                @endif
            @endforeach
        </datalist>
        @error('technical_workpackage_owner')
            <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
        @enderror
    </div>
</div>
                </div>
                <div class="mb-6">
                    <h3 class="text-lg md:text-2xl font-bold text-[#01426a] mb-2 tracking-wide">Execution Lines</h3>
                    <div class="overflow-x-auto rounded-xl border border-[#01426a22] bg-white shadow">
                        <table class="min-w-full w-full border text-xs md:text-sm bg-white rounded-xl overflow-hidden" id="execution-table">
                            <thead>
                                <tr class="bg-gradient-to-r from-[#e6eef4] to-[#b3c9db] text-[#01426a]">
                                    <th class="border px-3 py-2 font-semibold">Work Package</th>
                                    <th class="border px-3 py-2 font-semibold">Workstream/Building</th>
                                    <th class="border px-3 py-2 font-semibold">Expediting Contact</th>
                                    <th class="border px-3 py-2 font-semibold">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="hover:bg-[#e6eef4] transition">
                                    <td class="border px-3 py-2"><input type="text" name="executions[0][work_package]" class="w-full rounded border-[#01426a55] py-1 px-2 text-xs md:text-sm focus:ring-2 focus:ring-[#01426a33] focus:border-[#01426a] transition" required></td>
                                    <td class="border px-3 py-2"><input type="text" name="executions[0][workstream_building]" class="w-full rounded border-[#01426a55] py-1 px-2 text-xs md:text-sm focus:ring-2 focus:ring-[#01426a33] focus:border-[#01426a] transition" required></td>
                                    <td class="border px-3 py-2"><input type="text" name="executions[0][expediting_contact]" class="w-full rounded border-[#01426a55] py-1 px-2 text-xs md:text-sm focus:ring-2 focus:ring-[#01426a33] focus:border-[#01426a] transition" required></td>
                                    <td class="border px-3 py-2 text-center">
                                        <button type="button" class="remove-row bg-[#fbe9e7] hover:bg-[#ff5252] hover:text-white text-[#d32f2f] font-bold text-2xl rounded-full w-10 h-10 flex items-center justify-center shadow transition focus:outline-none focus:ring-2 focus:ring-[#01426a33]" title="Remove">
                                            <span class="material-icons">delete</span>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" id="add-row" class="mt-4 ml-2 px-5 py-2 bg-gradient-to-r from-[#01426a] to-[#357ab7] text-white rounded-lg shadow hover:from-[#01426a] hover:to-[#012a40] transition font-semibold text-sm flex items-center gap-2"><span class="material-icons align-middle">add</span>Add Row</button>
                    </div>
                </div>
                <div class="mt-8 text-right w-full">
                    <button type="submit" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-[#01426a] to-[#357ab7] border border-transparent rounded-xl font-bold text-sm md:text-base text-white uppercase tracking-widest shadow hover:from-[#01426a] hover:to-[#012a40] focus:outline-none focus:ring-2 focus:ring-[#01426a33] active:bg-[#012a40] transition gap-2"><span class="material-icons align-middle">save</span>Save</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(function () {
            $('#supplier-select').select2({
                width: '100%',
                placeholder: 'Select supplier',
                allowClear: true
            });

            // Helper: reusable field IDs
            const reusableFields = [
                'lli',
                'expediting_category',
                'order_date',
                'contract_data_available_dmcs',
                'incoterms',
                'exyte_procurement_contract_manager',
                'customer_procurement_contact',
                'kickoff_status',
                'technical_workpackage_owner'
            ];

            // Helper: context fields
            function getContextValues() {
                return {
                    supplier: $('#supplier-select').val(),
                    workpackage_name: $('#workpackage_name').val(),
                    po_number: $('#po_number').val()
                };
            }

            function setReusableFields(data, lock) {
                reusableFields.forEach(function (field) {
                    const $el = $('#' + field);
                    if (data[field] !== undefined) {
                        $el.val(data[field]);
                    }
                    $el.prop('readonly', lock);
                    if (lock) {
                        $el.addClass('locked-field');
                    } else {
                        $el.removeClass('locked-field');
                    }
                });
            }

            function clearExecutionFields() {
                $('#execution-table tbody tr:gt(0)').remove();
                $('#execution-table tbody tr:first input').val('');
            }

            // --- Execution Lines Add/Remove Row ---
            let rowIdx = $('#execution-table tbody tr').length;
            $('#add-row').on('click', function() {
                const row = `<tr class="hover:bg-[#e6eef4] transition">
                    <td class="border px-3 py-2"><input type="text" name="executions[${rowIdx}][work_package]" class="w-full rounded border-[#01426a55] py-1 px-2 text-xs md:text-sm focus:ring-2 focus:ring-[#01426a33] focus:border-[#01426a] transition" required></td>
                    <td class="border px-3 py-2"><input type="text" name="executions[${rowIdx}][workstream_building]" class="w-full rounded border-[#01426a55] py-1 px-2 text-xs md:text-sm focus:ring-2 focus:ring-[#01426a33] focus:border-[#01426a] transition" required></td>
                    <td class="border px-3 py-2"><input type="text" name="executions[${rowIdx}][expediting_contact]" class="w-full rounded border-[#01426a55] py-1 px-2 text-xs md:text-sm focus:ring-2 focus:ring-[#01426a33] focus:border-[#01426a] transition" required></td>
                    <td class="border px-3 py-2 text-center">
                        <button type="button" class="remove-row bg-[#fbe9e7] hover:bg-[#ff5252] hover:text-white text-[#d32f2f] font-bold text-2xl rounded-full w-10 h-10 flex items-center justify-center shadow transition focus:outline-none focus:ring-2 focus:ring-[#01426a33]" title="Remove">
                            <span class="material-icons">delete</span>
                        </button>
                    </td>
                </tr>`;
                $('#execution-table tbody').append(row);
                rowIdx++;
            });
            $('#execution-table tbody').on('click', '.remove-row', function() {
                if ($('#execution-table tbody tr').length > 1) {
                    $(this).closest('tr').remove();
                }
            });
            // --- End Execution Lines Add/Remove Row ---

            // Context check logic
            function checkContext() {
                const ctx = getContextValues();
                const reuseMsg = $('#reuse-msg');
                if (ctx.supplier && ctx.workpackage_name && ctx.po_number) {
                    $.post({
                        url: "{{ route('expediting_forms.context_check') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            supplier: ctx.supplier,
                            workpackage_name: ctx.workpackage_name,
                            po_number: ctx.po_number
                        },
                        success: function (res) {
                            if (res.exists) {
                                setReusableFields(res.data, true);
                                reuseMsg.text('Existing expediting data reused').show();
                                $('#edit-context-toggle').show();
                            } else {
                                setReusableFields({}, false);
                                reuseMsg.hide();
                                $('#edit-context-toggle').hide();
                                $('#edit-context-checkbox').prop('checked', false);
                            }
                        }
                    });
                } else {
                    setReusableFields({}, false);
                    reuseMsg.hide();
                    $('#edit-context-toggle').hide();
                    $('#edit-context-checkbox').prop('checked', false);
                }
            }

            // Toggle context field lock/unlock on checkbox change
            $('#edit-context-checkbox').on('change', function () {
                // Re-apply lock state based on checkbox
                const ctx = getContextValues();
                $.post({
                    url: "{{ route('expediting_forms.context_check') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        supplier: ctx.supplier,
                        workpackage_name: ctx.workpackage_name,
                        po_number: ctx.po_number
                    },
                    success: function (res) {
                        if (res.exists) {
                            setReusableFields(res.data, true);
                        }
                    }
                });
            });

            $('#supplier-select, #workpackage_name, #po_number').on('change input', checkContext);

            // After submit, clear only execution fields
            $('form').on('submit', function (e) {
                setTimeout(function () {
                    clearExecutionFields();
                }, 500);
            });
        });
    </script>
    @endpush
</x-app-layout>
