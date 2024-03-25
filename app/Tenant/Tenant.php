<?php

namespace App\Tenant;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class Tenant {

    public static string $id;

    public static function init()
    {
        self::$id = 'test';
        $connectionId = self::$id;

        $default = config('database.default');

        config(["database.connections.$connectionId" =>
            [
                'driver' => 'mysql',
                'url' => config("database.connections.$default.url"),
                'host' => config("database.connections.$default.host"),
                'port' => config("database.connections.$default.port"),
                'database' => $connectionId,
                'username' => config("database.connections.$default.username"),
                'password' => config("database.connections.$default.password"),
                'unix_socket' => config("database.connections.$default.unix_socket"),
                'charset' => config("database.connections.$default.charset"),
                'collation' => config("database.connections.$default.collation"),
                'prefix' => '',
                'prefix_indexes' => true,
                'strict' => true,
                'engine' => null,
                'options' => [],
            ]
        ]);
    }

    public static function id()
    {
        self::init();
        return self::$id;
    }

    public static function up()
    {
        self::init();

        if ( ! Schema::connection(self::$id)->hasTable('test')) {
            Schema::connection(self::$id)->create('test', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            });
        }
    }

    public static function down()
    {
        self::init();

        Schema::connection(self::$id)->dropIfExists('test');
    }
}
