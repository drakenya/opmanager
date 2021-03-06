<?php

namespace Wrath\OperationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Wrath\OperationBundle\Entity\Operation;
use Wrath\OperationBundle\Entity\Participant;
use Wrath\OperationBundle\Form\OperationType;

/**
 * Operation controller.
 *
 */
class OperationController extends Controller
{
    /**
     * Lists all Operation entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('WrathOperationBundle:Operation')->findAll();

        return $this->render('WrathOperationBundle:Operation:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a Operation entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WrathOperationBundle:Operation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Operation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('WrathOperationBundle:Operation:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to create a new Operation entity.
     *
     */
    public function newAction()
    {
        $entity = new Operation();
        $form   = $this->createForm(new OperationType(), $entity);

        return $this->render('WrathOperationBundle:Operation:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Operation entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Operation();
        $form = $this->createForm(new OperationType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $user = $this->container->get('security.context')->getToken()->getUser();
            $entity->setCreator($user);
      
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('operation_show', array('id' => $entity->getId())));
        }

        return $this->render('WrathOperationBundle:Operation:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Operation entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WrathOperationBundle:Operation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Operation entity.');
        }

        $editForm = $this->createForm(new OperationType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('WrathOperationBundle:Operation:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Operation entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WrathOperationBundle:Operation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Operation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new OperationType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('operation_edit', array('id' => $id)));
        }

        return $this->render('WrathOperationBundle:Operation:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Operation entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('WrathOperationBundle:Operation')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Operation entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('operation'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    /**
     * End the current operation.
     *
     */
    public function endAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WrathOperationBundle:Operation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Operation entity.');
        }
        
        if($entity->isEndable()) {
            $entity->end(new \DateTime('now'));
        }
        $em->flush();
        
        return $this->redirect($this->generateUrl('operation_show', array('id' => $id)));
    }
    
    /**
     * Confirm the current operation
     */
    public function confirmAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WrathOperationBundle:Operation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Operation entity.');
        }
        
        if($entity->isConfirmable()) {
            $entity->confirm();
        }
        $em->flush();
        
        return $this->redirect($this->generateUrl('operation_show', array('id' => $id)));
    }
    
    /**
     * Pay the current operation
     */
    public function payAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WrathOperationBundle:Operation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Operation entity.');
        }
        
        if($entity->isPayable()) {
            $entity->pay();
        }
        $em->flush();
        
        return $this->redirect($this->generateUrl('operation_show', array('id' => $id)));
    }
    
    /**
     * Join current user to the operation.
     * 
     */
    public function joinAction($id, Request $request) {
        $form = $this->createFormBuilder()
                ->add('ship_class', 'text')
                ->add('ship_weight', 'text')
                ->getForm();
        
        if($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            $data = $form->getData();

            $em = $this->getDoctrine()->getManager();
        
            $entity = $em->getRepository('WrathOperationBundle:Operation')->find($id);
            $user = $this->container->get('security.context')->getToken()->getUser();
            $participant = new Participant();
            $participant->setUser($user);
            $participant->setOperation($entity);
            $participant->setShipClass($data['ship_class']);
            $participant->setShipWeight($data['ship_weight']);
            
            if($entity->getStartAt() > $participant->getJoinAt()) {
                $participant->setStartAt($entity->getStartAt());
            } else {
                $participant->setStartAt($participant->getJoinAt());
            }
            
            $em->persist($participant);
            $em->flush();
            
            return $this->redirect($this->generateUrl('operation_show', array('id' => $id)));
        }
        
        return $this->render('WrathOperationBundle:Operation:join.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    /**
     * Part current user from the operation.
     * 
     */
    public function leaveAction($id) {
        $em = $this->getDoctrine()->getManager();
        
        $entity = $em->getRepository('WrathOperationBundle:Operation')->find($id);
        $user = $this->container->get('security.context')->getToken()->getUser();
        
        $participant = $em->getRepository('WrathOperationBundle:Participant')->findOneBy(array(
            'operation' => $entity,
            'user' => $user,
            'leave_at' => null,
        ));
        if($participant) {
            $participant->setLeaveAt(new \DateTime('now'));
        }
        $em->flush();
        
        return $this->redirect($this->generateUrl('operation_show', array('id' => $id)));
    }
}
