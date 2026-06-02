<?php

declare(strict_types=1);

return [
    'db' => [
        'host' => '100.100.55.22',
        'port' => 32346,
        'name' => 'didin_tendav2',
        'username' => 'root',
        'password' => '123',
        'charset' => 'utf8mb4',
    ],

    'backup_dir' => __DIR__ . '/uploads/backup',
    'backup_prefix' => 'backup_didin_tendav2_',
    'keep_last_files' => 12,
    'timezone' => 'Asia/Jakarta',
];