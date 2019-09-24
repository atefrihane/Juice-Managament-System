<?php

namespace App\Modules\MachineRental\Controllers\api;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Modules\MachineRental\Models\MachineRental;
use App\Modules\Machine\Models\Machine;
use Illuminate\Http\Request;

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
        $checkMachine=Machine::find($request->id);
        if($checkMachine)
        {
            $checkMachine->update(['rented' => 1]);

        }
        $checkRenal=MachineRental::where('machine_id',$checkMachine->id)
        ->where('active',1)
        ->first();
        if($checkRenal)
        {
            return response()->json(['status'=>400]);


        }
        $parsedStartDate = Carbon::parse($request->startDate)->toDateTimeString();
        $parsedEndDate =   Carbon::parse($request->endDate)->toDateTimeString();

        if($parsedEndDate < $parsedStartDate) {

            return response()->json(['status'=>405]);
        }
   
        MachineRental::create([
            'date_debut'=>$parsedStartDate,
            'date_fin'=>$parsedEndDate,
            'location'=>$request->location,
            'Comment'=>$request->comment,
            'price'=>$request->price,
            'active'=>$request->active,
            'store_id'=>$request->storeId,
            'machine_id'=>$request->id,

        ]);

            return response()->json(['status'=>200]);
       
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
}
