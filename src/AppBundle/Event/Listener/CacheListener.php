<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 18/11/16
 * Time: 21:46
 */

namespace AppBundle\Event\Listener;


use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class CacheListener
{
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();

        $response->headers->addCacheControlDirective('no-cache', true);
        $response->headers->addCacheControlDirective('max-age', 0);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        $response->headers->addCacheControlDirective('no-store', true);
    }
}