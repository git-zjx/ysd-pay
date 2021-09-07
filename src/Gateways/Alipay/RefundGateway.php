<?php

namespace Git_zjx\Pay\Gateways\Alipay;

class RefundGateway
{
    /**
     * Find.
     *
     * @author Git_zjx <me@Git_zjx.cn>
     *
     * @param $order
     */
    public function find($order): array
    {
        return [
            'method' => 'alipay.trade.fastpay.refund.query',
            'biz_content' => json_encode(is_array($order) ? $order : ['out_trade_no' => $order]),
        ];
    }
}
