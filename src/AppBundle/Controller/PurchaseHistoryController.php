<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PurchaseHistory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Purchasehistory controller.
 *
 * @Route("purchasehistory")
 */
class PurchaseHistoryController extends Controller
{
    /**
     * Lists all purchaseHistory entities.
     *
     * @Route("/", name="purchasehistory_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $purchaseHistories = $em->getRepository('AppBundle:PurchaseHistory')->findAll();

        return $this->render('purchasehistory/index.html.twig', array(
            'purchaseHistories' => $purchaseHistories,
        ));
    }

    /**
     * Creates a new purchaseHistory entity.
     *
     * @Route("/new", name="purchasehistory_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $purchaseHistory = new Purchasehistory();
        $form = $this->createForm('AppBundle\Form\PurchaseHistoryType', $purchaseHistory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($purchaseHistory);
            $em->flush();

            return $this->redirectToRoute('purchasehistory_show', array('id' => $purchaseHistory->getId()));
        }

        return $this->render('purchasehistory/new.html.twig', array(
            'purchaseHistory' => $purchaseHistory,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a purchaseHistory entity.
     *
     * @Route("/{id}", name="purchasehistory_show")
     * @Method("GET")
     */
    public function showAction(PurchaseHistory $purchaseHistory)
    {
        $deleteForm = $this->createDeleteForm($purchaseHistory);

        return $this->render('purchasehistory/show.html.twig', array(
            'purchaseHistory' => $purchaseHistory,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing purchaseHistory entity.
     *
     * @Route("/{id}/edit", name="purchasehistory_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, PurchaseHistory $purchaseHistory)
    {
        $deleteForm = $this->createDeleteForm($purchaseHistory);
        $editForm = $this->createForm('AppBundle\Form\PurchaseHistoryType', $purchaseHistory);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('purchasehistory_edit', array('id' => $purchaseHistory->getId()));
        }

        return $this->render('purchasehistory/edit.html.twig', array(
            'purchaseHistory' => $purchaseHistory,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a purchaseHistory entity.
     *
     * @Route("/{id}", name="purchasehistory_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, PurchaseHistory $purchaseHistory)
    {
        $form = $this->createDeleteForm($purchaseHistory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($purchaseHistory);
            $em->flush();
        }

        return $this->redirectToRoute('purchasehistory_index');
    }

    /**
     * Creates a form to delete a purchaseHistory entity.
     *
     * @param PurchaseHistory $purchaseHistory The purchaseHistory entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PurchaseHistory $purchaseHistory)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('purchasehistory_delete', array('id' => $purchaseHistory->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
