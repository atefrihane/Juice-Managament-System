<?php

namespace App\Modules\MachineRental\Controllers;

use App\Modules\Bac\Models\Bac;
use App\Modules\Machine\Models\Machine;
use App\Modules\MachineRental\Models\MachineRental;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MachineRentalController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("MachineRental::index");
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
    public function store(Request $request)
    {
        //
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
        $rental = MachineRental::find($id);
        return view('MachineRental::detailRentalMachine', compact('rental'));
    }

    public function showAllRentals($id){
        if($_GET['machine'])
           $rentals =  MachineRental::where('machine_id', $id)->get();
        else
            $rentals = MachineRental::where('store_id', $id)->get();
        return view('MachineRental::listRentals', compact('rentals'));
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function endMachineRental($id){
        $rental = MachineRental::find($id);
        return view('MachineRental::stopRental', compact('rental'));
    }

    public function endRental(Request $request, $id){

        MachineRental::where('id', $id)->update(['end_reason'=> $request->end_reason, 'date_fin'=> $request->date_fin,'active'=> false, 'Comment' => $request->comment]);
        $rental = MachineRental::find($id);
        Machine::where('id', $rental->machine_id)->update(['rented'=> false]);
        Bac::where('machine_id', $rental->machine_id)->delete();
        return redirect(route('showMachines'));

    }
}
