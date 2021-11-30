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
        <div class="row">
            <div class="col" id="accordion">
                @forelse ($evaluations as $evaluation)
                    <div class="card @if($evaluation->trashed()) card-danger @else card-primary @endif card-outline">
                        <a class="d-block" data-toggle="collapse" href="#evaluation-{{ $evaluation->id }}">
                            <div class="card-header d-flex p-0">
                                {{-- <div class="row"> --}}
                                    {{-- <div class="col-md-6"> --}}
                                    <h4 class="card-title p-3 text-dark">
                                        {{ $evaluation->title }}
                                        [{{ $evaluation->getStatus() }}]
                                        @if($evaluation->trashed())
                                        <strong class="text-danger">
                                            [DELETED]
                                        </strong>
                                        @endif
                                    </h4>
                                    {{-- </div> --}}
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
                                {{-- </div> --}}
                            </div>
                        </a>
                        <div id="evaluation-{{ $evaluation->id }}" class="collapse @if($evaluation->getStatus() == "ongoing") show @endif" data-parent="#accordion">
                            <div class="card-body">
                                <div class="row">
                                    @forelse($evaluation->faculties as $faculty)
                                        <div class="col-lg-3 col-6">
                                            <div class="small-box bg-info">
                                                <div class="inner">
                                                    <h3>Done</h3>
                                                    <p>{{ $faculty->faculty->getFacultyName() }}</p>
                                                </div>
                                                <div class="icon">
                                                    <img src="{{ asset('images/user/default/male.jpg') }}" alt="">
                                                </div>
                                                <a href="javascript:void(0)" data-toggle="model-ajax" data-target="#evaluate" data-href="{{ route('evaluation_students.create', ['faculty_id'=> $faculty->id]) }}" class="small-box-footer">Evaluate <i class="fas fa-arrow-circle-right"></i></a>
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
        </div>
    </div>
</section>
@endsection