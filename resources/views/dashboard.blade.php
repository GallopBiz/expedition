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
                     <!-- Upcoming Deliveries: Two Column Layout -->
                    <div class="my-12 bg-blue-50 border border-blue-200 rounded-xl shadow p-6">
                        <h4 class="text-xl font-bold mb-6 text-white bg-[#01426a] px-4 py-2 rounded-t-lg tracking-wide shadow-inner">Upcoming Deliveries (Next 6 Weeks)</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- 1st Column: Bar Graph -->
                            <div class="md:pr-6 md:border-r md:border-gray-300 flex flex-col justify-center">
                                <div id="upcoming-deliveries-bar" class="w-full max-w-2xl mx-auto"></div>
                            </div>
                            <!-- 2nd Column: Table -->
                            <div class="md:pl-6 flex flex-col justify-center">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full bg-white border border-gray-200 rounded-lg text-xs">
                                        <thead>
                                            <tr class="bg-blue-50 text-[#01426a]">
                                                <th class="py-2 px-4 border-b text-center">Week</th>
                                                <th class="py-2 px-4 border-b text-center">Delivery Date</th>
                                                <th class="py-2 px-4 border-b text-center">Work Package</th>
                                                <th class="py-2 px-4 border-b text-center">Supplier</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="py-2 px-4 border-b text-center">Week 1</td>
                                                <td class="py-2 px-4 border-b text-center">2026-02-22</td>
                                                <td class="py-2 px-4 border-b text-center"><a href="{{ url('workpackages/1') }}" class="text-blue-700 underline hover:text-blue-900">WP-001</a></td>
                                                <td class="py-2 px-4 border-b text-center">Alpha Supplies</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-4 border-b text-center">Week 1</td>
                                                <td class="py-2 px-4 border-b text-center">2026-02-22</td>
                                                <td class="py-2 px-4 border-b text-center"><a href="{{ url('workpackages/2') }}" class="text-blue-700 underline hover:text-blue-900">WP-002</a></td>
                                                <td class="py-2 px-4 border-b text-center">Beta Traders</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-4 border-b text-center">Week 2</td>
                                                <td class="py-2 px-4 border-b text-center">2026-03-01</td>
                                                <td class="py-2 px-4 border-b text-center"><a href="{{ url('workpackages/3') }}" class="text-blue-700 underline hover:text-blue-900">WP-003</a></td>
                                                <td class="py-2 px-4 border-b text-center">Gamma Corp</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-4 border-b text-center">Week 3</td>
                                                <td class="py-2 px-4 border-b text-center">2026-03-08</td>
                                                <td class="py-2 px-4 border-b text-center"><a href="{{ url('workpackages/4') }}" class="text-blue-700 underline hover:text-blue-900">WP-004</a></td>
                                                <td class="py-2 px-4 border-b text-center">Delta Industries</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-4 border-b text-center">Week 4</td>
                                                <td class="py-2 px-4 border-b text-center">2026-03-15</td>
                                                <td class="py-2 px-4 border-b text-center"><a href="{{ url('workpackages/5') }}" class="text-blue-700 underline hover:text-blue-900">WP-005</a></td>
                                                <td class="py-2 px-4 border-b text-center">Epsilon Ltd</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-4 border-b text-center">Week 5</td>
                                                <td class="py-2 px-4 border-b text-center">2026-03-22</td>
                                                <td class="py-2 px-4 border-b text-center"><a href="{{ url('workpackages/6') }}" class="text-blue-700 underline hover:text-blue-900">WP-006</a></td>
                                                <td class="py-2 px-4 border-b text-center">Zeta Partners</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-4 border-b text-center">Week 6</td>
                                                <td class="py-2 px-4 border-b text-center">2026-03-29</td>
                                                <td class="py-2 px-4 border-b text-center"><a href="{{ url('workpackages/7') }}" class="text-blue-700 underline hover:text-blue-900">WP-007</a></td>
                                                <td class="py-2 px-4 border-b text-center">Theta Group</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="flex justify-end mt-2">
                                        <button class="text-xs px-3 py-1 bg-blue-100 text-[#01426a] rounded hover:bg-blue-200 transition">See More</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Expediting & Status Section: Three Column Layout -->
                    <div class="my-12 bg-blue-50 border border-blue-200 rounded-xl shadow p-6">
                        <h4 class="text-xl font-bold mb-6 text-white bg-[#01426a] px-4 py-2 rounded-t-lg tracking-wide shadow-inner">Expediting & Status Overview</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <!-- 1st Column: Expediting Category Pie Chart -->
                            <div class="md:pr-6 md:border-r md:border-gray-300 flex flex-col justify-center">
                                <h5 class="text-base font-semibold mb-4 text-[#01426a] text-center">Expediting Category</h5>
                                <div id="expediting-category-pie" class="w-full max-w-xs mx-auto"></div>
                            </div>
                            <!-- 2nd Column: Design Status Bar Graph -->
                            <div class="md:px-6 md:border-r md:border-gray-300 flex flex-col justify-center">
                                <h5 class="text-base font-semibold mb-4 text-[#01426a] text-center">Design Status</h5>
                                <div id="design-status-bar" class="w-full max-w-xs mx-auto"></div>
                            </div>
                            <!-- 3rd Column: Fabrication Status Bar Graph -->
                            <div class="md:pl-6 flex flex-col justify-center">
                                <h5 class="text-base font-semibold mb-4 text-[#01426a] text-center">Fabrication Status</h5>
                                <div id="fabrication-status-bar" class="w-full max-w-xs mx-auto"></div>
                            </div>
                        </div>
                    </div>
                                        <!-- Recent Work Packages & Suppliers Section -->
                                        <div class="my-12 bg-blue-50 border border-blue-200 rounded-xl shadow p-6">
                                            <h4 class="text-xl font-bold mb-6 text-white bg-[#01426a] px-4 py-2 rounded-t-lg tracking-wide shadow-inner">Recent Work Packages & Suppliers</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- 1st Column: Recent Work Packages -->
                            <div>
                                <h5 class="text-base font-semibold mb-4 text-[#01426a] text-center">Recent Work Packages</h5>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full bg-white border border-gray-200 rounded-lg text-xs">
                                        <thead>
                                            <tr class="bg-blue-50 text-[#01426a]">
                                                <th class="py-2 px-4 border-b text-center">Work Package</th>
                                                <th class="py-2 px-4 border-b text-center">Status</th>
                                                <th class="py-2 px-4 border-b text-center">Created At</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="py-2 px-4 border-b text-center"><a href="{{ url('workpackages/11') }}" class="text-blue-700 underline hover:text-blue-900">WP-011</a></td>
                                                <td class="py-2 px-4 border-b text-center">In Progress</td>
                                                <td class="py-2 px-4 border-b text-center">2026-02-16</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-4 border-b text-center"><a href="{{ url('workpackages/12') }}" class="text-blue-700 underline hover:text-blue-900">WP-012</a></td>
                                                <td class="py-2 px-4 border-b text-center">Pending</td>
                                                <td class="py-2 px-4 border-b text-center">2026-02-15</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-4 border-b text-center"><a href="{{ url('workpackages/13') }}" class="text-blue-700 underline hover:text-blue-900">WP-013</a></td>
                                                <td class="py-2 px-4 border-b text-center">Completed</td>
                                                <td class="py-2 px-4 border-b text-center">2026-02-14</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- 2nd Column: Recent Suppliers -->
                            <div>
                                <h5 class="text-base font-semibold mb-4 text-[#01426a] text-center">Recent Suppliers</h5> 
                                    <table class="min-w-full bg-white border border-gray-200 rounded-lg text-xs">
                                        <thead>
                                            <tr class="bg-blue-50 text-[#01426a]">
                                                <th class="py-2 px-4 border-b text-center">Supplier Name</th>
                                                <th class="py-2 px-4 border-b text-center">Contact</th>
                                                <th class="py-2 px-4 border-b text-center">Created At</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="py-2 px-4 border-b text-center">Sigma Supplies</td>
                                                <td class="py-2 px-4 border-b text-center">sigma@email.com</td>
                                                <td class="py-2 px-4 border-b text-center">2026-02-16</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-4 border-b text-center">Omega Corp</td>
                                                <td class="py-2 px-4 border-b text-center">omega@email.com</td>
                                                <td class="py-2 px-4 border-b text-center">2026-02-15</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-4 border-b text-center">Lambda Industries</td>
                                                <td class="py-2 px-4 border-b text-center">lambda@email.com</td>
                                                <td class="py-2 px-4 border-b text-center">2026-02-14</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            // Expediting Category Pie Chart (Dummy Data)
                            var expeditingPieOptions = {
                                chart: { type: 'pie', height: 260 },
                                series: [40, 35, 25],
                                labels: ['Low', 'Medium', 'High'],
                                colors: ['#00b5e2', '#fbbf24', '#01426a'],
                                legend: { position: 'bottom', fontSize: '14px' },
                                dataLabels: { enabled: true },
                                title: { text: 'Expediting Category', align: 'center', style: { fontSize: '16px', color: '#01426a' } }
                            };
                            var expeditingPieChart = new ApexCharts(document.querySelector("#expediting-category-pie"), expeditingPieOptions);
                            expeditingPieChart.render();

                            // Design Status Bar Graph (Dummy Data)
                            var designBarOptions = {
                                chart: { type: 'bar', height: 260 },
                                series: [{ name: 'Status', data: [12, 8, 5] }],
                                xaxis: { categories: ['Completed', 'In Progress', 'Pending'], labels: { style: { fontSize: '14px' } } },
                                colors: ['#38bdf8', '#fbbf24', '#a3a3a3'],
                                plotOptions: { bar: { borderRadius: 6, columnWidth: '50%' } },
                                dataLabels: { enabled: true },
                                title: { text: 'Design Status', align: 'center', style: { fontSize: '16px', color: '#01426a' } },
                                legend: { show: false }
                            };
                            var designBarChart = new ApexCharts(document.querySelector("#design-status-bar"), designBarOptions);
                            designBarChart.render();

                            // Fabrication Status Bar Graph (Dummy Data)
                            var fabricationBarOptions = {
                                chart: { type: 'bar', height: 260 },
                                series: [{ name: 'Status', data: [9, 6, 3] }],
                                xaxis: { categories: ['Completed', 'In Progress', 'Pending'], labels: { style: { fontSize: '14px' } } },
                                colors: ['#22c55e', '#fbbf24', '#a3a3a3'],
                                plotOptions: { bar: { borderRadius: 6, columnWidth: '50%' } },
                                dataLabels: { enabled: true },
                                title: { text: 'Fabrication Status', align: 'center', style: { fontSize: '16px', color: '#01426a' } },
                                legend: { show: false }
                            };
                            var fabricationBarChart = new ApexCharts(document.querySelector("#fabrication-status-bar"), fabricationBarOptions);
                            fabricationBarChart.render();
                        });
                    </script>
                        </div>
                    </div>
                    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            var weekLabels = [
                                'Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6'
                            ];
                            var dummyDeliveries = [5, 8, 12, 7, 10, 6];
                            var deliveryBarOptions = {
                                chart: {
                                    type: 'bar',
                                    height: 320
                                },
                                series: [{
                                    name: 'Deliveries',
                                    data: dummyDeliveries
                                }],
                                xaxis: {
                                    categories: weekLabels,
                                    title: { text: 'Week' },
                                    labels: {
                                        style: {
                                            fontSize: '15px',
                                            fontWeight: 500
                                        }
                                    }
                                },
                                yaxis: {
                                    title: { text: 'No. of Deliveries' },
                                    min: 0
                                },
                                colors: ['#00b5e2'],
                                plotOptions: {
                                    bar: {
                                        borderRadius: 6,
                                        columnWidth: '50%'
                                    }
                                },
                                dataLabels: {
                                    enabled: true,
                                    style: {
                                        fontSize: '15px',
                                        fontWeight: 700
                                    }
                                },
                                title: {
                                    text: 'Upcoming Deliveries by Week',
                                    align: 'center',
                                    style: {
                                        fontSize: '18px',
                                        fontWeight: 700,
                                        color: '#01426a'
                                    }
                                },
                                legend: {
                                    show: false
                                }
                            };
                            var deliveryBarChart = new ApexCharts(document.querySelector("#upcoming-deliveries-bar"), deliveryBarOptions);
                            deliveryBarChart.render();
                        });
                    </script>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
