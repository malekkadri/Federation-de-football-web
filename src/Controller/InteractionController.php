<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Badge;
use App\Entity\User;
use App\Entity\Interaction;
use App\Form\InteractionType;
use App\Form\UserType;
use App\Repository\BadgeRepository;
use App\Repository\InteractionRepository;
use App\Repository\UserRepository;
use App\Services\MailerService;
use App\Services\MessageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class InteractionController extends AbstractController
{
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;

    }
    private $requestStack;
    /**
     * @Route("/interaction{id}", name="interaction")
     */
    public function index($id,Request $request): Response
    {

        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        $x = $id;

        $interaction = new Interaction();
        $session = $this->requestStack->getSession();
        $tab =  $session->get('user');
        if($tab == null)
        {
            $user_id = null;
        }
        else
        {
            $user_id =reset($tab);
        }

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $user_id]);
        /*
        $interaction->setArticle($article);
        $interaction->setUser($user);
        $interaction->setType('comment');
        $user = $this->getDoctrine()->getRepository(User::class)->find($article->getUser()->getId());

        $emuser= $usercontroller->getDoctrine()->getManager();
        $nbp =  $user->getNbp() + 1 ;
        $badges = $badgeRepository->findByResult($nbp);
        $badge = reset($badges);

        $user->setNbp($nbp);
        $user->setBadge($badge);
        $emuser->persist($user);
        $emuser->flush();
        */
        $form = $this->createForm(InteractionType::class, $interaction);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($interaction);
            $em->flush();

            return $this->redirectToRoute('interaction', [
                'id' =>$id,
            ]);
        }

        return $this->render('interaction/index.html.twig', [
            'a' =>$article,'comments'=>$article->getInteraction(),'fb'=>$form->createView(),'us'=>$user,'x'=>7,
        ]);

    }
    /**
     * @Route("/listinteractions{id}", name="listinteractions")
     */
    public function listinteractions($id,UserController $userController,BadgeRepository $badgeRepository): Response
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        $x = $id;
        $session = $this->requestStack->getSession();
        $tab =  $session->get('user');
        $user = $article->getUser();
        $emuser= $userController->getDoctrine()->getManager();
        $nbp =  $user->getNbp() ;
        $badges = $badgeRepository->findByResult($nbp);
        $badge = reset($badges);

        $user->setNbp($nbp);
        $user->setBadge($badge);
        $emuser->persist($user);
        $emuser->flush();

       // $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $user_id]);
        return $this->render('interaction/listinteractions.html.twig', [
            'a' =>$article,'comments'=>$article->getInteraction(),'us'=>$tab,'x'=>$x
        ]);
    }

    /**
     * @Route("/updateComment{id}/{idc}/{reply}", name="updateComment")
     */
    public function updateComment(Request $request,$id,$idc,$reply)
    {
//je récupère la classe à modifier
        $interaction=$this->getDoctrine()->getRepository(Interaction::class)->find($idc);
//récupération du formulaire
        $form = $this->createForm(InteractionType::class, $interaction);
        $session = $this->requestStack->getSession();
        $user_id = $session->get('user')[0];
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $user_id]);
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
//récupérer les données saisies dans les champs
        $form->handleRequest($request);
       // if ($form->isSubmitted() && $form->isValid())
       // {
            $em = $this->getDoctrine()->getManager();
            $interaction->setDescrp($reply);
            $em->persist($interaction);
            $em->flush();
        return $this->redirectToRoute('interaction', [
            'id' =>$id,
        ]);

       // }

    }
    /**
     * @Route("/delComment{id}/{idc}", name="delComment")
     */
    public function delComment($id,$idc): Response
    {
        $interaction = $this->getDoctrine()->getRepository(Interaction::class)->find($idc);
        $er=$this->getDoctrine()->getManager();
        //suppression
        $er->remove($interaction);
        //effectuer la supp
        $er->flush();
        return $this->redirectToRoute('interaction', [
            'id' =>$id,
        ]);
    }
    /**
     * @Route("/addComment{id}/{reply}", name="addComment")
     */
    public function addComment(Request $request,$id,$reply,UserController $usercontroller,BadgeRepository  $badgeRepository): Response
    {
        $r=$this->getDoctrine()->getRepository(Interaction::class);

        $interaction = new Interaction();
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        $session = $this->requestStack->getSession();
        $user_id = $session->get('user')[0];
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $user_id]);
       // $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => 1]);
        $interaction->setArticle($article);
        $interaction->setUser($user);

        $interaction->setType('comment');
        $interaction->setDescrp($reply);
        $form = $this->createForm(InteractionType::class, $interaction);
        $form->handleRequest($request);
      //  if ($form->isSubmitted() && $form->isValid() ) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($interaction);
            $em->flush();
            $emuser= $usercontroller->getDoctrine()->getManager();
           $nbp =  $user->getNbp() + 1 ;
           $badges = $badgeRepository->findByResult($nbp);
        $badge = reset($badges);

           $user->setNbp($nbp);
           $user->setBadge($badge);
            $emuser->persist($user);
            $emuser->flush();


        //}

        return $this->render('interaction/addComment.html.twig', [
            'a' =>$article,'comments'=>$article->getInteraction(),'fb'=>$form->createView(),'us'=>$user,
            'x'=>$id,
        ]);

    }
    /**
     * @Route("/addReply{id}/{idc}/{reply}", name="addReply")
     * @param Request $request
     * @param MessageService $messageService
     * @param MailerService $mailService
     */
    public function addReply(Request $request,$id,$idc,$reply, MessageService $messageService,
                             MailerService     $mailerService ,UserController $usercontroller,BadgeRepository  $badgeRepository): Response
    {

        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        $owner = $article->getUser();
        $interaction = new Interaction();
        $session = $this->requestStack->getSession();
        $user_id = $session->get('user')[0];
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $user_id]);
        $interaction->setArticle($article);
        $interaction->setUser($user);
        $interaction->setType('reply?'.$idc);
        $interaction->setDescrp($reply);
        $form = $this->createForm(InteractionType::class, $interaction);
        $form->handleRequest($request);
    //    if ($form->isSubmitted() && $form->isValid() ) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($interaction);
            $em->flush();
        $emuser= $usercontroller->getDoctrine()->getManager();
        $nbp =  $user->getNbp() + 1 ;
        $badges = $badgeRepository->findByResult($nbp);
        $badge = reset($badges);

        $user->setNbp($nbp);
        $user->setBadge($badge);
        $emuser->persist($user);
        $emuser->flush();
        $mailerService->send(
            "Article[Reply]",
            "onep1981@gmail.com",
            $owner->getEmail(),
            " 
A lot has happened on our Website since you last logged in .
".$user->getUsername()." Replied to your comment "

        );

            return $this->redirectToRoute('interaction', [
                'id' =>$id,
            ]);
        //}
        //else
        //{
        //   dump($form);
        //  }
        return $this->render('interaction/addReply.html.twig', [
            'a' =>$article,'comments'=>$article->getInteraction(),'fb'=>$form->createView(),'us'=>$user,
        ]);

    }

    /**
     * @Route("/addL{id}", name="addL")
     */
    public function addL(Request $request,$id): Response
    {

        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        $interaction = new Interaction();
        $session = $this->requestStack->getSession();
        $user_id = $session->get('user')[0];
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $user_id]);
        $interaction->setArticle($article);
        $interaction->setUser($user);
        $interaction->setType('up');
        $interaction->setDescrp('');
        //$form = $this->createForm(InteractionType::class, $interaction);
        //$form->handleRequest($request);
        // if ($form->isSubmitted() && $form->isValid() ) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($interaction);
        $em->flush();

        return $this->redirectToRoute('interaction', [
            'id' =>$id,
        ]);



    }
    /**
     * @Route("/removeL{id}", name="removeL")
     */
    public function removeL(Request $request,$id,InteractionRepository $i ,UserRepository $UserRepository): Response
    {

        //
        $session = $this->requestStack->getSession();
        $user_id = $session->get('user')[0];
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $user_id]);
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        $inter = $i->findByResult($article->getid(),$user->getid(),'up');
        $interaction = $this->getDoctrine()->getRepository(Interaction::class)->find($inter);
        $er=$this->getDoctrine()->getManager();
        $er->remove($interaction);
        $er->flush();
        return $this->redirectToRoute('interaction', [
            'id' =>$id,
        ]);

    }



}