<?php

namespace Git_zjx\Pay\Contracts;

use Symfony\Component\HttpFoundation\Response;
use Git_zjx\Supports\Collection;

interface GatewayApplicationInterface
{
    /**
     * To pay.
     *
     * @author Git_zjx <me@yansonga.cn>
     *
     * @param string $gateway
     * @param array  $params
     *
     * @return Collection|Response
     */
    public function pay($gateway, $params);

    /**
     * Query an order.
     *
     * @author Git_zjx <me@Git_zjx.cn>
     *
     * @param string|array $order
     *
     * @return Collection
     */
    public function find($order, string $type);

    /**
     * Refund an order.
     *
     * @author Git_zjx <me@Git_zjx.cn>
     *
     * @return Collection
     */
    public function refund(array $order);

    /**
     * Cancel an order.
     *
     * @author Git_zjx <me@Git_zjx.cn>
     *
     * @param string|array $order
     *
     * @return Collection
     */
    public function cancel($order);

    /**
     * Close an order.
     *
     * @author Git_zjx <me@Git_zjx.cn>
     *
     * @param string|array $order
     *
     * @return Collection
     */
    public function close($order);

    /**
     * Verify a request.
     *
     * @author Git_zjx <me@Git_zjx.cn>
     *
     * @param string|array|null $content
     *
     * @return Collection
     */
    public function verify($content, bool $refund);

    /**
     * Echo success to server.
     *
     * @author Git_zjx <me@Git_zjx.cn>
     *
     * @return Response
     */
    public function success();
}
