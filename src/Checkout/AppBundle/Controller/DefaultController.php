<?php

declare(strict_types=1);

namespace Checkout\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CheckoutAppBundle:Default:index.html.twig');
    }
}
