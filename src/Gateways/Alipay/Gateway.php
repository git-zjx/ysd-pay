<?php

namespace Git_zjx\Pay\Gateways\Alipay;

use Git_zjx\Pay\Contracts\GatewayInterface;
use Git_zjx\Pay\Exceptions\InvalidArgumentException;
use Git_zjx\Supports\Collection;

abstract class Gateway implements GatewayInterface
{
    /**
     * Mode.
     *
     * @var string
     */
    protected $mode;

    /**
     * Bootstrap.
     *
     * @author Git_zjx <me@Git_zjx.cn>
     *
     * @throws InvalidArgumentException
     */
    public function __construct()
    {
        $this->mode = Support::getInstance()->mode;
    }

    /**
     * Pay an order.
     *
     * @author Git_zjx <me@Git_zjx.cn>
     *
     * @param string $endpoint
     *
     * @return Collection
     */
    abstract public function pay($endpoint, array $payload);
}
