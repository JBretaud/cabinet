<?php
class Med{
    
    private $idMedicament;
    private $nom;
    

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

    public function getIdMedicament(){
        return $this->idMedicament;
    }
    public function getNom(){
        return $this->nom;
    }


    //SETTERS

    public function setNom($nom){
        $this->nom = $nom;
    }

    public function setIdMedicament($idMedicament){
        $this->idMedicament = $idMedicament;
    }

}
?>