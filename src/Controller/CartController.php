<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RouteCollectione;
use MongoDB\Driver\Session;
use Symfony\Component\Security\Http\Util\TargetPathTrait;


class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function index(SessionInterface $session,SessionInterface  $session2,
                          SessionInterface $session3,
                          ProduitRepository $produitRepository,SessionInterface $session10,
                          SessionInterface $session11,SessionInterface $s): Response
    {

        $panier=$session->get('commande',[]);

        $get=$session2->get('abc');
        $get2=$session3->get('cba');



        $panierWithData=[];
        foreach ($panier as $id=>$quantity){

            $panierWithData[]=[
                'product'=>$produitRepository->find($id),
                'quantity'=>$get2,
                'taille'=>$get


            ];


        }

$total =0;
        foreach ($panierWithData as $item) {
            if($item['product']!=null) {
                $totaItem = $item['product']->getprix() * $item['quantity'];
                $total += $totaItem;
            }
        }


        $session10->set('panier',$panierWithData);
        $session11->set('total',$total);

       // $this->index2($session10,$session11);

        return $this->render('cart/index.html.twig', [
            'items'=> $panierWithData,
            'total'=>$total

        ]);
    }


    /**
     * @Route("/cart2", name="cart2")
     */
    public function index2(SessionInterface $session,SessionInterface  $session2,
                           SessionInterface $session3,
                           ProduitRepository $produitRepository,SessionInterface $session10,
                           SessionInterface $session11,SessionInterface $s
                           ): Response
    {

        $panier=$session->get('commande',[]);

        $get=$session2->get('abc');
        $get2=$session3->get('cba');



        $panierWithData=[];
        foreach ($panier as $id=>$quantity){

            $panierWithData[]=[
                'product'=>$produitRepository->find($id),
                'quantity'=>$get2,
                'taille'=>$get


            ];


        }

        $total =0;
        foreach ($panierWithData as $item) {
            if($item['product']!=null) {
                $totaItem = $item['product']->getprix() * $item['quantity'];
                $total += $totaItem;
            }
        }


        $session10->set('panier',$panierWithData);
        $session11->set('total',$total);

        // $this->index2($session10,$session11);

        return $this->render('cart.html.twig', [
            'items'=> $panierWithData,
            'total'=>$total

        ]);
    }



    /**
     * @Route ("commande/add",name="cart_add")
     */

    public  function add(SessionInterface $session,SessionInterface $s,SessionInterface $session2,SessionInterface $session3,ProduitRepository $produitRepository)
    {


        $panier=$session->get('commande',[]);


if(isset($_GET['taille'])) {

    $get = $_GET['taille'];
        $session2->set('abc', $_GET['taille']);
}

        if(isset($_GET['taille2'])) {

            $get = $_GET['taille2'];
                $session2->set('abc', $_GET['taille2']);
        }

        if(isset($_GET['quantite'])) {

            $get2 = $_GET['quantite'];
                $session3->set('cba', $_GET['quantite']);
        }









            if(!empty($panier[$_GET['id']])){
                $panier[$_GET['id']]++;



            }
            else{$panier[$_GET['id']]=1;}



            $session->set('commande',$panier);




        return $this->redirectToRoute("affichef");


    }

    /**
     * @Route("commande/remove/{id}" ,name="cart_remove")
     */
    public function remove($id,SessionInterface $session,Request $request):Response
    {

      //  $path=$request->getPathInfo();
      //  $requestUri=$request->getRequestUri();

       // $url=str_replace($path,rtrim($path, ' /'),$requestUri);

         $panier=$session->get('commande',[]);

         if (!empty($panier[$id]))
         {
             unset($panier[$id]);
         }

         $session->set('commande',$panier);



        return $this->redirectToRoute("cart2");

    }







    /**
     * @Route("commande/remove2" ,name="cart_remove2")
     */
    public function remove2(SessionInterface $session)
    {
        $panier=$session->get('commande',[]);

        if (!empty($panier))
        {
          $panier=  array_diff($panier,$panier);
        }

        $session->set('commande',$panier);



        return $this->redirectToRoute("affichef");

    }
}
