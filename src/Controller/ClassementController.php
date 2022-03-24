<?php

namespace App\Controller;


use App\Entity\Classement;
use App\Entity\Game;
use App\Entity\Club;
use App\Entity\Tournoi;
use App\Entity\User;
use App\Form\ClassementType;
use App\Repository\ClubRepository;
use App\Repository\TournoiRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class ClassementController extends AbstractController
{
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    private $requestStack;
    /**
     * @Route("/classement", name="classement")
     */
    public function index(): Response
    {
        return $this->render('classement/index.html.twig', [
            'controller_name' => 'ClassementController',
        ]);
    }
    
    /**
     * @Route("/ajoutClassement", name="ajoutClassement")
     */
    public function ajoutClassement(Request $request): Response
    {
        //creation du formulaire
        $c=new Classement();
        $form=$this->createForm(ClassementType::class,$c);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()  ) {
            $em=$this->getDoctrine()->getManager();
            $em->persist($c);
            $em->flush();
            return $this->redirectToRoute('afficheClassement');
        }
        return $this->render('classement/ajoutClassement.html.twig', [
            'r' => $form->createView()
        ]);
    }
    /**
     * @Route("/suppClassement/{id}", name="suppClassement")
     */
    public function suppClassement($id): Response
    {
        $rewards=$this->getDoctrine()->getRepository(Classement::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($rewards);
        $em->flush();
        return $this->redirectToRoute('afficheClassement');

    }
    /**
     * @Route("/modifClassement/{id}", name="modifClassement")
     */
    public function modifClassement(Request $request,$id): Response
    {
        //creation du formulaire
        $rewards=$this->getDoctrine()->getRepository(Classement::class)->find($id);
        $form=$this->createForm(ClassementType::class,$rewards);
        $checkout=$form->handleRequest($request);
        if($checkout->isSubmitted()&&$checkout->isValid())
        {



            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('afficheClassement');
        }
        return $this->render('classement/ajoutClassement.html.twig', [
            'r' => $form->createView()
        ]);
    }
    /**
     * @Route("/afficheClassement", name="afficheClassement")
     *
     */
    public function afficheClassement(): Response
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
        $result = $this->getDoctrine()->getRepository(Classement::class);
        $rewards = $result->findall();
        return $this->render('classement/deg.html.twig', [
            'r' =>$rewards,
        ]);
    }
    /**
     * @Route("/afficheCls{id}", name="afficheCls")
     */
    public function afficheCls($id,ClubRepository  $clubRepository): Response
    {
        //$result = $this->getDoctrine()->getRepository(classement::class);
        $result = $this->getDoctrine()->getRepository(Classement::class);
        $resultx = $this->getDoctrine()->getRepository(Classement::class);
       // $tournement = $this->getDoctrine()->getRepository(Classement::class)->findBy'idt'($idt);

        //$cl = $this->getDoctrine()->getRepository(Club::class);
        $dataclub = [];

        $resultt = $resultx->findByResultatc($id);

    foreach ( $resultt as $x) {




            $form="";
        $form1="";
        $form2="";
        $form3="";
            $count = 0;
            $classement = $result->findByResultat($x->getId(), $id);
            $count1 = count($classement) * 3;
            if($count1)
            {
                $form1="W";
            }else
                $form1="L";
            $classement = $result->findByResultat1($x->getId(), $id);
            $count2 = count($classement) * 3;


            $classement = $result->findByResultat2($x->getId(), $id);
            $count3 = count($classement) * 1;
        if($count3)
        {
            $form3="D";
        }
            $count = $count + $count1 + $count2 + $count3;
           //  $form= sum($form,$form1,$form2,$form3);

            $dataclub[] =
                [

                    'club' => $clubRepository->find($x->getid()),
                    'game1'=>$result->findByResultat($x->getId(), $id),
                    'game2'=>$result->findByResultat1($x->getId(), $id),
                    'game3'=>$result->findByResultat2($x->getId(), $id),
                    'pts' => $count,
                    'f1'=>$form1,
                    'f2'=>$form2,
                    'f3'=>$form3
                ];

    }


            // $s = $count->findall();
            // return $this->redirectToRoute('club', [
            //    'c' => $dataclub,
            // ]);

        return $this->render('classement/index.html.twig', [
            'c' => $dataclub,
        ]);


        }
    /**
     * @Route("/search1/{searchString}", name="search")
     */
    public function searchEnt($searchString,SerializerInterface $serializerInterface)
    {
        $serializer=new Serializer([new ObjectNormalizer()]);
        // $serializer = new Serializer([new ObjectNormalizer()]);
        $repository = $this->getDoctrine()->getRepository(Classement::class);
        // $students = $repository->findByid($searchString);
        //$students = $repository->findBy(array('id' => '%'.'2'));

        $students = $repository->findByExampleField($searchString);
       // $data = $serializerInterface->normalize($students,'json',['groups'=>'student']);
         $data=$serializer->normalize($students);

        return new JsonResponse($data);
    }


}
