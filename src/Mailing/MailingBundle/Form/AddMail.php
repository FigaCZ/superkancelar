<?php

// src/Mailing/MailingBundle/Form/AddMail.php

namespace Mailing\MailingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Mailing\MailingBundle\Entity\Inventory;

class AddMail extends AbstractType {

    /**
     * Pole všech seznamů emailů
     * @var type 
     */
    private $inventories;

    public function __construct($inventories = NULL) {
        $this->inventories = $inventories;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('address', 'email');
        $builder->add('name');
        $builder->add('surname');
        /**$builder->add('inventories', 'choice', array(
            'choices' => $this->inventories,
            'multiple' => true, 
        ));*/
        $builder->add('inventories', null, array('expanded' => "true", "multiple" => "true"));
    }

    public function getName() {
        return 'addMail';
    }

}