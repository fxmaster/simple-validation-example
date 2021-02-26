<?php

declare(strict_types=1);


$config = require_once(__DIR__ . '/../../../config.php');

return new QueryBuilder(
    Connection::make($config['database'])
);
