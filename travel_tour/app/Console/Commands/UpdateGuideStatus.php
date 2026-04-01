<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Group;
use Carbon\Carbon;

class UpdateGuideStatus extends Command
{
    protected $signature = 'guide:update-status';

    protected $description = 'Update guide status after trip';

    public function handle()
    {
        $today = Carbon::today();

        $groups = Group::with(['trip','guide'])
            ->whereNotNull('guide_id')
            ->get();

        foreach ($groups as $group) {

            if (!$group->trip || !$group->guide) continue;

            $end = Carbon::parse($group->trip->end_date);

            if ($today->gt($end)) {
                $group->guide->update([
                    'status' => 'available'
                ]);
            }
        }

        $this->info('Done');
    }
}