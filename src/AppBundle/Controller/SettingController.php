<?php

namespace AppBundle\Controller;

use AppBundle\Service\PiCamera;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SettingController extends Controller
{
    /**
     * @Route("/settings")
     */
    public function indexAction(Request $request, $option)
    {
        return $this->render('AppBundle:Settings:default.html.twig');
    }

    /**
     * @Route("/settings/{option}")
     */
    public function setAction(Request $request, $option = null)
    {
        $widget = $this->get('pi_camera')->getWidget($option);
        return $this->render(
            'AppBundle:Settings:option.html.twig',
            [
                'form' => $widget->getForm(),
                'option' => $widget->getOption(),
            ]
        );
    }
}
