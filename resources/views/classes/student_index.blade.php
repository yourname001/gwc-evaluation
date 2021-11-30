@extends('layouts.adminlte')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Classes</h1>
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
                                <th>Section</th>
                                <th>Course</th>
                                <th>Faculty</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($studentClasses as $studentClass)
                            <tr>
                                <td>
                                    {{ $studentClass->class->section }} -
                                </td>
                                <td>
                                    {{ $studentClass->class->course->course_code }} -
                                    {{ $studentClass->class->course->title }}
                                </td>
                                <td>{{ $studentClass->class->faculty->fullname('') }}</td>
                            </tr>
                            @empty
                            {{-- <tr>
                                <td class="text-center text-danger" colspan="8">*** EMPTY ***</td>
                            </tr> --}}
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection