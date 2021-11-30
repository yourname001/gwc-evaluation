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
            @foreach ($evaluation->evaluationClasses as $evaluationClass)
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>
                            {{ $evaluationClass->class->course->course_code }}
                        </h3>
                        <p>{{ $evaluationClass->class->course->title }}</p>
                        <p>Section: {{ $evaluationClass->class->section }}</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-book"></i>
                    </div>
                    <a href="{{ route('evaluation_classes.show', $evaluationClass->id) }}" class="small-box-footer">View Result <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

@section('script')
{{-- @if($evaluation->evaluationClasses->count() > 0)
    
    @foreach ($evaluation->evaluationClasses as $evaluationClass)
        @if($evaluationClass->evaluationStudentResponses()->count() > 0)                 
            <script>
                var chart = new Chart('{{ $evaluationClassChart[$evaluationClass->id]->id }}')
            </script>
            {!! $evaluationClassChart[$evaluationClass->id]->script() !!}
        @endif
    @endforeach
@endif --}}
   
@endsection