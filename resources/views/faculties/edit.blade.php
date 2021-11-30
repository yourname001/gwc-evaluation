<form action="{{ route('faculties.update', $faculty->id) }}" method="POST" autocomplete="off">
    @csrf
    @method('PUT')
    <div class="modal fade" id="editFaculty" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Faculty</h5>
                    <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Department:</label><br>
                                <select name="department"class="form-control select2">
                                    <option></option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" @if($faculty->department_id == $department->id) selected @endif>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Faculty ID:</label><br>
                                <input class="form-control" type="text" name="faculty_id" required value="{{ $faculty->faculty_id }}">
                            </div>
                            <div class="form-group">
                                <label>First Name:</label><br>
                                <input class="form-control" type="text" name="first_name" value="{{ $faculty->first_name }}" required>
                            </div>
                            <div class="form-group">
                                <label>Middle Name:</label><br>
                                <input class="form-control" type="text" name="middle_name" value="{{ $faculty->middle_name }}" required>
                            </div>
                            <div class="form-group">
                                <label>Last Name:</label><br>
                                <input class="form-control" type="text" name="last_name" value="{{ $faculty->last_name }}" required>
                            </div>
                            <div class="form-group">
                                <label>Suffix:</label><br>
                                <input class="form-control" type="text" name="suffix" value="{{ $faculty->suffix }}">
                            </div>
                            <div class="form-group">
                                <label>Gender:</label><br>
                                <div class="form-row">
                                    <div class="radio col-md-4">
                                        <div class="custom-control custom-radio">
                                            <input required type="radio" class="custom-control-input" name="gender" value="Male" id="male" @if($faculty->gender == 'Male') checked @endif>
                                            <label class="custom-control-label" for="male">Male</label>
                                        </div>
                                    </div>
                                    <div class="radio col-md-4">
                                        <div class="custom-control custom-radio">
                                            <input required type="radio" class="custom-control-input" name="gender" value="Female" id="female" @if($faculty->gender == 'Female') checked @endif>
                                            <label class="custom-control-label" for="female">Female</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Contact #:</label><br>
                                <input class="form-control" type="text" name="contact_number" value="{{ $faculty->contact_number }}">
                            </div>
                            <div class="form-group">
                                <label>Address:</label>
                                <textarea class="form-control" name="address" rows="3">{{ $faculty->address }}</textarea>
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
        addUserCredentials()

        $('#addUserAccount').on('change', function(){
            addUserCredentials()
        })

        function addUserCredentials(){
            if($('#addUserAccount').prop('checked')){
                $('#userCredentials input').attr('disabled', false)
                $('#userCredentials select').attr('disabled', false)
            }else{
                $('#userCredentials input').attr('disabled', true)
                $('#userCredentials select').attr('disabled', true)
            }
        }
    })
</script>