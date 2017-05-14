<?php

namespace App\Console\Commands;

use App\Model\GeneralSetting;
use Illuminate\Console\Command;

class FetchSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:settings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch settings.';

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

        if ( config('lebby.ads') !== null ) {
            return false;
        }
        
        $post = curlPost('https://www.weblebby.com/webcraft-plus/fetch-settings');
        $post = json_decode($post);

        if ( isset($post->status) !== true || $post->status !== true ) {
            return false;
        }

        settings([
            'lebby.ads_field' => $post->data->ads_field,
            'lebby.footer_links' => $post->data->footer_links
        ]);
    }
}
