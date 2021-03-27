<?php
namespace App\Helpers;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use App\Models\Residence;
use App\Models\Property;

class ApiHelpers {

    /**
     * Generic API response structure for all requests
     *
     * @param $code string
     * @param $response mixed
     * @return \Illuminate\Http\JsonResponse
     */
    public static function ApiResponse($code, $message, $response)
    {
        return response()->json([
            'message'  => $message,
            'response' => $response
        ], $code);
    }
    public static function dolarPrice() {
        $client = new Client([
            'base_uri' => 'http://s3.amazonaws.com',
        ]);

        $res = $client->request('GET', 'dolartoday/data.json');
        $sicad = json_decode(mb_convert_encoding($res->getBody()->getContents(), 'UTF-8', 'UTF-8'))->USD->sicad2;
        $dolarPrice = $sicad == null ? json_decode(mb_convert_encoding($res->getBody()->getContents(), 'UTF-8', 'UTF-8'))->USD->transferencia : $sicad;

        return $dolarPrice;
    }
    public  static function GetBalance($properties)
    {
        $balance = 0;
        foreach($properties as $property){
            $balance += $property->balance;
        }
        return $balance;
    }

    public static function ModifyReserve($id,$amount){
        $residence = Residence::findOrFail($id);
        $residence->reserve -= $amount;
        $residence->save();
    }

    public static function ModifyBalance($id,$amount){
        $property = Property::findOrFail($id,$amount);
        $property->balance -= $amount;
        $property->save();
    }

    public static function ProcessResidenceBalanceAndReserve($id,$amount){
        $balance = 0;
        $residence = Residence::with(['properties'])->first();
        foreach($residence->properties as $property){
            $property = Property::findOrFail($property->id);
            $hasToPay = ($property->alicuota / 100) * $amount;
            $reservePercentage = $residence->reserve_percentage / 100;
            $op = ($hasToPay * $reservePercentage) + $hasToPay;
            $property->balance -= $op;
            $property->save();
            $residence->reserve += $hasToPay * $reservePercentage;
            $residence->save();
            $balance += $property->balance;
        }
        if($property->balance < $amount){
            $residence->reserve -= ($amount - $property->balance);
        }
    }
    public static function ProcessOnlyResidenceBalance($id,$amount){
        $balance = 0;
        $residence = Residence::with(['properties'])->first();
        foreach($residence->properties as $property){
            $property = Property::findOrFail($property->id);
            $hasToPay = ($property->alicuota / 100) * $amount;
            $property->balance -= $hasToPay;
            $property->save();
            $balance += $property->balance;
        }
        if($property->balance < $amount){
            $residence->reserve -= ($amount - $property->balance);
        }
    }
}
