<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendEmails2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send2 {user}{--queue}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $userId = $this->argument('user');
        echo $userId;
        $queueName = $this->option('queue');
        echo $queueName;
    }
}
