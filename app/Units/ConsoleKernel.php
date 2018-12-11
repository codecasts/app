<?php

namespace Codecasts\Units;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel;

/**
 * Class ConsoleKernel.
 *
 * Application Console Kernel.
 */
class ConsoleKernel extends Kernel
{
    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    }
}
