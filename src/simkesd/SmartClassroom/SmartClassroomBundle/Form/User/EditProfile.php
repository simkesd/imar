<?php

// src/Acme/TaskBundle/Form/Type/TaskType.php
namespace Acme\TaskBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EditProfile extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAction($this->generateUrl('edit_profile'))
            ->setMethod('POST')->getForm();

    }

    public function getName()
    {
        return 'profile';
    }
}