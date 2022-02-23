
<div class="modal fade" id="showSubject" data-backdrop="static" data-keyboard="false" tabindex="-1" faculty="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" faculty="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $subject->subject_code}} | {{ $subject->title}}</h5>
                <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Subject Code:</label>
                            {{ $subject->subject_code}}
                        </div>
                        <div class="form-group">
                            <label>Title:</label>
                            {{ $subject->title}}
                        </div>
                        <div class="form-group">
                            <label>Description:</label>
                            {{ $subject->description}}
                        </div>
                    </div>
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
                                @forelse ($subject->classes as $class)
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
                </div>
            </div>
            <div class="modal-footer">
                <div class="col">
					@if ($subject->trashed())
                		@can('subjects.restore')
					    <a class="btn btn-default text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('subjects.restore', $subject->id) }}"><i class="fad fa-download"></i> Restore</a>
						@endcan
					@else
						@can('subjects.destroy')
					    <a class="btn btn-default text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('subjects.destroy', $subject->id) }}"><i class="fad fa-trash-alt"></i> Delete</a>
						@endcan
					@endif
					@can('subjects.edit')
					   <a class="btn btn-default text-primary" href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('subjects.edit', $subject->id) }}" data-target="#editSubject"><i class="fad fa-edit"></i> Edit</a>
                    @endcan
				</div>
				<div class="col text-right">
					<button class="btn btn-default" type="button" data-dismiss="modal-ajax"> Close</button>
				</div>
            </div>
        </div>
    </div>
</div>