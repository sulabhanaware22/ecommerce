<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class CartDuplicateItemException extends Exception
{
     public function report()
    {
        Log::debug('Duplicate Cart Item Added!');
    }
}
