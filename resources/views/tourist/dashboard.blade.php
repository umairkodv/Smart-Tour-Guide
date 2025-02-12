@extends('layout.tourist_master')
@section('title', 'Tourist Dashboard')
@section('content')

<div class="db-info-wrap">
    <div class="row">
        <!-- Item -->
        <div class="col-xl-3 col-sm-6">
            <div class="db-info-list">
                <div class="dashboard-stat-icon bg-blue">
                    <i class="far fa-chart-bar"></i>
                </div>
                <div class="dashboard-stat-content">
                    <h4>Total Plans</h4>
                    <h5>{{ $mytrip_count }}</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="dashboard-box">
                <h4>My Tour Plans</h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Destination</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trips as $trip)
                            <tr>
                                <td>{{$trip->destination}}</td>
                                <td>{{$trip->start_date}}</td>
                                <td>{{$trip->end_date}}</td>
                                <td>
                                    <a href="{{ route('view_trip', ['id'=>$trip->id]) }}" class="btn btn-primary btn-sm text-white"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('edit_trip', ['id'=>$trip->id]) }}" class="btn btn-primary btn-sm text-white"><i class="fas fa-edit"></i></a>
                                    <a href="#0" class="btn btn-danger btn-sm text-white delete_trip1" data-id="{{$trip->id}}" data-url="{{ route('delete_trip', ['id'=>$trip->id]) }}"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
            <div class="col-lg-12">
                <div class="dashboard-box chart-box">
                <h4>Bar Chart</h4>
                <div id="barchart" style="height: 250px; width: 100%;"></div>
                </div>
            </div>
    </div>
</div>

@endsection
