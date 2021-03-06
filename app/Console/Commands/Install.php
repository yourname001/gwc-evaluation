<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Artisan;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run migrate and seed';

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
        Schema::disableForeignKeyConstraints();
        $this->call('migrate:fresh');
        $this->info("Driver: " . config('database.connections.mysql.driver'));
        $this->info("Database: " . config('database.connections.mysql.database'));
        $this->info("Host: " . config('database.connections.mysql.host'));
        $this->info("Port: " . config('database.connections.mysql.port'));
        $this->call('db:seed');
        // $this->call('key:generate');
        $this->call('config:cache');
        // $bar->advance();
        // $bar->finish();
    }
}
