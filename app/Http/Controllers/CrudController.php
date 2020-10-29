<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Crud;

class CrudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $data = Crud::latest()->paginate(5);
       return view('index',compact('data'))->with('i',(request()->input('page',1)-1)*5);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate the input fields
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'image' => 'required|image'
        ]);

        $image = $request->file('image');

        //generate the random name for the image
        $new_name = rand().'.'.$image->getClientOriginalExtension();

        //move the uploaded file with new name inside public image directory
        $image->move(public_path('images'),$new_name);

        //create a form_data in an array
        $form_data = array(
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'image' => $new_name
        );

        //insert data into the table
        Crud::create($form_data);


        //return to crud list
        return redirect('crud')->with('success','record created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Crud::findOrFail($id);

        return view('view',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Crud::findOrFail($id);
        // echo json_encode($data);
        return view('edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name'  => 'required'        
        ]);

         // $image = $request->file('image');

        //generate the random name for the image
        // $new_name = rand().'.'.$image->getClientOriginalExtension();

        //move the uploaded file with new name inside public image directory
        // $image->move(public_path('images'),$new_name);

        $first_name = $request->first_name;
        $last_name = $request->last_name;

        //update 
        $data = Crud::find($id);

        $data->first_name = $first_name;
        $data->last_name = $last_name;
        // $data->image = $new_name;

        $data->save();
        
         //return to crud list
        return redirect('crud')->with('success','record updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Crud::find($id);
        $image_name = $data->image;
        unlink(public_path('images'.'/'.$image_name));
        $data->delete();
        return redirect('crud')->with('success','record deleted successfully!');


    }
}
