<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Property;
use App\Models\ProntoPago;
use Illuminate\Console\Command;

class checkProntoPagos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:pronto_pagos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check what properties needs to be applied pronto pago';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /* $prontopagos = ProntoPago::with('property')
        ->whereDate('command_date', '=', Carbon::now()->format('Y-m-d'))
        ->where('is_applied',false)->limit(3500)->get();

        foreach($prontopagos as $key=>$pronto){
            if($pronto->property->balance >= 0){
                $prontopagos[$key]->delete();
            }else{
                $prontopagos[$key]->is_applied = true;
                $prontopagos[$key]->save();
                $balance = $prontopagos[$key]->property->balance;
                $prontopagos[$key]->property->balance = $balance - $pronto->amount;
                $prontopagos[$key]->property->save();
            }
        } */
    }
}
