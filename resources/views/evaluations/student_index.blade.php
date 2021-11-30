@extends('layouts.adminlte')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Evaluations</h1>
            </div>
            <div class="col-sm-6 text-right">
                @can('evaluations.create')
                    <button class="btn btn-default" type="button" data-toggle="modal-ajax" data-href="{{ route('evaluations.create') }}" data-target="#createEvaluation"><i class="fa fa-plus"></i> Add</button>
                @endcan
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        {{-- <table>
            <thead>
                <tr>
                    <td>Course Code</td>
                    <td>Title</td>
                </tr>
            </thead>
            <tbody>
                @foreach (Auth::user()->student->student->classes as $class)
                    <tr>
                        <td>
                            {{ $class->class->course->course_code }}
                        </td>
                        <td>
                            {{ $class->class->course->title }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <hr> --}}
        <div class="row">
            <div class="col" id="accordion">
                @forelse ($evaluations as $evaluation)
                    <div class="card @if($evaluation->trashed()) card-danger @else card-primary @endif card-outline">
                        <a class="d-block" data-toggle="collapse" href="#evaluation-{{ $evaluation->id }}">
                            <div class="card-header d-flex p-0">
                                <h4 class="card-title p-3 text-dark">
                                    {{ $evaluation->title }}
                                    {!! $evaluation->getStatusbadge() !!}
                                    |
                                    <i>
                                        <b>Date:</b>
                                        {{ date('F d, Y h:i A', strtotime($evaluation->start_date)) }}
                                        -
                                        {{ date('F d, Y h:i A', strtotime($evaluation->end_date)) }}
                                    </i>
                                </h4>
                                {{-- <ul class="nav nav-pills ml-auto p-2">
                                    @if ($evaluation->trashed())
                                        @can('evaluations.restore')
                                        <li class="nav-item">
                                            <a class="nav-link text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('evaluations.restore', $evaluation->id) }}"><i class="fad fa-download"></i> Restore</a>
                                        </li>
                                        @endcan
                                    @else
                                        @can('evaluations.destroy')
                                        <li class="nav-item">
                                            <a class="nav-link text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('evaluations.destroy', $evaluation->id) }}"><i class="fad fa-trash-alt"></i> Delete</a>
                                        </li>
                                        @endcan
                                    @endif
                                    @can('evaluations.edit')
                                    <li class="nav-item">
                                        <a class="nav-link text-primary" href="{{ route('evaluations.edit', $evaluation->id) }}"><i class="fad fa-edit"></i> Edit</a>
                                    </li>
                                    @endcan
                                </ul> --}}
                            </div>
                        </a>
                        <div id="evaluation-{{ $evaluation->id }}" class="collapse @if($evaluation->getStatus() == "ongoing") show @endif" data-parent="#accordion">
                            <div class="card-body">
                                <div class="row">
                                    @forelse($evaluation->evaluationClasses as $evaluationClass)
                                        @if(Auth::user()->student->student->hasClass($evaluationClass->class_id))
                                            <div class="col-lg-3 col-6">
                                                <div class="small-box @if($evaluationClass->isDone()) bg-success @else bg-warning @endif">
                                                    <div class="inner">
                                                        <h4>
                                                            {{ $evaluationClass->class->course->course_code }}
                                                            {{-- @if($evaluationClass->isDone())
                                                            <i class="fa fa-check"></i>
                                                            @else
                                                            <i class="fa fa-times"></i>
                                                            @endif --}}
                                                        </h4>
                                                        <p>{{ $evaluationClass->class->section }}</p>
                                                        <p>{{ $evaluationClass->class->faculty->fullname('') }}</p>
                                                    </div>
                                                    <div class="icon">
                                                        <img class="img-thumbnail" width="100%" src="{{ asset($evaluationClass->class->faculty->avatar()) }}">
                                                    </div>
                                                    @if($evaluationClass->isDone())
                                                    <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#showEvaluationStudent" data-href="{{ route('evaluation_students.show', $evaluationClass->studentResponseID()) }}" class="small-box-footer">View Response <i class="fas fa-arrow-circle-right"></i></a>
                                                    @elseif($evaluation->getStatus() == 'ongoing')
                                                    <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#createEvaluationStudent" data-href="{{ route('evaluation_students.create', ['evaluation_class_id' => $evaluationClass->id]) }}" class="small-box-footer">Evaluate <i class="fas fa-arrow-circle-right"></i></a>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                <div class="alert alert-danger text-center">
                    *** EMPTY ***
                </div>
                @endforelse
            </div>
        </div>
        {{-- <table>
            <thead>
                <tr>
                    <td>Course Code</td>
                    <td>Title</td>
                </tr>
            </thead>
            <tbody>
                @foreach (Auth::user()->student->student->classes as $class)
                    <tr>
                        <td>
                            {{ $class->class->course->course_code }}
                        </td>
                        <td>
                            {{ $class->class->course->title }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table> --}}
        {{-- <div class="row">
            <div class="col" id="accordion">
                @forelse ($evaluations as $evaluation)
                    <div class="card @if($evaluation->trashed()) card-danger @else card-primary @endif card-outline">
                        <a class="d-block" data-toggle="collapse" href="#evaluation-{{ $evaluation->id }}">
                            <div class="card-header d-flex p-0">
                                <h4 class="card-title p-3 text-dark">
                                    {{ $evaluation->title }}
                                    [{{ $evaluation->getStatus() }}]
                                    @if($evaluation->trashed())
                                    <strong class="text-danger">
                                        [DELETED]
                                    </strong>
                                    @endif
                                </h4>
                                <ul class="nav nav-pills ml-auto p-2">
                                    @if ($evaluation->trashed())
                                        @can('evaluations.restore')
                                        <li class="nav-item">
                                            <a class="nav-link text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('evaluations.restore', $evaluation->id) }}"><i class="fad fa-download"></i> Restore</a>
                                        </li>
                                        @endcan
                                    @else
                                        @can('evaluations.destroy')
                                        <li class="nav-item">
                                            <a class="nav-link text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('evaluations.destroy', $evaluation->id) }}"><i class="fad fa-trash-alt"></i> Delete</a>
                                        </li>
                                        @endcan
                                    @endif
                                    @can('evaluations.edit')
                                    <li class="nav-item">
                                        <a class="nav-link text-primary" href="{{ route('evaluations.edit', $evaluation->id) }}"><i class="fad fa-edit"></i> Edit</a>
                                    </li>
                                    @endcan
                                </ul>
                            </div>
                        </a>
                        <div id="evaluation-{{ $evaluation->id }}" class="collapse @if($evaluation->getStatus() == "ongoing") show @endif" data-parent="#accordion">
                            <div class="card-body">
                                <div class="row">
                                    @forelse($evaluation->evaluationFaculties as $evaluation_faculty)
                                        <div class="col-lg-3 col-6">
                                            <div class="small-box @if($evaluation_faculty->isDone()) bg-success @else bg-warning @endif">
                                                <div class="inner">
                                                    <h3>
                                                        @if($evaluation_faculty->isDone())
                                                        <i class="fa fa-check"></i>
                                                        @else
                                                        <i class="fa fa-times"></i>
                                                        @endif
                                                    </h3>
                                                    <p>{{ $evaluation_faculty->faculty->getFacultyName() }}</p>
                                                </div>
                                                <div class="icon">
                                                    <img src="{{ asset('images/user/default/male.jpg') }}" alt="">
                                                </div>
                                                @if($evaluation_faculty->isDone())
                                                <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#showEvaluationStudent" data-href="{{ route('evaluation_students.show', $evaluation_faculty->studentResponseID()) }}" class="small-box-footer">View Response <i class="fas fa-arrow-circle-right"></i></a>
                                                @else
                                                <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#createEvaluationStudent" data-href="{{ route('evaluation_students.create', ['evaluation_faculty_id' => $evaluation_faculty->id]) }}" class="small-box-footer">Evaluate <i class="fas fa-arrow-circle-right"></i></a>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                <div class="alert alert-danger text-center">
                    *** EMPTY ***
                </div>
                @endforelse
            </div>
        </div> --}}
        {{-- <div class="row">
            <div class="col" id="accordion">
                @forelse ($evaluations as $evaluation)
                    <div class="card @if($evaluation->trashed()) card-danger @else card-primary @endif card-outline">
                        <a class="d-block" data-toggle="collapse" href="#evaluation-{{ $evaluation->id }}">
                            <div class="card-header d-flex p-0">
                                <h4 class="card-title p-3 text-dark">
                                    {{ $evaluation->title }}
                                    [{{ $evaluation->getStatus() }}]
                                    @if($evaluation->trashed())
                                    <strong class="text-danger">
                                        [DELETED]
                                    </strong>
                                    @endif
                                </h4>
                                <ul class="nav nav-pills ml-auto p-2">
                                    @if ($evaluation->trashed())
                                        @can('evaluations.restore')
                                        <li class="nav-item">
                                            <a class="nav-link text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('evaluations.restore', $evaluation->id) }}"><i class="fad fa-download"></i> Restore</a>
                                        </li>
                                        @endcan
                                    @else
                                        @can('evaluations.destroy')
                                        <li class="nav-item">
                                            <a class="nav-link text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('evaluations.destroy', $evaluation->id) }}"><i class="fad fa-trash-alt"></i> Delete</a>
                                        </li>
                                        @endcan
                                    @endif
                                    @can('evaluations.edit')
                                    <li class="nav-item">
                                        <a class="nav-link text-primary" href="{{ route('evaluations.edit', $evaluation->id) }}"><i class="fad fa-edit"></i> Edit</a>
                                    </li>
                                    @endcan
                                </ul>
                            </div>
                        </a>
                        <div id="evaluation-{{ $evaluation->id }}" class="collapse @if($evaluation->getStatus() == "ongoing") show @endif" data-parent="#accordion">
                            <div class="card-body">
                                <div class="row">
                                    @forelse($evaluation->evaluationFaculties as $evaluation_faculty)
                                        <div class="col-lg-3 col-6">
                                            <div class="small-box @if($evaluation_faculty->isDone()) bg-success @else bg-warning @endif">
                                                <div class="inner">
                                                    <h3>
                                                        @if($evaluation_faculty->isDone())
                                                        <i class="fa fa-check"></i>
                                                        @else
                                                        <i class="fa fa-times"></i>
                                                        @endif
                                                    </h3>
                                                    <p>{{ $evaluation_faculty->faculty->getFacultyName() }}</p>
                                                </div>
                                                <div class="icon">
                                                    <img src="{{ asset('images/user/default/male.jpg') }}" alt="">
                                                </div>
                                                @if($evaluation_faculty->isDone())
                                                <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#showEvaluationStudent" data-href="{{ route('evaluation_students.show', $evaluation_faculty->studentResponseID()) }}" class="small-box-footer">View Response <i class="fas fa-arrow-circle-right"></i></a>
                                                @else
                                                <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#createEvaluationStudent" data-href="{{ route('evaluation_students.create', ['evaluation_faculty_id' => $evaluation_faculty->id]) }}" class="small-box-footer">Evaluate <i class="fas fa-arrow-circle-right"></i></a>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                <div class="alert alert-danger text-center">
                    *** EMPTY ***
                </div>
                @endforelse
            </div>
        </div> --}}
    </div>
</section>
@endsection