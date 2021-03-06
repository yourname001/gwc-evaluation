<form action="{{ route('evaluations.store') }}" method="POST" autocomplete="off">
    @csrf
    <div class="modal fade" id="createEvaluation" data-backdrop="static" data-keyboard="false" tabindex="-1" faculty="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" faculty="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Evaluation</h5>
                    <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Title:</label>
                                <input class="form-control" type="text" name="title" required>
                            </div>
                            {{-- <div class="form-group">
                                <label>Faculty:</label>
                                <select class="form-control select2" name="faculties[]" multiple required>
                                    <option></option>
                                    @foreach ($faculties as $faculty)
                                        <option value="{{ $faculty->id }}">
                                            {{ $faculty->getFacultyName() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="form-group">
                                <label>Classes:</label>
                                <br>
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="addAllActiveClasses" name="add_all_active_classes" value="1">
                                    <label for="addAllActiveClasses">Add all active classes this semester</label>
                                </div>
                                <br>
                                <select id="selectClasses" class="form-control select2" name="classes[]" required multiple>
                                    <option></option>
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}">
                                            {{ $class->subject->subject_code }} - 
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
                                    <input type="text" name="start_date" class="form-control datetimepicker-input" data-target="#startDate" data-toggle="datetimepicker" required/>
                                    <div class="input-group-append" data-target="#startDate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Evaluation End Date:</label>
                                <div class="input-group datetimepicker-no-past" id="endDate" data-target-input="nearest">
                                    <input type="text" name="end_date" class="form-control datetimepicker-input" data-target="#endDate" data-toggle="datetimepicker" required/>
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
        $('.datetimepicker-no-past').datetimepicker({
            minDate: new Date()
        });

        $('#addAllActiveClasses').change(function(){
            if($(this).is(':checked')){
                $('#selectClasses').prop('disabled', true);
            }else{
                $('#selectClasses').prop('disabled', false);
            }
        });
    })
</script>