@extends('layouts.adminlte')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Departments</h1>
            </div>
            <div class="col-sm-6 text-right">
                @can('departments.create')
                    <button class="btn btn-default" type="button" data-toggle="modal-ajax" data-href="{{ route('departments.create') }}" data-target="#createDepartment"><i class="fa fa-plus"></i> Add</button>
                @endcan
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <table id="datatable" class="table table-sm table-bordered table-hover">
                        <thead>
                            <tr>
                                @role('System Administrator')
                                <th>ID</th>
                                @endrole
                                <th>Name</th>
                                @role('System Administrator')
                                <th class="text-center">Action</th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($departments as $department)
                            <tr @unlessrole('System Administrator') @can('departments.show') data-toggle="modal-ajax" data-target="#showDepartment" data-href="{{ route('departments.show', $department->id) }}"  @endcan @else class="{{ $department->trashed() ? 'table-danger' : '' }}" @endunlessrole>
                                @role('System Administrator')
                                <td>{{ $department->id }}</td>
                                @endrole
                                <td>{{ $department->name }}</td>
                                @role('System Administrator')
                                    <td class="text-center">
                                        <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#showDepartment" data-href="{{ route('departments.show',$department->id) }}"><i class="fad fa-file fa-lg"></i></a>
                                        {{-- <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#editDepartment" data-href="{{ route('departments.edit',$department->id) }}"><i class="fad fa-edit fa-lg"></i></a> --}}
                                        @if ($department->trashed())
                                            <a class="text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('departments.restore', $department->id) }}"><i class="fad fa-download fa-lg"></i></a>
                                        @else
                                            <a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('departments.destroy', $department->id) }}"><i class="fad fa-trash-alt fa-lg"></i></a>
                                        @endif
                                    </td>
                                @endrole
                            </tr>
                            @empty
                            {{-- <tr>
                                <td class="text-center text-danger" colspan="8">*** EMPTY ***</td>
                            </tr> --}}
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection