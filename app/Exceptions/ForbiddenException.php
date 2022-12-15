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


class ForbiddenException extends HttpException
{
    /**
     * Constructor.
     *
     * @param string|null $message
     * @param int         $code
     * @param \Throwable  $previous
     */
    public function __construct(int $code = 403, string $message = null, \Throwable $previous = null)
    {
        parent::__construct($code, $message, $previous);
    }
}
