@extends('layout.profile')
@section('status2','active')
@section('contentprofile')
		<div class="row">
			<div class="col-sm-12">
				<div class="" style="text-align: center;">
					<h2 class="text-primary ">CHANGE PASSWORD</h2>	
				</div>
				<hr class="my-3">
				<div class="row">
					<div class="col-sm-2"></div>
					<div class="col-sm-8">
					<form action="" method="post">
						<div class="form-group">
					    	<label for="curentpassword" class="font-weight-bold">Curent password</label>
					    	<input type="password" class="form-control"  name="curentpassword">
						</div>
						<div class="form-group">
					    	<label for="newpassword" class="font-weight-bold">New password</label>
					    	<input type="password" class="form-control" name="newpassword">
						</div>
						<div class="form-group">
					    	<label for="confirmpass" class="font-weight-bold">Confirm password</label>
					    	<input type="password" class="form-control" name="confirmpass">
						</div>
					  	<div class="d-flex justify-content-center">
					  		<button type="submit" class="btn btn-primary">Save</button>
					  		<button type="reset" class="btn btn-outline-primary " style="margin-left: 10px; ">Reset</button>
						</div>
					</form>
					</div>
				</div>
			</div>
		</div>
@endsection