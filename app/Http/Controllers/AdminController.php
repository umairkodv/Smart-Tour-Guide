<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Trip;
use App\Models\TripItinerary;

class AdminController extends Controller
{
    public function dashboard()
    {
        $total_users = User::where('user_type', '!=', 'Admin')->count();
        $tourists = User::where('user_type', '=', 'Tourist')->count();
        $drivers = User::where('user_type', '=', 'Driver')->count();
        $all = User::orderBy('id', 'desc')->where('user_type', '!=', 'Admin')->take(5)->get();
        $trips_count = Trip::all()->count();
        // dd($trips_count);
        // dd($total_users);
        return view('admin.dashboard', compact('total_users','tourists','drivers','all','trips_count'));
    }

    public function users()
    {
        $total_users = User::where('user_type', '!=', 'Admin')->count();
        $tourists = User::where('user_type', '=', 'Tourist')->count();
        $drivers = User::where('user_type', '=', 'Driver')->count();
        $all = User::orderBy('id', 'desc')->where('user_type', '!=', 'Admin')->get();
        return view('admin.users', compact('all','total_users','tourists','drivers'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->input('password')),
            ]);
        }

        return redirect()->route('admin.users')->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully');
    }

    public function all_plans()
    {
        $trips = Trip::all();
        // dd($trips);
        return view('admin.trips',compact('trips'));
    }

    public function view_trip($id)
    {

    $trip = Trip::where('id',$id)->first();
        if($trip){
            return view('admin.view_trip',compact('trip'));
        }else{
            abort(404);
        }
    }

    public function reports()
    {
        $tourists =  User::where('user_type', 'Tourist')->count();
        $drivers =  User::where('user_type', 'Driver')->count();
        $plans =  Trip::all()->count();

        return view('admin.reports', compact('tourists','drivers','plans'));
    }

}
