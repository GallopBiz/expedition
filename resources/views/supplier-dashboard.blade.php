<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Supplier Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl shadow p-6 mb-8">
                        <h3 class="text-lg font-bold mb-2 text-yellow-800">Welcome Supplier</h3>
                        <p class="text-sm text-yellow-700">This dashboard is customized for your supplier account. Please check your assigned work packages and notifications.</p>
                    </div>
                    <h3 class="text-lg font-bold mb-4 text-[#01426a]">Dashboard Analytics</h3>
                    @php
                        $showDummy = ($totalWP ?? 0) === 0 && ($wpWithPO ?? 0) === 0 && ($wpWithoutPO ?? 0) === 0 && ($deliveredWP ?? 0) === 0;
                        $dummy = [
                            'totalWP' => 100,
                            'wpWithPO' => 60,
                            'wpWithoutPO' => 40,
                            'delivered' => [
                                'Yes' => 55,
                                'No' => 30,
                                'Delay- FAT Issue' => 10,
                                'Other' => 5,
                            ],
                        ];
                        $deliveredStats = $showDummy ? $dummy['delivered'] : [
                            'Yes' => \App\Models\ExpeditingForm::where('delivered', 'Yes')->count(),
                            'No' => \App\Models\ExpeditingForm::where('delivered', 'No')->count(),
                            'Delay- FAT Issue' => \App\Models\ExpeditingForm::where('delivered', 'Delay- FAT Issue')->count(),
                            'Other' => \App\Models\ExpeditingForm::where('delivered', 'Other')->count(),
                        ];
                    @endphp
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                        <a href="{{ url('workpackages') }}" class="block bg-blue-100 p-4 rounded-lg shadow text-center hover:bg-blue-200 transition">
                            <div class="text-2xl font-bold text-blue-700">{{ $showDummy ? $dummy['totalWP'] : ($totalWP ?? 0) }}</div>
                            <div class="text-sm text-blue-900 mt-2">Total Work Packages</div>
                        </a>
                        <a href="{{ url('workpackages?filter=with-po') }}" class="block bg-green-100 p-4 rounded-lg shadow text-center hover:bg-green-200 transition">
                            <div class="text-2xl font-bold text-green-700">{{ $showDummy ? $dummy['wpWithPO'] : ($wpWithPO ?? 0) }}</div>
                            <div class="text-sm text-green-900 mt-2">Work Packages with PO</div>
                        </a>
                        <a href="{{ url('workpackages?filter=without-po') }}" class="block bg-red-100 p-4 rounded-lg shadow text-center hover:bg-red-200 transition">
                            <div class="text-2xl font-bold text-red-700">{{ $showDummy ? $dummy['wpWithoutPO'] : ($wpWithoutPO ?? 0) }}</div>
                            <div class="text-sm text-red-900 mt-2">Work Packages without PO</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
