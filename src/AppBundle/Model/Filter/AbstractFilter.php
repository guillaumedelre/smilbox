<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 20/11/16
 * Time: 21:16
 */

namespace AppBundle\Model\Filter;

use Psr\Log\LoggerInterface;

abstract class AbstractFilter implements FilterInterface, FxAwareInterface
{
    const NAME = '';

    /** @var LoggerInterface */
    protected $logger;

    /**
     * AbstractFilter constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param string $filter
     * @return bool
     */
    public function canSupport($filter)
    {
        $className = get_class($this);

        $supported = $this->isAware() && $this->getName() == strtoupper($filter);

        dump([
            $className,
            $this->isAware(),
            $this->getName(),
            strtoupper($filter),
            $this->getName() == strtoupper($filter),
            $supported,
        ]);

        if ($supported) {
            $this->logger->info(sprintf('%s supports %s', $className, $filter));
        } else {
            $this->logger->notice(sprintf('%s does not support %s', $className, $filter));
        }

        return $supported;
    }

    abstract protected function getName();

}