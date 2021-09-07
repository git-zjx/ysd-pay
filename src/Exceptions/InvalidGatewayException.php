<?php

namespace Git_zjx\Pay\Exceptions;

class InvalidGatewayException extends Exception
{
    /**
     * Bootstrap.
     *
     * @author Git_zjx <me@yansonga.cn>
     *
     * @param string       $message
     * @param array|string $raw
     */
    public function __construct($message, $raw = [])
    {
        parent::__construct('INVALID_GATEWAY: '.$message, $raw, self::INVALID_GATEWAY);
    }
}
