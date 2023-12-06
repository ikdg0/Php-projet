<?php

namespace App\Controller;


use App\Entity\Marque;
use App\Form\MarqueType;
use App\Repository\MarqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/marque')]
class MarqueController extends AbstractController
{
    #[Route('/', name: 'app_marque')]
    public function index(MarqueRepository $repository): Response
    {
        $marques=$repository->findAll();
        return $this->render('marque/index.html.twig', [
            "marques"=>$marques
        ]);
    }
    
    #création form 
    #[Route("/new", name:"app_newMarque")]
    public function formAddMarque(Request $request, EntityManagerInterface $manager):Response
    {
        $marques = new Marque();
        $form = $this->createForm(MarqueType::class, $marques);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $marques= $form->getData();
            #dd($marques);

            $manager->persist($marques);
            $manager->flush();

            $this->addFlash("succes", "La marque à bien été créée");

            #return $this->redirectToRoute('app_marque');
        }else {
            
        }
        return $this ->render("marque/new.html.twig",[
            'form'=> $form->createView()
        ]);
    }

    #[Route("/edition/{id}", name:"afficher")]
    public function afficher(MarqueRepository $repository, Marque $marque, Request $request, EntityManagerInterface $em):Response
    {
        
        
        $form= $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $marque = $form->getData();

            $em->persist($marque);
            $em->flush();
            
            $this->addFlash('succes','marque mofidiée');

            
        }
        return $this->render('marque/show.html.twig', [
            "form" => $form->createView()
        ]);
       
    }

    #[Route('/delete/{id}', name: 'delete_marque')]
    public function delete(Marque $marque = null, EntityManagerInterface $em):Response
    {
        if($marque == null){
            $this->addFlash('danger', 'catégorie introuvable');
            return $this-> redirectToRoute('app_marque');
        }

        $em ->remove($marque);
        $em ->flush();

        $this->addFlash('warning', 'Marque supprimée');
        return $this->redirectToRoute('app_marque');
    }
}
