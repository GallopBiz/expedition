<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All Users') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                    <h3 class="text-lg font-bold text-gray-700">User List</h3>
                    <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto sm:justify-end items-center">
                        <form method="GET" action="{{ route('users.index') }}" class="w-full sm:w-auto">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users..." class="w-full sm:w-64 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" />
                        </form>
                        <a href="{{ route('users.create') }}" class="btn whitespace-nowrap">Create New User</a>
                    </div>
                </div>
                <!-- Role Filter Buttons -->
                <div class="mb-4 flex flex-wrap gap-2">
                    <a href="{{ route('users.index') }}" class="px-3 py-1 rounded-full border text-sm font-semibold transition {{ !isset($roleFilter) || !$roleFilter ? 'bg-[#01426a] text-white border-[#01426a]' : 'bg-white text-[#01426a] border-[#01426a]' }}">
                        All <span class="ml-1 text-xs font-normal">({{ array_sum($roleCounts ? $roleCounts->toArray() : []) }})</span>
                    </a>
                    @foreach(['Manager', 'Expeditor', 'Supplier'] as $role)
                        <a href="{{ route('users.index', array_merge(request()->except('page'), ['role' => $role])) }}"
                           class="px-3 py-1 rounded-full border text-sm font-semibold transition {{ (isset($roleFilter) && $roleFilter === $role) ? 'bg-[#01426a] text-white border-[#01426a]' : 'bg-white text-[#01426a] border-[#01426a]' }}">
                            {{ $role }} <span class="ml-1 text-xs font-normal">({{ $roleCounts[$role] ?? 0 }})</span>
                        </a>
                    @endforeach
                </div>
                @if(session('success'))
                    <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
                @endif
                <div class="overflow-x-auto">
                    <table class="min-w-[900px] w-full border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                        <thead class="bg-gradient-to-r from-indigo-100 to-white">
                            <tr>
                                <th class="py-3 px-4 border-b text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Sr. No</th>
                                <th class="py-3 px-4 border-b text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Name</th>
                                <th class="py-3 px-4 border-b text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Email</th>
                                <th class="py-3 px-4 border-b text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Phone No.</th>
                                <th class="py-3 px-4 border-b text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Role</th>
                                <th class="py-3 px-4 border-b text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Active</th>
                                <th class="py-3 px-4 border-b text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr class="hover:bg-indigo-50 transition">
                                    <td class="py-2 px-4 border-b text-gray-600">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                                    <td class="py-2 px-4 border-b font-medium text-gray-900">{{ $user->name }}</td>
                                    <td class="py-2 px-4 border-b text-gray-700">{{ $user->email }}</td>
                                    <td class="py-2 px-4 border-b text-gray-700">{{ $user->phone ?? '-' }}</td>
                                    <td class="py-2 px-4 border-b text-gray-700">{{ $user->role }}</td>
                                    <td class="py-2 px-4 border-b text-center">
                                        <form method="POST" action="{{ route('users.toggle', $user->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-indigo-400 transition {{ $user->is_active ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-red-100 text-red-700 hover:bg-red-200' }}">
                                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="py-2 px-4 border-b text-center">
                                        <a href="{{ route('users.edit', $user->id) }}" class="inline-block text-indigo-600 hover:text-indigo-900 font-semibold mr-2 transition">Edit</a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-block text-red-600 hover:text-red-900 font-semibold transition" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-4 px-4 text-center text-gray-500">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
