<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Carbon\Carbon;
use App\Models\Charge;
use App\Models\Invoice;
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
    {//return $request->all();
        // Bring all properties by residence
        $invoice = Invoice::findOrFail($request->invoice_id);
        $invoice->update([
            'start' => $request->start,
            'end' => $request->end,
            'percentage_prontopago' => $request->percentage_prontopago
        ]);
        // Creating prontoPago
        $prontopagos = [];
        foreach ($invoice->residence->properties as $property) {
            $amount = $invoice->total * ($property->alicuota / 100);
            $amount = ($amount + ($amount * ($invoice->residence->reserve_percentage / 100)));
            $pronto = ProntoPago::create([
                'property_id' => $property->id,
                'invoice_id' => $invoice->id,
                'amount' => $amount
            ]);
            array_push($prontopagos,$pronto);
        }
        return ApiHelpers::ApiResponse('200', 'Created Successfully', [
            'invoice' => $invoice,
            'residence' => $invoice->residence,
            'prontopagos' => $prontopagos
        ]);

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
