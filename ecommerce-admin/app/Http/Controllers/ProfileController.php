<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
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
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

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

    /**
     * Update basic profile information (NEW)
     */
    public function updateBasic(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->job_title = $request->job_title;
        $user->location = $request->location;

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $user->profile_picture = $path;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('success', 'Profile updated successfully!');
    }

    /**
     * Update personal information (NEW)
     */
    public function updatePersonal(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->bio = $request->bio;
        $user->save();
        
        return Redirect::route('profile.edit')->with('success', 'Personal information updated successfully!');
    }

    /**
     * Update address information (NEW)
     */
    public function updateAddress(Request $request): RedirectResponse
    {
        $request->validate([
            'country' => 'nullable|string|max:255',
            'city_state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'tax_id' => 'nullable|string|max:50',
        ]);

        $user = Auth::user();
        $user->country = $request->country;
        $user->city_state = $request->city_state;
        $user->postal_code = $request->postal_code;
        $user->tax_id = $request->tax_id;
        $user->save();

        return Redirect::route('profile.edit')->with('success', 'Address updated successfully!');
    }

    public function viewProfile(): View
    {
        $user = Auth::user();
        return view('profile.view', compact('user'));
    }
}
