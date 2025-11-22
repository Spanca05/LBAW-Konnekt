<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Runs database/thingy-seed.sql as-is.
     * The SQL reads current_setting('app.schema', true) and defaults to 'thingy'.
     */
    public function run(): void
    {
        // Get schema name from environment (e.g., .env or .env.testing)
        $schema = env('DB_SCHEMA');

        // If DB_SCHEMA is set, expose it to the SQL script
        // (the script reads it via current_setting('app.schema', true))
        if ($schema !== null) {
            DB::statement("SELECT set_config('app.schema', ?, false)", [$schema]);
        }

        // Execute create.sql first
        $create = file_get_contents(base_path('create.sql'));
        DB::unprepared($create);

        // Then execute populate.sql
        $populate = file_get_contents(base_path('populate.sql'));
        DB::unprepared($populate);

        // Show a message in the Artisan console
        $this->command?->info('Database seeded using schema: ' . ($schema ?? 'thingy (default)'));
    }
}
