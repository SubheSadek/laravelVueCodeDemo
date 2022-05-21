<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Exel\ExelController;

class InfoUpload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:InfoUpload';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        // \Log::info("Iam here now 222");

        $info = new ExelController();
        $info->uploadExcelFile();
        return 1;

    }
}
