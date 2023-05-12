<?php

namespace App\Controller;

use App\Entity\Gateau;
use App\Entity\Image;
use App\Entity\Ingredient;
use App\Form\GateauType;
use App\Repository\GateauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/index', name: 'app_gateau')]
class GateauController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(GateauRepository $repository): Response
    {


        return $this->render('gateau/index.html.twig', [
            "gateaux"=>$repository->findAll()
        ]);
    }


    #[Route("/create",name: "app_gateau_create")]
    public function create(EntityManagerInterface $manager, Request $request):Response{

        $gateau = new Gateau();

        $formGateau = $this->createForm(GateauType::class,$gateau);

        $formGateau->handleRequest($request);
        if ($formGateau->isSubmitted() && $formGateau->isValid()){


            foreach ($formGateau->getData()->getIngredients() as $ingredient){

                $newIngredient = new Ingredient();
                $newIngredient->setName($ingredient->getName());
                $newIngredient->setGateau($gateau);
            }

            foreach ( $formGateau->getData()->getImages() as $image){

                $newImage = new Image();
                $newImage->setGateau($gateau);
            }





            $manager->persist($gateau);
            $manager->flush();

            return $this->redirectToRoute('app_gateauapp_gateau_show', ['id'=>$gateau->getId()]);
        }

        return $this->renderForm("gateau/create.html.twig",[
            "formGateau"=>$formGateau
        ]);
    }


    #[Route("/show/{id}",name: "app_gateau_show")]
    public function show(Gateau $gateau, ):Response{

        return $this->render("gateau/show.html.twig",[
            "gateau"=>$gateau
        ]);

    }
}
