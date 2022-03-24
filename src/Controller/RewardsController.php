<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Rewards;
use App\Entity\User;
use App\Form\RewardsType;
use App\Entity\Tournoi;
use App\Form\TournoiType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\File;

class RewardsController extends AbstractController
{
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    private $requestStack;

    /**
     * @Route("/listR", name="listR")
     */
    public function listR(Request $request, PaginatorInterface $paginator)
    {

        $r=$this->getDoctrine()->getRepository(Article::class);

        //faire appel a la fonction findAll
        $articles=$r->findAll();

        $reclamationsE = $paginator->paginate($articles, $request->query->getInt('page',1),
            2
        );
        return $this->render('article/listarticles.html.twig', [
            'a' =>$reclamationsE,

        ]);

    }
    /**
     * @Route("/listRD", name="listRD")
     */
    public function listRD(Request $request, PaginatorInterface $paginator)
    {

        $em = $this->getDoctrine()->getManager();


        $query = $em->createQuery(
            'SELECT r FROM App\Entity\Rewards r
            ORDER BY r.prixR DESC'

        );

        $reclamationEndroit = $query->getResult();

        $reclamationsE = $paginator->paginate($reclamationEndroit, $request->query->getInt('page',1),
            2
        );
        return $this->render('Rewards/listrewards.html.twig', [
            'r' =>$reclamationEndroit,

        ]);

    }

    /**
     * @Route("/listRA", name="listRA")
     */
    public function listRA(Request $request, PaginatorInterface $paginator)
    {

        $em = $this->getDoctrine()->getManager();


        $query = $em->createQuery(
            'SELECT r FROM App\Entity\Rewards r
            ORDER BY r.prixR ASC'

        );

        $reclamationEndroit = $query->getResult();

        $reclamationsE = $paginator->paginate($reclamationEndroit, $request->query->getInt('page',1),
            2
        );
        return $this->render('Rewards/listrewards.html.twig', [
            'r' =>$reclamationEndroit,

        ]);
    }
    /**
     * @Route("/rewards", name="rewards")
     */
    public function index(): Response
    {
        return $this->render('rewards/index.html.twig', [
            'controller_name' => 'RewardsController',
        ]);
    }
    /**
     * @Route("/listRB", name="listRB")
     *
     */
    public function listRB(): Response
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
        $result = $this->getDoctrine()->getRepository(rewards::class);
        $rewards = $result->findall();
        return $this->render('rewards/listrewards.html.twig', [
            'r' =>$rewards,
        ]);
    }
    /**
     * @Route("/afficheRB", name="afficheRB")
     *
     */
    public function afficheRB(): Response
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
        $result = $this->getDoctrine()->getRepository(rewards::class);
        $rewards = $result->findall();
        return $this->render('rewards/index.html.twig', [
            'r' =>$rewards,
        ]);
    }
    /**
     * @Route("/afficheRF", name="afficheRF")
     */
    public function afficheRF(): Response
    {
        $result = $this->getDoctrine()->getRepository(rewards::class);
        $rewards = $result->findall();
        return $this->render('rewards/rewardsFront.html.twig', [
            'r' =>$rewards,
        ]);
    }
    /**
     * @Route("/ajoutR", name="ajoutR")
     */
    public function ajoutR(Request $request): Response
    {
        //creation du formulaire
        $c=new Rewards();
        $form=$this->createForm(RewardsType::class,$c);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $file = $form->get('img')->getData();

            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

            // moves the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName
            );

            $c->setImg($fileName);
            $em=$this->getDoctrine()->getManager();
            $em->persist($c);
            $em->flush();
            return $this->redirectToRoute('afficheRB');
        }
        return $this->render('rewards/ajoutRewards.html.twig', [
            'r' => $form->createView()
        ]);
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
     * @Route("/suppR/{id}", name="suppR")
     */
    public function suppR($id): Response
    {
        $rewards=$this->getDoctrine()->getRepository(rewards::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($rewards);
        $em->flush();
        return $this->redirectToRoute('afficheRB');

    }
    /**
     * @Route("/modifR/{id}", name="modifR")
     */
    public function modifR(Request $request,$id): Response
    {
        //creation du formulaire
        $rewards=$this->getDoctrine()->getRepository(rewards::class)->find($id);
        $form=$this->createForm(RewardsType::class,$rewards);
        $checkout=$form->handleRequest($request);
        if($checkout->isSubmitted()&&$checkout->isValid())
        {
            $file = $form->get('img')->getData();

            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

            // moves the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName
            );

            $rewards->setImg($fileName);
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('afficheRB');
        }
        return $this->render('rewards/ajoutRewards.html.twig', [
            'r' => $form->createView()
        ]);
    }
}
