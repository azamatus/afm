<?php

namespace Strokit\ConfigBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Bundle\FrameworkBundle\Command\CacheClearCommand;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

class AdminController extends CRUDController
{
    public function configAction()
    {
        $configurator = $this->get('strokit_config.configurator');

        $form = $this->createFormBuilder();

        foreach ($configurator->getParameters() as $key => $value)
        {
            if (0 !== strpos($key, 'database_'))
                $form->add($key, null,array('attr'=>array('class'=>'span5'),'required'=>false));
        }

        $form = $form->getForm();
        $form->setData($configurator->getParameters());

        $request = $this->get('request');
        if ('POST' === $request->getMethod()) {
            $form->bind($request);
            if ($form->isValid()) {
                $configurator->mergeParameters($form->getData());
                $configurator->write();
            }
        }

        return $this->render('StrokitConfigBundle:Default:index.html.twig', array(
            'form' => $form->createView(),
            'admin_pool' => $this->container->get('sonata.admin.pool'),
        ));
    }

    public function cacheclearAction()
    {
        $url = $this->get('request')->server->get('HTTP_REFERER');
        if (!$url)
            $url = $this->generateUrl('sonata_admin_dashboard');
        $this->clear();
        return $this->redirect($url);
    }

    private function clear()
    {
        $command = new CacheClearCommand();
        $command->setContainer($this->container);
        $input = new ArrayInput(array());
        $output = new NullOutput();
        $resultCode = $command->run($input, $output);
        return $resultCode;
    }

}
