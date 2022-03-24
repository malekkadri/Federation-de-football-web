<?php

namespace App\Controller;
use App\Entity\User;
use ContainerDsHILo7\PaginatorInterface_82dac15;
use DateTime;
use App\Entity\Categorie;
use App\Entity\Produit;
use App\Form\CategorieType;
use App\Form\ProduitType;
use App\Repository\CathegorieRepository;
use App\Repository\MarquesRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\isSubmitted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Marques;
use App\Form\UpdatePType;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\Json;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


class ProduitController extends AbstractController
{
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    private $requestStack;



    /**
     * @Route("/searchp/{searchString}", name="searchp")
     */
    public function searchp($searchString,SerializerInterface $serializerInterface ,PaginatorInterface $paginator,Request $request)
    {
        //$serializer=new Serializer([new ObjectNormalizer()]);
        // $serializer = new Serializer([new ObjectNormalizer()]);
        $repository = $this->getDoctrine()->getRepository(Produit::class);
        // $students = $repository->findByid($searchString);
        //$students = $repository->findBy(array('id' => '%'.'2'));

        $students = $repository->findByExampleField($searchString);
        $p=$paginator->paginate(
            $students,
            $request->query->getInt('page',1),
            2
        );
        $data = $serializerInterface->normalize($p,'json',['groups'=>'prod']);
        // $data=$serializer->normalize("");

        return new JsonResponse($data);
    }


    /**
     * @Route("/produit", name="produit")
     */
    public function index(ProduitRepository $repository): Response
    {
       $now= new \DateTime('@'.strtotime('now'));
        $date=$repository->findAll();
        $t=[];
        $x= new DateTime();
        foreach ($date as $test)
        {
           $a= $x->setTimestamp(strtotime($test->getDateAjout()->format('Y-m-d H:i:s')));


           if($a->modify('+10 day') > $now) {


               $t[] = ['product' => $repository->find($test->getId())];
           }

            }




        return $this->render('new.html.twig',['date'=>$t]);
    }

    /**
     * @Route("/ajoutp", name="ajoutp")
     */
    public function ajoutp(Request $request): Response
    {
        $c=new Produit();
        $slugger = new AsciiSlugger();
        $br = 'uploads/img';
        $form=$this->createForm(ProduitType::class,$c);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
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
                $c->setImg($newFilename);
            }

            $c->setDateAjout(new \DateTime('@'.strtotime('now')));
            $em=$this->getDoctrine()->getManager();
            $em->persist($c);
            $em->flush();
             return $this->redirectToRoute("affichep");

        }

        return $this->render('produit/ajout_produit.html.twig', [ 'f'=>$form->createView()]);

    }

    /**
     * @Route("/affichep", name="affichep")
     */
    public function affichep(ProduitRepository $repository): Response
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
        $r=$this->getDoctrine()->getRepository(Produit::class);
        $p=$r->findAll();
        $search=$repository->searchProduit();
        return $this->render('Produit/index.html.twig',
            ['c'=>$p, 'qte'=>$search
        ]);
    }



    /**
     * @Route("/affichenot", name="affichenot")
     */
    public function affichenot(ProduitRepository $repository): Response
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
        $r=$this->getDoctrine()->getRepository(Produit::class);
        $p=$r->findAll();
        $search=$repository->searchProduit();
        return $this->render('Produit/notify.html.twig',
            [ 'qte'=>$search
            ]);
    }



    /**
     * @Route("/modifp/{id}", name="modifp")
     */
    public function modifp(Request $request,$id): Response
    {
        $slugger = new AsciiSlugger();
        $br = 'uploads/img';

        $class=$this->getDoctrine()->getRepository(Produit::class)->find($id);


        $form=$this->createForm(ProduitType::class,$class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();

            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('img')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $br,
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
            }
                $class->setImg($newFilename);

            $em->flush();
            return $this->redirectToRoute("affichep");
        }

        return $this->render('Produit/modif_produit.html.twig', [ 'f'=>$form->createView()]);



    }


    /**
     *
     * @Route("/suppp/{id}", name="suppp")
     */
    public function suppp($id): Response
    {
        $class=$this->getDoctrine()->getRepository(Produit::class)->find($id);
        $d=$this->getDoctrine()->getManager();
        $d->remove($class);
        $d->flush();
        return $this->redirectToRoute("affichep");

    }


    /**
     * @Route("/affichef", name="affichef")
     */
    public function affichef(CathegorieRepository $repository,ProduitRepository $pr,Request $request,PaginatorInterface $paginator): Response
    {
        
        $verif=0;
        $cat=$repository->findAll();
        //$r=$this->getDoctrine()->getRepository(Produit::class);
        $donnes=$pr->findAll();
        $p=$paginator->paginate(
            $donnes,
            $request->query->getInt('page',1),
            2
        );

        $count=$pr->counts();





        return $this->render('produit/store.html.twig', ['c'=>$p,'cat'=>$cat,'verif'=>$verif
        ]);
    }

    /**
     * @Route("/find{id}", name="find")
     */

    public function find($id,Request $request,ProduitRepository $repository,CathegorieRepository $repository2,PaginatorInterface $paginator)
{

    $search=$repository->searchProduit_categorie($id);
    $cat=$repository2->findAll();





    if(isset($_GET['prix1']))
    {
        $search=$repository->filter($id);


    }

    if(isset($_GET['prix2']))
    {
        $search=$repository->filter2($id);
    }

    if(isset($_GET['red']))
    {
        $search=$repository->filter3($id,'rouge');
    }

    if(isset($_GET['white']))
    {
        $search=$repository->filter4($id,'blanc');
    }
    if(isset($_GET['black']))
    {
        $search=$repository->filter5($id,'noire');
    }


    if(isset($_GET['white']) && isset($_GET['prix1']) )
    {
        $search=$repository->filter6($id,'blanc');
    }

    if(isset($_GET['white']) && isset($_GET['prix2']) )
    {
        $search=$repository->filter7($id,'blanc');
    }


    if(isset($_GET['black']) && isset($_GET['prix1']) )
    {
        $search=$repository->filter8($id,'noire');
    }

    if(isset($_GET['black']) && isset($_GET['prix2']) )
    {
        $search=$repository->filter9($id,'noire');
    }



    $p=$paginator->paginate(
        $search,
        $request->query->getInt('page',1),
        2
    );


    return $this->render('produit/store.html.twig',['c'=>$p,'cat'=>$cat,'verif'=>$id]);


}

    /**
     * @Route("/product_page{id}", name="product_page")
     */
    public function product_page($id): Response
    {
        $r=$this->getDoctrine()->getRepository(Produit::class);
        $p=$r->find($id);
        return $this->render('product.html.twig', ['c'=>$p
        ]);
    }

    /**
     * @Route("/notification{id}", name="notification")
     */
    public function notification($id,Request $request,ProduitRepository $repository):Response
    {
        $r=$this->getDoctrine()->getRepository(Produit::class);
        $c=$r->find($id);

       $p=$repository->find($id);
        $em=$this->getDoctrine()->getManager();

        $form=$this->createForm(UpdatePType::class);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $x=$form->getData();
            foreach ($x as $qte) {
                $i=(int)$qte;
                $c->setQte($i);
            }
        if($p->getId()==$id) {
            $c->setNomP($p->getNomP());
            $c->setMarquep($p->getMarquep());
            $c->setTaille($p->getTaille());
            $c->setTaille2($p->getTaille2());
            $c->setDescr($p->getDescr());
            $c->setPrix($p->getPrix());
            $c->setImg($p->getImg());
            $c->setDateAjout($p->getDateAjout());
            $c->setCouleur($p->getCouleur());
            $c->setCategorie($p->getCategorie());
        }

            $em->persist($c);
            $em->flush();
            return $this->redirectToRoute("affichep");
        }



        return $this->render('produit/modif_notif.html.twig',
            [ 'f'=>$form->createView(),'id'=>$p->getId() ]);
    }






    /**
     * @Route("/gets", name="gets")
     */
    public function gets(ProduitRepository $repository,SerializerInterface $serializer){
        $student=$repository->findAll();
        $json=$serializer->serialize($student,'json',['groups'=>'student']);
dump($json);
die;
    }

    /**
     * @Route("/addp", name="addp")
     */

    public function addp(Request $request, NormalizerInterface  $serializer , EntityManagerInterface $em)
    {
        $badge = new Produit();

        $nom = $request->query->get("nomP");
        $taille1 = $request->query->get("taille1");
        $taille2 = $request->query->get("taille2");
        $couleur=  $request->query->get("couleurP");
        $prix=     $request->query->get("prixP");
        $descr=    $request->query->get("descrP");
        $qte=      $request->query->get("quantiteP");
        $img=      $request->query->get("imageP");
        $date=    new \DateTime('now');
        $categorie=$request->query->get("categorieP");
        $marque=   $request->query->get("marqueP");

        $m=$this->getDoctrine()->getManager()->getRepository(Categorie::class)->find($request->get("categorieP"));
        $m2=$this->getDoctrine()->getManager()->getRepository(Marques::class)->find($request->get("marqueP"));


        $em = $this->getDoctrine()->getManager();

        $badge->setNomP($nom);
        $badge->setTaille($taille1);
        $badge->setTaille2($taille2);
        $badge->setCouleur($couleur);
        $badge->setPrix($prix);
        $badge->setDescr($descr);
        $badge->setQte($qte);
        $badge->setImg($img);
        $badge->setDateAjout($date);
        $badge->setCategorie($m);
        $badge->setMarquep($m2);
        $em->persist($badge);
        $em->flush();

        //$serializer = new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($badge,'json',['groups'=>'prod']);
        return new JsonResponse($formatted);
    }

    /**
     * @Route("/getp", name="getp")
     */
    public function getp(ProduitRepository  $repository,NormalizerInterface $serializer){
        //$marque=$this->getDoctrine()->getManager()->getRepository(Marques::class)->findAll();
        $rep= $this->getDoctrine()->getRepository(Produit::class);
        $marque=$rep->findAll();
        $formatted=$serializer->normalize($marque,'json',['groups'=>'prod']);

        return new  Response(json_encode($formatted));
    }
}
