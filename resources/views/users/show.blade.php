@php
    $user_info;
    if(isset($user->student->id)){
        $user_info = $user->student->student;
    }else{
        $user_info = $user->faculty->faculty;
    }
@endphp
@extends('layouts.adminlte')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ $user->username }} | {{ $user->userInfo()->fullname('') }}</h1>
            </div>
            <div class="col-md-6 text-right">
                @if($user->is_verified == 1)
                <a href="{{ route('users.deactivate', $user->id) }}" class="btn btn-danger"><i class="fa fa-lock"></i> Deactivate</a>
                @else
                <a href="{{ route('users.activate', $user->id) }}" class="btn btn-success"><i class="fa fa-check"></i> Activate</a>
                @endif
                <a href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('users.edit', $user->id) }}" data-target="#editUser" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a>
                <a href="{{ route('users.index') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <legend>Avatar</legend>
                <form action="{{ route('users.change_avatar', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <img id="img" width="100%" class="img-thumbnail" style="border: none; background-color: transparent" src="{{ asset($user->avatar()) }}" />
                        <div class="btn-group btn-block">
                            <label type="button" class="btn btn-primary">
                                Browse&hellip;<input value="" type="file" name="image" style="display: none;" id="upload" accept="image/png, image/jpeg" required/>
                            </label>
                            <label type="button" class="btn btn-primary">
                                Upload<input type="submit" style="display: none;" />
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-3">
                <legend>Change Password</legend>
                <form action="{{ route('users.change_password', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input id="new_password" name="new_password" type="password" class="form-control {{ $errors->has('new_password') ? 'is-invalid' : '' }}" required>
                        @if($errors->has('new_password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('new_password') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="new_password_confirmation">Confirm New Password</label>
                        <input id="new_password_confirmation" name="new_password_confirmation" type="password" class="form-control {{ $errors->has('new_password_confirmation') ? 'is-invalid' : '' }}" required>
                        @if($errors->has('new_password_confirmation'))
                            <div class="invalid-feedback">
                                {{ $errors->first('new_password_confirmation') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-block" type="submit">Save</button>
                    </div>
                </form>
            </div>
            <div class="col-md-3">
                <legend>Account Info</legend>
                @if($user->is_verified == 0)
                    @isset($user->student->id)
                    <label>School ID::</label>
                    <button class="btn btn-sm btn-info" type="button" data-toggle="modal" data-target="#viewSchoolIDImage">View</button>
                    @endif
                    <br>
                @endif
                <label class="mb-0">Status:</label>
                @if($user->is_verified == 1)
                <span class="badge badge-success">Verified</span>
                @else
                <span class="badge badge-warning">Under Validation</span>
                @endif
                <br>
                <label class="mb-0">Role:</label>
                {{ $user->role->name }}
                <br>
                <label class="mb-0">Username:</label>
                {{ $user->username }}
                <br>
                <label class="mb-0">Email:</label>
                {{ $user->email }}
            </div>
            <div class="col-md-3">
                <legend>Your Info</legend>
                @isset($user->student->id)
                    <label class="mb-0">Student ID:</label>
                    {{ $user_info->student_id }}
                    <br>
                    <label class="mb-0">Year Level:</label>
                    {{ $user_info->year_level }}
                    <br>
                @else
                    <label class="mb-0">Faculty ID:</label>
                    {{ $user_info->faculty_id }}
                    <br>
                @endisset
                <label class="mb-0">First Name:</label>
                {{ $user_info->first_name }}
                <br>
                <label class="mb-0">Middle Name:</label>
                {{ $user_info->middle_name }}
                <br>
                <label class="mb-0">Last Name:</label>
                {{ $user_info->last_name }}
                <br>
                <label class="mb-0">Suffix:</label>
                {{ $user_info->suffix }}
                <br>
                <label class="mb-0">Gender:</label>
                {{ $user_info->gender }}
                <br>
                <label class="mb-0">Contact #:</label>
                {{ $user_info->contact_number }}
                <br>
                <label class="mb-0">Address #:</label>
                {{ $user_info->address }}
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="viewSchoolIDImage" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">School ID</h5>
                <a href="javascript:void(0)" class="close" data-dismiss="modal" data-target="#viewSchoolIDImage">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body text-center">
                <img src="{{ asset($user->schoolIDImage()) }}" alt="" class="img-thumbnail">
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(function(){
        $('#upload').change(function(){
            var input = this;
            var url = $(this).val();
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
            {
                var reader = new FileReader();
                
                reader.onload = function (e) {
                    $('#img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        });
    });
</script>
@endsection

    