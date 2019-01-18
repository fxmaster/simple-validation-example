<?php
$baseDir = __DIR__ . '/../../';
include 'QueryBuilder.php';
include 'Connection.php';
$config = include $baseDir . 'config.php';

return new QueryBuilder(Connection::make($config['database']));