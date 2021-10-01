<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class RequestValidationException extends Exception
{
    public function report() {
        Log::error('Validation error');
    }
}
