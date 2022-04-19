<?php

namespace App\Controller;

use App\Entity\Crud;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api")
     */
    public function index(): Response
    {
        return $this->json(['message' => "Bienvenu dans votre controller"]);
    }

    /**
     * @Route("/api/post_api", name="post_api", methods={"POST"})
     */
    public function post_api(Request $request, ManagerRegistry $managerRegistry): Response
    {
        $crud = new Crud();
        $parameter = json_decode($request->getContent(), true);

        $crud->setTitle($parameter['title']);
        $crud->setContent($parameter['content']);
        
        $em = $managerRegistry->getManager();
        $em->persist($crud);
        $em->flush();

        return $this->json(["Inserer avec Success"]);
    }
}
