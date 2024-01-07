<?php

namespace App\Http\Controllers\Backend\Traits;

use App\Models\Radio;
use Shetabit\Visitor\Models\Visit;

trait AdminStatsTrait {
    /**
     * Display statistics for radios.
     *
     * @param string $period
     * @return \Illuminate\Http\JsonResponse
     */
    public function radiosStatsForAdmin($period)
    {
        return $this->generateStats($period, 'radios', Radio::query(), 'Radios', '#667080');
    }

    /**
     * Display statistics for visits.
     *
     * @param string $period
     * @return \Illuminate\Http\JsonResponse
     */
    public function visitsStatsForAdmin($period)
    {
        return $this->generateStats($period, 'visits', Visit::query(), 'Website visits', '#667080');
    }

}
