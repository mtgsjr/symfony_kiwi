<?php

namespace App\Controller\Request;
namespace App\Controller;

use App\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", name="web_usuario_")
 */

class UsuarioController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="index")
     */
    
     public function index() : Response
    {
        return $this->render("/usuario/form.html.twig");
    }
    
    /**
     * @Route("/salvar", methods={"POST"}, name="salvar")
     */

    public function salvar(Request $request): Response
    {
        // Recebendo as informações do POST
        $data = dump($request->request->all());

        $usuario = new Usuario;

        // Separando as informações do array $data
        $usuario->setNome($data['nome']);
        $usuario->setEmail($data['email']);

        // Publicando no Banco
        $doctrine = $this->getDoctrine()->getManager(); // Chama o SGBD
        $doctrine->persist($usuario); // Prepara as Querys
        $doctrine->flush(); // Executa a Query

        if ( $doctrine->contains($usuario) ){
            return $this->render("usuario/sucesso.html.twig", 
            [
                "fulano" => $data['nome']
            ]);
        } else {
            return $this->render("usuario/erro.html.twig", 
            [
                "fulano" => $data['nome']
            ]);
        }        
    }
}