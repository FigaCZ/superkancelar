<?php

// src/Mailing/MailingBundle/Entity/Iventory.php

namespace Mailing\MailingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This entity represent a list of email
 * @ORM\Entity
 * @ORM\Table(name="inventory")
 */
class Inventory {

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
     * NAme of the inventory
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
     * Return all email in list
     * @ORM\manyToMany(targetEntity="Mail", mappedBy="inventories")
     */
    protected $mails;

    public function getMails() {
        return $this->mails;
    }

    /**
     * Returns object as string
     * @return type
     */
    public function __toString() {
        return $this->name;
    }

}