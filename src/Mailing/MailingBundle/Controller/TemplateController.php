<?php

// src/Mailing/MailingBundle/Controller/TemplateController.php

namespace Mailing\MailingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mailing\MailingBundle\Entity\Template;
use Mailing\MailingBundle\Form\AddTemplate;

class TemplateController extends Controller {

    /**
     * Shows all templates
     * @return type
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $templates = $em->getRepository('MailingBundle:Template')->findAll();
        return $this->render('MailingBundle:Template:index.html.twig', array('templates' => $templates));
    }
    
    /**
     * Show form for add another template
     * @return type
     */
    public function addAction() {
        $template = new Template();
        $form = $this->createForm(new AddTemplate(), $template);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($template);
                $em->flush();
                $this->get('session')->getFlashBag()->add(
                        'notice', 'Your template was added!'
                );
                return $this->redirect($this->generateUrl('MailingBundle_template_add'));
            }
        }

        return $this->render('MailingBundle:Template:add.html.twig', array(
                    'form' => $form->createView()
        ));
    }
    
    /**
     * Delete tempalte by given ID
     * @param type $id
     * @return type
     */
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $inventory = $em->getRepository('MailingBundle:Template')->find($id);
        $em->remove($inventory);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
                'notice', 'Template was deleted!'
        );
        return $this->redirect($this->generateUrl('MailingBundle_template'));
    }
    
    /**
     * Show form for edit template
     * @param type $id
     * @return type
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();
        $template = $em->getRepository('MailingBundle:Template')->find($id);
        $form = $this->createForm(new AddTemplate(), $template);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($template);
                $em->flush();
                $this->get('session')->getFlashBag()->add(
                        'notice', 'Your template was updated!'
                );
                return $this->redirect($this->generateUrl('MailingBundle_template_edit', array('id'=>$id)));
            }
        }

        return $this->render('MailingBundle:Template:edit.html.twig', array(
                    'form' => $form->createView(), 'id'=>$id
        ));
    }

}