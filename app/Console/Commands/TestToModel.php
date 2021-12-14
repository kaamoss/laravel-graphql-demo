<?php

namespace App\Console\Commands;

use App\Interfaces\Repositories\IUserRepository;
use App\Util\ModelReflectionCache;
use App\Util\ModelTranslator;
use Illuminate\Console\Command;

class TestToModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'model:benchmark';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Benchmark toModel Implementation';

    protected $userRepo;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(IUserRepository $userRepo)
    {
        parent::__construct();
        $this->userRepo = $userRepo;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ModelReflectionCache::generateCache();
        $cache = ModelReflectionCache::fetchCache();
        //dd('Yeeee');
        //$accounts = $this->userRepo->getAllAccounts();
        //$firstAccount = $accounts->first();

        $model = null;
        $startTime = microtime(true);
        $memStart = memory_get_usage(true);
        //$model = ModelTranslator::toModel($firstAccount);

        $model =$cache;

        $memEnd = memory_get_usage(true);
        $endTime = microtime(true);
        $memUsage = ($memEnd-$memStart);

        printf("Fetched %d Accounts in %f microtime with mem usage: %s \n", 0, ($endTime-$startTime), $this->formatBytes($memUsage, 0));
        dd($model);//$firstAccount
    }

    function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('', 'K', 'M', 'G', 'T');

        return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
    }
}
