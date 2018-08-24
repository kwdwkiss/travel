<?php

namespace Cly\Admin\Console\Commands;


use Cly\Admin\Http\Controllers\Admin\IndexController;
use Cly\Admin\Model\Admin;
use Illuminate\Console\Command;

class InstallCmd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cly_admin:install';

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
        Admin::create([
            'name' => 'kwdwkiss',
            'password' => bcrypt('caoleiyu'),
        ]);
    }
}
