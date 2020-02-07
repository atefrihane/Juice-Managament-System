<?php

namespace App\Modules\MachineRental\Controllers\api;

use App\Http\Controllers\Controller;
use App\Modules\BacHistory\Models\BacHistory;
use App\Modules\Bac\Models\Bac;
use App\Modules\MachineRental\Models\MachineRental;
use App\Modules\MachineRental\Models\MachineRentalHistory;
use App\Modules\Machine\Models\Machine;
use Carbon\Carbon;
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
     

        $parsedStartDate = Carbon::parse($request->startDate)->toDateString();
        $parsedEndDate = Carbon::parse($request->endDate)->toDateString();

        $checkMachine = Machine::find($request->id);

        if ($checkMachine) {
           if($checkMachine->rented)
           {
            return response()->json(['status' => 403]);
           }

            $checkRenal = MachineRental::where('date_debut', '=', $parsedStartDate)
                ->where('date_fin', '=', $parsedEndDate)
                ->where('active', 1)
                ->first();

            if ($checkRenal) {
                return response()->json(['status' => 400]);

            }

            if ($parsedEndDate < $parsedStartDate) {

                return response()->json(['status' => 405]);
            }

            $rental = MachineRental::create([
                'date_debut' => $parsedStartDate,
                'date_fin' => $parsedEndDate,
                'location' => $request->localisation,
                'Comment' => $request->comment,
                'price' => $request->price,
                'active' => $request->active,
                'store_id' => $request->storeId,
                'machine_id' => $request->id,

            ]);

         

            $checkMachine->update(['rented' => 1]);
            MachineRentalHistory::create([
                'action' => 'Création',
                'machine_rental_id' => $rental->id,
                'user_id' => $request->userId,
            ]);

            return response()->json(['status' => 200]);

        }

        return response()->json(['status' => 404]);

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

    public function handleUpdateRental($id, Request $request)
    {

        $rental = MachineRental::find($id);
        if ($rental) {
            if ($request->endDate < $rental->date_debut) {
                return response()->json(['status' => 400]);

            }
            $rental->update([
                'date_debut' => $request->startDate,
                'date_fin' => $request->endDate,
                'location' => $request->location,
                'Comment' => $request->comment,
                'price' => $request->price,
                'end_reason' => $request->end_reason,
            ]);
     

            MachineRentalHistory::create([
                'action' => 'Modification',
                'machine_rental_id' => $rental->id,
                'user_id' => $request->userId,
            ]);
            return response()->json(['status' => 200]);

        }
        return response()->json(['status' => 404]);

    }
    public function handleGetRentalData($id)
    {
        $rental = MachineRental::find($id);

        if ($rental) {
            $bacs = Bac::where('machine_id', $rental->machine->id)->with('product', 'product.mixtures')->get();
            return response()->json(['status' => 200, 'bacs' => $bacs]);
        }
        return response()->json(['status' => 404]);

    }
}
