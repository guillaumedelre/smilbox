<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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
     * @Method({"GET", "POST"})
     */
    public function setAction(Request $request, $option)
    {
        if (Request::METHOD_POST === $request->getMethod()) {
            $compute = $request->request->get('compute', null);
            $request->request->remove('compute');
            if (count($request->request->all()) > 1) {
                foreach ($request->request->all() as $key => $value) {
                    if ('compute' === $key) {
                        continue;
                    }
                    $this->get('pi_camera')->set($key, $value, $compute);
                }
            } else {
                $values = array_values($request->request->all());
                $this->get('pi_camera')->set(key($request->request->all()), reset($values));
                $this->redirectToRoute('app_setting_set', ['option' => $option]);
            }
        }

        $widget = $this->get('pi_camera')->getWidget($option);
        return $this->render(
            'AppBundle:Settings:option.html.twig',
            ['widget' => $widget]
        );
    }
}
