<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IntroController extends Controller
{
    /**
     * @Route("/intro", name="intro")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        return $this->render('intro/index.html.twig', [
            'controller_name' => 'IntroController',
        ]);
    }
    
    /**
     * @route("/test")
     */
    public function test()
    {
        //retourne une reponse en texte brut équivalent à echo 'test';
        return new Response('test');
    }
    
    /**
     * @Route("/")  //par défaut le name sera : app_intro_indexbis
     */
    public function indexBis()
    {
        return $this->render('intro/index.html.twig', [
            'controller_name' => 'My Controller',
        ]);
    }
    /**
     * @Route("/hello/{name}")
     * 
     */
    public function hello($name)
    {
        return $this->render('intro/hello.html.twig',
                ['nom' =>$name]
        );
    }
    /**
     * @Route("/hi/{firstname}-{lastname}", defaults={"lastname":""})
     * 
     */
    public function hi($firstname, $lastname)
    {
        $name = $firstname;
        if(!empty($lastname)) {
            $name .= ' '.$lastname;
        }
        return $this->render('intro/hello.html.twig',
                ['nom' =>$name]
        );
    }
    /**
     * @Route("/twig")
     * 
     */
    public function twig()
    {
        return $this->render('intro/twig.html.twig');
    }
    /**
     * @Route("/boucle")
     * 
     */
    public function boucle()
    {
        return $this->render('intro/boucle.html.twig',
                [
                    'log' => 'greg',
                    'user' => ['test1' => 'toto','test2' => 'tata','test3' => 'titi']
                ]
                );
    }
}
