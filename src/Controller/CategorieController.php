<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\User;
use App\Form\CategorieType;
use Symfony\Component\Form\isSubmitted;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CathegorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Json;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Doctrine\ORM\EntityManagerInterface;



class CategorieController extends AbstractController
{
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    private $requestStack;
    /**
     * @Route("/categorie", name="categorie")
     */
    public function index(): Response
    {
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }

    /**
     * @Route("/ajoutc", name="ajoutc")
     */
    public function ajoutc(Request $request): Response
    {
        $c=new Categorie();
        $form=$this->createForm(CategorieType::class,$c);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($c);
            $em->flush();
            return $this->redirectToRoute("affichec");

        }

        return $this->render('categorie/ajout_categorie.html.twig', [ 'f'=>$form->createView()]);

    }

    /**
     * @Route("/affichec", name="affichec")
     */
    public function affichec(): Response
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
        $r=$this->getDoctrine()->getRepository(Categorie::class);
        $p=$r->findAll();
        return $this->render('Categorie/index.html.twig', ['c'=>$p,
        ]);
    }

    /**
     * @Route("/modifc/{id}", name="modifc")
     */
    public function modifc(Request $request,$id): Response
    {

        $class=$this->getDoctrine()->getRepository(Categorie::class)->find($id);


        $form=$this->createForm(CategorieType::class,$class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();

            $em->flush();
            return $this->redirectToRoute("affichec");
        }

        return $this->render('Categorie/modif_categorie.html.twig', [ 'f'=>$form->createView()]);



    }


    /**
     *
     * @Route("/suppc/{id}", name="suppc")
     */
    public function suppc($id): Response
    {
        $class=$this->getDoctrine()->getRepository(Categorie::class)->find($id);
        $d=$this->getDoctrine()->getManager();
        $d->remove($class);
        $d->flush();
        return $this->redirectToRoute("affichec");

    }




    /**
     * @Route("/store", name="store")
     */
    public function store(): Response
    {
        $r=$this->getDoctrine()->getRepository(Categorie::class);
        $p=$r->findAll();
        return $this->render('store.html.twig', ['c'=>$p,
        ]);
    }



    /**
     * @Route("/addc", name="addc")
     */

    public function addc(Request $request, SerializerInterface  $serializer , EntityManagerInterface $em)
    {
        $badge = new Categorie();


        $marque=   $request->query->get("typeC");

        $em = $this->getDoctrine()->getManager();

        $badge->setTypeC($marque);

        $em->persist($badge);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($badge);
        return new JsonResponse($formatted);
    }

    /**
     * @Route("/getc", name="getc")
     */
    public function getc(CathegorieRepository $repository,NormalizerInterface $serializer){
        //$marque=$this->getDoctrine()->getManager()->getRepository(Marques::class)->findAll();
        $rep= $this->getDoctrine()->getRepository(Categorie::class);
        $marque=$rep->findAll();
        $formatted=$serializer->normalize($marque,'json',['groups'=>'cat']);

        return new  Response(json_encode($formatted));
    }

    /**
     * @Route("/updatec", name="updatec")
     */
    public function updatec(Request $request,NormalizerInterface $serializer,EntityManagerInterface $em)
    {
        $em=$this->getDoctrine()->getManager();
        $m=$this->getDoctrine()->getManager()->getRepository(Categorie::class)->find($request->get("id"));
        $m->setTypeC($request->get("typeC"));
        $em->persist($m);
        $em->flush();
        //$serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($m,'json',['groups'=>'cat']);
        return new JsonResponse('Categorie updated');
    }

    /**
     * @Route("/deletec", name="deletec")
     */
    public function deletec(Request $request, SerializerInterface  $serializer , EntityManagerInterface $em)
    {
        $id = $request->get("id");
        $em = $this->getDoctrine()->getManager();
        $badge  = $em->getRepository(Categorie::class)->find($id);
        if($badge != null)
        {
            $em->remove($badge);
            $em->flush();
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize("categorie Deleted ");
            return new JsonResponse($formatted);
        }
        return new JsonResponse("rip");
    }

}
