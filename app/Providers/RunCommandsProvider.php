<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class RunCommandsProvider extends ServiceProvider
{
    /**
     * Executable commands.
     *
     * @return array
     */
    protected function console_commands()
    {
        return [
            \App\Console\Commands\FetchSettings::class,
            \App\Console\Commands\UpdateServers::class,
            \App\Console\Commands\CheckStillVip::class,
        ];
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        _run(function () {
            foreach ($this->console_commands() as $key => $command) {
                (new $command)->handle();
            }
        }, settings('lebby.sync_delay'), 'run_commands');
    }
}
