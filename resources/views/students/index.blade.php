@extends('layouts.adminlte')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Students</h1>
            </div>
            <div class="col-sm-6 text-right">
                @can('students.create')
                    <button class="btn btn-default" type="button" data-toggle="modal-ajax" data-href="{{ route('students.create') }}" data-target="#createStudent"><i class="fa fa-plus"></i> Add</button>
                @endcan
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card card-primary card-outline card-tabs">
                    <div class="card-header p-0 pt-1 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                            @forelse ($studentsByYearLevel as $yearLevel => $courses)
                                <li class="nav-item">
                                    <a class="nav-link @if($loop->first) active @endif text-dark" id="year-{{ $yearLevel }}-tab" data-toggle="pill" href="#year-{{ $yearLevel }}" role="tab" aria-controls="year-{{ $yearLevel }}" @if($loop->first) aria-selected="true" @endif>
                                        {{ App\Models\Student::getOrdinalOfYearLevel($yearLevel) }}
                                    </a>
                                </li>
                            @empty
                            @endforelse
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="year-tabContent">
                            @forelse ($studentsByYearLevel as $yearLevel => $courses)
                                <div class="tab-pane fade @if($loop->first) show active @endif" id="year-{{ $yearLevel }}" role="tabpanel" aria-labelledby="year-{{ $yearLevel }}-tab">
                                    @forelse ($courses->groupBy('course_id') as $courseID => $students)
                                        @php
                                            $course = App\Models\Course::find($courseID);
                                        @endphp
                                        <div class="col" id="accordion-{{ $course->id }}">
                                            <div class="card card-info  card-outline">
                                                <a class="d-block" data-toggle="collapse" href="#course-{{ $course->id }}-students">
                                                    <div class="card-header d-flex p-0">
                                                        <div class="col-md-6">
                                                            <h4 class="card-title p-3 text-dark">
                                                                {{ $course->name }}
                                                            </h4>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6 class="p-3 text-dark text-right">
                                                                ({{ $course->students->count() }} Students)
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </a>
                                                <div id="course-{{ $course->id }}-students" class="collapse" data-parent="#accordion-{{ $course->id }}">
                                                    <div class="card-body">
                                                        <table class="table table-sm table-bordered table-hover datatable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Course</th>
                                                                    <th>Student ID</th>
                                                                    <th>Year</th>
                                                                    <th>First Name</th>
                                                                    <th>Middle Name</th>
                                                                    <th>Last Name</th>
                                                                    @role('System Administrator')
                                                                    <th class="text-center">Action</th>
                                                                    @endrole
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($students as $student)
                                                                <tr @unlessrole('System Administrator') @can('students.show') data-toggle="tr-link" data-href="{{ route('students.show', $student->id) }}"  @endcan @else class="{{ $student->trashed() ? 'table-danger' : '' }}" @endunlessrole>
                                                                    <td>{{ $student->course->name ?? "" }}</td>
                                                                    <td>{{ $student->student_id }}</td>
                                                                    <td>
                                                                        {{ $student->getYearLevel() }}
                                                                    </td>
                                                                    <td>{{ $student->first_name }}</td>
                                                                    <td>{{ $student->middle_name }}</td>
                                                                    <td>{{ $student->last_name }}</td>
                                                                    @role('System Administrator')
                                                                        <td class="text-center">
                                                                            {{-- <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#editStudent" data-href="{{ route('students.edit',$student->id) }}"><i class="fad fa-edit fa-lg"></i></a> --}}
                                                                            @if ($student->trashed())
                                                                            <a class="text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('students.restore', $student->id) }}"><i class="fad fa-download fa-lg"></i></a>
                                                                            @else
                                                                                <a href="{{ route('students.show',$student->id) }}"><i class="fad fa-file fa-lg"></i></a>
                                                                                <a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('students.destroy', $student->id) }}"><i class="fad fa-trash-alt fa-lg"></i></a>
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
                                        </div>
                                    @empty
                                    @endforelse
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            @role('System Administrator')
                @if(config('app.env') == 'local')
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            Insert Dummy Student
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" action="{{ route('dummy_identity.insert_student') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <hr>
                                <div class="form-group">
                                    <label>Number of Students: </label>
                                    <input class="form-control" type="number" name="number" max="15000" min="1" value="1">
                                </div>
                                <div class="form-group">
                                    <div class="checkbox">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="add_account" value="add_account" id="addAccount" checked>
                                            <label class="custom-control-label" for="addAccount">Add User Account</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="verified" value="1" id="verified" checked>
                                            <label class="custom-control-label" for="verified">Verified</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="radio">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="year_level" value="1" id="year1">
                                            <label class="custom-control-label" for="year1">1st Year</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="year_level" value="2" id="year2">
                                            <label class="custom-control-label" for="year2">2nd Year</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="year_level" value="3" id="year3">
                                            <label class="custom-control-label" for="year3">3rd Year</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="year_level" value="4" id="year4">
                                            <label class="custom-control-label" for="year4">4th Year</label>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <button type="submit" class="btn btn-danger">Submit</button>					
                            </form>
                        </div>
                    </div>
                </div>	
                @endif
            @endrole
        </div>
    </div>
</section>
@endsection