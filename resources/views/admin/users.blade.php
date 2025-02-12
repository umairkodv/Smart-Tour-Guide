@extends('layout.adminmaster')
@section('title', 'Admin Users')
@section('content')

<div class="db-info-wrap">
    <div class="row">
        <!-- Item -->
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
    <div class="row mt-3">
        <div class="col-lg-12 mt-5">
            <div class="dashboard-box table-opp-color-box">
                <h4>All Users</h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>User Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i=1;
                            @endphp
                            @foreach ($all as $all)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td><a href="#"><span class="list-name">{{ $all->name }}</span><span class="list-enq-city">Pakistan</span></a>
                                </td>
                                <td>{{ $all->email }}</td>
                                <td>
                                    <span class="badge badge-dark">{{ $all->user_type }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('users.edit', $all->id) }}" class="btn btn-secondary">Edit</a>
                                    <form action="{{ route('users.destroy', $all->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>



</div>

@endsection
