<?php
class ServiceExterne{
    private $idService;
    private $nom;
    private $email;
    private $type;


    public function __construct(?array $attributes)
    {
        $this->hydrate($attributes);
    }

    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value)
        {
            if(!empty($value)){
                // On récupère le nom du setter correspondant à l'attribut.
                $method = 'set'.ucfirst($key);
                // Si le setter correspondant existe.
                if (method_exists($this, $method))
                {
                // On appelle le setter.
                $this->$method($value);
                }
            }
        }
    }
    public function getIdService(){
        return $this->idService;
    }
    public function getNom(){
        return $this->nom;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getType(){
        return $this->type;
    }

    public function setIdService(?String $idService){
        $this->idService = $idService;
    }
    public function setNom(?String $nom){
        $this->nom = $nom;
    }
    public function setEmail(?String $email){
        $this->email = $email;
    }
    public function setType(?String $type){
        $this->type = $type;
    }

}