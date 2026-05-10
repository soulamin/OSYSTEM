<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use RuntimeException;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;

class DatabaseBackupService
{
    public function createBackup(): array
    {
        $connectionName = Config::get('database.default');
        $connection = Config::get("database.connections.{$connectionName}");

        if (! is_array($connection) || empty($connection['driver'])) {
            throw new RuntimeException('Conexao de banco nao configurada para backup.');
        }

        return match ($connection['driver']) {
            'mysql', 'mariadb' => $this->dumpMySql($connection),
            'pgsql' => $this->dumpPgSql($connection),
            'sqlite' => $this->copySqlite($connection),
            default => throw new RuntimeException('Driver de banco nao suportado para backup completo.'),
        };
    }

    private function dumpMySql(array $connection): array
    {
        $database = (string) ($connection['database'] ?? '');
        if ($database === '') {
            throw new RuntimeException('Nome do banco nao configurado.');
        }

        $backup = $this->prepareBackupFile($database, 'sql');
        $binary = $this->findExecutable([
            env('MYSQLDUMP_PATH'),
            env('MARIADB_DUMP_PATH'),
            'C:\\xampp\\mysql\\bin\\mysqldump.exe',
            'C:\\xampp\\mysql\\bin\\mariadb-dump.exe',
            'C:\\xampp\\mysqlold\\bin\\mysqldump.exe',
            'mysqldump',
            'mariadb-dump',
        ]);

        $process = new Process([
            $binary,
            '--single-transaction',
            '--quick',
            '--routines',
            '--triggers',
            '--events',
            '--hex-blob',
            '--skip-comments',
            '--default-character-set=' . ($connection['charset'] ?? 'utf8mb4'),
            '--host=' . ($connection['host'] ?? '127.0.0.1'),
            '--port=' . ($connection['port'] ?? '3306'),
            '--user=' . ($connection['username'] ?? ''),
            '--result-file=' . $backup['path'],
            $database,
        ]);

        $env = [];
        if (array_key_exists('password', $connection)) {
            $env['MYSQL_PWD'] = (string) ($connection['password'] ?? '');
        }

        $process->setEnv($env);
        $process->setTimeout(600);
        $process->run();

        if (! $process->isSuccessful()) {
            @File::delete($backup['path']);
            throw new RuntimeException('Falha ao gerar o dump do MySQL: ' . trim($process->getErrorOutput() ?: $process->getOutput()));
        }

        return $this->finalizeBackup($backup['path'], $backup['filename']);
    }

    private function dumpPgSql(array $connection): array
    {
        $database = (string) ($connection['database'] ?? '');
        if ($database === '') {
            throw new RuntimeException('Nome do banco nao configurado.');
        }

        $backup = $this->prepareBackupFile($database, 'sql');
        $binary = $this->findExecutable([
            env('PG_DUMP_PATH'),
            'pg_dump',
            'C:\\Program Files\\PostgreSQL\\16\\bin\\pg_dump.exe',
            'C:\\Program Files\\PostgreSQL\\15\\bin\\pg_dump.exe',
            'C:\\Program Files\\PostgreSQL\\14\\bin\\pg_dump.exe',
        ]);

        $process = new Process([
            $binary,
            '--clean',
            '--if-exists',
            '--format=plain',
            '--encoding=UTF8',
            '--host=' . ($connection['host'] ?? '127.0.0.1'),
            '--port=' . ($connection['port'] ?? '5432'),
            '--username=' . ($connection['username'] ?? ''),
            '--file=' . $backup['path'],
            $database,
        ]);

        $env = [];
        if (array_key_exists('password', $connection)) {
            $env['PGPASSWORD'] = (string) ($connection['password'] ?? '');
        }

        $process->setEnv($env);
        $process->setTimeout(600);
        $process->run();

        if (! $process->isSuccessful()) {
            @File::delete($backup['path']);
            throw new RuntimeException('Falha ao gerar o dump do PostgreSQL: ' . trim($process->getErrorOutput() ?: $process->getOutput()));
        }

        return $this->finalizeBackup($backup['path'], $backup['filename']);
    }

    private function copySqlite(array $connection): array
    {
        $source = (string) ($connection['database'] ?? '');
        if ($source === '' || ! File::exists($source)) {
            throw new RuntimeException('Arquivo do banco SQLite nao encontrado.');
        }

        $name = pathinfo($source, PATHINFO_FILENAME) ?: 'database';
        $backup = $this->prepareBackupFile($name, 'sqlite');
        File::copy($source, $backup['path']);

        return $this->finalizeBackup($backup['path'], $backup['filename']);
    }

    private function prepareBackupFile(string $database, string $extension): array
    {
        $directory = storage_path('app/backups');
        File::ensureDirectoryExists($directory);

        $safeDatabase = preg_replace('/[^A-Za-z0-9_-]+/', '-', $database) ?: 'database';
        $filename = sprintf('%s-%s.%s', $safeDatabase, now()->format('Y-m-d_H-i-s'), $extension);
        $path = $directory . DIRECTORY_SEPARATOR . $filename;

        return ['path' => $path, 'filename' => $filename];
    }

    private function finalizeBackup(string $path, string $filename): array
    {
        if (! File::exists($path) || File::size($path) <= 0) {
            throw new RuntimeException('O arquivo de backup nao foi gerado corretamente.');
        }

        return ['path' => $path, 'filename' => $filename];
    }

    private function findExecutable(array $candidates): string
    {
        $finder = new ExecutableFinder();

        foreach ($candidates as $candidate) {
            $candidate = trim((string) $candidate);
            if ($candidate === '') {
                continue;
            }

            if (File::exists($candidate)) {
                return $candidate;
            }

            $found = $finder->find($candidate);
            if ($found) {
                return $found;
            }
        }

        throw new RuntimeException('Nao foi possivel localizar o executavel de backup do banco.');
    }
}
