<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Stade;
use App\Entity\Joueur;
use App\Entity\Tournoi;
use App\Form\GameType;
use App\Form\TournoiType;
use App\Form\StadeType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;



class GameController extends AbstractController
{
    /**
     * @Route("/game", name="game")
     */
    public function index(): Response
    {
        return $this->render('game/index.html.twig', [
            'controller_name' => 'GameController',
        ]);
    }

    /**
     * @Route("/detailG{id}", name="detailG")
     */
    public function detailG($id): Response
    {
        //recuperer le repository pour utiliser la fonction findAll()
        $r=$this->getDoctrine()->getRepository(Game::class);
        $games=$r->findAll();
        $r=$this->getDoctrine()->getRepository(Game::class);
        $arbitres=$r->find($id);
        $result = $this->getDoctrine()->getRepository(tournoi::class);
        $tournois = $result->findall();
        $r=$this->getDoctrine()->getRepository(Joueur::class);
        $joueurs=$r->findAll();
        return $this->render('game/detailG.html.twig', [
            'e' => $arbitres,
            'g' =>$games,
            'c' =>$tournois,
            'jrr' =>$arbitres->getClub1()->getJoueurs(),
            'jr' =>$arbitres->getClub2()->getJoueurs(),
        ]);
    }

    ///methode Ajout
    /**
     * @Route("/ajoutG", name="ajoutG")
     */

    public function ajoutG(Request $request,FlashyNotifier $flashy): Response
    {
        //creation une formulaire
        $g=new Game();
        $form=$this->createForm(GameType::class,$g);

        //recuperer les donnees depuis la requette http
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid())
        {

            $em=$this->getDoctrine()->getManager();
            $em->persist($g);
            $em->flush();
            $flashy->success('Match ajouté avec succés', 'http://your-awesome-link.com');
            return $this->redirect('afficheG');
        }
        return $this->render('game/ajoutG.html.twig',['g' => $form->createView()]);

    }

    ///methode affichage
    /**
     * @Route("/afficheG", name="afficheG")
     */
    public function afficheG(): Response
    {
        //recuperer le repository pour utiliser la fonction findAll()
        $r=$this->getDoctrine()->getRepository(Game::class);
        $games=$r->findAll();
        return $this->render('game/afficheG.html.twig', [
            'e' => $games,
        ]);
    }
    ///methode affichage
    /**
     * @Route("/afficheGF", name="afficheGF")
     */
    public function afficheGF(): Response
    {
        //recuperer le repository pour utiliser la fonction findAll()
        $r=$this->getDoctrine()->getRepository(Game::class);
        $games=$r->findAll();
        $result = $this->getDoctrine()->getRepository(tournoi::class);
        $tournois = $result->findall();
        $result = $this->getDoctrine()->getRepository(tournoi::class);
        $tournois = $result->findall();
        return $this->render('game/afficheGF.html.twig', [
            'e' => $games,
            'c' =>$tournois,

        ]);
    }

    ///methode affichage
    /**
     * @Route("/afficheGFD{id}", name="afficheGFD")
     */
    public function afficheGFD($id): Response
    {
        //recuperer le repository pour utiliser la fonction findAll()
        $r=$this->getDoctrine()->getRepository(Tournoi::class);
        $arbitres=$r->find($id);
        $r=$this->getDoctrine()->getRepository(Game::class);
        $games=$r->findAll();
        $result = $this->getDoctrine()->getRepository(tournoi::class);
        $tournois = $result->findall();
        return $this->render('game/afficheGFD.html.twig', [
            'e' => $games,
            'art'=>$arbitres->getGame(),
            'c' =>$tournois,
            
        ]);
    } 

    ///methode supprimer
    /**
     * @Route("/SuppG/{id}", name="SuppG")
     */
    public function SuppG($id,FlashyNotifier $flashy): Response
    {
        //recuperer le Classroom a supprimer find($id)
        $s=$this->getDoctrine()->getRepository(Game::class);
        $games=$s->find($id);

        //on passe a la supprision
        $em=$this->getDoctrine()->getManager();
        $em->remove($games);
        $em->flush();
        $flashy->error('Match supprimé !!', 'http://your-awesome-link.com');
        return $this->redirectToroute('afficheG');
        //    return $this->render('classroom/afficheC.html.twig', [
        //    'c' => $classrooms,
        //    ]);
    }

    ///methode modifier
    /**
     * @Route("/modifG{id}", name="modifG")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function modifG(Request $request,$id,FlashyNotifier $flashy): Response
    {
        //recuperer le Classroom a supprimer find($id)
        // $c=new Classroom();
        $s=$this->getDoctrine()->getRepository(Game::class);
        $games=$s->find($id);

        $form=$this->createForm(GameType::class,$games);
        $checkout=$form->handleRequest($request);
        if($checkout->isSubmitted()&&$checkout->isValid())
        {

            $em=$this->getDoctrine()->getManager();
            $em->flush();
            $flashy->info('Match modifié!', 'http://your-awesome-link.com');
            return $this->redirectToRoute('afficheG');
        }

        return $this->render('game/ajoutG.html.twig',['g' => $form->createView()]);
    }


        /**
     * @Route("/testG", name="testG")
     */
    public function testG(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Game::class);
        $tournois = $repo->findAll();
        return $this->render('game/recent_listG.html.twig', [
            't' => $tournois,
        ]);
    }
}
