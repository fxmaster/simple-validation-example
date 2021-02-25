<?php

declare(strict_types=1);

require_once(__DIR__ . 'QueryBuilder.php');
require_once(__DIR__ . 'Connection.php');

$config = require_once(__DIR__ . '/../../../config.php');

return new QueryBuilder(
    Connection::make($config['database'])
);
