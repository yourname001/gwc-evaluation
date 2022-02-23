<form action="{{ route('students.store') }}" method="POST" autocomplete="off">
    @csrf
    <div class="modal fade" id="createStudent" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Student</h5>
                    <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Student ID: <strong class="text-danger">*</strong></label>
                                <input class="form-control" oninput="this.value = this.value.toUpperCase()" type="text" name="student_id" required>
                            </div>
                            <div class="form-group">
                                <label>Course: <strong class="text-danger">*</strong></label>
                                <select name="course" class="form-control select2" required>
                                    <option></option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Year Level: <strong class="text-danger">*</strong></label>
                                <input type="number" class="form-control" name="year_level">
                            </div>
                            <div class="form-group">
                                <label class="required">First Name: <strong class="text-danger">*</strong></label><br>
                                <input class="form-control" oninput="this.value = this.value.toUpperCase()" type="text" name="first_name" required>
                            </div>
                            <div class="form-group">
                                <label>Middle Name:</label><br>
                                <input class="form-control" oninput="this.value = this.value.toUpperCase()" type="text" name="middle_name">
                            </div>
                            <div class="form-group">
                                <label>Last Name: <strong class="text-danger">*</strong></label>
                                <input class="form-control" oninput="this.value = this.value.toUpperCase()" type="text" name="last_name" required>
                            </div>
                            <div class="form-group">
                                <label>Suffix:</label><br>
                                <input class="form-control" oninput="this.value = this.value.toUpperCase()" type="text" name="suffix">
                            </div>
                            <div class="form-group">
                                <label>Gender: <strong class="text-danger">*</strong></label>
                                <div class="form-row">
                                    <div class="radio col-md-4">
                                        <div class="custom-control custom-radio">
                                            <input required type="radio" class="custom-control-input" name="gender" value="male" id="male">
                                            <label class="custom-control-label" for="male">Male</label>
                                        </div>
                                    </div>
                                    <div class="radio col-md-4">
                                        <div class="custom-control custom-radio">
                                            <input required type="radio" class="custom-control-input" name="gender" value="female" id="female">
                                            <label class="custom-control-label" for="female">Female</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="form-group">
                                <label>Contact #:</label><br>
                                <input class="form-control" type="tel" pattern="^(09|\+639)\d{9}$" name="contact_number">
                            </div>
                            <div class="form-group">
                                <label>Address:</label>
                                <textarea class="form-control" name="address" rows="3"></textarea>
                            </div> --}}
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="checkbox">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="add_user_account" value="1" id="addUserAccount">
                                        <label class="custom-control-label" for="addUserAccount">Add User Account</label>
                                    </div>
                                </div>
                            </div>
                            <div id="userCredentials">
                                <div class="form-group">
                                    <label>Email: <strong class="text-danger">*</strong></label>
                                    <input class="form-control" type="email" name="email" required>
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