<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\TripItinerary;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\TripComment;


class TouristController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $trips = $user->trips;
        $mytrip_count = $user->trips->count();

        // dd($mytrip_count);
        return view('tourist.dashboard', compact('trips','mytrip_count'));
    }

    public function add_comment(Request $request)
    {
        // dd($request->trip_id);

        $trip = new TripComment();
        $trip->trip_id = $request->trip_id;
        $trip->user_id = Auth::user()->id;
        $trip->comment = $request->comment;
        $trip->save();

        if($trip)
        {
            return redirect()
            ->back()
            ->with('success', 'Comment Added!');

        }else
        {
            return redirect()
            ->back()
            ->with('error', 'Something went wrong!');
        }

    }
}
