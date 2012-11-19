<?php

namespace Wrath\OperationBundle\Controller;

use Wrath\OperationBundle\Entity\Operation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('WrathOperationBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function createAction() {
      $operation = new Operation();
      $operation->setName("Test Operation");
      $operation->setTotalValue(100);
      
      $user = $this->container->get('security.context')->getToken()->getUser();
      $operation->setCreator($user);
      
      $operation->setStartAt(new \DateTime('9-1-1985'));
      
      $em = $this->getDoctrine()->getManager();
      $em->persist($operation);
      $em->flush();
      
      return new Response('Created: ' . $operation->getId());
    }
}
