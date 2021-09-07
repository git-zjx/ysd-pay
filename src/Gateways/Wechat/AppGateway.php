<?php

namespace Git_zjx\Pay\Gateways\Wechat;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Git_zjx\Pay\Events;
use Git_zjx\Pay\Exceptions\GatewayException;
use Git_zjx\Pay\Exceptions\InvalidArgumentException;
use Git_zjx\Pay\Exceptions\InvalidSignException;
use Git_zjx\Pay\Gateways\Wechat;
use Git_zjx\Supports\Str;

class AppGateway extends Gateway
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
     * @throws Exception
     */
    public function pay($endpoint, array $payload): Response
    {
        $payload['appid'] = Support::getInstance()->appid;
        $payload['trade_type'] = $this->getTradeType();

        if (Wechat::MODE_SERVICE === $this->mode) {
            $payload['sub_appid'] = Support::getInstance()->sub_appid;
        }

        $pay_request = [
            'appid' => Wechat::MODE_SERVICE === $this->mode ? $payload['sub_appid'] : $payload['appid'],
            'partnerid' => Wechat::MODE_SERVICE === $this->mode ? $payload['sub_mch_id'] : $payload['mch_id'],
            'prepayid' => $this->preOrder($payload)->get('prepay_id'),
            'timestamp' => strval(time()),
            'noncestr' => Str::random(),
            'package' => 'Sign=WXPay',
        ];
        $pay_request['sign'] = Support::generateSign($pay_request);

        Events::dispatch(new Events\PayStarted('Wechat', 'App', $endpoint, $pay_request));

        return new JsonResponse($pay_request);
    }

    /**
     * Get trade type config.
     *
     * @author Git_zjx <me@Git_zjx.cn>
     */
    protected function getTradeType(): string
    {
        return 'APP';
    }
}
