<?php

namespace Git_zjx\Pay\Contracts;

use Git_zjx\Supports\Collection;
use Symfony\Component\HttpFoundation\Response;

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
