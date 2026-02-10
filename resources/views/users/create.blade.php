<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New User') }}
        </h2>
    </x-slot>
    <div class="container mx-auto p-4 max-w-lg">
        <x-card>
            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="block mb-1 font-semibold" for="name">Name</label>
                    <input class="w-full border rounded px-3 py-2" type="text" name="name" id="name" value="{{ old('name') }}" required>
                    @error('name')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-semibold" for="email">Email</label>
                    <input class="w-full border rounded px-3 py-2" type="email" name="email" id="email" value="{{ old('email') }}" required>
                    @error('email')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-semibold" for="role">Role</label>
                    <select class="w-full border rounded px-3 py-2" name="role" id="role" required>
                        <option value="">Select Role</option>
                        <option value="Manager" @if(old('role')=='Manager') selected @endif>Manager</option>
                        <option value="Expeditor" @if(old('role')=='Expeditor') selected @endif>Expeditor</option>
                        <option value="Supplier" @if(old('role')=='Supplier') selected @endif>Supplier</option>
                    </select>
                    @error('role')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-semibold" for="password">Password</label>
                    <input class="w-full border rounded px-3 py-2" type="password" name="password" id="password" required>
                    @error('password')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-semibold" for="password_confirmation">Confirm Password</label>
                    <input class="w-full border rounded px-3 py-2" type="password" name="password_confirmation" id="password_confirmation" required>
                </div>
                <button class="bg-indigo-600 text-white px-4 py-2 rounded" type="submit">Create User</button>
                <a href="{{ route('users.index') }}" class="ml-2 text-indigo-600">Cancel</a>
            </form>
        </x-card>
    </div>
</x-app-layout>
