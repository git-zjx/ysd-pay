<?php

namespace Git_zjx\Pay\Gateways\Wechat;

use Exception;
use Git_zjx\Pay\Events;
use Git_zjx\Pay\Exceptions\GatewayException;
use Git_zjx\Pay\Exceptions\InvalidArgumentException;
use Git_zjx\Pay\Exceptions\InvalidSignException;
use Git_zjx\Supports\Collection;
use Git_zjx\Supports\Str;

class MpGateway extends Gateway
{
    /**
     * @var bool
     */
    protected $payRequestUseSubAppId = false;

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
     * @throws Exception
     */
    public function pay($endpoint, array $payload): Collection
    {
        $payload['trade_type'] = $this->getTradeType();

        $pay_request = [
            'appId' => !$this->payRequestUseSubAppId ? $payload['appid'] : $payload['sub_appid'],
            'timeStamp' => strval(time()),
            'nonceStr' => Str::random(),
            'package' => 'prepay_id='.$this->preOrder($payload)->get('prepay_id'),
            'signType' => 'MD5',
        ];
        $pay_request['paySign'] = Support::generateSign($pay_request);

        Events::dispatch(new Events\PayStarted('Wechat', 'JSAPI', $endpoint, $pay_request));

        return new Collection($pay_request);
    }

    /**
     * Get trade type config.
     *
     * @author Git_zjx <me@Git_zjx.cn>
     */
    protected function getTradeType(): string
    {
        return 'JSAPI';
    }
}
