<?php

namespace App\Console\Commands;

use App\Services\CommonCache;
use Illuminate\Console\Command;

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
     * @param CommonCache $commonCache
     * @return int
     */
    public function handle(CommonCache $commonCache)
    {
        $commonCache->cacheNavigation();

        return 0;
    }
}
