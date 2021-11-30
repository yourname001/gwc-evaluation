@extends('layouts.adminlte')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $evaluationClass->class->faculty->fullname('') }} | {{ $evaluationClass->class->course->course_code }} - {{ $evaluationClass->class->course->title }} | {{ $evaluationClass->class->section }}</h1>
            </div>
            <div class="col-sm-6 text-right">
                @hasrole('System Administrator')
                <a class="btn btn-primary" href="{{ route('evaluation_classes.export', ['evaluation_class_id' => $evaluationClass->id]) }}" target="_blank"><i class="fad fa-table"></i> Export Excel</a>
                <a class="btn btn-primary" href="{{ route('evaluation_classes.send_email', $evaluationClass->id) }}"><i class="fad fa-envelope"></i> Send Email</a>
                @endhasrole
                @hasrole('Faculty')
                <a class="btn btn-default" href="{{ route('evaluations.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                @else
                <a class="btn btn-default" href="{{ route('evaluations.show', $evaluationClass->evaluation_id) }}"><i class="fa fa-arrow-left"></i> Back</a>
                @endhasrole
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            Results
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @forelse ($evaluationClass->evaluationStudentResponses()->groupBy('question') as $question => $responses)
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
                                                    {!! $evaluationClassChart[$questionID]->container() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @empty
                            <div class="col">
                                <div class="alert alert-warning text-center">No Records yet</div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            Student Comments
                        </h3>
                    </div>
                    <div class="card-body">
                        <table id="datatable" class="table table-sm table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Positive Comment</th>
                                    <th>Negative Comment</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($evaluationClass->evaluationStudents as $studentResponse)
                                    <tr>
                                        <td>
                                            {{ $studentResponse->positive_comments }}
                                        </td>
                                        <td>
                                            {{ $studentResponse->negative_comments }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center text-danger" colspan="2">*** No records yet ***</td>
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
@endsection
@section('script')
    @foreach ($evaluationClass->evaluationStudentResponses()->groupBy('question') as $question => $responses)
        @foreach ($responses->groupBy('question_id') as $questionID => $response)
        {!! $evaluationClassChart[$questionID]->script() !!}
        @endforeach 
    @endforeach
@endsection