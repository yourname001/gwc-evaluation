@extends('layouts.adminlte')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Questions</h1>
            </div>
            <div class="col-sm-6 text-right">
                @can('questions.create')
                    <button class="btn btn-default" type="button" data-toggle="modal-ajax" data-href="{{ route('questions.create') }}" data-target="#createQuestion"><i class="fa fa-plus"></i> Add</button>
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
                                <th>Question</th>
                                @role('System Administrator')
                                <th class="text-center">Action</th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($questions as $question)
                            <tr @unlessrole('System Administrator') @can('questions.show') data-toggle="modal-ajax" data-target="#showQuestion" data-href="{{ route('questions.show', $question->id) }}"  @endcan @else class="{{ $question->trashed() ? 'table-danger' : '' }}" @endunlessrole>
                                <td>
                                    @if($question->is_active == 1)
                                    <span class="badge badge-success">Active</span>
                                    @else
                                    <span class="badge badge-warning">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $question->question }}</td>
                                @role('System Administrator')
                                    <td class="text-center">
                                        <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#showQuestion" data-href="{{ route('questions.show',$question->id) }}"><i class="fad fa-file fa-lg"></i></a>
                                        {{-- <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#editQuestion" data-href="{{ route('questions.edit',$question->id) }}"><i class="fad fa-edit fa-lg"></i></a> --}}
                                        @if ($question->trashed())
                                            <a class="text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('questions.restore', $question->id) }}"><i class="fad fa-download fa-lg"></i></a>
                                        @else
                                            <a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('questions.destroy', $question->id) }}"><i class="fad fa-trash-alt fa-lg"></i></a>
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