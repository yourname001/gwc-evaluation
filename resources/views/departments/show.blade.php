
<div class="modal fade" id="showCourse" data-backdrop="static" data-keyboard="false" tabindex="-1" faculty="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" faculty="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Department</h5>
                <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Name:</label>
                            {{ $course->name}}
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="col-md-6">
                            <label>Classes:</label>
                            <br>
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Faculty</th>
                                        <th>Schedule</th>
                                        <th>School Year</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($course->classes as $class)
                                        <tr>
                                            <td>
                                                {{ $class->faculty->fullname('') }}
                                            </td>
                                            <td>
                                                {{ date('F d, Y h:iA', strtotime($class->schedule)) }}
                                            </td>
                                            <td>
                                                {{ $class->school_year }}
                                            </td>
                                        </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-danger">*** EMPTY ***</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div> --}}
                </div>
            </div>
            <div class="modal-footer">
                <div class="col">
					@if ($election_show->trashed())
                		@can('courses.restore')
					    <a class="btn btn-default text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('courses.restore', $election_show->id) }}"><i class="fad fa-download"></i> Restore</a>
						@endcan
					@else
						@can('courses.destroy')
					    <a class="btn btn-default text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('courses.destroy', $election_show->id) }}"><i class="fad fa-trash-alt"></i> Delete</a>
						@endcan
					@endif
					@can('courses.edit')
					   <a class="btn btn-default text-primary" href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('courses.edit', $election_show->id) }}" data-target="#editCourse"><i class="fad fa-edit"></i> Edit</a>
                    @endcan
				</div>
				<div class="col text-right">
					<button class="btn btn-default" type="button" data-dismiss="modal-ajax"> Close</button>
				</div>
            </div>
        </div>
    </div>
</div>