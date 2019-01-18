<?php
class Connection{

    public static function make($conf){
         return new PDO(
            "{$conf['connection']};dbname={$conf['dbname']};charset={$conf['charset']};",
            $conf['username'],
            $conf['password']);
    }
}