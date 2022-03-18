<?php

namespace Git_zjx\Pay\Gateways\Alipay;

use Git_zjx\Pay\Events;
use Git_zjx\Pay\Exceptions\GatewayException;
use Git_zjx\Pay\Exceptions\InvalidArgumentException;
use Git_zjx\Pay\Exceptions\InvalidConfigException;
use Git_zjx\Pay\Exceptions\InvalidSignException;
use Git_zjx\Pay\Gateways\Alipay;
use Git_zjx\Supports\Collection;

class TradeGateway extends Gateway
{
    /**
     * Pay an order.
     *
     * @author Git_zjx <me@Git_zjx.cn>
     *
     * @param string $endpoint
     *
     * @throws InvalidArgumentException
     * @throws GatewayException
     * @throws InvalidConfigException
     * @throws InvalidSignException
     */
    public function pay($endpoint, array $payload): Collection
    {
        $payload['method'] = 'alipay.trade.pay';
        $biz_array = json_decode($payload['biz_content'], true);
        if ((Alipay::MODE_SERVICE === $this->mode) && (!empty(Support::getInstance()->pid))) {
            $biz_array['extend_params'] = is_array($biz_array['extend_params']) ? array_merge(['sys_service_provider_id' => Support::getInstance()->pid], $biz_array['extend_params']) : ['sys_service_provider_id' => Support::getInstance()->pid];
        }
        $payload['biz_content'] = json_encode($biz_array);
        $payload['sign'] = Support::generateSign($payload);

        Events::dispatch(new Events\PayStarted('Alipay', 'Trade', $endpoint, $payload));

        return Support::requestApi($payload);
    }
}
