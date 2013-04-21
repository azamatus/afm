<?php

namespace Nurix\SliderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SliderController extends Controller
{
    public function getSliderAction()
    {
        $sliders = $this->getDoctrine()->getRepository('NurixSliderBundle:Slider')->findByActive(1);

        return $this->render('NurixSliderBundle:Slider:getslider.html.twig',array('sliders'=>$sliders));

    }
}