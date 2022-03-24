<?php

namespace App\Controller;

use App\Entity\Rewards;
use App\Entity\Tournoi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatistiquesController extends AbstractController
{
    /**
     * @Route("/statistiques", name="statistiques")
     */
    public function index(): Response
    {
        $Entreprises=$this->getDoctrine()->getRepository(Tournoi::class)->findBy(['typet' => 'eliminatoire']);
        $EntreprisesNbr=sizeof($Entreprises);


        $Etudiants=$this->getDoctrine()->getRepository(Tournoi::class)->findBy(['typet' => 'Club']);
        $EtudiantsNbr=sizeof($Etudiants);




        return $this->render('statistiques/index.html.twig', [
            'controller_name' => 'FrontController',
            'EntreprisesNbr'=>$EntreprisesNbr,'EtudiantsNbr'=>$EtudiantsNbr
        ]);
    }
    /**
     * @Route("/statR", name="statR")
     */
    public function statR(): Response
    {
        $x=$this->getDoctrine()->getRepository(Rewards::class)->findBy(array('rank'=>1));
        $y=$this->getDoctrine()->getRepository(Rewards::class)->findBy(array('rank'=>2));
        //$Entreprise=$this->getDoctrine()->getRepository(Rewards::class)->findBy(['prixR'=>$x]);
        $EntreprisesNbr=sizeof($x);
        $EtudiantsNbr=sizeof($y);





        return $this->render('statistiques/statR.html.twig', [
            'controller_name' => 'FrontController',
            'EntreprisesNbr'=>$EntreprisesNbr,'EtudiantsNbr'=>$EtudiantsNbr
        ]);
    }
}
