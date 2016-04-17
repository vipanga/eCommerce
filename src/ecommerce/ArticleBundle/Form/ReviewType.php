<?php

namespace ecommerce\ArticleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ReviewType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content')
            ->add('note', ChoiceType::class, array(
                'choices' => array(
                    ' Un ' => 1,
                    ' Deux ' => 2,
                    ' Trois ' => 3,
                    ' Quatre ' => 4,
                    ' Cinq ' => 5,
                ),
                // *this line is important*
                'choices_as_values' => true,
                'expanded' => true,
                'multiple' => false,
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ecommerce\ArticleBundle\Entity\Review'
        ));
    }

    public function getName()
    {
        return 'ecommerce_articlebundle_reviewtype';
    }
}
