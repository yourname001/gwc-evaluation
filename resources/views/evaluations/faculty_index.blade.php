@extends('layouts.adminlte')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Evaluations</h1>
            </div>
            {{-- <div class="col-sm-6 text-right">
                @can('evaluations.create')
                    <button class="btn btn-default" type="button" data-toggle="modal-ajax" data-href="{{ route('evaluations.create') }}" data-target="#createEvaluation"><i class="fa fa-plus"></i> Add</button>
                @endcan
            </div> --}}
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                @if($facultyEvaluations->count() > 0)
                <div class="col" id="accordion">
                    @foreach ($facultyEvaluations->groupBy('evaluation_id') as $evaluationID => $facultyEvaluation)
                    @php
                        $evaluation = App\Models\Evaluation::find($evaluationID);
                    @endphp
                        <div class="card card-primary card-outline">
                            <a class="d-block" data-toggle="collapse" href="#evaluation-{{ $evaluationID }}">
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
                                </div>
                            </a>
                            <div id="evaluation-{{ $evaluationID }}" class="collapse show" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="row">
                                        @forelse($facultyEvaluation as $evaluationClass)
                                            {{-- @if(Auth::user()->student->student->hasClass($evaluationClass->class_id)) --}}
                                                <div class="col-lg-3 col-6">
                                                    <div class="small-box bg-success">
                                                        <div class="inner">
                                                            <h4>
                                                                {{ $evaluationClass->class->course->course_code }}
                                                            </h4>
                                                            <p>{{ $evaluationClass->class->section }}</p>
                                                            <p>{{ $evaluationClass->class->course->title }}</p>
                                                        </div>
                                                        <div class="icon">
                                                            <i class="fa fa-book"></i>
                                                        </div>
                                                        <a href="{{ route('evaluation_classes.show', $evaluationClass->id) }}" class="small-box-footer">View Result <i class="fas fa-arrow-circle-right"></i></a>
                                                    </div>
                                                </div>
                                            {{-- @endif --}}
                                        @empty
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @else
                <div class="alert alert-warning text-center">No Records yet</div>
                @endif
            </div>
            {{-- <div class="col-lg-12">
                @if($facultyEvaluations->count() > 0)
                <div class="col" id="accordion">
                    @foreach ($facultyEvaluations as $facultyEvaluation)
                        <div class="card @if($facultyEvaluation->trashed()) card-danger @else card-primary @endif card-outline">
                            <a class="d-block" data-toggle="collapse" href="#evaluation-{{ $facultyEvaluation->id }}">
                                <div class="card-header d-flex p-0">
                                    <h4 class="card-title p-3 text-dark">
                                        {{ $facultyEvaluation->evaluation->title }}
                                        [{{ $facultyEvaluation->evaluation->getStatus() }}]
                                        @if($facultyEvaluation->evaluation->trashed())
                                        <strong class="text-danger">
                                            [DELETED]
                                        </strong>
                                        @endif
                                    </h4>
                                </div>
                            </a>
                            <div id="evaluation-{{ $facultyEvaluation->id }}" class="collapse @if($facultyEvaluation->evaluation->getStatus() == 'ongoing') show @endif" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="position-relative mb-4">
                                        <div class="row">
                                            @foreach ($facultyEvaluation->evaluationStudentResponses()->groupBy('question') as $question => $responses)
                                                @foreach ($responses->groupBy('question_id') as $questionID => $response)
                                                    <div class="col-md-3">
                                                        <div class="card">
                                                            <div class="card-header border-0">
                                                                <div class="d-flex justify-content-between">
                                                                    <h5 class="card-title">{{ $question }}</h5>
                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="position-relative mb-4">
                                                                    {!! $facultyEvaluationChart[$facultyEvaluation->id][$questionID]->container() !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach 
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @else
                <div class="alert alert-warning text-center">No Records yet</div>
                @endif
            </div> --}}
        </div>
    </div>
</section>
@endsection

@section('script')
{{-- @for ($i = 0; $i < $countGraph; $i++)
    {!! $facultyEvaluationChart[$facultyEvaluationChartIDs[$i]]->script() !!}
@endfor --}}
{{-- @foreach ($facultyEvaluationChartIDs as $facultyEvaluationChartIDs)
    {!! $facultyEvaluationChart[$facultyEvaluationChartIDs]->script() !!}
@endforeach --}}
{{-- @if($facultyEvaluations->count() > 0)
    @foreach ($facultyEvaluations as $facultyEvaluation)
        @foreach ($facultyEvaluation->evaluationStudentResponses()->groupBy('question_id') as $questionID => $responses)
                {!! $facultyEvaluationChart[$facultyEvaluation->id][$questionID]->script() !!}
            <script>
                var renderChart = new Chart(window.{{ $facultyEvaluationChart[$facultyEvaluation->id][$questionID]->id }}, {
                    options: {
                        'min-height': '250px',
                    }
                })
            </script>
        @endforeach
    @endforeach
@endif --}}
   
@endsection