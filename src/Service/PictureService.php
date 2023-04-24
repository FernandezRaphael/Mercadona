<?php

namespace App\Service;

use App\Entity\Images;
use App\Entity\Produits;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


class PictureService
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function add(
        array $images,
        Produits $produits
    )
    {
        // On boucle sur les images
        foreach($images as $image){
            // On génère un nouveau nom de fichier
            $fichier = md5(uniqid(mt_rand(), true)).'.png';
            
            // On copie le fichier dans le dossier uploads
            $image->move_uploaded_file($fichier,
                $this->params->get('images_directory')
                
            );
            
            // On crée l'image dans la base de données
            $img = new Images();
            $img->setNom($fichier);
            $produits->addImage($img);
        }
    }

}