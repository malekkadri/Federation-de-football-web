<?php

namespace App\Controller;


use App\Entity\Categorie;
use App\Entity\Produit;
use App\Entity\User;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Marques;
use App\Form\MarquesType;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Json;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use App\Repository\MarquesRepository;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


class MarquesController extends AbstractController
{
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    private $requestStack;
    /**
     * @Route("/marques", name="marques")
     */
    public function index(): Response
    {
        return $this->render('marques/index.html.twig', [
            'controller_name' => 'MarquesController',
        ]);
    }

    /**
     * @Route("/ajoutm", name="ajoutm")
     */
    public function ajoutm(Request $request): Response
    {
        $c=new Marques();
        $form=$this->createForm(MarquesType::class,$c);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($c);
            $em->flush();
             return $this->redirectToRoute("affichem");

        }

        return $this->render('Marques/ajout_marque.html.twig', [ 'f'=>$form->createView()]);

    }

    /**
     * @Route("/affichem", name="affichem")
     */
    public function affichem(): Response
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
        $r=$this->getDoctrine()->getRepository(Marques::class);
        $p=$r->findAll();
        return $this->render('Marques/index.html.twig', ['k'=>$p,
        ]);
    }

    /**
     * @Route("/modifm/{id}", name="modifm")
     */
    public function modifm(Request $request,$id): Response
    {

        $class=$this->getDoctrine()->getRepository(Marques::class)->find($id);


        $form=$this->createForm(MarquesType::class,$class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();

            $em->flush();
            return $this->redirectToRoute("affichem");
        }

        return $this->render('Marques/modif_marque.html.twig', [ 'f'=>$form->createView()]);



    }

    /**
     *
     * @Route("/suppm/{id}", name="suppm")
     */
    public function suppm($id): Response
    {
        $class=$this->getDoctrine()->getRepository(Marques::class)->find($id);
        $d=$this->getDoctrine()->getManager();
        $d->remove($class);
        $d->flush();
        return $this->redirectToRoute("affichem");

    }

    /**
     * @Route("/addm", name="addm")
     */

    public function addm(Request $request, SerializerInterface  $serializer , EntityManagerInterface $em)
    {
        $badge = new Marques();


        $marque=   $request->query->get("nomM");

        $em = $this->getDoctrine()->getManager();

        $badge->setNomM($marque);

        $em->persist($badge);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($badge);
        return new JsonResponse($formatted);
    }

    /**
     * @Route("/getm", name="getm")
     */
    public function getm(MarquesRepository $repository,NormalizerInterface $serializer){
  //$marque=$this->getDoctrine()->getManager()->getRepository(Marques::class)->findAll();
       $rep= $this->getDoctrine()->getRepository(Marques::class);
       $marque=$rep->findAll();
   $formatted=$serializer->normalize($marque,'json',['groups'=>'marque']);

  return new  Response(json_encode($formatted));
    }

    /**
     * @Route("/updatem", name="updatem")
     */
public function updatem(Request $request,NormalizerInterface $serializer,EntityManagerInterface $em)
{
    $em=$this->getDoctrine()->getManager();
    $m=$this->getDoctrine()->getManager()->getRepository(Marques::class)->find($request->get("id"));
    $m->setNomM($request->get("nomM"));
    $em->persist($m);
    $em->flush();
    //$serializer=new Serializer([new ObjectNormalizer()]);
    $formatted=$serializer->normalize($m,'json',['groups'=>'marque']);
    return new JsonResponse('Marques updated');
}

    /**
     * @Route("/deletem", name="deletem")
     */
    public function deletem(Request $request, NormalizerInterface  $serializer , EntityManagerInterface $em)
    {
        $id = $request->get("id");
        $em = $this->getDoctrine()->getManager();
        $badge  = $em->getRepository(Marques::class)->find($id);
        if($badge != null)
        {
            $em->remove($badge);
            $em->flush();
           // $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize("Marque Deleted ");
            $formatted=$serializer->normalize($badge,'json',['groups'=>'marque']);

        }
        return new JsonResponse("rip");
    }


}
