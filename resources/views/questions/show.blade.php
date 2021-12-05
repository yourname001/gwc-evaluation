<div class="modal fade" id="showQuestion" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Question</h5>
                <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="question">Status</label>
                    @if($question->is_active == 1)
                    <span class="badge badge-success">Active</span>
                    @else
                    <span class="badge badge-warning">Inactive</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="question">Question</label>
                    {{ $question->question }}
                </div>
            </div>
            <div class="modal-footer">
                @can('questions.edit')
                @if($question->is_active == 1)
                <a href="{{ route('questions.set_inactive', $question->id) }}" class="btn btn-default text-danger"><i class="fad fa-times-circle"></i>Set Inactive</a>
                @else
                <a href="{{ route('questions.set_active', $question->id) }}" class="btn btn-default text-success"><i class="fa fa-check-circle"></i>Set Active</a>
                @endif
                <a href="javascript:void(0)" class="btn btn-default text-primary" data-toggle="modal-ajax" data-target="#editQuestion" data-href="{{ route('questions.edit',$question->id) }}"><i class="fad fa-edit"></i> Edit</a>
                @endcan
            </div>
        </div>
    </div>
</div>