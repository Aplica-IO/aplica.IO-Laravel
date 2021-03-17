<?php

namespace App\Http\Controllers\Charge;

use App\Models\Charge;
use App\Models\Property;
use App\Models\Residence;
use GuzzleHttp\Client;
use App\Models\Invoice;
use App\Helpers\ApiHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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
        if($invoice->currency == 1){
            $amount = $request->amount;
        }if($invoice->currency == 2){
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

        $op = $invoice->total + $amount;
        $invoice->total = $op;
        $invoice->save();

        if($charge->type == 3){

            $property = Property::findOrFail($request->propertyId);
            $oldBalance = $property->balance;
            $balance = $oldBalance - $charge->amount;
            $property->update([
                'balance' => $balance
            ]);

        }else{

            $op = $invoice->total + $amount;
            $invoice->total = $op;
            $invoice->save();

            $residence = Residence::with(['properties'])->where('id',$invoice->residence_id)->first();

            foreach($residence->properties as $property){

                $op = ($property->alicuota / 100) * $charge->amount;
                $reserve_op = $op * ($residence->reserve_percentage / 100);
                $op_final = $op + $reserve_op;
                $newBalance = $property->balance - $op_final;

                $property->update([
                    'balance' => $newBalance
                ]);

            }
        }

        return ApiHelpers::ApiResponse(200, 'Successfully completed', $charge);
    }

    public function storePersonalCharges(Request $request){

        $invoice = Invoice::findOrFail($request->invoice_id);

        if($invoice->currency == 1){
            $amount = $request->amount;
        }if($invoice->currency == 2){
            $amount = $request->amount / $request->bcv;
        }

        $op = $invoice->total + $amount;
        $invoice->total = $op;
        $invoice->save();
        $count = count($request->properties);
        $divided = $amount / $count;

        for($i=0;$i < $count;$i++){

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

            $property = Property::findOrFail($request->properties[$i]);
            $residence = Residence::findOrFail($property->residence_id);

            $op = $charge->amount;
            $reserve_op = $divided * ($residence->reserve_percentage / 100);
            $op_final = $op + $reserve_op;
            $newBalance = $property->balance - $op_final;

            $property->update([
                'balance' => $newBalance
            ]);
        }

        return ApiHelpers::ApiResponse(200, 'Successfully completed', [$property, $charge]);
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
        $amount = $charge->amount;
        $total = $charge->invoice->total - $amount;
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
