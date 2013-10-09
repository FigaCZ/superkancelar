<?php

// src/Mailing/MailingBundle/Controller/InventoryController.php

namespace Mailing\MailingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mailing\MailingBundle\Entity\Inventory;
use Mailing\MailingBundle\Form\AddInventory;

class InventoryController extends Controller {

    /**
     * AHows all inventories
     * @return type
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $inventories = $em->getRepository('MailingBundle:Inventory')->findAll();
        return $this->render('MailingBundle:Inventory:index.html.twig', array('inventories' => $inventories));
    }

    /**
     * Show form to add a inventory
     * @return type
     */
    public function addAction() {
        $inventory = new Inventory();
        $form = $this->createForm(new AddInventory(), $inventory);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($inventory);
                $em->flush();
                $this->get('session')->getFlashBag()->add(
                        'notice', 'Your inventory was added!'
                );
                return $this->redirect($this->generateUrl('MailingBundle_inventory_add'));
            }
        }

        return $this->render('MailingBundle:Inventory:add.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    /**
     * Deletes inventory in DB
     * @param type $id
     * @return type
     */
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $inventory = $em->getRepository('MailingBundle:Inventory')->find($id);
        $em->remove($inventory);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
                'notice', 'Inventory was deleted!'
        );
        return $this->redirect($this->generateUrl('MailingBundle_inventory'));
    }

    /**
     * Generate form for edit existing inventory in DB
     * @param type $id
     * @return type
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();
        $inventory = $em->getRepository('MailingBundle:Inventory')->find($id);
        $form = $this->createForm(new AddInventory(), $inventory);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($inventory);
                $em->flush();
                $this->get('session')->getFlashBag()->add(
                        'notice', 'Your inventory was updated!'
                );
                return $this->redirect($this->generateUrl('MailingBundle_inventory_edit', array('id' => $id)));
            }
        }

        return $this->render('MailingBundle:Inventory:edit.html.twig', array(
                    'form' => $form->createView(), 'id' => $id
        ));
    }

}