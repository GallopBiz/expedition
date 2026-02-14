<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
            @if(auth()->user() && auth()->user()->role === 'Supplier')
                <div class="mt-8 bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-4 text-[#01426a]">Your Expediting Forms</h3>
                    @php
                        $forms = \App\Models\ExpeditingForm::where('supplier', auth()->user()->email)
                            ->orWhere('supplier', auth()->user()->name)
                            ->orderByDesc('created_at')->get();
                    @endphp
                    @if($forms->count())
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm border">
                                <thead class="bg-gradient-to-r from-[#e6eef4] to-[#b3c9db] text-[#01426a]">
                                    <tr>
                                        <th class="px-3 py-2 border">Work Package</th>
                                        <th class="px-3 py-2 border">Work Package Name</th>
                                        <th class="px-3 py-2 border">Order Status</th>
                                        <th class="px-3 py-2 border">Last Updated</th>
                                        <th class="px-3 py-2 border">View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($forms as $form)
                                        <tr class="hover:bg-[#e6eef4]">
                                            <td class="px-3 py-2 border">{{ $form->work_package }}</td>
                                            <td class="px-3 py-2 border">{{ $form->workpackage_name }}</td>
                                            <td class="px-3 py-2 border">{{ $form->order_status ?? '-' }}</td>
                                            <td class="px-3 py-2 border">{{ $form->updated_at ? $form->updated_at->format('Y-m-d H:i') : '-' }}</td>
                                            <td class="px-3 py-2 border text-center">
                                                <a href="{{ URL::signedRoute('supplier.expedite.access', $form) }}" class="text-blue-700 underline" target="_blank">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-gray-500">No expediting forms found.</div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
