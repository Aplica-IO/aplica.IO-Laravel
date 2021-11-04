<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Invoice;
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
        $invoicesEnd = Invoice::with(['pronto_pagos'])
        ->whereDate('end', '=', Carbon::now()->format('Y-m-d'))
        ->limit(3500)->get();

        foreach($invoicesEnd as $key=>$invoice){
            foreach($invoice->pronto_pagos as $pronto){
                $pronto->is_applied = false;
                $pronto->save();
            }
        }
    }
}
