<?php
// src/Mailing/MailingBundle/Entity/Mail.php

namespace Mailing\MailingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Represents e-mail
 * @ORM\Entity
 * @ORM\Table(name="mail")
*/

class Mail
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
     * Email address
     * @ORM\Column(type="string", length=200)
     */
    protected $address;
    
    public function getAddress() {
        return $this->address;
    }
    
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * First name of person
     * @ORM\Column(type="string", length=200)
     */
    protected $name;
    
    public function getName() {
        return $this->name;
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Second name of person
     * @ORM\Column(type="string", length=200)
     */
    protected $surname;
    
    public function getSurname() {
        return $this->surname;
    }
    
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * True if email is activated and can receive a messages
     * @ORM\Column(type="boolean")
     */
    protected $subscribed;
    
    public function getSubscribed() {
        return $this->subscribed;
    }
    
    public function setSubscribed($subscribed)
    {
        $this->subscribed = $subscribed;
    }

    
    /**
     * Returns all inventories where is mail located
     * @ORM\manyToMany(targetEntity="Inventory", inversedBy="mails")
     * @ORM\joinTable(
     *     name="mail_inventory",
     *     joinColumns={
     *         @ORM\joinColumn(name="mail_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *         @ORM\joinColumn(name="iventory_id", referencedColumnName="id")
     *     }
     * )
     */
    protected $inventories;
    
    public function getInventories()
    {
        return $this->inventories;
    }
    
    public function setInventories($inventories)
    {
        $this->inventories = $inventories;
    }
    
    /**
     * Hash for generate link to unsubscribe
     * @ORM\Column(type="string", length=128)
     */
    protected $hash;
    
    public function getHash() {
        return $this->hash;
    }
    
    public function setHash($hash) {
        $this->hash = $hash;
    }

}