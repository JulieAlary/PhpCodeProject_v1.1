<?php

namespace CMS\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UserRoleEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('roles', ChoiceType::class, array(
                    'choices' => array('ROLE_USER' => 'ROLE_USER', 'ROLE_ADMIN' => 'ROLE_ADMIN', 'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN'),
                    'choice_label' => function ($value) {
                        if ($value === 'ROLE_USER') {
                            return 'User';
                        } elseif ($value === "ROLE_ADMIN") {
                            return 'Admin';
                        } else {
                            return 'Super Admin';
                        }
                    },
                    'multiple' => true
                )
            )
            ->add('save', SubmitType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CMS\UserBundle\Entity\User'
        ));
    }

}

/* Liste a choix mais moins bien */
/* ->add('roles', CollectionType::class, array(
                    'entry_type' => ChoiceType::class,
                    'entry_options' => array(
                        'label' => false,
                        'choices' => array(
                            'ROLE_ADMIN' => 'Admin',
                            'ROLE_USER' => 'User',

                        ),
                    ),
                )

            )*/