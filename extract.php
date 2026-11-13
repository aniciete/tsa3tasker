<?php

/**
 * InfinityFree Deployment Extractor & MySQL Provisioner (tsa3.freedev.app).
 *
 * Unpacks tsa3tasker-infinityfree.zip into /htdocs, configures writable storage,
 * reads database credentials from the unpacked .env file to import database/schema_export.sql,
 * falls back to pre-migrated SQLite if MySQL provisioning fails, and removes itself.
 */
header('Content-Type: text/plain; charset=utf-8');

/**
 * Parse key=value entries from a dotenv file without executing shell syntax.
 *
 * @return array<string, string>
 */
function parseDotEnv(string $path): array
{
    if (! file_exists($path)) {
        return [];
    }

    $values = [];
    foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $trimmed = trim($line);
        if ($trimmed === '' || str_starts_with($trimmed, '#') || ! str_contains($trimmed, '=')) {
            continue;
        }

        [$key, $val] = explode('=', $trimmed, 2);
        $values[trim($key)] = trim(trim($val), "\"'");
    }

    return $values;
}

$zipFile = __DIR__.'/tsa3tasker-infinityfree.zip';

if (! file_exists($zipFile)) {
    http_response_code(404);
    echo "ERROR: Deployment package not found at {$zipFile}\n";
    exit(1);
}

if (! class_exists('ZipArchive')) {
    http_response_code(500);
    echo "ERROR: ZipArchive extension is not enabled.\n";
    exit(1);
}

$zip = new ZipArchive;
if ($zip->open($zipFile) !== true) {
    http_response_code(500);
    echo "ERROR: Unable to open {$zipFile}.\n";
    exit(1);
}

$extracted = $zip->extractTo(__DIR__);
$zip->close();

if (! $extracted) {
    http_response_code(500);
    echo 'ERROR: Failed extracting archive into '.__DIR__."\n";
    exit(1);
}

@unlink($zipFile);
echo "SUCCESS: Extracted tsa3tasker-infinityfree.zip.\n";

if (file_exists(__DIR__.'/index2.html')) {
    @unlink(__DIR__.'/index2.html');
    echo "Removed InfinityFree placeholder index2.html.\n";
}

$storageDirs = [
    __DIR__.'/storage/app/public',
    __DIR__.'/storage/framework/cache/data',
    __DIR__.'/storage/framework/sessions',
    __DIR__.'/storage/framework/views',
    __DIR__.'/storage/logs',
    __DIR__.'/bootstrap/cache',
];
foreach ($storageDirs as $dir) {
    if (! is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
    @chmod($dir, 0777);
}
echo "Verified storage and cache directories.\n";

$env = parseDotEnv(__DIR__.'/.env');
$sqlFile = __DIR__.'/database/schema_export.sql';
$dbHost = $env['DB_HOST'] ?? '';
$dbName = $env['DB_DATABASE'] ?? '';
$dbUser = $env['DB_USERNAME'] ?? '';
$dbPass = $env['DB_PASSWORD'] ?? '';

$mysqlSuccess = false;
if ($dbHost !== '' && $dbName !== '' && $dbUser !== '' && file_exists($sqlFile)) {
    try {
        $dsn = "mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4";
        $pdo = new PDO($dsn, $dbUser, $dbPass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 10,
        ]);

        $rawSql = file_get_contents($sqlFile);
        $cleanSql = preg_replace('/^--.*$/m', '', $rawSql);
        $statements = array_filter(array_map('trim', explode(';', $cleanSql)));

        foreach ($statements as $stmt) {
            if ($stmt !== '') {
                $pdo->exec($stmt);
            }
        }
        echo "SUCCESS: Provisioned MySQL schema and seed data in {$dbName} on {$dbHost}.\n";
        $mysqlSuccess = true;
    } catch (Throwable $e) {
        echo 'NOTICE: MySQL provisioning failed ('.$e->getMessage().").\n";
    }
}

$envFile = __DIR__.'/.env';
$sqliteFile = __DIR__.'/database/database.sqlite';
if (! $mysqlSuccess && file_exists($envFile) && file_exists($sqliteFile)) {
    $envContent = file_get_contents($envFile);
    $envContent = preg_replace('/^DB_CONNECTION=mysql$/m', 'DB_CONNECTION=sqlite', $envContent);
    file_put_contents($envFile, $envContent);
    echo "Fallback: configured pre-seeded SQLite connection in .env.\n";
}

@unlink(__FILE__);
echo "Removed extract.php.\n";
