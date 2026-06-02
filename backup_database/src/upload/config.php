<?php

declare(strict_types=1);

return [
    'db' => [
        'host' => '100.100.55.22',
        'port' => 62307,
        'name' => 'sdk_db',
        'username' => 'root',
        'password' => '123',
        'charset' => 'utf8mb4',
    ],

    'backup_dir' => __DIR__ . '/uploads/backup',
    'backup_prefix' => 'backup_sdk_db_',
    'keep_last_files' => 12,
    'timezone' => 'Asia/Jakarta',
];