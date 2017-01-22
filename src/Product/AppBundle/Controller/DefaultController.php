<?php

declare(strict_types=1);

namespace Product\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ProductAppBundle:Default:index.html.twig');
    }
}
