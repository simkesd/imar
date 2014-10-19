<?php

// src/Acme/TaskBundle/Form/Type/TaskType.php
//namespace Acme\TaskBundle\Form\Type;
//namespace simkesd\SmartClassroom\SmartClassroomBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAction($this->generateUrl('edit_profile'))
            ->setMethod('POST')->getForm()
            ->add('email')
            ->add('username');
    }

    public function getName()
    {
        return 'profile';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'simkesd\SmartClassroom\SmartClassroomBundle\Entity\User'
        ));
    }
}