<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FridgeInventory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Fridgeinventory controller.
 *
 * @Route("fridgeinventory")
 */
class FridgeInventoryController extends Controller
{
    /**
     * Lists all fridgeInventory entities.
     *
     * @Route("/", name="fridgeinventory_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fridgeInventories = $em->getRepository('AppBundle:FridgeInventory')->findAll();

        return $this->render('fridgeinventory/index.html.twig', array(
            'fridgeInventories' => $fridgeInventories,
        ));
    }

    /**
     * Creates a new fridgeInventory entity.
     *
     * @Route("/new", name="fridgeinventory_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $fridgeInventory = new Fridgeinventory();
        $form = $this->createForm('AppBundle\Form\FridgeInventoryType', $fridgeInventory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fridgeInventory);
            $em->flush();

            return $this->redirectToRoute('fridgeinventory_show', array('id' => $fridgeInventory->getId()));
        }

        return $this->render('fridgeinventory/new.html.twig', array(
            'fridgeInventory' => $fridgeInventory,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a fridgeInventory entity.
     *
     * @Route("/{id}", name="fridgeinventory_show")
     * @Method("GET")
     */
    public function showAction(FridgeInventory $fridgeInventory)
    {
        $deleteForm = $this->createDeleteForm($fridgeInventory);

        return $this->render('fridgeinventory/show.html.twig', array(
            'fridgeInventory' => $fridgeInventory,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing fridgeInventory entity.
     *
     * @Route("/{id}/edit", name="fridgeinventory_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FridgeInventory $fridgeInventory)
    {
        $deleteForm = $this->createDeleteForm($fridgeInventory);
        $editForm = $this->createForm('AppBundle\Form\FridgeInventoryType', $fridgeInventory);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('fridgeinventory_edit', array('id' => $fridgeInventory->getId()));
        }

        return $this->render('fridgeinventory/edit.html.twig', array(
            'fridgeInventory' => $fridgeInventory,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a fridgeInventory entity.
     *
     * @Route("/{id}", name="fridgeinventory_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FridgeInventory $fridgeInventory)
    {
        $form = $this->createDeleteForm($fridgeInventory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fridgeInventory);
            $em->flush();
        }

        return $this->redirectToRoute('fridgeinventory_index');
    }

    /**
     * Creates a form to delete a fridgeInventory entity.
     *
     * @param FridgeInventory $fridgeInventory The fridgeInventory entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FridgeInventory $fridgeInventory)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fridgeinventory_delete', array('id' => $fridgeInventory->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
