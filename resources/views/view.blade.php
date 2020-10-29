@extends('parent')


@section('main')

<div class="jumbotron" align="center">
	<div align="right">
		<a href="{{ route('crud.index') }}" class="btn btn-sm btn-info">Back</a>
	</div>
	<br>
	<img src="{{ URL::to('/') }}/images/{{ $data->image }}" alt="{{ $data->firstname }}" class="img/thumbnail">

	<h3>First Name: {{ $data->first_name }}</h3>
	<h3>Last Name: {{ $data->last_name }}</h3>
</div>

@endsection