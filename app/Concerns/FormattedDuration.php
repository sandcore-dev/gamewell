<?php

namespace App\Concerns;

use Carbon\CarbonInterface;
use Carbon\CarbonInterval;

/**
 * @property int duration
 */
trait FormattedDuration
{
    public function getFormattedDurationAttribute(): string
    {
        return CarbonInterval::seconds($this->duration)
            ->cascade()
            ->forHumans(CarbonInterface::DIFF_ABSOLUTE, true, 3);
    }
}
