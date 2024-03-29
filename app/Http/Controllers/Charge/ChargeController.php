<?php

namespace App\Http\Controllers\Charge;

use App\Models\Charge;
use GuzzleHttp\Client;
use App\Models\Invoice;
use App\Models\Property;
use App\Models\Residence;
use App\Helpers\ApiHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Date;
 
class ChargeController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        $index = Charge::with('invoice')->paginate(200);

        return ApiHelpers::ApiResponse(200, 'Successfully completed', $index);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) {
        
        $invoice = Invoice::findOrFail($request->invoice_id);
        $amount = 0;
        if($invoice->currency == 1){
            $amount = $request->amount;
        }
        if($invoice->currency == 2){
            $amount = $request->amount / $request->bcv;
        }
        $charge = Charge::create([
            'invoice_id' => $request->invoice_id,
            'amount' => $amount,
            'bcv' => $request->bcv,
            'name' => $request->name,
            'reason' => $request->reason,
            'spend_date' => $request->spend_date,
            'type' => $request->type,
            'propertyId' => $request->propertyId
        ]);
        
        if($charge->type == 3){
            ApiHelpers::ModifyBalance($request->propertyId,$charge->amount);
            
        }else{
            $op = $invoice->total + $amount;
            $invoice->total = $op;
            $invoice->save();
            ApiHelpers::ProcessResidenceBalanceAndReserve($charge);
        }

        return ApiHelpers::ApiResponse(200, 'Successfully completed', $charge);
    }


    public function storePersonalCharges(Request $request){
        // get invoice
        $invoice = Invoice::findOrFail($request->invoice_id);
        // get amount by currency
        if($invoice->currency == 1){
            $amount = $request->amount;
        }if($invoice->currency == 2){
            $amount = $request->amount / $request->bcv;
        }
        $count = count($request->properties);
        $divided = $amount / $count;

        // operation for each property
        $charges = [];
        $balances = [];
        for($i=0;$i < $count;$i++){
            // creating charge
            $charge = Charge::create([
                'invoice_id' => $request->invoice_id,
                'amount' => $divided,
                'bcv' => $request->bcv,
                'name' => $request->name,
                'reason' => $request->reason,
                'spend_date' => $request->spend_date,
                'type' => 3,
                'propertyId' => $request->properties[$i]
            ]);
            // get property and residence
            $property = Property::findOrFail($request->properties[$i]);
            
            // operation for property
            $op = ($divided * ($invoice->residence->reserve_percentage / 100) + $divided);
            $balance = ApiHelpers::ModifyBalance($property->id,$op);
            array_push($balances, $balance);
            array_push($charges, $charge);
        }

        return ApiHelpers::ApiResponse(200, 'Successfully completed', [$property, $charges, $balances]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id) {
        $show = Charge::with('invoice')->findOrFail($id);

        return ApiHelpers::ApiResponse(200, 'Successfully completed', $show);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id) {
        $charge = Charge::findOrFail($id);

        $charge->update($request->all());

        return ApiHelpers::ApiResponse(200, 'Succesfully completed', $charge);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id) {
        $charge = Charge::with(['invoice'])->where('id',$id)->first();
        foreach($charge->invoice->residence->properties as $property){
            $hasToPay = ($property->alicuota / 100) * $charge->amount;
            $reservePercentage = $charge->invoice->residence->reserve_percentage / 100;
            $op = ($hasToPay * $reservePercentage) + $hasToPay;
            $property->balance += $op;
            $property->save();
        } 
        $total = $charge->invoice->total - $charge->amount;
        $charge->invoice->update([
            'total' => $total
        ]);
        $charge->delete();

        return ApiHelpers::ApiResponse(200, 'Successfully completed', null);
    }

    public function showThroughInvoice($id) {
        $charges = DB::table('charges')->where('invoice_id', $id)->paginate(50);

        if ($charges->all() == null) {
            $response = ApiHelpers::ApiResponse(404, '404 not found', null);
        } else {
            $response = ApiHelpers::ApiResponse(200, 'Succesfully completed', $charges);
        }
        return $response;

    }

    public function getChargesTypes() {
        $types = DB::table('charges_types')->get();

        return ApiHelpers::ApiResponse(200, 'Succesfully completed', $types);
    }

    public function prontoPago(Request $request, $id) {

        $invoice = Invoice::findOrfail($id);
        $response = '';
        $code = 0;

        if ($invoice->prontopago == false) {
            $total = $invoice->total + $request->amount;
            $invoice->total = $total;
            $invoice->prontopago = true;
            $store = Charge::create($request->all());
            $response = 'Succesfully completed';
            $code = 200;
            $invoice->save();
        } else {
            $response = 'Prontopago is already added';
            $code = 500;
        }

        return ApiHelpers::ApiResponse($code, $response, $invoice);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function dolarPrice() {
        $client = new Client([
            'base_uri' => 'http://s3.amazonaws.com',
        ]);

        $res = $client->request('GET', 'dolartoday/data.json');
        $sicad = json_decode(mb_convert_encoding($res->getBody()->getContents(), 'UTF-8', 'UTF-8'))->USD->sicad2;
        $dolarPrice = $sicad == null ? json_decode(mb_convert_encoding($res->getBody()->getContents(), 'UTF-8', 'UTF-8'))->USD->transferencia : $sicad;

        return ApiHelpers::ApiResponse(200, 'Successfully completed', $dolarPrice);
    }
}