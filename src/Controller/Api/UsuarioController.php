<?php

namespace App\Controller\Api;
use App\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/api/v1", name="api_v1_usuario_")
 */

class UsuarioController extends AbstractController
{
    /**     
     * @Route("/lista", methods={"GET"}, name="lista")     
     */
    public function lista(): JsonResponse    
    {
        $doctrine = $this->getDoctrine()->getRepository(Usuario::class);

        $data=dump($doctrine->pegarTodos);

        return new JsonResponse($data);
    }

    /**     
     * @Route("/cadastra", methods={"POST"}, name="cadastra")     
     */

    public function cadastra(Request $request): Response
    {
        // Recebendo as informações do POST
        $data = $request->request->all();

        $usuario = new Usuario;

        // Separando as informações do array $data
        $usuario->setNome($data['nome']);
        $usuario->setEmail($data['email']);

        // Publicando no Banco
        $doctrine = $this->getDoctrine()->getManager(); // Chama o SGBD
        $doctrine->persist($usuario); // Prepara as Querys
        $doctrine->flush(); // Executa a Query

        if ( $doctrine->contains($usuario) )
        {
            return new Response("OK",200);
        } 
        else 
        {
            return new Response("ERRO",404);
        }              
    }
}