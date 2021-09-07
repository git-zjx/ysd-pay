<?php

namespace Git_zjx\Pay\Contracts;

use Symfony\Component\HttpFoundation\Response;
use Git_zjx\Supports\Collection;

interface GatewayInterface
{
    /**
     * Pay an order.
     *
     * @author Git_zjx <me@Git_zjx.cn>
     *
     * @param string $endpoint
     *
     * @return Collection|Response
     */
    public function pay($endpoint, array $payload);
}
