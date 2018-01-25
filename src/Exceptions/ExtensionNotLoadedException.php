<?php

namespace Larapulse\NewRelic\Exceptions;

use Throwable;

class ExtensionNotLoadedException extends \Exception
{
    public function __construct($code = 0, Throwable $previous = null)
    {
        $message = 'NewRelic extension is not loaded. Verify that newrelic.so is listed in your extension_dir';

        parent::__construct($message, $code, $previous);
    }
}
