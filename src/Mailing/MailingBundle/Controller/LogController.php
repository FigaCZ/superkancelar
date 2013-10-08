<?php
// src/Mailing/MailingBundle/Controller/LogController.php

namespace Mailing\MailingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LogController extends Controller
{
    /**
     * Shows all records in log
     * @return type
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $records = $em->getRepository('MailingBundle:Log')->findAll();        
        return $this->render('MailingBundle:Log:index.html.twig', array('logs' =>$records));
    }
}