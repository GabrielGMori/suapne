<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class LimparCadastrosPendentesExpirados extends Command
{
    protected $signature = 'cadastro:limpar-pendentes-expirados';
    protected $description = 'Remove cadastros pendentes expirados do cache';

    public function handle(): void
    {
        $prefix = config('cache.prefix');

        $deleted = DB::table('cache')
            ->where('key', 'like', "{$prefix}cadastro_pendente:%")
            ->where('expiration', '<', now()->timestamp)
            ->delete();

        $this->info("{$deleted} cadastros pendentes expirados removidos.");
    }
}
