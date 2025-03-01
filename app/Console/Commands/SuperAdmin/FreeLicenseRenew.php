<?php

namespace App\Console\Commands\SuperAdmin;

use App\Models\Restaurant;
use Illuminate\Console\Command;

class FreeLicenseRenew extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:free-license-renew';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Free license renew';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = now();
        Restaurant::with('package')
            ->where('status', 'active')
            ->whereHas('package', function ($q) {
                $q->where('is_free', 1);
            })
            ->whereNotNull('license_expire_on')
            ->where('license_expire_on', '<', $now)
            ->each(function ($restaurant) use ($now) {
                $restaurant->update([
                    'license_expire_on' => $now
                        ->add($restaurant->package_type == 'monthly' ? 'month' : 'year')
                        ->format('Y-m-d')
                ]);
            });
    }
}
