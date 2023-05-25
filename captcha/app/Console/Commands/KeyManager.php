<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\KeyController;

class KeyManager extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:key-manager';

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
        $key_controller = new KeyController();
        $key_controller->updateKey();
    }
}
