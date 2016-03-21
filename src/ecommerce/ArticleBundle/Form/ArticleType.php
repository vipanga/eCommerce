<?php

namespace ecommerce\ArticleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ArticleType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name_item', 'text')
                ->add('price')
                ->add('quantity')
                ->add('quality', ChoiceType::class, array(
                    'choices' => array(
                        'Neuf' => 'Neuf',
                        'Occasion' => 'Occasion',
                        'Reconditionné(e)' => 'Reconditionné(e)',
                        'Autre' => 'Autre',
                    ),
                    // *this line is important*
                    'choices_as_values' => true,
                ))
                ->add('description', 'textarea')
                //->add('solde', 'checkbox', array('required' => false))
                ->add('city', 'text')
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
                    // *this line is important*
                    'choices_as_values' => true,
                ))
                ->add('country', ChoiceType::class, array(
                    'choices' => array(
                        'République démocratique du Congo' => 'D.R. Congo',
                        'Zambia' => 'Zambia',
                    ),
                    // *this line is important*
                    'choices_as_values' => true,
                ))
                ->add('image', new ImageType(), array('required' => false))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'ecommerce\ArticleBundle\Entity\Article'
        ));
    }

    public function getName() {
        return 'ecommerce_articlebundle_articletype';
    }

}
