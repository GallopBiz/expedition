<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All Work Packages') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4 text-[#01426a]">Work Package List</h3>
                    @php
                        $forms = \App\Models\ExpeditingForm::orderByDesc('created_at')->get();
                    @endphp
                    @if($forms->count())
                        <div class="overflow-x-auto">
                            <form method="GET" class="mb-4 flex flex-wrap gap-2 items-end justify-start" id="work-package-filter-form">
                                <input type="text" name="search_work_package" placeholder="Work Package" class="border rounded px-2 py-1 text-xs" value="{{ request('search_work_package') }}">
                                <input type="text" name="search_workpackage_name" placeholder="Work Package Name" class="border rounded px-2 py-1 text-xs" value="{{ request('search_workpackage_name') }}">
                                <input type="text" name="search_equipment_type" placeholder="Equipment Type / Tag Number" class="border rounded px-2 py-1 text-xs" value="{{ request('search_equipment_type') }}">
                                <select name="filter_delivered" class="border rounded px-2 py-1 text-xs">
                                    <option value="">Delivered (All)</option>
                                    <option value="Yes" {{ request('filter_delivered') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ request('filter_delivered') == 'No' ? 'selected' : '' }}>No</option>
                                    <option value="Delay- FAT Issue" {{ request('filter_delivered') == 'Delay- FAT Issue' ? 'selected' : '' }}>Delay- FAT Issue</option>
                                    <option value="Other" {{ request('filter_delivered') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                <select name="filter_sub_supplier" class="border rounded px-2 py-1 text-xs">
                                    <option value="">Sub Supplier (All)</option>
                                    @foreach(\App\Models\ExpeditingForm::distinct()->orderBy('sub_supplier')->pluck('sub_supplier') as $subSupplier)
                                        @if($subSupplier)
                                            <option value="{{ $subSupplier }}" {{ request('filter_sub_supplier') == $subSupplier ? 'selected' : '' }}>{{ $subSupplier }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <button type="submit" class="bg-[#01426a] text-white px-4 py-1 rounded text-xs font-semibold">Filter</button>
                                <button type="button" onclick="resetWorkPackageFilters()" class="bg-gray-300 text-gray-800 px-4 py-1 rounded text-xs font-semibold">Reset</button>
                            </form>
                            <table class="min-w-full border">
                                <thead class="bg-gradient-to-r from-[#e6eef4] to-[#b3c9db] text-[#01426a] text-xs font-semibold">
                                    <tr>
                                        <th class="px-3 py-2 border">Work Package</th>
                                        <th class="px-3 py-2 border">Work Package Name</th>
                                        <th class="px-3 py-2 border">Equipment Type / Tag Number</th>
                                        <th class="px-3 py-2 border">Quantity</th>
                                        <th class="px-3 py-2 border">Order Status</th>
                                        <th class="px-3 py-2 border">Drawing Approval</th>
                                        <th class="px-3 py-2 border">Design Status (%)</th>
                                        <th class="px-3 py-2 border">Material Status</th>
                                        <th class="px-3 py-2 border">Fabrication Status</th>
                                        <th class="px-3 py-2 border">FAT Status</th>
                                        <th class="px-3 py-2 border">FAT Date Actual</th>
                                        <th class="px-3 py-2 border">Ready for Shipment</th>
                                        <th class="px-3 py-2 border">Contractual Delivery to Site Date</th>
                                        <th class="px-3 py-2 border">Delivered</th>
                                        <th class="px-3 py-2 border">Exyte Technical Discussion / Open Points in clarification with Supplier Delivery Remarks</th>
                                        <th class="px-3 py-2 border">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($forms as $form)
                                        <tr class="hover:bg-[#e6eef4]">
                                            <td class="px-3 py-2 border">{{ $form->work_package }}</td>
                                            <td class="px-3 py-2 border">{{ $form->workpackage_name }}</td>
                                            <td class="px-3 py-2 border">{{ $form->equipment_type_tag_number }}</td>
                                            <td class="px-3 py-2 border">{{ $form->quantity }}</td>
                                            <td class="px-3 py-2 border">{{ $form->order_status }}</td>
                                            <td class="px-3 py-2 border">{{ $form->drawing_approval }}</td>
                                            <td class="px-3 py-2 border">{{ $form->design_status }}</td>
                                            <td class="px-3 py-2 border">{{ $form->material_status }}</td>
                                            <td class="px-3 py-2 border">{{ $form->fabrication_status }}</td>
                                            <td class="px-3 py-2 border">{{ $form->fat_status }}</td>
                                            <td class="px-3 py-2 border">{{ $form->fat_date_actual }}</td>
                                            <td class="px-3 py-2 border">{{ $form->ready_for_shipment }}</td>
                                            <td class="px-3 py-2 border">{{ $form->contractual_delivery_to_site_date }}</td>
                                            <td class="px-3 py-2 border">{{ $form->delivered }}</td>
                                            <td class="px-3 py-2 border max-w-xs truncate" x-data="{ showCommentModal: false }">
                                                <span>
                                                    {{ \Illuminate\Support\Str::limit($form->comments, 40) }}
                                                </span>
                                                @php $isLong = isset($form->comments) && trim($form->comments) !== '' && strlen($form->comments) > 40; @endphp
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
                                            </td>
                                            <td class="px-3 py-2 border text-center">
                                                <a href="{{ URL::signedRoute('supplier.expedite.access', $form) }}" class="text-blue-700 underline" target="_blank">View</a>
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
</x-app-layout>

<script>
function resetWorkPackageFilters() {
    const form = document.getElementById('work-package-filter-form');
    Array.from(form.elements).forEach(el => {
        if (el.tagName === 'SELECT' || el.tagName === 'INPUT') {
            if (el.type === 'checkbox' || el.type === 'radio') {
                el.checked = false;
            } else {
                el.value = '';
            }
        }
    });
    // For select elements with custom value binding (like Laravel request()), manually reset selected options
    Array.from(form.querySelectorAll('select')).forEach(sel => {
        sel.selectedIndex = 0;
    });
    form.submit();
}
</script>
