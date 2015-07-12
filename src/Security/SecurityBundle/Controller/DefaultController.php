<?php

namespace Security\SecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SecurityBundle:Default:index.html.twig', array('name' => $name));
    }
}
