<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DevController extends Controller
{

    public function phpinfoAction()
    {
        phpinfo();
        return new Response();
    }

}
