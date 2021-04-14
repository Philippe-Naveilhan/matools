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
            ['title'=>'Livres','img'=>'red1.jpg','color'=>'red','text'=>'1984 d\'Orwell,<br> MAUS de Spiegelman'],
            ['title'=>'Musique','img'=>'green1.jpg','color'=>'green','text'=>'De Brassens à Shakaponk en passant par Mozart, Debussy, Beethoven'],
            ['title'=>'Films','img'=>'yellow1.jpg','color'=>'grey','text'=>'Amadeus, Orange Mécanique, Musée haut - Musée bas'],
            ['title'=>'Couleurs','img'=>'orange1.jpg','color'=>'orange','text'=>'blanc cassé'],
            ['title'=>'Animal','img'=>'red2.jpg','color'=>'red','text'=>'Belette ou loutre. Un animal joueur.'],
            ['title'=>'Langage','img'=>'green2.jpg','color'=>'green','text'=>'PHP Javascript'],
            ['title'=>'Transport','img'=>'yellow2.jpg','color'=>'yellow','text'=>'Mon esprit'],
            ['title'=>'Plante','img'=>'red3.jpg','color'=>'red','text'=>'Chanvre'],
            ['title'=>'Vêtement','img'=>'green3.jpg','color'=>'green','text'=>'Des chaussons ?'],
            ['title'=>'Métier','img'=>'red1.jpg','color'=>'red','text'=>'Développeur aujourd\'hui... demain ?'],
            ['title'=>'Sport','img'=>'orange1.jpg','color'=>'orange','text'=>'Les échecs, rien de plus physique en tous cas...'],
            ['title'=>'Odeur','img'=>'yellow1.jpg','color'=>'grey','text'=>'L\'herbe, la bouse de vache, la campagne...'],
            ['title'=>'Pays','img'=>'red3.jpg','color'=>'red','text'=>'La notion de frontières m\'est assez étrangère...'],
        ];

        return $this->render('CV/index.html.twig', [
            'titles'=> $titles
        ]);
    }
}

