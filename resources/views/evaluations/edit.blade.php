<form action="{{ route('evaluations.update', $evaluation->id) }}" method="POST" autocomplete="off">
    @csrf
    @method('PUT')
    <div class="modal fade" id="editEvaluation" data-backdrop="static" data-keyboard="false" tabindex="-1" faculty="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" faculty="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Evaluation</h5>
                    <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Title:</label>
                                <input class="form-control" type="text" name="title" value="{{ $evaluation->title }}" required>
                            </div>
                            <div class="form-group">
                                <label>Classes:</label>
                                <select class="form-control select2" name="classes[]" multiple required>
                                    <option></option>
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}" @if(in_array($class->id, $evaluationClassIDs)) selected @endif>
                                            {{ $class->course->course_code }} - 
                                            {{ $class->section }}
                                            {{ $class->title }}
                                            (Faculty: {{ $class->faculty->fullname('') }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Evaluation Start Date:</label>
                                <div class="input-group datetimepicker-no-past" id="startDate" data-target-input="nearest">
                                    <input type="text" name="start_date" value="{{ date('m/d/Y h:i A', strtotime($evaluation->start_date)) }}" class="form-control datetimepicker-input" data-target="#startDate" data-toggle="datetimepicker" required/>
                                    <div class="input-group-append" data-target="#startDate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Evaluation End Date:</label>
                                <div class="input-group datetimepicker-no-past" id="endDate" data-target-input="nearest">
                                    <input type="text" name="end_date" value="{{ date('m/d/Y h:i A', strtotime($evaluation->end_date)) }}" class="form-control datetimepicker-input" data-target="#endDate" data-toggle="datetimepicker" required/>
                                    <div class="input-group-append" data-target="#endDate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal-ajax">Cancel</button>
                    <button class="btn btn-default text-success" type="submit"><i class="fas fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(function(){
        $('.datetimepicker-no-past').datetimepicker();
    })
</script>