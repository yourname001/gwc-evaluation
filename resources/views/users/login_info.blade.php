@extends('layouts.adminlte')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Login logs</h1>
            </div>
            <div class="col-sm-6 text-right">
                @can('questions.create')
                    <button class="btn btn-default" type="button" data-toggle="modal-ajax" data-href="{{ route('questions.create') }}" data-target="#createQuestion"><i class="fa fa-plus"></i> Add</button>
                @endcan
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <table class="table table-bordered table-hover table-sm datatable">
                    <thead>
                        <tr>
                            <th>Activity</th>
                            <th>User</th>
                            <th>Date</th>
                            <th>Username</th>
                            {{-- <th>IP Address</th> --}}
                            <th>Device</th>
                            <th>Platform</th>
                            <th>Browser</th>
                            <th>Remarks</th>
                            {{-- @if(Auth::user()->hasrole('System Administrator'))
                            <th class="text-center">Action</th>
                            @endif --}}
                        </tr>
                    </thead>
                    <tbody>						
                        @forelse ($loginInfos as $loginInfo)
                        <tr>
                            <td>{{ $loginInfo->activity }}</td>
                            <td>{{ $loginInfo->user ? $loginInfo->user->userInfo()->fullname('') : "N/A" }}</td>
                            <td>{{ date('M d, Y h:i A', strtotime($loginInfo->created_at)) }}</td>
                            <td>{{ $loginInfo->username }}</td>
                            {{-- <td>{{ $loginInfo->ip_address }}</td> --}}
                            <td>{{ $loginInfo->device }}</td>
                            <td>{{ $loginInfo->platform }}</td>
                            <td>{{ $loginInfo->browser }}</td>
                            <td>{{ $loginInfo->status }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-danger text-center" colspan="10">*** Empty ***</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

@endsection