    @if(session('success'))
        <div id="emailSuccessAlert" class="fixed top-6 left-1/2 transform -translate-x-1/2 bg-green-100 border border-green-400 text-green-800 px-6 py-3 rounded-lg shadow-lg z-50 flex items-center gap-2 animate-fade-in">
            <span class="material-icons text-green-600">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
        <script>
            setTimeout(function() {
                var alert = document.getElementById('emailSuccessAlert');
                if(alert) alert.style.display = 'none';
            }, 3500);
        </script>
    @endif
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Work Package List') }}
        </h2>
    </x-slot>
    
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex items-center">
    <a href="{{ url('/expediting-forms/create') }}" class="inline-flex items-center px-2 py-1 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-full shadow transition text-xs font-semibold">
      <svg xmlns='http://www.w3.org/2000/svg' class='h-4 w-4 mr-1' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 19l-7-7 7-7' /></svg>
      Back
    </a>
  </div>
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <h3 class="text-lg font-bold text-gray-700">Submitted Expediting Forms</h3>
                </div>
                <form method="GET" class="mb-4 flex flex-wrap gap-2 items-end justify-start">
                    <div class="flex flex-col min-w-[140px]">
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Expediting Category</label>
                        <select class="border rounded px-2 py-1 text-xs" name="filter_category">
                            <option value="">All</option>
                            <option value="Low" {{ request('filter_category')=='Low' ? 'selected' : '' }}>Low</option>
                            <option value="Middle" {{ request('filter_category')=='Middle' ? 'selected' : '' }}>Middle</option>
                            <option value="High" {{ request('filter_category')=='High' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>
                    <div class="flex flex-col min-w-[220px]">
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Supplier</label>
                        <select class="border rounded px-2 py-1 text-xs supplier-select" name="filter_supplier">
                            <option value="">All</option>
                            @if(isset($supplierList))
                                @foreach($supplierList as $supplier)
                                    <option value="{{ $supplier }}" {{ request('filter_supplier') == $supplier ? 'selected' : '' }}>{{ $supplier }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="flex flex-col min-w-[120px]">
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Order Date (From)</label>
                        <input type="date" class="border rounded px-2 py-1 text-xs" name="filter_order_date_from" value="{{ request('filter_order_date_from') }}">
                    </div>
                    <div class="flex flex-col min-w-[120px]">
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Order Date (To)</label>
                        <input type="date" class="border rounded px-2 py-1 text-xs" name="filter_order_date_to" value="{{ request('filter_order_date_to') }}">
                    </div>
                    <div class="flex flex-col min-w-[120px]">
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Workpackage Name</label>
                        <input type="text" class="border rounded px-2 py-1 text-xs" name="search_workpackage_name" placeholder="Workpackage Name" value="{{ request('search_workpackage_name') }}">
                    </div>
                    <div class="flex flex-col min-w-[120px]">
                        <label class="block text-xs font-semibold text-gray-700 mb-1">PO Number</label>
                        <input type="text" class="border rounded px-2 py-1 text-xs" name="search_po_number" placeholder="PO Number" value="{{ request('search_po_number') }}">
                    </div>
                    <div class="flex gap-2 mt-4">
                        <button type="submit" class="bg-[#01426a] text-white px-4 py-1 rounded text-xs font-semibold">Filter</button>
                        <a href="{{ route('expediting_forms.list') }}" class="bg-gray-300 text-gray-800 px-4 py-1 rounded text-xs font-semibold">Reset</a>
                    </div>
                </form>
                <div class="overflow-x-auto rounded-xl border border-[#01426a22] bg-white shadow">
                    <table class="min-w-full w-full border text-xs md:text-sm bg-white rounded-xl overflow-hidden">
                        <thead>
                            <tr class="bg-gradient-to-r from-[#e6eef4] to-[#b3c9db] text-[#01426a] text-xs">
                                <th class="border px-3 py-2 font-semibold text-xs">Work package</th>
                                <th class="border px-3 py-2 font-semibold text-xs">LLI?</th>
                                <th class="border px-3 py-2 font-semibold text-xs">Expediting category</th>
                                <th class="border px-3 py-2 font-semibold text-xs">Workpackage name</th>
                                <th class="border px-3 py-2 font-semibold text-xs">Supplier</th>
                                <th class="border px-3 py-2 font-semibold text-xs">Order Date</th>
                                <th class="border px-3 py-2 font-semibold text-xs">Contract Data Available (DMCS)</th>
                                <th class="border px-3 py-2 font-semibold text-xs">PO Number</th>
                                <th class="border px-3 py-2 font-semibold text-xs">Incoterms</th>
                                <th class="border px-3 py-2 font-semibold text-xs">Exyte Procurement Contract Manager</th>
                                <th class="border px-3 py-2 font-semibold text-xs">Customer Procurement Contact</th>
                                <th class="border px-3 py-2 font-semibold text-xs">Kick-off Status</th>
                                <th class="border px-3 py-2 font-semibold text-xs">Technical Workpackage Owner</th>
                                <th class="border px-3 py-2 font-semibold text-xs">Workstream/Building</th>
                                <th class="border px-3 py-2 font-semibold text-xs">Expediting Contact</th>
                                <th class="border px-3 py-2 font-semibold text-xs">Submitted At</th>
                                <th class="border px-3 py-2 font-semibold text-xs">Forecast Delivery to Site<br><span class=\"text-xs\">Time schedule date (site need date)</span></th>
                                <th class="border px-3 py-2 font-semibold text-xs">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expeditingForms as $form)
                                @php
                                    $cat = optional($form->context)->expediting_category ?? $form->expediting_category;
                                    $catColor = $cat === 'Middle' ? 'bg-yellow-200' : ($cat === 'High' ? 'bg-red-200' : ($cat === 'Low' ? 'bg-green-200' : ''));
                                    $supplier = optional($form->context)->supplier ?? $form->supplier;
                                    $supplierColor = $supplier === 'Acc' ? 'bg-green-200' : ($supplier === 'Alta' ? 'bg-green-400' : '');
                                @endphp
                                <tr class="hover:bg-[#e6eef4] transition">
                                    <td class="border px-3 py-2">{{ $form->work_package }}</td>
                                    <td class="border px-3 py-2">{{ optional($form->context)->lli ?? '' }}</td>
                                    <td class="border px-3 py-2 {{ $catColor }}">{{ $cat }}</td>
                                    <td class="border px-3 py-2">{{ optional($form->context)->workpackage_name ?? $form->workpackage_name }}</td>
                                    <td class="border px-3 py-2 {{ $supplierColor }}">{{ $supplier }}</td>
                                    <td class="border px-3 py-2">{{ optional($form->context)->order_date ?? '' }}</td>
                                    <td class="border px-3 py-2">{{ optional($form->context)->contract_data_available_dmcs ?? '' }}</td>
                                    <td class="border px-3 py-2">{{ optional($form->context)->po_number ?? $form->po_number }}</td>
                                    <td class="border px-3 py-2">{{ optional($form->context)->incoterms ?? '' }}</td>
                                    <td class="border px-3 py-2">{{ optional($form->context)->exyte_procurement_contract_manager ?? '' }}</td>
                                    <td class="border px-3 py-2">{{ optional($form->context)->customer_procurement_contact ?? '' }}</td>
                                    <td class="border px-3 py-2">{{ optional($form->context)->kickoff_status ?? '' }}</td>
                                    <td class="border px-3 py-2">{{ optional($form->context)->technical_workpackage_owner ?? '' }}</td>
                                    <td class="border px-3 py-2">{{ $form->workstream_building }}</td>
                                    <td class="border px-3 py-2">{{ $form->expediting_contact }}</td>
                                    <td class="border px-3 py-2">{{ $form->created_at->format('d.m.Y') }}</td>
                                    <td class="border px-3 py-2 whitespace-nowrap">
                                        <span>{{ $form->forecast_delivery_to_site ? \Carbon\Carbon::parse($form->forecast_delivery_to_site)->format('d-m-Y') : '' }}</span>
                                        @php
                                            $forecastHistories = $form->forecastDeliveryHistories()->orderByDesc('changed_at')->get();
                                        @endphp
                                        @if($forecastHistories->count())
                                            <button type="button" onclick="showForecastHistory{{ $form->id }}()" class="ml-1 align-middle text-[#01426a] hover:text-[#357ab7]" title="View Change History">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="inline h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                            <div id="forecastHistoryModal{{ $form->id }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
                                                <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-2xl relative flex flex-col items-center justify-center text-center">
                                                    <button type="button" onclick="closeForecastHistory{{ $form->id }}()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700">
                                                        <span class="material-icons">close</span>
                                                    </button>
                                                    <h3 class="text-base font-bold text-[#01426a] mb-1">Forecast Delivery to Site Change History</h3>
                                                    <div class="mb-3 text-sm text-gray-700">Supplier: <span class="font-semibold">{{ optional($form->context)->supplier ?? $form->supplier }}</span></div>
                                                    <table class="min-w-full text-xs border border-gray-200 bg-white">
                                                        <thead class="bg-[#f8fafc] text-[#01426a]">
                                                            <tr>
                                                                <th class="px-1 py-1 border border-gray-200">Previous Date</th>
                                                                <th class="px-1 py-1 border border-gray-200">Latest Date</th>
                                                                <th class="px-1 py-1 border border-gray-200">Changed By</th>
                                                                <th class="px-1 py-1 border border-gray-200">Changed At</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($forecastHistories as $history)
                                                                <tr>
                                                                    <td class="px-1 py-1 border border-gray-200 whitespace-nowrap">{{ $history->old_value ? \Carbon\Carbon::parse($history->old_value)->format('d-m-Y') : '' }}</td>
                                                                    <td class="px-1 py-1 border border-gray-200 whitespace-nowrap">{{ $history->new_value ? \Carbon\Carbon::parse($history->new_value)->format('d-m-Y') : '' }}</td>
                                                                    <td class="px-1 py-1 border border-gray-200">{{ $history->changed_by }}</td>
                                                                    <td class="px-1 py-1 border border-gray-200">{{ $history->changed_at }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <script>
                                                function showForecastHistory{{ $form->id }}() {
                                                    document.getElementById('forecastHistoryModal{{ $form->id }}').classList.remove('hidden');
                                                }
                                                function closeForecastHistory{{ $form->id }}() {
                                                    document.getElementById('forecastHistoryModal{{ $form->id }}').classList.add('hidden');
                                                }
                                            </script>
                                        @endif
                                    </td>
                                    <td class="border px-3 py-2 text-center">
                                        <a href="{{ route('expediting_forms.edit', $form->id) }}" class="inline-block mx-1 text-blue-600 hover:text-blue-900" title="Edit">
                                            <span class="material-icons" style="font-size:18px;vertical-align:middle;">edit</span>
                                        </a>
                                        <form action="{{ route('expediting_forms.destroy', $form->id) }}" method="POST" class="inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="inline-block mx-1 text-red-600 hover:text-red-900 delete-btn" title="Delete" style="background:none;border:none;padding:0;">
                                                <span class="material-icons" style="font-size:18px;vertical-align:middle;">delete</span>
                                            </button>
                                        </form>
                                                                            <!-- Delete Confirmation Modal -->
                                                                            <div id="deleteConfirmModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
                                                                                <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-sm text-center border-t-8 border-red-600 relative animate-fade-in">
                                                                                    <div class="flex flex-col items-center mb-4">
                                                                                        <div id="deleteConfirmText" class="text-red-900 font-bold text-lg mb-1">Delete Work Package?</div>
                                                                                        <div class="text-gray-600 text-base mb-4">Are you sure you want to delete this work package? This action cannot be undone.</div>
                                                                                    </div>
                                                                                    <div class="flex justify-center gap-4 mt-2">
                                                                                        <button id="deleteConfirmYes" class="px-6 py-2 rounded-lg bg-gradient-to-r from-red-500 to-red-700 text-white font-semibold shadow hover:from-red-600 hover:to-red-800 transition">Yes, Delete</button>
                                                                                        <button id="deleteConfirmNo" class="px-6 py-2 rounded-lg bg-gray-200 text-gray-800 font-semibold shadow hover:bg-gray-300 transition">Cancel</button>
                                                                                    </div>
                                                                                    <button id="deleteConfirmClose" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-2xl leading-none">&times;</button>
                                                                                </div>
                                                                            </div>
                                        <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            // Email modal (existing)
                                            let emailModal = document.getElementById('emailConfirmModal');
                                            let emailConfirmText = document.getElementById('emailConfirmText');
                                            let emailYesBtn = document.getElementById('emailConfirmYes');
                                            let emailNoBtn = document.getElementById('emailConfirmNo');
                                            let emailFormToSubmit = null;
                                            document.querySelectorAll('.email-btn').forEach(function(btn) {
                                                btn.addEventListener('click', function(e) {
                                                    e.preventDefault();
                                                    emailFormToSubmit = btn.closest('form');
                                                    let supplierName = emailFormToSubmit.querySelector('.supplier-name').value;
                                                    emailConfirmText.innerHTML = '<span class="text-green-700">Send email to <b>' + supplierName + '</b>?</span>';
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

                                            // Delete modal (new)
                                            let deleteModal = document.getElementById('deleteConfirmModal');
                                            let deleteYesBtn = document.getElementById('deleteConfirmYes');
                                            let deleteNoBtn = document.getElementById('deleteConfirmNo');
                                            let deleteFormToSubmit = null;
                                            document.querySelectorAll('.delete-btn').forEach(function(btn) {
                                                btn.addEventListener('click', function(e) {
                                                    e.preventDefault();
                                                    deleteFormToSubmit = btn.closest('form');
                                                    deleteModal.classList.remove('hidden');
                                                });
                                            });
                                            function closeDeleteModal() {
                                                deleteModal.classList.add('hidden');
                                                deleteFormToSubmit = null;
                                            }
                                            deleteYesBtn.addEventListener('click', function() {
                                                if (deleteFormToSubmit) deleteFormToSubmit.submit();
                                                closeDeleteModal();
                                            });
                                            deleteNoBtn.addEventListener('click', closeDeleteModal);
                                            document.getElementById('deleteConfirmClose').addEventListener('click', closeDeleteModal);
                                            window.addEventListener('keydown', function(e) {
                                                if (!deleteModal.classList.contains('hidden') && (e.key === 'Escape' || e.keyCode === 27)) {
                                                    closeDeleteModal();
                                                }
                                            });
                                        });
                                        </script>
                                        <form action="{{ route('expediting_forms.send_email', $form->id) }}" method="POST" class="inline email-form">
                                            @csrf
                                            <button type="button" class="inline-block mx-1 text-green-600 hover:text-green-900 email-btn" title="Email to Supplier" style="background:none;border:none;padding:0;">
                                                <span class="material-icons" style="font-size:18px;vertical-align:middle;">email</span>
                                            </button>
                                            <input type="hidden" class="supplier-name" value="{{ $supplier }}">
                                        </form>
                                    </td>
                                </tr>

                                    <!-- Email Confirmation Modal -->
                                    <div id="emailConfirmModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
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
                                    <style>
                                    @keyframes fade-in {
                                      from { opacity: 0; transform: translateY(20px); }
                                      to { opacity: 1; transform: translateY(0); }
                                    }
                                    .animate-fade-in { animation: fade-in 0.3s ease; }
                                    </style>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            let modal = document.getElementById('emailConfirmModal');
                                            let confirmText = document.getElementById('emailConfirmText');
                                            let yesBtn = document.getElementById('emailConfirmYes');
                                            let noBtn = document.getElementById('emailConfirmNo');
                                            let formToSubmit = null;

                                            document.querySelectorAll('.email-btn').forEach(function(btn) {
                                                btn.addEventListener('click', function(e) {
                                                    e.preventDefault();
                                                    formToSubmit = btn.closest('form');
                                                    let supplierName = formToSubmit.querySelector('.supplier-name').value;
                                                    confirmText.innerHTML = '<span class="text-green-700">Send email to <b>' + supplierName + '</b>?</span>';
                                                    modal.classList.remove('hidden');
                                                });
                                            });

                                            function closeModal() {
                                                modal.classList.add('hidden');
                                                formToSubmit = null;
                                            }

                                            yesBtn.addEventListener('click', function() {
                                                if (formToSubmit) formToSubmit.submit();
                                                closeModal();
                                            });
                                            noBtn.addEventListener('click', closeModal);
                                            document.getElementById('emailConfirmClose').addEventListener('click', closeModal);
                                            window.addEventListener('keydown', function(e) {
                                                if (!modal.classList.contains('hidden') && (e.key === 'Escape' || e.keyCode === 27)) {
                                                    closeModal();
                                                }
                                            });
                                        });
                                    </script>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="16" class="text-center py-4 text-gray-500">No expediting forms submitted yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
