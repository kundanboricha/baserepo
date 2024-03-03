<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\CantBeSameAsOldPassword;
use App\Traits\GeneralTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    use GeneralTrait;
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        try {
            return Inertia::render('Profile/Edit', [
                'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
                'status' => session('status'),
            ]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with(['status' => "error", 'message' => "An error occurred."]);
        }
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "name" => ["required", "max:200"],
            "email" => ["required", 'email', Rule::unique(User::class)->ignore(auth()->user()->id)],
            "password" => ["nullable", "min:8", new CantBeSameAsOldPassword],
            "confirmPassword" => "same:password",
        ]);

        try {

            $user = User::find(auth()->user()->id);

            if (!$user) {
                return redirect()->route('profile.edit')->with(["status" => "error", "message" => "User not found."]);
            }

            $user->name = $request->name;
            $user->email = $request->email;

            if (!empty($request->password)) {
                $user->old_password = $user->password;
                $user->password = Hash::make($request->password);
            }

            if (!empty($request->image)) {
                if ($user->image != 'default.png') {
                    $this->deleteImageFromStorage('public/profiles/' . $user->image);
                }
                $user->image = $this->uploadBase64Image('profiles/', $request->image, 1920, 1440);
            }

            $user->save();

            return redirect()->route('profile.edit')->with(["status" => "success", "message" => "Profile Updated Successfully"]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->route('profile.edit')->with(['status' => "error", 'message' => "An error occurred."]);
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        try {

            $user = $request->user();

            if (!$user) {
                return redirect()->route('home')->with(["status" => "error", "message" => "User not found."]);
            }

            Auth::logout();

            $user->delete();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('home')->with(["status" => "success", "message" => "Account deleted successfully."]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->route('home')->with(['status' => "error", 'message' => "An error occurred."]);
        }
    }
}
