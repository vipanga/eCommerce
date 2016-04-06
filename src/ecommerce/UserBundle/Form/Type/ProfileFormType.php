<?php

namespace ecommerce\UserBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileFormType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->remove('current_password');
        $builder->add('first_name', TextType::class, array('required' => false));
        $builder->add('last_name', TextType::class, array('required' => false));
        $builder->add('gender', ChoiceType::class, array('choices' => array('Male' => 'M', 'Female' => 'M'), 'choices_as_values' => true));
        $builder->add('telephone', TextType::class, array('required' => false));
        $builder->add('website', TextType::class, array('required' => false));
        $builder->add('city', TextType::class, array('required' => false));
        $builder->add('province', ChoiceType::class, array(
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
        ));
        $builder->add('birth_date', DateType::class, array('widget' => 'single_text', 'format' => 'd-MM-y', 'required' => false));
        $builder->add('address', 'textarea', array('required' => false));
        //$builder->add('updated', HiddenType::class, array('data' => date('Y-m-d H:i:s')));
    }

    public function getParent() {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }
}