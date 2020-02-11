<?php
namespace App\Users\Entity;
class User
{
    protected $id;
    protected $login;
    //protected $mail;
    //protected $password;

    public function __construct($id, $login)
    {
        $this->id = $id;
        $this->login = $login;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLogin()
    {
        return $this->name;
    }
    public function toArray()
    {
        $array = array();
        $array['id'] = $this->id;
        $array['login'] = $this->login;

        return $array;
    }
}