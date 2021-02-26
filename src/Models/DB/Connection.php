<?php

declare(strict_types=1);

namespace App\Models\DB;

use \PDO;

class Connection
{
    public static function make(array $conf): PDO
    {
         return new PDO(
            "{$conf['connection']};dbname={$conf['dbname']};charset={$conf['charset']};",
            $conf['username'],
            $conf['password']
        );
    }
}