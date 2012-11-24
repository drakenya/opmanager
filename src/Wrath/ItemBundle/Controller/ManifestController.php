<?php

namespace Wrath\ItemBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Wrath\ItemBundle\Entity\Manifest;
use Wrath\ItemBundle\Entity\LineItem;
use Wrath\ItemBundle\Form\ManifestType;

/**
 * Manifest controller.
 *
 */
class ManifestController extends Controller
{
    /**
     * Lists all Manifest entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('WrathItemBundle:Manifest')->findAll();

        return $this->render('WrathItemBundle:Manifest:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a Manifest entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WrathItemBundle:Manifest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Manifest entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('WrathItemBundle:Manifest:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to create a new Manifest entity.
     *
     */
    public function newAction()
    {
        $entity = new Manifest();

        $form   = $this->createForm(new ManifestType(), $entity);

        return $this->render('WrathItemBundle:Manifest:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Manifest entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Manifest();
        $form = $this->createForm(new ManifestType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            foreach($entity->getLineItems() as $line_item) {
                $line_item->setCurrentValue( $line_item->getItem()->getPrice() );
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('manifest_show', array('id' => $entity->getId())));
        }

        return $this->render('WrathItemBundle:Manifest:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Manifest entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WrathItemBundle:Manifest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Manifest entity.');
        }

        $editForm = $this->createForm(new ManifestType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('WrathItemBundle:Manifest:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Manifest entity.
     *
     */
    public function updateAction(Request $request, $id)
    {        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WrathItemBundle:Manifest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Manifest entity.');
        }
        
        foreach($entity->getLineItems() as $line_item) {
            $original_line_items[] = $line_item;
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ManifestType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            
            // filter $original... to contain line_items no longer present
            foreach($entity->getLineItems() as $line_item) {
                foreach($original_line_items as $key => $to_delete) {
                    if($to_delete->getId() === $line_item->getId()) {
                        unset($original_line_items[$key]);
                    }
                }
            }
            
            // remote the relationships and the entities
            foreach($original_line_items as $line_item) {
                $line_item->setManifest(null);
                
                $em->remove($line_item);
            }
            
            foreach($entity->getLineItems() as $line_item) {
                $line_item->setCurrentValue( $line_item->getItem()->getPrice() );
            }
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('manifest_edit', array('id' => $id)));
        }

        return $this->render('WrathItemBundle:Manifest:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Manifest entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('WrathItemBundle:Manifest')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Manifest entity.');
            }
            
            foreach($entity->getLineItems() as $line_item) {
                $em->remove($line_item);
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('manifest'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
