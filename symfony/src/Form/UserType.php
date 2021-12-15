<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;

class UserType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                "label" => "Entrez le prenom de l'utilisateur",
                "required" => true
            ])
            ->add('lastName', TextType::class, [
                "label" => "Entrez le nom de l'utilisateur",
                "required" => true
            ])
            ->add('email', EmailType::class, [
                "label" => "Entrez l'email de l'utilisateur",
                "required" => true
            ])
            ->add("roles", ChoiceType::class, [
                'required' => true,
                'multiple' => true,
                'choices' => [
                    "Comedian" => 'ROLE_COMEDIAN',
                    "Client" => 'ROLE_CLIENT',
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux password doivent être pareil',
                'options' => ['attr' => ['autocomplete' => 'new-password', 'class' => 'password-field']],
                'required' => true,
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Repeter le mot de passe'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre password doit contenir {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add("imageFile", VichImageType::class, [
                "label" => "Insérer une photo de profil",
                "required" => false,
                'storage_resolve_method' => VichImageType::STORAGE_RESOLVE_PATH_RELATIVE,
                'allow_delete'  => true,
                "delete_label"=>"",
                'download_link' => false, // not mandatory, default is true
            ])
            ->add("street_number", TextType::class, [
                'attr' => [
                    "readonly" => "readonly",
                    "id" => "street_number"
                ]
            ])
            ->add("route", TextType::class, [
                'attr' => [
                    "readonly" => "readonly",
                    "id" => "route"
                ]
            ])
            ->add("locality", TextType::class, [
                'attr' => [
                    "readonly" => "readonly",
                    "id" => "locality"
                ]
            ])
            ->add("country", TextType::class, [
                'attr' => [
                    "readonly" => "readonly",
                    "id" => "country"
                ]
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
