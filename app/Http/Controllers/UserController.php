<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function toggle($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();
        return redirect()->route('users.index')->with('success', 'User status updated.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        // If only password fields are filled, validate and update password only
        if ($request->filled('password') && !$request->filled('name') && !$request->filled('email') && !$request->filled('role')) {
            $request->validate([
                'password' => 'string|min:8|confirmed',
            ]);
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->route('users.edit', $user->id)->with('status', 'password-updated');
        }
        // Otherwise, validate all fields as before
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:Manager,Expeditor,Supplier',
        ];
        if ($request->role === 'Supplier') {
            $rules['company_name'] = 'nullable|string|max:255';
            $rules['company_address'] = 'nullable|string|max:255';
            $rules['contact1_name'] = 'nullable|string|max:255';
            $rules['contact1_position'] = 'nullable|string|max:255';
            $rules['contact1_mail'] = 'nullable|email|max:255';
            $rules['contact1_mobile'] = 'nullable|string|max:50';
            $rules['contact1_phone'] = 'nullable|string|max:50';
            $rules['contact2_name'] = 'nullable|string|max:255';
            $rules['contact2_position'] = 'nullable|string|max:255';
            $rules['contact2_mail'] = 'nullable|email|max:255';
            $rules['contact2_mobile'] = 'nullable|string|max:50';
            $rules['contact2_phone'] = 'nullable|string|max:50';
        }
        if ($request->filled('password')) {
            $rules['password'] = 'string|min:8|confirmed';
        }
        $validated = $request->validate($rules);
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }
        if ($request->role !== 'Supplier') {
            unset($validated['company_name'], $validated['company_address'],
                $validated['contact1_name'], $validated['contact1_position'], $validated['contact1_mail'], $validated['contact1_mobile'], $validated['contact1_phone'],
                $validated['contact2_name'], $validated['contact2_position'], $validated['contact2_mail'], $validated['contact2_mobile'], $validated['contact2_phone']);
        }
        $user->update($validated);
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function index()
    {
        $roleFilter = request('role');
        $query = User::query();
        if ($roleFilter && in_array($roleFilter, ['Manager', 'Expeditor', 'Supplier'])) {
            $query->where('role', $roleFilter);
        }
        $users = $query->orderByDesc('created_at')->paginate(20)->withQueryString();
        // Get role counts
        $roleCounts = User::selectRaw('role, COUNT(*) as count')
            ->groupBy('role')
            ->pluck('count', 'role');
        return view('users.index', compact('users', 'roleCounts', 'roleFilter'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:Manager,Expeditor,Supplier',
        ];
        if ($request->role === 'Supplier') {
            $rules['company_name'] = 'nullable|string|max:255';
            $rules['company_address'] = 'nullable|string|max:255';
            $rules['contact1_name'] = 'nullable|string|max:255';
            $rules['contact1_position'] = 'nullable|string|max:255';
            $rules['contact1_mail'] = 'nullable|email|max:255';
            $rules['contact1_mobile'] = 'nullable|string|max:50';
            $rules['contact1_phone'] = 'nullable|string|max:50';
            $rules['contact2_name'] = 'nullable|string|max:255';
            $rules['contact2_position'] = 'nullable|string|max:255';
            $rules['contact2_mail'] = 'nullable|email|max:255';
            $rules['contact2_mobile'] = 'nullable|string|max:50';
            $rules['contact2_phone'] = 'nullable|string|max:50';
        }
        $validated = $request->validate($rules);
        $validated['password'] = Hash::make($request->password);
        $validated['is_active'] = true;
        // Only allow company fields for supplier
        if ($request->role !== 'Supplier') {
            unset($validated['company_name'], $validated['company_address'],
                $validated['contact1_name'], $validated['contact1_position'], $validated['contact1_mail'], $validated['contact1_mobile'], $validated['contact1_phone'],
                $validated['contact2_name'], $validated['contact2_position'], $validated['contact2_mail'], $validated['contact2_mobile'], $validated['contact2_phone']);
        }
        User::create($validated);
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }
}
