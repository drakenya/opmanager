<?php

namespace Wrath\AccountingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('WrathAccountingBundle:Default:index.html.twig', array('name' => $name));
    }
}
