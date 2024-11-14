<?php

namespace App\Console\Commands;

use App\Models\VerifyUser;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-code';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $timeLimit = Carbon::now()->subMinutes(1);

        $deletedRows = VerifyUser::where('created_at', '<', $timeLimit)->delete();
        Log::info("Deleted {$deletedRows} verification codes that were older than 1 minutes.");
    }
}
