<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
// configuring cron schedules
use Illuminate\Http\Request;
use App\User;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\SendEmails::class,
        Commands\SendEmails2::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        // configuring cron schedules
        $schedule->call(function(Request $request,User $user){
            $user = $user->find(1);
            // $user->createAsStripeCustomer();
            $user->newSubscription('Basic','plan_GCrZLyACwh7Cis')->create('pm_1FrJXJHOBkwljjnYoReKN9OA');
        });

        echo "cron job";
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
