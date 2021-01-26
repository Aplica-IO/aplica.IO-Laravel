<?php

namespace App\Http\Controllers\Payment;

use GuzzleHttp\Client;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Property;
use App\Models\Residence;
use App\Helpers\ApiHelpers;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PaymentController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return JsonResponse
	 */
	public function index() {
		$index = Payment::with(['property'])->paginate();

		return ApiHelpers::ApiResponse(200, 'Succesfully completed', $index);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function store(Request $request) {

		$client = new Client([
			'base_uri' => 'https://s3.amazonaws.com',
		]);

		$res = $client->request('GET', 'dolartoday/data.json');
		$sicad = json_decode(mb_convert_encoding($res->getBody()->getContents(), 'UTF-8', 'UTF-8'))->USD->sicad2;
		$dolarPrice = $sicad == null ? json_decode(mb_convert_encoding($res->getBody()->getContents(), 'UTF-8', 'UTF-8'))->USD->transferencia : $sicad;
		
		if($request->currency_id == 1){
			$amount_payed = $request->amount_payed;
		}if($request->currency_id == 2){
			$amount_payed = $request->amount_payed / $dolarPrice;
		}

		$data = [
			'amount_payed' => $amount_payed,
			'bcv' => $dolarPrice,
			'transaction_ref' => $request->transaction_ref,
			'id_method' => $request->id_method,
			'bank' => $request->bank,
			'status' => 1,
			'property_id' => $request->property_id,
            'currency_id' => $request->currency_id
		];

		$store = Payment::create($data);

		return ApiHelpers::ApiResponse(200, 'Succesfully completed', $store);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return JsonResponse
	 */
	public function show($id) {
		$show = Payment::with(['property'])->findOrFail($id);
		
		return ApiHelpers::ApiResponse(200, 'Successfully completed', $show);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param Request $request
	 * @param  int  $id
	 * @return JsonResponse
	 */
	public function update(Request $request, $id) {
		$queryPayment = Payment::with(['property'])->findOrFail($id);

		/* if ((($queryPayment->invoice[0]->total * $queryPayment->property[0]->alicuota) / 100) > $request->amount_payed) {
			$queryPayment->update($request->all());
		}
		if ((($queryPayment->invoice[0]->total * $queryPayment->property[0]->alicuota) / 100) > $queryPayment->amount_payed) {
			$queryPayment->update($request->all());
		}if ((($queryPayment->invoice[0]->total * $queryPayment->property[0]->alicuota) / 100) <= $queryPayment->amount_payed) {
			$queryPayment->update($request->all());
			$queryPayment->is_completed = 1;
			$queryPayment->is_payed = 1;
			$queryPayment->save();
		} */
		$queryPayment->update($request->all());
		return ApiHelpers::ApiResponse(200, 'Successfully completed', $queryPayment);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return JsonResponse
	 */
	public function destroy($id) {
		$destroy = Payment::findOrFail($id);
		$destroy->delete();

		return ApiHelpers::ApiResponse(200, 'Successfully completed', null);
	}

	public function showThroughInvoice($id) {
		$payment = Invoice::with('payments')->where('id', $id)->paginate(50);

		if ($payment->all() == null) {
			return ApiHelpers::ApiResponse(404, '404 not found', null);
		} else {
			return ApiHelpers::ApiResponse(200, 'Successfully completed', $payment);
		}
	}

	public function showThroughProperty($id) {
	    $payment = Property::with(['payments'])->where('properties.id', $id)->get();

		if ($payment->all() == null) {
			return ApiHelpers::ApiResponse(404, '404 not found', null);
		} else {
			return ApiHelpers::ApiResponse(200, 'Successfully completed', $payment);
		}
		
	}

	public function getBanks() {
		$banks = DB::table('banks')->get();

		return ApiHelpers::ApiResponse(200, 'Successfully completed', $banks);
	}

	public function getMethodsPayments() {
		$methods = DB::table('payment_methods')->get();

		return ApiHelpers::ApiResponse(200, 'Successfully completed', $methods);
	}

	public function getPropertiesPayed($id){

		$paymentsWithProperty = Payment::with(['property', 'bank', 'status', 'method', 'currency'])->whereHas('property', function ($query) use ($id){
			$query->where('residence_id',$id);
		})->where('status',1)->get();

		return apiHelpers::ApiResponse(200, 'Successfully', $paymentsWithProperty);
	} 

	public function getDollar(Request $request) {
		// Get dolar price
		$client = new Client([
			'base_uri' => 'https://s3.amazonaws.com',
		]);

		$res = $client->request('GET', 'dolartoday/data.json');
		$sicad = json_decode(mb_convert_encoding($res->getBody()->getContents(), 'UTF-8', 'UTF-8'))->USD->sicad2;
		$dolarPrice = $sicad == null ? json_decode(mb_convert_encoding($res->getBody()->getContents(), 'UTF-8', 'UTF-8'))->USD->transferencia : $sicad;

		return ApiHelpers::ApiResponse(200, 'Succesfully completed', $dolarPrice);
	}

	public function confirmPayment($id) {

		$payment = Payment::with(['property'])->where('id',$id)->first();

		$payment->update([
			'status' => 2
		]);

		$payed = $payment->amount_payed;

		$newBalance = $payment->property->balance + $payed;

		$payment->property->update([
			'balance' => $newBalance
		]);

        $property = Property::findOrFail($payment->property_id);
        $residence = Residence::findOrFail($property->residence_id);

        $newReserve = $residence->reserve + ($payed * ($residence->reserve_percentage / 100));

        $residence->update([
            'reserve' => $newReserve
        ]);

		return ApiHelpers::ApiResponse(200, 'Succesfully completed', $payment);
	}

    public function createAndConfirm(Request $request) {

        $client = new Client([
            'base_uri' => 'https://s3.amazonaws.com',
        ]);

        $res = $client->request('GET', 'dolartoday/data.json');
        $sicad = json_decode(mb_convert_encoding($res->getBody()->getContents(), 'UTF-8', 'UTF-8'))->USD->sicad2;
        $dolarPrice = $sicad == null ? json_decode(mb_convert_encoding($res->getBody()->getContents(), 'UTF-8', 'UTF-8'))->USD->transferencia : $sicad;

        if($request->currency_id == 1){
            $amount_payed = $request->amount_payed;
        }if($request->currency_id == 2){
            $amount_payed = $request->amount_payed / $dolarPrice;
        }

        $data = [
            'amount_payed' => $amount_payed,
            'bcv' => $dolarPrice,
            'transaction_ref' => $request->transaction_ref,
            'id_method' => $request->id_method,
            'bank' => $request->bank,
            'status' => 2,
            'property_id' => $request->property_id,
            'currency_id' => $request->currency_id
        ];

        $store = Payment::create($data);
        $property = Property::findOrFail($request->property_id);
        
        $newBalance = $property->balance + $amount_payed;
        $property->update([
            'balance' => $newBalance
        ]);

        $residence = Residence::findOrFail($property->residence_id);
        $newReserve = $residence->reserve + ($amount_payed * ($residence->reserve_percentage / 100));
        $residence->update([
            'reserve' => $newReserve
        ]);

        return ApiHelpers::ApiResponse(200, 'Succesfully completed', $store);
    }

}
