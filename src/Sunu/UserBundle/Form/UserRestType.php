<?php

namespace Sunu\UserBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserRestType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom', TextType::class)
        ->add('username', TextType::class)
        //->add('email', TextType::class)
		->add('plainPassword', TextType::class)
		//->add('compte',CompteRegistrationRestType::class) 
        //->add('typedecompte', TextType::class, array('mapped' => false))
       // ->add('lastname', TextType::class)
       ->add('libellesecret', TextType::class)
       ->add('secret', TextType::class)
		
		
		;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sunu\UserBundle\Entity\User',
            'csrf_protection' => false,
			'allow_extra_fields' => true
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sunu_userbundle_user';
    }


}