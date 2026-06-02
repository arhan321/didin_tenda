<?php

declare(strict_types=1);

/**
 * Native PHP MySQL/MariaDB backup to .sql file
 * Jalankan via browser atau CLI.
 */

$config = require __DIR__ . '/config.php';

date_default_timezone_set($config['timezone'] ?? 'Asia/Jakarta');

function pdoConnect(array $db): PDO
{
    $dsn = sprintf(
        'mysql:host=%s;port=%d;dbname=%s;charset=%s',
        $db['host'],
        (int) $db['port'],
        $db['name'],
        $db['charset']
    );

    return new PDO($dsn, $db['username'], $db['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => false,
    ]);
}

function ensureDirectory(string $dir): void
{
    if (!is_dir($dir) && !mkdir($dir, 0775, true) && !is_dir($dir)) {
        throw new RuntimeException('Gagal membuat folder backup: ' . $dir);
    }

    if (!is_writable($dir)) {
        throw new RuntimeException('Folder backup tidak bisa ditulis: ' . $dir);
    }
}

function getAllTables(PDO $pdo): array
{
    $tables = [];
    $stmt = $pdo->query('SHOW TABLES');

    while (($row = $stmt->fetch(PDO::FETCH_NUM)) !== false) {
        $tables[] = $row[0];
    }

    return $tables;
}

function getCreateTable(PDO $pdo, string $table): string
{
    $stmt = $pdo->query('SHOW CREATE TABLE `' . str_replace('`', '``', $table) . '`');
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        throw new RuntimeException('Tidak bisa mengambil struktur tabel: ' . $table);
    }

    $createSql = $row['Create Table'] ?? array_values($row)[1] ?? null;

    if (!$createSql) {
        throw new RuntimeException('Format SHOW CREATE TABLE tidak valid untuk tabel: ' . $table);
    }

    return $createSql . ";\n";
}

function sqlValue(PDO $pdo, mixed $value): string
{
    if ($value === null) {
        return 'NULL';
    }

    if (is_bool($value)) {
        return $value ? '1' : '0';
    }

    if (is_int($value) || is_float($value)) {
        return (string) $value;
    }

    return $pdo->quote((string) $value);
}

function writeTableData(PDO $pdo, string $table, $handle, int $batchSize = 200): int
{
    $tableSafe = '`' . str_replace('`', '``', $table) . '`';
    $columnsStmt = $pdo->query('SHOW COLUMNS FROM ' . $tableSafe);
    $columns = [];

    while (($col = $columnsStmt->fetch()) !== false) {
        $columns[] = '`' . str_replace('`', '``', $col['Field']) . '`';
    }

    if ($columns === []) {
        return 0;
    }

    $query = $pdo->query('SELECT * FROM ' . $tableSafe);
    $totalRows = 0;
    $buffer = [];
    $columnList = implode(', ', $columns);

    while (($row = $query->fetch(PDO::FETCH_ASSOC)) !== false) {
        $values = [];
        foreach ($row as $value) {
            $values[] = sqlValue($pdo, $value);
        }

        $buffer[] = '(' . implode(', ', $values) . ')';
        $totalRows++;

        if (count($buffer) >= $batchSize) {
            fwrite($handle, 'INSERT INTO ' . $tableSafe . ' (' . $columnList . ') VALUES' . "\n");
            fwrite($handle, implode(",\n", $buffer) . ";\n\n");
            $buffer = [];
        }
    }

    if ($buffer !== []) {
        fwrite($handle, 'INSERT INTO ' . $tableSafe . ' (' . $columnList . ') VALUES' . "\n");
        fwrite($handle, implode(",\n", $buffer) . ";\n\n");
    }

    return $totalRows;
}

function cleanupOldBackups(string $dir, string $prefix, int $keepLastFiles): void
{
    if ($keepLastFiles <= 0) {
        return;
    }

    $files = glob(rtrim($dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $prefix . '*.sql');

    if (!$files || count($files) <= $keepLastFiles) {
        return;
    }

    usort($files, static fn(string $a, string $b): int => filemtime($b) <=> filemtime($a));
    $filesToDelete = array_slice($files, $keepLastFiles);

    foreach ($filesToDelete as $file) {
        if (is_file($file)) {
            @unlink($file);
        }
    }
}

function runBackup(array $config): array
{
    $backupDir = $config['backup_dir'];
    $prefix = $config['backup_prefix'] ?? 'backup_db_';
    $databaseName = $config['db']['name'];

    ensureDirectory($backupDir);

    $lockFile = $backupDir . DIRECTORY_SEPARATOR . 'backup.lock';
    $lockHandle = fopen($lockFile, 'c+');

    if ($lockHandle === false) {
        throw new RuntimeException('Gagal membuat lock file.');
    }

    if (!flock($lockHandle, LOCK_EX | LOCK_NB)) {
        fclose($lockHandle);
        throw new RuntimeException('Backup sedang berjalan oleh proses lain.');
    }

    $timestamp = date('Y-m-d_H-i-s');
    $fileName = $prefix . $databaseName . '_' . $timestamp . '.sql';
    $filePath = rtrim($backupDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $fileName;

    try {
        $pdo = pdoConnect($config['db']);
        $handle = fopen($filePath, 'wb');

        if ($handle === false) {
            throw new RuntimeException('Gagal membuat file backup: ' . $filePath);
        }

        $tables = getAllTables($pdo);

        fwrite($handle, "-- --------------------------------------------------\n");
        fwrite($handle, "-- AUTO DATABASE BACKUP\n");
        fwrite($handle, "-- Database : {$databaseName}\n");
        fwrite($handle, "-- Dibuat   : " . date('Y-m-d H:i:s') . "\n");
        fwrite($handle, "-- --------------------------------------------------\n\n");
        fwrite($handle, "SET NAMES utf8mb4;\n");
        fwrite($handle, "SET FOREIGN_KEY_CHECKS = 0;\n\n");

        $summary = [
            'tables' => 0,
            'rows' => 0,
        ];

        foreach ($tables as $table) {
            fwrite($handle, "-- ----------------------------\n");
            fwrite($handle, "-- Table structure for {$table}\n");
            fwrite($handle, "-- ----------------------------\n");
            fwrite($handle, 'DROP TABLE IF EXISTS `' . str_replace('`', '``', $table) . "`;\n");
            fwrite($handle, getCreateTable($pdo, $table));
            fwrite($handle, "\n");

            fwrite($handle, "-- ----------------------------\n");
            fwrite($handle, "-- Records of {$table}\n");
            fwrite($handle, "-- ----------------------------\n");
            $summary['rows'] += writeTableData($pdo, $table, $handle);
            $summary['tables']++;
        }

        fwrite($handle, "SET FOREIGN_KEY_CHECKS = 1;\n");
        fclose($handle);

        cleanupOldBackups($backupDir, $prefix, (int) ($config['keep_last_files'] ?? 0));

        flock($lockHandle, LOCK_UN);
        fclose($lockHandle);

        return [
            'success' => true,
            'file_name' => $fileName,
            'file_path' => $filePath,
            'tables' => $summary['tables'],
            'rows' => $summary['rows'],
            'size' => filesize($filePath) ?: 0,
        ];
    } catch (Throwable $e) {
        if (isset($handle) && is_resource($handle)) {
            fclose($handle);
        }

        if (isset($filePath) && is_file($filePath) && filesize($filePath) === 0) {
            @unlink($filePath);
        }

        flock($lockHandle, LOCK_UN);
        fclose($lockHandle);

        throw $e;
    }
}

try {
    $result = runBackup($config);

    $message = [
        'status' => 'success',
        'message' => 'Backup database berhasil dibuat.',
        'file_name' => $result['file_name'],
        'file_path' => $result['file_path'],
        'tables' => $result['tables'],
        'rows' => $result['rows'],
        'size_bytes' => $result['size'],
    ];

    if (PHP_SAPI === 'cli') {
        echo json_encode($message, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL;
    } else {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($message, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
} catch (Throwable $e) {
    http_response_code(500);
    $message = [
        'status' => 'error',
        'message' => $e->getMessage(),
    ];

    if (PHP_SAPI === 'cli') {
        fwrite(STDERR, json_encode($message, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL);
    } else {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($message, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}