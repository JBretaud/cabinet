<?php
class Praticien{
    private $idPraticien;
    private $nom;
    private $prenom;
    private $email;
    private $idUtilisateur;
    private $cheminPhoto;

    public function __construct(?Array $attributes){
        $this->hydrate($attributes);
    }

    public function hydrate($attributes){
        foreach ($attributes as $key => $value)
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

    public function getNom(){
        return $this->nom;
    }
    public function getPrenom(){
        return $this->prenom;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getIdUtilisateur(){
        return $this->idUtilisateur;
    }
    public function getIdPraticien(){
        return $this->idPraticien;
    }
    public function getCheminPhoto(){
        return $this->cheminPhoto;
    }


    public function setNom($nom){
        $this->nom=$nom;
    }
    public function setPrenom($prenom){
        $this->prenom=$prenom;
    }
    public function setEmail($email){
        $this->email=$email;
    }
    public function setIdUtilisateur($idUtilisateur){
        $this->idUtilisateur=$idUtilisateur;
    }
    public function setCheminPhoto($cheminPhoto){
        $this->cheminPhoto=$cheminPhoto;
    }
    public function setIdPraticien($idPraticien){
        $this->idPraticien=$idPraticien;
    }
}