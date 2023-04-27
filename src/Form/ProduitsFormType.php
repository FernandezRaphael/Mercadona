<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Produits;
use App\Repository\CategorieRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Positive;

class ProduitsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('prix', MoneyType::class, options:[
                'constraints' =>[
                    new Positive(
                        message:'Le prix ne peut être négatif'
                    )
                ]
            ])
            ->add('categorie', EntityType::class,[
                'class' => Categorie::class,
                'choice_label' => 'nom',
                'query_builder'=> function (CategorieRepository $cr)
                {
                    return $cr->createQueryBuilder('c')
                    ->where('c.nom IS NOT NULL')
                    ->orderBy('c.nom', 'ASC')
                    ;
                }
            ])
            ->add('imageFile', FileType::class, [
                'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produits::class,
        ]);
    }
}
