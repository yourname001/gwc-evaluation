<form action="{{ route('classes.update', $class->id) }}" method="POST" autocomplete="off">
    @csrf
    @method('PUT')
    <div class="modal fade" id="editClass" data-backdrop="static" data-keyboard="false" tabindex="-1" faculty="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" faculty="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Class</h5>
                    <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Course:</label>
                                <select class="form-control select2" name="course" required>
                                    <option></option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}" @if($class->course_id == $course->id) selected @endif>
                                            {{ $course->course_code }} - 
                                            {{ $course->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Faculty:</label>
                                <select class="form-control select2" name="faculty" required>
                                    <option></option>
                                    @foreach ($faculties as $faculty)
                                        <option value="{{ $faculty->id }}" @if($class->faculty_id == $faculty->id) selected @endif>
                                            {{ $faculty->fullname('') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Students:</label>
                                <select class="form-control select2" name="students[]" multiple required>
                                    <option></option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}" @if(in_array($student->id, $classStudentIDs)) selected @endif>
                                            {{ $student->fullname('') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Section:</label>
                                <input class="form-control" type="text" name="section" value="{{ $class->section }}">
                            </div>
                            {{-- <div class="form-group">
                                <label>School Year:</label>
                                <input class="form-control" type="text" name="school_year" required>
                            </div> --}}
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