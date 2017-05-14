<?php

namespace App\Console\Commands;

use Artisan;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class SetupApplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup {--ads=false}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup the application.';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /**
         * Clear config.
         */
        Artisan::call('config:clear');

        /**
         * Clear views.
         */
        Artisan::call('view:clear');

        /**
         * Clear routes.
         */
        Artisan::call('route:clear');

        /**
         * Clear cache.
         */
        Artisan::call('cache:clear');

        /**
         * Remove images.
         */
        $imagesPath = storage_path('app/public/images');

        $this->files->deleteDirectory($imagesPath);
        $this->files->makeDirectory($imagesPath);

        /**
         * Remove sessions.
         */
        foreach ($this->files->glob(storage_path('framework/sessions/*')) as $view) {
            $this->files->delete($view);
        }

        /**
         * Remove logs.
         */
        foreach ($this->files->glob(storage_path('logs/*')) as $view) {
            $this->files->delete($view);
        }
        
        /**
         * Create 'laravel.log' file.
         */
        $this->files->put(storage_path('logs/laravel.log'), '');

        /**
         * Create .env file if not exists.
         */
    	if ( $this->files->exists(base_path('.env')) === false ) {
    		$exampleEnvFile = $this->files->get(base_path('.env.example'));

    		$this->files->put(base_path('.env'), $exampleEnvFile);

    		Artisan::call('key:generate');
    	}
    }
}
