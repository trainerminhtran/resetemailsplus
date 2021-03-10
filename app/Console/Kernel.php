<?php
//php artisan make:command WordOfTheDay
//php artisan queue1minute:cron
namespace App\Console;

use App\Console\Commands\OrderQueue;
use App\Console\Commands\Queue1Minute;
use App\Http\Controllers\OrderController;
use App\Console\Commands\OpenAPIProductsLZD;
use App\Jobs\OrderJob;
use App\Laravue\Models\AccountShop;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Date;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

}
