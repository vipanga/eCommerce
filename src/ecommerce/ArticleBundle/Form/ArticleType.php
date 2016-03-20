<?php

namespace ecommerce\ArticleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
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
            ->add('name_item', 'text')
            ->add('price')
            ->add('quantity')
            ->add('quality')
            ->add('description', 'textarea')
            ->add('solde', 'checkbox', array('required' => false))
            ->add('country', 'text')
            ->add('city', 'text')
            ->add('image', new ImageType(), array('required' => false))
            ->add('enregistrer', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ecommerce\ArticleBundle\Entity\Article'
        ));
    }
    
    public function getName() {
        return 'ecommerce_articlebundle_articletype';
    }
}
