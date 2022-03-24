<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Interaction;
use App\Entity\Tournoi;
use App\Entity\User;
use App\Form\ArticleType;
use App\Form\InteractionType;
use App\Repository\BadgeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;
class ArticleController extends AbstractController
{

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    private $requestStack;

    /**
     * @Route("/listA", name="listA")
     */
    public function listA(Request $request, PaginatorInterface $paginator)
    {

        $r=$this->getDoctrine()->getRepository(Article::class);

        //faire appel a la fonction findAll
        $articles=$r->findAll();

        $reclamationsE = $paginator->paginate($articles, $request->query->getInt('page',1),
            3
        );
        return $this->render('article/listarticles.html.twig', [
            'a' =>$reclamationsE,

        ]);

    }
    /**
     * @Route("/triRD", name="triRD")
     */
    public function triRD(Request $request, PaginatorInterface $paginator)
    {

        $em = $this->getDoctrine()->getManager();


        $query = $em->createQuery(
            'SELECT p FROM App\Entity\Article p 
            ORDER BY p.descr DESC'

        );

        $ar = $query->getResult();

        $are = $paginator->paginate($ar, $request->query->getInt('page',1),
            3
        );
        return $this->render('article/listarticles.html.twig', [
            'a' =>$are,

        ]);

    }

    /**
     * @Route("/triRA", name="triRA")
     */
    public function triRA(Request $request, PaginatorInterface $paginator)
    {


        $em = $this->getDoctrine()->getManager();


        $query = $em->createQuery(
            'SELECT p FROM App\Entity\Article p 
            ORDER BY p.descr ASC'

        );

        $ar = $query->getResult();
        $are = $paginator->paginate($ar, $request->query->getInt('page',1),
            3
        );
        return $this->render('article/listarticles.html.twig', [
            'a' =>$are,

        ]);
    }
    /**
     * @Route("/triRDN", name="triRDN")
     */
    public function triRDN(Request $request, PaginatorInterface $paginator)
    {

        $em = $this->getDoctrine()->getManager();


        $query = $em->createQuery(
            'SELECT p FROM App\Entity\Article p 
            ORDER BY p.titre DESC'

        );

        $ar = $query->getResult();

        $are = $paginator->paginate($ar, $request->query->getInt('page',1),
            3
        );
        return $this->render('article/listarticles.html.twig', [
            'a' =>$are,

        ]);

    }

    /**
     * @Route("/triRAN", name="triRAN")
     */
    public function triRAN(Request $request, PaginatorInterface $paginator)
    {


        $em = $this->getDoctrine()->getManager();


        $query = $em->createQuery(
            'SELECT p FROM App\Entity\Article p 
            ORDER BY p.titre ASC'

        );

        $ar = $query->getResult();
        $are = $paginator->paginate($ar, $request->query->getInt('page',1),
            3
        );
        return $this->render('article/listarticles.html.twig', [
            'a' =>$are,

        ]);
    }
    /**
     * @Route("/searchx/{searchString}", name="searchx")
     */
    public function searchx($searchString,SerializerInterface $serializerInterface ,PaginatorInterface $paginator,Request $request)
    {
        //$serializer=new Serializer([new ObjectNormalizer()]);
        // $serializer = new Serializer([new ObjectNormalizer()]);
        $repository = $this->getDoctrine()->getRepository(Article::class);
        // $students = $repository->findByid($searchString);
        //$students = $repository->findBy(array('id' => '%'.'2'));

        $students = $repository->findByExampleField($searchString);
        $p=$paginator->paginate(
            $students,
            $request->query->getInt('page',1),
            3
        );
        $data = $serializerInterface->normalize($p,'json',['groups'=>'student']);
        // $data=$serializer->normalize("");

        return new JsonResponse($data);
    }
    /**
     * @Route("/article", name="article")
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
        //recuperer le repository pour utiliser la fonction findAll
        $r=$this->getDoctrine()->getRepository(Article::class);

        //faire appel a la fonction findAll
        $articles=$r->findAll();

        return $this->render('article/index.html.twig', [
            'a' =>$articles,
        ]);
    }
    /**
     * @Route("/addArticle", name="addArticle")
     */
    public function addArticle(Request $request): Response
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
        $slugger = new AsciiSlugger();
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $article->setDatea(new \DateTime('@'.strtotime('now')));
        $br = 'uploads/img';
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ) {

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
                $article->setImg($newFilename);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('article');
        }
        else
        {
           dump($form);
          }
        return $this->render("article/addArticle.html.twig",
            array('fb'=>$form->createView(),));
    }

    /**
     * @Route("/deleteArticle/{id}", name="deleteArticle")
     */
    public function deleteArticle($id): Response
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
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        $er=$this->getDoctrine()->getManager();
        //suppression
        $er->remove($article);
        //effectuer la supp
        $er->flush();
        return $this->redirectToRoute("article");
    }

    /**
     * @Route("/updateArticle/{id}", name="updateArticle")
     */
    public function updateArticle(Request $request,$id)
    {
        $session = $this->requestStack->getSession();
        $user = $session->get('user');
        $br = 'uploads/img';
        $slugger = new AsciiSlugger();
        if($user == null )
            return $this->redirectToRoute('login');
        $user =  $this->getDoctrine()->getRepository(User::class)->findOneBy(['id'=>$user[0]]);
        if($user == null )
            return $this->redirectToRoute('login');

        if($user->getRole() == 'client' )
        {
            return $this->redirectToRoute('user');
        }
//je récupère la classe à modifier
        $article=$this->getDoctrine()
            ->getRepository(Article::class)->find($id);
//récupération du formulaire
        $form = $this->createForm(ArticleType::class, $article);
//récupérer les données saisies dans les champs
        $form->handleRequest($request);
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
                $article->setImg($newFilename);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('article');
        }
        return $this->render('article/updateArticle.html.twig',['fb' => $form->createView()]);
    }

    /**
     * @Route("/viewArticleS", name="viewArticleS")
     */
    public function ViewArticleS(PaginatorInterface $paginator,Request $request,SerializerInterface $serializer): Response
    {
        //recuperer le repository pour utiliser la fonction findAll
        $r=$this->getDoctrine()->getRepository(Article::class);

        //faire appel a la fonction findAll
        $articles=$r->findAll();
        $p=$paginator->paginate(
            $articles,
            $request->query->getInt('page',1),
            3
        );


     //  $result = $this->getDoctrine()->getRepository(tournoi::class);

        // $data=$serializer->normalize("");


        return $this->render('article/viewArticlesF.html.twig', [
            'a' =>$p,

        ]);
    }
    /**
     * @Route("/viewArticle{id}", name="viewArticle")
     */
    public function ViewArticle(Request $request,$id)
    {
        //recuperer le repository pour utiliser la fonction findAll

        $r=$this->getDoctrine()->getRepository(Article::class);
        $article=$r->find($id);





       return $this->render('article/viewArticleF.html.twig', [
          'a' =>$article,
        ]);
    }

}
