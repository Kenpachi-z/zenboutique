<?php

namespace App\Form;

use App\Entity\Adress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
class AdressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label' => 'Quel nom souhaitez-vous donner a votre adresse ?',
                'attr' => [
                    'placeholder' => 'Nommez votre adresse'
                ]
            ])
            ->add('firstname', TextType::class,[
                'label' => 'Votre prénom',
                'attr' => [
                    'placeholder' => 'Entrez votre prénom'
                ]
            ])
            ->add('Lastname', TextType::class,[
                'label' => 'Votre nom',
                'attr' => [
                    'placeholder' => 'Entrez votre nom'
                ]
            ])
            ->add('compagny', TextType::class,[
                'label' => 'Votre socièté',
                'required'=> false,
                'attr' => [
                    'placeholder' => '(facultatif) Entre le nom de votre socièté'
                ]
            ])
            ->add('adress', TextType::class,[
                'label' => 'Votre adresse',
                'attr' => [
                    'placeholder' => 'Indiquez votre adresse'
                ]
            ])
            ->add('postal', TextType::class,[
                'label' => 'Votre code postal ',
                'attr' => [
                    'placeholder' => 'Indiquez votre code postal'
                ]
            ])
            ->add('city', TextType::class,[
                'label' => 'Votre Ville',
                'attr' => [
                    'placeholder' => 'Indiquez votre ville'
                ]
            ])
            ->add('country', CountryType::class,[
                'label' => 'Pays',
                'attr' => [
                    'placeholder' => 'Indiquez votre Pays de residence'
                ]
            ])
            ->add('phone', Teltype::class,[
                'label' => 'Votre téléphone',
                'attr' => [
                    'placeholder' => 'Indiquez le pays'
                ]
            ])
            ->add('submit', SubmitType::class,[
                'label'=>'valider',
                'attr'=>[
                    ' class'=>'btn col-12 btn-primary
                    '
                ]  
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adress::class,
            
        ]);
    }
}
