<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class InitConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:navigation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Init navigation';

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
     * @return int
     */
    public function handle()
    {
        Cache::add('navigation',
            view('admin.particles.sidebar', [
                'menu' => json_decode(file_get_contents(config_path('navigation.json')), true)
            ])->render()
        );

        return 0;
    }
}
