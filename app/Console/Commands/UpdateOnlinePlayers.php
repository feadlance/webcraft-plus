<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\User;
use App\Models\Server;

class UpdateOnlinePlayers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'server:update-online-players';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update online players';

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
        $users = User::get()->each(function ($user) {
            $user->logged_server = null;
            $user->save();
        });

        foreach ( Server::get() as $server ) {
            $rcon = $server->connectRcon();

            if ( $rcon->authorized !== true ) {
                continue;
            }

            foreach ( $rcon->listPlayers() as $player ) {
                $user = User::whereUsername($player)->first();

                if ( $user === null ) {
                    continue;
                }

                $server->users()->save($user);
            }
        }
    }
}
