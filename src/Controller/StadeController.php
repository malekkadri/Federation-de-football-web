<?php

namespace App\Controller;
use App\Entity\Stade;
use App\Entity\Arbitre;
use App\Entity\Tournoi;
use App\Entity\Game;
use App\Entity\Club;
use App\Form\StadeType;
use App\Repository\StadeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;
use Dompdf\Dompdf;
use Dompdf\Options;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\BarChart;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Doctrine\ORM\EntityManagerInterface;
use CMEN\GoogleChartsBundle\GoogleCharts\Options\VAxis;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Histogram;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\LineChart;
use CMEN\GoogleChartsBundle\Twig\GoogleChartsExtension;
use MercurySeries\FlashyBundle\FlashyNotifier;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use SessionIdInterface;
use Symfony\Component\Validator\Constraints\Json;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class StadeController extends AbstractController
{
    /**
     * @Route("/stade", name="stade")
     */
    public function index(): Response
    {
        return $this->render('stade/indexS.html.twig', [
            'controller_name' => 'StadeController',
        ]);
    }



    /**
     * @Route("/llistarticlepdf", name="llistpdf")
     */
    public function llistpdf(Request $request)
    {

        $entityManager = $this->getDoctrine();
        $list = $entityManager->getRepository(Stade::class)
            ->findAll();


        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
       
        

        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new DOMPDF($pdfOptions);
      
       

        $html=$this->renderView('stade/listpdf.html.twig', [
            'e' => $list
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

      

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("stade/listpdf.html.twig", [
            "Attachment" => false
        ]);


    }

    /**
     * @Route("/stats/chart", name="statistique")
     */
    public function stat(StadeRepository $terrainRepository){


        /*$pieChart->getOptions()->setTitle('Etat de terrain:');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#303030');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(false);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);*/
        $nbs = $terrainRepository->countEtat();
        $data = [['e', 'stade']];
        foreach( (array)$nbs as $nb)
        {
            $data[] = array($nb['e'], $nb['stade']);
        }

        $bar = new barchart();
        $bar->getData()->setArrayToDataTable(
            $data
        );
        $bar->getOptions()->setTitle('Etat des terrains:');
        $bar->getOptions()->setHeight(500);
        $bar->getOptions()->setWidth(900);
        $bar->getOptions()->getTitleTextStyle()->setColor('#07600');
        $bar->getOptions()->getTitleTextStyle()->setFontSize(25);


        return $this->render('stade/stat.html.twig', array('barchart' => $bar,'nbs' => $nbs));
    }

    /**
     * @Route("/detailS{id}", name="detailS")
     */
    public function detailS($id): Response
    {
        //recuperer le repository pour utiliser la fonction findAll()
        $d=[];
        $r=$this->getDoctrine()->getRepository(Game::class);
        $games=$r->findAll();
       
        $r=$this->getDoctrine()->getRepository(Stade::class);
        $arbitres=$r->find($id);
        $result = $this->getDoctrine()->getRepository(tournoi::class);
        $tournois = $result->findall();
 

        return $this->render('stade/detailS.html.twig', [
            'e' => $arbitres,
            'art'=>$arbitres->getGame(),
            'g' => $games,
            'c' =>$tournois,
        ]);
    }

///methode Ajout
    /**
     * @Route("/ajoutS", name="ajoutS")
     */

    public function ajoutS(Request $request,FlashyNotifier $flashy): Response
    {
        //creation une formulaire
        $c=new Stade();
        $form=$this->createForm(StadeType::class,$c);

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
            $flashy->success('Stade ajouté avec succés', 'http://your-awesome-link.com');
            return $this->redirect('afficheS');
        }
        return $this->render('stade/ajoutS.html.twig',['g' => $form->createView()]);

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
     * @Route("/afficheS", name="afficheS")
     */
    public function afficheS(): Response
    {
        //recuperer le repository pour utiliser la fonction findAll()
        
        $r=$this->getDoctrine()->getRepository(Arbitre::class);
        $arbitres=$r->findAll();
        $r=$this->getDoctrine()->getRepository(Stade::class);
        $stades=$r->findAll();
        return $this->render('stade/afficheS.html.twig', [
            'e' => $stades,
            'a' => $arbitres,
        ]);
    }

    ///methode affichage
    /**
     * @Route("/afficheSF", name="afficheSF")
     */
    public function afficheSF(): Response
    {
        //recuperer le repository pour utiliser la fonction findAll()
        $result = $this->getDoctrine()->getRepository(tournoi::class);
        $tournois = $result->findall();
        $r=$this->getDoctrine()->getRepository(Game::class);
        $games=$r->findAll();
        $r=$this->getDoctrine()->getRepository(Stade::class);
        $stades=$r->findAll();
        return $this->render('stade/afficheSF.html.twig', [
            'e' => $stades,
            'g' => $games,
            'c' =>$tournois,
        ]);
    }
///methode supprimer
    /**
     * @Route("/SuppS/{id}", name="SuppS")
     */
    public function SuppS($id,FlashyNotifier $flashy): Response
    {
        //recuperer le Classroom a supprimer find($id)
        $s=$this->getDoctrine()->getRepository(Stade::class);
        $stades=$s->find($id);

        //on passe a la supprision
        $em=$this->getDoctrine()->getManager();
        $em->remove($stades);
        $em->flush();
        $flashy->error('Stade supprimé !!', 'http://your-awesome-link.com');
        return $this->redirectToroute('afficheS');
        //    return $this->render('classroom/afficheC.html.twig', [
        //    'c' => $classrooms,
        //    ]);
    }

    ///methode modifier
    /**
     * @Route("/modifS/{id}", name="modifS")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function modifS(Request $request,$id,FlashyNotifier $flashy): Response
    {
        //recuperer le Classroom a supprimer find($id)
        // $c=new Classroom();
        $s=$this->getDoctrine()->getRepository(Stade::class);
        $stades=$s->find($id);

        $form=$this->createForm(StadeType::class,$stades);
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

            $stades->setPhoto($fileName);
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            $flashy->info('Stade modifié!', 'http://your-awesome-link.com');
            return $this->redirectToRoute('afficheS');
        }

        return $this->render('stade/ajoutS.html.twig',['g' => $form->createView()]);
    }


/**
     * @Route("/map/map", name="map_index", methods={"GET"})
     */
    public function map(): Response
    {
        return $this->render('stade/map.html.twig');


    }
        /**
     * @Route("/addStadesj", name="addStadesj")
     */
    public function addStadesj(Request $request, SerializerInterface  $serializer , EntityManagerInterface $em)
    {

        $em=$this->getDoctrine()->getManager();
        $tournoi=new Stade();

        $tournoi->setNoms($request->get("noms"));
        $tournoi->setNbrP($request->get("nbrP"));       
        $tournoi->setLieu($request->get("lieu"));
        $tournoi->setEtat($request->get("etat"));
        $tournoi->setPhoto($request->get("photo"));

        $em->persist($tournoi);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tournoi);
        return new JsonResponse($formatted);
    }

        /**
     * @Route("/viewSj", name="viewSj")
     */
    public function viewSj( NormalizerInterface $Normalizer)
    {
        $repo = $this->getDoctrine()->getRepository(Stade::class);
        $tournois = $repo->findAll();



        $json=$Normalizer->normalize($tournois,'json',['groups'=>'stade : read']);


        return new Response(json_encode($json));

        dump($json);

        die;
    }


    /**
     * @Route("/updateS/json", name="updateS_json",methods={"POST","GET"})
     */
    public function updateS_Json(Request $request, NormalizerInterface $serializer ,EntityManagerInterface $entityManager)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $terrain=$entityManager->getRepository(Stade::class)->find($request->get("id"));

        $terrain->getNoms($request->get("noms"));
        $terrain->getNbrP($request->get("nbrP"));
        $terrain->getLieu($request->get("lieu"));
        $terrain->getEtat($request->get("etat"));
        $terrain->getPhoto($request->get("photo"));
        $entityManager->flush();
        $data= $serializer->normalize($terrain,'json',['groups' => 'stade : read']);
        return new Response("Stade modifié avec succés".json_encode($data) );
    }

     /**
      * @Route("/deleteStadee/{id}", name="deleteStadee")
      * @Method("DELETE")
      */

      public function deleteStadee(Request $request) {
        $id = $request->get("id");

        $em = $this->getDoctrine()->getManager();
        $reclamation = $em->getRepository(Stade::class)->find($id);
        if($reclamation!=null ) {
            $em->remove($reclamation);
            $em->flush();

            $serialize = new Serializer([new ObjectNormalizer()]);
            $formatted = $serialize->normalize("Stade a ete supprimee avec success.");
            return new JsonResponse($formatted);

        }
        return new JsonResponse("id Stade invalide.");


    }



}
