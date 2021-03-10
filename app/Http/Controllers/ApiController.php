<?php 

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Helpers\ApiHelpers;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ApiController extends Controller
{
    /**
     * Wrapper for the ApiResponse Helper
     *
     * @param string $code
     * @param array $response
     * @return \Illuminate\Http\JsonResponse
     */
    protected function ApiResponse($code, $message, $response)
    {
        return ApiHelpers::ApiResponse($code, $message, $response);
    }

    public function SendEmailForget($mail)
    {
        $object = User::select('first_name', 'last_name', 'email')
            ->where('email', $mail)->get();

        $token = str_random(60);

        DB::table('user_tokens')->insert([
            'email' => $mail,
            'token' => $token,
            'created_at' => Carbon::now('utc')
        ]);

        return Mail::to($mail)->send(new ResetPassword($object, $token));
    }

    public function ValidateToken($token)
    {
        $data = DB::table('user_tokens')
            ->where('token', $token)->first();

        if ($data->created_at <= Carbon::now('utc')->addMinute(30))
        {
            return [
                'data' => $data,
                'response' => true
            ];

        }else
        {   
            $data->delete();
            return [
                'data' => null,
                'response' => false
            ];
        }
    }
    
    public function RestartPass($account, $password)
    {
        $user = User::where('email', $account->email)->first();

        $user->update([
            'password' => bcrypt($password)
        ]);

        DB::table('user_tokens')->where('email', $user->email)->delete();
        
        return $this->ApiResponse(200, 'The password has been successfully reset', null);
    }
}
