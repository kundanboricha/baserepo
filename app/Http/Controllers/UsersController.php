<?php

namespace App\Http\Controllers;

use App\Jobs\sendSetPasswordMailJob;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class UsersController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            "name" => "max:100",
            "email" => "max:100",
            "status" => "in:1,2",
        ]);
        
        try {
            $per_page = $request->per_page ?? 10;
            $users = User::select('*')->where('role', '!=', 1);

            if (!empty($request->name)) {
                $users = $users->where("name", "LIKE", "%{$request->name}%");
            }
            if (!empty($request->email)) {
                $users = $users->where("email", "LIKE", "%{$request->email}%");
            }
            if (!empty($request->status)) {
                $users = $users->where("status", $request->status);
            }
            if (!empty($request->role)) {
                $users = $users->where("role", $request->role);
            }
            if (!empty($request->sortAs) && !empty($request->orderBy)) {
                $users = $users->orderBy($request->orderBy, $request->sortAs);
            } else {
                $users = $users->latest();
            }

            $users = $users->paginate($per_page);

            $statistics = [
                "totalUsers" => User::where('role', '!=', 1)->count(),
                "inActiveUsers" => User::select('*')->where('role', '!=', 1)->where("status", 2)->count(),
                "activeUsers" => User::select('*')->where('role', '!=', 1)->where("status", 1)->count(),
                "defaultImageUsers" => User::select('*')->where('role', '!=', 1)->where('image', "default.png")->count(),
            ];

            $props = [
                "users" => $users,
                "searchedData" => $request->all(),
                "statistics" => $statistics,
            ];

            return Inertia::render("Users/Index", $props);
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with(['status' => "error", "message" => "an Error Occured"]);
             }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return Inertia::render("Users/Create");
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with(['status' => "error", "message" => "an Error Occured"]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            "name" => "required|max:200",
            "email" => ["required", 'email', Rule::unique(User::class, 'email')->ignore($request->id)],
            "image" => "nullable",
            "role" => "required|in:1,2",
        ]);
        try {
            $user = new User();
            $user->ulid = Str::ulid();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;

            if (!empty($request->image)) {
                $user->image = $this->uploadBase64Image('profiles/', $request->image, 1920, 1440);
            } else {
                $user->image = "default.png";
            }
            $user->save();

            $mailData = [
                "email" => $user->email,
                "user" => $user,
                "url" => route('page.password', $user->ulid),
            ];
            $sendMail = new sendSetPasswordMailJob($mailData);
            $sendMail->dispatch($mailData);

            return redirect()->route("users.index")->with(["status" => "success", "message" => "User Added successfully"]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with(['status' => "error", "message" => "an Error Occured"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $user = User::where("ulid",  $id)->first();
            return Inertia::render("Users/Edit", ["user" => $user]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with(['status' => "error", "message" => "an Error Occured"]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "name" => "required|max:200",
            "email" => ["required", 'email', Rule::unique(User::class)->ignore($request->id)],
            "password" => "nullable|min:8",
            "confirmPassword" => "required|same:password",
            "image" => "nullable",
        ]);

        try {
            $user = User::find($request->id);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->status = $request->status;

            if (!empty($request->password)) {
                $user->password = Hash::make($request->password);
            }

            if (!empty($request->file("image"))) {
                $user->image = uploadImage($request, $request->name);
            }
            $user->save();
            return redirect()->route("users.index")->with(["status" => "success", "message" => "User updated successfully"]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with(['status' => "error", "message" => "an Error Occured"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            User::where('ulid', $id)->first()->delete();
            return redirect()->route('users.index')->with(["status" => "success", "message" => "User Deleted!"]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with(['status' => "error", "message" => "an Error Occured"]);
        }
    }
}
