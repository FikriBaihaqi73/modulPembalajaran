<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Major;
use App\Models\Module;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $santriRole = Role::where('name', 'Santri')->first();
        $mentorRole = Role::where('name', 'Mentor')->first();

        $totalSantri = $santriRole ? User::where('role_id', $santriRole->id)->count() : 0;
        $totalMentor = $mentorRole ? User::where('role_id', $mentorRole->id)->count() : 0;

        // Get module counts per major
        $modulesPerMajor = Major::withCount('modules')->get();

        return view('admin.dashboard.index', compact('totalSantri', 'totalMentor', 'modulesPerMajor'));
    }
}
