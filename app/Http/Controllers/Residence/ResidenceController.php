<?php

namespace App\Http\Controllers\Residence;

use App\Models\Address;
use App\Models\Invoice;
use App\Models\Property;
use App\Models\Residence;
use App\Models\Payment;
use App\Helpers\ApiHelpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Residence\ResidenceResource as ResidenceResource;
use Illuminate\Support\Facades\DB;

class ResidenceController extends Controller
{

    public function balanceGeneral($id){

        $residence = Residence::findOrFail($id);
    
        $balanceGeneral = 0;

        $data = [];
    
        foreach($residence->properties as $property){
    
            $balanceGeneral += $property->balance;
    
        }

        array_push($data,$residence,$balanceGeneral);
    
        return ApiHelpers::ApiResponse(200, 'Successfully completed', $residence);
    
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $size = empty($request['paginate']) ? 1000 : $request['paginate'];
        $index = Residence::with('address')->paginate((int)$size);

        return ApiHelpers::ApiResponse(200, 'Successfully completed', $index);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $store = Residence::create($request->all());

        return ApiHelpers::ApiResponse(201, 'Successfully completed', $store);
    }

    /**
     * Display the specified resource.
     *
     * @param Residence $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $residence = Residence::findOrFail($id);

        return ApiHelpers::ApiResponse(200, 'Successfully completed', $residence);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $data
     * @param Residence $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $data, $id)
    {
        $resi = Residence::findOrFail($id);
        $resi->update($data->all());

        return ApiHelpers::ApiResponse(200, 'Successfully completed', [$resi]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Residence $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $resi = Residence::findOrFail($id);
        $resi->delete();

        return ApiHelpers::ApiResponse(200, 'Successfully completed', null);
    }

    public function createResidenceWithAddress(Request $request)
    {
        $data = [];
        $addressData = [
            'location'      => $request->location,
            'street'        => $request->street,
            'zip_code'      => $request->zip_code,
            'country_id'    => $request->country_id,
            'state_id'      => $request->state_id,
            'city_id'       => $request->city_id
        ];
        $newAddress = Address::create($addressData);
        array_push($data, $newAddress);
        $residenceData = [
            'name'       => $request->name,
            'nif'        => $request->nif,
            'auditor_id' => $request->auditor_id,
            'community_type' => $request->community_type,
            'address_id' => $newAddress['id'],
            'reserve_percentage' => $request->reserve_percentage,
            'reserve' => $request->reserve
        ];
        $newResidence = Residence::create($residenceData);
        array_push($data, $newResidence);

        return ApiHelpers::ApiResponse(200, 'Successfully completed', $data);
    }

    public function getResidencesThroughUser($id) {
        $residences = Residence::where('auditor_id', $id)->get();

        return ApiHelpers::ApiResponse(200, 'Successfully completed', $residences);
    }

    public function getPaymentThroughResidence($id) {
        $payments = Property::with(['payments','residence'])->where('residence_id',$id)->get();

        if($payments != null){
            return ApiHelpers::ApiResponse(200, 'Successfully completed', $payments);
        }else{
            return ApiHelpers::ApiResponse(404, '404 not found', $payments);
        }
    }

    public function getResidenceType() {
        $types = DB::table('residences_type')->get();

        return ApiHelpers::ApiResponse(200, 'Successfully completed', $types);
    }
}
