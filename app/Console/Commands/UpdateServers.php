<?php

namespace App\Console\Commands;

use App\Models\Server;
use Illuminate\Console\Command;

class UpdateServers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'server:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ping the all servers';

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
        if ( check_db_connection('tables') === false ) {
            return false;
        }
        
        Server::get()->each->updateQuery();
    }
}
