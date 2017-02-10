<?php

namespace CMS\BlogBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GalleryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', FileType::class, array(
                'attr' => array('class' => 'btn btn-file'),
                'label' => 'Choisir une image'
            ))
            ->add('description', TextareaType::class, array(
                'label' => 'Saisir une description',
                'required' => false,
            ))
            ->add('carousel', EntityType::class,
                [
                    'class' => 'CMSBlogBundle:Carousel',
                    'choice_label' => 'nom'
                ]

            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CMS\BlogBundle\Entity\Gallery'
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'cms_blogbundle_gallery';
    }


}
