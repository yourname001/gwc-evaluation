@extends('layouts.adminlte')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Courses</h1>
            </div>
            <div class="col-sm-6 text-right">
                @if ($course->trashed())
                    @can('courses.restore')
                    <a class="btn btn-default text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('courses.restore', $course->id) }}"><i class="fad fa-download"></i> Restore</a>
                    @endcan
                @else
                    @can('courses.destroy')
                    <a class="btn btn-default text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('courses.destroy', $course->id) }}"><i class="fad fa-trash-alt"></i> Delete</a>
                    @endcan
                @endif
                @can('courses.edit')
                    <a class="btn btn-default text-primary" href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('courses.edit', $course->id) }}" data-target="#editCourse"><i class="fad fa-edit"></i> Edit</a>
                @endcan
                <a class="btn btn-default text-default" href="{{ route('courses.index') }}"><i class="fad fa-arrow-left"></i> Back</a>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Department:</label>
                            {{ $course->department->name}}
                        </div>
                        <div class="form-group">
                            <label>Name:</label>
                            {{ $course->name}}
                        </div>
                        <div class="form-group">
                            <label>Description:</label>
                            {{ $course->description}}
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col">
                        <label>Curriculum:</label>
                        @can('course_subjects.store')
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addSubject"><i class="fa fa-plus"></i> Add Subject</button>
                        @endcan
                        <br>
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Subject Code</th>
                                    <th>Title</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($course->subjects->groupBy('year_level') as $year_level => $semesters)
                                    @foreach ($semesters->groupBy('semester') as $semester => $subjects)
                                        @php
                                            $ends = array('th','st','nd','rd','th','th','th','th','th','th');
                                            if (($year_level %100) >= 11 && ($year_level%100) <= 13)
                                                $yearLevel = $year_level. 'th';
                                            else
                                                $yearLevel = $year_level. $ends[$year_level % 10];
                                        @endphp
                                        <tr>
                                            <th colspan="3">{{ $yearLevel }} Year - {{ $semester }} Semester:</th>
                                        </tr>
                                        @foreach ($subjects as $subject)
                                        <tr>
                                            <td>
                                                {{ $subject->subject->subject_code }}
                                            </td>
                                            <td>
                                                {{ $subject->subject->title }}
                                            </td>
                                            <td>
                                                
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endforeach
                                    
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-danger">*** EMPTY ***</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </section>
</div>
@can('course_subjects.store')
<form action="{{ route('course_subjects.store') }}" method="POST">
    @csrf
    <input type="hidden" name="course" value="{{ $course->id }}">
    <div class="modal fade" id="addSubject" data-backdrop="static" data-keyboard="false" tabindex="-1" faculty="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-md" faculty="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Subject</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Subject:</label>
                        <select class="form-control select2" name="subject[]" multiple required>
                            <option></option>
                            @foreach ($selectSubjects as $subject)
                                <option value="{{ $subject->id }}">
                                    {{ $subject->subject_code }} - 
                                    {{ $subject->title }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-group">
                            <label>Year Level:</label>
                            <input class="form-control" name="year_level" type="number" max="5" required>
                        </div>
                        <div class="form-group">
                            <label>Semester:</label>
                            <select name="semester" class="form-control" required>
                                <option value="1st">1st Semester</option>
                                <option value="2nd">2nd Semester</option>
                                {{-- <option value="3rd">3rd Semester</option> --}}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-default text-success" type="submit"><i class="fas fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endcan
@endsection
