<?php
namespace App\Users\Entity;
class User
{
    protected $id;
    protected $login;
    protected $mail;
    protected $password;

    public function __construct($id, $login, $mail, $password)
    {
        $this->id = $id;
        $this->login = $login;
        $this->mail = $mail;
        $this->password = $password;
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
        $array['mail'] = $this->mail;
        $array['password'] = $this->password;

        return $array;
    }
}