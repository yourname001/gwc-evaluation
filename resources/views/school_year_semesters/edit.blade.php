<form action="{{ route('school_year_semesters.update', $schoolYearSemester->id) }}" method="POST" autocomplete="off">
    @csrf
    @method('PUT')
    <div class="modal fade" id="editSchoolYearSemester" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add School Year/Semester</h5>
                    <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="form-check-input" name="active" @if($schoolYearSemester->active == 1) checked @endif value="1" id="active">
                            <label class="form-check-label" for="active">Active</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>School Year:</label>
                        <div class="row">
                            <div class="col">
                                <input class="form-control" name="school_year_1" type="number" value="{{ explode('-', $schoolYearSemester->school_year)[0] }}" min="{{ date('Y')-1 }}" required>
                            </div>
                            -
                            <div class="col">
                                <input class="form-control" name="school_year_2" type="number" value="{{ explode('-', $schoolYearSemester->school_year)[1] }}" min="{{ date('Y')-1 }}" max="{{ date('Y')+1 }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Semester:</label>
                        <select name="semester" class="form-control select2-no-search" required>
                            <option></option>
                            <option value="1" @if($schoolYearSemester->semester == 1) selected @endif>1st Semester</option>
                            <option value="2" @if($schoolYearSemester->semester == 2) selected @endif>2nd Semester</option>
                            {{-- <option value="3rd">3rd Semester</option> --}}
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Semester Start Date:</label>
                        <div class="input-group datetimepicker-date-only" id="startDate" data-target-input="nearest">
                            <input type="text" name="start_date" class="form-control datetimepicker-input" data-target="#startDate" data-toggle="datetimepicker" value="{{ date('m/d/Y', strtotime($schoolYearSemester->start_date)) }}" required/>
                            <div class="input-group-append" data-target="#startDate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Semester End Date:</label>
                        <div class="input-group datetimepicker-date-only" id="endDate" data-target-input="nearest">
                            <input type="text" name="end_date" class="form-control datetimepicker-input" data-target="#endDate" data-toggle="datetimepicker" value="{{ date('m/d/Y', strtotime($schoolYearSemester->end_date)) }}" required/>
                            <div class="input-group-append" data-target="#endDate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
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
        $('.datetimepicker-date-only').datetimepicker({
            format: 'MM/DD/YYYY',
            buttons: {
                time: false,
            }
        });
    })
</script>