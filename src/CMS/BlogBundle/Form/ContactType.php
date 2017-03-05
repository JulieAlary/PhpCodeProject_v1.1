<?php

namespace CMS\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('faFacebook')
            ->add('faTwitter')
            ->add('faMail')
            ->add('faLinkedin')
            ->add('faFlickr')
            ->add('faGooglePlus')
            ->add('faInstagram')
            ->add('faReddit')
            ->add('faPinterest')
            ->add('faSnapchat')
            ->add('faSoundcloud')
            ->add('faYoutube')
            ->add('Save', SubmitType::class,
                [
                    'label' => 'Mettre en ligne',
                    'attr' => ['class' => 'btn btn-primary btn-sm']
                ]
            );

        // ajout d'un focntion qui va écouter un événement
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                $contact = $event->getData();

                if ($contact === null) {
                    return;
                }
                // si l'annonce n'est pas publiée ou si elle n'xiste pas encore
                if (!$contact->getPublished() || null === $contact->getId()) {
                    $event->getForm()->add('published', CheckboxType::class, array('required' => false, 'label' => 'Cochez pour publier'));
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
            'data_class' => 'CMS\BlogBundle\Entity\Contact'
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'cms_blogbundle_contact';
    }


}
