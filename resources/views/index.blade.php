@extends('parent')

@section('main')

<div align="right">
	<br>
	<a href="{{ route('crud.create') }}" class="btn btn-sm btn-primary">Add</a>
	<br>
</div>


<br>
@if($message = Session::get('success'))
<div class="alert alert-success">
	<p>{{ $message }}</p>
</div>

@endif
<table class='table table-bordered table-striped'>
	<tr>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Image</th>
		<th>Action</th>
		
	</tr>
	<tbody>
		@foreach($data as $row)
			<tr>
				<td>{{ $row->first_name }}</td>
				<td>{{ $row->last_name }}</td>
				<td><img style="width:50px;height:50px;text-align:center" src="{{ URL::to('/') }}/images/{{ $row->image }}" alt="{{ $row->image }}" class='img-thumbnail'></td>
				<td>
					<a href="{{ Route('crud.show', $row->id) }}" class="btn btn-sm btn-info" >Show</a>
					|
					<a href="{{ Route('crud.edit', $row->id) }}" class="btn btn-sm btn-warning">Edit</a>
					|
					<form action="{{ Route('crud.destroy', $row->id) }}" method="POST">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}
						<button class="btn btn-sm btn-danger">Delete</button>
					</form>

				</td>
			</tr>
		@endforeach
	</tbody>

</table>
{!! $data->links() !!}

@endsection