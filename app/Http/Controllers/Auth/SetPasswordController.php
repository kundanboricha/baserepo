<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\CantBeSameAsOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class SetPasswordController extends Controller
{
    public function show($ulid)
    {
        $user = User::where('ulid', $ulid)->first();
        $props = [
            "user" => $user,
        ];
        return Inertia::render("Auth/ConfirmPassword", $props);
    }

    public function setPassword(Request $request)
    {
        $request->validate([
            "password" => ["required", "min:8", "max:50", new CantBeSameAsOldPassword],
            "confirmPassword" => "required|same:password",
            "email" => "required|email",
        ]);

        $user = User::where('email', $request->email)->first();

        $user->password = Hash::make($request->password);
        $user->old_password = $user->password;
        $user->email_verified_at = now();
        $user->save();

        return redirect()->route('index')->with(['status' => "success", "message" => "Password set successfully"]);

    }
}
