<?php

namespace App\Http\Controllers\Invoice;

use Carbon\Carbon;
use App\Models\Charge;
use GuzzleHttp\Client;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Property;
use App\Models\Residence;
use App\Helpers\ApiHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendInvoiceNotification;

class InvoiceController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index() {
		$index = Invoice::with('residence')->paginate(200);
		return ApiHelpers::ApiResponse(200, 'Successfully completed', $index);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(Request $request) {
		$query = Invoice::with('charges')->where('residence_id', $request->residence_id)->latest('id')->first();
		$client = new Client([
			'base_uri' => 'https://s3.amazonaws.com',
		]);

		$res = $client->request('GET', 'dolartoday/data.json');
		$sicad = json_decode(mb_convert_encoding($res->getBody()->getContents(), 'UTF-8', 'UTF-8'))->USD->sicad2;
		$dolarPrice = $sicad == null ? json_decode(mb_convert_encoding($res->getBody()->getContents(), 'UTF-8', 'UTF-8'))->USD->transferencia : $sicad;

		if ($query != null) {
			$query->is_active = false;
			$query->save();
		}

		$store = Invoice::create($request->all());
		return ApiHelpers::ApiResponse(200, 'Succesfully completed', $store);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show($id) {
		$invoice = Invoice::with(['currency','residence', 'charges'])->findOrFail($id);

		return ApiHelpers::ApiResponse(200, 'Succesfully completed', [
			'invoice' => $invoice,
			'country' => $invoice->residence->address->country,
			'state' => $invoice->residence->address->state,
			'city' => $invoice->residence->address->city,
            'residence' => $invoice->residence
		]);
	}

	public function checkIfPayed($invoice_id,$property_id) {

		$invoice = Invoice::findOrFail($invoice_id);
		$invoices = DB::table('invoices')
		->where(['residence_id'=>$invoice->residence->id])
		->where('id','<',$invoice->id)
		->get();
		$property = Property::findOrFail($property_id);
		$payed = 0;

		foreach($property->payments as $payment){
			if($payment->status === 2){
				$payed += $payment->amount_payed;

			}
		}

		$shouldBePayed = 0;

		foreach($invoices as $actInvoice){
			$shouldBePayed += $actInvoice->total * ($property->alicuota/100);
		}

		if( ($invoice->total * ($property->alicuota/100) ) >= ($payed - $shouldBePayed)){
			$response = false;
		}else{
			$response = true;
		}

		return ApiHelpers::ApiResponse(200, 'Succesfully completed', $response);

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(Request $request, $id) {
		$invoice = Invoice::findOrFail($id);

		$invoice->update($request->all());

		return ApiHelpers::ApiResponse(200, 'Succesfully completed', $invoice);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy($id) {
		$invoice = Invoice::findOrfail($id);
		$invoice->delete();

		return ApiHelpers::ApiResponse(200, 'Succesfully completed', null);
	}

	public function showThroughResidence($id) {
		$invoice = Invoice::with(['charges', 'residence'])->where('residence_id', $id)
			->orderBy('id', 'desc')->get();
		if ($invoice->all() == null) {
			return ApiHelpers::ApiResponse(404, '404 not found', null);
		} else {
			return ApiHelpers::ApiResponse(200, 'Succesfully completed', $invoice);
		}
	}

	public function getLastOne($id) {
        // $invoice = Invoice::with(['charges', 'residence'])->where('residence_id', $id)->get()->last();

        $invoice = Residence::with(['properties', 'invoices' => function($query) {
            $query->with(['charges', 'currency'])->where('is_active', 1);
        }])->where('id', $id)->get();

        if ($invoice == null) {
            return ApiHelpers::ApiResponse(404, '404 not found', null);
        } elseif ($invoice != null) {

            if($invoice[0]->expiration_date <= today()){
                $invoice[0]->is_expired = true;
            } elseif ($invoice[0]->expiration_date > today()) {
                $invoice[0]->is_expired = false;
            }

            return ApiHelpers::ApiResponse(200, 'Succesfully completed', $invoice);
        }
	}

	public function InactiveInvoices() {
		$invoices = Invoice::with('residence')->where('is_active', 0)->paginate(20);
		if($invoices != null){
			return ApiHelpers::ApiResponse(200, 'Succesfully completed', $invoices);
		}else{
			return ApiHelpers::ApiResponse(404, '404 not foundd', false);
		}

	}

	public function turnOffInvoice($id) {
        $invoice = Invoice::findOrFail($id);
        $invoice->update([
            'is_active' => false
        ]);
		$x=0;
		$receivers = [];
		foreach($invoice->residence->properties as $property){

            $op = ($property->alicuota / 100) * $invoice->total;
            $reserve_op = $op * ($invoice->residence->reserve_percentage / 100);
            $newBalance = $property->balance - $reserve_op;

            $property->update([
                'balance' => $newBalance
            ]);

			$receivers[$x] = $property->user->email;
			$x++;
		}

		Mail::to($receivers)->send(new SendInvoiceNotification($invoice->id));

        if($invoice != null){
            return ApiHelpers::ApiResponse(200, 'Succesfully completed', $invoice);
        }else{
            return ApiHelpers::ApiResponse(404, '404 not foundd', false);
        }

    }

	public function Currencies() {
		$currencies = DB::table('currencies')->get();

		return ApiHelpers::ApiResponse(200, 'Succesfully completed', $currencies);
	}


}
