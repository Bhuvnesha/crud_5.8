@extends('parent')


@section('main')

@if($errors->any())
	<div class="alert alert-danger">
		<ul>
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>

@endif

<div align="right">
	<a href="{{ route('crud.index') }}" class="btn btn-sm btn-info">Back</a>	
</div>

<form action="{{ route('crud.store') }}" method="POST" enctype="multipart/form-data">
	
	{{ csrf_field() }}
	
	<div class="row">
		<div class="form-group">
		    <div class="col-sm-6">
			   <label for="first name">First Name</label>
		    </div>
		    <div class="col-sm-6">
			   <input type="text" placeholder="Enter first name" name='first_name' class="form-control">
		    </div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="form-group">
		    <div class="col-sm-6">
			   <label for="last name">Last Name</label>
		    </div>
		    <div class="col-sm-6">
			   <input type="text" placeholder="Enter last name" name='last_name' class="form-control">
		    </div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="form-group">
			<input type="file" name='image' class='form-control'>
		</div>
	</div>
	<div class="row">
		<input type="submit" name="submit" class='btn btn-sm btn-primary'>
	</div>
</form>

@endsection