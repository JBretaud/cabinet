<?php
class Ordonnance{
    
    private $idPatient;
    private $idPraticien;
    private $idOrdonnance;
    private $lignes;
    

    public function __construct(?Array $properties){
        $this->hydrate($properties);
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

    // GETTERS

    public function getIdPatient(){
        return $this->idPatient;
    }
    public function getIdPraticien(){
        return $this->idPraticien;
    }
    public function getLignes(){
        return $this->lignes;
    }
    public function getIdOrdonnance(){
        return $this->idOrdonnance;
    }
    


    //SETTERS


    public function setIdOrdonnance(int $idOrdonnance){
        $this->idOrdonnance = $idOrdonnance;
    }
    public function setIdPatient(int $idPatient){
        $this->idPatient = $idPatient;
    }
    public function setIdPraticien(int $idPraticien){
        $this->idPraticien = $idPraticien;
    }
    public function setLignes(array $lignes){
        $this->lignes = $lignes;
    }

}
?>