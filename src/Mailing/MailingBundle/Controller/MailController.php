<?php

// src/Mailing/MailingBundle/Controller/MailController.php

namespace Mailing\MailingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mailing\MailingBundle\Entity\Mail;
use Mailing\MailingBundle\Form\AddMail;

class MailController extends Controller {

    /**
     * Shows all emails
     * @return type
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $mails = $em->getRepository('MailingBundle:Mail')->findAll();
        return $this->render('MailingBundle:Mail:index.html.twig', array('mails' => $mails));
    }

    /**
     * Generates form for add another email
     * @return type
     */
    public function addAction() {
        $mail = new Mail();
        //set hash for subscribe and unsubscribe link
        $mail->setHash(hash("sha512", $_SERVER['REMOTE_ADDR'].time()));
        $em = $this->getDoctrine()->getManager();
        $inventories = $em->getRepository('MailingBundle:Inventory')->findAll();
        $choices = array();
        foreach($inventories AS $inventory) {
            $choices[$inventory->getId()] = $inventory->getName();
        }
        $form = $this->createForm(new AddMail($choices), $mail);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($mail);
                $em->flush();
                $this->get('session')->getFlashBag()->add(
                        'notice', 'Your mail was added!'
                );
                return $this->redirect($this->generateUrl('MailingBundle_mail_add'));
            }
        }

        return $this->render('MailingBundle:Mail:add.html.twig', array(
                    'form' => $form->createView()
        ));
    }
    
    /**
     * Generates form for edit mail by given ID
     * @return type
     */
    public function editAction($id) {
        $mail = new Mail();
        $em = $this->getDoctrine()->getManager();
        $mail = $em->getRepository('MailingBundle:Mail')->find($id);
        $form = $this->createForm(new AddMail(), $mail);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($mail);
                $em->flush();
                $this->get('session')->getFlashBag()->add(
                        'notice', 'Your mail was updated!'
                );
               return $this->redirect($this->generateUrl('MailingBundle_mail_edit', array('id'=>$id)));
            }
        }

        return $this->render('MailingBundle:Mail:edit.html.twig', array(
                    'form' => $form->createView(), 'id'=>$id
        ));
    }
    
    /**
     * Set email as active
     * @param type $id
     * @return type
     */
    public function subscribeAction($id) {
        $em = $this->getDoctrine()->getManager();
        $mail = $em->getRepository('MailingBundle:Mail')->find($id);
        $mail->setSubscribed(true);
        $em->persist($mail);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
                'notice', 'E-mail '.$mail->getAddress().' was subscribed.'
        );
        return $this->redirect($this->generateUrl('MailingBundle_mail'));
    }
    
    /**
     * Set email as inactive
     * @param type $hash
     * @return type
     */
    public function unsubscribeAction($hash) {
        $em = $this->getDoctrine()->getManager();
        $mail = $em->getRepository('MailingBundle:Mail')->findOneBy(array('hash'=>$hash));
        $mail->setSubscribed(false);
        $em->persist($mail);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
                'notice', 'E-mail '.$mail->getAddress().' was unsubscribed.'
        );
        return $this->redirect($this->generateUrl('MailingBundle_mail')); 
    }

}