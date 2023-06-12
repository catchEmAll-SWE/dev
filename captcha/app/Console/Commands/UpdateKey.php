<?php

namespace App\Console\Commands;

use App\Http\Business\KeyManager;
use Illuminate\Console\Command;
use App\Http\Controllers\KeyController;

class UpdateKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:key-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Call this command to update the active key';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        KeyManager::updateKey();
    }
}
