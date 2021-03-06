<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'price:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send prices to the customer : develop by bamit';

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
        
    }
}
