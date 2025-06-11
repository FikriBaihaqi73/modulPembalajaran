<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class AdminController extends Controller
{
    public function index()
    {
        $santriRole = Role::where('name', 'Santri')->first();
        $mentorRole = Role::where('name', 'Mentor')->first();

        $totalSantri = $santriRole ? User::where('role_id', $santriRole->id)->count() : 0;
        $totalMentor = $mentorRole ? User::where('role_id', $mentorRole->id)->count() : 0;

        return view('admin.dashboard', compact('totalSantri', 'totalMentor'));
    }
}
