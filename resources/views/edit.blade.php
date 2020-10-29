@extends('parent')


@section('main')

@if($errors->any())

<div class="alert alert-success">
	
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
<h3>Edit</h3>
<form action="{{ route('crud.update', $data->id) }}" method="POST" enctype="multipart/form-data">

	{{ csrf_field() }}
	{{ method_field('PUT') }}
	<div class="row">
		<div class="jumbotron">
			<div class="row" style="text-align:center">
				<img src="{{ URL::to('/') }}/images/{{ $data->image }}" alt="{{ $data->first_name }}" class="img/thumbnail">
			 <br>
			 <br>
				<input type="file" name="image" class="form-control" >
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<label for="first name">First Name</label>
		</div>
		<div class="col-md-6">
		    <input type="text" name="first_name" class="form-control" value="{{ $data->first_name }}">	
		</div>
	</div>
    <br>
	<div class="row">
		<div class="col-md-6">
			<label for="last name">Last Name</label>
		</div>
		<div class="col-md-6">
		    <input type="text" name="last_name" class="form-control" value="{{ $data->last_name }}">	
		</div>
	</div>
     <br>
	<div class="row">
		<input type="submit" value="Update" name="submit" class="btn btn-sm btn-primary">
	</div>
</form>

@endsection