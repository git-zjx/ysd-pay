<?php

namespace Git_zjx\Pay\Gateways\Alipay;

class WapGateway extends WebGateway
{
    /**
     * Get method config.
     *
     * @author Git_zjx <me@Git_zjx.cn>
     */
    protected function getMethod(): string
    {
        return 'alipay.trade.wap.pay';
    }

    /**
     * Get productCode config.
     *
     * @author Git_zjx <me@Git_zjx.cn>
     */
    protected function getProductCode(): string
    {
        return 'QUICK_WAP_WAY';
    }
}
