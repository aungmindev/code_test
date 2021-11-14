<?php

namespace App\Http\Controllers\Boilerplate;

use App\Events\crudEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\billingValidate;
use App\Models\Billing;
use App\Models\Client;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class billingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $billings = Billing::withoutTrashed()->paginate(10);
        $trashedbillings = Billing::onlyTrashed()->paginate(10);
        $clients = Client::withoutTrashed()->get();
        return view('boilerplate::billing',compact('billings' , 'trashedbillings','clients'));
    }

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
    public function store(billingValidate $request)
    {
        Billing::create([
            "amount"    =>  $request->get('amount'),
            "due_date"   => $request->get('duedate'),
            "description"   => $request->get('description'),
            "client_id"   => $request->get('clientid'),
        ]);
        crudEvent::dispatch(Auth()->user()->id , ' created billing');
        return redirect()->back()->with('success', 'Billing is created successfully.');  
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
    public function update(billingValidate $request)
    {
        
        Billing::where('id' , $request->get('id'))->update([
        "amount"    =>  $request->get('amount'),
        "due_date"   => $request->get('duedate'),
        "client_id"   => $request->get('clientid'),
        "description" => $request->get('description'),
       ]);
       crudEvent::dispatch(Auth()->user()->id , ' updated billing');
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
        Billing::where('id',$id)->delete();
        crudEvent::dispatch(Auth()->user()->id , ' softly deleted billing');
        return redirect()->back()->with('success', 'Successfully deleted'); 

    }
    public function forcedestroy($id)
    {
        Billing::onlyTrashed()->where('id',$id)->forceDelete();
        crudEvent::dispatch(Auth()->user()->id , ' forcely deleted billing');
        return redirect()->back()->with('success', 'Completely deleted');

    }
     public function restore($id)
    {
        Billing::onlyTrashed()->find($id)->restore();
        crudEvent::dispatch(Auth()->user()->id , ' restored billing');
        return redirect()->back()->with('success', 'Successfully restored'); 

    }
}
