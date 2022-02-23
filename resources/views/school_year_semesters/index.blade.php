@extends('layouts.adminlte')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">School Year & Semester</h1>
            </div>
            <div class="col-sm-6 text-right">
                @can('school_year_semesters.create')
                    <button class="btn btn-default" type="button" data-toggle="modal-ajax" data-href="{{ route('school_year_semesters.create') }}" data-target="#createSchoolYearSemesters"><i class="fa fa-plus"></i> Add</button>
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
                                <th>Status</th>
                                <th>School Year</th>
                                <th>Semester</th>
                                <th>Start</th>
                                <th>End</th>
                                @role('System Administrator')
                                <th class="text-center">Action</th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schoolYearSemesters as $schoolYearSemester)
                                <tr @unlessrole('System Administrator') @can('school_year_semesters.show') data-toggle="tr-link" data-href="{{ route('school_year_semesters.show', $schoolYearSemester->id) }}"  @endcan @else class="{{ $schoolYearSemester->trashed() ? 'table-danger' : '' }}" @endunlessrole>
                                    <td>
                                        {!! $schoolYearSemester->getStatusBadge() !!}
                                    </td>
                                    <td>{{ $schoolYearSemester->school_year }}</td>
                                    <td>{{ $schoolYearSemester->getSemester() }}</td>
                                    <td>{{ date('F d, Y', strtotime($schoolYearSemester->start_date)) }}</td>
                                    <td>{{ date('F d, Y', strtotime($schoolYearSemester->end_date)) }}</td>
                                    @role('System Administrator')
                                        <td class="text-center">
                                            <a href="{{ route('school_year_semesters.show',$schoolYearSemester->id) }}"><i class="fad fa-file fa-lg"></i></a>
                                            {{-- <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#editSchoolYearSemesters" data-href="{{ route('school_year_semesters.edit',$schoolYearSemester->id) }}"><i class="fad fa-edit fa-lg"></i></a> --}}
                                            @if ($schoolYearSemester->trashed())
                                                <a class="text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('school_year_semesters.restore', $schoolYearSemester->id) }}"><i class="fad fa-download fa-lg"></i></a>
                                            @else
                                                <a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('school_year_semesters.destroy', $schoolYearSemester->id) }}"><i class="fad fa-trash-alt fa-lg"></i></a>
                                            @endif
                                        </td>
                                    @endrole
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection