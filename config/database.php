<?php

return [

    /*
    |--------------------------------------------------------------------------
    | PDO Fetch Style
    |--------------------------------------------------------------------------
    |
    | By default, database results will be returned as instances of the PHP
    | stdClass object; however, you may desire to retrieve records in an
    | array format for simplicity. Here you can tweak the fetch style.
    |
    */

    'fetch' => PDO::FETCH_OBJ,

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],

        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', ''),
            'port' => env('DB_PORT', ''),
            'database' => env('DB_DATABASE', ''),
            'username' => env('DB_USERNAME', ''),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        
        'mysql_vanilla_auth' => [
            'driver' => 'mysql',
            'host' => env('DB_VANILLA_HOST', ''),
            'port' => env('DB_PORT', ''),
            'database' => env('DB_VANILLA_AUTH', ''),
            'username' => env('DB_VANILLA_USERNAME', ''),
            'password' => env('DB_VANILLA_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        'mysql_vanilla_characters_1' => [
            'driver' => 'mysql',
            'host' => env('DB_VANILLA_HOST', ''),
            'port' => env('DB_PORT', ''),
            'database' => env('DB_VANILLA_CHARACTERS_1', ''),
            'username' => env('DB_VANILLA_USERNAME', ''),
            'password' => env('DB_VANILLA_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        
        'mysql_vanilla_characters_2' => [
            'driver' => 'mysql',
            'host' => env('DB_VANILLA_HOST', ''),
            'port' => env('DB_PORT', ''),
            'database' => env('DB_VANILLA_CHARACTERS_2', ''),
            'username' => env('DB_VANILLA_USERNAME', ''),
            'password' => env('DB_VANILLA_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        
        'mysql_vanilla_characters_3' => [
            'driver' => 'mysql',
            'host' => env('DB_VANILLA_HOST', ''),
            'port' => env('DB_PORT', ''),
            'database' => env('DB_VANILLA_CHARACTERS_3', ''),
            'username' => env('DB_VANILLA_USERNAME', ''),
            'password' => env('DB_VANILLA_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        
                
        'mysql_vanilla_world_1' => [
            'driver' => 'mysql',
            'host' => env('DB_VANILLA_HOST', ''),
            'port' => env('DB_PORT', ''),
            'database' => env('DB_VANILLA_WORLD_1', ''),
            'username' => env('DB_VANILLA_USERNAME', ''),
            'password' => env('DB_VANILLA_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        
        'mysql_vanilla_world_2' => [
            'driver' => 'mysql',
            'host' => env('DB_VANILLA_HOST', ''),
            'port' => env('DB_PORT', ''),
            'database' => env('DB_VANILLA_WORLD_2', ''),
            'username' => env('DB_VANILLA_USERNAME', ''),
            'password' => env('DB_VANILLA_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        
        'mysql_vanilla_world_3' => [
            'driver' => 'mysql',
            'host' => env('DB_VANILLA_HOST', ''),
            'port' => env('DB_PORT', ''),
            'database' => env('DB_VANILLA_WORLD_3', ''),
            'username' => env('DB_VANILLA_USERNAME', ''),
            'password' => env('DB_VANILLA_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        
        'mysql_wotlk_auth' => [
            'driver' => 'mysql',
            'host' => env('DB_WOTLK_HOST', ''),
            'port' => env('DB_PORT', ''),
            'database' => env('DB_WOTLK_AUTH', ''),
            'username' => env('DB_WOTLK_USERNAME', ''),
            'password' => env('DB_WOTLK_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        'mysql_wotlk_characters_1' => [
            'driver' => 'mysql',
            'host' => env('DB_WOTLK_HOST', ''),
            'port' => env('DB_PORT', ''),
            'database' => env('DB_WOTLK_CHARACTERS_1', ''),
            'username' => env('DB_WOTLK_USERNAME', ''),
            'password' => env('DB_WOTLK_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        
        'mysql_wotlk_characters_2' => [
            'driver' => 'mysql',
            'host' => env('DB_WOTLK_HOST', ''),
            'port' => env('DB_PORT', ''),
            'database' => env('DB_WOTLK_CHARACTERS_2', ''),
            'username' => env('DB_WOTLK_USERNAME', ''),
            'password' => env('DB_WOTLK_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        
        'mysql_wotlk_characters_3' => [
            'driver' => 'mysql',
            'host' => env('DB_WOTLK_HOST', ''),
            'port' => env('DB_PORT', ''),
            'database' => env('DB_WOTLK_CHARACTERS_3', ''),
            'username' => env('DB_WOTLK_USERNAME', ''),
            'password' => env('DB_WOTLK_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        
                
        'mysql_wotlk_world_1' => [
            'driver' => 'mysql',
            'host' => env('DB_WOTLK_HOST', ''),
            'port' => env('DB_PORT', ''),
            'database' => env('DB_WOTLK_WORLD_1', ''),
            'username' => env('DB_WOTLK_USERNAME', ''),
            'password' => env('DB_WOTLK_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        
        'mysql_wotlk_world_2' => [
            'driver' => 'mysql',
            'host' => env('DB_WOTLK_HOST', ''),
            'port' => env('DB_PORT', ''),
            'database' => env('DB_WOTLK_WORLD_2', ''),
            'username' => env('DB_WOTLK_USERNAME', ''),
            'password' => env('DB_WOTLK_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        
        'mysql_wotlk_world_3' => [
            'driver' => 'mysql',
            'host' => env('DB_WOTLK_HOST', ''),
            'port' => env('DB_PORT', ''),
            'database' => env('DB_WOTLK_WORLD_3', ''),
            'username' => env('DB_WOTLK_USERNAME', ''),
            'password' => env('DB_WOTLK_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        
        'mysql_mop_auth' => [
            'driver' => 'mysql',
            'host' => env('DB_MOP_HOST', ''),
            'port' => env('DB_PORT', ''),
            'database' => env('DB_MOP_AUTH', ''),
            'username' => env('DB_MOP_USERNAME', ''),
            'password' => env('DB_MOP_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        'mysql_mop_characters_1' => [
            'driver' => 'mysql',
            'host' => env('DB_MOP_HOST', ''),
            'port' => env('DB_PORT', ''),
            'database' => env('DB_MOP_CHARACTERS_1', ''),
            'username' => env('DB_MOP_USERNAME', ''),
            'password' => env('DB_MOP_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        
        'mysql_mop_characters_2' => [
            'driver' => 'mysql',
            'host' => env('DB_MOP_HOST', ''),
            'port' => env('DB_PORT', ''),
            'database' => env('DB_MOP_CHARACTERS_2', ''),
            'username' => env('DB_MOP_USERNAME', ''),
            'password' => env('DB_MOP_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        
        'mysql_mop_characters_3' => [
            'driver' => 'mysql',
            'host' => env('DB_MOP_HOST', ''),
            'port' => env('DB_PORT', ''),
            'database' => env('DB_MOP_CHARACTERS_3', ''),
            'username' => env('DB_MOP_USERNAME', ''),
            'password' => env('DB_MOP_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        
        'mysql_mop_world_1' => [
            'driver' => 'mysql',
            'host' => env('DB_MOP_HOST', ''),
            'port' => env('DB_PORT', ''),
            'database' => env('DB_MOP_WORLD_1', ''),
            'username' => env('DB_MOP_USERNAME', ''),
            'password' => env('DB_MOP_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        
        'mysql_mop_world_2' => [
            'driver' => 'mysql',
            'host' => env('DB_MOP_HOST', ''),
            'port' => env('DB_PORT', ''),
            'database' => env('DB_MOP_WORLD_2', ''),
            'username' => env('DB_MOP_USERNAME', ''),
            'password' => env('DB_MOP_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        
        'mysql_mop_world_3' => [
            'driver' => 'mysql',
            'host' => env('DB_MOP_HOST', ''),
            'port' => env('DB_PORT', ''),
            'database' => env('DB_MOP_WORLD_3', ''),
            'username' => env('DB_MOP_USERNAME', ''),
            'password' => env('DB_MOP_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        'mysql_legion_auth' => [
            'driver' => 'mysql',
            'host' => env('DB_LEGION_HOST', ''),
            'port' => env('DB_PORT', ''),
            'database' => env('DB_LEGION_AUTH', ''),
            'username' => env('DB_LEGION_USERNAME', ''),
            'password' => env('DB_LEGION_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
            
        'mysql_legion_characters_1' => [
            'driver' => 'mysql',
            'host' => env('DB_LEGION_HOST', ''),
            'port' => env('DB_PORT', ''),
            'database' => env('DB_LEGION_CHARACTERS_1', ''),
            'username' => env('DB_LEGION_USERNAME', ''),
            'password' => env('DB_LEGION_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        
        'mysql_legion_characters_2' => [
            'driver' => 'mysql',
            'host' => env('DB_LEGION_HOST', ''),
            'port' => env('DB_PORT', ''),
            'database' => env('DB_LEGION_CHARACTERS_2', ''),
            'username' => env('DB_LEGION_USERNAME', ''),
            'password' => env('DB_LEGION_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        
        'mysql_legion_characters_3' => [
            'driver' => 'mysql',
            'host' => env('DB_LEGION_HOST', ''),
            'port' => env('DB_PORT', ''),
            'database' => env('DB_LEGION_CHARACTERS_3', ''),
            'username' => env('DB_LEGION_USERNAME', ''),
            'password' => env('DB_LEGION_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        'mysql_legion_hotfixes' => [
            'driver' => 'mysql',
            'host' => env('DB_LEGION_HOST', ''),
            'port' => env('DB_PORT', ''),
            'database' => env('DB_LEGION_HOTFIXES', ''),
            'username' => env('DB_LEGION_USERNAME', ''),
            'password' => env('DB_LEGION_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        
        'mysql_legion_world_1' => [
            'driver' => 'mysql',
            'host' => env('DB_LEGION_HOST', ''),
            'port' => env('DB_PORT', ''),
            'database' => env('DB_LEGION_WORLD_1', ''),
            'username' => env('DB_LEGION_USERNAME', ''),
            'password' => env('DB_LEGION_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        
        'mysql_legion_world_2' => [
            'driver' => 'mysql',
            'host' => env('DB_LEGION_HOST', ''),
            'port' => env('DB_PORT', ''),
            'database' => env('DB_LEGION_WORLD_2', ''),
            'username' => env('DB_LEGION_USERNAME', ''),
            'password' => env('DB_LEGION_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
        
        'mysql_legion_world_3' => [
            'driver' => 'mysql',
            'host' => env('DB_LEGION_HOST', ''),
            'port' => env('DB_PORT', ''),
            'database' => env('DB_LEGION_WORLD_3', ''),
            'username' => env('DB_LEGION_USERNAME', ''),
            'password' => env('DB_LEGION_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'cluster' => false,

        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],

    ],

];
