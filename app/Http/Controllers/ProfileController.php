<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();
        // If supplier, allow company fields
        if ($user->role === 'Supplier') {
            $data['company_name'] = $request->input('company_name');
            $data['company_address'] = $request->input('company_address');
            $data['contact1_name'] = $request->input('contact1_name');
            $data['contact1_position'] = $request->input('contact1_position');
            $data['contact1_mail'] = $request->input('contact1_mail');
            $data['contact1_mobile'] = $request->input('contact1_mobile');
            $data['contact1_phone'] = $request->input('contact1_phone');
            $data['contact2_name'] = $request->input('contact2_name');
            $data['contact2_position'] = $request->input('contact2_position');
            $data['contact2_mail'] = $request->input('contact2_mail');
            $data['contact2_mobile'] = $request->input('contact2_mobile');
            $data['contact2_phone'] = $request->input('contact2_phone');
        }
        $user->fill($data);
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        $user->save();
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
