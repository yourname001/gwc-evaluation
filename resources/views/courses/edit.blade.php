<form action="{{ route('courses.update', $course->id) }}" method="POST" autocomplete="off">
    @csrf
    @method('PUT')
    <div class="modal fade" id="editCourse" data-backdrop="static" data-keyboard="false" tabindex="-1" faculty="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" faculty="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Course</h5>
                    <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Course Code:</label>
                                <input class="form-control" type="text" name="course_code" value="@if(is_null(old('course_code'))){{ $course->course_code }}@else{{ old('course_code') }}@endif" required>
                            </div>
                            <div class="form-group">
                                <label>Title:</label>
                                <input class="form-control" type="text" name="title" value="@if(is_null(old('title'))){{ $course->title }}@else{{ old('title') }}@endif" required>
                            </div>
                            <div class="form-group">
                                <label>Description:</label>
                                <textarea name="description" rows="4" class="form-control">@if(is_null(old('title'))){{ $course->title }}@else{{ old('title') }}@endif</textarea>
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