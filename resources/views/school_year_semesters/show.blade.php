@extends('layouts.adminlte')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">S.Y. {{ $schoolYearSemester->school_year }} - {{ $schoolYearSemester->getSemester() }}</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a class="btn btn-primary" href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('school_year_semesters.edit', $schoolYearSemester->id) }}" data-target="#editSchoolYearSemester"><i class="fad fa-edit"></i> Edit</a>
                @if ($schoolYearSemester->trashed())
                    <a class="btn btn-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('school_year_semesters.restore', $schoolYearSemester->id) }}"><i class="fad fa-download"></i> Restore</a>
                @else
                    <a class="btn btn-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('school_year_semesters.destroy', $schoolYearSemester->id) }}"><i class="fad fa-trash-alt"></i> Delete</a>
                @endif
                <a class="btn btn-default" href="{{ route('school_year_semesters.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="form-group mb-0">
                        <label class="mb-0">Status:</label>
                        {!! $schoolYearSemester->getStatusBadge() !!}
                    </div>
                    <div class="form-group mb-0">
                        <label class="mb-0">School Year:</label>
                        {{ $schoolYearSemester->school_year }}
                    </div>
                    <div class="form-group mb-0">
                        <label class="mb-0">Semester:</label>
                        {{ $schoolYearSemester->getSemester() }}
                    </div>
                    <div class="form-group mb-0">
                        <label class="mb-0">Start Date:</label>
                        {{ date('F d, Y', strtotime($schoolYearSemester->start_date)) }}
                    </div>
                    <div class="form-group mb-0">
                        <label class="mb-0">End Date:</label>
                        {{ date('F d, Y', strtotime($schoolYearSemester->end_date)) }}
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                Classes
                            </h3>
                        </div>
                        <div class="card-body">
                            <table id="datatable" class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Section</th>
                                        <th>Course</th>
                                        <th>Faculty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($schoolYearSemester->classes as $class)
                                    <tr @if($class->trashed()) class="table-danger" @endif>
                                        <td>
                                            {{ $class->section }}
                                        </td>
                                        <td>
                                            {{ $class->subject->subject_code }} -
                                            {{ $class->subject->title }}
                                        </td>
                                        <td>
                                            {{ $class->faculty->fullname('') }}
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