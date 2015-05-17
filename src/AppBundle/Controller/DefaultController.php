<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Intl\Intl;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $locale = $request->getLocale();

        $currency = Intl::getCurrencyBundle()->getCurrencyName('RON');

        return $this->render('default/index.html.twig',
            array(
                'currencies' => $currency
            ));
    }
}
