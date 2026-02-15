@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endpush
@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h2 class="text-xl font-bold text-gray-700">Expediting List</h2>
            </div>
            <form method="GET" class="mb-4 flex flex-wrap gap-2 items-end justify-start" id="expediting-filter-form">
                <div class="flex flex-col min-w-[140px]">
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Expediting Category</label>
                    <select class="border rounded px-2 py-1 text-xs" name="filter_category">
                        <option value="">All</option>
                        <option value="Low">Low</option>
                        <option value="Middle">Middle</option>
                        <option value="High">High</option>
                    </select>
                </div>
                <div class="flex flex-col min-w-[220px]">
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Supplier</label>
                    <select class="border rounded px-2 py-1 text-xs supplier-select" name="filter_supplier">
                        <option value="">All</option>
                        @foreach($supplierList as $supplier)
                            <option value="{{ $supplier }}" {{ request('filter_supplier') == $supplier ? 'selected' : '' }}>{{ $supplier }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-row gap-2">
                    <div class="flex flex-col min-w-[120px]">
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Order Date (From)</label>
                        <input type="date" class="border rounded px-2 py-1 text-xs" name="filter_order_date_from">
                    </div>
                    <div class="flex flex-col min-w-[120px]">
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Order Date (To)</label>
                        <input type="date" class="border rounded px-2 py-1 text-xs" name="filter_order_date_to">
                    </div>
                </div>
                <div class="flex flex-col min-w-[120px]">
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Delivered</label>
                    <select class="border rounded px-2 py-1 text-xs" name="filter_delivered">
                        <option value="" {{ request('filter_delivered') == '' ? 'selected' : '' }}>All</option>
                        <option value="Yes" {{ request('filter_delivered') == 'Yes' ? 'selected' : '' }}>Yes</option>
                        <option value="No" {{ request('filter_delivered') == 'No' ? 'selected' : '' }}>No</option>
                        <option value="Delay- FAT Issue" {{ request('filter_delivered') == 'Delay- FAT Issue' ? 'selected' : '' }}>Delay- FAT Issue</option>
                        <option value="Other" {{ request('filter_delivered') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="flex flex-col min-w-[120px]">
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Actual Delivery Supplier (From)</label>
                    <input type="date" class="border rounded px-2 py-1 text-xs" name="filter_actual_delivery_from">
                </div>
                <div class="flex flex-col min-w-[120px]">
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Actual Delivery Supplier (To)</label>
                    <input type="date" class="border rounded px-2 py-1 text-xs" name="filter_actual_delivery_to">
                </div>
                <div class="flex flex-col min-w-[120px]">
                    <label class="block text-xs font-semibold text-gray-700 mb-1">PO Number</label>
                    <input type="text" class="border rounded px-2 py-1 text-xs" name="search_po_number" placeholder="PO Number">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-[#01426a] text-white px-4 py-1 rounded text-xs font-semibold">Filter</button>
                    <button type="button" onclick="resetExpeditingFilters()" class="bg-gray-300 text-gray-800 px-4 py-1 rounded text-xs font-semibold">Reset</button>
                </div>
            </form>
            <script>
function resetExpeditingFilters() {
    const form = document.getElementById('expediting-filter-form');
    Array.from(form.elements).forEach(el => {
        if (el.tagName === 'SELECT' || el.tagName === 'INPUT') {
            if (el.type === 'checkbox' || el.type === 'radio') {
                el.checked = false;
            } else {
                el.value = '';
            }
        }
    });
    form.submit();
}
            </script>
            <div class="overflow-x-auto rounded-xl border border-[#01426a22] bg-white shadow">
                <table class="min-w-full w-full border text-xs md:text-sm bg-white rounded-xl overflow-hidden">
                    <thead>
                        <tr class="bg-gradient-to-r from-[#e6eef4] to-[#b3c9db] text-[#01426a] text-xs">
                            <th class="border px-3 py-2 font-semibold text-xs sticky left-0">Work package</th>
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
                            <th class="border px-3 py-2 font-semibold text-xs">Workstream /Building</th>
                            <th class="border px-3 py-2 font-semibold text-xs">Expediting Contact</th>
                            <th class="border px-3 py-2 font-semibold text-xs">Submitted At</th>
                            <!-- Supplier Inputs Columns -->
                            <th class="border px-3 py-2 font-semibold bg-yellow-100 text-xs">Detailed Scope of delivery</th>
                            <th class="border px-3 py-2 font-semibold bg-yellow-100 text-xs">Quantity</th>
                            <th class="border px-3 py-2 font-semibold bg-yellow-100 text-xs">Design Status (%)</th>
                            <th class="border px-3 py-2 font-semibold bg-yellow-100 text-xs">End of manufacturing Supplier</th>
                            <th class="border px-3 py-2 font-semibold bg-yellow-100 text-xs">Manuafacturing Status (%)</th>
                            <th class="border px-3 py-2 font-semibold bg-yellow-100 text-xs">FAT date Scheduled - Baseline</th>
                            <th class="border px-3 py-2 font-semibold bg-yellow-100 text-xs">FAT date Actual</th>
                            <th class="border px-3 py-2 font-semibold bg-yellow-100 text-xs">FAT Status (%)</th>
                            <th class="border px-3 py-2 font-semibold bg-yellow-100 text-xs">Ready for Shipment</th>
                            <th class="border px-3 py-2 font-semibold bg-yellow-100 text-xs">Contractual delivery to site date</th>
                            <th class="border px-3 py-2 font-semibold bg-yellow-100 text-xs">Forecast Delivery to Site (Time shedule date (site need date))</th>
                            <th class="border px-3 py-2 font-semibold bg-yellow-100 text-xs">Actual Delivery to site Supplier</th>
                            <th class="border px-3 py-2 font-semibold bg-yellow-100 text-xs">Storage requirement</th>
                            <th class="border px-3 py-2 font-semibold bg-yellow-100 text-xs">Delivery postponement due to site readiness</th>
                            <th class="border px-3 py-2 font-semibold bg-yellow-100 text-xs">Delivered</th>
                            <th class="border px-3 py-2 font-semibold bg-yellow-100 text-xs">Exyte Technical Discussion / Open Points in clarification with Supplier Delivery Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Loop through expeditingForms and display all columns, including supplier inputs -->
                        @foreach($expeditingForms as $form)
                        @php
                            $cat = optional($form->context)->expediting_category ?? $form->expediting_category;
                            $catColor = $cat === 'Middle' ? 'bg-yellow-200' : ($cat === 'High' ? 'bg-red-200' : ($cat === 'Low' ? 'bg-green-200' : ''));
                        @endphp
                        <tr x-data="{ showHistory: false, showForecastHistory: false }">
                            <td class="border px-3 py-2 sticky left-0">{{ $form->work_package }}</td>
                            <td class="border px-3 py-2">{{ optional($form->context)->lli ?? '' }}</td>
                            <td class="border px-3 py-2 {{ $catColor }}">{{ $cat }}</td>
                            <td class="border px-3 py-2">{{ optional($form->context)->workpackage_name ?? $form->workpackage_name }}</td>
                            <td class="border px-3 py-2">{{ optional($form->context)->supplier ?? $form->supplier }}</td>
                            <td class="border px-3 py-2 whitespace-nowrap">{{ optional($form->context)->order_date ? \Carbon\Carbon::parse(optional($form->context)->order_date)->format('d-m-Y') : '' }}</td>
                            <td class="border px-3 py-2">{{ optional($form->context)->contract_data_available_dmcs ?? '' }}</td>
                            <td class="border px-3 py-2">{{ optional($form->context)->po_number ?? $form->po_number }}</td>
                            <td class="border px-3 py-2">{{ optional($form->context)->incoterms ?? '' }}</td>
                            <td class="border px-3 py-2">{{ optional($form->context)->exyte_procurement_contract_manager ?? '' }}</td>
                            <td class="border px-3 py-2">{{ optional($form->context)->customer_procurement_contact ?? '' }}</td>
                            <td class="border px-3 py-2">{{ optional($form->context)->kickoff_status ?? '' }}</td>
                            <td class="border px-3 py-2">{{ optional($form->context)->technical_workpackage_owner ?? '' }}</td>
                            <td class="border px-3 py-2">{{ $form->workstream_building }}</td>
                            <td class="border px-3 py-2">{{ $form->expediting_contact }}</td>
                            <td class="border px-3 py-2 whitespace-nowrap">{{ $form->created_at ? $form->created_at->format('d-m-Y') : '' }}</td>
                            <!-- Supplier Inputs -->
                            <td class="border px-3 py-2 bg-yellow-50">{{ $form->detailed_scope_of_delivery }}</td>
                            <td class="border px-3 py-2 bg-yellow-50">{{ $form->quantity }}</td>
                            <td class="border px-3 py-2 bg-yellow-50">{{ $form->design_status }}</td>
                            <td class="border px-3 py-2 bg-yellow-50">{{ $form->end_of_manufacturing_supplier }}</td>
                            <td class="border px-3 py-2 bg-yellow-50">{{ $form->manufacturing_status }}</td>
                            <td class="border px-3 py-2 bg-yellow-50 whitespace-nowrap">{{ $form->fat_date_scheduled_baseline ? \Carbon\Carbon::parse($form->fat_date_scheduled_baseline)->format('d-m-Y') : '' }}</td>
                            <td class="border px-3 py-2 bg-yellow-50 whitespace-nowrap">{{ $form->fat_date_actual ? \Carbon\Carbon::parse($form->fat_date_actual)->format('d-m-Y') : '' }}</td>
                            <td class="border px-3 py-2 bg-yellow-50">{{ $form->fat_status }}</td>
                            <td class="border px-3 py-2 bg-yellow-50">{{ $form->ready_for_shipment }}</td>
                            <td class="border px-3 py-2 bg-yellow-50 whitespace-nowrap">{{ $form->contractual_delivery_to_site_date ? \Carbon\Carbon::parse($form->contractual_delivery_to_site_date)->format('d-m-Y') : '' }}</td>
                            <td class="border px-3 py-2 bg-yellow-50 whitespace-nowrap">
                                <span>{{ $form->forecast_delivery_to_site ? \Carbon\Carbon::parse($form->forecast_delivery_to_site)->format('d-m-Y') : '' }}</span>
                                @php
                                    $forecastHistories = $form->forecastDeliveryHistories()->orderByDesc('changed_at')->get();
                                @endphp
                                @if($forecastHistories->count())
                                    <button type="button" @click="showForecastHistory = true" class="ml-1 align-middle text-[#01426a] hover:text-[#357ab7]" title="View Change History">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="inline h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                    <div>
                                        <div x-show="showForecastHistory" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                                            <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-2xl relative flex flex-col items-center justify-center text-center">
                                                <button type="button" @click="showForecastHistory = false" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                                <h3 class="text-base font-bold text-[#01426a] mb-1">Change History</h3>
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
                                    </div>
                                @endif
                            </td>
                            <td class="border px-3 py-2 bg-yellow-50 whitespace-nowrap">
                                <span>{{ $form->actual_delivery_to_site_supplier ? \Carbon\Carbon::parse($form->actual_delivery_to_site_supplier)->format('d-m-Y') : '' }}</span>
                                @php
                                    $histories = $form->actualDeliveryHistories()->orderByDesc('changed_at')->get();
                                @endphp
                                @if($histories->count())
                                    <button type="button" @click="showHistory = true" class="ml-1 align-middle text-[#01426a] hover:text-[#357ab7]" title="View Change History">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="inline h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                    <div>
                                        <div x-show="showHistory" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                                            <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-2xl relative flex flex-col items-center justify-center text-center">
                                                <button type="button" @click="showHistory = false" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                                <h3 class="text-base font-bold text-[#01426a] mb-1">Change History</h3>
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
                                                        @foreach($histories as $history)
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
                                    </div>
                                @endif
                            </td>
                            <td class="border px-3 py-2 bg-yellow-50">{{ $form->storage_requirement }}</td>
                            <td class="border px-3 py-2 bg-yellow-50">{{ $form->delivery_postponement_due_to_site_readiness }}</td>
                            @php
                                $deliveredBg = '';
                                if ($form->delivered === 'Yes') {
                                    $deliveredBg = 'bg-green-200 text-green-900 font-bold';
                                } elseif ($form->delivered === 'No') {
                                    $deliveredBg = 'bg-red-200 text-red-900 font-bold';
                                } elseif ($form->delivered === 'Delay- FAT Issue') {
                                    $deliveredBg = 'bg-orange-200 text-orange-900 font-bold';
                                } else {
                                    $deliveredBg = 'bg-yellow-50';
                                }
                            @endphp
                            <td class="border px-3 py-2 {{ $deliveredBg }}">{{ $form->delivered }}</td>
                            <td class="border px-3 py-2 bg-yellow-50 max-w-xs truncate" x-data="{ showCommentModal: false }">
                                @if(isset($form->comments) && trim($form->comments) !== '')
                                    @php $isLong = strlen($form->comments) > 40; @endphp
                                    <div>
                                        <span>
                                            {{ $isLong ? \Illuminate\Support\Str::limit($form->comments, 40) : $form->comments }}
                                        </span>
                                        @if($isLong)
                                            <div class="mt-1">
                                                <button type="button" @click="showCommentModal = true" class="align-middle text-red-600 hover:underline font-semibold text-xs" title="View Full Text">
                                                    Read More
                                                </button>
                                            </div>
                                            <div>
                                                <div x-show="showCommentModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                                                    <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-2xl relative flex flex-col items-center justify-center text-center">
                                                        <button type="button" @click="showCommentModal = false" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                        <h3 class="text-base font-bold text-[#01426a] mb-1">Full Remarks</h3>
                                                        <div class="mb-3 text-sm text-gray-700 whitespace-pre-line text-left">{{ $form->comments }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
