<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Module;
use App\Models\ModuleCategory;
use App\Models\User;
use App\Models\Role;

class DashboardController extends Controller
{
    public function index()
    {
        $mentor = Auth::user();
        $majorId = $mentor->major_id;

        // Total Modules created by this mentor
        $totalModules = Module::where('major_id', $majorId)->count();

        // Total Module Categories for this mentor's major
        $totalModuleCategories = ModuleCategory::where('major_id', $majorId)->count();

        // Total Santri for this mentor's major
        $santriRole = Role::where('name', 'Santri')->first();
        $totalSantri = User::where('role_id', $santriRole->id)
                             ->where('major_id', $majorId)
                             ->count();

        return view('mentor.dashboard', compact('totalModules', 'totalModuleCategories', 'totalSantri'));
    }
}
