<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Expediting List') }}
        </h2>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <h3 class="text-lg font-bold text-gray-700">Submitted Expediting Forms</h3>
                </div>
                <div class="overflow-x-auto rounded-xl border border-[#01426a22] bg-white shadow">
                    <table class="min-w-full w-full border text-xs md:text-sm bg-white rounded-xl overflow-hidden">
                        <thead>
                            <tr class="bg-gradient-to-r from-[#e6eef4] to-[#b3c9db] text-[#01426a]">
                                <th class="border px-3 py-2 font-semibold">Work package</th>
                                <th class="border px-3 py-2 font-semibold">LLI?</th>
                                <th class="border px-3 py-2 font-semibold">Expediting category</th>
                                <th class="border px-3 py-2 font-semibold">Workpackage name</th>
                                <th class="border px-3 py-2 font-semibold">Supplier</th>
                                <th class="border px-3 py-2 font-semibold">Order Date</th>
                                <th class="border px-3 py-2 font-semibold">Contract Data Available (DMCS)</th>
                                <th class="border px-3 py-2 font-semibold">PO Number</th>
                                <th class="border px-3 py-2 font-semibold">Incoterms</th>
                                <th class="border px-3 py-2 font-semibold">Exyte Procurement Contract Manager</th>
                                <th class="border px-3 py-2 font-semibold">Customer Procurement Contact</th>
                                <th class="border px-3 py-2 font-semibold">Kick-off Status</th>
                                <th class="border px-3 py-2 font-semibold">Technical Workpackage Owner</th>
                                <th class="border px-3 py-2 font-semibold">Workstream/Building</th>
                                <th class="border px-3 py-2 font-semibold">Expediting Contact</th>
                                <th class="border px-3 py-2 font-semibold">Submitted At</th>
                                <th class="border px-3 py-2 font-semibold">Action</th>
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
                                    <td class="border px-3 py-2 text-center">
                                        <a href="{{ route('expediting_forms.edit', $form->id) }}" class="inline-block mx-1 text-blue-600 hover:text-blue-900" title="Edit">
                                            <span class="material-icons" style="font-size:18px;vertical-align:middle;">edit</span>
                                        </a>
                                        <form action="#" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-block mx-1 text-red-600 hover:text-red-900" title="Delete" style="background:none;border:none;padding:0;">
                                                <span class="material-icons" style="font-size:18px;vertical-align:middle;">delete</span>
                                            </button>
                                        </form>
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
