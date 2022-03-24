<?php

namespace App\Controller;

use App\Entity\Club;
use App\Entity\Stade;
use App\Entity\Arbitre;
use App\Entity\Game;
use App\Entity\Sponsor;
use App\Entity\User;
use App\Form\StadeType;
use App\Form\SponsorType;
use App\Entity\Tournoi;
use App\Form\TournoiType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\StadeRepository;
use Symfony\Component\HttpFoundation\Request;
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
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class SponsorController extends AbstractController
{
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    private $requestStack;
    /**
     * @Route("/sponsor", name="sponsor")
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
        return $this->render('sponsor/index.html.twig', [
            'controller_name' => 'SponsorController',
        ]);
    }

     /**
     * @Route("/listarticlepdf", name="listpdf")
     */
    public function listpdf(Request $request)
    {

        $entityManager = $this->getDoctrine();
        $list = $entityManager->getRepository(Stade::class)
            ->findAll();


        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
       
        $pdfOptions->set('isRemoteEnabled', true);

        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new DOMPDF($pdfOptions);
      
        $contxt = stream_context_create([ 
            'ssl' => [ 
                'verify_peer' => FALSE, 
                'verify_peer_name' => FALSE,
                'allow_self_signed'=> TRUE
            ] 
        ]);

        $html=$this->render('stade/listpdf.html.twig', [
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
     * @Route("/detailSp{id}", name="detailSp")
     */
    public function detailSp($id): Response
    {
        //recuperer le repository pour utiliser la fonction findAll()
        $r=$this->getDoctrine()->getRepository(Game::class);
        $games=$r->findAll();
        $r=$this->getDoctrine()->getRepository(Sponsor::class);
        $arbitres=$r->find($id);
        return $this->render('sponsor/detailSp.html.twig', [
            'e' => $arbitres,
            'g' => $games,
        ]);
    }

///methode Ajout
    /**
     * @Route("/ajoutSp", name="ajoutSp")
     */

    public function ajoutSp(Request $request,FlashyNotifier $flashy): Response
    {
        //creation une formulaire
        $c=new Sponsor();
        $form=$this->createForm(SponsorType::class,$c);

        //recuperer les donnees depuis la requette http
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid())
        {
            $file = $form->get('logoS')->getData();

            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

            // moves the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName
            );

            $c->setLogoS($fileName);
            $em=$this->getDoctrine()->getManager();
            $em->persist($c);
            $em->flush();
            $flashy->success('Sponsor ajouté avec succés', 'http://your-awesome-link.com');
            return $this->redirect('afficheSp');
        }
        return $this->render('sponsor/ajoutSp.html.twig',['g' => $form->createView()]);

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
     * @Route("/afficheSp", name="afficheSp")
     */
    public function afficheSp(): Response
    {
        //recuperer le repository pour utiliser la fonction findAll()
        $r=$this->getDoctrine()->getRepository(Sponsor::class);
        $stades=$r->findAll();
        return $this->render('sponsor/afficheSp.html.twig', [
            'e' => $stades,
        ]);
    }

    ///methode affichage
    /**
     * @Route("/afficheSpF", name="afficheSpF")
     */
    public function afficheSpF(): Response
    {
        //recuperer le repository pour utiliser la fonction findAll()
        $r=$this->getDoctrine()->getRepository(Game::class);
        $games=$r->findAll();
        $r=$this->getDoctrine()->getRepository(Sponsor::class);
        $stades=$r->findAll();
        return $this->render('sponsor/afficheSpF.html.twig', [
            'e' => $stades,
            'g' => $games,
        ]);
    }
///methode supprimer
    /**
     * @Route("/SuppSp/{id}", name="SuppSp")
     */
    public function SuppSp($id,FlashyNotifier $flashy): Response
    {
        //recuperer le Classroom a supprimer find($id)
        $s=$this->getDoctrine()->getRepository(Sponsor::class);
        $stades=$s->find($id);

        //on passe a la supprision
        $em=$this->getDoctrine()->getManager();
        $em->remove($stades);
        $em->flush();
        $flashy->error('Sponsor supprimé !!', 'http://your-awesome-link.com');
        return $this->redirectToroute('afficheSp');
        //    return $this->render('classroom/afficheC.html.twig', [
        //    'c' => $classrooms,
        //    ]);
    }

    ///methode modifier
    /**
     * @Route("/modifSp/{id}", name="modifSp")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function modifSp(Request $request,$id,FlashyNotifier $flashy): Response
    {
        //recuperer le Classroom a supprimer find($id)
        // $c=new Classroom();
        $s=$this->getDoctrine()->getRepository(Sponsor::class);
        $stades=$s->find($id);

        $form=$this->createForm(SponsorType::class,$stades);
        $checkout=$form->handleRequest($request);
        if($checkout->isSubmitted()&&$checkout->isValid())
        {
            $file = $form->get('logoS')->getData();

            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

            // moves the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName
            );

            $stades->setLogoS($fileName);
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            $flashy->info('Sponsor modifié!', 'http://your-awesome-link.com');
            return $this->redirectToRoute('afficheSp');
        }

        return $this->render('sponsor/ajoutSp.html.twig',['g' => $form->createView()]);
    }
   //------------------

    /**
     * @Route("/viewsponsor", name="viewsponsor")
     */
    public function viewsponsor( NormalizerInterface $Normalizer)
    {
        $repo = $this->getDoctrine()->getRepository(Sponsor::class);
        $sponsor = $repo->findAll();



        $json=$Normalizer->normalize($sponsor,'json',['groups'=>'sponsor']);


        return new Response(json_encode($json));

        dump($json);

        die;
    }









    /**
     * @Route("/deletesponsor", name="deletesponsor")
     */
    public function deletesponsor (Request $request, SerializerInterface  $serializer , EntityManagerInterface $em)
    {
        $id = $request->get("id");
        //$m = $this->getDoctrine();
        $sponsor  = $this->getDoctrine()->getRepository(Sponsor::class)->find($id);
        $em = $this->getDoctrine()->getManager();

        if($sponsor != null)
        {
            $em->remove($sponsor);
            $em->flush();
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize("sponsor Deleted ");
            return new JsonResponse($formatted);
        }
        // return new JsonResponse("rip");
    }


    /**
     * @Route("/addsponsor", name="addsponsor")
     */
    public function addsponsor (Request $request, SerializerInterface  $serializer , EntityManagerInterface $em)
    {

        $sponsor = new Sponsor();
        $nomS = $request->query->get("noms");
        $logoS = $request->query->get("logoS");

        $em = $this->getDoctrine()->getManager();
        $sponsor ->setNomS($nomS);
        $sponsor ->setlogoS($logoS);

        $em->persist($sponsor );
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($sponsor );
        return new JsonResponse($formatted);
    }






}

