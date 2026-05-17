<?php

namespace App\Support;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class FakeBuilder
{
    /**
     * Returns an Eloquent Builder backed by an in-memory SQLite table
     * seeded with $rows. Columns are inferred from the first row.
     *
     * @param  array<int, array<string, mixed>>  $rows
     */
    public static function make(string $modelClass, array $rows): Builder
    {
        if (empty($rows)) {
            return $modelClass::query()->whereRaw('1 = 0');
        }

        $connName = 'fake_' . str($modelClass)->classBasename()->snake();

        // Register a fresh in-memory connection each time
        config(["database.connections.{$connName}" => [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]]);

        /** @var Model $instance */
        $instance = new $modelClass;
        $instance->setConnection($connName);

        $schema  = \Illuminate\Support\Facades\Schema::connection($connName);
        $table   = $instance->getTable();
        $columns = array_keys($rows[0]);

        if (! $schema->hasTable($table)) {
            $schema->create($table, function ($t) use ($columns) {
                $t->id();
                foreach ($columns as $col) {
                    if ($col === 'id') continue;
                    $t->string($col)->nullable();
                }
            });

            \Illuminate\Support\Facades\DB
                ::connection($connName)
                ->table($table)
                ->insert($rows);
        }

        return $modelClass::on($connName)->newQuery();
    }
}