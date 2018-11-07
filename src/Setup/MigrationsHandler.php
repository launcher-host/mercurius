<?php

namespace Launcher\Mercurius\Setup;

use Illuminate\Support\Carbon;

/**
 * Handles timestamped migrations featuring:
 * - provides list of publishable migrations files
 * - timestamp files with the current datetime
 * - exclude migrations already published at `database/migrations`.
 */
class MigrationsHandler
{
    /**
     * Timestamp used for each migration filename.
     *
     * @var Carbon\Carbon
     */
    private $datetime;

    /**
     * Migrations currently on system.
     *
     * @var array
     */
    private $migrations;

    /**
     * The migrations to be publishable.
     *
     * @var array
     */
    private $publishable;

    /**
     * Create a new migration handler instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->datetime = Carbon::now();
        $this->migrations = glob(database_path('migrations/*.php'));
        $this->publishable = [];
    }

    /**
     * Process migrations.
     *
     * @param string|array $migration
     *
     * @return array
     */
    public function processMigrations($migration)
    {
        $_migrations = is_array($migration) ? $migration : func_get_args();

        array_map([$this, 'processMigration'], $_migrations);

        return $this->publishable;
    }

    /**
     * Process a single migration file.
     *
     * @param string $migration
     *
     * @return void
     */
    private function processMigration(string $migration)
    {
        $migration .= '.php';

        if ($this->migrationExists($migration)) {
            return;
        }

        // Append 1 second per migration to keep the right order
        $date = $this->datetime->addSecond()->Format('Y_m_d_His');

        $_from = __DIR__.'/../../publishable/database/migrations/'.$migration;
        $_to = database_path("migrations/${date}_${migration}");

        $this->publishable[$_from] = $_to;
    }

    /**
     * Check if a migration exists on system.
     *
     * @param string $migration
     *
     * @return bool
     */
    private function migrationExists(string $migration)
    {
        return array_first($this->migrations, function ($m) use ($migration) {
            return ends_with($m, $migration);
        });
    }
}
