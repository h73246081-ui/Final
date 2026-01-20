<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\VendorPackage;
use Carbon\Carbon;


class ExpireVendorPackages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:expire-vendor-packages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire vendor packages whose end_date has passed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now=Carbon::now();
        $expired=VendorPackage::where('status','active')->where('end_date','<',$now)->update(['status'=>'expired']);
        $this->info("Expired Packages:$expired");
    }
}
