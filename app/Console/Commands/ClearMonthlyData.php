<?php

namespace App\Console\Commands;

use App\Models\ComputerHardDiskRecord;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ClearMonthlyData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'computers:clear-monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears computer data older than one month.';

    /**
     * @var ComputerHardDiskRecord
     */
    protected $hardDiskRecord;

    /**
     * Constructor.
     *
     * @param ComputerHardDiskRecord $hardDiskRecord
     */
    public function __construct(ComputerHardDiskRecord $hardDiskRecord)
    {
        parent::__construct();

        $this->hardDiskRecord = $hardDiskRecord;
    }

    /**
     * Execute the command.
     */
    public function handle()
    {
        $records = $this->hardDiskRecord->where('created_at', '>', Carbon::now()->subMonth())->delete();

        $this->info("Successfully deleted: $records records");
    }
}
