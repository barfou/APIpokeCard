<?php
namespace App\Users\Entity;
class User
{
    protected $id;
    protected $name;
    //protected $prenom;
    public function __construct($id, $name)//, $prenom)
    {
        $this->id = $id;
        //$this->prenom = $prenom;
        $this->nom = $name;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setNom($name)
    {
        $this->name = $name;
    }
    /*public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }*/
    public function getId()
    {
        return $this->id;
    }
    /*public function getPrenom()
    {
        return $this->prenom;
    }*/
    public function getNom()
    {
        return $this->name;
    }
    public function toArray()
    {
        $array = array();
        $array['id'] = $this->id;
        $array['name'] = $this->name;
        //$array['prenom'] = $this->prenom;
        return $array;
    }
}