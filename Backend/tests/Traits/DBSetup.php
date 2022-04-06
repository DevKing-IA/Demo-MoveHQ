<?php

namespace MovehqAppTests\Traits;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

trait DBSetup
{
    /**
     * If true, setup has run at least once.
     * @var boolean
     */
    protected static $setUpHasRunOnce = false;
    /**
     * After the first run of setUp "migrate:fresh --seed"
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        if (!static::$setUpHasRunOnce) {
            // Add migrate & truncate as it's faster with large migration sets
            // Toggle variable below to rest the database completely if you need...
            self::dbCheckUsingTestDatabase();

            $fresh = false;

            if ($fresh) {
                // Migrate from empty DB - slowwwwwww
                Log::debug('Migrating - fresh! ...');
                Artisan::call('migrate:fresh');
                Log::debug('Seeding ...');
                Artisan::call(
                    'db:seed',
                    ['--class' => 'TestingDatabaseSeeder']
                );
            } else {
                // Migrate & truncate - fastest
                Log::debug('Truncating ...');
                $this->truncateTables();

                Log::debug('Migrating ...');
                Artisan::call('migrate');

                Log::debug('Seeding ...');
                Artisan::call(
                    'db:seed',
                    ['--class' => 'TestingDatabaseSeeder']
                );
            }

            Log::debug('Migrated');
            static::$setUpHasRunOnce = true;
        }
    }

    public function truncateTables(): void
    {
        // Add tables that shouldn't be migrated here ...
        $tablesNotToTruncate = [
            'migrations',
        ];

        $databaseName = DB::connection()->getDatabaseName();
        DB::select('SET FOREIGN_KEY_CHECKS = 0; ');
        $tables = DB::select('SELECT table_name FROM information_schema.tables WHERE table_schema = "' . $databaseName . '"');
        foreach ($tables as $table) {
            if (!in_array($table->table_name, $tablesNotToTruncate)) {
                DB::table($table->table_name)->truncate();
            }
        }

        // Add custom truncation commands here ...

        DB::select('SET FOREIGN_KEY_CHECKS = 1; ');
    }

    public static function dbCheckUsingTestDatabase(): void
    {
        $databaseName = DB::connection()->getDatabaseName();
        if (!Str::contains($databaseName, 'test')) {
            throw new \Exception('It looks like you\'re running tests on a NON testing DB - check your settings. Current DB name = ' . $databaseName);
        }
    }
}
