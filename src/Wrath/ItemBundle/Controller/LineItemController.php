<?php

namespace Wrath\ItemBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Wrath\ItemBundle\Entity\LineItem;
use Wrath\ItemBundle\Form\LineItemType;

/**
 * LineItem controller.
 *
 */
class LineItemController extends Controller
{
    /**
     * Lists all LineItem entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('WrathItemBundle:LineItem')->findAll();

        return $this->render('WrathItemBundle:LineItem:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a LineItem entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WrathItemBundle:LineItem')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find LineItem entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('WrathItemBundle:LineItem:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to create a new LineItem entity.
     *
     */
    public function newAction()
    {
        $entity = new LineItem();
        $form   = $this->createForm(new LineItemType(), $entity);

        return $this->render('WrathItemBundle:LineItem:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new LineItem entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new LineItem();
        $form = $this->createForm(new LineItemType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('lineitem_show', array('id' => $entity->getId())));
        }

        return $this->render('WrathItemBundle:LineItem:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing LineItem entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WrathItemBundle:LineItem')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find LineItem entity.');
        }

        $editForm = $this->createForm(new LineItemType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('WrathItemBundle:LineItem:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing LineItem entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WrathItemBundle:LineItem')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find LineItem entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new LineItemType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('lineitem_edit', array('id' => $id)));
        }

        return $this->render('WrathItemBundle:LineItem:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a LineItem entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('WrathItemBundle:LineItem')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find LineItem entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('lineitem'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
