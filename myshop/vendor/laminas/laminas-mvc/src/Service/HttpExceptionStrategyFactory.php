<?php

namespace Laminas\Mvc\Service;

use Interop\Container\ContainerInterface;
use Laminas\Mvc\View\Http\ExceptionStrategy;
use Laminas\ServiceManager\Factory\FactoryInterface;

class HttpExceptionStrategyFactory implements FactoryInterface
{
    use HttpViewManagerConfigTrait;

    /**
     * @param  ContainerInterface $container
     * @param  string $name
     * @param  null|array $options
     * @return ExceptionStrategy
     */
    public function __invoke(ContainerInterface $container, $name, ?array $options = null)
    {
        $strategy = new ExceptionStrategy();
        $config   = $this->getConfig($container);

        $this->injectDisplayExceptions($strategy, $config);
        $this->injectExceptionTemplate($strategy, $config);

        return $strategy;
    }

    /**
     * Inject strategy with configured display_exceptions flag.
     */
    private function injectDisplayExceptions(ExceptionStrategy $strategy, array $config)
    {
        $flag = $config['display_exceptions'] ?? false;
        $strategy->setDisplayExceptions($flag);
    }

    /**
     * Inject strategy with configured exception_template
     */
    private function injectExceptionTemplate(ExceptionStrategy $strategy, array $config)
    {
        $template = $config['exception_template'] ?? 'error';
        $strategy->setExceptionTemplate($template);
    }
}
