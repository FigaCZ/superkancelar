<?php

// src/Mailing/MailingBundle/Form/AddTemplate.php

namespace Mailing\MailingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AddTemplate extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name');
        $builder->add('type', 'choice', array('choices' => array('text' => 'text', 'html' => 'html')));
        $builder->add('subject');
        $builder->add('content', 'textarea');
    }
    
    public function getName() {
        return 'addTemplate';
    }

}