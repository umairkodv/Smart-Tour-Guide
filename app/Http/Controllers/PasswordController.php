<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Models\User;

class PasswordController extends Controller
{
    public function showChangeForm()
    {
        return view('admin.changepass');
    }

    public function update(Request $request)
    {
        // $request->validate([
        //     'current_password' => ['required', 'password'],
        //     'new_password' => ['required', 'min:8', 'confirmed'],
        // ]);

        $user = Auth::user();
        $user->update(['password' => Hash::make($request->new_password)]);

        return redirect()->back()->with(['success' => 'Password changed successfully!']);
    }
}
