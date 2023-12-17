<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product\ProductOffers;
use App\Models\Product\Enums\ProductOfferStatusEnum;

class ChangeProductOfferStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:change-product-offer-status';

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
        $currentDate = now();
        $activeOffers = ProductOffers::where('started_at', '<=', $currentDate)
            ->where('ended_at', '>=', $currentDate)
            ->update(['status' => ProductOfferStatusEnum::ACTIVE()]);

        $inactiveOffers = ProductOffers::where('ended_at', '<', $currentDate)
            ->update(['status' => ProductOfferStatusEnum::INACTIVE()]);
        return [$activeOffers,$inactiveOffers];
    }

}
