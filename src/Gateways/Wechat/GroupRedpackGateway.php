<?php

namespace Git_zjx\Pay\Gateways\Wechat;

use Git_zjx\Pay\Events;
use Git_zjx\Pay\Exceptions\GatewayException;
use Git_zjx\Pay\Exceptions\InvalidArgumentException;
use Git_zjx\Pay\Exceptions\InvalidSignException;
use Git_zjx\Pay\Gateways\Wechat;
use Git_zjx\Supports\Collection;

class GroupRedpackGateway extends Gateway
{
    /**
     * Pay an order.
     *
     * @author Git_zjx <me@Git_zjx.cn>
     *
     * @param string $endpoint
     *
     * @throws GatewayException
     * @throws InvalidArgumentException
     * @throws InvalidSignException
     */
    public function pay($endpoint, array $payload): Collection
    {
        $payload['wxappid'] = $payload['appid'];
        $payload['amt_type'] = 'ALL_RAND';

        if (Wechat::MODE_SERVICE === $this->mode) {
            $payload['msgappid'] = $payload['appid'];
        }

        unset($payload['appid'], $payload['trade_type'],
              $payload['notify_url'], $payload['spbill_create_ip']);

        $payload['sign'] = Support::generateSign($payload);

        Events::dispatch(new Events\PayStarted('Wechat', 'Group Redpack', $endpoint, $payload));

        return Support::requestApi(
            'mmpaymkttransfers/sendgroupredpack',
            $payload,
            true
        );
    }

    /**
     * Find.
     *
     * @author Git_zjx <me@Git_zjx.cn>
     *
     * @param $billno
     */
    public function find($billno): array
    {
        return [
            'endpoint' => 'mmpaymkttransfers/gethbinfo',
            'order' => ['mch_billno' => $billno, 'bill_type' => 'MCHT'],
            'cert' => true,
        ];
    }

    /**
     * Get trade type config.
     *
     * @author Git_zjx <me@Git_zjx.cn>
     */
    protected function getTradeType(): string
    {
        return '';
    }
}
