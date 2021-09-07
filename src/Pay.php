<?php

namespace Git_zjx\Pay;

use Exception;
use Git_zjx\Pay\Contracts\GatewayApplicationInterface;
use Git_zjx\Pay\Exceptions\InvalidGatewayException;
use Git_zjx\Pay\Gateways\Alipay;
use Git_zjx\Pay\Gateways\Wechat;
use Git_zjx\Pay\Listeners\KernelLogSubscriber;
use Git_zjx\Supports\Config;
use Git_zjx\Supports\Log;
use Git_zjx\Supports\Logger;
use Git_zjx\Supports\Str;

/**
 * @method static Alipay alipay(array $config) 支付宝
 * @method static Wechat wechat(array $config) 微信
 */
class Pay
{
    /**
     * Config.
     *
     * @var Config
     */
    protected $config;

    /**
     * Bootstrap.
     *
     * @author Git_zjx <me@Git_zjx.cn>
     *
     * @throws Exception
     */
    public function __construct(array $config)
    {
        $this->config = new Config($config);

        $this->registerLogService();
        $this->registerEventService();
    }

    /**
     * Magic static call.
     *
     * @author Git_zjx <me@Git_zjx.cn>
     *
     * @param string $method
     * @param array  $params
     *
     * @throws InvalidGatewayException
     * @throws Exception
     */
    public static function __callStatic($method, $params): GatewayApplicationInterface
    {
        $app = new self(...$params);

        return $app->create($method);
    }

    /**
     * Create a instance.
     *
     * @author Git_zjx <me@Git_zjx.cn>
     *
     * @param string $method
     *
     * @throws InvalidGatewayException
     */
    protected function create($method): GatewayApplicationInterface
    {
        $gateway = __NAMESPACE__.'\\Gateways\\'.Str::studly($method);

        if (class_exists($gateway)) {
            return self::make($gateway);
        }

        throw new InvalidGatewayException("Gateway [{$method}] Not Exists");
    }

    /**
     * Make a gateway.
     *
     * @author Git_zjx <me@yansonga.cn>
     *
     * @param string $gateway
     *
     * @throws InvalidGatewayException
     */
    protected function make($gateway): GatewayApplicationInterface
    {
        $app = new $gateway($this->config);

        if ($app instanceof GatewayApplicationInterface) {
            return $app;
        }

        throw new InvalidGatewayException("Gateway [{$gateway}] Must Be An Instance Of GatewayApplicationInterface");
    }

    /**
     * Register log service.
     *
     * @author Git_zjx <me@Git_zjx.cn>
     *
     * @throws Exception
     */
    protected function registerLogService()
    {
        $config = $this->config->get('log');
        $config['identify'] = 'Git_zjx.pay';

        $logger = new Logger();
        $logger->setConfig($config);

        Log::setInstance($logger);
    }

    /**
     * Register event service.
     *
     * @author Git_zjx <me@Git_zjx.cn>
     */
    protected function registerEventService()
    {
        Events::setDispatcher(Events::createDispatcher());

        Events::addSubscriber(new KernelLogSubscriber());
    }
}
