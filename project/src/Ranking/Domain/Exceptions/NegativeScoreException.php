<?php
namespace App\Ranking\Domain\Exceptions;

use Exception;

class NegativeScoreException extends Exception
{
    public function __construct()
    {
        parent::__construct('Score cannot be negative');
    }
}