<?php
class User{
    private $login;
    private $pass;
    private $email;
    private $idUtilisateur;
    private $idTypeUtilisateur;
    private $idPatient;
    private $idPraticien;

    public function __construct(?array $attributes)
    {
        $this->hydrate($attributes);
    }

    public function hydrate($attributes){
        // print_r ($attributes);
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

    public function getLogin(){
        return $this->login;
    }
    public function getPass(){
        return $this->pass;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getIdTypeUtilisateur(){
        return $this->idTypeUtilisateur;
    }
    public function getIdUtilisateur(){
        return $this->idUtilisateur;
    }
    public function getIdPatient(){
        return $this->idPatient;
    }
    public function getIdPraticien(){
        return $this->idPraticien;
    }

    public function setLogin(?String $login){
        $this->login=$login;
    }
    public function setPass(?String $pass){
        $this->pass=$pass;
    }
    public function setEmail(?String $email){
        $this->email=$email;
    }
    public function setIdTypeUtilisateur(?int $idTypeUtilisateur){
        $this->idTypeUtilisateur=$idTypeUtilisateur;
    }
    public function setIdUtilisateur(?int $idUtilisateur){
        if(!empty($idUtilisateur)) $this->idUtilisateur=$idUtilisateur;
    }
    public function setIdPatient(?int $idPatient){
        $this->idPatient=$idPatient;
    }
    public function setIdPraticien(?int $idPraticien){
        $this->idPraticien=$idPraticien;
    }
}
?>