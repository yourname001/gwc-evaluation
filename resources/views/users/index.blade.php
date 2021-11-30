{{-- @extends('layouts.app') --}}
@extends('layouts.adminlte')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Users</h1>
            </div>
            <div class="col-md-6 text-right">
                {{-- @can('users.create')
                    <button class="btn btn-default text-primary" data-href="{{ route('users.create') }}" type="button" data-toggle="modal-ajax" data-target="#createUser"><i class="fa fa-plus"></i> Add</button>
                @endcan --}}
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-hover table-sm">
                        <thead>
                            <tr>
                                @role('System Administrator')
                                <th>ID</th>
                                @endrole
                                <th>Status</th>
                                <th>Role</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                @role('System Administrator')
                                <th class="text-center">Action</th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr @unlessrole('System Administrator') @can('users.show') data-toggle="tr-link" data-href="{{ route('users.show', $user->id) }}"  @endcan @else class="{{ $user->trashed() ? 'table-danger' : '' }}" @endunlessrole>
                            @if(Auth::user()->hasrole('System Administrator'))
                            <td>
                                {{ $user->id }}
                            </td>
                            @endif
                            <td>
                                @if($user->is_verified == 1)
                                <span class="badge badge-success">Verified</span>
                                @else
                                <span class="badge badge-warning">Under Validation</span>
                                @endif
                            </td>
                            <td>{{ $user->role->role->name }}</td>
                            <td>
                                @isset($user->student->student)
                                    {{ $user->student->student->fullname('f-m-l') }}
                                @else
                                    {{ $user->faculty->faculty->fullname('f-m-l') }}
                                @endif
                            </td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            @role('System Administrator')
                                <td class="text-center">
                                    <a href="{{ route('users.show',$user->id) }}"><i class="fad fa-file-user fa-lg"></i></a>
                                    {{-- <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#editUser" data-href="{{ route('users.edit',$user->id) }}"><i class="fad fa-edit fa-lg"></i></a> --}}
                                    @if ($user->trashed())
                                        <a class="text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('users.restore', $user->id) }}"><i class="fad fa-download fa-lg"></i></a>
                                    @else
                                        @if($user->id != 1)
                                        <a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('users.destroy', $user->id) }}"><i class="fad fa-trash-alt fa-lg"></i></a>
                                        @endif
                                    @endif
                                </td>
                            @endrole
                            </tr>
                            @endforeach
                            @if (count($users) == 0)
                            <tr>
                                <td class="text-danger text-center" colspan="6">*** Empty ***</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                {{-- <span class="justify-content-center row">{!! $users->links() !!}</span> --}}
            </div>
        </div>
    </div>
    {{-- /.container-fluid --}}
</div>
{{-- /.content --}}
@endsection
