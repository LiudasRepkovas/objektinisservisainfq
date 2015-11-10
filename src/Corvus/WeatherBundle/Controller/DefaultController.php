<?php

namespace Corvus\WeatherBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Corvus\WeatherBundle\CorvusWeatherBundle;

class DefaultController extends Controller
{
    /**
     * @Route("forecast/")
     * @Template()
     */
    public function forecastAction(Request $request){
        $weather = $this->get('nfq.weather');
        $weather->set_key('bd15241cebaaeba53a627a637677549a');
        $data = array(
            'latitude' => '54.696413',
            'longitude' => '25.277889'
        );


        $form = $this->createFormBuilder($data)
            ->add('longitude', 'text', array('label' => 'ilgumos:'))
            ->add('latitude', 'text', array('label' => 'platumos:'))
            ->add('save', 'submit', array('label' => 'saugoti'))
            ->getForm();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            $data = $form->getData();
        }

        $temperature = $weather->get_current_temperature(
            $data['latitude'],
            $data['longitude'],
            null,
            array(
            'units' => 'si',
            'exclude' => 'flags'
            )
        );

        return array(
            'temperature' =>  $temperature,
            'form' => $form->createView()
        );

    }
}
