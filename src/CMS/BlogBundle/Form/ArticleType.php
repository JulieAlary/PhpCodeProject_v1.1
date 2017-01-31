<?php

namespace CMS\BlogBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateTimeType::class)
            ->add('title', TextType::class)
            ->add('content', TinymceType::class)
            ->add('image', ImageType::class)
            ->add('categories', EntityType::class,
                [
                    'class' => 'CMSBlogBundle:Category',
                    'choice_label' => 'name',
                    'multiple' => true
                ]
            )
            ->add('save', SubmitType::class);

        // ajout d'un focntion qui va écouter un événement
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                $article = $event->getData();

                if ($article === null) {
                    return;
                }
                // si l'annonce n'est pas publiée ou si elle n'xiste pas encore
                if (!$article->getPublished() || null === $article->getId()) {
                    $event->getForm()->add('published', CheckboxType::class, array('required' => false));
                } else {
                    // sinon on le supprime
                    $event->getForm()->remove('published');
                }
            }
        );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CMS\BlogBundle\Entity\Article'
        ));
    }

}
