Laravel crud project:
Step 1: create a project in the composer
cmd: composer create-project laravel/laravel=5.8 crud --prefer-dist

Step 2: go to config/database.php and edit the database credentials.  Also change the database credentials in .env file.

Step 3: create a migration file to create a table in the database.
cmd: php artisan make:migration create_sample_data_table --create=sample_data

Step 4: edit migration file and add 3 columns first_name, last_name, image.
$table->string('first_name');
$table->string('last_name');
$table->string('imge');

Step 5: create a table in the database using the command.
cmd: php artisan migrate

Step 6: create a model to perform database operation.
cmd: php artisan make:model Crud -m

in the model page edit 
protected fillable = [first_name, last_name, image];

Step 7: create a controller using the command.
cmd: php artisan make:controller CrudController --resource

How to display the records into the view?

Step 1: Go to CrudController under index method. Add the model Crud with method latest and paginate property and specify the number of records.

for example: $data = CRUD::latest()->paginate(5);
 return view('index',compact('data'))->with('i',(request()->input('page',1)-1)*5);

Step 2: create 5 view files.
file 1: create.blade.php
file 2: edit.blade.php
file 3: index.blade.php
file 4: view.blade.php
file 5:parent.blade.php


Step 3: edit parent.blade.php
i)add all the bootstrap cdn files 
ii)In the body section add div.class="container", add title="Laravel 5.4 Crud tutorial" aligning at the centre.

below add @yield('main')

Step 4: edit index.blade.php, 
@extends('parent') - this will acts as a require command used in php.
@section('main') - will include the main yield code of the file.

@section('main')
<table class="table table-bordered table-striped">
   <tr>
          <th width="10%">Image</th>
          <th width="35%">First Name</th>
          <th width="35%">Last Name</th>
          <th width="30%">Action</th>
  </tr>
  @foreach($data as $row)
   <tr>
           <td><img src = "{{ URL::to('/')  }}images/{{ $row->image }}" class="img-thumbnail" width="75"></td>
            <td>{{ $row->first_name }}</td>
            <td>{{ $row->last_name }}</td>
            <td></td>
   </tr>         
  @endforeach
</table>
{!! $data->links() !!}
@endsection


Step 5: set the route, go to Routes/web.php
Route::resource('crud','CrudsController');

Step 6: fetch the url of the laravel server
php artisan serve

How to insert data into the database?
Step 1: Go to CrudController under create method and return create page in the view.

example: return view('create');

Step 2: Create a view page create.blade.php and add form to it.

example:
<form method="post" action="{{ route('crud.store') }}" enctype="multipart/form-data">
     @csrf
</form>

Step 3: store method in the crudcontroller.
first we need to validate the inputs.
$request->validate[
     'first_name' => 'required',
     'last_name'  => 'required',
     'image'  => 'required|image|max:2048'
];
$image = $request->file('image');
//generate new image name
$new_name = rand() . '.' . $image->getClientOriginalExtension();
//move the uploaded file with a new name inside public path inside image directory
$image->move(public_path('images'),$new_name);

//create a form data in an array
$form_data = array(
   'first_name' => $request->first_name,
   'last_name'  => $request->last_name,
   'image' => $new_name
);

//insert data into the table
Crud::create($form_data);

//return to crud list
return redirect('crud')->with('success','Data added successfully');

Step 4: go to index.blade.php to display the message if data is inserted successfully.
<div align="right">
       <a href="{{ route('crud.create') }}" class="btn btn-success btn-sm">Add</a>
</div>
@if($message = Session::get('success'))
<div class='alert alert-success'>
   <p>{{ $message }}</p>
</div>
@endif

Step 6: go to create.blade.php and add if condition to check validation. create back button
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
     <a href="{{ route('crud.index') }}" class="btn btn-default">Back</a>
</div>

How to view the data?
Step 1: add anchor tag to show each employee to edit.
<a href="{{ route('crud.show', $row->id }}" class="btn btn-primary">Show</a>

Step 2: go to crudController and use findOrFail() to fetch the specific data.
$data = Crud::findOrFail($id);
return view('view',compact('data'));

Step 3: Create a view of that specified resource.

<div class="jumbodron text-center" >
       <div align="right">
           <a href="{{ route('crud.index') }}" class="btn btn-sm btn-default">Back</a>
       </div>
         
       <br>
       <img class="img-thumbnail" src="{{ URL::to('/') }}/images/{{ $data->image }}">
        <br>
         <h3>First Name: {{ $data->first_name }}</h3>
         <h3>Last Name: {{ $data->last_name }}</h3>
</div>

How to edit the data?
Step 1: Go to edit.blade.php, add table data next to show button.
<a href={{ route('crud.edit'), $row->id }}} class="btn btn-sm btn-warning">Edit</a>

Step 2: 
