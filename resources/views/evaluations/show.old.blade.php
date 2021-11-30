@extends('layouts.adminlte')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> {{ $evaluation->title }} {!! $evaluation->getStatusBadge() !!}</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a class="btn btn-primary" href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('evaluations.edit', $evaluation->id) }}" data-target="#editEvaluation"><i class="fad fa-edit"></i> Edit</a>
                @if ($evaluation->trashed())
                    <a class="btn btn-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('evaluations.restore', $evaluation->id) }}"><i class="fad fa-download"></i> Restore</a>
                @else
                    <a class="btn btn-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('evaluations.destroy', $evaluation->id) }}"><i class="fad fa-trash-alt"></i> Delete</a>
                @endif
                <a class="btn btn-default" href="{{ route('evaluations.index') }}" ><i class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col" id="accordion">
                @foreach ($evaluation->evaluationClasses as $index => $evaluationClass)
                    <div class="card @if($evaluationClass->trashed()) card-danger @else card-primary @endif card-outline">
                        <a class="d-block" data-toggle="collapse" href="#evaluation-{{ $evaluationClass->id }}">
                            <div class="card-header d-flex p-0">
                                <h4 class="card-title p-3 text-dark">
                                    {{ $evaluationClass->class->faculty->fullname('') }} |
                                    {{ $evaluationClass->class->course->course_code }} -
                                    {{ $evaluationClass->class->course->title }}
                                </h4>
                                <ul class="nav nav-pills ml-auto p-2">
                                    @can('evaluations.export')
                                    <li class="nav-item">
                                        <a class="nav-link text-primary" href="{{ route('evaluation_classes.export', ['evaluation_class_id' => $evaluationClass->id]) }}" target="_blank"><i class="fad fa-table"></i> Export Excel</a>
                                    </li>
                                    @endcan
                                    @can('evaluations.send_email')
                                    <li class="nav-item">
                                        <a class="nav-link text-primary" href="{{ route('evaluation_classes.send_email', $evaluationClass->id) }}"><i class="fad fa-envelope"></i> Send Email</a>
                                    </li>
                                    @endcan
                                    @if ($evaluationClass->trashed())
                                        <a class="btn btn-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('evaluation_classes.restore', $evaluationClass->id) }}"><i class="fad fa-download"></i> Restore</a>
                                    @else
                                        <a class="btn btn-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('evaluation_classes.destroy', $evaluationClass->id) }}"><i class="fad fa-trash-alt"></i> Delete</a>
                                    @endif
                                </ul>
                            </div>
                        </a>
                        <div id="evaluation-{{ $evaluationClass->id }}" class="collapse" data-parent="#accordion">
                            <div class="card-body">
                                <div class="position-relative mb-4">
                                    <div class="row">
                                        @if($evaluationClass->evaluationStudentResponses()->count() > 0)
                                        <div class="col-md-12">
                                            {!! $evaluationClassChart[$evaluationClass->id]->container() !!}
                                        </div>
                                        @else
                                        <div class="col-md-12">
                                            <div class="alert alert-warning text-center">No Records yet</div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
@if($evaluation->evaluationClasses->count() > 0)
    
    @foreach ($evaluation->evaluationClasses as $evaluationClass)
        @if($evaluationClass->evaluationStudentResponses()->count() > 0)                 
            <script>
                var chart = new Chart('{{ $evaluationClassChart[$evaluationClass->id]->id }}')
            </script>
            {!! $evaluationClassChart[$evaluationClass->id]->script() !!}
        @endif
    @endforeach
@endif
   
@endsection