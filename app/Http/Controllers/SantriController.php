<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class SantriController extends Controller
{
    public function index()
    {
        $santriRole = Role::where('name', 'Santri')->first();
        $santri = $santriRole ? $santriRole->users : collect();
        return view('admin.santri', compact('santri'));
    }
}
