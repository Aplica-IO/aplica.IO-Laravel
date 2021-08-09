<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Carbon\Carbon;
use App\Models\Charge;
use App\Models\Property;
use App\Models\Residence;
use App\Models\ProntoPago;
use App\Helpers\ApiHelpers;
use Illuminate\Http\Request;

class ProntoPagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return ApiHelpers::ApiResponse('200', 'á', [Carbon::now()->sub('4 hours')->format('Y-m-d')]);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //  Get invoice
        $invoice = Invoice::findOrFail($request->invoice_id);
        // Create charge
        $total = ($request->percentage_prontopago / 100) * $invoice->total;
        $charge = Charge::create([
            'invoice_id' => $request->invoice_id,
            'bcv' => $request->bcv,
            'name' => 'Gasto de ProntoPago',
            'amount' => $total,
            'spend_date' => $request->command_date,
            'type' => 4
        ]);
        $charge->invoice->percentage_prontopago = $request->percentage_prontopago;
        $charge->invoice->save();
        // Bring all properties by residence
        // Bc needs to take all alicuota to create prontoPago item
        $residence = Residence::findOrFail($request->residence_id);
        $residence->properties;
        $pronto = [];
        // Creating prontoPago
        foreach ($residence->properties as $property) {
            $amount = $total * ($property->alicuota / 100);
            $prontoQuery = ProntoPago::create([
                'property_id' => $property->id,
                'invoice_id' => $request->invoice_id,
                'amount' => $amount,
                'command_date' => $request->command_date,
                'charge_id' => $charge->id
            ]);
            array_push($pronto, $prontoQuery);
        }
        $charge->invoice;
        return ApiHelpers::ApiResponse('200', 'Created Successfully', [$pronto, $charge]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProntoPago  $prontoPago
     * @return \Illuminate\Http\Response
     */
    public function show(ProntoPago $prontoPago)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProntoPago  $prontoPago
     * @return \Illuminate\Http\Response
     */
    public function edit(ProntoPago $prontoPago)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProntoPago  $prontoPago
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProntoPago $prontoPago)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProntoPago  $prontoPago
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProntoPago $prontoPago)
    {
        //
    }
}
