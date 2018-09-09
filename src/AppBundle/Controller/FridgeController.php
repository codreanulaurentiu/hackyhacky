<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Fridge;
use AppBundle\Entity\FridgeInventory;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Fridge controller.
 *
 * @Route("fridge")
 */
class FridgeController extends Controller
{
    /**
     * Lists all fridge entities.
     *
     * @Route("/", name="fridge_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository(User::class)->findOneBy(['id' => 9]);
        $fridge = $em->getRepository(Fridge::class)->findOneBy(['id' => 1]);

        $fridgeItems = $em->getRepository(FridgeInventory::class)->findBy(['fridgeId' => 1]);
        return $this->render('fridge/index.html.twig', array(
            'fridges' => $fridgeItems,
        ));
    }

    /**
     * Creates a new fridge entity.
     *
     * @Route("/new", name="fridge_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $fridge = new Fridge();
        $form = $this->createForm('AppBundle\Form\FridgeType', $fridge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fridge);
            $em->flush();

            return $this->redirectToRoute('fridge_show', array('id' => $fridge->getId()));
        }

        return $this->render('fridge/new.html.twig', array(
            'fridge' => $fridge,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a fridge entity.
     *
     * @Route("/{id}", name="fridge_show")
     * @Method("GET")
     */
    public function showAction(Fridge $fridge)
    {
        $deleteForm = $this->createDeleteForm($fridge);

        return $this->render('fridge/show.html.twig', array(
            'fridge' => $fridge,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing fridge entity.
     *
     * @Route("/{id}/edit", name="fridge_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Fridge $fridge)
    {
        $deleteForm = $this->createDeleteForm($fridge);
        $editForm = $this->createForm('AppBundle\Form\FridgeType', $fridge);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('fridge_edit', array('id' => $fridge->getId()));
        }

        return $this->render('fridge/edit.html.twig', array(
            'fridge' => $fridge,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a fridge entity.
     *
     * @Route("/{id}", name="fridge_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Fridge $fridge)
    {
        $form = $this->createDeleteForm($fridge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fridge);
            $em->flush();
        }

        return $this->redirectToRoute('fridge_index');
    }

    /**
     * Creates a form to delete a fridge entity.
     *
     * @param Fridge $fridge The fridge entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Fridge $fridge)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fridge_delete', array('id' => $fridge->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
