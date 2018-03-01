<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use function dump;

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
        return $this->render('intro/twig.html.twig',
                ['now' => new \DateTime()] /* le backslash pour chercher le datetime() a la racine des namespace / sinon il faut utiliser le use */
                );
    }
    
    /**
     * @Route("/request")
     * @param Request $request
     * @return Reponse
     */
    public function request(Request $request) /* le typage request permet d'instancier l'objet request avec la requete http*/
    {
        // $_GET['test'], null si $get n'existe pas au lieu d'une notif undifine
        dump($request->query->get('test'));
        dump($request->query->get('test', 'valeur optionnelle par defaut'));
        dump($request->query->all()); // //idem a var_dump($_GET)
      
        dump($request->getMethod());   //GET ou POST
        
        //isMethode vérifie si le getMethod est POST ou GET > si un formulaire à été  envoyé
        if($request->isMethod('POST')){
            dump($request->request->get('clic')); //récup ce qu'ily a dans le tableau post pour l'indice test
            dump($request->request->all()); //idem a var_dump($_POST)
        }
        dump($request->get('clic')); // récupère l'info du GET ou du POST à l'indice donné, mais on ne sais pas si c'est un post ou un get
        return $this->render('intro/request.html.twig'
               
                );
    }
    /**
     * @Route("/response")
     * @param Request $request
     * @return Reponse
     */
    public function response(Request $request) 
    {
        if($request->query->get('found') == 'no'){
            //pour envoyer une 404
            throw new NotFoundHttpException();
        }
        if($request->query->get('redirect') == 'intro'){
            //pour rediriger sur une nouvelle route
            return $this->redirectToRoute('intro'); //intro c'est le "name" de la route intrp
        }
        if($request->query->has('name')){ //équivalent au isset($_GET['name'])
            $name = $request->query->get('name');
            return $this->redirectToRoute('app_intro_hello', array('name'=>$name)); 
        }
    }
    /**
     * @Route("/session")
     * @param Request $request
     * @return Reponse
     */
    public function session(Request $request) 
    {
        $session = $request->getSession();
        $session->set('test', 'FOO'); //creer un indice 'test' dans $_SESSION avec la valeur FOO
        $session->set('bar', 'BAR');
        dump($session->get('test'));
        dump($session->all());
        $session->remove('bar');  // équivalemnt à unset($_SESSION['bar'])
        dump($session->all());
        
        if($request->query->get('redirect')=='flash'){
            //aoute un messageflash e type success
            $session->getFlashBag()->add('success','message de confirmation');
            return $this->redirectToRoute('app_intro_flash'); //intro c'est le "name" de la route intrp
        }
        
        return $this->render('intro/session.html.twig');
    }
    /**
     * @Route("/flash")
     */
    public function flash() {
        return $this->render('intro/flash.html.twig');
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
