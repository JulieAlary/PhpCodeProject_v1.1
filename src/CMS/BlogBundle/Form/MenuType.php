<?php

namespace CMS\BlogBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('categories', EntityType::class,
                [
                    'class' => 'CMSBlogBundle:Category',
                    'choice_label' => 'name',
                    'multiple' => true
                ]
            )
            ->add('published', CheckboxType::class)
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CMS\BlogBundle\Entity\Menu'
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'cms_blogbundle_menu';
    }


}
