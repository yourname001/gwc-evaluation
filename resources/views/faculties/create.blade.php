<form action="{{ route('faculties.store') }}" method="POST" autocomplete="off">
    @csrf
    <div class="modal fade" id="createFaculty" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Faculty</h5>
                    <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Department:</label><br>
                                <select name="department"class="form-control select2">
                                    <option></option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Faculty ID:</label><br>
                                <input class="form-control" type="text" name="faculty_id" required>
                            </div>
                            <div class="form-group">
                                <label>First Name:</label><br>
                                <input class="form-control" type="text" name="first_name" required>
                            </div>
                            <div class="form-group">
                                <label>Middle Name:</label><br>
                                <input class="form-control" type="text" name="middle_name" required>
                            </div>
                            <div class="form-group">
                                <label>Last Name:</label><br>
                                <input class="form-control" type="text" name="last_name" required>
                            </div>
                            <div class="form-group">
                                <label>Suffix:</label><br>
                                <input class="form-control" type="text" name="suffix">
                            </div>
                            <div class="form-group">
                                <label>Gender:</label><br>
                                <div class="form-row">
                                    <div class="radio col-md-4">
                                        <div class="custom-control custom-radio">
                                            <input required type="radio" class="custom-control-input" name="gender" value="Male" id="male">
                                            <label class="custom-control-label" for="male">Male</label>
                                        </div>
                                    </div>
                                    <div class="radio col-md-4">
                                        <div class="custom-control custom-radio">
                                            <input required type="radio" class="custom-control-input" name="gender" value="Female" id="female">
                                            <label class="custom-control-label" for="female">Female</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Contact #:</label><br>
                                <input class="form-control" type="text" name="contact_number">
                            </div>
                            <div class="form-group">
                                <label>Address:</label>
                                <textarea class="form-control" name="address" rows="3"></textarea>
                            </div>
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
                                <label>Role:</label><br>
                                <select class="form-control select2" name="role" required>
                                    <option></option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-group">
                                    <label>Username:</label><br>
                                    <input class="form-control" type="text" name="username" required>
                                </div>
                                <div class="form-group">
                                    <label>Email:</label><br>
                                    <input class="form-control" type="email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label>Password:</label><br>
                                    <input id="password" type="password" class="form-control" name="password" required>
                                </div>
                                <div class="form-group">
                                    <label>Confirm Password:</label><br>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
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