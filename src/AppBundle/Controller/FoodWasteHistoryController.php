<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FoodWasteHistory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Foodwastehistory controller.
 *
 * @Route("foodwastehistory")
 */
class FoodWasteHistoryController extends Controller
{
    /**
     * Lists all foodWasteHistory entities.
     *
     * @Route("/", name="foodwastehistory_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $foodWasteHistories = $em->getRepository('AppBundle:FoodWasteHistory')->findAll();

        return $this->render('foodwastehistory/index.html.twig', array(
            'foodWasteHistories' => $foodWasteHistories,
        ));
    }

    /**
     * Creates a new foodWasteHistory entity.
     *
     * @Route("/new", name="foodwastehistory_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $foodWasteHistory = new Foodwastehistory();
        $form = $this->createForm('AppBundle\Form\FoodWasteHistoryType', $foodWasteHistory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($foodWasteHistory);
            $em->flush();

            return $this->redirectToRoute('foodwastehistory_show', array('id' => $foodWasteHistory->getId()));
        }

        return $this->render('foodwastehistory/new.html.twig', array(
            'foodWasteHistory' => $foodWasteHistory,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a foodWasteHistory entity.
     *
     * @Route("/{id}", name="foodwastehistory_show")
     * @Method("GET")
     */
    public function showAction(FoodWasteHistory $foodWasteHistory)
    {
        $deleteForm = $this->createDeleteForm($foodWasteHistory);

        return $this->render('foodwastehistory/show.html.twig', array(
            'foodWasteHistory' => $foodWasteHistory,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing foodWasteHistory entity.
     *
     * @Route("/{id}/edit", name="foodwastehistory_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FoodWasteHistory $foodWasteHistory)
    {
        $deleteForm = $this->createDeleteForm($foodWasteHistory);
        $editForm = $this->createForm('AppBundle\Form\FoodWasteHistoryType', $foodWasteHistory);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('foodwastehistory_edit', array('id' => $foodWasteHistory->getId()));
        }

        return $this->render('foodwastehistory/edit.html.twig', array(
            'foodWasteHistory' => $foodWasteHistory,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a foodWasteHistory entity.
     *
     * @Route("/{id}", name="foodwastehistory_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FoodWasteHistory $foodWasteHistory)
    {
        $form = $this->createDeleteForm($foodWasteHistory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($foodWasteHistory);
            $em->flush();
        }

        return $this->redirectToRoute('foodwastehistory_index');
    }

    /**
     * Creates a form to delete a foodWasteHistory entity.
     *
     * @param FoodWasteHistory $foodWasteHistory The foodWasteHistory entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FoodWasteHistory $foodWasteHistory)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('foodwastehistory_delete', array('id' => $foodWasteHistory->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
