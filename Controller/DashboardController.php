<?php

namespace Ekyna\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function indexAction()
    {
        return $this->render('EkynaBackendBundle:Dashboard:index.html.twig');
    }
}
