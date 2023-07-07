<?php

namespace App\Ranking\Infrastructure\Exceptions;

use Exception;

class PlayerNotFound extends Exception
{
    public function __construct()
    {
        parent::__construct('Player not found');
    }
}