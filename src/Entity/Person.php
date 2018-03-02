<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonRepository")
 */
//fait la relation entre class et les tables en bdd
class Person
{
    /**
     * @var int
     * 
     * @ORM\Id
     * @ORM\GeneratedValue //autoincrément
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @var string
     * @ORM\Column() //définit que cet attribut doit etre un champ dans la table > par défaut le champ est un varchar(255) NOT NULL
     */
    private $firstname;
    /**
     * @var string
     * @ORM\Column()
     */
    private $lastname;
    /**
     * @var string
     * @ORM\Column(unique=true) //précise que ce champ doit etre unique
     */
    private $email;
    /**
     * @var \Datetime
     * @ORM\Column(type="date") //précise que ce champ et de type date
     */
    private $birthdate;
    
    
    public function getId() {
        return $this->id;
    }

    public function getFirstname() {
        return $this->firstname;
    }

    public function getLastname() {
        return $this->lastname;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getBirthdate(): \Datetime {
        return $this->birthdate;
    }

    public function setFirstname($firstname) {
        $this->firstname = $firstname;
        return $this; //permet de chainer les appels de methodes grace à la case à cocher 'fluent'
    }

    public function setLastname($lastname) {
        $this->lastname = $lastname;
        return $this;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function setBirthdate(\Datetime $birthdate) {
        $this->birthdate = $birthdate;
        return $this;
    }


    public function getFullname() {
        return $this->firstname . ' '. $this->lastname;
    }

}
