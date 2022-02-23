@extends('layouts.adminlte')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Subjects</h1>
            </div>
            <div class="col-sm-6 text-right">
                @can('subjects.create')
                    <button class="btn btn-default" type="button" data-toggle="modal-ajax" data-href="{{ route('subjects.create') }}" data-target="#createSubject"><i class="fa fa-plus"></i> Add</button>
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
                                <th>Subject Code</th>
                                <th>Title</th>
                                <th>Description</th>
                                @role('System Administrator')
                                <th class="text-center">Action</th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($subjects as $subject)
                            <tr @unlessrole('System Administrator') @can('subjects.show') data-toggle="modal-ajax" data-target="#showSubject" data-href="{{ route('subjects.show', $subject->id) }}"  @endcan @else class="{{ $subject->trashed() ? 'table-danger' : '' }}" @endunlessrole>
                                @role('System Administrator')
                                <td>{{ $subject->id }}</td>
                                @endrole
                                <td>{{ $subject->subject_code }}</td>
                                <td>{{ $subject->title }}</td>
                                <td>{{ $subject->description }}</td>
                                @role('System Administrator')
                                    <td class="text-center">
                                        <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#showSubject" data-href="{{ route('subjects.show',$subject->id) }}"><i class="fad fa-file fa-lg"></i></a>
                                        {{-- <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#editClasse" data-href="{{ route('subjects.edit',$subject->id) }}"><i class="fad fa-edit fa-lg"></i></a> --}}
                                        @if ($subject->trashed())
                                            <a class="text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('subjects.restore', $subject->id) }}"><i class="fad fa-download fa-lg"></i></a>
                                        @else
                                            <a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('subjects.destroy', $subject->id) }}"><i class="fad fa-trash-alt fa-lg"></i></a>
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