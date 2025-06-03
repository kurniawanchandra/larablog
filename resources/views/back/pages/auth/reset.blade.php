@extends('back.layout.auth-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Auth')
@section('content')
<div class="login-box bg-white box-shadow border-radius-10">
	<div class="login-title">
		<h2 class="text-center text-primary">Reset Password</h2>
	</div>
	<h6 class="mb-20">Enter your new password, confirm and submit</h6>
	<form action="{{ route('admin.reset_password_handler') }}" method="POST">
		<x-forms-alerts></x-forms-alerts> 
		@csrf
		<div class="input-group custom mb-1">
			<input type="password" name="new_password" class="form-control form-control-lg" placeholder="New Password">
			<div class="input-group-append custom">
				<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
			</div>
		</div>
		@error('new_password')
		<span class="text-danger ml-1">{{ $message }}</span>
		@enderror
		<div class="input-group custom mb-1 mt-3">
			<input type="password" name="new_password_confirmation" class="form-control form-control-lg"
				placeholder="Confirm New Password">
			<div class="input-group-append custom">
				<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
			</div>
		</div>
		@error('new_password_confirmation')
		<span class="text-danger ml-1">{{ $message }}</span>
		@enderror
		<div class="row align-items-center mt-2">
			<div class="col-5">
				<div class="input-group mb-0">
					<input class="btn btn-primary btn-lg btn-block" type="submit" value="Submit">
					{{-- <a class="btn btn-primary btn-lg btn-block" href="index.html">Submit</a> --}}
				</div>
			</div>
		</div>
	</form>
</div>

</div>
@endsection