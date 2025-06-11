<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class MentorController extends Controller
{
    public function index()
    {
        $mentorRole = Role::where('name', 'Mentor')->first();
        $mentor = $mentorRole ? $mentorRole->users : collect();
        return view('admin.mentor', compact('mentor'));
    }
}
