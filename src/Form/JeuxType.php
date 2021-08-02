<?php

namespace App\Form;

use App\Entity\Jeux;
use App\Repository\GenresRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JeuxType extends AbstractType
{   

    private $genreRepository;

    public function __construct(GenresRepository $genresRepository)
    {
        $this->genreRepository = $genresRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        $tabGenre = $this->genreRepository->findAll();
        $tabChoices = [];
        foreach($tabGenre as $genre){
            $tabChoices [] = [$genre->getId() => $genre->getLibelle()];
        }
        $builder
            ->add('titre')
            ->add('description')
            ->add('video_path')
            ->add('couverture_path')
            ->add('date_sortie')
            // ->add('genre', ChoiceType::class, [
            //     'choices' => $tabChoices
            // ])
            // ->add('developpeur')
            // ->add('classification')
            // ->add('plate_forme')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Jeux::class,
        ]);
    }
}
