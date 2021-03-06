<?php

namespace CMS\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomType extends AbstractType
{
    /**
     * Only for the title
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('description', TextareaType::class)
            ->add(
                'theme',
                ChoiceType::class,
                array(
                    'attr'    => ['class' => 'select2'],
                    'choices' => array(
                        'Gris'  => 'color_grey',
                        'Jaune' => 'color_yellow',
                        'Rouge' => 'color_red',
                        'Vert'  => 'color_green',
                    ),
                )
            )
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CMS\BlogBundle\Entity\Custom'
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'cms_blogbundle_custom';
    }


}
