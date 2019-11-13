<?php
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