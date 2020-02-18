<?php

namespace App\Pokemons\Entity;

class Pokemon
{
    protected $name;

    protected $urlImgBack;

    protected $urlImgFront;

    public function __construct($name, $urlImgBack, $urlImgFront)
    {
        $this->name = $name;
        $this->urlImgBack = $urlImgBack;
        $this->urlImgFront = $urlImgFront;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setUrlImgBack($urlImgBack)
    {
        $this->urlImgBack = $urlImgBack;
    }

    public function setUrlImgFront($urlImgFront)
    {
        $this->urlImgFront = $urlImgFront;
    }

    public function getName()
    {
        return $this->name;
    }
    public function getUrlImgBack()
    {
        return $this->urlImgBack;
    }
    public function getUrlImgFront()
    {
        return $this->urlImgFront;
    }

    public function toArray()
    {
        $array = array();
        $array['name'] = $this->name;
        $array['urlImgBack'] = $this->urlImgBack;
        $array['urlImgFront'] = $this->urlImgFront;

        return $array;
    }
}
