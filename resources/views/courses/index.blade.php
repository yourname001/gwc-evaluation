@extends('layouts.adminlte')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Classes</h1>
            </div>
            <div class="col-sm-6 text-right">
                @can('courses.create')
                    <button class="btn btn-default" type="button" data-toggle="modal-ajax" data-href="{{ route('courses.create') }}" data-target="#createCourse"><i class="fa fa-plus"></i> Add</button>
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
                                <th>Course Code</th>
                                <th>Title</th>
                                <th>Description</th>
                                @role('System Administrator')
                                <th class="text-center">Action</th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($courses as $course)
                            <tr @unlessrole('System Administrator') @can('courses.show') data-toggle="modal-ajax" data-target="#showCourse" data-href="{{ route('courses.show', $course->id) }}"  @endcan @else class="{{ $course->trashed() ? 'table-danger' : '' }}" @endunlessrole>
                                @role('System Administrator')
                                <td>{{ $course->id }}</td>
                                @endrole
                                <td>{{ $course->course_code }}</td>
                                <td>{{ $course->title }}</td>
                                <td>{{ $course->description }}</td>
                                @role('System Administrator')
                                    <td class="text-center">
                                        <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#showCourse" data-href="{{ route('courses.show',$course->id) }}"><i class="fad fa-file fa-lg"></i></a>
                                        {{-- <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#editClasse" data-href="{{ route('courses.edit',$course->id) }}"><i class="fad fa-edit fa-lg"></i></a> --}}
                                        @if ($course->trashed())
                                            <a class="text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('courses.restore', $course->id) }}"><i class="fad fa-download fa-lg"></i></a>
                                        @else
                                            <a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('courses.destroy', $course->id) }}"><i class="fad fa-trash-alt fa-lg"></i></a>
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