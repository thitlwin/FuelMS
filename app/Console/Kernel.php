<?php

namespace PowerMs\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
       /* $schedule->command('inspire')
                 ->hourly();         
                 */
         $schedule->call(function (){
             $this->calcualteExpiredCustomers();
         })->daily();
    }

    // calculate expired customer of SmartHome Application (product_id=2)
    // trial day is 30 days
    public function calcualteExpiredCustomers()
    {
        \DB::update('Update `customers` SET is_expired=1 
            WHERE id IN (SELECT customer_id FROM customer_product WHERE product_id=2) 
            AND  customers.created_at < DATE_SUB( now() , INTERVAL 30 DAY) 
            AND !customers.is_activated');
    }
}
