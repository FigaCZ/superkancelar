<?php

// src/Mailing/MailingBundle/Controller/TemplateController.php

namespace Mailing\MailingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mailing\MailingBundle\Entity\Log;

class SendController extends Controller {

    /**
     * Send emails with given template and email's inventory
     * @return type
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $inventories = $em->getRepository('MailingBundle:Inventory')->findAll();
        $inventoryChoices = array();
        foreach ($inventories AS $inventory) {
            $inventoryChoices[$inventory->getId()] = $inventory->getName();
        }
        $templates = $em->getRepository('MailingBundle:Template')->findAll();
        $templateChoices = array();
        foreach ($templates AS $template) {
            $templateChoices[$template->getId()] = $template->getName();
        }
        //$defaultData = array('template' => $templateChoices, 'inventory' => $inventoryChoices);
        $form = $this->createFormBuilder($defaultData = NULL)
                ->add('template', 'choice', array('choices' => $templateChoices))
                ->add('inventory', 'choice', array('choices' => $inventoryChoices))
                ->add('send', 'submit')
                ->getForm();
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                // data is an array with "name", "email", and "message" keys
                $data = $form->getData();
                $mailInventory = $em->getRepository('MailingBundle:Inventory')->find($data['inventory']);
                $mailTemplate = $em->getRepository('MailingBundle:Template')->find($data['template']);
                $mails = array();
                foreach ($mailInventory->getMails() as $mail) {
                    if ($mail->getSubscribed() == 1) {
                        $mails[] = $mail->getAddress();
                        // insert record to the log
                        $log = new Log();
                        $log->setMail($mail);
                        $log->setTemplate($mailTemplate);
                        $log->setAction('Sent');
                        $log->setDate(new \DateTime("now"));
                        $em->persist($log);
                        $em->flush();
                    }
                }

                $mg_api = 'key-5c4-elly0fvrwwbxfnjenwap03-i5mf8';
                $mg_version = 'api.mailgun.net/v2/';
                $mg_domain = "filipglazar.com";
                $mg_reply_to_email = "filip.glazar@gmail.com";

                $mg_message_url = "https://" . $mg_version . $mg_domain . "/messages";


                $ch = curl_init();
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

                curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_VERBOSE, 0);
                curl_setopt($ch, CURLOPT_HEADER, 1);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

                curl_setopt($ch, CURLOPT_USERPWD, 'api:' . $mg_api);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_URL, $mg_message_url);
                curl_setopt($ch, CURLOPT_POSTFIELDS, array('from' => 'filip.glazar@gmail.com',
                    'to' => implode(',', $mails),
                    'h:Reply-To' => ' <' . $mg_reply_to_email . '>',
                    'subject' => $mailTemplate->getSubject(),
                    'html' => $mailTemplate->getContent()
                ));
                $result = curl_exec($ch);
                curl_close($ch);
                if ($result !== false) {
                    $this->get('session')->getFlashBag()->add(
                            'notice', 'E-mails was successfully sent...'
                    );
                } else {
                    $this->get('session')->getFlashBag()->add(
                            'notice', 'Service is temporarily unavailable. Please try again later!'
                    );
                }
            }
        }
        return $this->render('MailingBundle:Send:index.html.twig', array('form' => $form->createView()));
    }

}