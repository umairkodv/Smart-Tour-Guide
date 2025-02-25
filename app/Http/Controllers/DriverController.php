<?php

namespace App\Http\Controllers;
use App\Models\Trip;
use App\Models\TripItinerary;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user()->id;
        $t_rides = TripItinerary::where('key', 'driver')->where('value', $user)->count();
        $rides = TripItinerary::where('key', 'driver')->where('value', $user)->get();

        $trips = []; // Initialize an empty array to store trips
        $accepted_trips = [];
        $rejected_trips = [];

        foreach ($rides as $rd) {
            $trip = Trip::where('id', $rd->trip_id)->where('status_by_driver', 'pending')->first();

            if ($trip) {
                $trips[] = $trip;
            }
        }
        $numberOfReq = count($trips);

        foreach ($rides as $rn) {
            $accepted_trip = Trip::where('id', $rn->trip_id)->where('status_by_driver', 'accepted')->first();

            if ($accepted_trip) {
                $accepted_trips[] = $accepted_trip;
            }
        }
        $numberOfAccept = count($accepted_trips);

        foreach ($rides as $rd) {
            $rejected_trip = Trip::where('id', $rd->trip_id)->where('status_by_driver', 'accepted')->first();

            if ($rejected_trip) {
                $rejected_trips[] = $rejected_trip;
            }
        }
        $numberOfReject = count($rejected_trips);

        return view('driver.dashboard', compact('numberOfReq','numberOfAccept','numberOfReject','t_rides', 'trips','accepted_trips', 'rejected_trips'));
    }

    public function accept($id){
        $trip = Trip::find($id);
        $trip->status_by_driver = 'accepted';
        $trip->save();

        return redirect()->back()->with('success', 'Trip Accepted');
    }

    public function reject($id){

        $trip = Trip::find($id);
        $trip->status_by_driver = 'rejected';
        $trip->save();

        return redirect()->back()->with('success', 'Trip Rejected');

    }

}
