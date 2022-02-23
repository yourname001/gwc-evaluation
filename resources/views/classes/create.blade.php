<form action="{{ route('classes.store') }}" method="POST" autocomplete="off">
    @csrf
    <div class="modal fade" id="createClass" data-backdrop="static" data-keyboard="false" tabindex="-1" faculty="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" faculty="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Class</h5>
                    <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>School Year & Semester:</label>
                                S.Y.{{ $schoolYearSemester->school_year }} | {{ $schoolYearSemester->getSemester() }}
                            </div>
                            <div class="form-group">
                                <label>Subject:</label>
                                <select class="form-control select2" name="subject" required>
                                    <option></option>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}">
                                            {{ $subject->subject_code }} - 
                                            {{ $subject->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Faculty:</label>
                                <select class="form-control select2" name="faculty" required>
                                    <option></option>
                                    @foreach ($faculties as $faculty)
                                        <option value="{{ $faculty->id }}">
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
                                        <option value="{{ $student->id }}">
                                            {{ $student->student_id }} | {{ $student->fullname('') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Section:</label>
                                <input class="form-control" type="text" name="section">
                            </div>
                            {{-- <div class="form-group">
                                <label>School Year:</label>
                                <div class="row">
                                    <div class="col">
                                        <input class="form-control" name="school_year_1" type="number" min="{{ date('Y')-1 }}" required>
                                    </div>
                                    -
                                    <div class="col">
                                        <input class="form-control" name="school_year_2" type="number" max="{{ date('Y')+1 }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Semester:</label>
                                <select name="semester" class="form-control" required>
                                    <option value="1st">1st Semester</option>
                                    <option value="2nd">2nd Semester</option>
                                    <option value="3rd">3rd Semester</option>
                                </select>
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