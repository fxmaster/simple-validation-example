<?php

declare(strict_types=1);

function dump(array $data): void {
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    die;
}