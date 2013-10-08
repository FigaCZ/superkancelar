<?php
// src/Mailing/MailingBundle/Entity/Log.php

namespace Mailing\MailingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Represents records of action in mail newsletter
 * @ORM\Entity
 * @ORM\Table(name="log")
*/

class Log
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    

    /**
     * TYpe of action wchich was performed
     * @ORM\Column(type="string", length=20)
     */
    protected $action;
    
    public function getAction() {
        return $this->action;
    }
    
    public function setAction($action) {
        $this->action = $action;
    }
    
    /**
     * DAte and time of action execution
     * @ORM\Column(type="datetime")
     */
    protected $date;
    
    public function getDate() {
        return $this->date;
    }
    
    public function setDate($date) {
        $this->date = $date;
    }
    
    /**
     * E-mail which accords to record
     * @ORM\OneToOne(targetEntity="Mail")
     * @ORM\JoinColumn(name="mail_id", referencedColumnName="id")
     */
    protected $mail;
    
    public function getMail() {
        return $this->mail;
    }
    
    public function setMail($mail) {
        $this->mail = $mail;
    }
    
    /**
     * Column for save a template for "Sent" action
     * @ORM\OneToOne(targetEntity="Template")
     * @ORM\JoinColumn(name="template_id", referencedColumnName="id")
     */
    protected $template;
    
    public function getTemplate() {
        return $this->template;
    }
    
    public function setTemplate($template) {
        $this->template = $template;
    }
    
}