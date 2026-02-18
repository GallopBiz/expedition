
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Supplier Expediting Form') }}
        </h2>
    </x-slot>

    <div class="w-full px-2 md:px-8 mt-6 font-sans">







        <div class="bg-gradient-to-br from-[#e6eef4] to-white p-4 md:p-8 rounded-2xl shadow-2xl w-full border border-[#01426a22]">
            @if(session('success'))
                <div class="mb-4 p-2 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif
            
            @if($errors->any())
                <div class="mb-4 p-2 bg-red-100 text-red-800 rounded">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(isset($linkExpired) && $linkExpired && (!auth()->check() || auth()->user()->role !== 'Supplier'))
                <div class="mb-6 p-6 bg-red-100 border border-red-300 text-red-800 rounded-xl text-center text-lg font-semibold">
                    This link has expired because the form has already been filled.<br>
                    Please log in to your dashboard to view your submitted form.
                </div>
            @endif
            @if(!isset($linkExpired) || !$linkExpired || (auth()->check() && auth()->user()->role === 'Supplier'))
                <form method="POST" action="{{ url()->full() }}" class="space-y-8 w-full">
                    @csrf
                    <div class="mb-6">
                        <h3 class="text-lg md:text-2xl font-bold text-[#01426a] mb-2 tracking-wide">Work Package Information</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 w-full">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Work Package</label>
                                <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm locked-field" value="{{ $expeditingForm->work_package }}" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Work Package Name</label>
                                <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm locked-field" value="{{ $expeditingForm->workpackage_name }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="mb-6">
                        <h3 class="text-lg md:text-2xl font-bold text-[#01426a] mb-2 tracking-wide">Supplier Editable Fields</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 w-full">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Equipment Type / Tag Number</label>
                            <input type="text" name="equipment_type_tag_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('equipment_type_tag_number', $expeditingForm->equipment_type_tag_number) }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Detailed Scope of Delivery</label>
                            <textarea name="detailed_scope_of_delivery" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('detailed_scope_of_delivery', $expeditingForm->detailed_scope_of_delivery) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Quantity</label>
                            <input type="number" name="quantity" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('quantity', $expeditingForm->quantity) }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Supplier</label>
                            <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm locked-field" value="{{ $expeditingForm->supplier }}" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Sub Supplier</label>
                            <input type="text" name="sub_supplier" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('sub_supplier', $expeditingForm->sub_supplier) }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Place of Manufacturing</label>
                            <select name="place_of_manufacturing" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Select</option>
                                <option value="Scheppach (Germany)" @if(old('place_of_manufacturing', $expeditingForm->place_of_manufacturing)==='Scheppach (Germany)') selected @endif>Scheppach (Germany)</option>
                                <option value="Milan (Italy)" @if(old('place_of_manufacturing', $expeditingForm->place_of_manufacturing)==='Milan (Italy)') selected @endif>Milan (Italy)</option>
                                <option value="Pegnitz (Germany)" @if(old('place_of_manufacturing', $expeditingForm->place_of_manufacturing)==='Pegnitz (Germany)') selected @endif>Pegnitz (Germany)</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mb-6">
                    <h3 class="text-lg md:text-2xl font-bold text-[#01426a] mb-2 tracking-wide">Status & Progress</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 w-full">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Order Status</label>
                            <select name="order_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Select</option>
                                <option value="Done" @if(old('order_status', $expeditingForm->order_status)==='Done') selected @endif>Done</option>
                                <option value="Material Order" @if(old('order_status', $expeditingForm->order_status)==='Material Order') selected @endif>Material Order</option>
                                <option value="Manufacturing" @if(old('order_status', $expeditingForm->order_status)==='Manufacturing') selected @endif>Manufacturing</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Drawing Approval</label>
                            <select name="drawing_approval" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Select</option>
                                <option value="IFC" @if(old('drawing_approval', $expeditingForm->drawing_approval)==='IFC') selected @endif>IFC</option>
                                <option value="AFC" @if(old('drawing_approval', $expeditingForm->drawing_approval)==='AFC') selected @endif>AFC</option>
                                <option value="IFD" @if(old('drawing_approval', $expeditingForm->drawing_approval)==='IFD') selected @endif>IFD</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Design Status (%)</label>
                            <input type="number" name="design_status" min="0" max="100" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('design_status', $expeditingForm->design_status) }}">
                        </div>
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Progress Status</label>
                            <div class="flex flex-col md:flex-row gap-4">
                                <div class="flex-1 bg-gradient-to-br from-[#e6eef4] to-[#b3c9db] rounded-xl p-4 shadow border border-[#01426a22] flex flex-col items-center">
                                    <span class="font-semibold text-[#01426a]">Material Status</span>
                                    <input type="number" name="material_status" min="0" max="100" class="mt-2 w-20 text-center rounded-md border-gray-300 shadow-sm text-lg font-bold text-[#357ab7] focus:ring-2 focus:ring-[#01426a33] focus:border-[#01426a] transition" value="{{ old('material_status', $expeditingForm->material_status) }}">
                                    <span class="text-xs text-gray-500 mt-1">%</span>
                                </div>
                                <div class="flex-1 bg-gradient-to-br from-[#e6eef4] to-[#b3c9db] rounded-xl p-4 shadow border border-[#01426a22] flex flex-col items-center">
                                    <span class="font-semibold text-[#01426a]">Fabrication Status</span>
                                    <input type="number" name="fabrication_status" min="0" max="100" class="mt-2 w-20 text-center rounded-md border-gray-300 shadow-sm text-lg font-bold text-[#357ab7] focus:ring-2 focus:ring-[#01426a33] focus:border-[#01426a] transition" value="{{ old('fabrication_status', $expeditingForm->fabrication_status) }}">
                                    <span class="text-xs text-gray-500 mt-1">%</span>
                                </div>
                                <div class="flex-1 bg-gradient-to-br from-[#e6eef4] to-[#b3c9db] rounded-xl p-4 shadow border border-[#01426a22] flex flex-col items-center">
                                    <span class="font-semibold text-[#01426a]">FAT Status</span>
                                    <input type="number" name="fat_status" min="0" max="100" class="mt-2 w-20 text-center rounded-md border-gray-300 shadow-sm text-lg font-bold text-[#357ab7] focus:ring-2 focus:ring-[#01426a33] focus:border-[#01426a] transition" value="{{ old('fat_status', $expeditingForm->fat_status) }}">
                                    <span class="text-xs text-gray-500 mt-1">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-6">
                    <h3 class="text-lg md:text-2xl font-bold text-[#01426a] mb-2 tracking-wide">Dates</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 w-full">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Start of Manufacturing Actual</label>
                            <input type="date" name="start_of_manufacturing_actual" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('start_of_manufacturing_actual', $expeditingForm->start_of_manufacturing_actual) }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">End of Manufacturing</label>
                            <input type="date" name="end_of_manufacturing" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('end_of_manufacturing', $expeditingForm->end_of_manufacturing) }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">FAT Date Actual</label>
                            <input type="date" name="fat_date_actual" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('fat_date_actual', $expeditingForm->fat_date_actual) }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Contractual Delivery to Site Date</label>
                            <input type="date" name="contractual_delivery_to_site_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('contractual_delivery_to_site_date', $expeditingForm->contractual_delivery_to_site_date) }}">
                        </div>
                        <div x-data="{ showHistory: false }">
                            <label class="block text-sm font-medium text-gray-700">Actual Delivery to Site – Supplier
                                @if(isset($actualDeliveryHistories) && $actualDeliveryHistories->count())
                                    <button type="button" @click="showHistory = true" class="ml-2 align-middle text-[#01426a] hover:text-[#357ab7]" title="View Change History">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="inline h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                @endif
                            </label>
                            <input type="date" name="actual_delivery_to_site_supplier" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('actual_delivery_to_site_supplier', $expeditingForm->actual_delivery_to_site_supplier) }}">
                            <!-- Modal Popup for Change History -->
                            <div x-show="showHistory" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                                <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-2xl relative">
                                    <button type="button" @click="showHistory = false" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                    <h3 class="text-base font-bold text-[#01426a] mb-3">Change History</h3>
                                    <table class="min-w-full text-xs border border-gray-200 bg-white">
                                        <thead class="bg-[#f8fafc] text-[#01426a]">
                                            <tr>
                                                <th class="px-1 py-1 border border-gray-200">Old Value</th>
                                                <th class="px-1 py-1 border border-gray-200">New Value</th>
                                                <th class="px-1 py-1 border border-gray-200">Changed By</th>
                                                <th class="px-1 py-1 border border-gray-200">Changed At</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($actualDeliveryHistories as $history)
                                                <tr>
                                                    <td class="px-1 py-1 border border-gray-200">{{ $history->old_value }}</td>
                                                    <td class="px-1 py-1 border border-gray-200">{{ $history->new_value }}</td>
                                                    <td class="px-1 py-1 border border-gray-200">{{ $history->changed_by }}</td>
                                                    <td class="px-1 py-1 border border-gray-200">{{ $history->changed_at }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-6">
                    <h3 class="text-lg md:text-2xl font-bold text-[#01426a] mb-2 tracking-wide">Other</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 w-full">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Manufacturing Duration (weeks)</label>
                            <input type="number" name="manufacturing_duration" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('manufacturing_duration', $expeditingForm->manufacturing_duration) }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ready for Shipment</label>
                            <select name="ready_for_shipment" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Select</option>
                                <option value="Yes" @if(old('ready_for_shipment', $expeditingForm->ready_for_shipment)==='Yes') selected @endif>Yes</option>
                                <option value="No" @if(old('ready_for_shipment', $expeditingForm->ready_for_shipment)==='No') selected @endif>No</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Storage at Supplier</label>
                            <select name="storage_at_supplier" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Select</option>
                                <option value="Yes" @if(old('storage_at_supplier', $expeditingForm->storage_at_supplier)==='Yes') selected @endif>Yes</option>
                                <option value="No" @if(old('storage_at_supplier', $expeditingForm->storage_at_supplier)==='No') selected @endif>No</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Delivered</label>
                            <select name="delivered" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Select</option>
                                <option value="Yes" @if(old('delivered', $expeditingForm->delivered)==='Yes') selected @endif>Yes</option>
                                <option value="No" @if(old('delivered', $expeditingForm->delivered)==='No') selected @endif>No</option>
                                <option value="Delay- FAT Issue" @if(old('delivered', $expeditingForm->delivered)==='Delay- FAT Issue') selected @endif>Delay- FAT Issue</option>
                                <option value="Other" @if(old('delivered', $expeditingForm->delivered)==='Other') selected @endif>Other</option>
                            </select>
                        </div>
                        <div class="col-span-1 md:col-span-3">
                            <label class="block text-sm font-medium text-gray-700">Exyte Technical Discussion / Open Points in clarification with Supplier Delivery Remarks</label>
                            <textarea name="comments" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('comments', $expeditingForm->comments) }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="mt-8 text-right w-full">
                    <button type="submit" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-[#01426a] to-[#357ab7] border border-transparent rounded-xl font-bold text-sm md:text-base text-white uppercase tracking-widest shadow hover:from-[#01426a] hover:to-[#012a40] focus:outline-none focus:ring-2 focus:ring-[#01426a33] active:bg-[#012a40] transition gap-2">Submit</button>
                </div>
            </form>
            @if(isset($emailLogs) && $emailLogs->count())
                <div class="mt-8 bg-white rounded-xl shadow border border-gray-100 p-4">
                    <h3 class="text-xs font-bold text-[#01426a] mb-2 tracking-wide">Email Log</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-xs border border-gray-200">
                            <thead class="bg-[#f8fafc] text-[#01426a]">
                                <tr>
                                    <th class="px-1 py-1 border border-gray-200">To</th>
                                    <th class="px-1 py-1 border border-gray-200">By</th>
                                    <th class="px-1 py-1 border border-gray-200">At</th>
                                    <th class="px-1 py-1 border border-gray-200">Subject</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($emailLogs as $log)
                                    <tr>
                                        <td class="px-1 py-1 border border-gray-200">{{ $log->recipient_email }}</td>
                                        <td class="px-1 py-1 border border-gray-200">{{ $log->sent_by }}</td>
                                        <td class="px-1 py-1 border border-gray-200">{{ $log->sent_at }}</td>
                                        <td class="px-1 py-1 border border-gray-200">{{ $log->subject }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            @endif
        </div>
    </div>
</x-app-layout>
