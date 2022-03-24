<?php

namespace App\Controller;
use App\Entity\Classement;
use App\Entity\Game;
use App\Entity\Rewards;
use App\Entity\Produit;
use App\Entity\Stade;
use App\Entity\Joueur;
use App\Entity\Tournoi;
use App\Form\UserType;
use App\Repository\BadgeRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Entity\User;
use App\Entity\Badge;
use App\Entity\Sponsor;
use App\Form\BadgeType;
use App\Repository\JoueurRepository;
use App\Repository\GameRepository;
use Symfony\Component\String\Slugger\AsciiSlugger;
class UserController extends AbstractController
{
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    private $requestStack;
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboard() : Response
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
          //  return $this->redirect('http://127.0.0.1:8000/user');
            return $this->redirectToRoute('user');

        }
        else
        {
            return $this->render('BaseBack.html.twig');
          // return $this->redirectToRoute('article');

        }

        //recuperer le repository pour utiliser la fonction findAll


    }

    /**
     * @Route("/Sess", name="Sess")
     */
    public function Sess(): Response
    {
        $session = $this->requestStack->getSession();
        return $this->render('user/sess.html.twig', [
        'user' =>$session->get('user')]);
    }
    /**
     * @Route("/shpuser", name="shpuser")
     */
    public function shpuser(): Response
    {
        $session = $this->requestStack->getSession();
        return $this->render('user/showuserprofile.html.twig', [
            'user' =>$session->get('user')]);
    }
    /**
     * @Route("/loginwarp", name="loginwarp")
     */
    public function loginwarp(): Response
    {

        return $this->render('user/loginwrap.html.twig') ;
    }
    /**
     * @Route("/user", name="user")
     */
    public function index(JoueurRepository $i,JoueurRepository $x,GameRepository $g): Response
    {
        //recuperer le repository pour utiliser la fonction findAll
        //$session = $this->requestStack->getSession();
        $session = $this->requestStack->getSession();
        $r=$this->getDoctrine()->getRepository(Game::class);
        $rewards=$this->getDoctrine()->getRepository(Rewards::class);
        $rews = $rewards->findAll();
        $rewardss=$this->getDoctrine()->getRepository(Produit::class);
        $rewss = $rewardss->findAll();
        $spon=$this->getDoctrine()->getRepository(Sponsor::class);
        $sponn = $spon->findAll();
        $games=$r->findAll();
        $r=$this->getDoctrine()->getRepository(User::class);

        $i = $i->findByResultam();

        $x = $x->findByResultaa();

        $g = $g->findByResultaaa();


        //faire appel a la fonction findAll
        $user=$r->findAll();
        return $this->render('BaseFront.html.twig', [
            'b' =>$user,
            'e' =>$games,
            'j' =>$i,
            'x' =>$x,
            'r' =>$rews,
            'p' =>$rewss,
            'sp' =>$sponn,
            'z' =>$g,


        ]);



    }
    /**
     * @Route("/addUser", name="addUser")
     */
    public function addUser(Request $request): Response
    {
        //récupération du formulaire
        $user = new User();
        $slugger = new AsciiSlugger();
        $form = $this->createForm(userType::class, $user);
        /*Ajout du boutton dans l'action
        $form->add('Ajouter',SubmitType::class);*/
//récupérer les données saisies dans les champs
        $form->handleRequest($request);
        $br = 'uploads/img';
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $brochureFile */

            $brochureFile = $form->get('img')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $br,
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $user->setImg($newFilename);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user');
        }
        return $this->render("user/addUser.html.twig",
            array('fb'=>$form->createView()));
    }
    /**
     * @Route("/statb{id}", name="statb")
     */
    public function statb($id,BadgeRepository $b): Response
    {
        //recuperer le repository pour utiliser la fonction findAll
        $r=$this->getDoctrine()->getRepository(Badge::class);
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $next_badges  = $b->findByResulta($user->getNbp());

        if(count($next_badges)  ==0 )
        {
            $next_badges= $user->getBadge();
            $percentage = 100 ;
        }
        else
            {
                $percentage = ($user->getNbp() / $next_badges[0]->getNb())*100 ;
            }

        //faire appel a la fonction findAll
       // $badges=$r->findAll();
        return $this->render('badge/stat.html.twig', [
            'p'=>$percentage
        ]);
    }

    /**
     * @Route("/UserRegister", name="UserRegister")
     */
    public function UserRegister(Request $request): Response
    {
        //récupération du formulaire
        $user = new User();
        $slugger = new AsciiSlugger();
        $badge  = $this->getDoctrine()->getRepository(Badge::class)->findOneBy(['id' => 1]);

        $form = $this->createForm(UserType::class, $user);

        // $user->setBadge(1);
        /*Ajout du boutton dans l'action
        $form->add('Ajouter',SubmitType::class);*/
//récupérer les données saisies dans les champs

        $form->handleRequest($request);
        $br = 'uploads/img';

        if ($form->isSubmitted() ) {

            $user->setImg("avatar.png");
            $user->setRole("client");
            $user->setNbp(0);
            $user->setBadge($badge);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('login');
        }
        return $this->render("user/registration.html.twig",
            array('fb'=>$form->createView()));
    }
    /**
     * @Route("/deleteUser/{id}", name="deleteUser")
     */
    public function supp($id): Response
    {
        //recupperer
        $classrooms = $this->getDoctrine()->getRepository(User::class)->find($id);
        $er=$this->getDoctrine()->getManager();
        //suppression
        $er->remove($classrooms);
        //effectuer la supp
        $er->flush();
        return $this->redirectToRoute("afficheU");
    }

    /**
     * @Route("/updateUser/{id}", name="updateUser")
     */
    public function updateUser(Request $request,$id)
    {
//je récupère la classe à modifier
        $user=$this->getDoctrine()
            ->getRepository(User::class)->find($id);
//récupération du formulaire
        $form = $this->createForm(UserType::class, $user);
//récupérer les données saisies dans les champs
        $form->handleRequest($request);
        $br = 'uploads/img';
        $slugger = new AsciiSlugger();
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $brochureFile */

            $brochureFile = $form->get('img')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $br,
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $user->setImg($newFilename);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('afficheU');
        }
        return $this->render('user/updateUser.html.twig',['fb' => $form->createView()]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login()
    {
        return $this->render('user/login.html.twig');
    }
    /**
     * @Route("/cnx", name="cnx")
     */
    public function cnx(Request $request)
    {
        $username=$request->request->get('_username');
        $mdp=$request->request->get('_mdp');
        $em=$this->getDoctrine();
        $tab=$em->getRepository(User::class)->findUserLogin($username , $mdp);
        if (count($tab)==0){
            return $this->redirectToRoute('login');

        }
        else
        {
            $session = $this->requestStack->getSession();
            $user = reset($tab);
            $session->set('user', $user);
            $tabu=[$user->getId(),$user->getUsername(),$user->getImg(),$user->getRole()];
            $session->set('user', $tabu);
            return $this->redirectToRoute('user');

        }



    }
    /**
     * @Route("/logout", name="logout")
     */
    public function logout(Request $request)
    {



            $session = $this->requestStack->getSession();
            $session->set('user', null);

        $session->set('total',0);
        return $this->redirectToRoute('user');





    }
    /**
     * @Route("/statu", name="statu")
     */
    public function statu(PaginatorInterface $paginator,Request  $request): Response
    {

        $result = $this->getDoctrine()->getRepository(User::class);
        $users = $result->findall();


        return $this->render('user/statu.html.twig', [
            'users' =>$users,
        ]);
    }
    /**
     * @Route("/afficheU", name="afficheU")
     */
    public function afficheU(PaginatorInterface $paginator,Request  $request): Response
    {

        $result = $this->getDoctrine()->getRepository(User::class);
        $users = $result->findall();
        $p=$paginator->paginate(
            $users,
            $request->query->getInt('page',1),
            4
        );

        return $this->render('user/index.html.twig', [
            'users' =>$p,
        ]);
    }
}
