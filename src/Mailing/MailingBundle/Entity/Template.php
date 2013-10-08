<?php
// src/Mailing/MailingBundle/Entity/Template.php

namespace Mailing\MailingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Represents pattern for email content
 * @ORM\Entity
 * @ORM\Table(name="template")
*/

class Template
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function getId() {
        return $this->id;
    }
    
    /**
     * Name of the tempalte
     * @ORM\Column(type="string", length=100)
     */
    protected $name;
    
    public function getName() {
        return $this->name;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    /**
     * TYpe of content plain text or html
     * @ORM\Column(type="string", length=20)
     */
    protected $type;
    
    public function getType() {
        return $this->type;
    }
    
    public function setType($type) {
        $this->type = $type;
    }
    
    /**
     * Subject of email
     * @ORM\Column(type="string", length=200)
     */
    protected $subject;
    
    public function getSubject() {
        return $this->subject;
    }
    
    public function setSubject($subject) {
        $this->subject = $subject;
    }
    
    /**
     * Content of template
     * @ORM\Column(type="text")
     */
    protected $content;
    
    public function getContent() {
        return $this->content;
    }
    
    public function setContent($content) {
        $this->content = $content;
    }
    
}