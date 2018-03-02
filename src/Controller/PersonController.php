<?php

namespace App\Controller;

use App\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use function dump;

/**
 * @Route("/person") //définit toutes les routes avec la base /persone/autrerep
 */
class PersonController extends Controller
{
    /**
     * @Route("/list") // donne la chemin complet /person/list // si je met dans un @ Route("/") se sera le chemin par défaut si je tape juste dans l'url /person
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        //em pour entity manager 
        //nous renvoie l'entity manger qui est la class qui permet d'interagir avec la bdd
        
        $personRepository = $em->getRepository(Person::class); //toutes les class on un attribut static qui s'appel class -> il revoit le nom complet de la class en chaine de caractère donc :App\Entity\Person
                        //il récupère le repository de la class person
        
        //le repository permet d'interagir avec la bdd pour la table en question
        $persons = $personRepository->findAll(); //ici select * from person
        dump($persons);
        return $this->render('person/index.html.twig', [
           'persons' => $persons
        ]);
    }
    
     /**
     * @Route("/{id}", requirements={"id":"\d+"}) //l'id doit etre un nombre (\d+ en expression régulière qui veut dire un ou plusieurs chiffres)
     * @param int $id
     */
    public function detail($id)
    {
        
         $em = $this->getDoctrine()->getManager();
        $personRepository = $em->getRepository(Person::class);
        
        //find() renvoi l'objet person ou null sur la requete select * from person were id = x
        $person = $personRepository->find($id); //find uniquement sur un id
        dump($person);
        if(is_null($person)){
            throw new NotFoundHttpException;
        }
         return $this->render('person/detail.html.twig', [
           'person' => $person
        ]);
    }
    
    /**
     * @Route("/search")
     */
    public function searchByLastname(Request $request)
    {
        $person=null;
        $persons=null;
        
        if($request->isMethod('POST')){
            $em = $this->getDoctrine()->getManager();
            $personRepository = $em->getRepository(Person::class);
            $person = $personRepository->findOneBy(['email'=>$request->request->get('email')]); // récupère l'info email du post et l'envoie dans la requete
                    //findOnBy retourn 0 ou 1 résultatsinon erreur 
            $persons = $personRepository->findBy(['lastname'=>$request->request->get('lastname')]);
        }
       return $this->render('person/search.html.twig', [
          'person' => $person,
          'persons' => $persons,
        ]);
    }
}
