<?php

namespace App\Entity;

class Pokemon
{
    protected $id;

    protected $lib;

    protected $marque;

    protected $os;

    protected $user;

    public function __construct($id, $lib, $marque, $os, $user)
    {
        $this->id = $id;
        $this->lib = $lib;
        $this->marque = $marque;
        $this->os = $os;
        $this->user = $user;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setLib($lib)
    {
        $this->lib = $lib;
    }

    public function setMarque($marque)
    {
        $this->marque = $marque;
    }

    public function setOS($os)
    {
      $this->os = $os;
    }

    public function setUser($user)
    {
      $this->user = $user;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getLib()
    {
        return $this->lib;
    }
    public function getMarque()
    {
        return $this->marque;
    }

    public function getOs()
    {
        return $this->os;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function toArray()
    {
        $array = array();
        $array['id'] = $this->id;
        $array['lib'] = $this->lib;
        $array['marque'] = $this->marque;
        $array['os'] = $this->os;
        $array['userid'] = $this->userid;

        return $array;
    }
}
