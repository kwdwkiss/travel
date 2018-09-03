<?php

namespace App\Console\Commands;


use Cly\Admin\Http\Controllers\Admin\IndexController;
use Cly\Admin\Model\TestTest;
use Cly\RegExp\RegExp;
use Illuminate\Console\Command;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

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
        $str = '
        #abc_abc_routes#
        Route::get(\'/abc_abc/index\', \'AbcAbcController@index\');
        Route::post(\'/abc_abc/create\', \'AbcAbcController@create\');
        Route::get(\'/abc_abc/detail\', \'AbcAbcController@detail\');
        Route::post(\'/abc_abc/update\', \'AbcAbcController@update\');
        Route::post(\'/abc_abc/delete\', \'AbcAbcController@delete\');
        #abc_abc_routes#

        #replace_routes#
        ';

        $data = preg_replace('/#abc_abc_routes#(.|\n)*#abc_abc_routes#\s*(?=#)/', '', $str);
        //$data = preg_replace('/#(.|\n)*#/', '', $str);
        dd($str,$data);
    }
}
