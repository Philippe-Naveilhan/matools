<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/portrait", name="portrait")
     */
    public function portrait(): Response
    {
        $titles = [
            ['title'=>'Livres','color'=>'red','text'=>'1984, Orwell ou MAUS de ???'],
            ['title'=>'Musique','color'=>'blue','text'=>'Jazz, Blue, Folk, Chansonniers, etc...'],
            ['title'=>'Films','color'=>'grey','text'=>'Amadeus, Orange Mécanique, Musée haut - Musée bas'],
            ['title'=>'Couleurs','color'=>'green','text'=>'blanc cassé'],
            ['title'=>'Animal','color'=>'yellow','text'=>'Belette ou loutre. Un animal joueur.'],
            ['title'=>'Langage','color'=>'red','text'=>'PHP Javascript'],
            ['title'=>'Transport','color'=>'blue','text'=>'Mon esprit'],
            ['title'=>'Plante','color'=>'purple','text'=>'Chanvre'],
            ['title'=>'Vêtement','color'=>'whitesmoke','text'=>'Des chaussons ?'],
            ['title'=>'Métier','color'=>'darkblue','text'=>'Développeur aujourd\'hui... demain ?'],
            ['title'=>'Sport','color'=>'red','text'=>'Les échecs, rien de plus physique en tous cas...'],
            ['title'=>'Odeur','color'=>'yellow','text'=>'L\'herbe, la bouse de vache, la campagne...'],
            ['title'=>'Pays','color'=>'green','text'=>'La notion de frontières m\'est assez étrangère...'],
        ];
        $bg = [];
        if ($dossier = opendir('build/otero')) {
            while(false !== ($fichier = readdir($dossier))){
                if($fichier != '.' && $fichier != '..') {
                    $bg[]=$fichier;
                }
            }
        };
        return $this->render('CV/index.html.twig', [
            'titles'=> $titles,
            'bg'=>$bg,
        ]);
    }
}

