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
                            <table class="min-w-full text-sm border">
                                <thead class="bg-gradient-to-r from-[#e6eef4] to-[#b3c9db] text-[#01426a]">
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
                                            <td class="px-3 py-2 border text-center">
                                                <a href="{{ URL::signedRoute('supplier.expedite.access', $form) }}" class="text-blue-700 underline" target="_blank">View</a>
                                            </td>
                                        <script>
                                            document.addEventListener('alpine:init', () => {
                                                Alpine.store('openModal', null);
                                            });
                                        </script>
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
