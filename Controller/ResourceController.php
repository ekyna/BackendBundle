<?php

namespace Ekyna\BackendBundle\Controller;

#use Symfony\Component\EventDispatcher\Event;
#use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
#use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController as BaseResourceController;
#use Sylius\Bundle\ResourceBundle\Event\ResourceEvent;

use ChromePhp;

/**
 * Resource controller.
 */
class ResourceController extends BaseResourceController
{
    protected function isApiRequest()
    {
        return !$this->get('fos_rest.view_handler')->isFormatTemplating($this->getRequest()->getRequestFormat());
    }

    /**
     * Create new resource or just display the form.
     */
    public function createAction(Request $request)
    {
        $config = $this->getConfiguration();

        $resource = $this->createNew();
        $form = $this->getForm($resource);

        if ($request->isMethod('POST') && $form->bind($request)->isValid()) {
            $event = $this->create($resource);
            if (!$event->isStopped()) {
                $this->setFlash('success', 'create');

                return $this->redirectTo($resource);
            }

            $this->setFlash($event->getMessageType(), $event->getMessage(), $event->getMessageParams());
        }

        if ($this->isApiRequest()) {
            return $this->handleView($this->view($form));
        }

        $view = $this
            ->view()
            ->setTemplate($config->getTemplate('create.'.$request->getRequestFormat()))
            ->setData(array(
                $config->getResourceName() => $resource,
                'form'                     => $form->createView()
            ))
        ;

        return $this->handleView($view);
    }
}
