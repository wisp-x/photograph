<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Command\Command as CommandAlias;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (file_exists(database_path('database.sqlite'))) {
            $this->warn('The program has been installed!');
        } else {
            while (! $password = $this->secret('Please enter the management password:')) {
                $this->warn('Password cannot be empty!');
            }

            Artisan::call('key:generate');
            Artisan::call('storage:link', ['--force' => true], $this->output);
            Artisan::call('migrate', ['--force' => true], $this->output);

            $this->setEnv(['APP_PASSWORD' => $password]);
        }

        return CommandAlias::SUCCESS;
    }

    protected function setEnv(array $data)
    {
        $replaces = collect($data)->transform(fn ($item, $key) => [strtoupper($key) => $item])->collapse();
        file_put_contents($this->laravel->environmentFilePath(), preg_replace(
            $replaces->map(fn ($item, $key) => $this->replacementPattern($key, env($key, '')))->values()->toArray(),
            $replaces->map(fn ($item, $key) => "{$key}={$item}")->values()->toArray(),
            file_get_contents($this->laravel->environmentFilePath())
        ));
    }

    protected function replacementPattern(string $name, string $value): string
    {
        $escaped = preg_quote('='.$value, '/');

        return "/^{$name}{$escaped}/m";
    }
}
