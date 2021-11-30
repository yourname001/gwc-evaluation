@extends('layouts.adminlte')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $class->faculty->fullname('') }}| {{ $class->course->course_code }} - {{ $class->course->title }}</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a class="btn btn-primary" href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('classes.edit', $class->id) }}" data-target="#editClass"><i class="fad fa-edit"></i> Edit</a>
                @if ($class->trashed())
                    <a class="btn btn-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('classes.restore', $class->id) }}"><i class="fad fa-download"></i> Restore</a>
                @else
                    <a class="btn btn-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('classes.destroy', $class->id) }}"><i class="fad fa-trash-alt"></i> Delete</a>
                @endif
                @if($class->is_active == 1)
                <a class="btn btn-secondary" href="{{ route('classes.index') }}"><i class="fa fa-check-circle"></i> Set as Inactive</a>
                @else
                <a class="btn btn-success" href="{{ route('classes.index') }}"><i class="fa fa-check-circle"></i> Set as Active</a>
                @endif
                <a class="btn btn-default" href="{{ route('classes.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="form-group mb-0">
                        <label class="mb-0">Section:</label>
                        {{ $class->section }}
                    </div>
                    <div class="form-group mb-0">
                        <label class="mb-0">Course:</label>
                        {{ $class->course->course_code }} - {{ $class->course->title }}
                    </div>
                    <div class="form-group mb-0">
                        <label class="mb-0">Faculty:</label>
                        {{ $class->faculty->fullname('') }}
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                {{-- <i class="fas fa-edit"></i> --}}
                                Students
                            </h3>
                        </div>
                        <div class="card-body">
                            <table id="datatable" class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        @hasrole('System Administrator')
                                        <th>ID</th>
                                        @endhasrole
                                        <th>Student ID</th>
                                        <th>First Name</th>
                                        <th>Middle Name</th>
                                        <th>Last Name</th>
                                        <th>Year Level</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($class->students as $classStudent)
                                    <tr @if($classStudent->trashed()) class="table-danger" @endif>
                                        @hasrole('System Administrator')
                                        <td>
                                            {{ $classStudent->id }}
                                        </td>
                                        @endhasrole
                                        <td>
                                            {{ $classStudent->student->student_id }}
                                        </td>
                                        <td>
                                            {{ $classStudent->student->first_name }}
                                        </td>
                                        <td>
                                            {{ $classStudent->student->middle_name }}
                                        </td>
                                        <td>
                                            {{ $classStudent->student->first_name }}
                                        </td>
                                        <td>
                                            {{ $classStudent->student->year_level }}
                                        </td>
                                        <td>
                                            @if ($classStudent->trashed())
                                                <a class="text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('class_students.restore', $classStudent->id) }}"><i class="fad fa-download fa-lg"></i></a>
                                            @else
                                                <a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('class_students.destroy', $classStudent->id) }}"><i class="fad fa-trash-alt fa-lg"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td class="text-center text-danger" colspan="8">*** EMPTY ***</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection