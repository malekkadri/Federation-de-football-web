<?php

namespace App\Controller;
use App\Entity\Badge;
use App\Entity\User;
use App\Form\BadgeType;
use App\Form\ClassementType;
use App\Entity\Classement;
use App\Entity\Club;
use App\Entity\Game;
use App\Entity\Joueur;
use App\Form\ClubType;
use App\Entity\Tournoi;
use App\Form\TournoiType;
use App\Repository\ClubRepository;
use Dompdf\Dompdf;
use Dompdf\Options;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\String\Slugger\AsciiSlugger;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Polyfill\Intl\Normalizer\Normalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Doctrine\ORM\EntityManagerInterface;


class ClubController extends AbstractController
{
    /**
     * @Route("/pdfC", name="pdfC")
     */
    public function listpdf(Request $request)
    {

        $entityManager = $this->getDoctrine();
        $list = $entityManager->getRepository(Club::class)
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

        $html=$this->render('club/pdfC.html.twig', [
            'e' => $list
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);



        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("club/pdfC.html.twig", [
            "Attachment" => false
        ]);


    }
    /**
     * @Route("/club", name="club")
     */
    public function index(): Response
    {
        return $this->render('club/index.html.twig', [
            'controller_name' => 'ClubController',
        ]);
    }

    /**
     * @Route("/detailCl{id}", name="detailCl")
     */
    public function detailCl($id,ClubRepository  $clubRepository): Response
    {
    
        $r=$this->getDoctrine()->getRepository(Game::class);
        $games=$r->findAll();
        $r=$this->getDoctrine()->getRepository(Club::class);
        $arbitres=$r->find($id);
        $r=$this->getDoctrine()->getRepository(Joueur::class);
        $joueurs=$r->findAll();
        $result = $this->getDoctrine()->getRepository(tournoi::class);
        $tournois = $result->findall();
        return $this->render('club/detailCl.html.twig', [
            'e' => $arbitres,
           'art'=>$arbitres->getGames(),
            'artt'=>$arbitres->getGames2(),
            'jr' =>$arbitres->getJoueurs(),
            'g' =>$games,
            'c' =>$tournois,
            //'aa' =>$arbitres->getClassements(),
            //'aa' => $dataclub,
        ]);
    }
    /**
     * @Route("/viewc", name="viewc")
     */
    public function viewc( NormalizerInterface $Normalizer)
    {
        $repo = $this->getDoctrine()->getRepository(Club::class);
        $club = $repo->findAll();



        $json=$Normalizer->normalize($club,'json',['groups'=>'club']);


        return new Response(json_encode($json));

        dump($json);

        die;
    }
    ///methode Ajout
    /**
     * @Route("/ajoutCl", name="ajoutCl")
     */

    public function ajoutCl(Request $request,FlashyNotifier $flashy): Response
    {
        //creation une formulaire
        $c=new Club();
        $form=$this->createForm(ClubType::class,$c);

        //recuperer les donnees depuis la requette http
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid())
        {
            $file = $form->get('logo')->getData();

            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

            // moves the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName
            );

            $c->setLogo($fileName);
            $em=$this->getDoctrine()->getManager();
            $em->persist($c);
            $em->flush();
            $flashy->success('Club ajouté avec succés', 'http://your-awesome-link.com');
            return $this->redirect('afficheCl');
        }
        return $this->render('club/ajoutCl.html.twig',['g' => $form->createView()]);

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
     * @Route("/afficheCl", name="afficheCl")
     */
    public function afficheCl(): Response
    {
        //recuperer le repository pour utiliser la fonction findAll()
        $r=$this->getDoctrine()->getRepository(Club::class);
        $arbitres=$r->findAll();
        return $this->render('club/afficheCl.html.twig', [
            'e' => $arbitres,
        ]);
    }

    ///methode affichage
    /**
     * @Route("/afficheClub", name="afficheClub")
     */
    public function afficheClub(): Response
    {
        //recuperer le repository pour utiliser la fonction findAll()
        $result = $this->getDoctrine()->getRepository(tournoi::class);
        $tournois = $result->findall();
        $r=$this->getDoctrine()->getRepository(Club::class);
        $arbitres=$r->findAll();
        $r=$this->getDoctrine()->getRepository(Game::class);
        $games=$r->findAll();
        return $this->render('club/afficheClub.html.twig', [
            'e' => $arbitres,
            'g'=> $games,
            'c' =>$tournois,
        ]);
    }


///methode supprimer
    /**
     * @Route("/SuppCl/{id}", name="SuppCl")
     */
    public function SuppCl($id,FlashyNotifier $flashy): Response
    {
        //recuperer le Classroom a supprimer find($id)
        $s=$this->getDoctrine()->getRepository(Club::class);
        $arbitres=$s->find($id);

        //on passe a la supprision
        $em=$this->getDoctrine()->getManager();
        $em->remove($arbitres);
        $em->flush();
        $flashy->error('Club supprimé !!', 'http://your-awesome-link.com');
        return $this->redirectToroute('afficheCl');
        //    return $this->render('classroom/afficheC.html.twig', [
        //    'c' => $classrooms,
        //    ]);
    }

    ///methode modifier
    /**
     * @Route("/modifCl/{id}", name="modifCl")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function modifCl(Request $request,$id, FlashyNotifier $flashy): Response
    {
        //recuperer le Classroom a supprimer find($id)
        // $c=new Classroom();
        $s=$this->getDoctrine()->getRepository(Club::class);
        $arbitres=$s->find($id);

        $form=$this->createForm(ClubType::class,$arbitres);
        $checkout=$form->handleRequest($request);
        if($checkout->isSubmitted()&&$checkout->isValid())
        {
            $file = $form->get('logo')->getData();

            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

            // moves the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName
            );

            $arbitres->setLogo($fileName);
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            $flashy->info('Club modifié!', 'http://your-awesome-link.com');
            return $this->redirectToRoute('afficheCl');
        }

        return $this->render('club/ajoutCl.html.twig',['g' => $form->createView()]);
    }

//------------------------












/**
 * @Route("/deleteclub", name="deleteclub")
 */
public function deleteclub (Request $request, SerializerInterface  $serializer , EntityManagerInterface $em)
{
    $id = $request->get("id");
    //$m = $this->getDoctrine();
    $club  = $this->getDoctrine()->getRepository(Club::class)->find($id);
    $em = $this->getDoctrine()->getManager();

    if($club != null)
    {
        $em->remove($club);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize("Club Deleted ");
        return new JsonResponse($formatted);
    }
   // return new JsonResponse("rip");
}




    /**
     * @Route("/addClub", name="addClub")
     */
    public function addAvisJSON(Request $request, NormalizerInterface $Normalizer){
        $em=$this->getDoctrine()->getManager();
        $reclamation = new club();

        $reclamation->setNomc($request->get('nomc'));
        $reclamation->setLogo($request->get('logo'));
        $reclamation->setDescr($request->get('descr'));
        $reclamation->setPresident($request->get('president'));

        $em->persist($reclamation);
        $em->flush();
        $jsonContent = $Normalizer->normalize($reclamation, 'json',['groups'=>'club']);
        return new Response("Informations ajoutées avec succès".json_encode($jsonContent));
    }






    /******************Modification club*****************************************/

    /**
     * @Route("/updateClub/{id}", name="updateClub")
     */
    public function updateClub(Request $request, NormalizerInterface $Normalizer,$id){
        $em=$this->getDoctrine()->getManager();
        $event=$em->getRepository(Club::class)->find($id);

        $event->setNomc($request->get('nomc'));
        $event->setDescr($request->get('descr'));
        $event->setLogo($request->get('logo'));
        $event->setPresident($request->get('president'));
        $em->flush();
        $jsonContent=$Normalizer->normalize($event,'json',['groups'=>'club']);
        return new Response("Informations mises à jour avec succès".json_encode($jsonContent));
    }





/**
 * @Route("/deleteBadge/{id}", name="deleteBadge")
 */
public function supp ($id): Response
{
    //recupperer
    $classrooms = $this->getDoctrine()->getRepository(Badge::class)->find($id);
    $er=$this->getDoctrine()->getManager();
    //suppression
    $er->remove($classrooms);
    //effectuer la supp
    $er->flush();
    return $this->redirectToRoute("badge");






}
}