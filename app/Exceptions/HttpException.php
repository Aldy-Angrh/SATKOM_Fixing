<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace App\Exceptions;

use Exception;
use Throwable;

class HttpException extends Exception implements Throwable
{

    /**
     * The HTTP status code.
     *
     * @var integer
     */
    public $code = 404;

    public $availableCodes = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        103 => 'Early Hints',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden Access',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        415 => 'Unsupported Media Type',
        419 => 'Page Expired',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
    ];

    public $message = 'The requested resource could not be found but may be available again in the future. Subsequent requests by the client are permissible.';

    public function __construct(int $code = 404, string $message = null, string $title = null)
    {
        $this->code = $code;
        $this->message = $message ?? $this->availableCodes[$this->code];
        $this->title = $title ?? $this->availableCodes[$this->code];
    }
}
