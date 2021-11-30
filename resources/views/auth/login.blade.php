@extends('layouts.adminlte')
@section('content')
<div class="content">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-default mt-5">
                <div class="card-header">
                    <h3 class="card-title">Login</h3>
                </div>
                <form action="{{ route('login') }}" class="form-horizontal" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="inputUsername3" class="col-sm-4 col-form-label">Username</label>
                            <div class="col-sm-8">
                                <input type="text" name="username" class="form-control" id="inputUsername3" placeholder="Username" value="{{ old('username') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-4 col-form-label">Password</label>
                            <div class="col-sm-8">
                                <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="offset-sm-4 col-sm-8">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                                @endif
                                {{-- <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck2">
                                    <label class="form-check-label" for="exampleCheck2">Remember me</label>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-info">Sign in</button>
                        {{-- <button type="submit" class="btn btn-default float-right">Cancel</button> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection