<?php

class LigneOrdonnance{
    
    private $idLigne;
    private $idMedicament;
    private $posologie;
    private $idOrdonnance;
    

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

    public function getIdLigne(){
        return $this->idLigne;
    }
    public function getIdMedicament(){
        return $this->idMedicament;
    }
    public function getIdOrdonnance(){
        return $this->idOrdonnance;
    }
    public function getPosologie(){
        return $this->posologie;
    }
    


    //SETTERS


    public function setPosologie($posologie){
        $this->posologie = $posologie;
    }
    public function setIdLigne($idLigne){
        $this->idLigne = $idLigne;
    }
    public function setIdMedicament($idMedicament){
        $this->idMedicament = $idMedicament;
    }
    public function setIdOrdonnance($idOrdonnance){
        $this->idOrdonnance = $idOrdonnance;
    }

}
?>