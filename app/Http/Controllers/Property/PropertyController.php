<?php

namespace App\Http\Controllers\Property;

use App\Helpers\ApiHelpers;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Property;
use App\Models\Residence;
use App\Models\User;
use Illuminate\Http\Request;

class PropertyController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index() {
		$size = empty($request['paginate']) ? 1000 : $request['paginate'];
		$index = Property::with(['residence', 'user'])->paginate((int) $size);

		return ApiHelpers::ApiResponse(200, 'Successfully completed', $index);
	}

	/**
	 * Store a newly created resource in storage. 
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(Request $request) {
        $find = User::where('email', $request->user_email)->get();

        if(!$find->isEmpty()) {
            $store = Property::create([
                'user_id' => $find[0]->id,
                'reference' => $request->reference,
                'alicuota' => $request->alicuota,
                'residence_id' => $request->residence_id,
                'balance' => $request->balance
            ]);
            return ApiHelpers::ApiResponse(200, 'Successfully completed', $store);
        } else {
            $store = 'Fails';
            return ApiHelpers::ApiResponse(404, 'Failed', $store);
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Property  $property
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show(Property $property) {
		$show = Property::findOrFail($property->id);

		return ApiHelpers::ApiResponse(200, 'Successfully completed', $show);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Property  $property
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(Request $request, Property $property) {
		$update = Property::findOrFail($property->id);
		$update->update($request->all());

		return ApiHelpers::ApiResponse(200, 'Successfully completed', $update);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Property  $property
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Property $property) {
		$delete = Property::findOrFail($property->id);
		$delete->delete();

		return ApiHelpers::ApiResponse(200, 'Property deleted', null);
	}

	public function showThroughUser($id) {
		$user = Property::with(['user', 'residence'])->where('user_id', $id)->get();
		return $user;
	}

	public function showThroughResidence($id) {
		$properties = Property::with('user')->where('residence_id', $id)->get();

		if ($properties->all() == null) {
			return ApiHelpers::ApiResponse(404, '404 not found', null);
		} else {
			return ApiHelpers::ApiResponse(200, 'Succesfully completed', $properties);
		}
	}

	public function getDefaulters($id) {
		//get properties
		$residences = Residence::with('properties')->findOrFail($id);
		$properties = [];
		// push properties in an array
		foreach ($residences->properties as $property) {
			if($property->balance < 0){
				array_push($properties, $property);
			}
		}

		// return a true response
		return ApiHelpers::ApiResponse(200, 'Succesfully completed', $properties);
	}

	public function getInactivePaymentsFromProperty($id) {
		$propertiesWithPayments = Payment::with(['property'])->whereHas('property', function ($query) use ($id) {
			$query->where('property_id', $id);
		})
			->where(function ($q) {
				$q->where('status', 2);
			})
			->get();

		// return the response
		if ($propertiesWithPayments->all() == null) {
			return ApiHelpers::ApiResponse(404, '404 not found', null);
		} else {
			foreach ($propertiesWithPayments as $i => $info) {
				$info->total_payed = ($info->invoice[0]->total * $info->property[0]->alicuota) / 100;
				if ($info->invoice[0]->is_active == true) {
					unset($propertiesWithPayments[$i]);
				}
			}
			return ApiHelpers::ApiResponse(200, 'Succesfully completed', $propertiesWithPayments);
		}
	}
}
