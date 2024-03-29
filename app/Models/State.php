<?php

namespace App\Models;

use App\Models\Address;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
     ];
 
     /**
      * The attributes that should be hidden for arrays.
      *
      * @var array
      */
     protected $hidden = [
        'created_at', 'updated_at'
     ];

   /**
   * Get the address that owns the state.
   */
   public function address()
   {
    return $this->hasMany(Address::class);
   }

   public function cities()
   {
    return $this->hasMany(City::class);
   }
}
