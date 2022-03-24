<?php

namespace App\Controller;
use App\Entity\Club;
use App\Entity\Game;
use App\Entity\Joueur;
use App\Entity\User;
use App\Form\JoueurType;
use App\Repository\JoueurRepository;
use App\Entity\Tournoi;
use App\Form\TournoiType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Polyfill\Intl\Normalizer\Normalizer;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\BarChart;

use Doctrine\ORM\EntityManagerInterface;
use CMEN\GoogleChartsBundle\GoogleCharts\Options\VAxis;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Histogram;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\LineChart;
use CMEN\GoogleChartsBundle\Twig\GoogleChartsExtension;



class JoueurController extends AbstractController
{
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    private $requestStack;
    /**
     * @Route("/searcj/{searchString}", name="searcj")
     */
    public function searcj($searchString,SerializerInterface $serializerInterface)
    {
        //$serializer=new Serializer([new ObjectNormalizer()]);
        // $serializer = new Serializer([new ObjectNormalizer()]);
        $repository = $this->getDoctrine()->getRepository(Joueur::class);
        // $students = $repository->findByid($searchString);
        //$students = $repository->findBy(array('id' => '%'.'2'));

        $students = $repository->findByExampleFieldj($searchString);
        $data = $serializerInterface->normalize($students,'json',['groups'=>'student']);
        // $data=$serializer->normalize("");

        return new JsonResponse($data);
    }
    /**
     * @Route("/stajo", name="stajo")
     */
    public function stajo(JoueurRepository $JoueurRepository){



        $nbs = $JoueurRepository->countEtat();
        $data = [['g', 'joueur']];
        foreach( (array)$nbs as $nb)
        {
            $data[] = array($nb['g'], $nb['joueur']);
        }





        $bar = new barchart();
        $bar->getData()->setArrayToDataTable(
            $data
        );

        $bar->getOptions()->setTitle('goals :');
        $bar->getOptions()->setHeight(500);
        $bar->getOptions()->setWidth(900);
        $bar->getOptions()->getTitleTextStyle()->setColor('#07600');
        $bar->getOptions()->getTitleTextStyle()->setFontSize(25);






        return $this->render('joueur/statJ.html.twig', array('barchart' => $bar,'nbs' => $nbs));
    }
    /**
     * @Route("/joueur", name="joueur")
     */
    public function index(): Response
    {
        $session = $this->requestStack->getSession();
        $user = $session->get('user');

        if($user == null )
            return $this->redirectToRoute('login');
        $user =  $this->getDoctrine()->getRepository(User::class)->findOneBy(['id'=>$user[0]]);
        if($user == null )
            return $this->redirectToRoute('login');

        if($user->getRole() == 'client' )
        {
            return $this->redirectToRoute('user');
        }

        return $this->render('joueur/index.html.twig', [
            'controller_name' => 'JoueurController',
        ]);
    }
    /**
     * @Route("/viewj", name="viewj")
     */
    public function viewj( NormalizerInterface $Normalizer)
    {
        $repo = $this->getDoctrine()->getRepository(Joueur::class);
        $joueurs = $repo->findAll();



        $json=$Normalizer->normalize($joueurs,'json',['groups'=>'joueur']);


        return new Response(json_encode($json));

        dump($json);

        die;
    }


/**
     * @Route("/detailJ{cin}", name="detailJ")
     */
    public function detailJ($cin): Response
    {
        //recuperer le repository pour utiliser la fonction findAll()
        $r=$this->getDoctrine()->getRepository(Game::class);
        $games=$r->findAll();
        $r=$this->getDoctrine()->getRepository(Joueur::class);
        $arbitres=$r->find($cin);
        $result = $this->getDoctrine()->getRepository(tournoi::class);
        $tournois = $result->findall();
        return $this->render('joueur/detailJ.html.twig', [
            'e' => $arbitres,
           // 'cl' =>$arbitres->getClub(),
            'g' =>$games,
            'c' =>$tournois,
        ]);
    }



    ///methode Ajout
    /**
     * @Route("/ajoutJ", name="ajoutJ")
     */

    public function ajoutJ(Request $request,FlashyNotifier $flashy): Response
    {
        //creation une formulaire
        $c=new Joueur();
        $form=$this->createForm(JoueurType::class,$c);

        //recuperer les donnees depuis la requette http
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid())
        {
            $file = $form->get('photo')->getData();

            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

            // moves the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName
            );

            $c->setPhoto($fileName);
            $em=$this->getDoctrine()->getManager();
            $em->persist($c);
            $em->flush();
            $flashy->success('Joueur ajouté avec succés', 'http://your-awesome-link.com');
            return $this->redirect('afficheJ');
        }
        return $this->render('joueur/ajoutJ.html.twig',['g' => $form->createView()]);

    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

    ///methode affichage
    /**
     * @Route("/afficheJ", name="afficheJ")
     */
    public function afficheJ(PaginatorInterface $paginator,Request $request): Response
    {
        //recuperer le repository pour utiliser la fonction findAll()
        $r=$this->getDoctrine()->getRepository(Joueur::class);
        $arbitres=$r->findAll();

        $p=$paginator->paginate(
            $arbitres,
            $request->query->getInt('page',1),
            10
        );
        return $this->render('joueur/afficheJ.html.twig', [
            'e' => $p,
        ]);
    }

    ///methode affichage
    /**
     * @Route("/afficheJF", name="afficheJF")
     */
    public function afficheJF(): Response
    {
        //recuperer le repository pour utiliser la fonction findAll()
        $r=$this->getDoctrine()->getRepository(Game::class);
        $games=$r->findAll();
        $r=$this->getDoctrine()->getRepository(Joueur::class);
        $arbitres=$r->findAll();
        $result = $this->getDoctrine()->getRepository(tournoi::class);
        $tournois = $result->findall();
        return $this->render('joueur/afficheJF.html.twig', [
            'e' => $arbitres,
            'g'=> $games,
            'c' =>$tournois,
        ]);
    }


///methode supprimer
    /**
     * @Route("/SuppJ/{cin}", name="SuppJ")
     */
    public function SuppJ($cin,FlashyNotifier $flashy): Response
    {
        //recuperer le Classroom a supprimer find($id)
        $s=$this->getDoctrine()->getRepository(Joueur::class);
        $arbitres=$s->find($cin);

        //on passe a la supprision
        $em=$this->getDoctrine()->getManager();
        $em->remove($arbitres);
        $em->flush();
        $flashy->error('Joueur supprimé !!', 'http://your-awesome-link.com');
        return $this->redirectToroute('afficheJ');
        //    return $this->render('classroom/afficheC.html.twig', [
        //    'c' => $classrooms,
        //    ]);
    }

    ///methode modifier
    /**
     * @Route("/modifJ/{cin}", name="modifJ")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function modifJ(Request $request,$cin, FlashyNotifier $flashy): Response
    {
        //recuperer le Classroom a supprimer find($id)
        // $c=new Classroom();
        $s=$this->getDoctrine()->getRepository(Joueur::class);
        $arbitres=$s->find($cin);

        $form=$this->createForm(JoueurType::class,$arbitres);
        $checkout=$form->handleRequest($request);
        if($checkout->isSubmitted()&&$checkout->isValid())
        {
            $file = $form->get('photo')->getData();

            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

            // moves the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName
            );

            $arbitres->setPhoto($fileName);
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            $flashy->info('Arbitre modifié!', 'http://your-awesome-link.com');
            return $this->redirectToRoute('afficheJ');
        }

        return $this->render('joueur/ajoutJ.html.twig',['g' => $form->createView()]);
    }

    /**
     * @Route("/deletejoueur", name="deletejoueur")
     */
    public function deletejoueur (Request $request, SerializerInterface  $serializer , EntityManagerInterface $em)
    {
        $id = $request->get("cin");
        //$m = $this->getDoctrine();
        $joueur  = $this->getDoctrine()->getRepository(Joueur::class)->find($id);
        $em = $this->getDoctrine()->getManager();

        if($joueur != null)
        {
            $em->remove($joueur);
            $em->flush();
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize("joueur Deleted ");
            return new JsonResponse($formatted);
        }
        // return new JsonResponse("rip");
    }

    /**
     * @Route("/addJoueur1", name="addJoueur1")
     */
    public function addAvis(Request $request, NormalizerInterface $Normalizer){
        $em=$this->getDoctrine()->getManager();
        $reclamation = new Joueur();

        $reclamation->setNom($request->get('nom'));
        $reclamation->setPoste($request->get('poste'));

        $em->persist($reclamation);
        $em->flush();
        $jsonContent = $Normalizer->normalize($reclamation, 'json',['groups'=>'joueur']);
        return new Response("Informations ajoutées avec succès".json_encode($jsonContent));
    }


}
