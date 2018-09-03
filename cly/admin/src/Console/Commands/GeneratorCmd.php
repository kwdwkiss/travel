<?php

namespace Cly\Admin\Console\Commands;

use Cly\generator\Generator;
use Illuminate\Console\Command;

class GeneratorCmd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cly_admin:generator {name}';

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
        $name = $this->argument('name');
        $generator = new Generator();
        $generator->build($name);
    }
}
