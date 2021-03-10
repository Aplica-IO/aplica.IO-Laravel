<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Http\Requests\User\{ShowRequest, IndexRequest, StoreRequest,
UpdateRequest, DestroyRequest};
use App\Repositories\UserRepository as Person;
use App\Mail\SendInvitation;
use App\Models\Residence;
use Illuminate\Support\Facades\Mail;
use App\Helpers\ApiHelpers;

class UserController extends ApiController
{
    public $user;

    /**
     * User constructor.
     */
    public function __construct(Person $user)
    {
        $this->user = $user;
        $this->middleware('jwt');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(IndexRequest $request)
    {
        return $this->user->index($request->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        return $this->user->store($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ShowRequest $request, $id)
    {
        return $this->user->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        return $this->user->update($id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyRequest $request, $id)
    {
        return $this->user->destroy($id);
    }

    public function invite(Request $request){
        
        $residence = Residence::findOrFail($request->residence_id);                                                                                                     
        $auditor = $residence->auditor;
        $url = "https://app.aplica.io/auth/invitation?residence=". strval($residence->id) ."&reference=". $request->reference. "&alicuota=". strval($request->alicuota) . "&balance=". strval($request->balance) . "&email=" . $request->email;
        Mail::to($request->email)->send(new SendInvitation($residence,$auditor,$url));
        return ApiHelpers::ApiResponse(200, 'Successfully completed',true);
    }
}
