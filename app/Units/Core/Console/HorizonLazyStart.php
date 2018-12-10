<?php

namespace Codecasts\Units\Core\Console;

use Illuminate\Console\Command;

/**
 * Class HorizonLazyStart.
 *
 * Sometimes redis is still booting up while horizon is trying to start.
 */
class HorizonLazyStart extends Command
{
    /**
     * @var string Define command name.
     */
    protected $name = 'horizon:lazy-start';

    /**
     * @var string Define command description.
     */
    protected $description = 'Wait for redis, then start Horizon.';

    /**
     * Backwards compatibility.
     */
    public function fire()
    {
        $this->handle();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // sleep for a while.
        sleep(10);

        // start horizon.
        $this->call('horizon');
    }
}