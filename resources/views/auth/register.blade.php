@extends('layouts.adminlte')
@section('content')
<div class="content">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-default mt-5">
                <div class="card-header">
                    <h3 class="card-title">Register</h3>
                </div>
                <form action="{{ route('student_registration.register') }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
						<div class="form-group row">
							<div class="col-sm-4">
								<label>School ID <strong class="text-danger">*</strong></label>
							</div>
							<div class="col-sm-8">
								{{-- <div class="input-group">
									<div class="custom-file">
										<input type="file" class="custom-file-input" id="exampleInputFile" name="school_id" accept="image/*">
										<label class="custom-file-label" for="exampleInputFile">Choose file</label>
									</div>
								</div> --}}
								<input type="file" name="school_id" accept="image/png, image/jpeg, image/jpg" required><br>
								<i>upload a clear photo of your School ID for validation</i>
							</div>
						</div>
                        <div class="form-group row">
							<label for="inputStudentID" class="col-sm-4 col-form-label">Student ID <strong class="text-danger">*</strong></label>
							<div class="col-sm-8">
								<input type="text" name="student_id" class="form-control" id="inputStudentID" placeholder="Student ID" value="{{ old('student_id') }}" required>
							</div>
						</div>
						<div class="form-group row">
							<label for="inputYearLevel" class="col-sm-4 col-form-label">Year Level <strong class="text-danger">*</strong></label>
							<div class="col-sm-8">
								<input type="number" max="4" min="1" name="year_level" class="form-control" id="inputYearLevel" placeholder="Year Level" value="{{ old('year_level') }}" required>
							</div>
						</div>
						<div class="form-group row">
							<label for="inputFirstName" class="col-sm-4 col-form-label">First Name <strong class="text-danger">*</strong></label>
							<div class="col-sm-8">
								<input type="text" name="first_name" class="form-control" id="inputFirstName" placeholder="First Name" value="{{ old('first_name') }}" required>
							</div>
                        </div>
						<div class="form-group row">
							<label for="inputMiddleName" class="col-sm-4 col-form-label">Middle Name</label>
							<div class="col-sm-8">
								<input type="text" name="middle_name" class="form-control" id="inputMiddleName" placeholder="Middle Name" value="{{ old('middle_name') }}">
							</div>
                        </div>
						<div class="form-group row">
							<label for="inputLastName" class="col-sm-4 col-form-label">Last Name <strong class="text-danger">*</strong></label>
							<div class="col-sm-8">
								<input type="text" name="last_name" class="form-control" id="inputLastName" placeholder="Last Name" value="{{ old('last_name') }}" required>
							</div>
						</div>
						<div class="form-group row">
							<label for="inputSuffix" class="col-sm-4 col-form-label">Suffix</label>
							<div class="col-sm-8">
								<input type="text" name="suffix" class="form-control" id="inputSuffix" placeholder="Suffix" value="{{ old('suffix') }}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Gender <strong class="text-danger">*</strong></label>
							<div class="col-sm-8">
								<div class="custom-control custom-radio">
									<input class="custom-control-input" name="gender" type="radio" id="genderMale" value="male" @if(old('gender') == 'male') checked @endif>
									<label for="genderMale" class="custom-control-label">Male</label>
								</div>
								<div class="custom-control custom-radio">
									<input class="custom-control-input" name="gender" type="radio" id="genderFemale" value="female" @if(old('gender') == 'female') checked @endif>
									<label for="genderFemale" class="custom-control-label">Female</label>
								</div>
							</div>
						</div>
						<hr>
						<div class="form-group row">
							<label for="inputEmail" class="col-sm-4 col-form-label">Email <strong class="text-danger">*</strong></label>
							<div class="col-sm-8">
								<input type="email" name="email" class="form-control" id="inputEmail" placeholder="Email" value="{{ old('email') }}">
							</div>
						</div>
                        {{-- <div class="form-group row">
							<label for="inputPassword" class="col-sm-4 col-form-label">Password <strong class="text-danger">*</strong></label>
							<div class="col-sm-8">
								<input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password">
							</div>
                        </div>
                        <div class="form-group row">
							<label for="inputPasswordConfirmation" class="col-sm-4 col-form-label">Confirm Password <strong class="text-danger">*</strong></label>
							<div class="col-sm-8">
								<input type="password" name="password_confirmation" class="form-control" id="inputPasswordConfirmation" placeholder="Confirm Password">
							</div>
                        </div> --}}
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-info">Register</button>
                        {{-- <button type="submit" class="btn btn-default float-right">Cancel</button> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection