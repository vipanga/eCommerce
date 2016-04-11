<?php

namespace ecommerce\ArticleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SearchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product')
            ->add('province', ChoiceType::class, array(
                'choices' => array(
                    'Bas-Uele' => 'Bas-Uele',
                    'Équateur' => 'Équateur',
                    'Haut-Katanga' => 'Haut-Katanga',
                    'Haut-Lomami' => 'Haut-Lomami',
                    'Haut-Uele' => 'Haut-Uele',
                    'Ituri' => 'Ituri',
                    'Kasaï' => 'Kasaï',
                    'Kasaï-Central' => 'Kasaï-Central',
                    'Kasaï-Oriental' => 'Kasaï-Oriental',
                    'Kinshasa' => 'Kinshasa',
                    'Kongo-Central' => 'Kongo-Central',
                    'Kwango' => 'Kwango',
                    'Kwilu' => 'Kwilu',
                    'Lomami' => 'Lomami',
                    'Lualaba' => 'Lualaba',
                    'Mai-Ndombe' => 'Mai-Ndombe',
                    'Maniema' => 'Maniema',
                    'Mongala' => 'Mongala',
                    'Nord-Kivu' => 'Nord-Kivu',
                    'Nord-Ubangi' => 'Nord-Ubangi',
                    'Sankuru' => 'Sankuru',
                    'Sud-Kivu' => 'Sud-Kivu',
                    'Sud-Ubangi' => 'Sud-Ubangi',
                    'Tanganyika' => 'Tanganyika',
                    'Tshopo' => 'Tshopo',
                    'Tshuapa' => 'Tshuapa',
                ),
                'placeholder' => 'Choisir la province',
                // *this line is important*
                'choices_as_values' => true,
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ecommerce\ArticleBundle\Entity\Search'
        ));
    }

    public function getName()
    {
        return 'ecommerce_articlebundle_searchtype';
    }
}
