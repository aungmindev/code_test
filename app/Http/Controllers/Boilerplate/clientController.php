<?php

namespace App\Http\Controllers\Boilerplate;

use App\Events\crudEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\clientValidate;
use App\Models\Client;
use Illuminate\Http\Request;

class clientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::withoutTrashed()->paginate(10);
        $trashclients = Client::onlyTrashed()->paginate(10);
        return view('boilerplate::client' , compact('clients' , 'trashclients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(clientValidate $request)
    {
        
        if($request->hasFile('photo')){
            $file =  $request->file('photo');
            $file_name =  $request->file('photo')->getClientOriginalName();
            $file->storeAs('public/images/products',$file_name);
        }else{
            $file_name = 'unknown.png';
        }
        Client::create([
            "name"    =>  $request->get('name'),
            "email"   => $request->get('email'),
            "phone"   => $request->get('phone'),
            "address" => $request->get('address'),
            "photo"   => $file_name,
        ]);
        crudEvent::dispatch(Auth()->user()->id , ' created client');
        return redirect()->back()->with('success', 'Client is created successfully.');  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if($request->hasFile('photo')){
            $file =  $request->file('photo');
            $file_name =  $request->file('photo')->getClientOriginalName();
            $file->storeAs('public/images/products',$file_name);
        }else{
            $file_name = $request->get('photoHN');
        }
       Client::where('id' , $request->get('clientId'))->update([
        "name"    =>  $request->get('name'),
        "email"   => $request->get('email'),
        "phone"   => $request->get('phone'),
        "address" => $request->get('address'),
        "photo"   => $file_name,
       ]);
       crudEvent::dispatch(Auth()->user()->id , ' updated Clients');
       return redirect()->back()->with('success', 'Successfully updated'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Client::where('id',$id)->delete();
        crudEvent::dispatch(Auth()->user()->id , ' softly deleted clients');
        return redirect()->back()->with('success', 'Successfully deleted'); 

    }
    public function forcedestroy($id)
    {
        Client::onlyTrashed()->where('id',$id)->forceDelete();
        crudEvent::dispatch(Auth()->user()->id , ' forcely deleted clients');
        return redirect()->back()->with('success', 'Completely deleted');

    }
     public function restore($id)
    {
        Client::onlyTrashed()->find($id)->restore();
        crudEvent::dispatch(Auth()->user()->id , ' restored client');
        return redirect()->back()->with('success', 'Successfully restored'); 

    }
}
