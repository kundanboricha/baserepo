<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use App\Traits\GeneralTrait;
use Carbon\Carbon;
use Inertia\Inertia;

class IndexController extends Controller
{

    public function index()
    {
        if (auth()->check()) {
            return redirect()->route("dashboard");
        } else {
            return redirect()->route("login");
        }
    }

    public function dashboard()
    {
        return Inertia::render("Dashboard");
    }
}
