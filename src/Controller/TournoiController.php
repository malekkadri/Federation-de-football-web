<?php

namespace App\Controller;

use App\Entity\Classement;
use App\Entity\Rewards;
use App\Entity\Tournoi;
use App\Entity\User;
use App\Form\TournoiType;

use App\Repository\TournoiRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Dompdf\Dompdf;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Date;

class TournoiController extends AbstractController
{
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    private $requestStack;
    /**
     * @Route("/tournoi", name="tournoi")
     */
    public function index(): Response
    {
        return $this->render('tournoi/index.html.twig', [
            'controller_name' => 'TournoiController',
        ]);
    }
    /**
     * @Route("/test", name="test")
     */
    public function test(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Tournoi::class);
        $tournois = $repo->findAll();
        return $this->render('tournoi/recent_list.html.twig', [
            't' => $tournois,
        ]);
    }
    /**
     * @Route("/list", name="listpdf", methods={"GET"})
     */
    public function listpdf(TournoiRepository  $tournoiRepository): Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $tournoi = $tournoiRepository->findAll();

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('tournoi/tournoipdf.html.twig', [
            'tournois' => $tournoi,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);

    }

    /**
     * @Route("/viewbj", name="viewbj")
     */
    public function viewbj( NormalizerInterface $Normalizer)
    {
        $repo = $this->getDoctrine()->getRepository(Tournoi::class);
        $tournois = $repo->findAll();



        $json=$Normalizer->normalize($tournois,'json',['groups'=>'student']);


        return new Response(json_encode($json));

        dump($json);

        die;
    }
    /**
     * @Route("/afficheT", name="afficheT")
     */
    public function afficheT(): Response
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
        $result = $this->getDoctrine()->getRepository(tournoi::class);
        $tournois = $result->findall();


        return $this->render('tournoi/index.html.twig', [
            'c' =>$tournois,
        ]);
    }
    /**
     * @Route("/affiche", name="affiche")
     */
    public function affiche(): Response
    {
        $result = $this->getDoctrine()->getRepository(tournoi::class);
        $tournois = $result->findall();
        return $this->render('tournoi/tournoiFront.html.twig', [
            'c' =>$tournois,
        ]);
    }
    /**
     * @Route("/affiches{id}", name="affiches", methods={"GET"})
     */
    public function affiches($id): Response
    {
        $result = $this->getDoctrine()->getRepository(tournoi::class);
        $tournois = $result->find($id);
        $resultt = $this->getDoctrine()->getRepository(tournoi::class);
        $tournoiss = $resultt->findall();
        $resulttt = $this->getDoctrine()->getRepository(Classement::class);
        $tournoisss = $resulttt->find($id);
        $r=$this->getDoctrine()->getRepository(Rewards::class);
        $joueurs=$r->find($id);
        return $this->render('tournoi/tournoispecific.html.twig', [
            't' =>$tournois,
            'c' =>$tournoiss,
            'art' =>$tournois->getGame(),
            'cc' =>$tournois->getGame(),
            'ca' =>$joueurs,
        ]);
    }
    /**
     * @Route("/ajoutT", name="ajoutT")
     */
    public function ajoutT(Request $request): Response
    {
        //creation du formulaire
        $c=new Tournoi();
        $form=$this->createForm(TournoiType::class,$c);
        $form->handleRequest($request);
        if ($form->isSubmitted()and $form->isValid()) {
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
            return $this->redirectToRoute('afficheT');
        }
        return $this->render('tournoi/ajoutTournoi.html.twig', [
            'f' => $form->createView()
        ]);
    }
    /**
     * @Route("/addTournoij", name="addTournoij")
     */
    public function addTournoij(Request $request, SerializerInterface  $serializer , EntityManagerInterface $em)
    {
        /*
       $content = $request->getContent();
       $data = $serializer->deserialize($content,Badge::class,'json');
       $em->persist($data);
       $em->flush;
       return new Response('Badge Added sucessfully');
        */
        $em=$this->getDoctrine()->getManager();
        $tournoi=new Tournoi();




        $tournoi->setNomt($request->get("nomt"));
        $tournoi->setLogo($request->get("logo"));
        $tournoi->setDated(date_create_from_format("Y-m-d",$request->get("dated")));
        $tournoi->setDatef(date_create_from_format("Y-m-d",$request->get("datef")));
        $tournoi->setTypet($request->get("typet"));
        $tournoi->setNbrc($request->get("nbrc"));

        $em->persist($tournoi);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tournoi);
        return new JsonResponse($formatted);
    }
    /**
     * @Route("/deletebj", name="deletebj")
     */
    public function deletebj(Request $request, SerializerInterface  $serializer , EntityManagerInterface $em)
    {
        $id = $request->get("id");

        $tournois  = $this->getDoctrine()->getRepository(tournoi::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        if($tournois != null)
        {
            $em->remove($tournois);
            $em->flush();
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize("Tournoi Deleted ");
            return new JsonResponse($formatted);
        }
    }
    /**
     * @Route("/search/{searchString}", name="search")
     */
    public function search($searchString,SerializerInterface $serializerInterface)
    {
      //$serializer=new Serializer([new ObjectNormalizer()]);
       // $serializer = new Serializer([new ObjectNormalizer()]);
        $repository = $this->getDoctrine()->getRepository(tournoi::class);
        // $students = $repository->findByid($searchString);
        //$students = $repository->findBy(array('id' => '%'.'2'));

        $students = $repository->findByExampleField($searchString);
        $data = $serializerInterface->normalize($students,'json',['groups'=>'student']);
       // $data=$serializer->normalize("");

        return new JsonResponse($data);
    }

    /**
     * @Route("/updateTournoij", name="updateBadgej")
     */
    public function updateTournoij(Request $request, SerializerInterface  $serializer , EntityManagerInterface $em)
    {
        $em= $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository(Tournoi::class);
        $tournoi = $repo->find($request->get("id"));
       // $tournoi = $this->getDoctrine()->getManager()->getRepository(tournoi::class)->find($request->get("id"));

        $tournoi->setNomt($request->get("nomt"));
        $tournoi->setLogo($request->get("logo"));
        $tournoi->setDated(date_create_from_format("Y-m-d",$request->get("dated")));
        $tournoi->setDatef(date_create_from_format("Y-m-d",$request->get("datef")));
        $tournoi->setTypet($request->get("typet"));
        $tournoi->setNbrc($request->get("nbrc"));
        $em->persist($tournoi);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tournoi);
        return new JsonResponse("Tournoi Updated");
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

    /**
     * @Route("/suppT/{id}", name="suppT")
     */
    public function suppT($id): Response
    {
        $tournoi=$this->getDoctrine()->getRepository(tournoi::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($tournoi);
        $em->flush();
        return $this->redirectToRoute('afficheT');

    }
    /**
     * @Route("/modifT/{id}", name="modifT")
     */
    public function modifT(Request $request,$id): Response
    {
        //creation du formulaire
        $tournoi=$this->getDoctrine()->getRepository(tournoi::class)->find($id);
        $form=$this->createForm(TournoiType::class,$tournoi);
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

            $tournoi->setLogo($fileName);
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('afficheT');
        }
        return $this->render('tournoi/ajoutTournoi.html.twig', [
            'f' => $form->createView()
        ]);
    }
}
