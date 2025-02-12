@extends('layout.adminmaster')
@section('title', 'Admin Dashboard')
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
                    <h4>Total Tours Plans</h4>
                    <h5>{{ $trips_count }}</h5>
                </div>
            </div>
        </div>
        <!-- Item -->
        <div class="col-xl-3 col-sm-6">
            <div class="db-info-list">
                <div class="dashboard-stat-icon bg-green">
                    <i class="fas fa-users"></i>
                </div>
                <div class="dashboard-stat-content">
                    <h4>Total Users</h4>
                    <h5>{{ $total_users }}</h5>
                </div>
            </div>
        </div>
        <!-- Item -->
        <div class="col-xl-3 col-sm-6">
            <div class="db-info-list">
                <div class="dashboard-stat-icon bg-purple">
                    <i class="fas fa-users"></i>
                </div>
                <div class="dashboard-stat-content">
                    <h4>Tourists</h4>
                    <h5>{{ $tourists }}</h5>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="db-info-list">
                <div class="dashboard-stat-icon bg-red">
                    <i class="fas fa-users"></i>
                </div>
                <div class="dashboard-stat-content">
                    <h4>Drivers</h4>
                    <h5>{{ $drivers }}</h5>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-lg-6">
            <div class="dashboard-box table-opp-color-box">
                <h4>Recent Created Plans</h4>
                <p>Tourist spots, tourist, tour plans by</p>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Select</th>
                                <th>User</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>City</th>
                                <th>Enquiry</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <label class="custom-input"><input type="checkbox" checked="checked">
                                    <span class="custom-input-field"></span></label>
                                </td>
                                <td><span class="list-img"><img src="{{ asset('assets2/images/comment.jpg') }}" alt=""></span>
                                </td>
                                <td><span class="list-enq-name">John Doe</span>
                                </td>
                                <td>12 may</td>
                                <td>Japan</td>
                                <td>
                                    <span class="badge badge-success">15</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="custom-input"><input type="checkbox" checked="checked">
                                    <span class="custom-input-field"></span></label>
                                </td>
                                <td><span class="list-img"><img src="{{ asset('assets2/images/comment2.jpg') }}" alt=""></span>
                                </td>
                                <td><span class="list-enq-name">John Doe</span>
                                </td>
                                <td>12 may</td>
                                <td>Japan</td>
                                <td>
                                    <span class="badge badge-success">15</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="custom-input"><input type="checkbox" checked="checked">
                                    <span class="custom-input-field"></span></label>
                                </td>
                                <td><span class="list-img"><img src="{{ asset('assets2/images/comment3.jpg') }}" alt=""></span>
                                </td>
                                <td><span class="list-enq-name">John Doe</span>
                                </td>
                                <td>12 may</td>
                                <td>Japan</td>
                                <td>
                                    <span class="badge badge-success">15</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="custom-input"><input type="checkbox" checked="checked">
                                    <span class="custom-input-field"></span></label>
                                </td>
                                <td><span class="list-img"><img src="{{ asset('assets2/images/comment4.jpg') }}" alt=""></span>
                                </td>
                                <td><span class="list-enq-name">John Doe</span>
                                </td>
                                <td>12 may</td>
                                <td>Japan</td>
                                <td>
                                    <span class="badge badge-success">15</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="custom-input"><input type="checkbox" checked="checked">
                                    <span class="custom-input-field"></span></label>
                                </td>
                                <td><span class="list-img"><img src="{{ asset('assets2/images/comment5.jpg') }}" alt=""></span>
                                </td>
                                <td><span class="list-enq-name">John Doe</span>
                                </td>
                                <td>12 may</td>
                                <td>Japan</td>
                                <td>
                                    <span class="badge badge-success">15</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="dashboard-box table-opp-color-box">
                <h4>Older Created Plans</h4>
                <p>Tourist spots, tourist, tour plans by</p>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Select</th>
                                <th>User</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>City</th>
                                <th>Enquiry</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <label class="custom-input"><input type="checkbox">
                                    <span class="custom-input-field"></span></label>
                                </td>
                                <td><span class="list-img"><img src="{{ asset('assets2/images/comment.jpg') }}" alt=""></span>
                                </td>
                                <td><span class="list-enq-name">John Doe</span>
                                </td>
                                <td>12 may</td>
                                <td>Japan</td>
                                <td>
                                    <span class="badge badge-success">15</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="custom-input"><input type="checkbox">
                                    <span class="custom-input-field"></span></label>
                                </td>
                                <td><span class="list-img"><img src="{{ asset('assets2/images/comment2.jpg') }}" alt=""></span>
                                </td>
                                <td><span class="list-enq-name">John Doe</span>
                                </td>
                                <td>12 may</td>
                                <td>Japan</td>
                                <td>
                                    <span class="badge badge-success">15</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="custom-input"><input type="checkbox">
                                    <span class="custom-input-field"></span></label>
                                </td>
                                <td><span class="list-img"><img src="{{ asset('assets2/images/comment3.jpg') }}" alt=""></span>
                                </td>
                                <td><span class="list-enq-name">John Doe</span>
                                </td>
                                <td>12 may</td>
                                <td>Japan</td>
                                <td>
                                    <span class="badge badge-success">15</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="custom-input"><input type="checkbox">
                                    <span class="custom-input-field"></span></label>
                                </td>
                                <td><span class="list-img"><img src="{{ asset('assets2/images/comment4.jpg') }}" alt=""></span>
                                </td>
                                <td><span class="list-enq-name">John Doe</span>
                                </td>
                                <td>12 may</td>
                                <td>Japan</td>
                                <td>
                                    <span class="badge badge-success">15</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="custom-input"><input type="checkbox">
                                    <span class="custom-input-field"></span></label>
                                </td>
                                <td><span class="list-img"><img src="{{ asset('assets2/images/comment5.jpg') }}" alt=""></span>
                                </td>
                                <td><span class="list-enq-name">John Doe</span>
                                </td>
                                <td>12 may</td>
                                <td>Japan</td>
                                <td>
                                    <span class="badge badge-success">15</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="dashboard-box">
                <h4>All User</h4>
                <p>All user including drivers and tourists.</p>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                {{-- <th>Phone</th> --}}
                                <th>Email</th>
                                <th>User Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($all as $all)
                            <tr>
                                <td><a href="#"><span class="list-name">{{ $all->name }}</span><span class="list-enq-city">Pakistan</span></a>
                                </td>
                                {{-- <td>+01 3214 6522</td> --}}
                                <td>{{ $all->email }}</td>
                                <td>
                                    <span class="badge badge-dark">{{ $all->user_type }}</span>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <td>
                                    <a href="{{ route('admin.users') }}" class="btn btn-primary">View All Users</a>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection
