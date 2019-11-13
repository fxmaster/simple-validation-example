<?php

include 'QueryBuilder.php';
include 'Connection.php';

$baseDir = __DIR__ . '/../../';
$config = include $baseDir . 'config.php';

return new QueryBuilder(
    Connection::make($config['database'])
);