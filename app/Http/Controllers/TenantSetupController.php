<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tenant\Tenant;

class TenantSetupController extends Controller
{
    public function create()
    {
        Tenant::down();

        // $connectionId = 'test';
        // $default = config('database.default');
        // config(['database.connections.test' =>
        //     [
        //         'driver' => 'mysql',
        //         'url' => config("database.connections.$default.url"),
        //         'host' => config("database.connections.$default.host"),
        //         'port' => config("database.connections.$default.port"),
        //         'database' => $connectionId,
        //         'username' => config("database.connections.$default.username"),
        //         'password' => config("database.connections.$default.password"),
        //         'unix_socket' => config("database.connections.$default.unix_socket"),
        //         'charset' => config("database.connections.$default.charset"),
        //         'collation' => config("database.connections.$default.collation"),
        //         'prefix' => '',
        //         'prefix_indexes' => true,
        //         'strict' => true,
        //         'engine' => null,
        //         'options' => [],
        //     ]
        // ]);
        // $con = DB::connection($connectionId);

    }

    public function createUnitTable()
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('airline');
            $table->timestamps();
        });
    }
}
