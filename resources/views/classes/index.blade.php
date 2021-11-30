@extends('layouts.adminlte')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Classes</h1>
            </div>
            <div class="col-sm-6 text-right">
                @can('classes.create')
                    <button class="btn btn-default" type="button" data-toggle="modal-ajax" data-href="{{ route('classes.create') }}" data-target="#createClass"><i class="fa fa-plus"></i> Add</button>
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
                                <th>Course</th>
                                <th>Faculty</th>
                                <th>Students</th>
                                {{-- <th>Schedule</th> --}}
                                {{-- <th>School Year</th> --}}
                                @role('System Administrator')
                                <th class="text-center">Action</th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($classes as $class)
                            <tr @unlessrole('System Administrator') @can('classes.show') data-toggle="tr-link" data-href="{{ route('classes.show', $class->id) }}"  @endcan @else class="{{ $class->trashed() ? 'table-danger' : '' }}" @endunlessrole>
                                @role('System Administrator')
                                <td>{{ $class->id }}</td>
                                @endrole
                                <td>
                                    {{ $class->course->course_code }} -
                                    {{ $class->course->title }}
                                </td>
                                <td>{{ $class->faculty->fullname('') }}</td>
                                <td>
                                    @forelse($class->students as $student)
                                    {{ $student->student->fullname('') }}@if(!$loop->last), @endif
                                    @empty
                                    *** EMPTY ***
                                    @endforelse
                                </td>
                                {{-- <td>{{ date('F d, Y h:iA', strtotime($class->schedule)) }}</td> --}}
                                {{-- <td>{{ $class->school_year }}</td> --}}
                                @role('System Administrator')
                                    <td class="text-center">
                                        <a href="{{ route('classes.show',$class->id) }}"><i class="fad fa-file fa-lg"></i></a>
                                        {{-- <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#editClasse" data-href="{{ route('classes.edit',$classe->id) }}"><i class="fad fa-edit fa-lg"></i></a> --}}
                                        @if ($class->trashed())
                                            <a class="text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('classes.restore', $class->id) }}"><i class="fad fa-download fa-lg"></i></a>
                                        @else
                                            <a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('classes.destroy', $class->id) }}"><i class="fad fa-trash-alt fa-lg"></i></a>
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