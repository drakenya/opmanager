<?php

namespace Wrath\ContentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Wrath\ContentBundle\Entity\News;
use Wrath\ContentBundle\Form\NewsType;

/**
 * News controller.
 *
 */
class NewsController extends Controller
{
    /**
     * Lists all News entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('WrathContentBundle:News')->findAll();

        return $this->render('WrathContentBundle:News:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    
    /**
     * Lists the current news actions (for frontpage display)
     * 
     */
    public function latestAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('WrathContentBundle:News')->findLatestOrderedByDateDesc();

        return $this->render('WrathContentBundle:News:latest.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a News entity.
     *
     */
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WrathContentBundle:News')->findOneBySlug($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find News entity.');
        }

        $deleteForm = $this->createDeleteForm($slug);

        return $this->render('WrathContentBundle:News:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to create a new News entity.
     *
     */
    public function newAction()
    {
        $entity = new News();
        $form   = $this->createForm(new NewsType(), $entity);

        return $this->render('WrathContentBundle:News:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new News entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new News();
        $form = $this->createForm(new NewsType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $user = $this->container->get('security.context')->getToken()->getUser();
            $entity->setUser($user);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('news_show', array('id' => $entity->getId())));
        }

        return $this->render('WrathContentBundle:News:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing News entity.
     *
     */
    public function editAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WrathContentBundle:News')->findOneBySlug($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find News entity.');
        }

        $editForm = $this->createForm(new NewsType(), $entity);
        $deleteForm = $this->createDeleteForm($slug);

        return $this->render('WrathContentBundle:News:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing News entity.
     *
     */
    public function updateAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('WrathContentBundle:News')->findOneBySlug($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find News entity.');
        }

        $deleteForm = $this->createDeleteForm($slug);
        $editForm = $this->createForm(new NewsType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('news_edit', array('slug' => $slug)));
        }

        return $this->render('WrathContentBundle:News:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a News entity.
     *
     */
    public function deleteAction(Request $request, $slug)
    {
        $form = $this->createDeleteForm($slug);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('WrathContentBundle:News')->findOneBySlug($slug);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find News entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('news'));
    }

    private function createDeleteForm($slug)
    {
        return $this->createFormBuilder(array('slug' => $slug))
            ->add('slug', 'hidden')
            ->getForm()
        ;
    }
}
