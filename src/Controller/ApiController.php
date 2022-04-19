<?php

namespace App\Controller;

use App\Entity\Crud;
use App\Repository\CrudRepository;
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

    /**
     * @Route("/api/update_api/{id}", name="update_api", methods={"PUT"})
     */
    public function update_api($id, Request $request, ManagerRegistry $managerRegistry, CrudRepository $crudRepository): Response
    {
        $data = $crudRepository->find($id);
        $parameter = json_decode($request->getContent(), true);

        $data->setTitle($parameter['title']);
        $data->setContent($parameter['content']);

        $em = $managerRegistry->getManager();
        $em->persist($data);
        $em->flush();

        return $this->json(["Modifier avec Success"]);
    }

    /**
     * @Route("/api/delete_api/{id}", name="delete_api", methods={"DELETE"})
     */
    public function delete_api($id, ManagerRegistry $managerRegistry, CrudRepository $crudRepository): Response
    {
        $data = $crudRepository->find($id);

        $em = $managerRegistry->getManager();
        $em->remove($data);
        $em->flush();

        return $this->json(["Supprimer avec Success"]);
    }


}
