<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\Users;
use App\Entity\SimpleUserInfo;

class UserController extends AbstractController {

    /**
     * @Route("/users", methods={"GET"})
     */
    public function getUsers(): Response {


        $users = $this->getDoctrine()
        ->getRepository(Users::class)
        ->findAll();
        $users_infos = array();
        
        foreach ($users as &$user) {
            $name = $user->getCompleteName();
            $email = $user->getEmail();
            $obj = new SimpleUserInfo();
            $obj->setName($name);
            $obj->setEmail($email);
            array_push($users_infos, $obj);
        }

        $serializer = $this->get('serializer');
        $data = $serializer->serialize($users_infos, 'json');

        return new Response($data, 200, [
            'Access-Control-Allow-Origin' => '*'
        ]); 
    }

    /**
     * @Route("/users/register", methods={"POST"})
     */
    public function postUsersRegister(Request $request): Response {
        $us = new Users();
        $us->setCompleteName($request->get('complete_name'));
        $us->setPhone($request->get('phone'));
        $us->setBirthday($request->get('birthday'));
        $us->setEmail($request->get('email'));
        $us->setCpf($request->get('cpf'));

        // Hash password (crypt)
        // https://www.php.net/manual/pt_BR/function.password-hash.php
        $hash = password_hash($request->get('password'), PASSWORD_DEFAULT);
        $us->setPassword($hash);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($us);
        $entityManager->flush();

        return new Response("Created!", 201, [
            'Access-Control-Allow-Origin' => '*'
        ]);
    }

    /**
     * @Route("/users/login", methods={"POST"})
     */
    public function postUsersLogin(Request $request): Response  {
        // Request informations
        $email_request = $request->get('email');
        $password_request = strval($request->get('password'));

        // Get password from database
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository(Users::class);
        $user = $repository->findOneBy(['email' => $email_request]);
        
        // https://www.php.net/manual/pt_BR/function.password-verify.php
        if ($user == null) { 
            return new Response("Usuario nao existe!"); 
        } else {            
            $password = strval($user->getPassword());
            
            if (password_verify($password_request, $password)) {
                return new Response("Logado com sucesso!", 202, [
                    'Access-Control-Allow-Origin' => '*'
                ]);
            }else{
                return new Response("Senha incorreta para o login!", 401, [
                    'Access-Control-Allow-Origin' => '*'
                ]); 
            }
        }        
        
    }

}
