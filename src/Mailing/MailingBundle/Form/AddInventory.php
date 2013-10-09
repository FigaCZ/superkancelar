<?php

// src/Mailing/MailingBundle/Form/AddInventory.php

namespace Mailing\MailingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AddInventory extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name');
    }
    
    public function getName() {
        return 'addInventory';
    }

}
